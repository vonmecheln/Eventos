/**
    Máscara de CPF e CNPJ definida por tamanho do conteúdo
    caminho: ../htdocs/nomesistema/javascript/mascara/cpfcnpjtamanho.js
    usa: ../htdocs/nomesistema/javascript/mascara/mascara.js //instanciado no .php que chama este js
*/
function mascaraCpfCnpj(evtKeyPress,nomecampo){
	    var doc  = $(nomecampo);
        tam = (doc.value).length +1;
        if (tam<=14) {//cpf
            doc.setAttribute('maxlength','14');
            return mascara(null, nomecampo, '999.999.999-99', evtKeyPress);
        } else {
            doc.setAttribute('maxlength','19');
            return mascara(null, nomecampo, '99.999.999/9999-99', evtKeyPress);
        }
}
