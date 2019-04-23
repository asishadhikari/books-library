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

//query for categories
if (strcmp($display, "categories")==0){
	$db = dbase_connect();
	$stmt = "SELECT * FROM category;"
	$categories = mysqli_query($db,$stmt);
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