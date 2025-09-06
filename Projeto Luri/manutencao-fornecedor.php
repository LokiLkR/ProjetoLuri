<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Controle de Fornecedor</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1> Controle de Fornecedor</h1>
    </header>
    <main>

        <!-- Div para Mensagens (PHP) -->
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

        <!-- Formulário de Cadastro de Fornecedor -->
        <div class="form-container">
            <form id="form-fornecedor" action="processa_fornecedor.php" method="post"> <!-- ID do formulário mais específico -->
                <label for="codigo_fornecedor_input">Código do Fornecedor:</label> <!-- ID do input diferenciado do label for -->
                <input type="text" id="codigo_fornecedor_input" name="codigo" required> <!-- Alterado para type="text" -->

                <label for="nome_fornecedor_input">Nome do Fornecedor:</label>
                <input type="text" id="nome_fornecedor_input" name="nome" required>

                <label for="cnpj_input">CNPJ:</label>
                <input type="text" id="cnpj_input" name="cnpj" required> <!-- Alterado para type="text" para permitir formatação -->

                <button type="submit">Salvar</button>
            </form>
        </div>

        <!-- Tabela de Fornecedores Cadastrados -->
        <section class="secao-tabela">
            <h2>Fornecedores Cadastrados</h2>

             <!-- Seção de Pesquisa -->
        <section class="secao-pesquisa">
            <input type="text" id="campo-pesquisa-fornecedor" placeholder="Pesquisar por Código, Nome ou CNPJ...">
            
            <!-- <div id="resultados-pesquisa"></div> -->
        </section>

            <table id="tabela-lista-fornecedores"> <!-- ID para a tabela -->
                <thead>
                    <!-- O título "Controle de Fornecedor" que estava aqui foi movido para o h2 -->
                    <tr>
                        <th>Código do Fornecedor</th> <!-- Coluna 0 -->
                        <th>Nome do Fornecedor</th>   <!-- Coluna 1 -->
                        <th>CNPJ</th>                 <!-- Coluna 2 -->
                    </tr>
                </thead>
                <tbody id="tbody-lista-fornecedores"> <!-- ID único para o tbody -->
                    <?php
                    require_once 'conexao.php';
                    $sql = "SELECT id, codigo_fornecedor, nome_fornecedor, cnpj FROM fornecedores ORDER BY nome_fornecedor ASC";
                    $result = $conn->query($sql);

                    if ($result && $result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($row['codigo_fornecedor']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['nome_fornecedor']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['cnpj']) . "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='3'>Nenhum fornecedor cadastrado.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </section>
        <?php if(isset($conn)) $conn->close(); ?>
    </main>
    <footer>
        <p>© <?php echo date("Y"); ?> - NTG-TI. Todos os Direitos Reservados</p>
        <p>Contato: @lury_ds</p>
    </footer>

    <!-- Inclua o arquivo JS com a função de filtro -->
    <script src="pesquisa-tabela.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchButtonFornecedor = document.getElementById('botao-pesquisa-fornecedor');
            const searchInputFornecedor = document.getElementById('campo-pesquisa-fornecedor');

            // Colunas a serem pesquisadas (base 0): Código (0), Nome (1), CNPJ (2)
            const colunasPesquisaveisFornecedor = [0, 1, 2];

            if (searchButtonFornecedor) {
                searchButtonFornecedor.addEventListener('click', function() {
                    filterTableByText('campo-pesquisa-fornecedor', 'tbody-lista-fornecedores', colunasPesquisaveisFornecedor);
                });
            }

            // Opcional: filtrar enquanto digita
            let typingTimerFornecedor;
            const doneTypingIntervalFornecedor = 300; // ms

            if (searchInputFornecedor) {
                searchInputFornecedor.addEventListener('keyup', () => {
                    clearTimeout(typingTimerFornecedor);
                    typingTimerFornecedor = setTimeout(() => {
                        filterTableByText('campo-pesquisa-fornecedor', 'tbody-lista-fornecedores', colunasPesquisaveisFornecedor);
                    }, doneTypingIntervalFornecedor);
                });
                searchInputFornecedor.addEventListener('keydown', () => {
                    clearTimeout(typingTimerFornecedor);
                });
                searchInputFornecedor.addEventListener('input', function() {
                    if (this.value === "") {
                        filterTableByText('campo-pesquisa-fornecedor', 'tbody-lista-fornecedores', colunasPesquisaveisFornecedor);
                    }
                });
            }
        });
    </script>
    <!-- Os scripts dados.js, app.js, filtro.js originais podem ser removidos se
         a funcionalidade deles foi substituída ou não é mais necessária para esta página -->
</body>
</html>
