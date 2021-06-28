<?
use app\models\Tools;
use app\models\User;

$slides = array(
  array("bg" => 'https://i.gadgets360cdn.com/large/godzilla_vs_kong_poster_crop_1611297219931.jpg', 'title' => "Slajd #1", "description" => "Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.", "href" => "#"),
  array("bg" => 'https://via.placeholder.com/1900x900', 'title' => "Slajd #2", "description" => "Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.", "href" => "#"),
  array("bg" => 'https://via.placeholder.com/1900x900', 'title' => "Slajd #3", "description" => "Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.", "href" => "#"),
  array("bg" => 'https://via.placeholder.com/1900x900', 'title' => "Slajd #4", "description" => "Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.", "href" => "#"),
  );

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
    <div class="carousel-item homepage-slider <?= $i == 0 ? "active" : "" ?>" style="background-image: url(<?= $s['bg'] ?>)">
      <div class="container">
        <div class="row h-100">
          <div class="col-12 col-md-6 homepage-slider-caption d-flex flex-column justify-content-end">
            <h5><?= $s['title'] ?></h5>
            <p class="d-none d-lg-block"><?= $s['description'] ?></p>
            <p class="d-block d-lg-none"><?= Tools::truncate($s['description'], 200) ?></p>
          </div>
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
