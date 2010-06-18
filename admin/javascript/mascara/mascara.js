/*

Descrição.: formata um campo do formulário de
acordo com a máscara informada...

Parâmetros: 
- objForm (o Objeto Form)
- strField (string contendo o nome do textbox)
- sMask (mascara que define o formato que o dado será apresentado,
  usando o algarismo "9" para definir números e o símbolo "!" para
  qualquer caracter...
- evtKeyPress (evento)

Uso.......: 
<input type="textbox" name="xxx" onkeypress="return mascara(document.rcfDownload, 'str_cep', '99999-999', event);">

Observação: 
As máscaras podem ser representadas como os exemplos abaixo:
CEP -> 99.999-999
CPF -> 999.999.999-99
CNPJ -> 99.999.999/9999-99
Data -> 99/99/9999
Tel Resid -> (99) 999-9999
Tel Cel -> (99) 9999-9999
Processo -> 99.999999999/999-99
C/C -> 999999-!
PLACA -> AAA-9999
*/

function mascara(objForm, strField, sMask, evtKeyPress) {
    var i, nCount, sValue, fldLen, mskLen,bolMask, sCod, nTecla,saida;
    
    if(document.all) { // Internet Explorer
        nTecla = evtKeyPress.keyCode;
    } else if(document.layers) { // Nestcape
        nTecla = evtKeyPress.which;
    } else {
        nTecla = evtKeyPress.which;
        if (nTecla == 8) {
           return true;
        }
    }
    
    
    //Dependendo do Caractere, não executa a função das mascaras
    if ((evtKeyPress.keyCode == Event.KEY_RETURN) || //ENTER
        (evtKeyPress.keyCode == Event.KEY_DELETE) || //DELETE
        (evtKeyPress.keyCode == Event.KEY_TAB) ||    //TAB
        (evtKeyPress.keyCode == Event.KEY_RIGHT) ||  //TECLA PRA DIREITA
        (evtKeyPress.keyCode == Event.KEY_LEFT)) {   //TECLA PRA ESQUERDA
        return true;
    }
    
    
    //Recupera o valor que tem o Input
    sValue = document.getElementById(strField).value;

    i = 0;
    
    saida = "";
    
    //Limpa todos os caracteres de formatação que
    //já estiverem no campo.
    sValue = sValue.toString().replace( "-", "" );
    sValue = sValue.toString().replace( "-", "" );
    sValue = sValue.toString().replace( ".", "" );
    sValue = sValue.toString().replace( ".", "" );
    sValue = sValue.toString().replace( "/", "" );
    sValue = sValue.toString().replace( "/", "" );
    sValue = sValue.toString().replace( "(", "" );
    sValue = sValue.toString().replace( "(", "" );
    sValue = sValue.toString().replace( ")", "" );
    sValue = sValue.toString().replace( ")", "" );
    sValue = sValue.toString().replace( ":", "" );
    sValue = sValue.toString().replace( " ", "" );   
    
    fldLen = sValue.length;
    mskLen = sMask.length;
    RealLenMask = sMask.length;
    
    
    i = 0;
    nCount = 0;
    sCod = "";
    mskLen = fldLen;

    
    //Percorre todos os caracteres 
    while (i <= mskLen){
        
        //Verifica se a mascara, na posição verificada, tem um caractere de formatação
        bolMask = ((sMask.charAt(i) == "-") || (sMask.charAt(i) == ":") || (sMask.charAt(i) == ".") || (sMask.charAt(i) == "/"))
        bolMask = bolMask || ((sMask.charAt(i) == "(") || (sMask.charAt(i) == ")") || (sMask.charAt(i) == " "))
        
        //Se tiver um caracter de formatação
        if (bolMask) {
            //Adiciona o caractere na saida
            sCod += sMask.charAt(i);
            //incrementa o tamanho do campo
            mskLen++;
        //Se for Letra ou Numero
        } else {
            //Se na mascara tiver o 'A', e a tecla digitada for uma letra minuscula, adiciona letra maiuscula
            if ((sMask.charAt(i) == 'A') && ((nTecla > 96) && (nTecla < 123))) {
	            sCod += sValue.charAt(nCount).toUpperCase();
	        //Se na mascara tiver 'a' e a tecla digitada for uma letra MAIUSCULA, adiciona letra minuscula
            } else if ((sMask.charAt(i) == 'a') && ((nTecla > 64) && (nTecla < 91))) {
                sCod += sValue.charAt(nCount).toLowerCase();
            //Caso contrario, adiciona o caracter normal
            } else {
                sCod += sValue.charAt(nCount);
            }
            //Incrementa o ponteiro que percorre os caracteres sem as formatações
            nCount++;
        }
        //Incrementa o ponteiro que percorre os caracteres com formatação
        i++;
    }
    
    if (bolMask) {
        return;
    }
    
    document.getElementById(strField).value = sCod;
    //objForm[strField].value = sCod;
    
    
    if (sMask.length >= i) {
         if (sMask.charAt(i-1) == "9") { // apenas números...
             return ((nTecla > 47) && (nTecla < 58)); // números de 0 a 9
         } else if ((sMask.charAt(i-1) == "&") ||(sMask.charAt(i-1) == "A") || (sMask.charAt(i-1) == "a")) {
             return (((nTecla > 64) && (nTecla < 91)) || ((nTecla > 96) && (nTecla < 123))); // Letras Maiusculas e letras Minusculas           
         } else { // qualquer caracter...
             return true;
         }
     } else {
         return false;
     }

    
}

//Fim da Função Máscaras Gerais

/***
* AUTO TAB - ao prencher o campo, automaticamente manda o foco para o próximo!
***/
var isNN = (navigator.appName.indexOf("Netscape")!=-1);
function autoTab(input,len, e) {
    var keyCode = (isNN) ? e.which : e.keyCode;
    var filter = (isNN) ? [0,8,9] : [0,8,9,16,17,18,37,38,39,40,46];
    if(input.value.length >= len && !containsElement(filter,keyCode)) {
        input.value = input.value.slice(0, len);
        input.form[(getIndex(input)+1) % input.form.length].focus();
    }

    function containsElement(arr, ele) {
        var found = false, index = 0;
        while(!found && index < arr.length) {
            
            if(arr[index] == ele) {
                found = true;
            } else {
                index++;
            }
        }
        return found;
    }

    function getIndex(input) {
        var index = -1, i = 0, found = false;
        while (i < input.form.length && index == -1) {
            if (input.form[i] == input) {
                index = i;
            } else {
                i++;
            }
        }
        return index;
    }
    return true;
}
//Fim da Função AutoTab

//Função que desabilita a tecla Enter do Formulário


