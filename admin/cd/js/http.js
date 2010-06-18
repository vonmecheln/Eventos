var HTTP = {

    init : false,
    GetVars: new Array(),

    __construct : function() {

        var uri = window.location.href;

  /*      if(uri.indexOf('?' <img src="http://s.wordpress.com/wp-includes/images/smilies/icon_wink.gif" alt=";)" class="wp-smiley"> == -1))
            return false;
*/
        var parts = uri.split('?');

	if(parts.length <= 1){
		return false;
	}

        var xv = parts[1].split('&');

        for(var i=0; i < xv.length; i++) {
            var get = xv[i].split('=');
            HTTP.GetVars[get[0]] = get[1];
        }

        this.init = true;
    },

    GET : function(v) {

        if(this.init == false)
            this.__construct();

        if(!this.GetVars[v])
            return false;

        return this.GetVars[v];
    }
}