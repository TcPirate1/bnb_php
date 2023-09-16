<?php
   include "ChromePhp.php"; //ChromePhp library
   include "config.php"; //load in any variables
   $DBC = mysqli_connect(DBHOST, DBUSER, DBPASSWORD, DBDATABASE) or die();

   $startDate = $_POST['startDate'];
   $endDate = $_POST['endDate'];

   ChromePhp::log($startDate);
   ChromePhp::log($endDate);
   // Logging the start and end date

   $searchresult ='';
   if(true){

    $query ="SELECT *
    FROM room WHERE roomID
    NOT IN (SELECT bookingID FROM booking
    WHERE checkInDate >='$startDate' AND checkOutDate <='$endDate')";
    $result = mysqli_query($DBC,$query);
    $rowcount = mysqli_num_rows($result);

    if($rowcount > 0){
        $rows=[];  //start an empty array
        while ($row = mysqli_fetch_assoc($result)){
            $rows[]= $row;
        }
        ChromePhp::log($rows); //log the array

        //take the array of our 1 or more bookings and turn it into a JSON text
        $searchresult = json_encode($rows);

        header('Content-Type: text/json; charset=utf-8');
    }else echo "<tr><td><h5>No bookings found!</h5></td></tr>";

   }else echo "<tr><td><h5>Invalid search query</h5></td></tr>";

   mysqli_free_result($result);
   mysqli_close($DBC);
   echo $searchresult;
?>