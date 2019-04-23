# Books 
> A demonstration of use of AJAX/XML/JSON
## Requirements:

-[ ] When the web page at books.php is first opened, the javascript program books.js included in  the  web  page fetches the  list  of  book  categories via  Ajax from booklist.php and displays it as specified. 
-[ ] When the "List Books" is clicked, the javascript program books.js fetches the information of  the books in the
selected categories via Ajax from booklist.php and displays it as in the specified example
-[ ] If  books.php is accessed with the parameter "format" set to "json", i.e. the path part of  the URL  is ```books.php?format=json```, the  web  server  should  send  back  data  in  JSONin  all  the following communication. Otherwise, the web server should send back data in XML.