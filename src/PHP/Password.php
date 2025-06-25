<?php
session_start();

$senha = 'senha123';
$senhaHash = password_hash($senha, PASSWORD_DEFAULT);

// Exemplo de uso com MySQLi
$sql = "INSERT INTO cadastroUsers (nome, cpf, telefone, email, senha, perfil) VALUES (?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssssss", $nome, $cpf, $telefone, $email, $senhaHash, $perfil);
$stmt->execute();