<?php

use app\models\Tools;

$this->title = "Kontakt";
?>

<div class="row">
  <div class="col-12">
    <h1>Alpakino - Rozrywka na pełnej...</h1>
    <p>Witaj na stronie internetowej kina Alpakino.<br><br>Jeżeli potrzebujesz pomocy możesz skorzystać z formularza kontaktowego zamieszczonego poniżej.<br>Na wszystkie maile staramy się odpowiadac w czasie nie dłuższym niż 2 dni robocze.</p>
  </div>
</div>
<div class="row">
  <div class="col-12 col-md-6">
    <form id="contact-form" method="post" autocomplete="off">
      <div class="row">
        <div class="col-6">
          <label class="form-label mb-3">
            <p class="mb-1">Imię</p>
            <input type="text" class="form-control" id="first_name" placeholder="Imię" value="" autocomplete="off">
            <p class="error"></p>
          </label>
        </div>
        <div class="col-6">
          <label class="form-label mb-3">
            <p class="mb-1">Nazwisko</p>
            <input type="text" class="form-control" id="last_name" placeholder="Nazwisko" value="">
            <p class="error"></p>
          </label>
        </div>
      </div>
      <div class="row">
        <div class="col-6">
          <label class="form-label mb-3">
            <p class="mb-1">Adres e-mail</p>
            <input type="email" class="form-control" id="email" placeholder="Adres e-mail" value="">
            <p class="error"></p>
          </label>
        </div>
        <div class="col-6">
          <label class="form-label mb-3">
            <p class="mb-1">Temat</p>
            <input type="text" class="form-control" id="subject" placeholder="Temat" value="">
            <p class="error"></p>
          </label>
        </div>
      </div>
      <div class="row">
        <div class="col-12">
          <label class="form-label mb-3">
            <p class="mb-1">Treść wiadomości</p>
            <textarea id="content" rows="8" cols="80"></textarea>
            <p class="error"></p>
          </label>
        </div>
      </div>
      <div class="row">
        <div class="col-12">
          <a class="btn btn-primary" name="button" onclick="ajaxSend('contact-form')" ><i class="fas fa-envelope"></i> Wyślij wiadomość</a>
        </div>
      </div>
    </form>
  </div>
  <div class="col-12 col-md-5 offset-md-1 d-none d-md-block">
      <p class="mb-1"> </p>
      <iframe style="filter: invert(0.85);" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2561.995992102283!2d21.979512915716967!3d50.048906379422!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x473cfb6d2f4ddf8f%3A0x958858da08f8753b!2sWy%C5%BCsza%20Szko%C5%82a%20Informatyki%20i%20Zarz%C4%85dzania!5e0!3m2!1spl!2spl!4v1624570209368!5m2!1spl!2spl" width="100%" height="500px" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
  </div>
</div>
