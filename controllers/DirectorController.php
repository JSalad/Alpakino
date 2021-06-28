<?php namespace app\controllers;
      use Yii;
      use yii\web\Controller;
      use app\models\User;
      use app\models\Movie;
      use app\models\Tools;
      use app\models\Director;
      use app\models\Pagination;
      use app\models\DirectorPicture;


class DirectorController extends Controller{
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

      $p = (new Pagination)->generatePagination(["total" => Director::getDirectors($p->records, $p->page, [], true)]);
      $directors = Director::getDirectors($p->records, $p->page, []);


      return $this->render('index', ['directors' => $directors, 'p' => $p]);
    }
    public function actionDetails(){
      $d = Yii::$app->request->get();
      $id = $d['id'];

      $director = Director::getByid($id);
      $movies = Movie::getByDirectorId($id);

      return $this->render('details', ['director' => $director, 'movies' => $movies]);
    }

    // public function actionImport(){
    //   $abc = ["a", "b", "c", "d", "e", "f", "g", "h", "i", "j", "k", "l", "ł", "m", "n", "o", "p", "r", "s", "ś", "t", "u", "v", "w", "x", "y", "z", "ź", "ż", "#"];
    //   $get = Yii::$app->request->get();
    //   $curr = $get['curr'] ? $get['curr'] : 0;
    //   $url = "https://multikino.pl/rezyserzy/filter/".strtolower($abc[$curr]);
    //
    //   $dom = new \DOMDocument('1.0');
    //   @$dom->loadHTMLFile($url);
    //
    //   $nodes = $dom->getElementsByTagName("li");
    //   if($nodes) foreach ($nodes as $element){
    //     $classy = $element->getAttribute("class");
    //     if (strpos($classy, "ml-columns__item") !== false){
    //       $fullname = $element->textContent;
    //       $d = explode(" ", trim($fullname));
    //       $data = array('first_name' => $d[0], 'last_name' => $d[1], 'birth_place' => '1', 'birth_date' => '1970-06-11', 'picture' => 0);
    //       Director::addDirector($data);
    //       // var_dump($data);
    //       // die();
    //     }
    //   }
    //
    //   if($abc[$curr+1]){
    //     echo "<script>setTimeout(function(){window.location = '/director/import?curr=".($curr+1)."'}, 5000)</script>";
    //   } else {
    //     echo "Konieeec";
    //   }
    //
    //   // $classname = "class1";
    //   // $domdocument = new \DOMDocument();
    //   // $domdocument->loadHTML(file_get_contents($url));
    //   // $a = new DOMXPath($domdocument);
    //   // $directors = $a->query("//*[contains(concat(' ', normalize-space(@class), ' '), ' '$classname' ')]");
    //   // print_r($directors);
    //
    //
    //   die();
    // }

    public function actionCreate(){
      if(!User::isAdmin()) return $this->goHome();

      if (Yii::$app->request->isAjax) {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $post = Yii::$app->request->post();
        $get = Yii::$app->request->post();

        $result = Director::addDirector($post);

        return json_encode($result);
      } else {
        return $this->render('create');
      }
    }
    public function actionEdit(){
      if(!User::isAdmin()) return $this->goHome();

      if (Yii::$app->request->isAjax) {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $post = Yii::$app->request->post();
        $get = Yii::$app->request->post();

        $result = Director::updateDirector($post['id'], $post);

        return json_encode($result);
      } else {
        $d = Yii::$app->request->get();
        $id = $d['id'];

        $director = Director::getById($id);


        return $this->render('edit', ['director' => $director]);
      }
    }
    public function actionDelete(){
      if(!User::isAdmin()) return $this->goHome();

      if (Yii::$app->request->isAjax) {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $post = Yii::$app->request->post();
        $get = Yii::$app->request->post();

        $result = Director::deleteDirector($post['id']);

        return json_encode($result);
      } else {
        return $this->redirect(['site/index']);
      }
    }

    public function actionPicture(){
      if(!User::isAdmin()) return $this->goHome();

      if (Yii::$app->request->isAjax) {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $post = Yii::$app->request->post();
        $get = Yii::$app->request->post();

        $src = $post['src'];
        $name = $post['name'];

        $r = DirectorPicture::addDirectorPicture($name, $src);

        return json_encode($r);
      } else {
        return $this->redirect(['site/index']);
      }
    }
    public function actionPicturedetails(){
      if(!User::isAdmin()) return $this->goHome();

      if (Yii::$app->request->isAjax) {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $post = Yii::$app->request->post();
        $get = Yii::$app->request->post();

        $requested = $post['id'];
        $poster = DirectorPicture::getById($requested);

        return json_encode($poster);
      } else {
        return $this->redirect(['site/index']);
      }
    }

}
