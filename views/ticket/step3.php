<? use app\models\Movie;
   use app\models\Slot;
   use app\models\Tools;
   use app\models\BookingSeat;


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
<input type="hidden" id="price_standard" value="<?= $seance->price_standard ?>">
<input type="hidden" id="price_vip" value="<?= $seance->price_vip ?>">
<div class="col-12 col-md-8 offset-md-2 hide-when-processing">
  <div class="row mt-5">
    <div class="col-12 hall-holder">
      <div class="hall-schematic" id="seat-selector">
        <? for ($a=1; $a <= $hall->size_y ; $a++) { ?>
        <div class="schematic-row">
          <? for ($b=1; $b <= $hall->size_x; $b++){
                $slot = Slot::getSlotAtPosition($hall->id, $a, $b);
                $free = BookingSeat::isFreeSeat($_GET['id'], $slot->id);
                echo "<p class='schematic ".$slot->type." ".($free ? "occupied" : "")."  ' slot-id='".$slot->id."' row='".$a."' col='".$b."'></p>";
              } ?>
        </div>
        <? } ?>
      </div>
    </div>
    <p class="error" id="seat-error"></p>

  </div>
  <div class="mt-5 mb-5">
    <div class="mb-5 d-none d-md-block">
      <h2 class="seats-text standard">Miejsca standardowe - <span class="highlighted">0</span> <span class="seats-price">0 zł</span></h2>
      <h2 class="seats-text vip">Miejsca VIP - <span class="highlighted">0</span> <span class="seats-price">0 zł</span></h2>
    </div>
    <div class="mb-5 d-block d-md-none">
      <div class="mb-3 table-responsive">
        <table class="table table-borderless">
          <thead>
            <tr>
              <th scope="col">Miejsce</th>
              <th scope="col">Ilość</th>
              <th scope="col">Cena</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>Standardowe</td>
              <td class="amount-standard">0</td>
              <td class="price-standard">0 zł</td>
            </tr>
            <tr>
              <td>VIP</td>
              <td class="amount-vip">0</td>
              <td class="price-vip">0 zł</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

    <p class="h5 mb-5">Po rozpoczęciu procesu rezerwacji biletów proszę nie zamykać tej strony. W przypadku jej zamknięcia cały proces zostanie anulowany.</p>

    <p class="btn btn-primary hide-when-processing" onclick="bookSeats()">Kup bilety</p>
  </div>
</div>
<input type="hidden" id="id_booking" value="">

<div class="col-12 col-md-8 offset-md-2 show-when-processing" style="display: none">
  <i class="fas fa-spinner"></i>
  <p class="h5 text-center mt-4">Trwa oczekiwanie na płatność, prosze nie zamykać tej strony.</p>
</div>
