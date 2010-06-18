var insc = {
		tipoParticipante : function(valor){
			if(valor == "Acadêmico"){
				$('nome_desc').innerHTML = "Universidade";
			}else{
				$('nome_desc').innerHTML = "Inscrição feita pela secretaria de saúde do município de";
			}
			
		}
		
}
Event.observe(window,'load', function(){
Event.observe('tpp_nome','change',function(){insc.tipoParticipante($('tpp_nome').value)});
});