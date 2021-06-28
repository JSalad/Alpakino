<?php use app\models\Tools;
      use app\models\Genre;
      use app\models\User;
      use app\models\Poster;
      use app\models\Country;

$this->title = 'Plakaty filmowe';
?>

<div class="mb-5 table-responsive">
  <table class="table table-borderless">
    <thead>
      <tr>
        <th scope="col">#</th>
        <th scope="col">Nazwa</th>
        <th scope="col">URL</th>
        <th scope="col" style="width: 295px;"></th>
      </tr>
    </thead>
    <tbody>
      <? if($posters) { $i = $p->display_from; foreach ($posters as $poster) { ?>
        <tr poster-id="<?= $poster->id ?>">
          <td><?= $i++ ?></td>
          <td><?= $poster->name ?></td>
          <td><?= $poster->url ?> <a class="preview" target="_blank" href="/uploads/posters/<?= $poster->url ?>">( podgląd )</a></td>
          <td class="actions">
            <a class="btn btn-primary subtle" onclick="deletePoster(<?=$poster->id?>)"><i class="fas fa-trash"></i> Usuń</a>
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
