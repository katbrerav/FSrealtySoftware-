<?php

include "dbconfig.php";

$agentID=$_POST ["agentID"];
$full_name=$_POST ["fname"];
$ofice_name=$_POST ["ofcname"];
$phone=$_POST ["phone"];
$email=$_POST ["email"];
$p_ID=$_POST ["propertyMLS"];


function agentRequests($agentID, $full_name, $ofice_name, $phone, $email, $p_ID, $con){
	$sql = "INSERT INTO agentRequests (id, fullName, officeName,  mobile, email)VALUES($agentID, '$full_name', '$ofice_name', '$phone', '$email')";

	if (mysqli_query($con, $sql)) {

	$query = "INSERT INTO showings (MLS, agentID, timeStamp1)VALUES($p_ID, $agentID, current_timestamp)";

	if (mysqli_query($con, $query)) {
	} else {
	echo "Error: " . $query . "<br>" . mysqli_error($con);
	}

	sendEmail($agentID, $full_name, $ofice_name, $phone, $email, $p_ID, $con);

	} else {
	echo "Error: " . $sql . "<br>" . mysqli_error($con);
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

// email to showings@florostone.com
$to = 'ajgb1904@gmail.com'; // Add your showings email address inbetween the '' This is where the form will send a message to.
$email_subject = "Agent ".$full_name . "requested a showing for property " .$p_ID;
$email_body = "Agent ".$full_name ."requested a showing for property located at: \n\n".$address." ".$city." ".$state." ".$zip."\nHere are the details:\n\nName: $full_name\n\nEmail: $email\n\nPhone: $phone\n\nLicense #:\n$agentID";

$headers = "From: noreply@ariangonzalez.me\n"; // This is the email address the generated message will be from. We recommend using something like noreply@yourdomain.com.
$headers .= "Reply-To: $email";	
mail($to,$email_subject,$email_body,$headers);



//email to agent email address
$reply_Subject = "AUTO REPLY FROM ariangonzalez.me";
$reply_Body = "Thank you for contacting me. I will get back to you as soon as possible. \n\n\n Best Regards,\n Arian J. Gonzalez";
$reply_headers = "From: noreply@ariangonzalez.me\n";
mail($email,$reply_Subject,$reply_Body,$reply_headers);
return true;			
}

?>
