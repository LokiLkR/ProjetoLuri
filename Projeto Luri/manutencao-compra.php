<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Controle de Compra</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1> Controle de Compra</h1>
    </header>
    <main>
        <!-- Seção de Pesquisa -->
        

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

        <!-- Formulário de Cadastro de Compra -->
        <div class="form-container">
            <form id="form-compra" action="processa_compra.php" method="post"> <!-- ID do formulário mais específico -->
                <label for="codigo">Código da Compra:</label>
                <input type="text" id="codigo" name="codigo" required> <!-- Alterado para type="text" para códigos alfanuméricos -->

                <label for="datap">Entrega Prevista:</label>
                <input type="date" id="datap" name="datap" required>

                <label for="datae">Entrega Realizada:</label> <!-- Nome do label mais claro -->
                <input type="date" id="datae" name="datae"> <!-- Não necessariamente required, pode ser preenchido depois -->

                <label for="quantidade">Quantidade:</label>
                <input type="number" id="quantidade" name="quantidade" required>

                <label for="nfe">NF-e:</label>
                <input type="text" id="nfe" name="nfe" required>

                <label for="dcompra">Data de Compra:</label>
                <input type="date" id="dcompra" name="dcompra" required>

                <label for="valor">Valor da Compra:</label>
                <input type="number" step="0.01" id="valor" name="valor" required> <!-- Adicionado step para decimais -->

                <button type="submit">Salvar</button>
            </form>
        </div>

        <!-- Tabela de Compras Registradas -->
        <section class="secao-tabela">
            <h2>Compras Registradas</h2>

            <section class="secao-pesquisa">
            <input type="text" id="campo-pesquisa-compra" placeholder="Pesquisar por Código da Compra ou NF-e...">
            
            <!-- <div id="resultados-pesquisa"></div>  Não usado diretamente pelo filtro de tabela -->
        </section>

            <table id="tabela-lista-compras"> <!-- ID para a tabela -->
                <thead>
                    <!-- O título "Controle de Compra" que estava aqui foi movido para o h2 acima da tabela -->
                    <tr>
                        <th>Código da Compra</th> <!-- Coluna 0 -->
                        <th>Entrega Prevista</th> <!-- Coluna 1 -->
                        <th>Entrega</th>          <!-- Coluna 2 -->
                        <th>Quantidade</th>       <!-- Coluna 3 -->
                        <th>NF-e</th>             <!-- Coluna 4 -->
                        <th>Data de Compra</th>   <!-- Coluna 5 -->
                        <th>Valor da Compra</th>  <!-- Coluna 6 -->
                    </tr>
                </thead>
                <tbody id="tbody-lista-compras"> <!-- ID único para o tbody -->
                    <?php
                    require_once 'conexao.php';
                    $sql = "SELECT id, codigo_compra, entrega_prevista, entrega_realizada, quantidade, nfe, data_compra, valor_compra FROM compras ORDER BY data_compra DESC";
                    $result = $conn->query($sql);

                    if ($result && $result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($row['codigo_compra']) . "</td>";
                            echo "<td>" . ($row['entrega_prevista'] ? htmlspecialchars(date("d/m/Y", strtotime($row['entrega_prevista']))) : '') . "</td>";
                            echo "<td>" . ($row['entrega_realizada'] ? htmlspecialchars(date("d/m/Y", strtotime($row['entrega_realizada']))) : 'Pendente') . "</td>";
                            echo "<td>" . htmlspecialchars($row['quantidade']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['nfe']) . "</td>";
                            echo "<td>" . ($row['data_compra'] ? htmlspecialchars(date("d/m/Y", strtotime($row['data_compra']))) : '') . "</td>";
                            echo "<td>R$ " . htmlspecialchars(number_format($row['valor_compra'], 2, ',', '.')) . "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='7'>Nenhuma compra registrada.</td></tr>";
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
            const searchButtonCompra = document.getElementById('botao-pesquisa-compra');
            const searchInputCompra = document.getElementById('campo-pesquisa-compra');

            // Colunas a serem pesquisadas (base 0): Código da Compra (0), NF-e (4)
            // As datas são formatadas para d/m/Y, então a pesquisa direta pode não ser ideal para elas
            // a menos que o usuário digite no mesmo formato.
            // Quantidade e Valor também são numéricos.
            const colunasPesquisaveisCompra = [0, 4];

            if (searchButtonCompra) {
                searchButtonCompra.addEventListener('click', function() {
                    filterTableByText('campo-pesquisa-compra', 'tbody-lista-compras', colunasPesquisaveisCompra);
                });
            }

            // Opcional: filtrar enquanto digita
            let typingTimerCompra;
            const doneTypingIntervalCompra = 300; // ms

            if (searchInputCompra) {
                searchInputCompra.addEventListener('keyup', () => {
                    clearTimeout(typingTimerCompra);
                    typingTimerCompra = setTimeout(() => {
                        filterTableByText('campo-pesquisa-compra', 'tbody-lista-compras', colunasPesquisaveisCompra);
                    }, doneTypingIntervalCompra);
                });
                searchInputCompra.addEventListener('keydown', () => {
                    clearTimeout(typingTimerCompra);
                });
                searchInputCompra.addEventListener('input', function() {
                    if (this.value === "") {
                        filterTableByText('campo-pesquisa-compra', 'tbody-lista-compras', colunasPesquisaveisCompra);
                    }
                });
            }
        });
    </script>
    <!-- Os scripts dados.js, app.js, filtro.js originais podem ser removidos se
         a funcionalidade deles foi substituída ou não é mais necessária para esta página -->
</body>
</html>