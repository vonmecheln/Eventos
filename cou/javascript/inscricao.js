var insc = {
		tipoParticipante : function(valor){
			if(valor == "Acad�mico"){
				$('nome_desc').innerHTML = "Universidade";
			}else{
				$('nome_desc').innerHTML = "Inscri��o feita pela secretaria de sa�de do munic�pio de";
			}
			
		}
		
}
Event.observe(window,'load', function(){
Event.observe('tpp_nome','change',function(){insc.tipoParticipante($('tpp_nome').value)});
});