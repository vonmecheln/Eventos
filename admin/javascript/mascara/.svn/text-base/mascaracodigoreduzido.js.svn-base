function mascaracodigoreduzido(id,event){
	
	var valor = $(id).value;
	var len = valor.length;

	// teclado 
	var whichCode = (window.Event) ? event.which : event.keyCode;
		
	// backspace
	if (whichCode == 8) {	
		$(id).value = valor.substring(0,valor.length-1);		
		return false;
	}

	if (whichCode == 0  ) return true;
	if (whichCode == 9  ) return true; //tecla tab
	if (whichCode == 13 ) return true; //tecla enter
	if (whichCode == 16 ) return true; //shift internet explorer
	if (whichCode == 17 ) return true; //control no internet explorer
	if (whichCode == 27 ) return true; //tecla esc
	if (whichCode == 34 ) return true; //tecla end
	if (whichCode == 35 ) return true;//tecla end
	if (whichCode == 36 ) return true; //tecla home
	
	if ((whichCode < 48) || (whichCode > 57)) {
		return false;
	}
	
	if(len == 6 ){
		return false;
	}
	
	alert(valor);
	valor.gsub(/-/,"K");
	alert(valor);
	
	var p1 = valor.substr(0,(valor.length-1));
	var p2 = valor.substr(valor.length+1,1);
	
	alert(valor.length);
	alert(p1+" - "+p2);
	
	return true;
}

function replaceAll(string, token, newtoken) {
	while (string.indexOf(token) != -1) {
 		string = string.replace(token, newtoken);
	}
	return string;
}