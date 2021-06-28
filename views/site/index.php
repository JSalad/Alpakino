<?php

/* @var $this yii\web\View */

use app\models\Tools;
use app\models\Genre;
use app\models\Poster;
// use app\models\Tools;
?>

<div class="px-3">
  <h3>Ostatnie premiery:</h3>
</div>
<div class="slick-carousel-standard mb-5">
  <? if($latest_movies) foreach ($latest_movies as $movie) { ?>
    <a class="movie-tile" href="/movie/details?id=<?= $movie->id ?>" style="display: none">
      <img class="img-fluid" src="<?= Poster::getPosterUrl($movie->poster_url) ?>" alt="<?= $movie->title ?>">
      <p class="genre"><?= Genre::getNameById($movie->genre) ?></p>
      <div class="movie-tile-details">
        <h4><?= $movie->title ?></h4>
        <div class="description">
          <?= $movie->description ?>
        </div>
      </div>
    </a>
  <? } ?>
</div>

<div class="px-3">
  <h3>Polecane filmy:</h3>
</div>

<? if($movies) foreach ($movies as $movie) { ?>
  <div class="movie-review container mb-5">
    <div class="row">
      <a class="col-5 col-sm-2 px-0" href="/movie/details?id=<?= $movie->id ?>">
        <img class="img-fluid" src="<?= Poster::getPosterUrl($movie->poster_url) ?>" alt="<?= $movie->title ?>">
      </a>
      <div class="col-7 col-sm-9">
        <a class="movie-title" href="/movie/details?id=<?= $movie->id ?>">
          <h2><?= $movie->title ?></h2>
        </a>
        <div class="movie-details">
          <div class="movie-properties">
            <p class="mb-1"><?= Genre::getNameById($movie->genre) ?></p><p class="seperator d-none d-sm-inline"> | </p><p class="mb-1"><?= Tools::getRequiredAgeText($movie->required_age) ?></p><p class="seperator d-none d-sm-inline"> | </p><p class="mb-1"><?= $movie->duration ?> minut</p>
          </div>
        </div>
        <div class="movie-description d-none d-md-block">
          <?= $movie->description ?>
        </div>
      </div>
    </div>
  </div>
<? } ?>
