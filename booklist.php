<?php
define("SRV_ADDR", "localhost");
define("USER", "USER1");
define("PASS", "USER1PASSWORD");
define("DB", "BOOKS");

/*parse user request*/
$format = $_GET["format"]; //JSON or XML
$display = $_GET["display"]; //

$format = $_GET["format"];
$display = $_GET["display"];
$db = dbase_connect(); //connect to database

//Load the initial categories
if( strcasecmp($display, "categories")==0){
	$stmt = "SELECT * FROM category;";
	$cats = mysqli_query($db, $stmt);

	//JSON data was requested
	if( strcasecmp("JSON",$format)==0 ){
		$cats_list = array();
		while ($record = $cats->fetch_assoc()) {
			array_push($cats_list, $record[category]);
		}
		$dataJSON = array("categories" => $cats_list);
		echo json_encode($dataJSON);
	}else{
		//send XML
		$dataXML = new SimpleXMLElement("<categories></categories>");
		while ($record = $cats->fetch_assoc()) {
			$c = $dataXML->addChild($record[category]);
			$c -> addChild("name", $record[category]);
			$c -> addChild("id",$record[category_id]);
		}
		Header('Content-type: text/xml');
		echo $dataXML->asXML();
	}
}else if( strcasecmp($display, "list")==0 ){
	$required_cats = $_GET["required_cats"];
	$arr = array();
	$arr = str_getcsv($required_cats);

	$response_string = "";

	$sql = "select t.title_name, a.author, y.year, c.category from title t ";
	$sql .= "join category c on c.category_id = t.category_id and ";
	$sql .= "c.category_id=" . $arr[0] . " ";
	$sql .= "join year y on y.title_id = t.title_id ";
	$sql .= "join author a on a.author_id = t.author_id;";
	$all_books = mysqli_query($db, $sql);
	
	if ($format == "json") {
		$list_of_books = array();

		while ($row = $all_books->fetch_assoc()) {
			array_push($list_of_books, $row[category]);
		}
		$returnJSON = array("books" => $list_of_books);
		echo json_encode($returnJSON);
	} else {
		$booksXML = new SimpleXMLElement("<?xml version='1.0'?><books></books>");
		while ($row = $all_books->fetch_assoc()) {
			$currBook = $booksXML->addChild("book");
			$currBook->addChild("author", $row[author]);
			$currBook->addChild("name", $row[category]);
			$currBook->addChild("year", $row[year]);
			$currBook->addChild("title", $row[title_name]);
		}

		Header('Content-type: text/xml');
		echo $booksXML->asXML();
	}




}





mysqli_close($db);


//connect to database
function dbase_connect() {
	$conn = mysqli_connect(SRV_ADDR, USER, PASS, DB);
	if(mysqli_connect_errno()) {
		$msg = "Unable to Connect to Database ";
		$msg .= mysqli_connect_error();
		$msg .= " (" . mysqli_connect_errno() . ")";
		exit($msg);
	}
	return $conn;
}




?>