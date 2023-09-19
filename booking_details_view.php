<!-- Assumes customer is signed up and logged in -->
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Booking Details View</title>
  </head>
  <body>
    <?php
      include "checksession.php";
      loginStatus();
      include "header.php";
      include "menu.php";
      echo '<div id="site_content">';
      include "sidebar.php";
      echo '<div id="content">';
      include "config.php"; //load in any variables
      $DBC = mysqli_connect(DBHOST, DBUSER, DBPASSWORD, DBDATABASE);

      if (mysqli_connect_errno()) {
          echo "Error: Unable to connect to MySQL. ".mysqli_connect_error() ;
          exit; //stop processing the page further
      }

      if ($_SERVER["REQUEST_METHOD"] == "GET") {
          $id = $_GET['id'];
          if (empty($id) or !is_numeric($id)) {
              echo "<h2>Invalid Booking ID</h2>"; //simple error feedback
              exit;
          }
        }

        $query = 'SELECT * FROM booking
        INNER JOIN customer ON booking.customerID = customer.customerID
        INNER JOIN room ON booking.roomID = room.roomID WHERE booking.bookingID='.$id;
        $result = mysqli_query($DBC,$query);
        $rowcount = mysqli_num_rows($result);
    ?>
    <h2><?php
    if (isset($_SESSION['username'])){
      echo "Logged in as ".$_SESSION['username'];
    }
    else {
      echo "No user logged in.";
    }?></h2>

    <h1>Booking Details View</h1>
    <a href="current_bookings.php">[Return to the booking listing]</a>
    <a href="/">[Return to main page]</a>
    <?php
    if ($rowcount > 0) {  
      echo "<fieldset><legend>Booking #$id</legend><dl>";
      $row = mysqli_fetch_assoc($result);
      echo "<dt>Room name:</dt><dd>".$row['roomname']."</dd>".PHP_EOL;
      echo "<dt>Checkin Date:</dt><dd>".$row['checkInDate']."</dd>".PHP_EOL;
      echo "<dt>Contact Number:</dt><dd>".$row['contactNumber']."</dd>".PHP_EOL;
      echo "<dt>Extras:</dt><dd>".$row['bookingExtras']."</dd>".PHP_EOL;
      echo "<dt>Review:</dt><dd>".$row['bookingReview']."</dd>".PHP_EOL;
      echo '</dl></fieldset>'.PHP_EOL;
      } else echo "<h2>No Room found!</h2>";
    ?>
    <?php
    echo '</div></div>';
    require_once "footer.php";
    ?>
  </body>
</html>
