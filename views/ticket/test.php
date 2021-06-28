<?

$DotpayId = Yii::$app->params['client_id'];
$DotpayPin = Yii::$app->params['client_pin'];;

$RedirectionMethod = "GET";
$autosubmit = false;

$ParametersArray = array(
    "id" => $DotpayId,
    "api_version" => "next",
    "amount" => "78.00",
    "currency" => "PLN",
    "description" => "Rezerwacja biletów #33",
    "url" => "https://prophet061.pl/ticket/test",
    "type" => "0",
    "urlc" => "https://prophet061.pl/ticket/urlc",
    "control" => "54f4g-dsgfdg-2342235",
    "firstname" => "Jan",
    "lastname" => "Nowak",
    "email" => "jan.nowak@example.com"
);

function GenerateChk($DotpayPin, $ParametersArray)
{
    ksort($ParametersArray);
    $paramList = implode(';', array_keys($ParametersArray));
    $ParametersArray['paramsList'] = $paramList;
    ksort($ParametersArray);
    $json = json_encode($ParametersArray, JSON_UNESCAPED_SLASHES);
    return hash_hmac('sha256', $json, $DotpayPin, false);
}

function GenerateChkDotpayRedirection($DotpayPin, $ParametersArray)
{

    $url = 'https://ssl.dotpay.pl/test_payment/?';
    foreach ($ParametersArray as $key => $value) {
      $url .= $key . '=' . rawurlencode($value) . '&';
    }
    $url .= 'chk=' . GenerateChk($DotpayPin, $ParametersArray);

    echo "<pre>";
    var_dump(urlencode($url));
    echo "</pre>";

    echo "<br>";
    echo "<br>";
    echo "<br>";

    echo "<pre>";
    print_r($url);
    echo "</pre>";

    echo "<br>";
    echo "<br>";
    echo "<br>";

    echo '<a href="' . $url . '">Link to Pay</a>';
}

GenerateChkDotpayRedirection($DotpayPin, $ParametersArray);

?>
