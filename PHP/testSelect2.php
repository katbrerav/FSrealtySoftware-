<!DOCTYPE html>
<html>
	<head> 
		<title> FS Realty Showing </title>
		<link rel="stylesheet" type="text/css" href="Style/styles.css">
		<!-- Latest compiled and minified CSS -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

		<!-- Optional theme -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

		<!-- Latest compiled and minified JavaScript -->
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
		
	</head>

	<body>
			<img id = "logo" src= "img/FSR_logo.png"> 
			<h2 class="center">Showings Request Information </h2>
		<?php

		include "dbconfig.php";
		include "storeData.php";


		$query= "SELECT * FROM properties";

		$result = mysqli_query($con, $query);

  echo "<div class='table-responsive'> ";
  echo "<TABLE class= 'table table-striped table-bordered' border=1>\n";

	if($result) {
	if (mysqli_num_rows($result)>0) {
		while($row = mysqli_fetch_array($result)){
		  $MLS = $row['MLS'];
          $address = $row['address']; 
          $city = $row['city']; 
          $state = $row['state']; 
          $zipcode = $row['zipcode']; 

          echo "<TR><TD>$MLS<TD>$address<TD>$city<TD>$state<TD>$zicode\n";
      echo "</div>";
      }}
  }

else{
	echo "<br> Query problem detected: $query \n";
}



      ?>
</body>
</html>