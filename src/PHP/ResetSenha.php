<?php
require_once "ConexaoBD.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $novaSenhaPadrao = '123senha';

    // Verifica se o e-mail existe
    $sql = $conn->prepare("SELECT id FROM cadastroUsers WHERE email = :email");
    $sql->bindValue(":email", $email);
    $sql->execute();
    $usuario = $sql->fetch();

    if ($usuario) {
        // Atualiza a senha fixa como SHA2
        $update = $conn->prepare("UPDATE cadastroUsers SET senha = SHA2(:senha, 256) WHERE email = :email");
        $update->bindValue(":senha", $novaSenhaPadrao);
        $update->bindValue(":email", $email);
        if ($update->execute()) {
            echo "Senha redefinida com sucesso para: 123senha";
        } else {
            echo "Erro ao redefinir a senha.";
        }
    } else {
        echo "E-mail não encontrado.";
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
    <div class="div-form-selet">
      <select class="form-select" id="userType" aria-label="Default select example">

        <option selected>Selecione seu tipo de usuário</option>
        <option value="1">Familiar</option>
        <option value="2">Cuidador(a)</option>
        <option value="3">Infermeiro(a)</option>
        <option value="4">Médico(a)</option>
        <option value="5">Admin</option>
      </select>
    </div>

    <form id="resetForm">
      <div class="form-group">
        <label for="exampleInputEmail1">E-mail</label>
        <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp"
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
      e.preventDefault(); // Impede envio do formulário

      const userTypeSelect = document.getElementById("userType");
      const emailInput = document.getElementById("exampleInputEmail1");

      const userType = userTypeSelect.value;
      const userText = userTypeSelect.options[userTypeSelect.selectedIndex].text;
      const email = emailInput.value.trim();

      if (userType === "0" || userTypeSelect.selectedIndex === 0) {
        alert("Por favor, selecione o tipo de usuário.");
      } else if (email === "") {
        alert("Por favor, digite seu e-mail.");
      } else {
        alert(`Uma nova senha será enviada para o e-mail: ${email} como ${userText}.`);
        this.reset(); // Limpa os campos
      }
    });
  </script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO"
    crossorigin="anonymous"></script>

</body>

</html>