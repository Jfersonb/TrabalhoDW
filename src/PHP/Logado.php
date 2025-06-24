<?php
session_start();
if(! (isset($_SESSION["logado"]) and $_SESSION["logado"])){
header("Location:/");
}
