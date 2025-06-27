<?php
require_once "ConexaoBD.php";
session_start();
//Varifica se logado
if (isset($_SESSION["logado"]) && $_SESSION["logado"]) {
    header("Location: /Index.php"); // ou outro destino apropriado
    exit;
}

error_reporting(E_ALL);
ini_set('display_errors', 1);

$mensagemErro = "";



if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["email"], $_POST["password"])) {
    $email = trim($_POST["email"]);
    $senhaDigitada = $_POST["password"];

    try {
        $sql = $conn->prepare("SELECT * FROM cadastroUsers WHERE email = :email");
        $sql->bindValue(":email", $email);
        $sql->execute();

        $User = $sql->fetch(PDO::FETCH_ASSOC);

        if ($User) {
            // Verificar a senha usando SHA2
            $senhaDigitadaHash = hash("sha256", $senhaDigitada);

            if ($senhaDigitadaHash === $User["senha"]) {
                $_SESSION["logado"] = true;
                $_SESSION["id"] = $User["id"];
                $_SESSION["perfil"] = $User["perfil"];
                header("Location: /");
                exit;
            } else {
                $mensagemErro = "Usuário ou senha incorreto!!";
            }
        } else {
            $mensagemErro = "Usuário ou senha incorreto!!";
        }
    } catch (PDOException $e) {
        $mensagemErro = "Erro de banco de dados: " . $e->getMessage();
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
    <?php require $_SERVER['DOCUMENT_ROOT'] . "/PHP/INCLUDES/Menu.php"; ?>

    <main class="container mt-4">
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
                <label class="form-check-label" for="exampleCheck1">Mostrar senha</label>
            </div>

            <?php if (!empty($mensagemErro)): ?>
                <div class="alert alert-danger mt-3">
                    <?= htmlspecialchars($mensagemErro) ?>
                </div>
            <?php endif; ?>

            <div class="header-btn">
                <div class="div-button d-flex justify-content-center mt-3">
                    <?php if (isset($_SESSION["logado"]) && $_SESSION["logado"]): ?>
                        <form method="post" action="/PHP/Logout.php">
                            <button type="submit" class="btn btn-outline-danger">Logout</button>
                        </form>
                    <?php else: ?>
                        <form method="post" action="/PHP/Logar.php">
                            <button type="submit" class="btn btn-outline-primary">Logar</button>
                        </form>
                    <?php endif; ?>
                </div>
            </div>


            <div class="div-button d-flex justify-content-center mt-2">
                <a class="btn btn-outline-danger" href="/PHP/ResetSenha.php">Esqueci minha senha</a>
            </div>
            <div class="div-button d-flex justify-content-center mt-2">
                <a class="btn btn-outline-warning" href="/Index.php">Voltar</a>
            </div>
            </div>
        </form>
    </main>

    <footer class="footer mt-5"></footer>

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