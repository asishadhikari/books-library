'use strict';

window.onload = init;

function init(){
	var data = new Ajax.Request("booklist.php",{
		method : "get",
		onException : logExcept,
		onFailure : logExcept,
		//pass in query parameter to server
		parameters : {display : "categories"},		
		onSuccess : displayCategories
	});


}

function displayCategories(d){
	var data = JSON.parse(d.responseJSON);
	console.log("ok, data is "+data.responseText);
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