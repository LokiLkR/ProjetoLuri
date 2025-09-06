<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Cliente</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1> Lista de Cliente</h1>
    </header>

    <main>    
        <!-- Div para Mensagens (se necessário) -->
        <div id="mensagem-status" style="text-align: center; margin-bottom: 20px;">
            <?php
            if (session_status() == PHP_SESSION_NONE) {
                session_start();
            }
            if (isset($_SESSION['mensagem'])) {
                $isError = strpos(strtolower($_SESSION['mensagem']), 'erro') !== false;
                $style = $isError ? 'color: red; background-color: #ffe0e0; border: 1px solid red; padding: 10px; display: inline-block;' : 'color: green; background-color: #e0ffe0; border: 1px solid green; padding: 10px; display: inline-block;';
                echo "<p style='" . $style . "'>" . htmlspecialchars($_SESSION['mensagem']) . "</p>";
                unset($_SESSION['mensagem']);
            }
            ?>
        </div>

        <!-- Formulário de Cadastro -->
        <div class="form-container">
           <form id="form-cliente" action="processa_cliente.php" method="post"> <!-- ID do formulário mais específico -->
                <label for="Nome">Nome:</label>
                <input type="text" id="Nome" name="Nome" required>

                <label for="CPF">CPF:</label>
                <input type="text" id="CPF" name="CPF" required>

                <label for="Endereco">Endereço:</label>
                <input type="text" id="Endereco" name="Endereco" required>

                <label for="Telefone">Telefone:</label>
                <input type="text" id="Telefone" name="Telefone" required>

                <button type="submit">Salvar</button>
            </form>
        </div>
        </section>
        <!-- Tabela de Clientes -->
        <section class="secao-tabela"> <!-- Adicionada classe para estilização se necessário -->
             <h2>Lista de Clientes Cadastrados</h2>
                
             <section class="secao-pesquisa"> <!-- Adicionada classe para estilização se necessário -->
            <input type="text" id="campo-pesquisa-cliente" placeholder="Pesquisar por Nome, CPF, Endereço ou Telefone...">
            <!-- A div resultados-pesquisa não é diretamente usada por este filtro de tabela, mas pode manter se tiver outro uso -->
            
            <table id="tabela-lista-clientes"> <!-- ID para a tabela se necessário, mas o tbody é mais importante para o filtro -->
                <thead>
                    <tr>
                        <th>ID</th>       <!-- Coluna 0 -->
                        <th>Nome</th>     <!-- Coluna 1 -->
                        <th>CPF</th>      <!-- Coluna 2 -->
                        <th>Endereço</th> <!-- Coluna 3 -->
                        <th>Telefone</th> <!-- Coluna 4 -->
                    </tr>
                </thead>
                <tbody id="tbody-lista-clientes"> <!-- ID único para o tbody -->
                    <?php
                    // Incluir conexão apenas se não foi iniciada a sessão ainda (evita warning)
                    // (session_start() já foi chamado acima para as mensagens)
                    require_once 'conexao.php'; // Garante que $conn está disponível

                    $sql = "SELECT id, nome, cpf, endereco, telefone FROM clientes ORDER BY nome ASC";
                    $result = $conn->query($sql);

                    if ($result && $result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($row['id']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['nome']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['cpf']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['endereco']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['telefone']) . "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='5'>Nenhum cliente cadastrado.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </section>
    </main>
    <footer>
        <p>© <?php echo date("Y"); ?> - NTG-TI. Todos os Direitos Reservados</p>
        <p>Contato: @lury_ds</p>
    </footer>

    <!-- Inclua o arquivo JS com a função de filtro -->
    <script src="pesquisa-tabela.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchButtonCliente = document.getElementById('botao-pesquisa-cliente');
            const searchInputCliente = document.getElementById('campo-pesquisa-cliente');

            // Colunas a serem pesquisadas (base 0): Nome (1), CPF (2), Endereço (3), Telefone (4)
            // Não vamos pesquisar pelo ID (0) neste exemplo.
            const colunasPesquisaveisClientes = [1, 2, 3, 4];

            if (searchButtonCliente) {
                searchButtonCliente.addEventListener('click', function() {
                    filterTableByText('campo-pesquisa-cliente', 'tbody-lista-clientes', colunasPesquisaveisClientes);
                });
            }

            // Opcional: filtrar enquanto digita
            let typingTimerCliente;
            const doneTypingIntervalCliente = 300; // ms

            if (searchInputCliente) {
                searchInputCliente.addEventListener('keyup', () => {
                    clearTimeout(typingTimerCliente);
                    typingTimerCliente = setTimeout(() => {
                        filterTableByText('campo-pesquisa-cliente', 'tbody-lista-clientes', colunasPesquisaveisClientes);
                    }, doneTypingIntervalCliente);
                });
                searchInputCliente.addEventListener('keydown', () => {
                    clearTimeout(typingTimerCliente);
                });

                // Limpar o filtro se o campo de pesquisa ficar vazio
                searchInputCliente.addEventListener('input', function() {
                    if (this.value === "") {
                        filterTableByText('campo-pesquisa-cliente', 'tbody-lista-clientes', colunasPesquisaveisClientes);
                    }
                });
            }
        });
    </script>
</body>
</html>
<?php if(isset($conn)) $conn->close(); ?>