<?php namespace app\models;
      use Yii;
      use app\models\QRCode;


class AlpakinoMailer{
  public $content = "";
  public $embed = "";

  public $mailer = false;

  public function __construct(){
    $this->mailer = Yii::$app->mailer->compose();
    $this->mailer->setSubject("Wiadomość z systemu | Alpakino");

  }
  public function setSubject($subject){
    $this->mailer->setSubject($subject);
    return $this;
  }
  public function addReceiver($email){
    $this->mailer->setTo($email);
    return $this;
  }
  public function setSender($email, $nicename){
    $this->mailer->setFrom([$email => $nicename]);
    return $this;
  }
  public function setPattern($pattern, $data){
    $dir = dirname(getcwd())."/views/mails/";
    $this->content = file_get_contents($dir."".$pattern.".php");

    if($pattern == "booking"){
      $s = $_SERVER;
      $once = true;
      $url = ($s['HTTPS'] == "on" ? "https://" : "http://").$s['HTTP_HOST']."/ticket/verify?";
      if($data) foreach ($data as $k => $v) {
        $url.= !$once ? "&".$k."=".$v : $k."=".$v;
        $once = false;
      }
      $qr = (new QRCode)->get($url);
      $this->content = str_replace('<div class="qr"></div>', '<div class="qr" style="margin: 0 auto; width: fit-content; width: -moz-fit-content"><img src="'.$qr.'" width="250px" height="250px"></img></div>', $this->content);
    } else if ($pattern == "contact") {

      $this->content = str_replace('<b class="name"></b>', '<b class="name">'.$data['name'].'</b>', $this->content);
      $this->content = str_replace('<div content></div>', '<div style="text-align: center; padding: 0 15px">'.$data['content'].'</div>', $this->content);
      $this->content = str_replace('<a reply></a>', '<a href="mailto:'.$data['email'].'">Kliknij aby odpowiedzieć</a>', $this->content);
    }

    $this->mailer->setHtmlBody($this->content);
    return $this;
  }
  public function showPreview(){
    echo $this->content;
    die();
  }
  public function send(){
    return $this->mailer->send();
  }
}
