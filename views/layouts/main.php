<?php use yii\helpers\Html;
      use app\assets\AppAsset;

AppAsset::register($this);
$this->beginPage() ?>


<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?> <?= $this->title ? "|" : "" ?> ALPAKINO - Rozrywka na pełnej...</title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<? include("header.php") ?>
<div class="container mt-5" id="primary-container">
  <?
  $action = Yii::$app->controller->action->id;
  $controller = Yii::$app->controller->id;

  $disabled = ["ticket" => true, "cinema" => true, "admin" => true];

  if($this->title && $this->title != "Not Found (#404)" && $action != "details" && !$disabled[$controller]){ ?>
  <div class="px-3 mb-5 anim-50">
    <h2 class="cl-color"><?= $this->title ?></h2>
  </div>
  <? } ?>
  <div class="anim-100">
    <?= $content ?>
  </div>
</div>
<? $this->title != "Not Found (#404)" && $controller != "ticket" ? include("footer.php") : "" ?>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
