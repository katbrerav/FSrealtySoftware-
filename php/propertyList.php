<?php
$server = "45.40.164.50";
$login = "FSshowings";
$password = "FSRealty7!";
$dbname = "FSshowings";

$con=mysqli_connect($server,$login,$password,$dbname) or die ("<br> Cannot connect to DB \n");

$search = $_GET['q'];
$sql = "SELECT MLS, address, city, state, zipcode FROM properties
		WHERE address LIKE  CONCAT('%','$search','%')";

$result = $con->query($sql);

$json = [];
while($row = $result->fetch_assoc()){
     $json[] = ['id'=>$row['MLS'], 'text'=>$row['address']." ".$row['city'].", ".$row['state'].", ".$row['zipcode']];
}

echo json_encode($json);
?>