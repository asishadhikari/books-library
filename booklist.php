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


if( strcasecmp($display, "categories")==0){
	$db = dbase_connect();
	$stmt = "SELECT * FROM category;";
	$all_categories = mysqli_query($db, $stmt);

	//JSON data was requested
	if( strcasecmp("JSON",$format)==0 ){
		$list_of_categories = array();
		while ($row = $all_categories->fetch_assoc()) {
			array_push($list_of_categories, $row[category]);
		}
		$dataJSON = array("categories" => $list_of_categories);
		echo json_encode($dataJSON);
	}else{
		//send XML
		
	}


}






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