<?php
/** 
From index.php - must receive Property GSMLS id & Agent ID 

**/
session_start();
include 'dbconfig.php';
include 'storeData.php';

setcookie("propertyID","$p_ID",time()+(86400*30),"/");



// query gets all the property related info given the property MLS id 
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

      if($type=="GSMLS"){ //gsmls lockboxes

        agentRequests($agentID, $full_name, $ofice_name, $phone, $email, $p_ID, $con);
        echo "<br> <p> <b>GSMLS LOCKBOX </b></p><br>";
        echo" <p><i>Use your Supra Key </i></p><br>";
        echo "<p><br><b>Notes: </b> ".$notes."</p>";
        echo "<p class= 'feedback'>After viewing the property, please give us feedback at showings@florostone.com</p>";
        
       

      } else if($type=="r") {//regular lockbox 
         agentRequests($agentID, $full_name, $ofice_name, $phone, $email, $p_ID, $con);
        
        echo "<br><br> <p>GO DIRECT";
        echo "<br> Regular Lockbox Code: <br></p>";
        echo "<p class='code'>".$code."</h2></p>";
        echo "<p><b>Notes: </b>  ".$notes."</p>";
        echo "<p class= 'feedback'>After viewing the property, please give us feedback at showings@florostone.com</p>";
        



      } else if($type=="occ"){ //occupied 
    
        echo "<br><br><p> PROPERTY IS OCCUPIED<br/>";
        echo"<br><i>Do not go direct! </i></br><br/><br/></p>";
        echo "<p><b>Notes: </b>  ".$notes."</p>";
        echo "<br><p><a href ='#' data-toggle='modal' data-target='#occupiedRequests'>Request Showing</a></p> ";
     }
     
    ?> 

      </div>

      <div>
        <button type="button" class="btn btn-primary center btn-lg" data-toggle="modal" data-target="#newRequest">New Property Request </button>
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
<div id="occupiedRequests" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Showing Request</h4>
      </div>
      <div class="modal-body">

        <?php  echo "<p class='notes'>".$notes."</p>"?>
        <p>Please select up to two days and times that you will like to show the property. If the first date provided is not confirmed with the tenants, we will request to show on the second date. <br><br></p>

        <form action="showingRequest.php"  method="post">
          <input type="hidden" value="<?php echo $agentID; ?>" name="agentID" />
          <input type="hidden" value="<?php echo $email; ?>" name="email" />
          <input type="hidden" value="<?php echo $p_ID; ?>" name="MLS" />
          <input type="hidden" value="<?php echo $phone; ?>" name="phone" />
          <input type="hidden" value="<?php echo $full_name; ?>" name="fname" />
          <input type="hidden" value="<?php echo $ofice_name; ?>" name="ofcname" />
          <fieldset>
            <div class="control-group">
              <div class="controls input-append date form_datetime"  data-date-format="mm/dd/yyyy - HH:ii p" data-link-field="dtp_input1">
                <label for= "date1"> Date and Time Option 1: </label>
                <input class= "form-control" type="text" id ="date11" name="date1" required="required" placeholder="Select a date and time" style= "width: 200px;">
                <span class="add-on" style="position: absolute;left: 369;font-size: 25px;top: 203px;"><i  class="icon-th glyphicon glyphicon-calendar"></i></span>
              </div>
              <div class="control-group">
              <div class="controls input-append date form_datetime2"  data-date-format="mm/dd/yyyy - HH:ii p" data-link-field="dtp_input1">
              <label for= "date2" style= "padding-top: 14px;"> Date and Time Option 2:</label>
              <input class= "form-control" type="text" id ="date2" name="date2" required="required" placeholder="Select a date and time" style= "width: 200px;"">
                <span class="add-on" style="position: absolute;left: 369;font-size: 25px;top: 285px;" ><i  class="icon-th glyphicon glyphicon-calendar"></i></span>
              </div>
              </div>
            </div>
             </fieldset>
             <center>
             <input id= "submit" type="Submit" class="btn btn-primary center" value="Send Request"><br />
              </center>
        </form>
        <br/><br/>
        <p> We will email you at <?php echo "<b class ='highlight'> $email</b>" ?> with a confimation</p>
        <br> 
      <p>Thank You! We appreciate your feedback! </p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>
<script type="text/javascript">

      $('.form_datetime').datetimepicker({
        weekStart: 1,
        todayBtn:  1,
        autoclose: 1,
        todayHighlight: 1,
        startView: 2,
        forceParse: 0,
        showMeridian: 1 , 
      });
      $('.form_datetime').datetimepicker('setStartDate', new Date());

      $('.form_datetime2').datetimepicker({
        weekStart: 1,
        todayBtn:  1,
        autoclose: 1,
        todayHighlight: 1,
        startView: 2,
        forceParse: 0,
        showMeridian: 1, 
      });
      $('.form_datetime2').datetimepicker('setStartDate', new Date());

      $("span#calendar1").on('click',function(){
        $("input#date11")[0].click();

      });
    
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