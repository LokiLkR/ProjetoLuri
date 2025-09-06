function irParaPagina(pagina) {
    window.location.href = pagina +'.php'; // Assumindo que as páginas tenham a extensão .html
  }

  // Exemplo de validação básica em JavaScript
function validarFormulario() {
  // Verifica se os campos estão preenchidos
  if (document.getElementById("nome").value === "") {
      alert("O campo nome é obrigatório.");
      return false;
  }
  // ... outras validações
}