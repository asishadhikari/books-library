'use strict';

window.onload = init;

function init(){
	var uri = window.location.search.substring(1);
	var params = new URLSearchParams(uri);
	var format = params.get('format') || 'xml';
	console.log(format + " type request will be sent");
	new Ajax.Request("booklist.php",{
		method : "get",
		onException : logExcept,
		onFailure : logExcept,
		//pass in query parameter to server
		parameters : {
			display : "categories",
			format : format
		},		
		onSuccess : displayCategories
	});


}

function displayCategories(d){
	var cats = [];
	//check if reposnse text is in json
	if(isJSON(d.responseText)){
		cats = JSON.parse(d.responseText);
	}else if(d.responseXML){
	
	}

}	

function logExcept(a,e){
	
	console.log(a); //ajax object
	console.log("ajax status: " + a.status);
	console.log("status text: " + a.statusText);
	if(e){
		console.log("Exception occured :" + e);
		throw e;
	}

}

function isJSON(s) {
    try {
        JSON.parse(s);
    } catch (e) {
        return false;
    }
    return true;
}