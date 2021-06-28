<?php use app\models\Tools;
      use app\models\Genre;
      use app\models\Country;
      use app\models\Director;
      use app\models\User;
      use app\models\Poster;
      use app\models\Movie;

$this->title = 'Dodaj trailer dla '.Movie::getById($_GET['id'])->title;
?>

<div class="mb-5">
  <form id="movie-create" class="container">
    <input type="hidden" id="id_movie" value="<?= $_GET['id'] ?>">
    <div class="row">
      <div class="col-md-6">
          <label class="form-label mb-3">
            <p class="mb-1">Tytuł trailera</p>
            <input type="text" class="form-control" id="title" placeholder="Tytuł trailera">
            <p class="error"></p>
          </label>

          <label class="form-label mb-3">
            <p class="mb-1">Opis trailera</p>
            <textarea id="description" rows="8" cols="80"></textarea>
            <p class="error"></p>
          </label>

          <div class="col-6">
            <label class="form-label mb-3">
              <p class="mb-1">Data premiery</p>
              <input type="custom-date" class="form-control" id="premiere_date" placeholder="Data premiery">
              <p class="error"></p>
            </label>
          </div>
      </div>
      <div class="col-md-6">
        <div class="row">
          <div class="col-8">
            <label class="form-label mb-3">
              <p class="mb-1">Źródło trailera</p>
              <input type="text" class="form-control" id="source" placeholder="Źródło trailera">
              <p class="error"></p>
            </label>
          </div>
          <div class="col-4">
            <label class="form-label mb-3">
              <p class="mb-1"> </p>
              <a onclick="loadVideo()" class="btn btn-primary w-100"><i class="fas fa-upload"></i> Wczytaj</a>
            </label>
          </div>
        </div>


        <div class="poster-holder">
          <p class="mb-1">Podgląd materiału</p>

          <img id="source_poster" src="https://via.placeholder.com/1280x720" class="img-fluid" onclick="$('#source_modal').modal('show')">
        </div>
        <p class="error"></p>


      <div class="modal fade" id="source_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl">
          <div class="modal-content">
            <div class="modal-body">
              <iframe id="source_frame" width="1280px" height="720px" src="" frameborder="0" allowfullscreen></iframe>
            </div>
          </div>
        </div>
      </div>

      </div>
    </div>
    <div class="row">
      <div class="col-12">
        <a onclick="ajaxSend('movie-create')" class="btn btn-primary"><i class="fas fa-plus"></i> Dodaj trailer</a>
      </div>
    </div>
  </form>
</div>
