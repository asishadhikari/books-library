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
	var categories;
	//check if reposnse text is in json
	if(isJSON(d.responseText)){
		cats = JSON.parse(d.responseText)["categories"];
	}else if(d.responseXML){
		categories = d.responseXML.firstElementChild;
		var f_child = categories.firstChild;
		while(f_child){
			//traverse xml 
			var cat = f_child.firstChild.firstChild.nodeValue;
			//var c_id = f_child.lastChild.firstChild.nodeValue;??unnecessary
			cats.push([cat]);
			f_child = f_child.nextSibling;
		} 
	}else{
		console.log("Invalid Data format received");
		console.log(d.responseText);
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