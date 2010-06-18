/**
    Máscara de CPF e CNPJ
*/

function mascaraCpfCnpj(evtKeyPress,nomecampo){
        
        var tipo = $('tipo_documento_cpf');
        var doc  = $(nomecampo);
        
        //if (tipo.options[tipo.selectedIndex].value == 1) {
        if (tipo.checked) {
            doc.setAttribute('maxlength','14');
            return mascara(null, nomecampo, '999.999.999-99', evtKeyPress);
        } else {
            doc.setAttribute('maxlength','19');
            return mascara(null, nomecampo, '999.999.999/9999-99', evtKeyPress);
        }
}

/**
    Limpa o campo quando clicado em um campo RADIO
*/
function limparCampoCpfCnpj(nomecampo)
{
    var doc  = $(nomecampo);
    doc.value = '';
}