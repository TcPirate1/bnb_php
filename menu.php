    <div id="header">
      <div id="logo">
        <div id="logo_text">
          <!-- class="logo_colour", allows you to change the colour of the text -->
          <h1><a href="/bnb_php/"><span class="logo_colour">Ongaonga Bed & Breakfast</span></a></h1>
          <h2>Make yourself at home is our slogan. We offer some of the best beds on the east coast. Sleep well and rest well.</h2>
        </div>
      </div>
      <div id="menubar">
        <ul id="menu">
          <!-- put class="selected" in the li tag for the selected page - to highlight which page you're on -->
          <?php
          $current_page = basename($_SERVER['PHP_SELF']); // Gets the current filename
          ?>
        <li <?php if ($current_page === 'index.php') echo 'class="selected"'; ?>>
          <a href="/bnb_php/">Home</a>
        </li>
        <li <?php if ($current_page === 'listcustomers.php') echo 'class="selected"'; ?>>
          <a href="listcustomers.php">Customer listing</a>
        </li>
        <li <?php if ($current_page === 'listrooms.php') echo 'class="selected"'; ?>>
          <a href="listrooms.php">Rooms listing</a>
        </li>
        <li <?php if ($current_page === 'current_bookings.php') echo 'class="selected"'; ?>>
          <a href="current_bookings.php">Bookings listing</a>
        </li>
        <li <?php if ($current_page === 'registercustomer.php') echo 'class="selected"'; ?>>
          <a href="registercustomer.php">Register</a>
        </li>
        <li <?php if ($current_page === 'login.php') echo 'class="selected"'; ?>>
          <a href="login.php">Login</a>
        </li>
      </ul>
      </div>
    </div>

	