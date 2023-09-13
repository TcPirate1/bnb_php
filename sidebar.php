<div class="sidebar">
        <!-- insert your sidebar items here -->
        <br>
        <?php
          if(isset($_SESSION['username']))
          {
            if(isset($_POST['logout'])) logout();
              $un = $_SESSION['username'];

              if($_SESSION['loggedin'] == 1)
              {
                ?>
                <h6>Logged in as <?php echo $un; ?></h6>
                <form method="POST">
                  <input type="submit" name="logout" value="Logout">
                </form>
                <?php
              }
          }
        ?>
      </div>