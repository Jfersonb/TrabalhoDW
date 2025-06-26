<?php
//inicia a sessão
session_start();

//valida se logado
if(! (isset($_SESSION["logado"]) and $_SESSION["logado"])){
header("Location:/");
}
