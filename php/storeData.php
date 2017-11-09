<?php
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
					die;
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

	// email to showings@florostone.com
	$to = 'ajgb1904@gmail.com'; // Add your showings email address inbetween the '' This is where the form will send a message to.
	$email_subject = "Agent ".$full_name . " requested a showing for property " .$p_ID;
	$email_body = "Agent ".$full_name ." requested a showing for property located at: \n\n".$address." ".$city." ".$state." ".$zip."\n\nHere are the details:\n\nAgent Name: $full_name\n\nLicense #: $agentID\n\nOffice Name: $ofice_name\n\nEmail: $email\n\nPhone: $phone\n\n";

	$headers = "From: submission@florostone.com\n"; // This is the email address the generated message will be from. We recommend using something like noreply@yourdomain.com.
	$headers .= "Reply-To: $email";	
	mail($to,$email_subject,$email_body,$headers);


	//email to agent email address
	$reply_Subject = "You have submitted a showing request for property ".$p_ID;
	$reply_Body = "Hello ".$full_name."!\n\nHere are the details from your recent request: \n\nProperty Address: ".$address." ".$city." ".$state." ".$zip."\n\nLockbox location: $location\n\nNotes: $notes\n\nCombination (if applicable): $code\n\n\n After reviewing the property, please give feedback to showings@florostone.com";
	$reply_headers = "From: showings@florostone.com\n";
	mail($email,$reply_Subject,$reply_Body,$reply_headers);
	return true;			
}

?>
