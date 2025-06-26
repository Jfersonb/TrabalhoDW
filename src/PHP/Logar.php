<?php
require_once "ConexaoBD.php";
session_start();
if (isset($_POST["email"])) {
  $sql = $conn->prepare("SELECT * FROM cadastroUsers WHERE email=:email");
  $sql->bindValue(":email", $_POST["email"]);
  $sql->execute();
  $User = $sql->fetch();
  if ($User) {
    $Senha = $_POST["password"];
    $hashSenha = hash("sha256", $Senha);
    if ($hashSenha === $User["senha"]) {
      $_SESSION["logado"] = true;
      $_SESSION["id"] = $User["id"];
      $_SESSION["perfil"] = $User["perfil"];
      header("location:/");
    } else {
      header("Location: /PHP/Logar.php?msg=erro");
    }
  } else {
    header("Location: /PHP/Logar.php?msg=erro");
  }

}


?>


<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous" />
  <link rel="stylesheet" href="/CSS/Logar.css" />
  <title>Logar</title>
</head>

<body>
  <?php
  require $_SERVER['DOCUMENT_ROOT'] . "/PHP/INCLUDES/Menu.php";
  ?>
  <main class="container mt-4">
    <!-- <div class="div-form-selet">
      <select class="form-select" id="userType" aria-label="Default select example">
        <option value="0" selected>Selecione seu tipo de usuário</option>
        <option value="1">Familiar</option>
        <option value="2">Cuidador(a)</option>
        <option value="3">Infermeiro(a)</option>
        <option value="4">Médico(a)</option>
        <option value="5">Admin</option>
      </select>
    </div> -->

    <form id="loginForm" method="post" action="/PHP/Logar.php">
      <div class="form-group">
        <label for="exampleInputEmail1">E-mail</label>
        <input type="email" class="form-control" id="exampleInputEmail1" required name="email"
          aria-describedby="emailHelp" placeholder="Informe seu e-mail cadastrado" />

      </div>

      <div class="form-group">
        <label for="exampleInputPassword1">Senha</label>
        <input type="password" class="form-control" id="exampleInputPassword1" required name="password"
          placeholder="Senha" />
      </div>

      <div class="form-check">
        <input type="checkbox" class="form-check-input" id="exampleCheck1" />
        <label class="form-check-label" for="exampleCheck1">Verificar</label>
      </div>

      <div class="header-btn">
        <div class="div-button d-flex justify-content-center">
          <button type="submit" class="btn btn-outline-primary">Logar</button>
        </div>
        <div class="div-button d-flex justify-content-center">
          <a type="submit" class="btn btn-outline-danger" href="/PHP/ResetSenha.php">Esqueci minha senha</a>
        </div>
        <div class="div-button d-flex justify-content-center">
          <a type="button" class="btn btn-outline-warning" href="/Index.php">Voltar</a>
        </div>
      </div>

  </main>
  </form>
  <footer class="footer"></footer>


  <script>
    // Mostrar ou ocultar a senha
    document.getElementById('exampleCheck1').addEventListener('change', function () {
      const senhaInput = document.getElementById('exampleInputPassword1');
      senhaInput.type = this.checked ? 'text' : 'password';
    });
  </script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO"
    crossorigin="anonymous"></script>
</body>

</html>