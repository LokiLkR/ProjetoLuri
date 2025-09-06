<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - LuriCosméticos</title>
    <link rel="stylesheet" href="styles.css"> <!-- Seu CSS principal -->
    <link rel="stylesheet" href="dashboard-styles.css"> <!-- CSS específico para o dashboard -->
    <!-- Inclua a biblioteca de gráficos, ex: Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <?php
        session_start();
        require_once 'conexao.php'; // Sua conexão com o banco
        // Aqui você faria as queries PHP para buscar os dados do dashboard
        // Exemplo:
        // $hoje = date("Y-m-d");
        // $vendas_hoje_sql = "SELECT SUM(valor_total) as total, COUNT(id) as num_pedidos FROM vendas WHERE DATE(data_venda) = '$hoje'";
        // $result_vendas_hoje = $conn->query($vendas_hoje_sql);
        // $dados_vendas_hoje = $result_vendas_hoje->fetch_assoc();
        // $total_vendas_hoje = $dados_vendas_hoje['total'] ?? 0;
        // $num_pedidos_hoje = $dados_vendas_hoje['num_pedidos'] ?? 0;
    ?>
    <header class="dashboard-header"> <!-- Pode ser um header diferente do index -->
        <div class="titulo-container">
            <!-- <img src="caminho/para/sua/imagem-logo.png" alt="Logo LuriCosméticos" id="logo-header"> -->
            <h1>Dashboard LuriCosméticos</h1>
        </div>
        <nav>
            <a href="index.php">Menu Principal</a>
            <!-- Outros links de navegação se necessário -->
        </nav>
    </header>

    <main class="dashboard-main">
        <!-- Seção de KPIs -->
        <section class="kpi-section">
            <div class="kpi-card">
                <h2>Vendas Hoje</h2>
                <p class="kpi-value">R$ <?php // echo number_format($total_vendas_hoje, 2, ',', '.'); ?></p>
            </div>
            <div class="kpi-card">
                <h2>Pedidos Hoje</h2>
                <p class="kpi-value"><?php // echo $num_pedidos_hoje; ?></p>
            </div>
            <div class="kpi-card">
                <h2>Ticket Médio Hoje</h2>
                <p class="kpi-value">R$ <?php
                    // if ($num_pedidos_hoje > 0) {
                    //    echo number_format($total_vendas_hoje / $num_pedidos_hoje, 2, ',', '.');
                    // } else {
                    //    echo '0,00';
                    // }
                ?></p>
            </div>
            <!-- Adicionar mais KPIs (ex: Vendas Mês, Novos Clientes Mês) -->
        </section>

        <!-- Seção de Gráficos -->
        <section class="charts-section">
            <div class="chart-container">
                <h3>Vendas nos Últimos 7 Dias</h3>
                <canvas id="vendasSemanaChart"></canvas>
            </div>
            <div class="chart-container">
                <h3>Top 5 Produtos Mais Vendidos (Mês)</h3>
                <canvas id="topProdutosChart"></canvas>
            </div>
        </section>

        <!-- Seção de Atividades Recentes -->
        <section class="recent-activity-section">
            <h3>Últimas Vendas</h3>
            <ul id="lista-ultimas-vendas">
                <?php
                // $ultimas_vendas_sql = "SELECT c.nome as nome_cliente, v.valor_total, v.data_venda
                //                        FROM vendas v
                //                        LEFT JOIN clientes c ON v.id_cliente = c.id
                //                        ORDER BY v.data_venda DESC LIMIT 5";
                // $result_ultimas_vendas = $conn->query($ultimas_vendas_sql);
                // if ($result_ultimas_vendas && $result_ultimas_vendas->num_rows > 0) {
                //     while($venda = $result_ultimas_vendas->fetch_assoc()) {
                //         echo "<li><strong>" . htmlspecialchars($venda['nome_cliente'] ?? 'N/A') . "</strong> - R$ "
                //              . number_format($venda['valor_total'], 2, ',', '.')
                //              . " <span class='data-pequena'>(" . date("d/m H:i", strtotime($venda['data_venda'])) . ")</span></li>";
                //     }
                // } else {
                //     echo "<li>Nenhuma venda recente.</li>";
                // }
                ?>
            </ul>
        </section>

        <!-- Seção de Atalhos Rápidos -->
        <section class="quick-actions-section">
            <h3>Ações Rápidas</h3>
            <a href="manutencao-produto.php" class="action-button">Gerenciar Produtos</a>
            <a href="controle-cliente.php" class="action-button">Ver Clientes</a>
            <!-- Adicionar mais botões/links -->
        </section>

    </main>

    <footer class="dashboard-footer">
        <p>© <?php echo date("Y"); ?> - NTG-TI. Todos os Direitos Reservados</p>
    </footer>

    <script>
        // Exemplo de como preencher dados para o gráfico de Vendas da Semana
        // Você buscaria esses dados do PHP e passaria para o JavaScript
        const vendasSemanaCtx = document.getElementById('vendasSemanaChart').getContext('2d');
        const vendasSemanaChart = new Chart(vendasSemanaCtx, {
            type: 'line', // ou 'bar'
            data: {
                labels: ['Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sáb', 'Dom'], // Labels dinâmicos do PHP
                datasets: [{
                    label: 'Vendas (R$)',
                    data: [120, 190, 300, 500, 200, 300, 450], // Dados dinâmicos do PHP
                    borderColor: 'rgb(177, 29, 164)',
                    tension: 0.1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false
            }
        });

        // Exemplo para Top Produtos
        const topProdutosCtx = document.getElementById('topProdutosChart').getContext('2d');
        const topProdutosChart = new Chart(topProdutosCtx, {
            type: 'bar', // ou 'doughnut'
            data: {
                labels: ['Produto A', 'Produto B', 'Produto C', 'Produto D', 'Produto E'], // Nomes dos produtos do PHP
                datasets: [{
                    label: 'Quantidade Vendida',
                    data: [65, 59, 80, 81, 56], // Quantidades do PHP
                    backgroundColor: [
                        'rgba(177, 29, 164, 0.7)',
                        'rgba(199, 50, 185, 0.7)',
                        'rgba(220, 78, 206, 0.7)',
                        'rgba(156, 25, 144, 0.7)',
                        'rgba(135, 22, 124, 0.7)'
                    ],
                    borderColor: [
                        'rgb(177, 29, 164)',
                        'rgb(199, 50, 185)',
                        'rgb(220, 78, 206)',
                        'rgb(156, 25, 144)',
                        'rgb(135, 22, 124)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                indexAxis: 'y', // Para gráfico de barras horizontais se preferir
                responsive: true,
                maintainAspectRatio: false
            }
        });
    </script>
    <?php if(isset($conn)) $conn->close(); ?>
</body>
</html>