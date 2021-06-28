<?php namespace app\controllers;
      use Yii;
      use yii\web\Controller;
      use app\models\User;
      use app\models\Movie;

class SiteController extends Controller{
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
        $movies = Movie::getRandomMovies(5);
        $latest_movies = Movie::getMovies(20, 1, [], false);


        return $this->render('index', ['movies' => $movies, 'latest_movies' => $latest_movies]);
    }

    // public function actionLogout(){
    //     Yii::$app->user->logout();
    //     return $this->goHome();
    // }
}
