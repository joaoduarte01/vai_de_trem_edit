<?php
// Configuração de conexão com o banco de dados local (XAMPP)
$DB_HOST = 'localhost';
$DB_USER = 'root';
$DB_PASS = 'root'; // ⚠️ Deixe vazio se você não configurou senha no MySQL do XAMPP
$DB_NAME = 'vaidetrem2';

$mysqli = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);

// Verificação de erro de conexão
if ($mysqli->connect_errno) {
  die('Erro ao conectar ao MySQL: ' . $mysqli->connect_error);
}

// Força UTF-8
$mysqli->set_charset('utf8mb4');
?>
