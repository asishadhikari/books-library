<?php
	$myfile = fopen("books.json", "r") or die("Unable to open file!");
	$data = fread($myfile,filesize("books.json"));
	fclose($myfile);
	$json_data = json_decode($data);
	echo $data;
?>