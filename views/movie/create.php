<?php use app\models\Tools;
      use app\models\Genre;
      use app\models\Country;
      use app\models\Director;
      use app\models\User;
      use app\models\Poster;

$this->title = 'Dodaj film';
?>

<div class="mb-5">
  <form id="movie-create" class="container">
    <div class="row">
      <div class="col-md-6">
          <label class="form-label mb-3">
            <p class="mb-1">Tytuł filmu</p>
            <input type="text" class="form-control" id="title" placeholder="Tytuł filmu">
            <p class="error"></p>
          </label>

          <label class="form-label mb-3">
            <p class="mb-1">Opis filmu</p>
            <textarea id="description" rows="8" cols="80"></textarea>
            <p class="error"></p>
          </label>

          <div class="row">
            <div class="col-6">
                <label class="form-label mb-3">
                  <p class="mb-1">Wymagany wiek</p>
                  <div class="number-input">
                    <button type="button" onclick="this.parentNode.querySelector('input[type=number]').stepDown()" class="minus"><i class="fas fa-minus"></i></button>
                    <input type="number" class="form-control" id="required_age" value="18" min="0" max="18">
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
                    <input type="number" class="form-control" id="duration" value="90" min="0" max="300">
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
                    <?= Genre::generateOptionList() ?>
                  </select>
                  <p class="error"></p>
                </label>
              </div>
              <div class="col-6">
                <label class="form-label mb-3">
                  <p class="mb-1">Kraj produkcji</p>
                  <select class="" id="production_country">
                    <?= Country::generateOptionList() ?>
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
                  <?= Director::generateOptionList() ?>
                </select>
                <p class="error"></p>
              </label>
            </div>
            <div class="col-6">
              <label class="form-label mb-3">
                <p class="mb-1">Data premiery</p>
                <input type="custom-date" class="form-control" id="premiere_date" placeholder="Data premiery">
                <p class="error"></p>
              </label>
            </div>
          </div>

          <label class="form-label mb-3">
            <p class="mb-1">Dodatkowe informacje</p>
            <textarea id="additional_info" rows="8" cols="80"></textarea>
            <p class="error"></p>
          </label>
      </div>
      <div class="col-md-6">
        <label class="form-label mb-3">
          <p class="mb-1">Wybierz wgrany plakat</p>
          <select class="" id="poster_select">
            <?= Poster::generateOptionList() ?>
          </select>
          <p class="error"></p>
        </label>

        <input type="hidden" id="poster_url" value="">

        <div class="poster-holder">
          <p class="mb-1">Lub wgraj nowy plakat</p>
          <img src="https://via.placeholder.com/690x1024" alt="" class="img-fluid" id="poster-drop">
        </div>
        <p class="error"></p>

      </div>
    </div>
    <div class="row">
      <div class="col-12">
        <a onclick="ajaxSend('movie-create')" class="btn btn-primary"><i class="fas fa-plus"></i> Dodaj film</a>
      </div>
    </div>
  </form>
</div>
