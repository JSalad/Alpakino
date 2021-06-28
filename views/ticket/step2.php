<? use app\models\Movie;
   use app\models\Slot;
   use app\models\Tools;


?>

<div class="col-12">
  <h1 class="text-center"><?= $movie->title ?></h1>
  <div class="ticket-movie-details mb-5">
    <p class="mb-1"><?= date("d-m-Y H:i", strtotime($seance->show_date))?></p>
    <p class="seperator d-none d-sm-inline"> | </p>
    <p class="mb-1"><?= Movie::getType($s->projection_type) ?></p>
    <p class="seperator d-none d-sm-inline"> | </p>
    <p class="mb-1"><?= $movie->duration ?> minut</p>
  </div>
</div>
<div class="col-12 col-md-8 offset-md-2">
  <div class="row mt-5">
    <div class="col-12 col-md-6">
      <label class="form-label mb-3">
        <p class="mb-1">Imię</p>
        <input type="text" class="form-control" id="first_name" placeholder="Imię" value="">
        <p class="error"></p>
      </label>
      <label class="form-label mb-3">
        <p class="mb-1">Nazwisko</p>
        <input type="text" class="form-control" id="last_name" placeholder="Nazwisko" value="">
        <p class="error"></p>
      </label>
      <label class="form-label mb-3">
        <p class="mb-1">Adres e-mail</p>
        <input type="text" class="form-control" id="email" placeholder="Adres e-mail" value="">
        <p class="error"></p>
      </label>
    </div>
    <div class="col-12 col-md-6 text-right">
      <div class="d-block d-md-none">
        <div class="mb-3 table-responsive">
          <table class="table table-borderless">
            <thead>
              <tr>
                <th scope="col">Typ biletu</th>
                <th scope="col">Cena</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>Bilet standardowy</td>
                <td><?= Tools::formatMoney($seance->price_standard) ?></td>
              </tr>
              <tr>
                <td>Bilet VIP</td>
                <td><?= Tools::formatMoney($seance->price_vip) ?></td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
      <div class="d-none d-md-block">
        <p class="text-end">Bilet standardowy</p>
        <h2 class="text-end"><?= Tools::formatMoney($seance->price_standard) ?></h2>
        <p class="text-end mt-4">Bilet VIP:</p>
        <h2 class="text-end"><?= Tools::formatMoney($seance->price_vip) ?></h2>
      </div>
    </div>
  </div>
  <div class="mt-5">
    <p class="btn btn-primary" onclick="validateData()"><i class="fas fa-ticket-alt"></i> Kontynuuj</p>
  </div>
</div>
