<? use app\models\Slot;
   use app\models\Hall;
   use app\models\Movie;
   use app\models\Seance;
   use app\models\Poster;
   use app\models\BookingSeat;

   $this->title = "Bilet #". $b['id'];

   $seance = Seance::getById($b['id_seance']);
   $movie = Movie::getById($seance['id_movie']);
   $hall = Hall::getById($seance['id_hall']);
   $seats = BookingSeat::getByBooking($b['id']);
   $seats_clear = [];
   if($seats) foreach ($seats as $v) $seats_clear[] = $v['id_seat']; $seats = $seats_clear;
?>

<div class="row ticket-holder">
  <div class="col-12 col-md-3 d-none d-md-block">
    <img class="img-fluid" src="<?= Poster::getPosterUrl($movie['poster_url']) ?>" alt="CICHE MIEJSCE 2">
  </div>
  <div class="col-12 col-md-9">
    <h2>Bilet #<?= $b['id']?> na film: <?= $movie->title ?></h2>
    <hr class="col-3">
    <p class="mb-1">Data seansu: <b class="highlighted"><?= $seance['show_date'] ?></b> </p>
    <p class="mb-1">Sala: <b class="highlighted"><?= $hall['name'] ?></b> </p>
    <p class="mb-1">Status biletu: <?= $b['payment_status'] == 2 ? "<b class='payment-ok'>Opłacony</b>" : "<b class='payment-bad'>Anulowany lub nieopłacony</b>" ?> </p>


    <hr class="col-3 mt-5">
    <p>Wybrane miejsca:</p>
    <? $i = 1;
    if($seats) foreach ($seats as $id) {
      $s = Slot::getByid($id); ?>
      <p class="mb-1">Miejsce #<?= $i++ ?>:
        fotel <?= $s['type'] == "vip" ? "<b class='seat-vip'>VIP</b>" : "<b class='seat-standard'>standard</b>" ?>,
        rząd: <b class="highlighted"><?= $s['pos_x'] ?></b>,
        kolumna: <b class="highlighted"><?= $s['pos_y'] ?></b>

      </p>
    <? } ?>

  </div>
</div>
