<?php use app\models\Tools;
      use app\models\User;
      use app\models\Genre;
      use app\models\Seance;
      use app\models\Movie;
      use app\models\Poster;
      use app\models\Trailer;
      use app\models\Country;
      use app\models\Director;
      use app\models\DirectorPicture;

$this->title = $director->name;
?>

<? if(User::isAdmin()){ ?>
<div class="toolbar admin-bar mb-5 anim-100">
  <a class="btn btn-primary" href="/director/edit?id=<?= $director->id ?>"><i class="fas fa-edit"></i> Edytuj reżysera</a>
</div>
<? } ?>

<div class="row">
  <div class="col-md-4">
    <img class="img-fluid director-picture" src="<?= DirectorPicture::getPictureUrl($director->picture) ?>" alt="<?= $director->name ?>">
  </div>
  <div class="col-12 col-md-7 offset-md-1">
    <div class="director-inside-title">
      <h1><?= $director->name ?></h1>
    </div>
    <div class="director-inside-country">
      Kraj pochodzenia: <?= Country::getNameById($director->birth_place) ?>
    </div>
    <div class="director-inside-country">
      Data urodzenia: <?= date("d-m-Y", strtotime($director->birth_date)) ?>
    </div>
    <div class="director-inside-description">
      <?= $director->description ? $director->description : "Dla wybranego reżysera nie została wprowadzona biografia." ?>
    </div>
  </div>
</div>

<div class="row mt-5">
  <? if($movies){ ?>
  <div class="col-12">
    <h3>Filmy wyreżyserowane przez <?= $director->name ?></h3>
  </div>
  <? } ?>
  <div class="slick-carousel-standard mb-5 anim-50">
    <? if($movies) foreach ($movies as $movie) { ?>
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
</div>
