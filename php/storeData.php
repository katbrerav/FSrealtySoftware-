<?php

require 'PHPMailer/PHPMailerAutoload.php';
include "dbconfig.php";

$agentID=$_POST ["agentID"];
$full_name=$_POST ["fname"];
$ofice_name=$_POST ["ofcname"];
$phone=$_POST ["phone"];
$email=$_POST ["email"];
$p_ID=$_POST ["itemName"];



function agentRequests($agentID, $full_name, $ofice_name, $phone, $email, $p_ID, $con){


	$query = "Select id from agentRequests;";
	$result = mysqli_query($con, $query); 

	if($result){
		if (mysqli_num_rows($result)>0) {
			while($row = mysqli_fetch_array($result)){

				$id = $row['id'];
		
				if($agentID == $id){
				submitShowing($agentID, $p_ID, $full_name, $ofice_name, $phone, $email, $con);
				return 0;
				}
			}
		}
		insertData($agentID, $full_name, $ofice_name, $phone, $email, $p_ID, $con);
		submitShowing($agentID, $p_ID, $full_name, $ofice_name, $phone, $email, $con);
	}

}

function insertData($agentID, $full_name, $ofice_name, $phone, $email, $p_ID, $con){

	$sql = "INSERT INTO agentRequests (id, fullName, officeName,  mobile, email)VALUES($agentID, '$full_name', '$ofice_name', '$phone', '$email')";

	if (mysqli_query($con, $sql)) {
			//do nothing
	} else {
		echo "Error: " . $sql . "<br>" . mysqli_error($con);
	}

	
}

function submitShowing($agentID, $p_ID, $full_name, $ofice_name, $phone, $email, $con){
	$cookieid = null;

	if(isset($_COOKIE["propertyID"])){

	$cookieid = $_COOKIE["propertyID"];

	}
	

	$query = "INSERT INTO showings (MLS, agentID, timeStamp1)VALUES($p_ID, $agentID, current_timestamp)";

	if ($cookieid == $p_ID) {
		#do not submit showing if property already exist in cookie.
	} else {
	if (mysqli_query($con, $query)) {
		//send email after submission
		sendEmail($agentID, $full_name, $ofice_name, $phone, $email, $p_ID, $con);
	} else {
		echo "Error: " . $query . "<br>" . mysqli_error($con);
	}
}

}

function sendEmail($agentID, $full_name, $ofice_name, $phone, $email, $p_ID, $con){

	$query= "SELECT * FROM properties join propertyAccess on properties.MLS=propertyAccess.MLS WHERE properties.MLS = $p_ID ";

	$result = mysqli_query($con, $query);
	$row= mysqli_fetch_array($result);

	$address= $row['address'];
	$city= $row['city'];
	$state= $row ['state']; 
	$zip= $row ['zipcode']; 
	$type= $row['type'];  // type= GSMLS? OCCUPIED? REGULAR LOCKBOX?
	$code= $row['combo'];
	$notes= $row['notes'];
	$location=$row['location']; 

$mail = new PHPMailer(true);                              // Passing `true` enables exceptions
try {
    //Server settings                                   // TCP port to connect to

   $mail->isSMTP();
	$mail->Host = 'relay-hosting.secureserver.net';
	$mail->Port = 25;
	$mail->SMTPAuth = false;
	$mail->SMTPSecure = false;

    //Recipients
    $mail->setFrom('showings@florostone.com', 'Showings FloroStone');
    $mail->addAddress($email, 'User');     // Add a recipient
    $mail->addReplyTo('showings@florostone.com', 'Showings FloroStone');

    //Content
    $mail->isHTML(true);                                  // Set email format to HTML
    $mail->Subject = "SHOWING REQUEST - ".$address." ".$city." ".$state." ".$zip. " (MLS# ".$MLS.")";
    $mail->Body    = "Hello ".$full_name.", <br/><br/>Here are the details from your recent request:<br/><br/> <b>Property Address:</b> ".$address." ".$city." ".$state." ".$zip."<br/><br/><b>Lockbox location:</b> $location<br/><br/><b>Notes: </b> $notes<br/><br/><b>Combination (if applicable)</b></b>: $code<br/><br/><br/> After reviewing the property, please give feedback to showings@florostone.com";
    $mail->send();

    echo 'You have received an email with the property details.';
} catch (Exception $e) {
    echo 'Oops, we were unable to send you an email with property details. Please email us at showings@florostone.com';
}	

$mail = new PHPMailer(true);  
try {
    //Server settings                                   // TCP port to connect to

   $mail->isSMTP();
	$mail->Host = 'relay-hosting.secureserver.net';
	$mail->Port = 25;
	$mail->SMTPAuth = false;
	$mail->SMTPSecure = false;

    //Recipients
    $mail->setFrom('submissions@florostone.com', 'Showings Submissions');
    $mail->addAddress('showings@florostone.com', 'User');     // Add a recipient
    $mail->addReplyTo($email, $full_name);

    //Content
    $mail->isHTML(true);                                  // Set email format to HTML
    $mail->Subject = "SHOWING REQUEST - ".$address." ".$city." ".$state." ".$zip." (MLS# ".$MLS.")";
    $mail->Body    = "Agent ".$full_name ." requested a showing for property located at: <b><br/><br/>".$address." ".$city." ".$state." ".$zip."</b><br/><br/>Here are the details:<br/><br/><b>Agent Name:</b> $full_name<br/><br/><b>License #:</b> $agentID<br/><br/><b>Office Name:</b>$ofice_name<br/><br/><b>Email:</b> $email<br/><br/><b>Phone: </b>$phone<br/><br/>";;
    $mail->send();

} catch (Exception $e) {
    echo 'Oops, we were unable to send you an email with property details. Please email us at showings@florostone.com';
}	
}

?>
