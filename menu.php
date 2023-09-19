    <div id="header">
      <div id="logo">
        <div id="logo_text">
          <!-- class="logo_colour", allows you to change the colour of the text -->
          <h1><a href="/"><span class="logo_colour">Ongaonga Bed & Breakfast</span></a></h1>
          <h2>Make yourself at home is our slogan. We offer some of the best beds on the east coast. Sleep well and rest well.</h2>
        </div>
      </div>
      <div id="menubar">
        <ul id="menu">
          <!-- put class="selected" in the li tag for the selected page - to highlight which page you're on -->
          <?php
          $current_page = basename($_SERVER['PHP_SELF']); // Gets the current filename
          ?>
          <li><a href="/">Home</a></li>
          <li><a href="listrooms.php">Room Listing</a></li>
        <?php
        if ($_SESSION['loggedin'] == 1)
        {
          ?>
          <li><a href="listcustomers.php">Customer listing</a></li>
          <li><a href="current_bookings.php">Booking listing</a></li>
          <?php
        } else {
          ?>
          <li><a href="registercustomer.php">Register</a></li>
          <li><a href="login.php">Login</a></li>
          <?php
        }
        ?>
      </ul>
      </div>
    </div>

	