<?php
// require_once "ConexaoBD.php";
//Validar se logado
require_once 'Logado.php';

if($_SESSION['perfil'] != "admin"){
    header("Location:/");
}
?>