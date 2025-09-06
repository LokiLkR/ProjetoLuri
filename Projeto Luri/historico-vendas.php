<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Histórico de Vendas</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1> Histórico de Vendas</h1>
    </header>
    <main>
        <section>
            <input type="text" id="campo-pesquisa-vendas" placeholder="Digite sua pesquisa"> <!-- Changed id -->
            <button id="botao-pesquisa-vendas">Pesquisar</button> <!-- Changed id -->
            <div id="resultados-pesquisa-vendas"></div> <!-- Changed id -->
        </section>
        <section class="filtros-vendas" style="margin-top:15px; margin-bottom:15px;">
            <label for="filtro-categoria-venda">Filtrar por Categoria:</label>
            <select id="filtro-categoria-venda" name="filtro_categoria"> <!-- Added name -->
                <option value="todos">Todos</option>
                <option value="cosmetico">Cosmético </option>
                <option value="higienico">Higiênico </option>
                <option value="vestuario">Vestuário</option>
                <option value="eletronico">Eletrônico </option>
                <option value="outros">Outros</option>
            </select>
            <!-- O botão de pesquisa pode acionar o filtro via JS ou um submit de form GET -->
        </section>

        <table id="tabela-resultados-vendas"> <!-- Changed id -->
            <thead>
                <tr><th colspan="3">Histórico de Vendas</th></tr>
                <tr>
                    <th>Nome do Cliente</th>
                    <th>Categoria</th>
                    <th>Valor da Compra</th>
                </tr>
            </thead>
            <tbody>
                <?php
                require_once 'conexao.php';
                // Basic select, filtering would require more logic (GET params, JS)
                $sql = "SELECT nome, v.categoria_produto, v.valor_total 
                        FROM vendas v 
                        LEFT JOIN clientes cv ON v.id_cliente = cv.id  -- Exemplo de JOIN
                        ORDER BY v.data_venda DESC";
                // Para um filtro real:
                // $filtro_cat = isset($_GET['filtro_categoria']) ? $_GET['filtro_categoria'] : 'todos';
                // $sql = "SELECT ... FROM vendas v ...";
                // if ($filtro_cat != 'todos') {
                //    $sql .= " WHERE v.categoria_produto = '" . $conn->real_escape_string($filtro_cat) . "'";
                // }
                // $sql .= " ORDER BY v.data_venda DESC";

                $result = $conn->query($sql);

                if ($result && $result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($row['nome_cliente'] ? $row['nome_cliente'] : 'Cliente não identificado') . "</td>";
                        echo "<td>" . htmlspecialchars($row['categoria_produto']) . "</td>";
                        echo "<td>R$ " . htmlspecialchars(number_format($row['valor_total'], 2, ',', '.')) . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='3'>Nenhum histórico de vendas encontrado.</td></tr>";
                }
                // $conn->close();
                ?>
            </tbody>
        </table>
    </main>
    <footer>
        <p>© <?php echo date("Y"); ?> - NTG-TI. Todos os Direitos Reservados</p>
        <p>Contato: @lury_ds</p>
    </footer>
    <!-- <script src="dados.js"></script> -->
    <!-- <script src="app.js"></script> -->
    <!-- <script src="filtro.js"></script> Assuming filtro.js for client-side -->
    <?php if(isset($conn)) $conn->close(); ?>
</body>
</html>