<?php use app\models\Tools;
      use app\models\Genre;
      use app\models\User;
      use app\models\Movie;
      use app\models\Seance;
      use app\models\Poster;

$this->title = 'Repertuar filmów';
?>
<? if(User::isAdmin()){ ?>
<div class="toolbar admin-bar mb-5">
  <a class="btn btn-primary" href="/seance/create"><i class="fas fa-plus"></i> Dodaj seans</a>
</div>
<? } ?>

<div class="mb-5">
  <? if($seances) foreach ($seances as $seance) {
    $movie = Movie::getById($seance->id_movie) ?>
    <div class="movie-review container mb-5" id="movie_<?= $movie->id ?>">
      <div class="row">
        <div class="col-12 d-sm-none">
          <h2><?= $movie->title ?></h2>
        </div>
        <div class="col-12 col-sm-4 col-md-3 col-lg-3 seance-poster">
          <img class="img-fluid" src="<?= Poster::getPosterUrl($movie->poster_url) ?>" alt="<?= $movie->title ?>">

          <div class="seances-vertical d-sm-none">
            <? $seances = Seance::getSeancesForMovie($movie->id);
            if($seances) foreach ($seances as $s) { ?>
              <div class="seanse-tile" seance-id="<?= $s->id?>">
                <a href="/ticket/buy?id=<?=$s->id?>">
                  <div class="seanse-time">
                    <?= date("H:i", strtotime($s['show_date'])) ?>
                  </div>
                  <div class="seanse-type">
                    <?= Movie::getType($s->projection_type) ?>
                  </div>
                  <div class="seanse-date">
                    <?= date("d.m ", strtotime($s['show_date'])) ?><br>
                    <?= Tools::getDayOfWeek(date("w", strtotime($s['show_date']))) ?>
                  </div>
                  <i class="fas fa-ticket-alt" aria-hidden="true"></i>
                </a>
                <? if(User::isAdmin()) { ?>
                <div class="buttons">
                  <i class="fas fa-edit" onclick="window.location = '/seance/edit?id=<?=$s->id?>';"></i>
                  <i class="fas fa-trash" onclick="deleteSeance(<?=$s->id?>)"></i>
                </div>
                <? } ?>
              </div>

            <? } ?>
          </div>
        </div>
        <div class="col-12 col-sm-8 col-md-8 col-lg-8 offset-lg-1 mt-4 mt-sm-0">
          <div class="d-none d-sm-block movie-title">
            <h2><?= $movie->title ?>
            </h2>
          </div>
          <div class="d-none d-sm-block movie-details">
            <div class="movie-properties">
              <p class="mb-1"><?= Genre::getNameById($movie->genre) ?></p><p class="seperator d-none d-sm-inline"> | </p><p class="mb-1"><?= Tools::getRequiredAgeText($movie->required_age) ?></p><p class="seperator d-none d-sm-inline"> | </p><p class="mb-1"><?= $movie->duration ?> minut</p>
            </div>
          </div>
          <div class="d-none d-sm-flex flex-row upcoming-seance">
            <? if($seances) foreach ($seances as $s) { ?>
              <div class="seanse-tile" seance-id="<?= $s->id?>">
                <a href="/ticket/buy?id=<?=$s->id?>">
                  <div class="seanse-time">
                    <?= date("H:i", strtotime($s['show_date'])) ?>
                  </div>
                  <div class="seanse-type">
                    <?= Movie::getType($s->projection_type) ?>
                  </div>
                  <div class="seanse-date">
                    <?= date("d.m ", strtotime($s['show_date'])) ?><br>
                    <?= Tools::getDayOfWeek(date("w", strtotime($s['show_date']))) ?>
                  </div>
                  <i class="fas fa-ticket-alt" aria-hidden="true"></i>
                </a>
                <? if(User::isAdmin()) { ?>
                <div class="buttons">
                  <i class="fas fa-edit" onclick="window.location = '/seance/edit?id=<?=$s->id?>';"></i>
                  <i class="fas fa-trash" onclick="deleteSeance(<?=$s->id?>)"></i>
                </div>
                <? } ?>
              </div>

            <? } ?>
          </div>
        </div>
      </div>
    </div>
  <? } ?>
</div>
<div class="">
  <? $p->displayPagination() ?>
</div>
