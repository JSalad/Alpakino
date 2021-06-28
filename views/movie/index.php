<?php use app\models\Tools;
      use app\models\Genre;
      use app\models\User;
      use app\models\Rating;
      use app\models\Poster;

$this->title = 'Premiery filmowe';
?>
<? if(User::isAdmin()){ ?>
<div class="toolbar admin-bar mb-5">
  <a class="btn btn-primary" href="/movie/create"><i class="fas fa-plus"></i> Dodaj film</a>
</div>
<? } ?>

<div class="mb-5">
  <? if($movies) foreach ($movies as $movie) { ?>
    <div class="movie-review container mb-5" id="movie_<?= $movie->id ?>">
      <div class="row">
        <a class="col-5 col-sm-4 col-md-2" href="/movie/details?id=<?= $movie->id ?>">
          <img class="img-fluid" src="<?= Poster::getPosterUrl($movie->poster_url) ?>" alt="<?= $movie->title ?>">
        </a>
        <div class="col-7 col-sm-8 col-md-9 offset-md-1">
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
</div>
<div class="">
  <? $p->displayPagination() ?>
</div>
