<?php namespace app\models;
      use Yii;

class QRCode{
  public $base = "";

  public function __construct(){
    $this->base = "https://api.qrserver.com/v1/create-qr-code/?size=300x300&data=";
    // $img = file_get_contents($base.$data);
  }

  public function get($data){
    return $this->base.urlencode($data);
  }
}
