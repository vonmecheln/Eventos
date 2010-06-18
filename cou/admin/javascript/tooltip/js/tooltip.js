var tooltip=function(){
	var id = 'tt';
	var top = 3;
	var left = 3;
	var maxw = 200;
	var speed = 10;
	var timer = 10;
	var endalpha = 90;
	var alpha = 0;
	var tt,t,c,b,h;
	var ie = document.all ? true : false;
	return{
		show:function(v,w){
			if(tt == null){
				tt = document.createElement('div');
				tt.setAttribute('id',id);
				t = document.createElement('div');
				t.setAttribute('id',id + 'top');
				c = document.createElement('div');
				c.setAttribute('id',id + 'cont');
				b = document.createElement('div');
				b.setAttribute('id',id + 'bot');
				tt.appendChild(t);
				tt.appendChild(c);
				tt.appendChild(b);
				document.body.appendChild(tt);
				tt.style.opacity = 0;
				tt.style.filter = 'alpha(opacity=0)';
				document.onmousemove = this.pos;
			}
			tt.style.display = 'block';
			c.innerHTML = v;
			tt.style.width = w ? w + 'px' : 'auto';
			if(!w && ie){
				t.style.display = 'none';
				b.style.display = 'none';
				tt.style.width = tt.offsetWidth;
				t.style.display = 'block';
				b.style.display = 'block';
			}
			if(tt.offsetWidth > maxw){tt.style.width = maxw + 'px'}
			h = parseInt(tt.offsetHeight) + top;
			clearInterval(tt.timer);			
			tt.timer = setInterval(function(){tooltip.fade(1)},timer);				
			
		},
		pos:function(e){
			var u = ie ? event.clientY + document.documentElement.scrollTop : e.pageY;
			var l = ie ? event.clientX + document.documentElement.scrollLeft : e.pageX;
			tt.style.top = (u - h) + 'px';
			tt.style.left = (l + left) + 'px';
		},
		fade:function(d){
			var a = alpha;								
			if((a != endalpha && d == 1) || (a != 0 && d == -1)){
				
				if (ie) {					
					tt.style.filter 	= 'alpha(opacity=' + endalpha + ')';						
					tt.style.opacity 	= endalpha * .01;				
				} else {					
					var i = speed;
					if(endalpha - a < speed && d == 1){
						i = endalpha - a;
					}else if(alpha < speed && d == -1){
						i = a;
					}
					alpha = a + (i * d);
					tt.style.opacity = alpha * .01;				
					tt.style.filter = 'alpha(opacity=' + alpha + ')';	
				}		
				
			}else{
				clearInterval(tt.timer);
				if(d == -1){tt.style.display = 'none'}
			}
		},
		hide:function(){
			clearInterval(tt.timer);
			tt.timer = setInterval(function(){tooltip.fade(-1)},timer);
		}
	};
}();


var titulo = '';

Event.observe(window,'load',carrega_tooltip);

function carrega_tooltip() {

	// faz o pré-carregamento das imagens
	carrega_imagem('/javascript/tooltip/images/tt_left.gif');
	carrega_imagem('/javascript/tooltip/images/tt_top.gif');
	carrega_imagem('/javascript/tooltip/images/tt_bottom.gif');

	var link = document.getElementsByTagName('a');

	for (var i in link){	
			
		if (link[i].title != '' && link[i].onmouseover == null) {			
			link[i].onmouseover = function () {				
				titulo = '<b>'+(this.title)+'</b>';			// guarda o texto do tooltip				
				tooltip.show(titulo);		// mostra o tooltip
				this.title = '';				
			}

			// esconde o link
			link[i].onmouseout = function () {
				tooltip.hide();
				this.title = titulo;			// retorna o texto ao links	
			}		
		}
	}	
}

function carrega_imagem() {

	var d=document; 
	
	if(d.images) { 
		if(!d.MM_p){ 
			d.MM_p=new Array();	
		}
		
		var i,j=d.MM_p.length,a=carrega_imagem.arguments; 
		
		for(i=0; i<a.length; i++) {
			if (a[i].indexOf('#')!=0) { 
				d.MM_p[j]=new Image; 
				d.MM_p[j++].src=a[i];
			}
		}	
	}
}


