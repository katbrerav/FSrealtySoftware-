<?php
/** 
From index.php - must receive Property GSMLS id & Agent ID 

**/
//session_start();
include 'dbconfig.php';
include 'storeData.php';

setcookie("propertyID","$p_ID",time()+(86400*30),"/");
// Do not let user see this page if not logged in 
//if(!isset($_SESSION['user'])){
  //header("Location: index.php"); 
//// query gets all the property related info given the property MLS id 
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

</head>

<body>
 <img id = "logo" src= "../img/FSR_Logo.png"> 
 <h3 class="center"> Property Access Details</h3>
 <div> 
  <center>
  <div>
   <div id="rcorners2" > 
    <?php
    
      if($type=="GSMLS"){ //gsmls lockboxes

        agentRequests($agentID, $full_name, $ofice_name, $phone, $email, $p_ID, $con);
        echo "<br> <p> <b>GSMLS LOCKBOX </b></p><br>";
        echo" <p><i>Use your Supra Key </i></p><br>";
        echo "<p><br><b>Notes: </b> ".$notes."</p>";
        
       

      } else if($type=="r") {//regular lockbox 
         agentRequests($agentID, $full_name, $ofice_name, $phone, $email, $p_ID, $con);
        
        echo "<br><br> <p>GO DIRECT";
        echo "<br> Regular Lockbox Code: <br></p>";
        echo "<p class='code'>".$code."</h2></p>";
        echo "<p><b>Notes: </b>  ".$notes."</p>";

       


      } else if($type=="occ"){ //occupied 
<<<<<<< HEAD
        ?>
        <br><br><br> <p> PROPERTY IS OCCUPIED
        <br> <i>Do not go direct! </i><br></p>
<?php
 echo "<p><b>Notes: </b>  ".$notes."</p>";
 echo "<br><br><a href='#'> <p>Submit request</p> </a>";
=======
    
        echo "<br><br> <p> PROPERTY IS OCCUPIED";
        echo"<br> <i>Do not go direct! </i><br></p>";
        echo "<p><b>Notes: </b>  ".$notes."</p>";
        echo "<br><p><a href ='#' data-toggle='modal' data-target='#occupiedRequest'> Submit request</a></p> ";
     }
     
    ?> 
      </div>

      <div>
        <button type="button" class="btn btn-primary center btn-lg" data-toggle="modal" data-target="#newRequest">New Request </button>
      </div>

      <div class="box">
        <b class="help"> Any questions or concerns?</b>
        <p class="help"> Call (908) 445-5339 </br> showings@florostone.com</p>
      </div>
  </div>

  <?php 
    end:
   ?>
    </center>

  </div>

  <!-- New Request Window -->
<div class="modal fade" id="newRequest">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title"> New Showing Request</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
        <?php 

        echo $full_name;

         ?>
        Form will go here

      </div>

      <!-- Modal footer -->
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
>>>>>>> 82293d7f21c90472ff6cc635ee7d5b01e292da5c

    </div>
  </div>
</div>

<!-- Occupied Window -->
<div class="modal fade" id="occupiedRequest">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title"> Occupied Request</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
        <?php 

        echo $full_name;

         ?>
        Form will go here

      </div>

      <!-- Modal footer -->
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>

    </div>
  </div>
</div>

</body>
</html>