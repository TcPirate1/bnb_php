<!-- Assumes customer is signed up and logged in -->

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Make a Booking</title>
    <link
      rel="stylesheet"
      href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css"
    />
    <link rel="stylesheet" href="/resources/demos/style.css" />
    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
  </head>

  <?php
    include "config.php"; //load in any variables
    $DBC = mysqli_connect(DBHOST, DBUSER, DBPASSWORD, DBDATABASE);

    if (mysqli_connect_errno()) {
        echo "Error: Unable to connect to MySQL. ".mysqli_connect_error() ;
        exit; //stop processing the page further
    };

  // function to clean input but not validate type and content
function cleanInput($data) {  
  return htmlspecialchars(stripslashes(trim($data)));
}

// check if we are saving data first by checking if the submit button exists in the array
if (isset($_POST['submit']) and !empty($_POST['submit']) and ($_POST['submit'] == 'Add')) {
  // Validate input
    $error = 0;
    $msg = 'Error: ';

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

    $id = cleanInput($_POST['roomID']);
    $custID = 1; //hard coded for the moment

    if ($error == 0) {
        $query = "INSERT INTO booking (roomID, customerID, checkInDate,checkOutDate,contactNumber,bookingExtras) VALUES (?,?,?,?,?,?)";
        $stmt = mysqli_prepare($DBC,$query); //prepare the query
        mysqli_stmt_bind_param($stmt,'iissss', $id, $custID, $checkindate, $checkoutdate,$contact, $bookingExtras);
        if (mysqli_stmt_execute($stmt))
        {
          echo "<h2>Booking saved</h2>".PHP_EOL;
        }
        else {
          echo "<h2>MySQLi Error: ".mysqli_error($DBC)."</h2>";
        }
        mysqli_stmt_close($stmt);
    } else {
      echo "<h2>$msg</h2>".PHP_EOL;
    }      
    mysqli_close($DBC); //close the connection once done
}
    ?>

  <body>
    <h1>Make a booking</h1>
    <h2><a href="current_bookings.php">[Return to the Bookings listing]</a>
    <a href="/bnb_php/">[Return to main page]</a></h2>

    <h2>Booking for Test</h2>
    <form method="POST" action="make_a_booking.php">
      <label for="roomNO">Room (name,type,beds):</label>
      <select name="roomID">
        <?php
        //Retrieve data to populate <select> dropdown
        $query = "SELECT roomID, roomname,roomtype,beds FROM room";
        $result = mysqli_query($DBC,$query);
        $rowcount = mysqli_num_rows($result);
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
      <label for="from">Checkin date:</label>
      <input
      required
        name = "from"
        id="from"
        type="text"
        placeholder="yyyy-mm-dd"
        pattern="^\d{4}-\d{2}-\d{2}"
      />
      <br />
      <label for="to">Checkout date:</label>
      <input
      required
        name = "to"
        id="to"
        type="text"
        placeholder="yyyy-mm-dd"
        pattern="^\d{4}-\d{2}-\d{2}"
      />
      <br />
      <label for="contactNum">Contact number:</label>
      <input
        name="contactNum"
        type="tel"
        placeholder="(###) ### ####"
        pattern="\([0-9]{3}\) [0-9]{3} [0-9]{4}"
      />
      <br />
      <label for="bookingExtras">Booking extras:</label>
      <textarea name="bookingExtras" rows="6" cols="25"></textarea>
      <br />
      <input type="submit" name="submit" value="Add"/>
      <a href="current_bookings.php">[Cancel]</a>
    </form>

    <hr />

    <h2>Search for room avaliability</h2>
    <form id="searchForm" method="POST">
      <label>Start date:</label>
      <input id="from_date" name="startDate" type="text" placeholder="yyyy-mm-dd" pattern="^\d{4}-\d{2}-\d{2}"></input>
      <label>End date:</label>
      <input id="to_date" name="endDate" type="text" placeholder="yyyy-mm-dd" pattern="^\d{4}-\d{2}-\d{2}"></input>
      <input type="submit" value="Search avaliability"></input>
    </form>

    <br><br>

    <div class="row">
        <table id="roomBookings" border="1">
            <thead>
                <tr>
                    <th>Room name</th>
                    <th>Room Type</th>
                    <th>Beds</th>
                </tr>
            </thead>
        </table>
    </div>

  </body>
  <script>
    $(function () {
      var dateFormat = "yy-mm-dd",
        from = $("#from")
          .datepicker({
            defaultDate: "+1w",
            changeMonth: true,
            numberOfMonths: 2,
            dateFormat: dateFormat,
          })
          .on("change", function () {
            to.datepicker("option", "minDate", getDate(this));
          }),
        to = $("#to")
          .datepicker({
            defaultDate: "+1w",
            changeMonth: true,
            numberOfMonths: 2,
            dateFormat: dateFormat
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

  $(document).ready(function() {
			  $('#from_date').datepicker({dateFormat: 'yy-mm-dd'});
				$('#to_date').datepicker({dateFormat: 'yy-mm-dd'});
				
            $('#searchForm').submit(function(event) {
                var formData = {
                    startDate: $('#from_date').val(),
                    endDate: $('#to_date').val()
                };
                $.ajax({
                    type: "POST",
                    url: "searchAvaliability.php",
                    data: formData,
                    dataType: "json",
                    encode: true,

                }).done(function(data) {
                    var tbl = document.getElementById("roomBookings"); //find the table in the HTML  
                    var rowCount = tbl.rows.length;

                    for (var i = 1; i < rowCount; i++) {
                        //delete from the top - row 0 is the table header we keep
                        tbl.deleteRow(1);
                    }

                    //populate the table
                    //data.length is the size of our array

                    for (var i = 0; i < data.length; i++) {
                        var rn = data[i]['roomname'];
                        var rt = data[i]['roomtype'];
                        var bd = data[i]['beds'];
                        //create a table row with four cells
                        //Insert new cell(s) with content at the end of a table row 
                        //https://www.w3schools.com/jsref/met_tablerow_insertcell.asp  
                        tr = tbl.insertRow(-1);
                        var tabCell = tr.insertCell(-1);
                        tabCell.innerHTML = rn;
                        var tabCell = tr.insertCell(-1);
                        tabCell.innerHTML = rt;
                        var tabCell = tr.insertCell(-1);
                        tabCell.innerHTML = bd;
                    }
                });
                event.preventDefault();
            })
        })
  </script>
</html>
