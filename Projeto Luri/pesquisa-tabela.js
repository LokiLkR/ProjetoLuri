/**
 * Filtra as linhas de uma tabela HTML com base em um termo de pesquisa.
 * @param {string} inputId ID do campo de input da pesquisa.
 * @param {string} tableBodyId ID do tbody da tabela a ser filtrada.
 * @param {number[]} searchableColumnIndices Array de índices (base 0) das colunas que devem ser pesquisadas.
 */
function filterTableByText(inputId, tableBodyId, searchableColumnIndices) {
    const searchTerm = document.getElementById(inputId).value.toLowerCase();
    const tableBody = document.getElementById(tableBodyId);

    if (!tableBody) {
        console.error("Elemento tbody com ID '" + tableBodyId + "' não encontrado.");
        return;
    }

    const rows = tableBody.getElementsByTagName('tr');

    for (let i = 0; i < rows.length; i++) {
        const row = rows[i];
        let rowTextContent = '';
        let foundMatch = false;

        // Itera sobre as colunas especificadas como pesquisáveis
        for (const colIndex of searchableColumnIndices) {
            if (row.cells[colIndex]) { // Verifica se a célula existe
                const cellText = (row.cells[colIndex].textContent || row.cells[colIndex].innerText).toLowerCase();
                if (cellText.includes(searchTerm)) {
                    foundMatch = true;
                    break; // Encontrou na linha, não precisa verificar outras colunas desta linha
                }
            }
        }

        if (foundMatch) {
            row.style.display = ""; // Mostra a linha
        } else {
            row.style.display = "none"; // Esconde a linha
        }
    }
}

// O código do filtro de select (categoria) pode ser mantido separado se necessário,
// mas ele também precisaria ser adaptado para filtrar as linhas da tabela existente
// em vez de recriá-las a partir de um array 'dados'.
// Por enquanto, vamos focar na pesquisa por texto.