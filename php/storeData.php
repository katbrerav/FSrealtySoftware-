<?php

include "dbconfig.php";

$agentID=$_POST ["agentID"];
$full_name=$_POST ["fname"];
$ofice_name=$_POST ["ofcname"];
$phone=$_POST ["phone"];
$email=$_POST ["email"];
$location=$_POST ["address"];

$sql = "INSERT INTO agentRequests (id, fullName, officeName,  mobile, email)VALUES($agentID, '$full_name', '$ofice_name', '$phone', '$email')";

if (mysqli_query($con, $sql)) {
	echo "<br>New record created successfully";
} else {
	echo "Error: " . $sql . "<br>" . mysqli_error($conn);

}

$sql = "INSERT INTO showings (MLS, agentID, timeStamp1)VALUES($location, '$agentID', '$ofice_name', '$phone', '$email')";

if (mysqli_query($con, $sql)) {
	echo "<br>New record created successfully";
} else {
	echo "Error: " . $sql . "<br>" . mysqli_error($conn);

}



?>
