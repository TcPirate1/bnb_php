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

 $query ='SELECT booking.bookingID, room.roomname, booking.checkInDate, booking.checkOutDate, customer.lastname, customer.firstname
 FROM booking
 INNER JOIN customer ON booking.customerID = customer.customerID
 INNER JOIN room ON booking.roomID = room.roomID ORDER BY booking.bookingID ASC';
 $result = mysqli_query($DBC, $query);
 $rowcount = mysqli_num_rows($result);
 ?>
    <h1>Current bookings</h1>
    <h2><a href="make_a_booking.php">[Make a booking]</a>
    <a href="/bnb_php/">[Return to main page]</a></h2>

    <table border='1'>
      <thead>
        <th>Booking (room, dates)</th>
        <th>Customer</th>
        <th>Action</th>
</thead>
<?php

    if($rowcount > 0){
        while ($row = mysqli_fetch_assoc($result)){
            $id =$row['bookingID'];
            $rn = $row['roomname'];
                
                $res = mysqli_query($DBC,$query);
                $rowc = mysqli_num_rows($res);

                if($rowc > 0){
                    $rowr = mysqli_fetch_assoc($res);
                }

                echo '<tr>
                <td>'.$rowr['roomname'] .','.$row['checkInDate'].','.$row['checkOutDate'].'</td>';
                echo '<td>'.$row['firstname']. ' '.$row['lastname'].'</td>';
                
                echo '<td><a href="booking_details_view.php?id='.$id.'">[view]</a>';
                echo '<a href="edit_a_booking.php?id='.$id.'">[edit]</a>';
                echo '<a href="edit_add_room_review.php?id='.$id.'">[manage reviews]</a>'; //Change link
                echo '<a href="booking_preview_before_deletion.php?id='.$id.'">[delete]</a></td>';
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
