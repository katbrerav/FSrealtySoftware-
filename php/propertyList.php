<?php
	//include "dbconfig.php";

	require('dbconfig.php');

	// strip tags may not be the best method for your project to apply extra layer of security but fits needs for this tutorial 
	$search = strip_tags(trim($_GET['q'])); 

	// Do Prepared Query 
	$query = $smnt->prepare("SELECT MLS,address FROM properties WHERE address LIKE :search LIMIT 40");

	// Add a wildcard search to the search variable
	$query->execute(array(':search'=>"%".$search."%"));

	// Do a quick fetchall on the results
	$list = $query->fetchall(PDO::FETCH_ASSOC);

	// Make sure we have a result
	if(count($list) > 0){
	   foreach ($list as $key => $value) {
	    $data[] = array('MLS' => $value['MLS'], 'text' => $value['address']);              
	   } 
	} else {
	   $data[] = array('id' => '0', 'text' => 'No address found');
	}

	// return the result in json
	echo json_encode($data);

?>