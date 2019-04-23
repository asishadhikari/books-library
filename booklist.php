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