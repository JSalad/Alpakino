<?php namespace app\models;
      use Yii;

class Recaptcha {
  public static function validate($code){
    $secret = Yii::$app->params['captcha_private'];
    $url = "https://www.google.com/recaptcha/api/siteverify?secret=".$secret."&response=".$code;
    $response = json_decode(file_get_contents($url));

    return $response && $response->success == true ? true : false;
  }
}
