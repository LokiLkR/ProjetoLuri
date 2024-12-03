function pesquisar() {


    // Obtém a seção HTML onde os resultados serão exibidos
    let section = document.getElementById("resultados-pagamento");

    // Obtém a palavra-chave digitada
    let palavraChave = document.getElementById("campo-pagamento").value.toLowerCase();

    // Inicializa uma string vazia para armazenar o HTML dos resultados
    let resultados = "";
  
    // Itera sobre cada dado da pesquisa e constrói o HTML dos resultados
    for (let dado of dados) {
      // Verifica se o título ou descrição contém a palavra-chave
    if (dado.titulo.toLowerCase().includes(palavraChave) || dado.descrição.toLowerCase().includes(palavraChave)) {
      resultados += `
          <div class="item-resultado">
                <img src="${dado.imagem}" alt="${dado.titulo}">
                <h2>${dado.titulo}</h2>
                <p>${dado.descrição}</p>
                <p>Preço: ${dado.preco}</p>
                <p>Quantidade: ${dado.quantidade}</p>
            </div>
      `;
     }
    }
  // Organiza os resultados em uma lista não ordenada
  resultados = `<ul>${resultados}</ul>`;
    // Atualiza o conteúdo HTML da seção com os resultados construídos
    function pesquisar() {


      // Obtém a seção HTML onde os resultados serão exibidos
      let section = document.getElementById("resultados-pagamento");
  
      // Obtém a palavra-chave digitada
      let palavraChave = document.getElementById("campo-pagamento").value.toLowerCase();
  
      // Inicializa uma string vazia para armazenar o HTML dos resultados
      let resultados = "";
    
      // Itera sobre cada dado da pesquisa e constrói o HTML dos resultados
      for (let dado of dados) {
        // Verifica se o título ou descrição contém a palavra-chave
      if (dado.titulo.toLowerCase().includes(palavraChave) || dado.descrição.toLowerCase().includes(palavraChave)) {
        resultados += `
            <div class="item-resultado">
                  <img src="${dado.imagem}" alt="${dado.titulo}">
                  <h2>${dado.titulo}</h2>
                  <p>${dado.descrição}</p>
                  <p>Preço: ${dado.preco}</p>
                  <p>Quantidade: ${dado.quantidade}</p>
              </div>
        `;
       }
      }
    // Organiza os resultados em uma lista não ordenada
    resultados = `<ul>${resultados}</ul>`;
      // Atualiza o conteúdo HTML da seção com os resultados construídos
      section.innerHTML = resultados;
    }
    //window.onload = pesquisar; // deixa os resultados aparente na tela.
    // Adiciona um ouvinte de evento para chamar a função pesquisar quando o valor do campo mudar
    document.getElementById("botao-pesquisa").addEventListener("click", pesquisar);
  }
  //window.onload = pesquisar; // deixa os resultados aparente na tela.
  // Adiciona um ouvinte de evento para chamar a função pesquisar quando o valor do campo mudar
  function pesquisar() {


    // Obtém a seção HTML onde os resultados serão exibidos
    let section = document.getElementById("resultados-pagamento");

    // Obtém a palavra-chave digitada
    let palavraChave = document.getElementById("campo-pagamento").value.toLowerCase();

    // Inicializa uma string vazia para armazenar o HTML dos resultados
    let resultados = "";
  
    // Itera sobre cada dado da pesquisa e constrói o HTML dos resultados
    for (let dado of dados) {
      // Verifica se o título ou descrição contém a palavra-chave
    if (dado.titulo.toLowerCase().includes(palavraChave) || dado.descrição.toLowerCase().includes(palavraChave)) {
      resultados += `
          <div class="item-resultado">
                <img src="${dado.imagem}" alt="${dado.titulo}">
                <h2>${dado.titulo}</h2>
                <p>${dado.descrição}</p>
                <p>Preço: ${dado.preco}</p>
                <p>Quantidade: ${dado.quantidade}</p>
            </div>
      `;
     }
    }
  // Organiza os resultados em uma lista não ordenada
  function pesquisar() {


    // Obtém a seção HTML onde os resultados serão exibidos
    let section = document.getElementById("resultados-pagamento");

    // Obtém a palavra-chave digitada
    let palavraChave = document.getElementById("campo-pagamento").value.toLowerCase();

    // Inicializa uma string vazia para armazenar o HTML dos resultados
    let resultados = "";
  
    // Itera sobre cada dado da pesquisa e constrói o HTML dos resultados
    for (let dado of dados) {
      // Verifica se o título ou descrição contém a palavra-chave
    if (dado.titulo.toLowerCase().includes(palavraChave) || dado.descrição.toLowerCase().includes(palavraChave)) {
      resultados += `
          <div class="item-resultado">
                <img src="${dado.imagem}" alt="${dado.titulo}">
                <h2>${dado.titulo}</h2>
                <p>${dado.descrição}</p>
                <p>Preço: ${dado.preco}</p>
                <p>Quantidade: ${dado.quantidade}</p>
            </div>
      `;
     }
    }
  // Organiza os resultados em uma lista não ordenada
  resultados = `<ul>${resultados}</ul>`;
    // Atualiza o conteúdo HTML da seção com os resultados construídos
    section.innerHTML = resultados;
  }
  //window.onload = pesquisar; // deixa os resultados aparente na tela.
  // Adiciona um ouvinte de evento para chamar a função pesquisar quando o valor do campo mudar
  document.getElementById("botao-pesquisa").addEventListener("click", pesquisar);
    // Atualiza o conteúdo HTML da seção com os resultados construídos
    section.innerHTML = resultados;
  }
  //window.onload = pesquisar; // deixa os resultados aparente na tela.
  // Adiciona um ouvinte de evento para chamar a função pesquisar quando o valor do campo mudar
  document.getElementById("botao-pesquisa").addEventListener("click", pesquisar);
  const filtroSelect = document.getElementById('filtro');
const tabelaResultados = document.getElementById('tabela-resultados');
const tbody = tabelaResultados.querySelector('tbody');

// Dados de exemplo
const dados = [
  { nome: 'Produto A', categoria: 'Eletrônicos' },
  { nome: 'Produto B', categoria: 'Vestuário' },
  // ... outros dados
];

function filtrarDados(categoria) {
  tbody.innerHTML = ''; // Limpa a tabela antes de adicionar os novos dados

  dados.forEach(item => {
    if (categoria === 'todos' || item.categoria === categoria) {
      const novaLinha = document.createElement('tr');
      const celulaNome = document.createElement('td');
      const celulaCategoria = document.createElement('td');

      celulaNome.textContent = item.nome;
      celulaCategoria.textContent = item.categoria;

      novaLinha.appendChild(celulaNome);
      novaLinha.appendChild(celulaCategoria);
      tbody.appendChild(novaLinha);
    }
  });
}

filtroSelect.addEventListener('change', () => {
  const categoriaSelecionada = filtroSelect.value;
  filtrarDados(categoriaSelecionada);
});

// Chamar a função para preencher a tabela inicialmente
filtrarDados('todos');