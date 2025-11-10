function formatarMoeda(campo) {
  let valor = campo.value.replace(/\D/g, "");
  valor = (valor / 100).toLocaleString("pt-BR", {
    style: "currency",
    currency: "BRL",
  });
  campo.value = valor;
}

function formatarHoras(campo) {
  // Remove tudo que não for número
  let valor = campo.value.replace(/\D/g, "");
  
  // Limita para até 3 dígitos (máx. 999 horas)
  if (valor.length > 3) valor = valor.slice(0, 3);

  // Atualiza o campo com prefixo "HR "
  campo.value = valor ? `HR ${valor}` : "";
}