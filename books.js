'use strict';

window.onload = init;
//persistent format across requests
var format; 

function init(){
	var uri = window.location.search.substring(1);
	var params = new URLSearchParams(uri);
	format = params.get('format') || 'xml';
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

	$('submit').onclick = getBooks;


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

	for(var i = 0; i < cats.length; i++){
		//create a radio selector for each element
		var radioBtn = document.createElement("input");
		radioBtn.value = cats[i]+"  ";
		radioBtn.type = "radio";
		radioBtn.name ="selection"


		//attach label
		var label = document.createElement("label");
		var val = document.createTextNode(cats[i]);
		label.appendChild(val);

		//attach the radio button to form
		$('categories').appendChild(radioBtn);
		$('categories').appendChild(label);
	}
	
}	

function clearBooks(){
	var n = $('books');
	while(n.firstChild){
		n.removeChild(n.firstChild);
	}
}


function getBooks(){
	clearBooks();
	var c = $('categories').children;
	var required_cats = [];

	for(var i = 0; i< c.length; i++){
		if(c[i].checked){
			required_cats.push(c[i].value);
		}
	}

	//only request if non empty	
	if(required_cats.length!=0){
		new Ajax.Request("booklist.php",{
			method:"get",
			parameters:{
				display:"list",
				format:format,
				//pass in the array as string
				required_cats:required_cats.toString(),
			},
			onSuccess:displayBooks,
			onFailure:logExcept,
			onException:logExcept
		});
	}

}

function displayBooks(data){
    var book_list=[];  //[[author,category,year,title]] 
    if (isJSON(data.responseText)) {
        book_list = JSON.parse(data.responseText);
    }
    else if (data.responseXML) {
        var returnXML = data.responseXML;
        var books = returnXML.getElementsByTagName("books")[0];
        var currBook = books.firstChild;
        while (currBook) {
            var bookAuthor = currBook.firstChild.firstChild.nodeValue;
            var bookCat = currBook.firstChild.nextSibling.firstChild.nodeValue;
            var bookYear = currBook.firstChild.nextSibling.
                nextSibling.firstChild.nodeValue;
            var bookName = currBook.lastChild.firstChild.nodeValue;
            book_list.push([bookAuthor, bookCat, bookYear, bookName]);
            currBook = currBook.nextSibling;
        }
    } else {
        console.log("Invalid Data format");
        
    }

    if (book_list.length > 0) {
        var title = document.createElement("p");
        var text = document.createTextNode('Books in category ' + 
            '"'+ book_list[0][1] + '":');
        title.appendChild(text);
        $("books").appendChild(title);
    }

    var ul = document.createElement("ul");

    for (var i=0; i < book_list.length; i++) {
        var li = document.createElement("li");
        var bookItem = book_list[i][3] + 
            ", by " + book_list[i][0] + 
            " (" + book_list[i][2] + ")";

        var row = document.createTextNode(bookItem);
        li.appendChild(row);
        ul.appendChild(li);
    }
    $('books').appendChild(ul);

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