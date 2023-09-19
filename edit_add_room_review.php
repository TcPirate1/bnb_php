<!-- Assumes customer is signed up and logged in -->

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Add review to booking</title>
  </head>
  <body>
    <h1>Would you like to add a review?</h1>
    <a href="current_bookings.php">[Return to the booking listing]</a>
    <a href="/">[Return to main page]</a>
    <?php
     include "checksession.php";
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
    };

    function cleanInput($data) {  
  return htmlspecialchars(stripslashes(trim($data)));
}

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $bookid = $_GET['id'];
    if (empty($bookid) or !is_numeric($bookid)) {
        echo "<h2>Invalid Booking ID</h2>"; //simple error feedback
        exit;
    }
  }

  if (isset($_POST['submit']) and !empty($_POST['submit']) and ($_POST['submit'] == 'Update')) {
      $error = 0;
      $msg = 'Error: ';
      if (isset($_POST['id']) and !empty($_POST['id']) and is_integer(intval($_POST['id']))) {
      $bookid = cleanInput($_POST['id']);
    } else {
      $error++; //bump the error flag
      $msg .= 'Invalid booking ID '; //append error message
      $id = 0;  
    }

      if (isset($_POST['bookingReview']) and is_string($_POST['bookingReview'])) {
       $bookingReview = cleanInput($_POST['bookingReview']);
       $bookingReview = (strlen($bookingReview)>255)?substr($bookingReview,1,255):$bookingReview;
    } else {
       $error++; //bump the error flag
       $msg .= 'Invalid booking extras'; //append eror message
       $bookingReview = '';
    }

    if ($error == 0 and $bookid > 0) {
      $query = "UPDATE booking SET bookingReview=? WHERE bookingID=?";
      $stmt = mysqli_prepare($DBC,$query); //prepare the query
      mysqli_stmt_bind_param($stmt,'si', $bookingReview, $bookid);
      if (mysqli_stmt_execute($stmt))
        {
          echo "<h2>Review added</h2>".PHP_EOL;
        } else {
          echo "<h2>Review failed to be added. </h2>".mysqli_error($DBC);
        }
        mysqli_stmt_close($stmt);
    } else {
      echo "<h2>$msg</h2>".PHP_EOL;
    }
    mysqli_close($DBC); //close the connection once done
  }
    ?>

    <h2><?php
    if (isset($_SESSION['username'])){
      echo "Review made by ". $_SESSION['username'];
    } else {
      echo "No user logged in";
    }?></h2>

    <form action="edit_add_room_review.php" method="POST">
      <input type="hidden" name="id" value="<?php echo $bookid;?>">
      <label for="bookingReview">Room review:</label>
      <textarea name="bookingReview" rows="6" cols="25">nothing</textarea>
      <br />
      <input type="submit" name="submit" value="Update"/>
      <a href="current_bookings.php">[Cancel]</a>
    </form>
    <?php
    echo '</div></div>';
    require_once "footer.php";
    ?>
  </body>
</html>
