<?php namespace app\models;
      use Yii;

class Tools{
  public static function generateRandomString($length = 32) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) $randomString .= $characters[rand(0, $charactersLength - 1)];
    return $randomString;
  }
  public static function formatMoney($money){
    return number_format($money, 2)." zł";
  }
  public static function truncate($string, $length, $dots = "..."){
    return (strlen($string) > $length) ? substr($string, 0, $length - strlen($dots)) . $dots : $string;
  }
  public static function getRequiredAgeText($age){
    if(!$age || $age === 0) return "Bez ograniczeń wiekowych";

    return "Od lat ".$age;
  }
  public static function merge($arrays = []){
    $return = [];
    if($arrays) foreach ($arrays as $a) {
      if($a) foreach ($a as $k => $v) $return[$k] = $v;
    }

    return $return;
  }
  public static function sanitize($text){
    $text = strip_tags($text);
    $text = htmlspecialchars($text);
    $text = trim($text);
    $text = addslashes($text);
    return $text;
  }
  public static function getDayOfWeek($day){
    $days = array(1 => "Poniedziałek", 2 => 'Wtorek', 3 => "Środa", 4 => "Czwartek", 5 => "Piątek", 6 => "Sobota", 0 => "Niedziela");

    return $days[$day];
  }
  public static function validate($text, $type, $min = false, $max = false){
    $result = array('status' => 'success');

    if($min != false && strlen($text) < $min ) $result = array('status' => 'failed');
    if($max != false && strlen($text) > $max ) $result = array('status' => 'failed');

    switch ($type) {
      case 'url':
        $test = filter_var($text, FILTER_VALIDATE_URL);
        if(!$test) $result =  array('status' => 'failed');
        break;

      case 'password':
        $uppercase = preg_match('/[A-ZĘÓĄŚŁŻŹĆŃ]/', $text);
        $lowercase = preg_match('/[a-zęóąśłżźćń]/', $text);
        $number    = preg_match('/[0-9]/', $text);
        if(!$uppercase)       $result =  array('status' => 'failed');
        if(!$lowercase)       $result =  array('status' => 'failed');
        if(!$number)          $result =  array('status' => 'failed');
        if(strlen($text) < 8) $result =  array('status' => 'failed');
        break;

      case 'date':
        $date = explode("-", $text);
        $test = checkdate((int)$date[1], (int)$date[2], (int)$date[0]);
        if(!$test) $result =  array('status' => 'failed');
        break;

      case 'time':
        $test = preg_match('/^(?:2[0-3]|[01][0-9]):[0-5][0-9]$/', $text);
        if(!$test) $result =  array('status' => 'failed');
        break;

      case 'email':
        $test = filter_var($text, FILTER_VALIDATE_EMAIL);
        if(!$test) $result =  array('status' => 'failed');
        break;

      case 'mobile':
        $test = preg_match('/[+48] [0-9]{3} [0-9]{3} [0-9]{3}/', $text);
        if(!$test) $result =  array('status' => 'failed');
        break;

      case 'zipcode':
        $test = preg_match('/[0-9]{2}[-]{1}[0-9]{3}/', $text);
        if(!$test) $result =  array('status' => 'failed');
        break;

      case 'city':
        $test = preg_match('/[^a-zA-ZęóąśłżźćńĘÓĄŚŁŻŹĆŃ\s\-]/', $text);
        if($test && strlen($test) > 0) $result =  array('status' => 'failed');
        break;

      case 'street':
        $test = preg_match('/[^a-zA-Z0-9ęóąśłżźćńĘÓĄŚŁŻŹĆŃ\s\-.\/]/', $text);
        if($test && strlen($test) > 0) $result =  array('status' => 'failed');
        break;

      case 'name':
        $test = preg_match('/[^:#"\',0-9&!a-zA-Z–-ęóąśłżźćńĘÓĄŚŁŻŹĆŃ\s\-.]/', $text);
        if($test && strlen($test) > 0) $result =  array('status' => 'failed');
        break;

      case 'first_name':
        $test = preg_match('/[^a-zA-ZęóąśłżźćńĘÓĄŚŁŻŹĆŃ\s\-]/', $text);
        if($test && strlen($test) > 0) $result =  array('status' => 'failed');
        break;

      case 'last_name':
        $test = preg_match('/[^a-zA-ZęóąśłżźćńĘÓĄŁŚŻŹĆŃ\s\-]/', $text);
        if($test && strlen($test) > 0) $result = array('status' => 'failed');
        break;

      case 'number':
        $test = is_numeric($text);
        if(!$test) $result = array('status' => 'failed');
        break;
    }


    return $result;
  }
}
