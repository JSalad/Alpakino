<?php use app\models\Tools;
      use app\models\Genre;
      use app\models\User;
      use app\models\Slot;
      use app\models\Poster;
      use app\models\Country;

$this->title = 'Sale kinowe';
?>

<? if(User::isAdmin()){ ?>
<div class="toolbar admin-bar mb-5">
  <a class="btn btn-primary" href="/hall/create"><i class="fas fa-plus"></i> Dodaj salę</a>
</div>
<? } ?>

<div class="mb-5 table-responsive">
  <table class="table table-borderless">
    <thead>
      <tr>
        <th scope="col">#</th>
        <th scope="col">Nazwa</th>
        <th scope="col">Ilość miejsc</th>
        <th scope="col" class="d-none d-lg-block" style="width: 500px;">Schemat sali</th>
        <th scope="col" style="width: 135px;"></th>
      </tr>
    </thead>
    <tbody>
      <? if($halls) { $i = $p->display_from; foreach ($halls as $h) { ?>
        <tr hall-id="<?= $h->id ?>">
          <td><?= $i++ ?></td>
          <td><?= $h->name ?></td>
          <td><?= Slot::calculateSeatsForHall($h->id) ?></td>
          <td class="d-none d-lg-table-cell">
            <div class="hall-shcematic">
              <? for ($a=1; $a <= $h->size_y ; $a++) { ?>
                <div class="schematic-row">
                  <? for ($b=1; $b <= $h->size_x; $b++) echo "<p class='schematic ".(Slot::getSlotAtPosition($h->id, $a, $b))['type']."'></p>"; ?>
                </div>
                <? } ?>
            </div>
          </td>
          <td class="actions">
            <a class="btn btn-primary subtle" onclick="deleteHall(<?=$h->id?>)"><i class="fas fa-trash"></i> Usuń</a>
          </td>
        </tr>
      <? } } else { ?>
        <tr director-id="<?= $director->id ?>">
          <td colspan="100%" class="results-error">Nie znaleziono wyników pasujących do podanych kryterii wyszukiwania</td>
        </tr>
      <? } ?>


    </tbody>
  </table>



</div>
<div class="">
  <? $p->displayPagination() ?>
</div>
