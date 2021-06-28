<?php

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'components' => [
        'request' => [
            'cookieValidationKey' => 'sdknfklsajdfhsaklJ;DFHWAeiufhwasiudkljfhasdkljfh',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'urlManager' => [
        	'class' => 'yii\web\UrlManager',
        	'showScriptName' => false,
        	'enablePrettyUrl' => true,
        	'rules' => array(),
        ],
        'assetManager' => [
            'appendTimestamp' => true,
            'bundles' => [
                'yii\bootstrap\BootstrapAsset' => [
                    'css' => [],
                ],
                'yii\bootstrap\BootstrapPluginAsset' => [
                    'js'=>[]
                ],
                'yii\web\JqueryAsset' => [
                    'js'=>['/js/libs/jquery.js']
                ],
            ],
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
          'messageConfig' => [
              'charset' => 'UTF-8',
              'from' => ['support@prophet061.pl' => "Alpakino"],
          ],
          'useFileTransport' => false,
          'transport' => [
              'class' => 'Swift_SmtpTransport',
              'host' => 'serwer2077031.home.pl',
              'username' => 'support@prophet061.pl',
              'password' => 'K5uL3GQJ',
              'port' => '465',
              'encryption' => 'SSL',
          ],
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=localhost;dbname=33700168_projekt',
            'username' => '33700168_projekt',
            'password' => '',
            'charset' => 'utf8',
        ],
    ],
    'params' => [
        'domain' => $_SERVER['SERVER_NAME'],
        'email' => 'support@'.$_SERVER['SERVER_NAME'],
        'name' => 'ALPAKINO',
        'client_id' => '785929',
        'client_pin' => 'MPGd3OfEYN6xhdML98tmZXyhSCh12Afz',
        'captcha_public' => '6Ld5zlgbAAAAAGCxTzM5c40rHdni0VULzEA3On-N',
        'captcha_private' => '6Ld5zlgbAAAAABrmHwDYod1rcNpQak18UPH276JQ',
    ],
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        'allowedIPs' => ['127.0.0.1', '::1'],
    ];
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        'allowedIPs' => ['127.0.0.1', '::1'],
    ];
}

return $config;
