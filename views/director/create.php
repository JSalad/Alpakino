<?php use app\models\User;
      use app\models\Tools;
      use app\models\Genre;
      use app\models\Country;
      use app\models\DirectorPicture;

$this->title = 'Dodaj reżysera';
?>

<div class="mb-5">
  <form id="director-create" class="container">
    <div class="row">
      <div class="col-md-6">
          <label class="form-label mb-3">
            <p class="mb-1">Imię i nazwisko reżysera</p>
            <input autocomplete="off" type="text" class="form-control" id="name" placeholder="Imię i nazwisko reżysera">
            <p class="error"></p>
          </label>

          <label class="form-label mb-3">
            <p class="mb-1">Biografia</p>
            <textarea id="description" rows="8" cols="80"></textarea>
            <p class="error"></p>
          </label>

          <div class="row">
            <div class="col-6">
                <label class="form-label mb-3">
                  <p class="mb-1">Kraj urodzenia</p>
                  <select class="" id="birth_place">
                    <?= Country::generateOptionList() ?>
                  </select>
                  <p class="error"></p>
                </label>
            </div>
            <div class="col-6">
                <label class="form-label mb-3">
                  <p class="mb-1">Data urodzenia</p>
                  <input autocomplete="off" type="custom-date" class="form-control" id="birth_date" placeholder="Data urodzenia">
                  <p class="error"></p>
                </label>
              </div>
          </div>

          <div class="row">
            <label class="form-label mb-3">
              <p class="mb-1">Wybierz wgrane zdjęcie</p>
              <select class="" id="picture_select">
                <?= DirectorPicture::generateOptionList() ?>
              </select>
              <p class="error"></p>
            </label>
          </div>
      </div>
      <div class="col-md-6">
        <input autocomplete="off" type="hidden" id="picture" value="">
        <div class="poster-holder">
          <p class="mb-1">Lub wgraj nowe zdjęcie</p>
          <img src="https://via.placeholder.com/300x300" alt="" class="img-fluid director-picture" id="picture-drop">
        </div>
        <p class="error"></p>
      </div>
    </div>
    <div class="row">
      <div class="col-12">
        <a onclick="ajaxSend('director-create')" class="btn btn-primary"><i class="fas fa-plus"></i> Dodaj reżysera</a>
      </div>
    </div>
  </form>
</div>
