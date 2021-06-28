<?php use app\models\User;
      use app\models\Tools;
      use app\models\Genre;
      use app\models\Country;
      use app\models\DirectorPicture;

$this->title = 'Edytuj reżysera';
?>

<div class="mb-5">
  <form id="director-create" class="container">
    <input type="hidden" id="id" value="<?= $director->id ?>">
    <div class="row">
      <div class="col-6">
        <label class="form-label mb-3">
          <p class="mb-1">Imię i nazwisko reżysera</p>
          <input type="text" class="form-control" id="name" placeholder="Imię i nazwisko reżysera" value="<?= $director->name ?>">
          <p class="error"></p>
        </label>

        <label class="form-label mb-3">
          <p class="mb-1">Biografia</p>
          <textarea id="description" rows="8" cols="80"><?=$director->description?></textarea>
          <p class="error"></p>
        </label>

        <div class="row">
          <div class="col-6">
            <label class="form-label mb-3">
              <p class="mb-1">Kraj urodzenia</p>
              <select class="" id="birth_place">
                <?= Country::generateOptionList($director->birth_place) ?>
              </select>
              <p class="error"></p>
            </label>
          </div>
          <div class="col-6">
            <label class="form-label mb-3">
              <p class="mb-1">Data urodzenia</p>
              <input type="custom-date" class="form-control" id="birth_date" placeholder="Data urodzenia" value="<?= date("Y-m-d", strtotime($director->birth_date)) ?>">
              <p class="error"></p>
            </label>
          </div>
        </div>

        <label class="form-label mb-3">
          <p class="mb-1">Wybierz wgrane zdjęcie</p>
          <select class="" id="picture_select">
            <?= DirectorPicture::generateOptionList() ?>
          </select>
          <p class="error"></p>
        </label>


      </div>
      <div class="col-6">

        <input type="hidden" id="picture" value="">

        <div class="poster-holder">
          <p class="mb-1">Lub wgraj nowe zdjęcie</p>
          <? $picture = DirectorPicture::getById($director->picture); ?>
          <img src="<?= $picture['url'] ? "/uploads/directors/".$picture['url'] : "https://via.placeholder.com/300x300" ?>" alt="" class="img-fluid director-picture" id="picture-drop">
        </div>
        <p class="error"></p>
      </div>
    </div>

    <div class="row">
      <div class="col-12">
        <a onclick="ajaxSend('director-create')" class="btn btn-primary"><i class="fas fa-edit"></i> Zapisz reżysera</a>
      </div>
    </div>
  </form>
</div>
