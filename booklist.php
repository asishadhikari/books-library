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

echo json_encode('{ "books": [ { "category": "cooking", "year": 2009, "price": 22.00, "title": "Breakfast for Dinner", "author": "Amanda Camp" }, { "category": "cooking", "year": 2010, "price": 75.00, "title": "21 Burgers for the 21st Century", "author": "Stuart Reges" } ] }');








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