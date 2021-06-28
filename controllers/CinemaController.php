<?php

namespace app\controllers;

use Yii;
use yii\web\Response;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use app\models\Tools;
use app\models\AlpakinoMailer;


class CinemaController extends Controller{
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
      return $this->redirect(['site/index']);
    }

    public function actionContact(){
      if (Yii::$app->request->isAjax) {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $d = Yii::$app->request->post();

        $fatal = false;
        $errors = [];

        $v = Tools::validate($d['first_name'], 'first_name', 3);
        if($v['status'] == "failed"){
          $fatal = true;
          $errors['first_name'] = "Podane imię jest nieprawidłowe";
        }
        $v = Tools::validate($d['last_name'], 'last_name', 3);
        if($v['status'] == "failed"){
          $fatal = true;
          $errors['last_name'] = "Podane nazwisko jest nieprawidłowe";
        }
        $v = Tools::validate($d['email'], 'email');
        if($v['status'] == "failed"){
          $fatal = true;
          $errors['email'] = "Podany email jest nieprawidłowy";
        }
        $v = Tools::validate($d['subject'], 'name', 3);
        if($v['status'] == "failed"){
          $fatal = true;
          $errors['subject'] = "Podany temat jest nieprawidłowy";
        }
        if(strlen($d['content']) < 10){
          $fatal = true;
          $errors['content'] = "Podana treść jest nieprawidłowa";
        }

        if(!$fatal) $mail = (new AlpakinoMailer)->addReceiver("xn4bmype5a@gmail.com")
                                    ->setSender('support@prophet061.pl', 'Alpakino')
                                    ->setSubject("Kontakt ze strony - ".$d['subject'])
                                    ->setPattern("contact", ['name' => ($d['first_name']." ".$d['last_name']), 'email' => $d['email'], 'content' => $d['content']])
                                    ->send();


        return json_encode(!$fatal && $mail ? array('success' => true, 'message' => "Wiadomość została pomyślnie wysłana") : array('success' => false, 'errors' => $errors));
      } else {

        return $this->render('contact');
      }
    }
    public function actionPrivacy(){
      return $this->render('privacy');
    }
}
