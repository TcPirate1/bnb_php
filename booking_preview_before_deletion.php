<!-- Assumes customer is signed up and logged in -->
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Booking preview before deletion</title>
  </head>
  <style>
    div {
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
    <h1>Booking preview before deletion</h1>
    <a href="current_bookings.php">[Return to the booking listing]</a>
    <a href="/bnb_php/">[Return to main page]</a>

    <div>
      <p class="roomdetail"><span>Booking detail #2</span></p>
      <p>Room name:</p>
      <p class="information">Kellie</p>
      <p>Checkin Date:</p>
      <p class="information">2018-09-15</p>
      <p>Checkout Date:</p>
    </div>
    <h2>Are you sure you want to delete this Booking?</h2>
    <button>Delete</button>
    <a href="current_bookings.php">[Cancel]</a>
  </body>
</html>
