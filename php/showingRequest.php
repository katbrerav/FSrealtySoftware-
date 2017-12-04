<?php
include 'dbconfig.php';
require 'PHPMailer/PHPMailerAutoload.php';




$date1=$_POST ["date1"];
$date2=$_POST ["date2"];
$agentID=$_POST ["agentID"];
$full_name=$_POST ["fname"];
$office_name=$_POST ["ofcname"];
$phone=$_POST ["phone"];
$email=$_POST ["email"];
$p_ID=$_POST ["MLS"];

if(!$agentID){
  header("Location: ../index.html");
  } 


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

$fullAddress= $address.",".$city.", ".$state."  ".$zip; 


?>
<html>
<head> 
<title> FSR Showings </title>


<link rel="stylesheet" type="text/css" href="../Style/styles.css">

<link href="https://fonts.googleapis.com/css?family=Chewy|Goudy+Bookletter+1911" rel="stylesheet">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.4/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.4/js/select2.min.js"></script>
<link href="../Style/all/bootstrap-datetimepicker.min.css" rel="stylesheet" media="screen">
<script type="text/javascript" src="../Style/all/bootstrap-datetimepicker.js" charset="UTF-8"></script>
<script type="text/javascript" src="../Style/all/bootstrap-datetimepicker.fr.js" charset="UTF-8"></script>
</head>
<body>
	<img id = "logo" src= "../img/FSR_Logo.png"> 
	<h3 class="center"> Property Access Details</h3>
	<div> 
		<center>
			<div>
				<div id="rcorners2" > 
					<?php 
						echo "<p class='highlight'> Property: ".$fullAddress."</p>";
						echo "<br><p> PROPERTY IS OCCUPIED";
				        echo"<br><i>Do not go direct! </i></br></p>";
				        echo "<p><b>Notes: </b>  ".$notes."</p>";
				        $pageWasRefreshed = isset($_SERVER['HTTP_CACHE_CONTROL']) && $_SERVER['HTTP_CACHE_CONTROL'] === 'max-age=0';

							if($pageWasRefreshed ) {
							   echo '<p>Your submission has been recorded!</p><p>You have received an email with the property details.</p>';
							} else {
							   echo sendEmail($agentID, $full_name, $office_name, $phone, $email, $p_ID, $con, $date1, $date2);
							}
				        
				        echo "<p>Your requested dates: <br/>".$date1."<br/> or <br/>".$date2." </p>";
						
					?>

				</div>
			</div>
			<div>
        <button type="button" class="btn btn-primary center btn-lg" data-toggle="modal" data-target="#newRequest">New Property Request </button>
      </div>

      <div class="box">
        <b class="help"> Any questions or concerns?</b>
        <p class="help"> Call (908) 445-5339 </br> showings@florostone.com</p>
      </div>
		</center>
	</div>
      
	
</body>

<!-- New Request Window -->
<div class="modal fade" id="newRequest">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">New Showing Request</h4>
      </div>
      <div class="modal-body">
        
        <form action="access.php" method="post">

          <div class="form-box">
            <div id="agentID" class="form-group has-feedback">
              <label for = "agentID">Enter NJ Realtor License #:</label>
              <input class="form-control" type="text" maxlength="7" name="agentID" id="$agentID" required="required" value='<?php echo $agentID; ?>' readonly="readonly">
              <span id="agentID" class=""></span>
            </div>
            
            <div id="fname" class="form-group has-feedback">
              <label for = "fname">Full Name:</label>
              <input class="form-control" type="text" id="$full_name" name="fname" required="required" value='<?php echo $full_name; ?>' readonly="readonly">
              <span id="fname" class=""></span>
            </div>

            <div id="ofcname" class="form-group has-feedback">
             <label for = "ofcname">Office Name:</label>
             <input class="form-control" type="text" name="ofcname" id="ofcname" required="required"  value='<?php echo $office_name; ?>' readonly="readonly"/>
             <span id="ofcname" class=""></span>
           </div>
           <div id="phone" class="form-group has-feedback">
             <label for = "phone">Cell Phone Number </label>
             <input class="form-control" type="tel" name="phone" id="phone" maxlength="11" required="required"  value='<?php echo $phone; ?>' readonly="readonly"/>
             <span id="phone" class=""></span>
           </div>
           <div id="email" class="form-group has-feedback">
             <label for = "email">E-mail: </label>
             <input class="form-control" type="email" id="email" name="email"  required="required"  value='<?php echo $email; ?>' readonly="readonly">
             <span id="email" class=""></span>
           </div>

           <label for = "propertyMLS">Property Address</label>

           <div class="center">
            <select class="itemName form-control" style="width:250px" name="itemName" required="required">
              <option class="itemName"> </option>
            </select>
          </div> 

        </div>
        <center>
        <input id= "submit" type="Submit" class="btn btn-primary center" value="Submit New Request"><br />
      </center>
        </form>   

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>
    
</div>
<script> 
	$('.itemName').select2({
      placeholder: 'Start typing property address... ',
      minimumInputLength: 2,
      ajax: {
        url: 'propertyList.php',
        dataType: 'json',
        delay: 250,
        processResults: function (data) {
          return {
            results: data
          };
        },
        cache: true
      }
    });
</script>
</script>
</html>


<?php 

function sendEmail($agentID, $full_name, $office_name, $phone, $email, $p_ID, $con, $date1, $date2){

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
	    $mail->Subject = "SHOWING REQUEST - ".$address." ".$city." ".$state." ".$zip. " (MLS# ".$p_ID.")";
	    $mail->Body    = "Hello ".$full_name.", <br/><br/>You recently submitted a showing request for: <br/><br/> <b>Property Address:</b> ".$address." ".$city." ".$state." ".$zip."<br/><br/> <b>Requested Dates:</b>".$date1. " or ".$date2. "<br/><br/> We will contact you as soon as we get a confirmation from tenant. <br/><br/><b/> 
	    <br/><br/> After reviewing the property, please give feedback to showings@florostone.com";
	    $mail->send();

	    echo '<p>Your submission has been recorded!</p><p>You have received an email with the property details.</p>';
	} catch (Exception $e) {
	    echo '<p> Oops, we were unable to submit your request. Please email us at showings@florostone.com</p>';
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
	    $mail->setFrom('no-reply@florostone.com', 'Showings Submissions');
	    $mail->addAddress('showings@florostone.com', 'User');     // Add a recipient
	    $mail->addReplyTo($email, $full_name);

	    //Content
	    $mail->isHTML(true);                                  // Set email format to HTML
	    $mail->Subject = "SHOWING REQUEST OCCUPIED - ".$address." ".$city." ".$state." ".$zip." (MLS# ".$p_ID.")";
	    $mail->Body    = "Agent ".$full_name ." requested a showing for property located at: <b><br/><br/>".$address." ".$city." ".$state." ".$zip."</b><br/><br/>Here are the details:<br/><br/><b>Agent Name:</b> $full_name<br/><br/><b>License #:</b> $agentID<br/><br/><b>Office Name:</b>$office_name<br/><br/><b>Email:</b> $email<br/><br/><b>Phone: </b>$phone<br/><br/><b>Requested Dates:</b> ".$date1. " or ".$date2."<br/><br/>";

	    $mail->send();

	} catch (Exception $e) {
	    echo ' Unable to send email';
	}	
	}


					?>




