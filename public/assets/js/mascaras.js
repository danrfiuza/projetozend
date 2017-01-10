$(document).ready(function() {
	$("#tel").mask("(99)9999-9999?9");
	$("#cpf").mask("999.999.999-99");
	$("#cnpj").mask("99.999.999/9999-99");
	$("#data").mask("99/99/9999");
	// formatação de valores monetários
	$(".monetario").number(true, 2, ',', '.');
});