<?php use app\models\Tools;

$this->title = 'Dodawanie administratora';
?>

<div class="mb-5">
  <form id="create" class="container">
    <div class="row">
      <div class="col-md-6">
          <label class="form-label mb-3">
            <p class="mb-1">Adres e-mail</p>
            <input type="email" class="form-control" id="email" placeholder="Adres e-mail">
            <p class="error"></p>
          </label>

          <div class="row">
            <div class="col-12 col-md-6">
              <label class="form-label mb-3">
                <p class="mb-1">Imię</p>
                <input type="text" class="form-control" id="first_name" placeholder="Imię">
                <p class="error"></p>
              </label>
            </div>
            <div class="col-12 col-md-6">
              <label class="form-label mb-3">
                <p class="mb-1">Nazwisko</p>
                <input type="text" class="form-control" id="last_name" placeholder="Nazwisko">
                <p class="error"></p>
              </label>
            </div>
          </div>

          <label class="form-label mb-3">
            <p class="mb-1">Hasło</p>
            <input type="password" class="form-control" id="password" placeholder="Hasło">
            <p class="error"></p>
          </label>

          <label class="form-label mb-3">
            <p class="mb-1">Powtórz hasło</p>
            <input type="password" class="form-control" id="repeat-password" placeholder="Hasło">
            <p class="error"></p>
          </label>

          <a onclick="ajaxSend('create')" class="btn btn-primary"><i class="fas fa-plus"></i> Dodaj administratora</a>

      </div>
      <div class="col-md-6 d-none d-md-block">
        <img class="img-fluid" src="/images/logo_full.svg" alt="">
      </div>
    </div>
  </form>
</div>
