<?php

namespace app\controllers;

use Yii;
use yii\web\Response;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use app\models\User;
use app\models\Tools;
use app\models\Pagination;

class AdminController extends Controller{
    public function behaviors(){
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }
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

      $p = (new Pagination)->generatePagination(["total" => User::getUsers($p->records, $p->page, [], true)]);
      $users = User::getUsers($p->records, $p->page, []);


      return $this->render('index', ['users' => $users, 'p' => $p]);
    }
    public function actionCreate(){
      if(!User::isAdmin()) return $this->goHome();

      if (Yii::$app->request->isAjax) {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $d = Yii::$app->request->post();

        $user = User::createUser($d);

        return json_encode($user);

      } else {
        return $this->render('create');
      }
    }
    public function actionDelete(){
      if(!User::isAdmin()) return $this->goHome();

      if (Yii::$app->request->isAjax) {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $d = Yii::$app->request->post();

        $id = $d['id'];
        return json_encode(User::deleteUser($id) ? array('success' => true, 'id' => $id) : array('success' => false));

      } else {
        return $this->render('create');
      }
    }
    public function actionLogin(){
      if (Yii::$app->request->isAjax) {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $d = Yii::$app->request->post();

        $email = $d['email'];
        $password = $d['password'];

        $email_valid = Tools::validate($email, 'email');
        if(!$email || $email_valid['status'] == 'failed') return json_encode(array("success" => false, "message" => "Podany adres e-mail nie wydaje się być poprawny"));



        $identity = User::getByEmail($email);
        if(!$identity) return json_encode(array("success" => false, "message" => "Nie znaleziono użytkownika o wskazanym adresie e-mail."));


        $valid = $identity->validatePassword($password);
        if(!$valid) return json_encode(array("success" => false, "message" => "Podane hasło jest nieprawidłowe dla konta o wskazanym adresie e-mail."));



        return json_encode($valid && Yii::$app->user->login($identity) && User::updateLoginDetails() ? array("success" => true, "redirect" => "/admin/index") : array("success" => false, "message" => "Z przyczyn technicznych logowanie na konto jest niemożliwe"));
      } else {
        $u = User::getCurrentIdentity();
        if($u) return $this->redirect("index");

        return $this->render('login');
      }
    }
    public function actionLogout(){
      if(!User::isAdmin()) return $this->goHome();

      Yii::$app->user->logout();
      return $this->goHome();
    }
}
