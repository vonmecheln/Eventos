lista = {
		busca : function(){
			var valor  = $('list_busca').value;
			var filtro = $('filtro_busca').value;
			var formid = $('formid').value;
			var params = "busca="+valor+"&filtro="+filtro+"&formid="+formid;
			var url = SISTEMA_URL + "componente/listagem/ajax.php";
	        new Ajax.Request(
	    	    	url, 
	    	    	{
	    	    		method: 'post', 
	    	    		parameters: params,
	    	    		asynchronous: false,
	    	    		onCreate : function(){},
	    	    		onComplete: function(resp,json) {
	    	    		   $("list-div-resultados").innerHTML = resp.responseText;
	    	    		   lista.rollover();
	    	    		}
	    	    	});
	    	  return false;
		},
		recarrega : function(){			
			var params = "recarrega=true&formid="+$('formid').value;
			var url = SISTEMA_URL + "componente/listagem/ajax.php";
	        new Ajax.Request(
	    	    	url, 
	    	    	{
	    	    		method: 'post', 
	    	    		parameters: params,
	    	    		asynchronous: false,
	    	    		onCreate : function(){},
	    	    		onComplete: function(resp,json) {
	    	    			var url = new String(document.URL);
	    	    			window.location = url.replace("#","");
	    	    			lista.rollover();
	    	    		}
	    	    	});
	    	
		},
		paginas : function(limite){
			var valor  = $('list_busca').value;
			var filtro = $('filtro_busca').value;
			var formid = $('formid').value;
			var params = "busca="+valor+"&filtro="+filtro+"&formid="+formid+"&limit="+limite;
			var url = SISTEMA_URL + "componente/listagem/ajax.php";
	        new Ajax.Request(
	    	    	url, 
	    	    	{
	    	    		method: 'post', 
	    	    		parameters: params,
	    	    		asynchronous: false,
	    	    		onCreate : function(){},
	    	    		onComplete: function(resp,json) {
	    	    		   $("list-div-resultados").innerHTML = resp.responseText;
	    	    		   lista.rollover();
	    	    		}
	    	    	});
	    	//  return false;			
		},
		ordem : function (campo){
			var valor  = $('list_busca').value;
			var filtro = $('filtro_busca').value;
			var formid = $('formid').value;
			var params = "busca="+valor+"&filtro="+filtro+"&formid="+formid+"&ordem="+campo;
			var url = SISTEMA_URL + "componente/listagem/ajax.php";
	        new Ajax.Request(
	    	    	url, 
	    	    	{
	    	    		method: 'post', 
	    	    		parameters: params,
	    	    		asynchronous: false,
	    	    		onCreate : function(){},
	    	    		onComplete: function(resp,json) {
	    	    		   $("list-div-resultados").innerHTML = resp.responseText;
	    	    		   lista.rollover();
	    	    		}
	    	    	});	
		},
		rollover : function (){
			// carrega o efeito do rollver
			$$('.list-tabela tr').each(function(s) {
			    Event.observe(s,'mouseout',function (){	        
			        s.style.backgroundColor = '#ffffff';
			    });
			    Event.observe(s,'mouseover',function (){				        
			        s.style.backgroundColor = '#E2EFFE';
			    });
			});
		
					
		}
		
}
Event.observe(window,'load',function (){
	lista.rollover();
});