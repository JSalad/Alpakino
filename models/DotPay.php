<?php namespace app\models;
      use Yii;

class DotPay {
  public $id = false;
  public $pin = false;

  public $parameters = array(
      "id" => 0,
      "api_version" => "next",
      "amount" => "78.00",
      "currency" => "PLN",
      "description" => "Rezerwacja biletów #33",
      "url" => "https://prophet061.pl/ticket/after",
      "type" => "0",
      "urlc" => "https://prophet061.pl/ticket/after",
      "control" => "",
      "firstname" => "Jan",
      "lastname" => "Nowak",
      "email" => "jan.nowak@example.com"
  );


  public function __construct(){
    $this->id = Yii::$app->params['client_id'];
    $this->pin = Yii::$app->params['client_pin'];
    $this->parameters['id'] = Yii::$app->params['client_id'];
  }

  public function GenerateChk(){
    ksort($this->parameters);
    $this->parameters['paramsList'] = implode(';', array_keys($this->parameters));

    ksort($this->parameters);
    $json = json_encode($this->parameters, JSON_UNESCAPED_SLASHES);

    return hash_hmac('sha256', $json, $this->pin, false);
  }

  public function setParameters($data){
    if($data) foreach ($data as $k => $v) {
      // echo $k." => ".$v;
      // echo "<br>";
      $this->parameters[$k] = $v;
    }

    return $this;
  }

  public function createPayment(){
    $url = 'https://ssl.dotpay.pl/test_payment/?';
    foreach ($this->parameters as $key => $value) {
      $url .= $key . '=' . rawurlencode($value) . '&';
    }
    $url .= 'chk=' . $this->GenerateChk();

    return urlencode($url);
  }
}
