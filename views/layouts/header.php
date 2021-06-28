<? use app\models\Tools;
   use app\models\User; ?>
<header>
  <? //include("slider.php"); ?>
  <nav class="navbar navbar-expand-lg">
    <div class="container">
      <a class="navbar-brand" href="/">
        <img height="50px" src="/images/logo_text.svg" alt="ALPAKINO">
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <i class="fas fa-bars"></i>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav w-100 mb-2 mb-lg-0 d-block">
          <li class="nav-item">
            <a class="nav-link" href="/seance/index"><i class="fas fa-ticket-alt"></i> Repertuar</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="/movie/index"><i class="fas fa-film"></i> Premiery</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="/cinema/contact"><i class="far fa-id-card"></i> Kontakt</a>
          </li>
          <? if(User::isAdmin()){ ?>
            <li class="nav-item float-md-end dropdown">
              <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="fas fa-cog"></i> Zarządzanie
              </a>
              <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                <li class="nav-item">
                  <a class="nav-link" href="/admin/"><i class="fas fa-user"></i> Obsługa</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="/poster/"><i class="fas fa-image"></i> Plakaty</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="/director/"><i class="fas fa-portrait"></i> Reżyserzy</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="/hall/index"><i class="fas fa-border-all"></i> Sale</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="/admin/logout"><i class="fas fa-sign-out-alt"></i> Wyloguj</a>
                </li>
              </ul>
            </li>





          <? } ?>
        </ul>
      </div>
    </div>
  </nav>
</header>
