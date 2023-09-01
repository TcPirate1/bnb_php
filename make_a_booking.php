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
  <body>
    <h1>Make a booking</h1>
    <h2><a href="current_bookings.php">[Return to the Bookings listing]</a>
    <a href="/bnb_php/">[Return to main page]</a></h2>

    <h2>Booking for Test</h2>
    <form>
      <label>Room (name,type,beds):</label>
      <select>
        <option>Kellie,S,5</option>
      </select>
      <br />
      <label>Checkin date:</label>
      <input
      required
        id="from"
        type="text"
        placeholder="mm/dd/yyyy"
        pattern="^\d{2}\/\d{2}\/\d{4}"
      />
      <br />
      <label>Checkout date:</label>
      <input
      required
        id="to"
        type="text"
        placeholder="mm/dd/yyyy"
        pattern="^\d{2}\/\d{2}\/\d{4}"
      />
      <br />
      <label>Contact number:</label>
      <input
        type="text"
        placeholder="(###) ### ###"
        pattern="\(\d{3}\) \d{3} \d{4}"
      />
      <br />
      <label>Booking extras:</label>
      <textarea rows="6" cols="25"></textarea>
      <br />
      <button>Add</button>
      <a href="current_bookings.php">[Cancel]</a>
    </form>

    <hr />

    <h2>Search for room avaliability</h2>
    <form>
      <label>Start date:</label>
      <input id="startDate" type="text" placeholder="mm/dd/yyyy" pattern="^\d{2}\/\d{2}\/\d{4}"></input>
      <label>End date:</label>
      <input id="endDate" type="text" placeholder="mm/dd/yyyy" pattern="^\d{2}\/\d{2}\/\d{4}"></input>
      <input type="submit" value="Search avaliability" onclick="searchRooms()"></input>
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

      function searchRooms() {
        var startDate = $("#startDate").val();
        var endDate = $("#endDate").val();

        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function () {
          if (this.readyState == 4 && this.status == 200) {
            $("#result").html(this.responseText);
          }
        };
      }
    });
  </script>
</html>