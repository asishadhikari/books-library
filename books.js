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
	
}	

function logExcept(e){
	console.log("fail");
}