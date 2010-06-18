
/*-- LETRAS MAIUSCULAS -------------------------------
    Formata o campo somente com letras maiusculas
    
    Exemplo de uso:
    <input type="text" onKeyUp="formata_maiusculas(this,event)" name="exemplo" />
    
    Autor: Everton Emilio Tavares
------------------------------------------------------*/

function formata_maiusculas(obj,event) {
    
    //Dependendo do Caractere, não executa a função das mascaras
    if ((event.keyCode == Event.KEY_RETURN) || //ENTER
        (event.keyCode == Event.KEY_DELETE) || //DELETE
        (event.keyCode == Event.KEY_TAB) ||    //TAB
        (event.keyCode == Event.KEY_RIGHT) ||  //TECLA PRA DIREITA
        (event.keyCode == Event.KEY_LEFT)) {   //TECLA PRA ESQUERDA
        return true;
    }
    
    //Recupera o valor que tem o Input
    Valor     = obj.value;
    tamVal    = Valor.length;
    novoValor = '';
    
    var i = 0;
    
    //Percorre todos os caracteres
    while (i < tamVal) {
        novoValor += Valor.charAt(i).toUpperCase();
        i++;
    }
    
    //Retorna o valor
    obj.value = novoValor;
    
}