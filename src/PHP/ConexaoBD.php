<?php
/**
 * Arquivo de conexão com o banco de dados
 * Configuração centralizada para reutilização em outros arquivos
 */

// Configurações do banco de dados
define('DB_HOST', 'db');
define('DB_PORT', '3306');
define('DB_NAME', 'vidaSerena');
define('DB_USER', 'root');
define('DB_PASS', 'root');

function getConnection() {
    try {
        // Cria a conexão PDO
        $dsn = "mysql:host=" . DB_HOST . ";port=" . DB_PORT . ";dbname=" . DB_NAME . ";charset=utf8mb4";
        $conn = new PDO($dsn, DB_USER, DB_PASS);
        
        // Configura o PDO para lançar exceções em caso de erro
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        // Configura o modo de fetch padrão
        $conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        
        return $conn;
        
    } catch(PDOException $e) {
        error_log("Erro na conexão com o banco de dados: " . $e->getMessage());
        die("Erro na conexão com o banco de dados. Tente novamente mais tarde.");
    }
}

// Para compatibilidade com códigos antigos, mantém a variável $conn
$conn = getConnection();
?>