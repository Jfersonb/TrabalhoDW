<?php
function conectarBanco() {
    $host = "localhost";        // Ou IP do servidor (ex: 127.0.0.1)
    $usuario = "root";          // Usuário do banco de dados
    $senha = "";                // Senha do banco 
    $banco = "vidaserena";      // Nome do banco de dados

    // Criando a conexão
    $conn = new mysqli($host, $usuario, $senha, $banco);

    // Verificando erros
    if ($conn->connect_error) {
        die("Erro na conexão: " . $conn->connect_error);
    }

    return $conn; // Retorna o objeto de conexão
}
?>
