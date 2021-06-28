<?php use app\models\Tools;
      use app\models\User;
      use app\models\Genre;
      use app\models\Seance;
      use app\models\Movie;
      use app\models\Poster;
      use app\models\Rating;
      use app\models\Trailer;
      use app\models\Country;
      use app\models\Director;

$this->title = $movie->title;
?>

<? if(User::isAdmin()){ ?>
<div class="toolbar admin-bar mb-5">
  <a class="btn btn-primary ms-3" href="/trailer/create?id=<?= $movie->id ?>"><i class="fas fa-plus"></i> Dodaj trailer</a>
  <a class="btn btn-primary ms-3" href="/movie/edit?id=<?=$movie->id?>"><i class="fas fa-edit"></i> Edytuj film</a>
  <a class="btn btn-primary ms-3" onclick="deleteMovie(<?=$movie->id?>)"><i class="fas fa-trash"></i> Usuń film</a>
</div>
<? } ?>

<div class="row">
  <div class="col-12 col-md-3 d-none d-md-block">
    <img class="img-fluid" src="<?= Poster::getPosterUrl($movie->poster_url) ?>" alt="<?= $movie->title ?>">
  </div>
  <div class="col-12 col-md-8 offset-md-1">
    <div class="movie-inside-title">
      <h1><?= $movie->title ?></h1>
    </div>
    <div class="rating mb-2" rating="<?= $rating ?>">
      <? for ($i=1; $i <= 5; $i++) {
        echo '<i class="'.($i <= $rating ? "fas" : "far").' fa-star" onclick="rateMovie('.$movie->id.', '.$i.')" rating="'.$i.'"></i>';

      }
      ?>
    </div>
    <div class="movie-inside-details">
      <div class="movie-properties">
        <p class="mb-1"><?= Genre::getNameById($movie->genre) ?></p>
        <p class="seperator d-none d-sm-inline"> | </p>
        <p class="mb-1"><?= Tools::getRequiredAgeText($movie->required_age) ?></p>
        <p class="seperator d-none d-sm-inline"> | </p>
        <p class="mb-1"><?= $movie->duration ?> minut</p>
      </div>
    </div>
    <div class="movie-inside-director">
      <p>W reżyserii <a href="/director/details?id=<?=$movie->director?>"><?= Director::getNameById($movie->director) ?></a></p>
    </div>
    <div class="movie-inside-director">
      <p>W kinach od <span class="highlighted"><?= date("d-m-Y", strtotime($movie->premiere_date)) ?></span></p>
    </div>
    <div class="movie-inside-description">
      <?= $movie->description ?>
    </div>

    <? $seances = Seance::getSeancesForMovie($movie->id);
    if($seances) { ?>
    <div class="movie-inside-upcoming">
      <h5 class="mt-5 mb-4">Nadchodzące seanse dla <?= $movie->title ?></h5>
      <div class="d-flex flex-row upcoming-seance">
        <? foreach ($seances as $s) { ?>
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
          <div class="buttons">
            <i class="fas fa-edit" onclick="window.location = '/seance/edit?id=<?=$s->id?>';"></i>
            <i class="fas fa-trash" onclick="deleteSeance(<?=$s->id?>)"></i>
          </div>
        </div>
        <? } ?>
      </div>
    </div>
    <? } ?>
  </div>
</div>

<? if($trailers) { ?>
<div class="row mt-5">
  <div class="col-12">
    <h3>Materiały promocyjne</h3>
  </div>
  <div class="col-12">
    <div class="row mb-5">
      <? foreach ($trailers as $v) { ?>
      <div class="col-12 col-md-4" trailer-id="<?= $v['id'] ?>">
        <div class="nice-photo" style="transform: rotate(<?=rand(-4,4)?>deg) scale(0.9)">
          <? if(User::isAdmin()) { ?>
          <i class="fas fa-times" onclick="deleteTrailer(<?= $v['id'] ?>)"></i>
          <? } ?>
          <img onclick="$('#trailer_<?= $v['id'] ?>').modal('show')" src="https://img.youtube.com/vi/<?=$v['source']?>/0.jpg" alt="<?= $v['title'] ?> - Zwiastun - Zdjęcie #1">
          <p class="photo-title"><?= $v['title'] ?></p>
        </div>
      </div>


      <div class="modal fade" id="trailer_<?= $v['id'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl">
          <div class="modal-content">
            <div class="modal-body">
              <iframe id="source_frame" src="https://www.youtube.com/embed/<?=$v['source']?>" width="1280px" height="720px" src="" frameborder="0" allowfullscreen>

              </iframe>
            </div>
          </div>
        </div>
      </div>
      <? } ?>
    </div>
  </div>
</div>
<? } ?>


