<? use app\models\Movie;
   use app\models\Slot;


?>

<div class="col-12">
    <h1 class="text-center"><?= $movie->title ?></h1>
    <div class="ticket-movie-details mb-5">
      <p class="mb-1"><?= date("d-m-Y H:i", strtotime($seance->show_date))?></p>
      <p class="seperator d-none d-sm-inline"> | </p>
      <p class="mb-1"><?= Movie::getType($seance->projection_type) ?></p>
      <p class="seperator d-none d-sm-inline"> | </p>
      <p class="mb-1"><?= $movie->duration ?> minut</p>
    </div>

    <?
    $date_start = $seance->show_date;
    $now = date("Y-m-d H:i:s", strtotime(date("Y-m-d H:i:s")." + 1 hour"));
    $expired = $date_start <= $now;

    if(!$expired){ ?>
      <div class="mt-5">
        <p class="btn btn-primary" onclick="initProcess()"><i class="fas fa-ticket-alt"></i> Kup bilet</p>
      </div>
    <? } else { ?>
        <h4 class="text-center">Sprzedaż biletów została zakończona</h4>
        <p class="text-center">Bilet można zakupić najpóźniej do godziny przed rozpoczęciem seansu.</p>
    <? } ?>
  </div>
