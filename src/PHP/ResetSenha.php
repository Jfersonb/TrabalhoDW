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
  <header>
    <nav class="navbar navbar-expand-lg-1 text-center bg-body-tertiary">
      <div class="container-fluid">
        <a class="navbar-brand" href="/Index.html">Vida Serena</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
          aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li class="nav-item">
              <a class="nav-link" href="/Index.html">Página principal</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="/PHP/Logar.php">Logar</a>
            </li>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                aria-expanded="false">Cadastros</a>
              <ul class="dropdown-menu text-center">
                <li><a class="dropdown-item" href="/PHP/CadastroUsuario.php">Novo Usuário</a></li>
                <li><a class="dropdown-item" href="/PHP/CadastroMedicamentos.php">Cadastro Medicamentos</a></li>
                <!-- <li>
                  <hr class="dropdown-divider" />
                </li> -->
                <!-- <li>
                  <a class="dropdown-item" href="#">Sem atribuição</a>
                </li> -->
              </ul>
            </li>
            <!-- <li class="nav-item">
              <a class="nav-link disabled" aria-disabled="true">Disabled</a>
            </li> -->
            <li class="nav-item">
              <a class="nav-link" href="/HTML/Informacao.html">Sobre o sistema</a>
            </li>
          </ul>
        </div>
      </div>
    </nav>
  </header>

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
          <a type="button" class="btn btn-outline-warning" href="/HTML/Logar.html">Voltar</a>
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