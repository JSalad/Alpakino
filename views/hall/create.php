<?php use app\models\Tools;
      use app\models\Genre;
      use app\models\Country;
      use app\models\Director;
      use app\models\User;
      use app\models\Poster;

$this->title = 'Dodaj salę kinową';
?>

<div class="mb-5">
  <form id="movie-create" class="container">
    <input type="hidden" id="" value="">
    <div class="row">
      <div class="col-lg-6">
          <label class="form-label mb-3">
            <p class="mb-1">Nazwa sali</p>
            <input type="text" class="form-control" id="name" placeholder="Nazwa sali">
            <p class="error"></p>
          </label>

          <label class="form-label mb-3">
            <p class="mb-1">Opis sali</p>
            <textarea id="description" rows="8" cols="80"></textarea>
            <p class="error"></p>
          </label>
      </div>
      <div class="col-lg-6">
        <div class="row mb-4">
          <div class="col-12 col-md-6">
              <label class="form-label mb-0">
                <p class="mb-1">Szerokość sali</p>
                <div class="number-input">
                  <button type="button" onclick="this.parentNode.querySelector('input[type=number]').stepDown()" class="minus"><i class="fas fa-minus"></i></button>
                  <input type="number" class="form-control" id="size_x" value="14" min="1" max="20">
                  <button type="button" onclick="this.parentNode.querySelector('input[type=number]').stepUp()" class="plus"><i class="fas fa-plus"></i></button>
                </div>
              </label>
            </div>
          <div class="col-12 col-md-6">
              <label class="form-label mb-0">
                <p class="mb-1">Długość sali</p>
                <div class="number-input">
                  <button type="button" onclick="this.parentNode.querySelector('input[type=number]').stepDown()" class="minus"><i class="fas fa-minus"></i></button>
                  <input type="number" class="form-control" id="size_y" value="10" min="1" max="14">
                  <button type="button" onclick="this.parentNode.querySelector('input[type=number]').stepUp()" class="plus"><i class="fas fa-plus"></i></button>
                </div>
              </label>
            </div>
          <div class="col-12 col-md-12">
              <label class="form-label mb-3">
                <p class="mb-1 d-none d-lg-block"> </p>
                <a onclick="generateHall()" class="btn btn-primary w-100"><i class="fas fa-border-all"></i>Wygeneruj</a>
              </label>
            </div>
        </div>
        <div class="row">
          <div class="col-12 col-md-6">
            <a onclick="createScreen()" class="btn btn-success w-100"><i class="fas fa-plus"></i> Stwórz ekran</a>
            <p class="error"></p>
          </div>
          <div class="col-12 col-md-6">
            <a onclick="deleteScreen()" class="btn btn-danger w-100"><i class="fas fa-minus"></i> Skasuj ekran</a>
            <p class="error"></p>
          </div>
        </div>
        <div class="row">
          <div class="col-12 col-md-6">
            <a onclick="createSeat()" class="btn btn-success w-100"><i class="fas fa-plus"></i> Stwórz miejsca</a>
            <p class="error"></p>
          </div>
          <div class="col-12 col-md-6">
            <a onclick="deleteSeat()" class="btn btn-danger w-100"><i class="fas fa-minus"></i> Skasuj miejsca</a>
            <p class="error"></p>
          </div>
        </div>
        <div class="row">
          <div class="col-12 col-md-6">
            <a onclick="createSeatVIP()" class="btn btn-success w-100"><i class="fas fa-plus"></i> Stwórz miejsca VIP</a>
            <p class="error"></p>
          </div>
          <div class="col-12 col-md-6">
            <a onclick="deleteSeatVIP()" class="btn btn-danger w-100"><i class="fas fa-minus"></i> Skasuj miejsca VIP</a>
            <p class="error"></p>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-12">
        <div class="" id="hall-selector">
          <table class="hall-schema">
            <tbody>

            </tbody>
          </table>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-12 mt-5">
        <a onclick="addHall();" class="btn btn-primary"><i class="fas fa-plus"></i> Dodaj salę</a>
      </div>
    </div>
  </form>
</div>
