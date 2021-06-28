<?php namespace app\controllers;
      use Yii;
      use yii\web\Controller;
      use app\models\Hall;
      use app\models\User;
      use app\models\Tools;
      use app\models\Movie;
      use app\models\Seance;
      use app\models\Booking;
      use app\models\BookingSeat;
      use app\models\Slot;
      use app\models\DotPay;
      use app\models\AlpakinoMailer;


class TicketController extends Controller{
    public function actions(){
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }
    public function beforeAction($action){
      // Router::checkAccess($action);

      Yii::$app->getView()->registerJsFile(Yii::$app->request->BaseUrl . '/js/controllers/'.Yii::$app->controller->id.'.js', ['depends' => 'yii\web\JqueryAsset']);
      return true;
    }

    public function actionBuy(){
      if (Yii::$app->request->isAjax && false) {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $post = Yii::$app->request->post();
        $get = Yii::$app->request->get();


      } else {
        $post = Yii::$app->request->post();
        $get = Yii::$app->request->get();

        $id = $get['id'];

        $seance = Seance::getById($id);
        $movie = Movie::getById($seance->id_movie);
        $hall = Hall::getById($seance->id_hall);

        $pos_id = Yii::$app->params['pos_id'];

        return $this->render('buy', ['seance' => $seance, 'movie' => $movie, 'hall' => $hall, 'pos_id' => $pos_id]);
      }
    }
    public function actionValidatedata(){
      if (Yii::$app->request->isAjax) {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $post = Yii::$app->request->post();
        $get = Yii::$app->request->get();

        $fatal = false;
        $errors = [];

        $v = Tools::validate($post['first_name'], 'first_name', 3);
        if($v['status'] == "failed"){
          $fatal = true;
          $errors['first_name'] = "Podane imie jest nieprawidłowe";
        }

        $v = Tools::validate($post['last_name'], 'last_name', 3);
        if($v['status'] == "failed"){
          $fatal = true;
          $errors['last_name'] = "Podane nazwisko jest nieprawidłowe";
        }

        $v = Tools::validate($post['email'], 'email');
        if($v['status'] == "failed"){
          $fatal = true;
          $errors['email'] = "Podany e-mail jest nieprawidłowy";
        }

        return json_encode(!$fatal ?  array('success' => true) : array('success' => false, 'errors' => $errors));
      } else {
        return $this->redirect(['site/index']);
      }
    }
    public function actionBooking(){
      if (Yii::$app->request->isAjax) {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $post = Yii::$app->request->post();
        $get = Yii::$app->request->get();

        $id_seance = $post['id_seance'];
        $seance = Seance::getById($id_seance);

        $price = 0;
        $price_v = 0;
        $price_s = 0;
        $booking = Booking::addBooking($id_seance, $post);
        if($booking['success']) foreach ($post['seats'] as $v) {
          BookingSeat::addBookingSeat($booking['id'], $id_seance, $v);
          $s = Slot::getById($v);
          if($s->type == "seat"){
            $price_s += (float)$seance->price_standard;
            $price += (float)$seance->price_standard;
          }
          if($s->type == "vip"){
            $price_v += (float)$seance->price_vip;
            $price += (float)$seance->price_vip;
          }
        }

        $d = new DotPay();
        $url = $d->setParameters([
          'amount' => (string)$price,
          'description' => "Rezerwacja biletów #".$booking['id'],
          'firstname' => $post['first_name'],
          'control' => (string)$booking['id'],
          'lastname' => $post['last_name'],
          'email' => $post['email'],
          'expiration_date' => date("Y-m-d H:i:s", strtotime(date("Y-m-d H:i:s")." + 2 minute")),
        ])->createPayment();


        return json_encode($booking['success'] ? array('success' => true, 'url' => $url, 'price' => $price, 'price_standard' => $price_s, 'price_vip' => $price_v, 'id' => $booking['id']) : array('success' => false));
      } else {
        return $this->redirect(['site/index']);
      }
    }


    public function actionAfter(){
      $get = Yii::$app->request->get();
      $post = Yii::$app->request->post();
      $status = $get['status'];
      $errors = [
        "PAYMENT_EXPIRED" => "Czas przeznaczony na dokonanie płatności został wyczerpany.",
        "FAIL" => "Płatność została anulowana przez użytkownika",

      ];

      if($post['operation_status'] == "completed"){
        $booking_id = $post['control'];

        $b = Booking::getById($booking_id);
        if($b->payment_status == 2) return $this->render("success");

        $mail = (new AlpakinoMailer)->addReceiver($b->email)
                                    ->setSender('support@prophet061.pl', 'Alpakino')
                                    ->setSubject("Potwierdzenie rezerwacji biletów")
                                    ->setPattern("booking", ['id' => $b['id'], 'token' => $b['access_token']])
                                    ->send();

        Booking::markAsPaid($booking_id);
        AlpakinoMailer::sendBookingMail($booking_id);
      }



      if($status == "FAIL" || $post['operation_status'] == "rejected"){
        $booking_id = $post['control'];
        $delete = Booking::deleteBooking($booking_id);
        if($delete) BookingSeat::deleteSeatsForBooking($booking_id);

        return $this->render("canceled");
      } else if($status == "OK"){
        return $this->render("success");
      }


      if($get['error_code']){
        $error = $errors[$get['error_code']] ? $errors[$get['error_code']] : $get['error_code'];

        $booking_id = $post['control'];

        $delete = Booking::deleteBooking($booking_id);
        if($delete) BookingSeat::deleteSeatsForBooking($booking_id);

        return $this->render("failed", ['error' => $error]);
      }

      return $this->redirect(['site/index']);
    }
    public function actionCancel(){
      if (Yii::$app->request->isAjax) {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $post = Yii::$app->request->post();
        $booking_id = $post['id'];

        $delete = Booking::deleteBooking($booking_id);
        if($delete) BookingSeat::deleteSeatsForBooking($booking_id);

        return json_encode(array('success' => true));
      } else {

        return $this->redirect('seance/index');
      }
    }
    public function actionVerify(){
      $get = Yii::$app->request->get();

      $params = ['id' => $get['id'], 'access_token' => $get['token']];
      $b = Booking::getByParameters($params);


      return $b ? $this->render("valid", ['b' => $b]) : $this->render("not-valid");
    }
    public function actionEmbed(){
      $get = Yii::$app->request->get();
      $params = ['id' => $get['id'], 'access_token' => $get['token']];
      $b = Booking::getByParameters($params);

      $mail = (new AlpakinoMailer)->addReceiver($b->email)
                                  ->setSender('support@prophet061.pl', 'Alpakino')
                                  ->setSubject("Potwierdzenie rezerwacji biletów")
                                  ->setPattern("booking", ['id' => $b['id'], 'token' => $b['access_token']])
                                  ->showPreview();


      // return $b ? $this->render("valid", ['b' => $b]) : $this->render("not-valid");
    }
}
