<?php
require_once "ConexaoBD.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $novaSenhaPadrao = '123senha';
    $hashSenha = password_hash($novaSenhaPadrao, PASSWORD_DEFAULT);

    // Verifica se o e-mail existe
    $sql = $conn->prepare("SELECT id FROM cadastroUsers WHERE email = :email");
    $sql->bindValue(":email", $email);
    $sql->execute();
    $usuario = $sql->fetch();


    if ($usuario) {
        // Atualiza a senha fixa como criptografia
        $update = $conn->prepare("UPDATE cadastroUsers SET senha = :senha WHERE email = :email");
        $update->bindValue(":senha", $hashSenha);
        $update->bindValue(":email", $email);
        if ($update->execute()) {
            header("Location: /PHP/Logar.php?msg=sucesso");
            exit;
        } else {
            header("Location: /PHP/Logar.php?msg=erro");
            exit;
        }
    } else {
        header("Location: /PHP/Logar.php?msg=erro");
        exit;
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
  <link rel="stylesheet" href="/CSS/ReserSenha.css" />
  <title>Esqueci a senha</title>
</head>

<body>
  <?php
  require $_SERVER['DOCUMENT_ROOT'] . "/PHP/INCLUDES/Menu.php";
  ?>

  <main class="container mt-4">
    <form id="resetForm" method="post" action="">
      <div class="form-group">
        <label for="exampleInputEmail1">E-mail</label>
        <input type="email" name="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp"
          placeholder="Informe seu e-mail cadastrado" />

      </div>

      <div class="div-button d-flex justify-content-center">
        <button type="submit" class="btn btn-outline-primary">
          Solicitar nova Senha</button>
      </div>


      <div class="div-button d-flex justify-content-center">
        <a type="button" class="btn btn-outline-warning" href="/PHP/Logar.php">Voltar</a>
      </div>
  </main>

  <footer></footer>


  <script>
    document.getElementById("resetForm").addEventListener("submit", function (e) {

      const emailInput = document.getElementById("exampleInputEmail1");
      const email = emailInput.value.trim();

      if (email === "") {
        e.preventDefault();
        alert("Por favor, digite seu e-mail.");
      } 
      
    });
  </script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO"
    crossorigin="anonymous"></script>

</body>

</html>