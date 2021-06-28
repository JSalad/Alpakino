<?php use app\models\Tools;

$this->title = 'Logowanie';
?>

<div class="mb-5">
  <form id="login" class="container">
    <div class="row">
      <div class="col-md-6">
          <label class="form-label mb-3">
            <p class="mb-1">Adres e-mail</p>
            <input type="email" class="form-control" id="email" placeholder="Adres e-mail">
            <p class="error"></p>
          </label>

          <label class="form-label mb-3">
            <p class="mb-1">Hasło</p>
            <input type="password" class="form-control" id="password" placeholder="Hasło">
            <p class="error"></p>
          </label>

          <a onclick="ajaxSend('login')" class="btn btn-primary"><i class="fas fa-sign-in-alt"></i> Zaloguj się</a>

      </div>
      <div class="col-md-6 d-none d-md-block">
        <img class="img-fluid" src="/images/logo_full.svg" alt="">
      </div>
    </div>
  </form>
</div>
