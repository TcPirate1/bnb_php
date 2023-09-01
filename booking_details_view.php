<!-- Assumes customer is signed up and logged in -->
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Booking Details View</title>
  </head>
  <style>
    fieldset {
      width: 50%;
      border-left: 1px solid #000;
      border-right: 1px solid #000;
      border-bottom: 1px solid #000;
    }
    p {
      margin: 0;
      padding: 0 10px;
    }
    p.information {
      padding: 0 50px;
    }
    p.roomdetail {
      text-align: left;
      border-bottom: 1px solid #000;
      line-height: 0.1em;
      margin: 10px 0 20px;
    }
    p span {
      background: #fff;
      padding: 0 10px;
    }
  </style>
  <body>
    <h2>Logged in as test</h2>
    <h1>Booking Details View</h1>
    <a href="current_bookings.php">[Return to the booking listing]</a>
    <a href="/bnb_php/">[Return to main page]</a>

    <fieldset>
      <legend>Room detail #2</legend>
      <p>Room name:</p>
      <p class="information">Kellie</p>
      <p>Checkin Date:</p>
      <p class="information">2018-09-15</p>
      <p>Checkout Date:</p>
      <p class="information">2018-09-19</p>
      <p>Contact number:</p>
      <p class="information">(001) 123 1234</p>
      <p>Extras:</p>
      <p class="information">nothing</p>
      <p>Review:</p>
      <p class="information">nothing</p>
    </fieldset>
  </body>
</html>
