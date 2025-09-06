<?php
$servername = "localhost"; // or your db host
$username = "root";        // your db username
$password = "";            // your db password
$dbname = "luri_db";   // your database name

// Criar conexão
$conn = new mysqli($servername, $username, $password, $dbname);

// Checar conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Definir charset para utf8mb4 para suportar caracteres especiais e emojis
if (!$conn->set_charset("utf8mb4")) {
    //printf("Erro ao definir utf8mb4: %s\n", $conn->error);
    // Fallback para utf8 se utf8mb4 não for suportado (versões mais antigas do MySQL)
    if (!$conn->set_charset("utf8")) {
        printf("Erro ao definir utf8: %s\n", $conn->error);
    }
}
?>