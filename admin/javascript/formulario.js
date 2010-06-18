
var formulario = {
		login : function(nomeForm){
	        var form = $(nomeForm);
	        var url  = SISTEMA_URL+"login.php";
	        var params = Form.serialize(form);
	        new Ajax.Request(
	    	url, 
	    	{
	    		method: 'post', 
	    		parameters: params,
	    		asynchronous: false,
	    		onComplete: function(resp) {
	    		   if(resp.responseText == "ok"){
	    			   $('msg').innerHTML = "Entrando no Sistema";
	    			   window.location = document.URL;
	    		   }else{
	    			   $('msg').innerHTML = "<b style='color:red'>Usuário ou Senha incorretos</b>";
	    		   }
	    		}
	    	});
	    	
	    	return false;
		}, 
		enviaForm : function(nomeForm,modulo,acao){
	        var form = $(nomeForm);
	        var url  = SISTEMA_URL+"index.php?"+modulo+"&"+acao;
	        var params = Form.serialize(form);
	        new Ajax.Request(
	    	url, 
	    	{
	    		method: 'post', 
	    		parameters: params,
	    		asynchronous: false,
	    		onCreate : function(){},
	    		onComplete: function(resp,json) {
	    			var json = eval("("+resp.responseText+")");
	    		    if ((json.tipo != "erro") && (json.id != undefined)) {
	    		    	if($(json.id.campoid) != undefined){
		        		   var campoid = $(json.id.campoid);
		        		   campoid.value = json.id.valorid;
	    		    	}
	    		    }
	    		    formulario.mostraMensagem(json.mensagem,json.tipo);
	    		    if(json.campos != null){
	    		    	$$(".inputerro").each(function(id){$(id).removeClassName("inputerro");});
	    		    	json.campos.each(function(e){
	    		    		 $(e).addClassName("inputerro");
	    		    	})
	    		    }
	    		}
	    	});
	    	return false;
		},
		mostraMensagem : function(mensagem,tipo){
            var nomeClasse = 'mensagem'+tipo;
            // Remove todas as classes
            $('layout_mensagens').setAttribute('class',"");
            $('layout_mensagens').setAttribute('className',"");
            // Remove o conteudo atual
            $('mensagem_conteudo').innerHTML = "";
            // Adiciona a nova classe
            $('layout_mensagens').addClassName(nomeClasse);
            // Adiciona o novo conteudo
            $('mensagem_conteudo').innerHTML = mensagem;
            // Mostra a mensagem
            $('layout_mensagens').style.display='block';
		},
		getCidade : function(estado){
			var url = SISTEMA_URL+"componente/formulario/ajax.php";
			var parans = "uf="+estado;
	        new Ajax.Request(url,{method: 'post',parameters: parans,onComplete:function(r,json){formulario.retornoCidades(r);}});
		},
		retornoCidades : function(r){
			var json = eval(r.responseText);
			$('cid_cod').update("");
			json.each(function(e){
				$('cid_cod').insert(new Element('option', { value: e.cid_cod }).update(e.cid_nome));
			});
		},		
		enviaFormInscricao : function(nomeForm){
		
	        var form = $(nomeForm);
	        var url  = SISTEMA_URL+"modulo/inscricao/ajax.php";
	        var params = Form.serialize(form);
	        new Ajax.Request(
	    	url, 
	    	{
	    		method: 'post', 
	    		parameters: params,
	    		asynchronous: false,
	    		onCreate : function(){},
	    		onComplete: function(resp,json) {
	    			var json = eval("("+resp.responseText+")");
	    		    if ((json.tipo != "erro") && (json.id != undefined)) {
	    		    	if($(json.id.campoid) != undefined){
		        		   var campoid = $(json.id.campoid);
		        		   campoid.value = json.id.valorid;
	    		    	}
	    		    }
	    		    formulario.mostraMensagem(json.mensagem,json.tipo);
	    		    if(json.campos != null){
	    		    	$$(".inputerro").each(function(id){$(id).removeClassName("inputerro");});
	    		    	json.campos.each(function(e){
	    		    		 $(e).addClassName("inputerro");
	    		    	})
	    		    }
	    		}
	    	});
	    	return false;
		},
		entrada : function(nomeForm,modulo,acao){
			
	        var form = $(nomeForm);
	        var url  = SISTEMA_URL+"index.php?"+modulo+"&"+acao;
	        var params = Form.serialize(form);
	        new Ajax.Request(
	    	url, 
	    	{
	    		method: 'post', 
	    		parameters: params,
	    		asynchronous: false,
	    		onCreate : function(){},
	    		onComplete: function(resp,json) {
	    			var json = eval("("+resp.responseText+")");
	    		    if ((json.tipo != "erro") && (json.id != undefined)) {
	    		    	if($(json.id.campoid) != undefined){
		        		   var campoid = $(json.id.campoid);
		        		   campoid.value = json.id.valorid;
	    		    	}
	    		    }
	    		    formulario.mostraMensagem(json.mensagem,json.tipo);
	    		    if(json.campos != null){
	    		    	$$(".inputerro").each(function(id){$(id).removeClassName("inputerro");});
	    		    	json.campos.each(function(e){
	    		    		 $(e).addClassName("inputerro");
	    		    	})
	    		    }
	    		}
	    	});
	        $('usr_cod').value = "";
	        $('usr_cod').focus();
	    	return false;
		}		
		
		
}
