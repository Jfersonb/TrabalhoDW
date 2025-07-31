<?php
require_once 'Logado.php';
require_once 'ConexaoBD.php';

if (!isset($_SESSION['perfil']) || $_SESSION['perfil'] !== 'usuario') {
    header("Location: /PHP/Logar.php");
    exit;
}

$idUsuario = $_SESSION["id"];
$busca = strtolower($_GET['busca'] ?? '');

try {
    if (!empty($busca)) {
        $sql = $conn->prepare("
            SELECT c.*, u.nome AS nomeIdoso
            FROM cadastroIdoso c
            INNER JOIN cadastroUsers u ON c.id_usuario = u.id
            WHERE 
            LOWER(c.responsavel) LIKE :busca
                  OR LOWER(u.nome) LIKE :busca
        ");
        $sql->bindValue(":busca", "%$busca%", PDO::PARAM_STR);
    } else {
        $sql = $conn->prepare("
            SELECT c.*, u.nome AS nomeIdoso
            FROM cadastroIdoso c
            INNER JOIN cadastroUsers u ON c.id_usuario = u.id
        ");
    }

    $sql->execute();
    $pacientes = $sql->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    die("Erro ao buscar pacientes: " . htmlspecialchars($e->getMessage()));
}
?>


<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Lista de Pacientes</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous" />
    <link rel="stylesheet" href="/CSS/ListaPacientes.css" />
    <link rel="stylesheet" href="/CSS/Style.css" />
</head>

<body>

    <?php require $_SERVER['DOCUMENT_ROOT'] . "/PHP/INCLUDES/Menu.php"; ?>

    <main class="container mt-4">
        <h2 class="fw-bold text-dark text-center">Meus Pacientes (Idosos)</h2>

        <form method="GET" class="mb-3">
            <div class="input-group">
                <input type="text" name="busca" class="form-control" placeholder="Buscar por responsável ou idoso..."
                    value="<?= htmlspecialchars($busca) ?>">
                <button class="btn btn-outline-primary" type="submit">Buscar</button>
                <a href="ListaPacientes.php" class="btn btn-outline-secondary">Limpar</a>
            </div>
        </form>

        <?php if (count($pacientes) === 0): ?>
            <div class="alert alert-warning">Nenhum paciente encontrado.</div>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>Nome do Idoso</th>
                            <th>Responsável</th>
                            <th>Condições Médicas</th>
                            <th>Medicamentos em Uso</th>
                            <th>Restrições Alimentares</th>
                            <th>Alergias</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($pacientes as $p): ?>
                            <tr>
                                <td><?= htmlspecialchars($p['nomeIdoso']) ?></td>
                                <td><?= htmlspecialchars($p['responsavel']) ?></td>
                                <td><?= htmlspecialchars($p['condicoesMedicas']) ?></td>
                                <td><?= htmlspecialchars($p['medicamentosUso']) ?></td>
                                <td><?= htmlspecialchars($p['resticoesAlimentar']) ?></td>
                                <td><?= htmlspecialchars($p['alergias']) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>

        <a href="/Index.php" class="btn btn-outline-warning mt-3">Voltar</a>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO"
        crossorigin="anonymous"></script>
</body>

</html>
