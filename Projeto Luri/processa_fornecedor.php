<?php
session_start();
require_once 'conexao.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $codigo_fornecedor = $conn->real_escape_string(trim($_POST['codigo'])); // Assumindo que 'codigo' é o código do fornecedor
    $nome_fornecedor = $conn->real_escape_string(trim($_POST['nome']));
    $cnpj = $conn->real_escape_string(trim($_POST['cnpj']));

    if (empty($codigo_fornecedor) || empty($nome_fornecedor) || empty($cnpj)) {
        $_SESSION['mensagem'] = "Erro: Todos os campos do fornecedor são obrigatórios.";
    } else {
        $sql = "INSERT INTO fornecedores (codigo_fornecedor, nome_fornecedor, cnpj) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        if ($stmt) {
            $stmt->bind_param("sss", $codigo_fornecedor, $nome_fornecedor, $cnpj);
            if ($stmt->execute()) {
                $_SESSION['mensagem'] = "Fornecedor cadastrado com sucesso!";
            } else {
                $_SESSION['mensagem'] = "Erro ao cadastrar fornecedor: " . $stmt->error;
            }
            $stmt->close();
        } else {
            $_SESSION['mensagem'] = "Erro ao preparar query: " . $conn->error;
        }
    }
    $conn->close();
    header("Location: manutencao-fornecedor.php"); // Assume renomeado para .php
    exit();
} else {
    $_SESSION['mensagem'] = "Erro: Método de requisição inválido.";
    header("Location: manutencao-fornecedor.php");
    exit();
}
?>