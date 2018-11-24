<?php

session_start();

if(isset($_SESSION['username'])) {
  header("Location: ../home/home.php");
}

include('../../include/includeLogin.php');

?>

<!doctype html>
<html>
  <head>
    <meta charset="UTF-8" />
    <title>Home</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <?php echo $head; ?>
  </head>
  <body class="error-body no-top">
    <div class="container">
      <div class="row login-container column-seperation">
        <div class="col-md-5 col-md-offset-4">
          <br>
          <form action="process.php" class="login-form validate" id="login-form" method="POST" name="login-form">
            <div class="row">
              <div class="form-group col-md-10">
                <label class="form-label">Username</label>
                <input class="form-control" id="txtusername" name="username" type="text" required>
              </div>
            </div>
            <div class="row">
              <div class="form-group col-md-10">
                <label class="form-label">Password</label> <span class="help"></span>
                <input class="form-control" id="txtpassword" name="password" type="password" required>
              </div>
            </div>
            <!-- <div class="row">
              <div class="control-group col-md-10">
                <div class="checkbox checkbox check-success">
                  <input id="checkbox1" type="checkbox" value="1">
                  <label for="checkbox1">Remember Me</label>
                </div>
              </div>
            </div> -->
            <div class="row">
              <div class="col-md-10">
                <button class="btn btn-primary btn-cons pull-right" type="submit">Login</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
    <!-- END CONTAINER -->
  </body>
  <?php echo $footer; ?>
</html>