<div class="row my-5">
  <div class="col-12">
    <h3 class="w-100">Ostatnie recenzje
      <a onclick="$('#comment-add').fadeIn(); $('.comment-hide').hide();" class="float-end btn btn-primary"><i class="fas fa-plus"></i> Dodaj recenzję</a>
    </h3>
  </div>
</div>
<form method="post" id="comment-add" action="/review/create" class="comment-show" style="display: none;">
  <h3>Dodaj własną recenzję!</h3>
  <div class="row mt-5 ">
    <div class="col-12 col-md-6">
      <input type="hidden" id="id_movie" value="<?= $movie->id ?>">
      <label class="form-label mb-3">
        <p class="mb-1">Imię lub pseudonim</p>
        <input type="text" class="form-control" id="first_name" placeholder="Imię lub pseudonim" value="" autocomplete="off">
        <p class="error"></p>
      </label>
      <label class="form-label mb-3">
        <p class="mb-1">Adres e-mail (niewidoczny po dodaniu)</p>
        <input type="text" class="form-control" id="email" placeholder="Adres e-mail" value="" autocomplete="off">
        <p class="error"></p>
      </label>
      <label class="form-label mb-3">
        <p class="mb-1">Weryfikacja bezpieczeństwa</p>
        <div class="g-recaptcha" id="recaptcha" data-sitekey="<?= Yii::$app->params['captcha_public']?>"></div>
        <p class="error"></p>
      </label>
    </div>
    <div class="col-12 col-md-6">
      <label class="form-label mb-3">
        <p class="mb-1">Treść recenzji</p>
        <textarea id="content" rows="8" cols="80"></textarea>
        <p class="error"></p>
      </label>
    </div>
    <div class="col-12">
      <a onclick="ajaxSend('comment-add')" class="btn btn-primary"><i class="fas fa-plus"></i> Dodaj recenzję</a>
    </div>
  </div>
</form>

<? if($reviews) { ?>
  <? foreach ($reviews as $rev) { ?>
    <div class="comment" review-id="<?=$rev->id?>">
      <p class="h4"><b class="highlighted"><?= $rev->name ?></b> napisał:

        <a class="float-end btn btn-primary subtle flag d-none d-md-block" onclick="reportReview(<?= $rev->id ?>)"><i class="fas fa-flag"></i> Zgłoś recenzję</a>
        <? if(User::isAdmin()){ ?>
        <a class="float-end btn btn-primary subtle me-3 d-none d-md-block" onclick="deleteReview(<?= $rev->id ?>)"><i class="fas fa-trash"></i> Usuń</a>
        <? } ?>
      </p>
      <div class="comment-text">
        <?= $rev->content ?>
      </div>
      <div class="d-block d-md-none">
        <a class="btn btn-primary subtle flag" onclick="reportReview(<?= $rev->id ?>)"><i class="fas fa-flag"></i> Zgłoś recenzję</a>
        <? if(User::isAdmin()){ ?>
        <a class="btn btn-primary subtle me-3" onclick="deleteReview(<?= $rev->id ?>)"><i class="fas fa-trash"></i> Usuń</a>
        <? } ?>
      </div>
      <div class="comment-footer mt-3 mb-5 d-none d-md-block">
        <? $rating = Rating::getUserRatingForMovie($movie->id, $rev->ip_address) ? Rating::getUserRatingForMovie($movie->id, $rev->ip_address)->value : 0;
        if($rating) { ?>
        <p class="h6 d-inline-block me-3"> Wystawiona ocena: </p>
        <div class="rating disabled d-inline-block me-5" rating="<?= $rating ?>">
          <? for ($i=1; $i <= 5; $i++) echo '<i class="'.($i <= $rating ? "fas" : "far").' fa-star" onclick="rateMovie('.$movie->id.', '.$i.')" rating="'.$i.'"></i>'; ?>
        </div>
        <? } ?>
        <p class="h6 d-inline-block me-3"><?= $rating ? "w dniu: " : "Data wystawienia recenzji:" ?></p>
        <p class="h6 d-inline-block me-5 highlighted"><?= date("Y-m-d", strtotime($rev->date_created)) ?></p>
      </div>
    </div>
  <? } ?>

<? } else { ?>
<div class="row comment-hide">
  <div class="col-12">
    <p class="h4">Jeszcze nikt nie napisał recenzji dla <?= $movie->title ?></p>
    <p>Możesz być pierwszy i zachęcić innych kinomaniaków do obejrzenia tego filmu!</p>
    <div class="mt-5">
      <a onclick="$('#comment-add').fadeIn(); $('.comment-hide').hide();" class="btn btn-primary"><i class="fas fa-plus"></i> Dodaj recenzję</a>
    </div>
  </div>
</div>
<? } ?>
