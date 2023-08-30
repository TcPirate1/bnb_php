<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Current bookings</title>
  </head>
  <body>
    <?php
  include "config.php";
  $DBC = mysqli_connect(DBHOST,DBUSER,DBPASSWORD,DBDATABASE);

  if (mysqli_connect_errno()){
     echo "Error: Unable to connect to MySQL" .mysqli_connect_error();
     exit;
 }
 $query ='SELECT bookingID, checkInDate, checkOutDate FROM booking ORDER BY bookingID';
 $result = mysqli_query($DBC, $query);
 $rowcount = mysqli_num_rows($result);
 ?>
    <h1>Current bookings</h1>
    <a href="make_a_booking.php">[Make a booking]</a>
    <a href="index.php">[Return to main page]</a>

    <table>
      <thead>
        <th>Booking (room, dates)</th>
        <th>Customer</th>
        <th>Action</th>
</thead>
<?php

    if($rowcount > 0){
        while ($row = mysqli_fetch_assoc($result)){
            $id =$row['ticketID'];
            $fc = $row['flightcode'];
            $sql = 'SELECT flightcode, flightname, departure_location, destination_location
            FROM flight WHERE flightcode='.$fc;
                
                $res = mysqli_query($DBC,$sql);
                $rowc=mysqli_num_rows($res);

                if($rowc > 0){
                    $rowr = mysqli_fetch_assoc($res);
                }

                echo '<tr><td>'.$rowr['flightname'] .','.$row['departureDate']
                .','.$row['arrivalDate'].'</td>';
                
                echo '<td><a href="ticketdetails.php?id='.$id.'">[view]</a>';
                echo '<a href="edit_a_booking.php?id='.$id.'">[edit]</a>';
                echo '<a href="edit_add_room.php?id='.$id.'">[manage reviews]</a>';
                echo '<a href="deleteroom.php?id='.$id.'">[delete]</a></td>';
                echo '</tr>'.PHP_EOL;

                mysqli_free_result($res);

        }
    }else echo "<h2>No bookings found!</h2>";
    mysqli_free_result($result);
    mysqli_close($DBC);
?>
    </table>
  </body>
</html>
