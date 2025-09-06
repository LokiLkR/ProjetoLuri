<?php
session_start();
require_once 'conexao.php'; // Inclui o script de conexão

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Coleta e sanitiza os dados do formulário
    $nome = $conn->real_escape_string(trim($_POST['Nome']));
    $cpf = $conn->real_escape_string(trim($_POST['CPF']));
    $endereco = $conn->real_escape_string(trim($_POST['Endereco']));
    $telefone = $conn->real_escape_string(trim($_POST['Telefone']));

    // Validação básica (pode ser mais robusta)
    if (empty($nome) || empty($cpf) || empty($endereco) || empty($telefone)) {
        $_SESSION['mensagem'] = "Erro: Todos os campos são obrigatórios.";
    } else {
        // Prepara a inserção
        $sql = "INSERT INTO clientes (nome, cpf, endereco, telefone) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);

        if ($stmt) {
            $stmt->bind_param("ssss", $nome, $cpf, $endereco, $telefone);
            if ($stmt->execute()) {
                $_SESSION['mensagem'] = "Cliente cadastrado com sucesso!";
            } else {
                $_SESSION['mensagem'] = "Erro ao cadastrar cliente: " . $stmt->error;
            }
            $stmt->close();
        } else {
            $_SESSION['mensagem'] = "Erro ao preparar a query: " . $conn->error;
        }
    }
    $conn->close();
    header("Location: controle-cliente.php"); // Redireciona de volta para a página do formulário
    exit();
} else {
    // Se não for POST, redireciona ou mostra erro
    $_SESSION['mensagem'] = "Erro: Método de requisição inválido.";
    header("Location: controle-cliente.php");
    exit();
}
?>