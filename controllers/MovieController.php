<?php namespace app\controllers;
      use Yii;
      use yii\web\Controller;
      use app\models\User;
      use app\models\Movie;
      use app\models\Tools;
      use app\models\Review;
      use app\models\Poster;
      use app\models\Trailer;
      use app\models\Rating;
      use app\models\Pagination;


class MovieController extends Controller{
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
      $p = (new Pagination)->generatePagination(["total" => Movie::getMovies($p->records, $p->page, [], true)]);
      $movies = Movie::getMovies($p->records, $p->page, []);


      return $this->render('index', ['movies' => $movies, 'p' => $p]);
    }
    public function actionDetails(){
      $d = Yii::$app->request->get();
      $id = $d['id'];

      $movie = Movie::getById($id);
      $trailers = Trailer::getMovieTrailers($id);
      $rating = Rating::getAverageForMovie($id);
      $reviews = Review::getReviews(10, 1, ['id_movie' => $id], false);

      return $this->render('details', ['movie' => $movie, 'trailers' => $trailers, 'rating' => $rating, 'reviews' => $reviews]);
    }
    public function actionCreate(){
      if(!User::isAdmin()) return $this->goHome();

      if (Yii::$app->request->isAjax) {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $post = Yii::$app->request->post();
        $get = Yii::$app->request->post();

        $result = Movie::addMovie($post);

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

        $result = Movie::updateMovie($post['id'], $post);

        return json_encode($result);
      } else {
        $d = Yii::$app->request->get();
        $id = $d['id'];

        $movie = Movie::getById($id);


        return $this->render('edit', ['movie' => $movie]);
      }
    }
    public function actionDelete(){
      if(!User::isAdmin()) return $this->goHome();

      if (Yii::$app->request->isAjax) {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $post = Yii::$app->request->post();
        $get = Yii::$app->request->post();

        $result = Movie::deleteMovie($post['id']);

        return json_encode($result);
      } else {
        return $this->redirect(['site/index']);
      }
    }

    public function actionRate(){
      if (Yii::$app->request->isAjax) {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $post = Yii::$app->request->post();
        $get = Yii::$app->request->post();

        if(Rating::getUserRatingForMovie($post['id'])){
          $r = Rating::updateRating($post['id'], $post['value']);
        } else {
          $r = Rating::addRating($post['id'], $post['value']);
        }

        $r['recalculated'] = Rating::getAverageForMovie($post['id']);

        return json_encode($r);
      } else {
        return $this->redirect(['site/index']);
      }
    }
    public function actionPoster(){
      if(!User::isAdmin()) return $this->goHome();

      if (Yii::$app->request->isAjax) {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $post = Yii::$app->request->post();
        $get = Yii::$app->request->post();

        $src = $post['src'];
        $name = $post['name'];

        $r = Poster::addPoster($name, $src);

        return json_encode($r);
      } else {
        return $this->redirect(['site/index']);
      }
    }
    public function actionPosterdetails(){
      if (Yii::$app->request->isAjax) {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $post = Yii::$app->request->post();
        $get = Yii::$app->request->post();

        $requested = $post['id'];
        $poster = Poster::getById($requested);

        return json_encode($poster);
      } else {
        return $this->redirect(['site/index']);
      }
    }

}
