<?php namespace app\controllers;
      use Yii;
      use yii\web\Controller;
      use app\models\User;
      use app\models\Slot;
      use app\models\Hall;
      use app\models\Tools;
      use app\models\Pagination;


class HallController extends Controller{
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

    public function actionIndex(){
      if(!User::isAdmin()) return $this->goHome();

      $p = (new Pagination)->generatePagination(["total" => Hall::getHalls($p->records, $p->page, [], true)]);
      $halls = Hall::getHalls($p->records, $p->page, []);


      return $this->render('index', ['halls' => $halls, 'p' => $p]);
    }

    public function actionCreate(){
      if(!User::isAdmin()) return $this->goHome();


      if (Yii::$app->request->isAjax) {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $post = Yii::$app->request->post();
        $get = Yii::$app->request->post();

        $fatal = false;
        $errors = [];

        $hall = Hall::addHall($post);
        if(!$hall['success']){
          $errors = Tools::merge([$errors, $hall['errors']]);
          $fatal = true;
        }

        $added = [];
        $slots_total = 0;
        $slots_success = 0;
        if(!$fatal) foreach ($post['additional'] as $s) {
            $slots_total++;
            $slot = Slot::addSlot($hall['hall']->id, $s['type'], $s['row'], $s['col']);
            if($slot['success']){
              $added[] = $slot['id'];
              $slots_success++;
            }
          }

        if($slots_total != $slots_success) foreach ($added as $v) Slots::deleteSlot($v);


        return json_encode($hall);
      } else {
        return $this->render('create');
      }
    }
    public function actionDelete(){
      if(!User::isAdmin()) return $this->goHome();

      if (Yii::$app->request->isAjax) {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $post = Yii::$app->request->post();
        $get = Yii::$app->request->post();

        $result = Hall::deleteHall($post['id']);

        return json_encode($result);
      } else {
        return $this->redirect(['site/index']);
      }
    }
}
