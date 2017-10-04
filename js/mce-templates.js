var wp_xhr = function(action, data, callback){
	var _c = callback;
	var xhr = new XMLHttpRequest();
	xhr.onreadystatechange = function() {
	  if( xhr.readyState === 4 && xhr.status === 200 ) {
	    _c(xhr.responseText);
	  }
	}
	var ajax_url = wp_vars.ajax_url;
	xhr.open( 'POST', ajax_url, true );
	xhr.setRequestHeader( 'Content-type', 'application/x-www-form-urlencoded' );
	var params = 'action='+action+'&data=' + JSON.stringify(data); 
	console.log("-xhr Data ----------------" );
	console.log( data );
	console.log( "-send xhr ----------------" );
	console.log( params );
	xhr.send( params );
}

/*wp_xhr('bbGETtemplate', {'id':86}, function(res){
	console.log(res);
});*/

wp_xhr('bbGETtemplates', {'types':['newsletters','sections']}, function(res){
	console.log(JSON.parse(res));
});