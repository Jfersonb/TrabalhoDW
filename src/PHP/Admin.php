<?php
// require_once "ConexaoBD.php";
session_start();
require_once 'Logado.php';

//Validar se logado com admin
if($_SESSION['perfil'] != "admin"){
    header("Location:/");
}
?>