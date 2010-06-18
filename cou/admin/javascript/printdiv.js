function printDiv(id, pg) {
	var oPrint, oJan;
	oPrint = window.document.getElementById(id).innerHTML;
	oJan = window.open(pg);
	oJan.document.write(oPrint);	
	oJan.window.print();
    oJan.document.close(); 
    oJan.focus();
}