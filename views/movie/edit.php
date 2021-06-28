<?php use app\models\Tools;
      use app\models\Genre;
      use app\models\Country;
      use app\models\Director;
      use app\models\User;
      use app\models\Poster;

$this->title = 'Edytuj film';
?>

<div class="mb-5">
  <form id="movie-create" class="container">
    <input type="hidden" id="id" value="<?= $movie->id ?>">
    <div class="row">
      <div class="col-md-6">
          <label class="form-label mb-3">
            <p class="mb-1">Tytuł filmu</p>
            <input type="text" class="form-control" id="title" placeholder="Tytuł filmu" value="<?= $movie->title ?>">
            <p class="error"></p>
          </label>

          <label class="form-label mb-3">
            <p class="mb-1">Opis filmu</p>
            <textarea id="description" rows="8" cols="80"><?= $movie->description ?></textarea>
            <p class="error"></p>
          </label>

          <div class="row">
            <div class="col-6">
                <label class="form-label mb-3">
                  <p class="mb-1">Wymagany wiek</p>
                  <div class="number-input">
                    <button type="button" onclick="this.parentNode.querySelector('input[type=number]').stepDown()" class="minus"><i class="fas fa-minus"></i></button>
                    <input type="number" class="form-control" id="required_age" value="<?= $movie->required_age ?>" min="0" max="18">
                    <button type="button" onclick="this.parentNode.querySelector('input[type=number]').stepUp()" class="plus"><i class="fas fa-plus"></i></button>
                  </div>
                  <p class="error"></p>
                </label>
              </div>
            <div class="col-6">
                <label class="form-label mb-3">
                  <p class="mb-1">Długość filmu</p>
                  <div class="number-input">
                    <button type="button" onclick="this.parentNode.querySelector('input[type=number]').stepDown()" class="minus"><i class="fas fa-minus"></i></button>
                    <input type="number" class="form-control" id="duration" value="<?= $movie->duration ?>" min="0" max="300">
                    <button type="button" onclick="this.parentNode.querySelector('input[type=number]').stepUp()" class="plus"><i class="fas fa-plus"></i></button>
                  </div>
                  <p class="error"></p>
                </label>
              </div>
          </div>

          <div class="row">
            <div class="col-6">
                <label class="form-label mb-3">
                  <p class="mb-1">Gatunek filmu</p>
                  <select class="" id="genre">
                    <?= Genre::generateOptionList($movie->genre) ?>
                  </select>
                  <p class="error"></p>
                </label>
              </div>
              <div class="col-6">
                <label class="form-label mb-3">
                  <p class="mb-1">Kraj produkcji</p>
                  <select class="" id="production_country">
                    <?= Country::generateOptionList($movie->production_country) ?>
                  </select>
                  <p class="error"></p>
                </label>
              </div>
          </div>

          <div class="row">
            <div class="col-6">
              <label class="form-label mb-3">
                <p class="mb-1">Reżyser</p>
                <select class="" id="director">
                  <?= Director::generateOptionList($movie->director) ?>
                </select>
                <p class="error"></p>
              </label>
            </div>
            <div class="col-6">
              <label class="form-label mb-3">
                <p class="mb-1">Data premiery</p>
                <input type="custom-date" class="form-control" id="premiere_date" placeholder="Data premiery" value="<?= date("Y-m-d", strtotime($movie->premiere_date)) ?>">
                <p class="error"></p>
              </label>
            </div>
          </div>

          <label class="form-label mb-3">
            <p class="mb-1">Dodatkowe informacje</p>
            <textarea id="additional_info" rows="8" cols="80"><?= $movie->additional_info ?></textarea>
            <p class="error"></p>
          </label>
      </div>
      <div class="col-md-6">
        <input type="hidden" id="poster_url" value="<?= $movie->poster_url ?>">
        <label class="form-label mb-3">
          <p class="mb-1">Wybierz wgrany plakat</p>
          <select class="" id="poster_select">
            <?= Poster::generateOptionList() ?>
          </select>
          <p class="error"></p>
        </label>

        <div class="poster-holder">
          <p class="mb-1">Lub wgraj nowy plakat</p>
          <? $poster = Poster::getById($movie->poster_url); ?>
          <img src="/uploads/posters/<?= $poster['url'] ?>" alt="" class="img-fluid" id="poster-drop">
        </div>
        <p class="error"></p>
      </div>
    </div>
    <div class="row">
      <div class="col-12">
        <a onclick="ajaxSend('movie-create')" class="btn btn-primary">Zapisz film</a>
      </div>
    </div>
  </form>
</div>
