<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Controle de Pagamento</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1> Controle de Pagamento</h1>
    </header>
    <main>
        <section>
            <input type="text" id="campo-pesquisa-pagamento" placeholder="Digite sua pesquisa"> <!-- Changed id -->
            <button id="botao-pesquisa-pagamento">Pesquisar</button> <!-- Changed id -->
            <div id="resultados-pesquisa-pagamento"></div> <!-- Changed id -->
        </section>
        <section class="filtros-pagamento" style="margin-top:15px; margin-bottom:15px;">
             <label for="filtro-categoria-pagamento">Filtrar por Categoria:</label>
            <select id="filtro-categoria-pagamento" name="filtro_categoria_pag"> <!-- Added name -->
                <option value="todos">Todos</option>
                <option value="fornecedor">Fornecedor</option>
                <option value="cliente">Clientes</option> <!-- Corrigido para 'cliente' (singular) se for o valor -->
            </select>
        </section>

        <table id="tabela-resultados-pagamento"> <!-- Changed id -->
            <thead>
                <tr><th colspan="3">Controle de Pagamento</th></tr>
                <tr>
                    <th>Nome</th>
                    <th>Categoria</th>
                    <th>Valor Pago/Recebido</th> <!-- Ajustado para clareza -->
                </tr>
            </thead>
            <tbody>
                <?php
                require_once 'conexao.php';
                $sql = "SELECT nome_entidade, categoria_pagamento, valor_pagamento FROM pagamentos ORDER BY data_pagamento DESC";
                // Adicionar lógica de filtro similar ao de vendas se necessário
                $result = $conn->query($sql);

                if ($result && $result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($row['nome_entidade']) . "</td>";
                        echo "<td>" . htmlspecialchars(ucfirst($row['categoria_pagamento'])) . "</td>";
                        echo "<td>R$ " . htmlspecialchars(number_format($row['valor_pagamento'], 2, ',', '.')) . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='3'>Nenhum registro de pagamento encontrado.</td></tr>";
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
    <!-- <script src="filtro.js"></script> -->
    <?php if(isset($conn)) $conn->close(); ?>
</body>
</html>