<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Controle de Produtos</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1> Controle de Produtos</h1>
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

        <!-- Formulário de Cadastro de Produto -->
        <div class="form-container">
            <form id="form-cadastro-produto" action="processa_produto.php" method="post"> <!-- ID do formulário mais específico -->
                <label for="codigo_prod_input">Código do Produto:</label> <!-- IDs de input únicos -->
                <input type="text" id="codigo_prod_input" name="codigo" required>

                <label for="nome_prod_input">Nome:</label>
                <input type="text" id="nome_prod_input" name="nome" required>

                <label for="marca_prod_input">Marca:</label>
                <input type="text" id="marca_prod_input" name="marca" required>

                <label for="categoria_prod_select">Categoria:</label>
                <select id="categoria_prod_select" name="categoria">
                    <option value="selecao">Selecione Categoria</option>
                    <option value="cosmetico">Cosmético</option> <!-- Corrigido 'cosmeticos' para 'cosmetico' para consistência -->
                    <option value="higienico">Higiênico</option>
                    <option value="vestuario">Vestuário</option>
                    <option value="eletronico">Eletrônico</option>
                    <option value="outros">Outros</option>
                </select>

                <label for="preco_prod_input">Preço:</label>
                <input type="number" step="0.01" id="preco_prod_input" name="preco" required>

                <label for="validade_prod_input">Validade:</label>
                <input type="date" id="validade_prod_input" name="validade" > <!-- Validade pode não ser obrigatória para todos produtos -->

                <label for="dcompra_prod_input">Data de Compra:</label>
                <input type="date" id="dcompra_prod_input" name="dcompra" required>

                <label for="quantidade_prod_input">Quantidade:</label>
                <input type="number" id="quantidade_prod_input" name="quantidade" required>

                <button type="submit">Salvar</button>
            </form>
        </div>

        <!-- Tabela de Produtos Cadastrados -->
        <section class="secao-tabela">
            <h2>Produtos Cadastrados</h2>

            <!-- Seção de Pesquisa -->
        <section class="secao-pesquisa">
            <input type="text" id="campo-pesquisa-produto" placeholder="Pesquisar por Código, Nome, Marca ou Categoria...">
            <!-- <div id="resultados-pesquisa"></div> -->
        </section>

            <table id="tabela-lista-produtos"> <!-- ID para a tabela -->
                <thead>
                    <!-- O título "Controle de Produtos" que estava no colspan foi movido para o h2 -->
                    <tr>
                        <th>Código</th>         <!-- Coluna 0 -->
                        <th>Nome</th>           <!-- Coluna 1 -->
                        <th>Marca</th>          <!-- Coluna 2 -->
                        <th>Categoria</th>      <!-- Coluna 3 -->
                        <th>Preço</th>          <!-- Coluna 4 (pesquisa de texto não ideal) -->
                        <th>Validade</th>       <!-- Coluna 5 (pesquisa de texto não ideal) -->
                        <th>Data de Compra</th> <!-- Coluna 6 (pesquisa de texto não ideal) -->
                        <th>Quantidade</th>     <!-- Coluna 7 (pesquisa de texto não ideal) -->
                    </tr>
                </thead>
                <tbody id="tbody-lista-produtos"> <!-- ID único para o tbody -->
                    <?php
                    require_once 'conexao.php';
                    $sql = "SELECT id, codigo_produto, nome, marca, categoria, preco, validade, data_compra_produto, quantidade_estoque FROM produtos ORDER BY nome ASC";
                    $result = $conn->query($sql);

                    if ($result && $result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($row['codigo_produto']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['nome']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['marca']) . "</td>";
                            echo "<td>" . htmlspecialchars(ucfirst($row['categoria'])) . "</td>"; // ucfirst para capitalizar
                            echo "<td>R$ " . htmlspecialchars(number_format($row['preco'], 2, ',', '.')) . "</td>";
                            echo "<td>" . ($row['validade'] ? htmlspecialchars(date("d/m/Y", strtotime($row['validade']))) : 'N/A') . "</td>";
                            echo "<td>" . ($row['data_compra_produto'] ? htmlspecialchars(date("d/m/Y", strtotime($row['data_compra_produto']))) : 'N/A') . "</td>";
                            echo "<td>" . htmlspecialchars($row['quantidade_estoque']) . "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='8'>Nenhum produto cadastrado.</td></tr>";
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
            const searchButtonProduto = document.getElementById('botao-pesquisa-produto');
            const searchInputProduto = document.getElementById('campo-pesquisa-produto');

            // Colunas a serem pesquisadas (base 0): Código (0), Nome (1), Marca (2), Categoria (3)
            const colunasPesquisaveisProduto = [0, 1, 2, 3];

            if (searchButtonProduto) {
                searchButtonProduto.addEventListener('click', function() {
                    filterTableByText('campo-pesquisa-produto', 'tbody-lista-produtos', colunasPesquisaveisProduto);
                });
            }

            // Opcional: filtrar enquanto digita
            let typingTimerProduto;
            const doneTypingIntervalProduto = 300; // ms

            if (searchInputProduto) {
                searchInputProduto.addEventListener('keyup', () => {
                    clearTimeout(typingTimerProduto);
                    typingTimerProduto = setTimeout(() => {
                        filterTableByText('campo-pesquisa-produto', 'tbody-lista-produtos', colunasPesquisaveisProduto);
                    }, doneTypingIntervalProduto);
                });
                searchInputProduto.addEventListener('keydown', () => {
                    clearTimeout(typingTimerProduto);
                });
                searchInputProduto.addEventListener('input', function() {
                    if (this.value === "") {
                        filterTableByText('campo-pesquisa-produto', 'tbody-lista-produtos', colunasPesquisaveisProduto);
                    }
                });
            }
        });
    </script>
    <!-- Os scripts dados.js, app.js, filtro.js originais podem ser removidos se
         a funcionalidade deles foi substituída ou não é mais necessária para esta página -->
</body>
</html>