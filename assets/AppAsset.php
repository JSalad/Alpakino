<?php namespace app\assets;
      use yii\web\AssetBundle;

class AppAsset extends AssetBundle{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/libs/reset.css',
        'css/libs/bootstrap.css',
        'css/libs/slick.css',
        'css/libs/select2.css',
        'css/libs/pagination.css',
        'css/libs/datetimepicker.css',
        'css/typography.css',
        'css/site.css',
        'css/animations.css',
        'css/hall.css',
        'https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;700;900&display=swap',
    ];
    public $js = [
      '/js/libs/fontawesome.js',
      '/js/libs/bootstrap.js',
      '/js/libs/popper.js',
      '/js/libs/slick.js',
      '/js/libs/moment.js',
      '/js/libs/datetimepicker.js',
      '/js/libs/select2.js',
      '/js/libs/notify.js',
      '/js/ajax.js',
      '/js/main.js',
      'https://cdn.tiny.cloud/1/4cht1izuj6yfllkl4if84bp3rd7rmvagqtwmjb5rharin72k/tinymce/5/tinymce.min.js',
      'https://www.google.com/recaptcha/api.js?onload=captchaReady&render=explicit',
    ];
}
