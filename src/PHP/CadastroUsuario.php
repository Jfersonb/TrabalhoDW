<?php
//Validar se logado
require_once 'Logado.php';

// Só processa o formulário se for uma requisição POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once 'ConexaoBD.php';
    // Função para limpar máscara de CPF e telefone
    function limparMascara($str)
    {
        return preg_replace('/\D/', '', $str ?? '');
    }

    // Dados comuns
    $tipo_usuario = $_POST['userType'] ?? '';
    $nome = $_POST['nomeCompleto'] ?? '';
    $cpf = limparMascara($_POST['cpf'] ?? '');
    $telefone = limparMascara($_POST['telefone'] ?? '');
    $email = $_POST['email'] ?? '';
    $senha = password_hash($_POST['senha1'] ?? '', PASSWORD_DEFAULT);

    // Verificação do upload
    if (!isset($_FILES['arquivo']) || $_FILES['arquivo']['error'] !== UPLOAD_ERR_OK) {
        die("Erro ao enviar o arquivo.");
    }

    // Verifica a extensão do arquivo
    $extensao = pathinfo($_FILES['arquivo']['name'], PATHINFO_EXTENSION);
    $permitidos = ['pdf', 'jpg', 'jpeg', 'png'];
    if (!in_array(strtolower($extensao), $permitidos)) {
        die("Tipo de arquivo não permitido. Envie apenas PDF, JPG, JPEG ou PNG.");
    }

    // Verifica o tamanho do arquivo (2MB = 2 * 1024 * 1024 bytes)
    $tamanhoMaximo = 2 * 1024 * 1024;
    if ($_FILES['arquivo']['size'] > $tamanhoMaximo) {
        die("Arquivo muito grande. O tamanho máximo permitido é 2MB.");
    }

    // Carrega o conteúdo do arquivo (após validar)
    $arquivo = file_get_contents($_FILES['arquivo']['tmp_name']);

    try {
        // 1. Inserção na tabela principal
        $sqlUser = "INSERT INTO cadastroUsers (nome, cpf, telefone, email, senha, arquivo) VALUES (?, ?, ?, ?, ?, ?)";
        $stmtUser = $conn->prepare($sqlUser);
        $stmtUser->bindParam(1, $nome, PDO::PARAM_STR);
        $stmtUser->bindParam(2, $cpf, PDO::PARAM_STR);
        $stmtUser->bindParam(3, $telefone, PDO::PARAM_STR);
        $stmtUser->bindParam(4, $email, PDO::PARAM_STR);
        $stmtUser->bindParam(5, $senha, PDO::PARAM_STR);
        $stmtUser->bindParam(6, $arquivo, PDO::PARAM_LOB);

        if (!$stmtUser->execute()) {
            throw new Exception("Erro ao cadastrar usuário");
        }

        $id_usuario = $conn->lastInsertId(); // ID para usar nas tabelas específicas

        // 2. Inserção conforme tipo de usuário
        switch ($tipo_usuario) {
            case "1": // Familiar
                $parentesco = $_POST['tipoParentesco'] ?? '';
                $endereco = $_POST['endereco'] ?? '';
                $sql = "INSERT INTO cadastroFamilia (id_usuario, tipoParentesco, endereco) VALUES (?, ?, ?)";
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(1, $id_usuario, PDO::PARAM_INT);
                $stmt->bindParam(2, $parentesco, PDO::PARAM_STR);
                $stmt->bindParam(3, $endereco, PDO::PARAM_STR);
                break;

            case "2": // Cuidador
                $cursos = $_POST['cursos'] ?? '';
                $sql = "INSERT INTO cadastroCuidador (id_usuario, cursos) VALUES (?, ?)";
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(1, $id_usuario, PDO::PARAM_INT);
                $stmt->bindParam(2, $cursos, PDO::PARAM_STR);
                break;

            case "3": // Enfermeiro
                $coren = $_POST['coren'] ?? '';
                $cip = $_POST['cip'] ?? '';
                $sql = "INSERT INTO cadastroEnfermeiro (id_usuario, coren, cip) VALUES (?, ?, ?)";
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(1, $id_usuario, PDO::PARAM_INT);
                $stmt->bindParam(2, $coren, PDO::PARAM_STR);
                $stmt->bindParam(3, $cip, PDO::PARAM_STR);
                break;

            case "4": // Médico
                $crm = $_POST['crm'] ?? '';
                $sql = "INSERT INTO cadastroMedico (id_usuario, crm) VALUES (?, ?)";
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(1, $id_usuario, PDO::PARAM_INT);
                $stmt->bindParam(2, $crm, PDO::PARAM_STR);
                break;

            case "5": // Idoso
                $responsavel = $_POST['responsavelLegal'] ?? '';
                $condicao = $_POST['condicaoMedicaImportante'] ?? '';
                $medicamentos = $_POST['medicamentosUso'] ?? '';
                $restricao = $_POST['resticaoAlimentar'] ?? '';
                $alergias = $_POST['alergias'] ?? '';
                $sql = "INSERT INTO cadastroIdoso (id_usuario, responsavel, condicoesMedicas, medicamentosUso, resticoesAlimentar, alergias) VALUES (?, ?, ?, ?, ?, ?)";
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(1, $id_usuario, PDO::PARAM_INT);
                $stmt->bindParam(2, $responsavel, PDO::PARAM_STR);
                $stmt->bindParam(3, $condicao, PDO::PARAM_STR);
                $stmt->bindParam(4, $medicamentos, PDO::PARAM_STR);
                $stmt->bindParam(5, $restricao, PDO::PARAM_STR);
                $stmt->bindParam(6, $alergias, PDO::PARAM_STR);
                break;

            default:
                throw new Exception("Tipo de usuário inválido.");
        }

        if ($stmt->execute()) {
            echo "<script>alert('Cadastro realizado com sucesso!'); window.location.href = '/Index.html';</script>";
        } else {
            throw new Exception("Erro ao inserir dados específicos");
        }

    } catch (Exception $e) {
        echo "Erro: " . $e->getMessage();
    } finally {
        $conn = null; // Fecha a conexão PDO
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="CSS/Cadastro.css" />
  <title>Cadastro Usuário</title>
</head>

<body>
<?php
require $_SERVER['DOCUMENT_ROOT'] . "/PHP/INCLUDES/Menu.php";
?>

  <main class="container mt-4">
    <form id="loginForm" action="CadastroUsuario.php" method="POST" enctype="multipart/form-data">
      <div class="div-form-selet mb-3">
        <select class="form-select" id="userType" name="userType" required>
          <option value="0" selected>Selecione seu tipo de usuário</option>
          <option value="1">Familiar</option>
          <option value="2">Cuidador(a)</option>
          <option value="3">Enfermeiro(a)</option>
          <option value="4">Médico(a)</option>
          <option value="5">Idoso</option>
        </select>
      </div>
      <div class="form-group mb-3">
        <label for="exampleInputtxt">Nome</label>
        <input type="text" id="nomeCompleto" name="nomeCompleto" class="form-control"
          placeholder="Informe seu nome completo" required />
      </div>

      <div class="form-group mb-3">
        <label for="exampleInputtxt">CPF</label>
        <input type="text" id="cpf" name="cpf" class="form-control" placeholder="000.000.000-00"
          oninput="aplicarMascaraCPF(this)" required />
      </div>

      <div class="form-group mb-3">
        <label for="exampleInputtxt">Telefone</label>
        <input type="text" id="telefone" name="telefone" class="form-control" placeholder="(99) 99999-9999"
          oninput="aplicarMascaraTelefone(this)" required />
      </div>

      <div class="form-group mb-3">
        <label for="exampleInputEmail1">E-mail</label>
        <input type="email" id="email" name="email" class="form-control" placeholder="Informe seu e-mail" required />
      </div>

      <div class="d-none" id="dadosEnfermeiro">
        <h4>Dados obrigatórios do Enfermeiro</h4>
        <div class="form-group mb-3">
          <label for="exampleInputtxt">COREN</label>
          <input type="text" id="coren" name="coren" class="form-control" placeholder="Informe seu COREN" />
        </div>
        <div class="form-group mb-3">
          <label for="exampleInputtxt">CIP</label>
          <input type="text" id="cip" name="cip" class="form-control" placeholder="Informe seu CIP" />
        </div>
      </div>

      <div class="d-none" id="dadosFamiliar">
        <h4>Dados obrigatórios do Familiar</h4>
        <div class="form-group mb-3">
          <label for="exampleInputtxt">Tipo de parentesco</label>
          <input type="text" id="tipoParentesco" name="tipoParentesco" class="form-control"
            placeholder="Informe seu parentesco" />
        </div>
        <div class="form-group mb-3">
          <label for="exampleInputtxt">Endereço</label>
          <input type="text" id="endereco" name="endereco" class="form-control" placeholder="Informe seu endereço" />
        </div>
      </div>

      <div class="d-none" id="dadosCuidador">
        <h4>Dados obrigatórios do Cuidador</h4>
        <div class="form-group mb-3">
          <label for="exampleInputtxt">Cursos</label>
          <input type="text" id="cursos" name="cursos" class="form-control"
            placeholder="Informe cursos realizados caso tenha" />
        </div>
      </div>

      <div class="d-none" id="dadosMedico">
        <h4>Dados obrigatórios do Médico</h4>
        <div class="form-group mb-3">
          <label for="exampleInputtxt">CRM</label>
          <input type="text" id="crm" name="crm" class="form-control" placeholder="Informe seu CRM" />
        </div>
      </div>

      <div class="d-none" id="dadosIdoso">
        <h4>Dados obrigatórios do Idoso</h4>
        <div class="form-group mb-3">
          <label for="exampleInputtxt">Responsável legal</label>
          <input type="text" id="responsavelLegal" name="responsavelLegal" class="form-control"
            placeholder="Informe o nome do responsável legal" />
        </div>
        <div class="form-group mb-3">
          <label for="exampleInputtxt">Condições médicas importantes</label>
          <input type="text" id="condicaoMedicaImportante" name="condicaoMedicaImportante" class="form-control"
            placeholder="Informe as condições médicas importantes" />
        </div>
        <div class="form-group mb-3">
          <label for="exampleInputtxt">Medicamentos de uso</label>
          <input type="text" id="medicamentosUso" name="medicamentosUso" class="form-control"
            placeholder="Informe os medicamentos de uso do idoso" />
        </div>
        <div class="form-group mb-3">
          <label for="exampleInputtxt">Restrições alimentar</label>
          <input type="text" id="resticaoAlimentar" name="resticaoAlimentar" class="form-control"
            placeholder="Informe as restições alimentares" />
        </div>
        <div class="form-group mb-3">
          <label for="exampleInputtxt">Alergias</label>
          <input type="text" id="alergias" name="alergias" class="form-control"
            placeholder="Informe as alergias dos idoso" />
        </div>
      </div>

      <div class="form-group mb-3">
        <label for="inputPassword1">Senha</label>
        <input type="password" id="senha1" name="senha1" class="form-control" placeholder="Crie uma senha" required />
      </div>

      <div class="form-group mb-3">
        <label for="inputPassword2">Repita a Senha</label>
        <input type="password" id="senha2" name="senha2" class="form-control" placeholder="Repita a senha" required />
      </div>

      <div id="passwordHelpBlock" class="form-text mb-3">
        Sua senha deve ter pelo menos 8 caracteres.
      </div>

      <div class="form-check mb-3">
        <input type="checkbox" class="form-check-input" id="showPassword" />
        <label class="form-check-label" for="showPassword">Mostrar senha</label>
      </div>

      <div class="input mb-3">
        <input type="file" class="form-control" id="arquivo" name="arquivo" accept=".pdf,.jpg,.jpeg,.png" required />
      </div>
      <p>Selecione um arquivo para comprovação</p>

      <div class="header-btn">
        <button type="submit" class="btn btn-outline-primary">
          Solicitar
        </button>
        <a class="btn btn-outline-warning" href="/Index.html">Voltar</a>
      </div>
    </form>
  </main>

  <script>
    function aplicarMascaraTelefone(input) {
      input.value = input.value
        .replace(/\D/g, "")
        .replace(/^(\d{2})(\d)/, "($1) $2")
        .replace(/(\d{5})(\d)/, "$1-$2")
        .replace(/(-\d{4})\d+?$/, "$1");
    }

    function aplicarMascaraCPF(input) {
      input.value = input.value
        .replace(/\D/g, "")
        .replace(/(\d{3})(\d)/, "$1.$2")
        .replace(/(\d{3})(\d)/, "$1.$2")
        .replace(/(\d{3})(\d{1,2})$/, "$1-$2");
    }
  </script>

  <script>
    let selectType = document.getElementById("userType");

    selectType.onchange = function () {
      //Escondo todos os opcionais
      document.getElementById("dadosFamiliar").classList.add("d-none");
      document.getElementById("dadosCuidador").classList.add("d-none");
      document.getElementById("dadosEnfermeiro").classList.add("d-none");
      document.getElementById("dadosMedico").classList.add("d-none");
      document.getElementById("dadosIdoso").classList.add("d-none");

      const type = parseInt(this.value);

      switch (type) {
        case 1:
          //Exibo o bloco de dados do familiar
          document.getElementById("dadosFamiliar").classList.remove("d-none");
          break;

        case 2:
          //Exibo o bloco de dados do cuidador
          document.getElementById("dadosCuidador").classList.remove("d-none");
          break;
        case 3:
          //Exibo o bloco de dados do enfermeiro
          document
            .getElementById("dadosEnfermeiro")
            .classList.remove("d-none");
          break;
        case 4:
          //Exibo o bloco de dados do médico
          document.getElementById("dadosMedico").classList.remove("d-none");
          break;
        case 5:
          //Exibo o bloco de dados do idoso
          document.getElementById("dadosIdoso").classList.remove("d-none");
          break;

        default:
          console.log(type, typeof type);
      }
    };

    // Mostrar ou ocultar senha
    document
      .getElementById("showPassword")
      .addEventListener("change", function () {
        const senha1 = document.getElementById("senha1");
        const senha2 = document.getElementById("senha2");
        const type = this.checked ? "text" : "password";
        senha1.type = type;
        senha2.type = type;
      });

    // Validação do formulário
    document.getElementById("loginForm").onsubmit = function (e) {
      e.preventDefault();

      const userType = document.getElementById("userType").value;
      const nome = document.getElementById("nomeCompleto").value.trim();
      const cpf = document.getElementById("cpf").value.trim();
      const telefone = document.getElementById("telefone").value.trim();
      const email = document.getElementById("email").value.trim();
      const senha1 = document.getElementById("senha1").value;
      const senha2 = document.getElementById("senha2").value;
      const arquivo = document.getElementById("arquivo").files[0];

      if (userType === "0") {
        alert("Por favor, selecione o tipo de usuário.");
        return;
      }

      if (
        !userType ||
        !nome ||
        !cpf ||
        !telefone ||
        !email ||
        !senha1 ||
        !senha2 ||
        !arquivo
      ) {
        alert("Todos os campos são obrigatórios.");
        return;
      }

      if (senha1 !== senha2) {
        alert("As senhas não coincidem.");
        return;
      }

      if (senha1.length < 8) {
        alert("A senha deve conter no mínimo 8 caracteres.");
        return;
      }

      // Validar campos específicos baseado no tipo de usuário
      const type = parseInt(userType);
      let camposEspecificos = true;
      
      switch (type) {
        case 1: // Familiar
          if (!document.getElementById("tipoParentesco").value.trim() || 
              !document.getElementById("endereco").value.trim()) {
            alert("Por favor, preencha todos os campos obrigatórios do Familiar.");
            camposEspecificos = false;
          }
          break;
        case 2: // Cuidador
          if (!document.getElementById("cursos").value.trim()) {
            alert("Por favor, preencha o campo de cursos do Cuidador.");
            camposEspecificos = false;
          }
          break;
        case 3: // Enfermeiro
          if (!document.getElementById("coren").value.trim() || 
              !document.getElementById("cip").value.trim()) {
            alert("Por favor, preencha todos os campos obrigatórios do Enfermeiro.");
            camposEspecificos = false;
          }
          break;
        case 4: // Médico
          if (!document.getElementById("crm").value.trim()) {
            alert("Por favor, preencha o campo CRM do Médico.");
            camposEspecificos = false;
          }
          break;
        case 5: // Idoso
          if (!document.getElementById("responsavelLegal").value.trim() || 
              !document.getElementById("condicaoMedicaImportante").value.trim() ||
              !document.getElementById("medicamentosUso").value.trim() ||
              !document.getElementById("resticaoAlimentar").value.trim() ||
              !document.getElementById("alergias").value.trim()) {
            alert("Por favor, preencha todos os campos obrigatórios do Idoso.");
            camposEspecificos = false;
          }
          break;
      }

      if (camposEspecificos) {
        this.submit();
      }
    };
  </script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO"
    crossorigin="anonymous"></script>
</body>

</html>