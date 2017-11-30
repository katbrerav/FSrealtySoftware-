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
$full_name="Katerine";
/*$type="occ";
$agentID="123456";

$ofice_name="Floro";
$phone="9087649301";
$email-"cabrerka@kean.edu";
$p_ID=3430390;
$notes=" Tenants preferred times: Weekdays after 5pm.";
$fullAddress="114 Franklin St, Elizabeth NJ 07206";*/

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
    
        echo "<br><br> <p> PROPERTY IS OCCUPIED";
        echo"<br> <i>Do not go direct! </i><br></p>";
        echo "<p><b>Notes: </b>  ".$notes."</p>";
        echo "<br><p><a href ='#' data-toggle='modal' data-target='#occupiedRequests'> Submit request</a></p> ";
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
             <input class="form-control" type="text" name="ofcname" id="ofcname" required="required"  value='<?php echo $ofice_name; ?>' readonly="readonly"/>
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



<!-- Modal -->
<div id="occupiedRequests" class="modal fade" >
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Showing Request</h4>
      </div>

       <p> 
      <div class="modal-body">
        <?php
echo "Dear ".$full_name.",<br>"."Please enter up to two days and times that you will like to show the property.<br>"." <br>For easier showing, choose time slots from the tenant's preferred times.";
echo " Someone from our office will contact you shortly to the e-mail or phone provided.<br> Thank You! We appreciate your feedback!";




        ?>
        <form action="access.php" method="post"><br><br>
          <center>
          <div class="form-box">
       
        
          <div id="comment" class="form-group has-feedback">
         
          <input class="form-control" type="text" id="fname" name="fname" required="required" placeholder="Enter day and time" >
          <span id="fname" class=""></span>
        </div>


    
      </div>
    </center>
    </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    

  </div>

<script type="text/javascript">
    
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


</body>

</html>