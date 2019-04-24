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

	//create response string
	foreach ($arr as $a){
		$stmt = getStmt($a,$db);

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


//for each category, return response as a JSON string
function getResString($s,$db){
	$stmt = "select t.title_name, a.author, y.year, c.category from title t ";
	$stmt .= "join category c on c.category_id = t.category_id and ";
	$stmt .= "c.category_id=" . $s . " ";
	$stmt .= "join year y on y.title_id = t.title_id ";
	$stmt .= "join author a on a.author_id = t.author_id;";
	$complete_books = mysqli_query($db, $stmt);

	if (strcasecmp($format,"json"){
		$book_list = array();

		while($record = $complete_books->fetch_assoc()){
			array_push($book_list,$row[category]);
		}
		$dJson = array($s=>$book_list);
		return dJson;
	}else{
		//return XML
	}

}

?>