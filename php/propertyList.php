<?php
$server = "45.40.164.50";
$login = "FSshowings";
$password = "FSRealty7!";
$dbname = "FSshowings";

$con=mysqli_connect($server,$login,$password,$dbname) or die ("<br> Cannot connect to DB \n");

$search = $_GET['q'];
$sql = "SELECT MLS, address, city, state, zipcode FROM properties
		WHERE address LIKE  CONCAT('%','$search','%') OR city LIKE CONCAT('%','$search','%') OR state LIKE CONCAT('%','$search','%') OR zipcode LIKE CONCAT('%','$search','%')";

$result = $con->query($sql);

$json = array();
while($row = $result->fetch_assoc()){
     $json[] = array('id'=>$row['MLS'], 'text'=>$row['address']." ".$row['city'].", ".$row['state'].", ".$row['zipcode']);
}

header("Content-type:application/json");
echo json_encode($json);
?>