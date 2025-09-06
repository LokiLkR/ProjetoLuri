<?php
session_start();
require_once 'conexao.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $codigo_compra = $conn->real_escape_string(trim($_POST['codigo']));
    $entrega_prevista = $conn->real_escape_string(trim($_POST['datap']));
    $entrega_realizada = $conn->real_escape_string(trim($_POST['datae']));
    $quantidade = (int) trim($_POST['quantidade']);
    $nfe = $conn->real_escape_string(trim($_POST['nfe']));
    $data_compra = $conn->real_escape_string(trim($_POST['dcompra']));
    $valor_compra = (float) str_replace(',', '.', trim($_POST['valor']));

    if (empty($codigo_compra) || empty($entrega_prevista) || empty($quantidade) || empty($nfe) || empty($data_compra) || empty($valor_compra)) {
        $_SESSION['mensagem'] = "Erro: Verifique os campos obrigatórios da compra.";
    } else {
        $sql = "INSERT INTO compras (codigo_compra, entrega_prevista, entrega_realizada, quantidade, nfe, data_compra, valor_compra)
                VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        if ($stmt) {
            $stmt->bind_param("sssissd", $codigo_compra, $entrega_prevista, $entrega_realizada, $quantidade, $nfe, $data_compra, $valor_compra);
            if ($stmt->execute()) {
                $_SESSION['mensagem'] = "Compra registrada com sucesso!";
            } else {
                $_SESSION['mensagem'] = "Erro ao registrar compra: " . $stmt->error;
            }
            $stmt->close();
        } else {
            $_SESSION['mensagem'] = "Erro ao preparar query: " . $conn->error;
        }
    }
    $conn->close();
    header("Location: manutencao-compra.php");
    exit();
} else {
    $_SESSION['mensagem'] = "Erro: Método de requisição inválido.";
    header("Location: manutencao-compra.php");
    exit();
}
?>