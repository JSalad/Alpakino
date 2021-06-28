<?php use app\models\Tools;
      use app\models\Genre;
      use app\models\User;
      use app\models\Poster;
      use app\models\Country;

$this->title = 'Reżyserzy';
?>

<? if(User::isAdmin()){ ?>
<div class="toolbar admin-bar mb-5 anim-100">
  <a class="btn btn-primary" href="/director/create"><i class="fas fa-plus"></i> Dodaj reżysera</a>
</div>
<? } ?>

<div class="mb-5 table-responsive anim-100">
  <table class="table table-borderless">
    <thead>
      <tr>
        <th scope="col">#</th>
        <th scope="col">Imię i nazwisko</th>
        <th scope="col">Data urodzenia</th>
        <th scope="col">Miejsce urodzenia</th>
        <th scope="col" style="width: 295px;"></th>
      </tr>
    </thead>
    <tbody>
      <? if($directors) { $i = $p->display_from; foreach ($directors as $director) { ?>
        <tr director-id="<?= $director->id ?>">
          <td><?= $i++ ?></td>
          <td><a href="/direcotr/details?id=<?= $director->id?>"><?= $director->name ?></a></td>
          <td><?= date("Y-m-d", strtotime($director->birth_date)) ?></td>
          <td><?= Country::getNameById($director->birth_place)?></td>
          <td class="actions">
            <a class="btn btn-primary subtle" href="/director/edit?id=<?=$director->id?>"><i class="fas fa-edit"></i> Edytuj</a>
            <a class="btn btn-primary subtle" onclick="deleteDirector(<?=$director->id?>)"><i class="fas fa-trash"></i> Usuń</a>
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
