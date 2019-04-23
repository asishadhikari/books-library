# Books 
> A demonstration of use of AJAX/XML/JSON
## Requirements:
-[ ] A plain text file named Readme.md that contains the instructions to setup your web site from  scratch. If  anysite-specificparameters need be changed in order for your web site to work, make sure the explanation is included in the instructions
-[ ] When the web page at books.php is first opened, the javascript program books.js included in  the  web  page fetches the  list  of  book  categories via  Ajax from booklist.php and displays it as specified. 
-[ ] When the "List Books" is clicked, the javascript program books.js fetches the information of  the books in the
selected categories via Ajax from booklist.php and displays it as in the specified example
-[ ] If  books.php is accessed with the parameter "format" set to "json", i.e. the path part of  the URL  is ```books.php?format=json```, the  web  server  should  send  back  data  in  JSONin  all  the following communication. Otherwise, the web server should send back data in XML.
-[ ] The book information on the server must be stored in a MySQL database. There should be 5 tables, one for title, year, price, category and author respectively.(You will create dummy book information to store in the database.)