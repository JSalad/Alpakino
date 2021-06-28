<?php namespace app\controllers;
      use Yii;
      use yii\web\Controller;
      use app\models\User;
      use app\models\Tools;
      use app\models\Poster;
      use app\models\Pagination;


class PosterController extends Controller{
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

      $p = (new Pagination)->generatePagination(["total" => Poster::getPosters($p->records, $p->page, [], true)]);
      $posters = Poster::getPosters($p->records, $p->page, []);


      return $this->render('index', ['posters' => $posters, 'p' => $p]);
    }

    // public function actionCreate(){
    //   if(!User::isAdmin()) return $this->goHome();
    //
    //   if (Yii::$app->request->isAjax) {
    //     \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
    //     $post = Yii::$app->request->post();
    //     $get = Yii::$app->request->get();
    //
    //     $result = Director::addDirector($post);
    //
    //     return json_encode($result);
    //   } else {
    //     return $this->render('create');
    //   }
    // }
    // public function actionEdit(){
    //   if(!User::isAdmin()) return $this->goHome();
    //
    //   if (Yii::$app->request->isAjax) {
    //     \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
    //     $post = Yii::$app->request->post();
    //     $get = Yii::$app->request->get();
    //
    //     $result = Director::updateDirector($post['id'], $post);
    //
    //     return json_encode($result);
    //   } else {
    //     $d = Yii::$app->request->get();
    //     $id = $d['id'];
    //
    //     $director = Director::getById($id);
    //
    //
    //     return $this->render('edit', ['director' => $director]);
    //   }
    // }
    public function actionDelete(){
      if(!User::isAdmin()) return $this->goHome();

      if (Yii::$app->request->isAjax) {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $post = Yii::$app->request->post();
        $get = Yii::$app->request->get();

        $result = Poster::deletePoster($post['id']);

        return json_encode($result);
      } else {
        return $this->redirect(['site/index']);
      }
    }
}
