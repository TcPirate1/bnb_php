<!-- Assumes customer is signed up and logged in -->

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Edit a booking</title>
  </head>

  <?php
    include "config.php"; //load in any variables
    $DBC = mysqli_connect(DBHOST, DBUSER, DBPASSWORD, DBDATABASE);

    if (mysqli_connect_errno()) {
        echo "Error: Unable to connect to MySQL. ".mysqli_connect_error() ;
        exit; //stop processing the page further
    };
  //Retrieve data to populate <select> dropdown
  $query = "SELECT roomID, roomname,roomtype,beds FROM room";
  $result = mysqli_query($DBC,$query);
  $rowcount = mysqli_num_rows($result);

  // function to clean input but not validate type and content
function cleanInput($data) {  
  return htmlspecialchars(stripslashes(trim($data)));
}

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $bookid = $_GET['id'];
    if (empty($bookid) or !is_numeric($bookid)) {
        echo "<h2>Invalid Booking ID</h2>"; //simple error feedback
        exit;
    }

    if (isset($_POST['submit']) and !empty($_POST['submit']) and ($_POST['submit'] == 'Update')) {
      $error = 0;
      $msg = 'Error: ';
      if (isset($_POST['id']) and !empty($_POST['id']) and is_integer(intval($_POST['id']))) {
      $id = cleanInput($_POST['id']); 
    } else {
      $error++; //bump the error flag
      $msg .= 'Invalid room ID '; //append error message
      $id = 0;  
    }

    if (isset($_POST['from']) and !empty($_POST['from']) and is_string($_POST['from'])) {
       $checkindate = cleanInput($_POST['from']);
       
       if (!preg_match("/^\d{4}-\d{2}-\d{2}$/",$checkindate)) {
          $error++; //bump the error flag
          $msg .= 'checkin date does not match the pattern'; //append error message
          $checkindate = '';
       }
    } else {
       $error++; //bump the error flag
       $msg .= 'Invalid checkin date '; //append eror message
       $checkindate = '';
    }

    if (isset($_POST['to']) and !empty($_POST['to']) and is_string($_POST['to'])) {
       $checkoutdate = cleanInput($_POST['to']);
       
       if (!preg_match("/^\d{4}-\d{2}-\d{2}$/",$checkoutdate)) {
          $error++; //bump the error flag
          $msg .= 'checkout date does not match the pattern'; //append error message
          $checkoutdate = '';
       }
    } else {
       $error++; //bump the error flag
       $msg .= 'Invalid checkout date '; //append eror message
       $checkoutdate = '';
    }
    
    if (isset($_POST['contactNum']) and !empty($_POST['contactNum']) and is_string($_POST['contactNum'])) {
       $contact = cleanInput($_POST['contactNum']);
       
       if (!preg_match("/\([0-9]{3}\) [0-9]{3} [0-9]{4}/",$contact)) {
          $error++; //bump the error flag
          $msg .= 'Contact Number does not match the pattern'; //append error message
          $contact = '';
       }
    } else {
       $error++; //bump the error flag
       $msg .= 'Invalid contact number '; //append eror message
       $contact = '';
    }

    if (isset($_POST['bookingExtras']) and is_string($_POST['bookingExtras'])) {
       $bookingExtras = cleanInput($_POST['bookingExtras']);
       $bookingExtras = (strlen($bookingExtras)>255)?substr($bookingExtras,1,255):$bookingExtras;
    } else {
       $error++; //bump the error flag
       $msg .= 'Invalid booking extras'; //append eror message
       $bookingExtras = '';
    }

    $bookid = cleanInput($_POST['bookingID']);
    $custID = 1; //hard coded for the moment
    if ($error == 0 and $bookid > 0) {
        $query = "UPDATE booking SET from=?,to=?,contactNum=?,bookingExtras=? WHERE bookingID=?";
        $stmt = mysqli_prepare($DBC,$query); //prepare the query
        mysqli_stmt_bind_param($stmt,'sssdi', $checkindate, $checkoutdate, $contact, $bookingExtras, $bookid);
        if (mysqli_stmt_execute($stmt))
        {
          echo "<h2>Booking updated</h2>".PHP_EOL;
        }
        else {
          echo "<h2>MySQLi Error: ".mysqli_error($DBC)."</h2>";
        }
        mysqli_stmt_close($stmt);
    } else {
      echo "<h2>$msg</h2>".PHP_EOL;
    }
    mysqli_close($DBC);
  }
}

?>
  <body>
    <h1>Edit a booking</h1>
    <h2>
      <a href="current_bookings.php">[Return to the Bookings listing]</a>
      <a href="/bnb_php/">[Return to main page]</a>
    </h2>

    <h2>Booking made for the test</h2>

    <form action="edit_a_booking.php" method="POST">
      <input type="hidden" name="id" value="<?php echo $bookid;?>">
      <label>Room (name,type,beds):</label>
      <select name="roomID">
        <?php
        if ($rowcount > 0) {
          while ($row = mysqli_fetch_assoc($result))
          {
            $id = $row['roomID']; ?>
          <option value = "<?php echo $id;?>">
          <?php echo $row['roomname'].', '.$row['roomtype'].', '.$row['beds']; ?>
          </option>
          <?php
          }
        }
        else echo "<option>No rooms found!</option>";
        ?>
      </select>
      <br />
      <label>Checkin date:</label>
      <input
        required
        id="startDate"
        type="date"
        placeholder="yyyy-mm-dd"
        pattern="^\d{4}-\d{2}-\d{2}"
      />
      <br />
      <label>Checkout date:</label>
      <input
        required
        id="endDate"
        type="date"
        placeholder="yyyy-mm-dd"
        pattern="^\d{4}-\d{2}-\d{2}"
      />
      <br />
      <label>Contact number:</label>
      <input
        type="text"
        placeholder="(###) ### ####"
        pattern="\(\d{3}\) \d{3} \d{4}"
      />
      <br />
      <label>Booking extras:</label>
      <textarea rows="6" cols="25">nothing</textarea>
      <br />
      <button>Update</button>
      <a href="current_bookings.php">[Cancel]</a>
    </form>
  </body>
  <script>
    $(function () {
      var dateFormat = "mm/dd/yy",
        from = $("#startDate")
          .datepicker({
            defaultDate: "+1w",
            changeMonth: true,
            numberOfMonths: 2,
          })
          .on("change", function () {
            to.datepicker("option", "minDate", getDate(this));
          }),
        to = $("#endDate")
          .datepicker({
            defaultDate: "+1w",
            changeMonth: true,
            numberOfMonths: 2,
          })
          .on("change", function () {
            from.datepicker("option", "maxDate", getDate(this));
          });

      function getDate(element) {
        var date;
        try {
          date = $.datepicker.parseDate(dateFormat, element.value);
        } catch (error) {
          date = null;
        }
        return date;
      }
    });
  </script>
</html>
