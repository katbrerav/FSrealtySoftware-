<html> 

<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

<!-- Latest compiled JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>



 <?php
    $datetimepicker = new \Kendo\UI\DateTimePicker('datetimepicker');
    $datetimepicker->min(new DateTime('1900-01-01'))
                   ->max(new DateTime('2099-12-31'))
                   ->value(new DateTime('today', new DateTimeZone('UTC')));
    ?>

</html>