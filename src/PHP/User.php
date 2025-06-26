<?php
// require_once "ConexaoBD.php";

session_start();
require_once 'Logado.php';

// Verifica se está logado como "usuario"
if($_SESSION['perfil'] != "usuario"){
    header("Location:/");
}
?>