<?
use app\models\Tools;
use app\models\User;



?>


<div id="header-slider" class="carousel slide <?= Yii::$app->controller->id != "site" || Yii::$app->controller->action->id != "index" ? "d-none" : " " ?> " data-bs-ride="carousel">
  <div class="carousel-indicators">
    <div class="container d-flex justify-content-end" style="padding: 0 3%;">
      <? $i = 0; if(count($slides) > 1) foreach ($slides as $s) { ?>
        <button type="button" data-bs-target="#slide_<?= $i ?>" data-bs-slide-to="<?= $i ?>" class="<?= $i == 0 ? "active" : "" ?>" aria-current="<?= $i == 0 ? "true" : "false" ?>"></button>
        <? $i++; } ?>
    </div>
  </div>
  <div class="carousel-inner">
    <? $i = 0; foreach ($slides as $s) { ?>
    <div class="carousel-item <?= $i == 0 ? "active" : "" ?>" style="background-image: url(<?= $s['bg'] ?>)">
      <div class="container">
        <div class="carousel-caption d-none d-md-block px-3">
          <h5><?= $s['title'] ?></h5>
          <p class="d-none d-lg-block"><?= $s['description'] ?></p>
          <p class="d-block d-lg-none"><?= Tools::truncate($s['description'], 200) ?></p>
        </div>
      </div>
    </div>
    <? $i++; } ?>
  </div>
  <button class="carousel-control-prev" type="button" data-bs-target="#header-slider" data-bs-slide="prev">
    <i class="fas fa-chevron-left"></i>
  </button>
  <button class="carousel-control-next" type="button" data-bs-target="#header-slider" data-bs-slide="next">
    <i class="fas fa-chevron-right"></i>
  </button>
</div>
