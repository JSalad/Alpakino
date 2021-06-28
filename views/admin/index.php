<?php
      use app\models\Hall;
      use app\models\Movie;
      use app\models\Tools;
      use app\models\Genre;
      use app\models\Seance;
      use app\models\Poster;
      use app\models\Review;
      use app\models\Director;

$this->title = 'Zarządzanie i statystyki';
?>

<div class="row">
  <div class="col-lg-6 d-none d-lg-block">
    <!-- filmy -->
    <div class="inner tile p-3 mb-3">
      <div class="amount">
        <span><?= Movie::getTotalCount() ?></span>
      </div>
      <div class="text"><span>Wszystkich</span><span>Filmów</span></div>
    </div>
    <div class="inner tile p-3 mb-3">
      <div class="amount">
        <span><?= Seance::getTotalCount() ?></span>
      </div>
      <div class="text"><span>Wszystkich</span><span>Seansów</span></div>
    </div>
    <div class="inner tile p-3 mb-3">
      <div class="amount">
        <span><?= Genre::getTotalCount() ?></span>
      </div>
      <div class="text"><span>Wszystkich</span><span>Kategorii</span></div>
    </div>
    <div class="inner tile p-3 mb-3">
      <div class="amount">
        <span><?= Director::getTotalCount() ?></span>
      </div>
      <div class="text"><span>Wszystkich</span><span>Reżyserów</span></div>
    </div>
    <div class="inner tile p-3 mb-3">
      <div class="amount">
        <span><?= Hall::getTotalCount() ?></span>
      </div>
      <div class="text"><span>Wszystkich</span><span>Sal kinowych</span></div>
    </div>
    <div class="inner tile p-3 mb-3">
      <div class="amount">
        <span><?= Poster::getTotalCount() ?></span>
      </div>
      <div class="text"><span>Wszystkich</span><span>Plakatów filmowych</span></div>
    </div>
    <div class="inner tile p-3 mb-3">
      <div class="amount">
        <span><?= Review::getTotalCount() ?></span>
      </div>
      <div class="text"><span>Wszystkich</span><span>Recenzji użytkowników</span></div>
    </div>
  </div>
  <div class="col-lg-6 ">
    <h3>Administratorzy</h3>
    <div class="mb-3 table-responsive">
      <table class="table table-borderless">
        <thead>
          <tr>
            <th scope="col">#</th>
            <th scope="col">Imię i nazwisko</th>
            <th scope="col">Adres e-mail</th>
            <th scope="col" style="width: 295px;"></th>
          </tr>
        </thead>
        <tbody>
          <? if($users) { $i = $p->display_from; foreach ($users as $u) { ?>
            <tr admin-id="<?= $u->id ?>">
              <td><?= $i++ ?></td>
              <td><?= $u->first_name." ".$u->last_name ?></td>
              <td><?= $u->email ?></td>
              <td class="actions">
                <a class="btn btn-primary subtle" onclick="deleteUser(<?=$u->id?>)"><i class="fas fa-trash"></i> Usuń</a>
              </td>
            </tr>
          <? } } else { ?>
            <tr>
              <td colspan="100%" class="results-error">Nie znaleziono wyników pasujących do podanych kryterii wyszukiwania</td>
            </tr>
          <? } ?>
        </tbody>
      </table>
    </div>
    <div class="">
      <? $p->displayPagination() ?>
    </div>
    <div class="col-12">
      <a class="btn btn-primary float-end" href="/admin/create"><i class="fas fa-plus"></i> Dodaj administratora</a>
    </div>

    <? $reviews = Review::getReportedReviews() ?>

    <? if($reviews) { ?>
    <br>
    <br class="mt-5">
    <h3 class="mt-5">Zgłoszone recenzje</h3>
    <div class="mb-3 table-responsive">
      <table class="table table-borderless">
        <thead>
          <tr>
            <th scope="col">#</th>
            <th scope="col">Imię i nazwisko</th>
            <th scope="col">Adres e-mail</th>
            <th scope="col">Wiadomość</th>
            <th scope="col" style="width: 295px;"></th>
          </tr>
        </thead>
        <tbody>
          <? if($reviews) { $i = $p->display_from; foreach ($reviews as $r) { ?>
            <tr review-id="<?= $r->id ?>">
              <td><?= $i++ ?></td>
              <td><?= $r->name ?></td>
              <td><?= $r->email ?></td>
              <td class="td-content"><?= $r->content ?></td>
              <td class="actions">
                <a class="btn btn-primary subtle" onclick="deleteReview(<?=$r->id?>)"><i class="fas fa-trash"></i> Usuń</a>
                <a class="btn btn-primary subtle" onclick="approveReview(<?=$r->id?>)"><i class="fas fa-check"></i> Dopuść</a>
              </td>
            </tr>
          <? } } else { ?>
            <tr>
              <td colspan="100%" class="results-error">Nie znaleziono wyników pasujących do podanych kryterii wyszukiwania</td>
            </tr>
          <? } ?>
        </tbody>
      </table>
    </div>

    <? } ?>
  </div>
</div>
