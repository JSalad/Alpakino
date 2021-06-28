<style media="screen">
  @import url("https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;700;900&display=swap");

  .al-container * {
    font-family: 'Nunito' !important;
  }

  .al-container {
    width: 500px;
    min-height: 700px;
    background: rgba(225, 225, 225);
    margin: 0 auto;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
  }

  .al-container header {
    background: rgba(10, 10, 10, 0.9);
    box-shadow: 0 0 6px #00000029;
  }

  .al-container header img {
    max-width: 300px;
    display: block;
    margin: 0px auto;
    padding: 25px 0;
  }

  .al-container main {
    text-align: center;
  }

  .al-container footer {
    background: rgba(10, 10, 10, 0.9);
    box-shadow: 0 0 6px #00000029;
  }

  .al-container footer p {
    color: white;
    font-weight: bold;
    text-align: center;

  }
</style>
<div class="al-container">
  <header>
    <img src="https://prophet061.pl/images/logo_text.svg" alt="Alpakino" title="Alpakino - rozrywka na pełnej...">
  </header>
  <main>
    <h1>Bilety na twój ulubiony film właśnie dotarły!</h1>
    <p>Poniższy kod QR jest Twoim wirtualnym biletem. Okazanie go w momencie wchodzenia na salę kinową jest niezbędne i stanowi jedyną metodę potwierdzenia posiadania biletów.</p>

    <div class="qr"></div>

    <p>Życzymy miłego seansu!</p>
  </main>
  <footer>
    <p>Copyright &copy; Alpakino 2021</p>
  </footer>
</div>
