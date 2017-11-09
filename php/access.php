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
  

   <link rel="stylesheet" type="text/css" href="http://www.florostone.com/showings/Style/styles.css">

   <link href="https://fonts.googleapis.com/css?family=Chewy|Goudy+Bookletter+1911" rel="stylesheet">

   <!-- Latest compiled and minified CSS -->
   <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

   <!-- Optional theme -->
   <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

   <!-- Latest compiled and minified JavaScript -->
   <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

 </head>
<style>
h3{
  font-family: 'Goudy Bookletter 1911', serif;
  font-size:30px;
}

p{
  font-family: 'Goudy Bookletter 1911', serif;
  font-size: 24px;
}

.code{
  font-family: 'Chewy', cursive;
  font-size:60px;

}

.highlight{
font-size: 24px;
color: blue; 
text-align: center;

}


</style>



           <body>
             <img id = "logo" src= "http://www.florostone.com/showings/img/FSR_Logo.png"> 
             <br> <h3 class="center"> Property Access Details</h3>
             <div> 
              <br><br>
              <center>

               <div id="rcorners2" > 


                 <?php
                 echo "<p class='highlight'> Property: ".$fullAddress."</p>";


      
      if($type=="GSMLS"){ //gsmls lockboxes
        
        ?>
        
         <br> <p> <b>GSMLS LOCKBOX </b></p><br>
         <p><i>Use your Supra Key </i></p><br> 
          <?php
          echo "<p><br><b>Notes: </b> ".$notes."</p";

      agentRequests($agentID, $full_name, $ofice_name, $phone, $email, $p_ID, $con);

      } else if($type=="r") {//regular lockbox 
            ?>
             <br><br> <p>GO DIRECT
            <br> Regular Lockbox Code: <br>
             </p>

              <?php
              echo "<p class='code'>".$code."</h2></p>";
              echo "<p><b>Notes: </b>  ".$notes."</p>";
              


      agentRequests($agentID, $full_name, $ofice_name, $phone, $email, $p_ID, $con);

      } else if($type=="occ"){ //occupied 
        ?>
        <br><br><br> <p> PROPERTY IS OCCUPIED
        <br> <i>Do not go direct! </i><br></p>
<?php
 echo "<p><b>Notes: </b>  ".$notes."</p>";
 echo "<br><br><a href='#'> <p>Submit request</p> </a>";

      }


?> 


    </div>
    <br><br>
  <input type="Submit" class="btn btn-primary center btn-lg" value="New Request"><br>
 
    

  </center>



</div>


</body>
</html>