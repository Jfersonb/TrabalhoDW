<?php
session_start();
require_once "ConexaoBD.php";

// Validação do método
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Verifica se usuário está logado
  if (!isset($_SESSION['id'])) {
    die("Usuário não autenticado.");
  }

  $idUsuario = $_SESSION['id'];

  // Coleta os dados do formulário
  $nome = $_POST['nomeMedicamento'] ?? '';
  $tipo = $_POST['tipoMedicamento'] ?? '';
  $quantidadeCaixas = (int) ($_POST['quantidadeCaixas'] ?? 0);
  $quantidadePorCaixa = (int) ($_POST['quantidadePorCaixa'] ?? 0);

  // Verifica se o arquivo foi enviado
  if (!isset($_FILES['notaFiscal']) || $_FILES['notaFiscal']['error'] !== UPLOAD_ERR_OK) {
    die("Erro ao enviar a nota fiscal.");
  }

  // Validação do tipo de arquivo
  $permitidos = ['application/pdf', 'image/jpeg', 'image/png'];
  $tipoArquivo = mime_content_type($_FILES['notaFiscal']['tmp_name']);
  if (!in_array($tipoArquivo, $permitidos)) {
    die("Tipo de arquivo não permitido. Apenas PDF, JPG e PNG são aceitos.");
  }

  // Processa o arquivo
  $notaFiscal = file_get_contents($_FILES['notaFiscal']['tmp_name']);

  // Insere no banco de dados
  try {
    $sql = $conn->prepare("INSERT INTO cadastroMedicamentos 
        (id_usuario, nomeMedicamento, tipoMedicamento, quantDeCaixa, quantPorCaixa, notaFiscal) 
        VALUES (:idUsuario, :nome, :tipo, :qtdCaixas, :qtdPorCaixa, :nota)");

    $sql->bindValue(":idUsuario", $idUsuario, PDO::PARAM_INT);
    $sql->bindValue(":nome", $nome);
    $sql->bindValue(":tipo", $tipo);
    $sql->bindValue(":qtdCaixas", $quantidadeCaixas, PDO::PARAM_INT);
    $sql->bindValue(":qtdPorCaixa", $quantidadePorCaixa, PDO::PARAM_INT);
    $sql->bindValue(":nota", $notaFiscal, PDO::PARAM_LOB);

    $sql->execute();

    header("Location: /PHP/CadastroMedicamentos.php?msg=sucesso");
    exit;

  } catch (PDOException $e) {
    error_log("Erro ao cadastrar medicamento: " . $e->getMessage());
    header("Location: /PHP/CadastroMedicamentos.php?msg=erro");
    exit;
  }
}
?>



<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="/CSS/CadastroMedicamentos.css" />
  <title>Cadastro Medicamentos</title>
</head>

<body>
  <?php
  require $_SERVER['DOCUMENT_ROOT'] . "/PHP/INCLUDES/Menu.php";

  if (isset($_GET['msg'])) {
    if ($_GET['msg'] === 'sucesso') {
      echo "<script>alert('Medicamento cadastrado com sucesso!');</script>";
    } elseif ($_GET['msg'] === 'erro') {
      echo "<script>alert('Erro ao cadastrar medicamento.');</script>";
    }
  }
  ?>

  <main class="container mt-4">
    <h2>Cadastro de Medicamentos</h2>
    <form id="formMedicamento" method="POST" action="" enctype="multipart/form-data">
      <div class="mb-3">
        <label for="nomeMedicamento" class="form-label">Nome do Medicamento</label>
        <input type="text" name="nomeMedicamento" class="form-control" id="nomeMedicamento" required />
      </div>

      <div class="mb-3">
        <label class="form-label">Tipo de Medicamento</label>
        <div class="form-check">
          <input class="form-check-input tipo-medicamento" type="checkbox" id="semTarja" name="tipoMedicamento"
            value="Sem tarja" />
          <label class="form-check-label" for="semTarja">Sem tarja</label>
        </div>
        <div class="form-check">
          <input class="form-check-input tipo-medicamento" type="checkbox" id="tarjaAmarela" name="tipoMedicamento"
            value="Tarja amarela" />
          <label class="form-check-label" for="tarjaAmarela">Tarja amarela</label>
        </div>
        <div class="form-check">
          <input class="form-check-input tipo-medicamento" type="checkbox" id="tarjaVermelha" name="tipoMedicamento"
            value="Tarja vermelha" />
          <label class="form-check-label" for="tarjaVermelha">Tarja vermelha</label>
        </div>
        <div class="form-check">
          <input class="form-check-input tipo-medicamento" type="checkbox" id="tarjaPreta" name="tipoMedicamento"
            value="Tarja preta" />
          <label class="form-check-label" for="tarjaPreta">Tarja preta</label>
        </div>
      </div>

      <div class="mb-3">
        <label for="quantidadeCaixas" class="form-label">Quantidade de caixas</label>
        <input type="number" name="quantidadeCaixas" class="form-control" id="quantidadeCaixas" min="1" required />
      </div>

      <div class="mb-3">
        <label for="quantidadePorCaixa" class="form-label">Quantidade por caixa</label>
        <input type="number" name="quantidadePorCaixa" class="form-control" id="quantidadePorCaixa" min="1" required />
      </div>

      <div class="input mb-3">
        <input type="file" name="notaFiscal" class="form-control" id="inputGroupFile02" accept=".pdf,.jpg,.jpeg,.png"
          required />
      </div>
      <p>Selecione a nota fiscal de compra</p>
      <div class="header-btn">
        <button type="submit" class="btn btn-outline-primary">
          Solicitar cadastramento
        </button>
        <a class="btn btn-outline-warning" href="/Index.php">Voltar</a>
      </div>
    </form>
  </main>

  <script>
    // Permitir apenas uma checkbox marcada
    const checkboxes = document.querySelectorAll(".tipo-medicamento");

    checkboxes.forEach((checkbox) => {
      checkbox.addEventListener("change", function () {
        if (this.checked) {
          checkboxes.forEach((cb) => {
            if (cb !== this) cb.checked = false;
          });
        }
      });
    });

    // Envio do formulário
    document.getElementById("formMedicamento").onsubmit = function (e) {
      const nome = document.getElementById("nomeMedicamento").value.trim();
      const tipoSelecionado = Array.from(checkboxes).find((cb) => cb.checked);
      const qtdCaixas = document.getElementById("quantidadeCaixas").value.trim();
      const qtdPorCaixa = document.getElementById("quantidadePorCaixa").value.trim();
      const notaFiscal = document.getElementById("inputGroupFile02").files[0];

      if (!nome || !tipoSelecionado || !qtdCaixas || !qtdPorCaixa || !notaFiscal) {
        e.preventDefault(); // impede envio só se estiver incompleto
        alert("Por favor, preencha todos os campos e selecione o tipo de medicamento.");
      }
    };
  </script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO"
    crossorigin="anonymous"></script>
</body>

</html>