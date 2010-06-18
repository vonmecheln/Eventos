var fcursos = {
		cancelaPerticipante : function(id){
			if(confirm("Deseja Cancelar a entrada deste participante?")){
				var url  = SISTEMA_URL+"index.php?mod=cursos&act=cancelarentrada";
		        var params = "cod="+id;
		        new Ajax.Request(
		    	url, 
		    	{
		    		method: 'post', 
		    		parameters: params,
		    		asynchronous: false,
		    		onComplete: function(resp) {
		    		   if(resp.responseText == "ok"){
		    			   alert("Participante retirado com sucesso");
		    			   window.location = document.URL;
		    		   }else{
		    			   alert("Não foi possível retirar o participante");
		    		   }
		    		}
		    	});
			}
		}
		
}