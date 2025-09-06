<?php
session_start();
require_once 'conexao.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $codigo_produto = $conn->real_escape_string(trim($_POST['codigo']));
    $nome = $conn->real_escape_string(trim($_POST['nome']));
    $marca = $conn->real_escape_string(trim($_POST['marca']));
    $categoria = $conn->real_escape_string(trim($_POST['categoria']));
    $preco = $conn->real_escape_string(trim($_POST['preco']));
    $validade = $conn->real_escape_string(trim($_POST['validade']));
    $data_compra = $conn->real_escape_string(trim($_POST['dcompra']));
    $quantidade = $conn->real_escape_string(trim($_POST['quantidade']));

    if (empty($codigo_produto) || empty($nome) || empty($marca) || $categoria == "selecao" || empty($preco) || empty($quantidade)) {
        $_SESSION['mensagem'] = "Erro: Verifique os campos obrigatórios do produto.";
    } else {
        $sql = "INSERT INTO produtos (codigo_produto, nome, marca, categoria, preco, validade, data_compra_produto, quantidade_estoque)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        if ($stmt) {
            // 'd' for double/decimal, 's' for string, 'i' for integer
            $stmt->bind_param("ssssdssi", $codigo_produto, $nome, $marca, $categoria, $preco, $validade, $data_compra, $quantidade);
            if ($stmt->execute()) {
                $_SESSION['mensagem'] = "Produto cadastrado com sucesso!";
            } else {
                $_SESSION['mensagem'] = "Erro ao cadastrar produto: " . $stmt->error;
            }
            $stmt->close();
        } else {
            $_SESSION['mensagem'] = "Erro ao preparar query: " . $conn->error;
        }
    }
    $conn->close();
    header("Location: manutencao-produto.php"); // Assume renomeado para .php
    exit();
} else {
    $_SESSION['mensagem'] = "Erro: Método de requisição inválido.";
    header("Location: manutencao-produto.php");
    exit();
}
?>