<?php use app\models\Tools;
      use app\models\Movie;
      use app\models\User;
      use app\models\Hall;
      use app\models\Poster;

$this->title = 'Dodaj seans';
?>

<div class="mb-5">
  <form id="seance-create" class="container">
    <div class="row">
      <div class="col-md-6">
          <label class="form-label mb-3">
            <p class="mb-1">Film</p>
            <select class="" id="id_movie">
              <?= Movie::generateOptionList() ?>
            </select>
            <p class="error"></p>
          </label>

          <div class="row">
            <div class="col-6">
                <label class="form-label mb-3">
                  <p class="mb-1">Sala</p>
                  <select class="" id="id_hall">
                    <?= Hall::generateOptionList() ?>
                  </select>
                  <p class="error"></p>
                </label>
              </div>
            <div class="col-6">
              <label class="form-label mb-3">
                <p class="mb-1">Typ filmu</p>
                <select class="" id="projection_type">
                  <?= Movie::generateTypesOptionList() ?>
                </select>
                <p class="error"></p>
              </label>
            </div>
          </div>

          <div class="row">
            <div class="col-6">
              <label class="form-label mb-3">
                <p class="mb-1">Data seansu</p>
                <input type="custom-date" class="form-control" id="show_date_date" placeholder="Data seansu">
                <p class="error"></p>
              </label>
            </div>
            <div class="col-6">
              <label class="form-label mb-3">
                <p class="mb-1">Godzina seansu</p>
                <input type="custom-time" class="form-control" id="show_date_time" placeholder="Godzina seansu">
                <p class="error"></p>
              </label>
            </div>
          </div>
      </div>

      <div class="col-md-6">

        <label class="form-label mb-3">
          <p class="mb-1">Cena biletu standardowego</p>
          <div class="number-input">
            <button type="button" onclick="this.parentNode.querySelector('input[type=number]').stepDown()" class="minus"><i class="fas fa-minus"></i></button>
            <input type="number" class="form-control" id="price_standard" value="15" min="1" max="300">
            <button type="button" onclick="this.parentNode.querySelector('input[type=number]').stepUp()" class="plus"><i class="fas fa-plus"></i></button>
          </div>
          <p class="error"></p>
        </label>

        <label class="form-label mb-3">
          <p class="mb-1">Cena biletu VIP</p>
          <div class="number-input">
            <button type="button" onclick="this.parentNode.querySelector('input[type=number]').stepDown()" class="minus"><i class="fas fa-minus"></i></button>
            <input type="number" class="form-control" id="price_vip" value="25" min="1" max="300">
            <button type="button" onclick="this.parentNode.querySelector('input[type=number]').stepUp()" class="plus"><i class="fas fa-plus"></i></button>
          </div>
          <p class="error"></p>
        </label>

      </div>
    </div>
    <div class="row">
      <div class="col-12">
        <a onclick="ajaxSend('seance-create')" class="btn btn-primary"><i class="fas fa-plus"></i> Dodaj seans</a>
      </div>
    </div>
  </form>
</div>
