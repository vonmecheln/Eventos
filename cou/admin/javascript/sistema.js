
Event.observe(window,'load', function(){
				if($('mensagemCarregando') != null){
					Element.hide('mensagemCarregando');
				}
			  },false);

var callbacksGlobais = {
	onCreate: function(){
		Element.show('mensagemCarregando');
	},
	onComplete: function() {
		if(Ajax.activeRequestCount == 0){
			 Element.hide('mensagemCarregando');
		}
	}
};
if($('mensagemCarregando') != null){
	Ajax.Responders.register(callbacksGlobais);
}
