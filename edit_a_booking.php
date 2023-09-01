<!-- Assumes customer is signed up and logged in -->

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Edit a booking</title>
  </head>
  <body>
    <h1>Edit a booking</h1>
    <h2>
      <a href="current_bookings.php">[Return to the Bookings listing]</a>
      <a href="/bnb_php/">[Return to main page]</a>
    </h2>

    <h2>Booking made for the test</h2>

    <form>
      <label>Room (name,type,beds):</label>
      <select>
        <option>Kellie,S,5</option>
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
