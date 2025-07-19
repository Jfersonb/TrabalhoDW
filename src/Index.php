<?php
session_start();
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous" />
  <link rel="stylesheet" href="/CSS/Style.css" />
  <title>Vida Serena</title>
</head>

<body>

  <?php
  require $_SERVER['DOCUMENT_ROOT'] . "/PHP/INCLUDES/Menu.php";
  ?>

  <main class="container text-center mt-4">
    <h2 class="fw-bold text-dark">
      Escala dos<br /><span class="fw-bold text-primary">profissionais</span>
    </h2>

    <div class="team-cards mt-4">
      <!-- Card 1 -->
      <div class="card shadow-sm mb-4">
        <img src="https://mighty.tools/mockmind-api/content/human/80.jpg" class="card-img-top rounded"
          alt="Dr. Roberto" />
        <div class="card-body">
          <h5 class="card-title">Dr. Roberto</h5>
          <p class="card-text text-muted">Geriatra</p>
          <span class="badge bg-success">Presente</span>
          <div class="stars mt-2">⭐ ⭐ ⭐ ⭐ ⭐ (102)</div>
        </div>
      </div>

      <!-- Card 2 -->
      <div class="card shadow-sm mb-4">
        <img src="https://mighty.tools/mockmind-api/content/human/102.jpg" class="card-img-top rounded"
          alt="Dr. Carlos" />
        <div class="card-body">
          <h5 class="card-title">Dr. Carlos</h5>
          <p class="card-text text-muted">Médico</p>
          <span class="badge bg-success">Presente</span>
          <div class="stars mt-2">⭐ ⭐ ⭐ ⭐ ⭐ (97)</div>
        </div>
      </div>

      <!-- Card 3 -->
      <div class="card shadow-sm mb-4">
        <img src="https://mighty.tools/mockmind-api/content/human/125.jpg" class="card-img-top rounded"
          alt="Dr. Sandra" />
        <div class="card-body">
          <h5 class="card-title">Dr. Sandra</h5>
          <p class="card-text text-muted">Enfermeira</p>
          <span class="badge bg-success">Presente</span>
          <div class="stars mt-2">⭐ ⭐ ⭐ ⭐ ⭐ (106)</div>
        </div>
      </div>

      <!-- Card 4 -->
      <div class="card shadow-sm mb-4">
        <img src="https://mighty.tools/mockmind-api/content/human/91.jpg" class="card-img-top rounded"
          alt="Dr. Diego" />
        <div class="card-body">
          <h5 class="card-title">Dr. Diego</h5>
          <p class="card-text text-muted">Cuidador</p>
          <span class="badge bg-success">Presente</span>
          <div class="stars mt-2">⭐ ⭐ ⭐ ⭐ ⭐ (72)</div>
        </div>
      </div>
    </div>

    <p class="container text-center text-dark">
      Adicionar depois
    </p>

    <!-- <div class="header-btn">
      <a type="button" class="btn btn-outline-primary d-flex justify-content-center" href="/PHP/Logar.php">Logar</a>
      <a type="button" class="btn btn-outline-secondary d-flex justify-content-center"
        href="/PHP/CadastroUsuario.php">Novo Usuário</a>
    </div> -->

    <?php
    if (isset($_SESSION["logado"]) and $_SESSION["logado"]) {
      ?>
      <div class="header-btn mb-3">
        <a type="button" class="btn btn-outline-primary d-flex justify-content-center" href="/PHP/ListaPacientes.php">Acessar lista de pacientes</a>
      </div>
      <div class="header-btn">
        <a type="button" class="btn btn-outline-primary d-flex justify-content-center" href="/PHP/Logout.php">logout</a>
      </div>
      <?php
    } else {
      ?>
      <div class="header-btn">
        <a type="button" class="btn btn-outline-primary d-flex justify-content-center" href="/PHP/Logar.php">Logar</a>
      </div>
      <?php
    }
    ?>

  </main>

  <footer class="footer">
    <a type="button" class="footer-btn btn btn-outline-secondary d-flex justify-content-center"
      href="/PHP/Informacao.php">Sobre</a>
    <!-- <p class="mb d-flex justify-content-cente">© 2025 Vida Serena. Todos os direitos reservados.</p> -->
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO"
    crossorigin="anonymous"></script>

</body>

</html>