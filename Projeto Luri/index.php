<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LuriCosmesticos</title>
    <link rel="stylesheet" href="styles.css">
    <link href="https://fonts.googleapis.com/css2?family=Titan+One&display=swap" rel="stylesheet">
</head>
<body>
    <header>
        <div class="titulo-container">
            <img src="Luri3.png" alt="Logo LuriCosméticos" id="logo-header" style="width:800px; height:auto;">
        </div>
        </header>
      <main> 
        <section class="botoes-navegacao">
            <button onclick="irParaPagina('controle-cliente')">Lista de Cliente</button>
            <button onclick="irParaPagina('manutencao-compra')">Controle de Compra</button>
            <button onclick="irParaPagina('historico-vendas')">Histórico de Vendas</button>
            <button onclick="irParaPagina('manutencao-produto')">Controle de Produtos</button>
            <button onclick="irParaPagina('controle-pagamento')">Controle de Pagamento</button>
            <button onclick="irParaPagina('manutencao-fornecedor')">Controle de Fornecedor</button>   
            <button onclick="irParaPagina('dashboard')">Dashboard</button> 
        </section>
    </main>
    <footer>
        <p>© <?php echo date("Y"); ?>2024 - NTG-TI. Todos os Direitos Reservados</p>
        <p>Contato:  @lury_ds</p>
</footer>
    <script src="appmenus.js"></script>
</body>
</html> 

 