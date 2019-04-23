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
			cats.push([cat]);
			f_child = f_child.nextSibling;
		} 
	}else{
		console.log("Invalid Data format received");
		console.log(d.responseText);
	}


	//build the form
	var form = document.createElement("form");
	for(var i = 0; i < cats.length; i++){
		//create a radio selector for each element
		var radioBtn = document.createElement("input");
		radioBtn.value = cats[i];
		radioBtn.name = "cat";
		radioBtn.type = "radio";

		//attach label
		var label = document.createElement("label");
		var val = document.createTextNode(cats[i]);
		label.appendChild(val);

		//attach the radio button to form
		form.appendChild(radioBtn);
		form.appendChild(label);
	}

	//attach a submit button to form
	var submit = document.createElement("input");
	submit.type="button";
	submit.value = "List Books";
	form.appendChild(submit);
	$('categories').appendChild(form);


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