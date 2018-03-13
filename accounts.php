<?php
	
  /* FILENAME: accounts.php
     Giovanina Mier
     May 19, 2014
     CS 304: Final Project
     Bread & Butter

     Contains all needed php methods to create a user account, log in to a 
     user account, and send a forgotten password via email.
  */

  // Takes username, password, and email to create and validate 
  // a new user account. 
  function createAccount($dbh) {
    if (isset($_POST['email']) && isset($_POST['username']) 
        && isset($_POST['password']) && isset($_POST['password2'])) {

      $email = $_POST['email'];
      $username = $_POST['username'];
      $password = $_POST['password'];
      $password2 = $_POST['password2'];

      if ($email != "" && $username != "" && $password != "") {
	      // Check that passwords match.
	      if ($password == $password2) { 
	      	// Check that the username or email doesn't already exist.
	      	$sql = "SELECT UID FROM user WHERE username = ? OR email = ?";
	      	$values = array($username, $email);
	      	$resultset = prepared_query($dbh,$sql,$values);
	      	$num_rows = $resultset->numRows();

	      	// Username or email already exists, show error message.
	      	if ($num_rows > 0) {
	      		echo "<script type='text/javascript'>alert('Username or email already exists. Please try again.')</script>";
	      	} else {
	      		$insert_account = "INSERT INTO user VALUES (null, ?, ?, ?)";
	        	$values = array(htmlspecialchars($username), htmlspecialchars($password), htmlspecialchars($email));
	        	prepared_statement($dbh,$insert_account,$values);
	        	echo "<script type='text/javascript'>alert('Thank you for creating an account!')</script>";
	      	}

	      // Passwords are not the same, do not create account.
	      } else {
	        echo "<script type='text/javascript'>alert('Passwords do not match. Please try again.')</script>";
	      }
	  }
    }
  }

  // function to log a user into an already existing account. Checks to see if any accounts
  // exist with the matching username and password combo, and only proceeds if there is
  // exactly one such account.
  function logIn($dbh) {
  	if (isset($_POST['usrname']) && isset($_POST['passwrd'])) {
  		$username = htmlspecialchars($_POST['usrname']);
  		$password = htmlspecialchars($_POST['passwrd']);

  		// check if account exists
  		$sql = "SELECT UID, username FROM user WHERE username = ? AND password = ?";
	    $values = array($username, $password);
	    $resultset = prepared_query($dbh,$sql,$values);
	    $num_rows = $resultset->numRows();

	    if ($num_rows != 1) {
	    	echo "<script type='text/javascript'>alert('Username and password not found.')</script>";
	    } else {
	    	$row = $resultset->fetchRow(MDB2_FETCHMODE_ASSOC);
	    	$_SESSION['user_id'] = $row['UID'];
            $_SESSION['username'] = $row['username'];
            $_SESSION['token'] = substr(md5(rand()), 0, 10);
            header("Location: recipebox.php");
            exit;
	    }
  	}
  }

  // Method to send a pasword to a users email if it exists in the database.
  function sendPassword($dbh) {
  	if (isset($_POST['email'])) {
  		$email = $_POST['email'];

  		//check if email exists for an account
  		$sql = "SELECT username, password, email FROM user WHERE email = ?";
  		$values = array($email);
  		$resultset = prepared_query($dbh,$sql,$values);
  		$num_rows = $resultset->numRows();

	    if ($num_rows != 1) {
	    	echo "<script type='text/javascript'>alert('Invalid email address.')</script>";
	    } else {
	    	$row = $resultset->fetchRow(MDB2_FETCHMODE_ASSOC);
	    	$username = $row['username'];
	    	$password =  $row['password'];
	    	$email = $row['email'];

	    	$msg = "Your user account information for Bread&Butter:\n username: ". $username ."
	    			\n password:" . $password ."";
	    	mail($email, "Bread&Butter Account Information", $msg);
	    	echo "<script type='text/javascript'>alert('Your password has been sent!')</script>";
	    }
  	}
  }


  // ------------------------------------------------------------------------------------------------
  // FORMS
  // ------------------------------------------------------------------------------------------------

  // Prints a form for the user to login using username and password.
  function print_login_form() {
    echo '<h2>Member Login</h2><br>
    	  <form method="POST" action="' . $_SERVER['PHP_SELF'] . '">
            <label>Username:</label>
            <input type="text" name="usrname" data-error="cannot be empty" required>
            <br><br><label>Password:</label>
            <input type="password" name="passwrd" data-error="cannot be empty" required>
            <br><br><input type="submit" name="login" value="Login">
            <br><br>
            <!--<p>Not a member? <a href="#" id="clickbutton">Click here</a> to register!</p>-->
          </form><br><br>';
  }


  // Prints a form for the user to create an account.
  function print_register_form() {
    echo '<form method="POST" action="' . $_SERVER['PHP_SELF'] . '">
            <label>Email:</label>
            <input type="email" name="email" data-error="cannot be empty" required>
            <br><br><label>Username:</label>
            <input type="text" name="username" data-error="cannot be empty" required>
            <br><br><label>Password:</label>
            <input type="password" name="password" data-error="cannot be empty" required>
            <br><br><label>Retype Password:</label>
            <input type="password" name="password2" data-error="cannot be empty" required>
            <br><br><input type="submit" name="register" value="Register">
          </form>';
  }

  // Prints a form for the user to email a forgotten password.
  function print_forgotpassword_form() {
    echo '<h3>Forgot your password?</h3>
          	<p>Enter your e-mail below, and we will send your password to you.</p>
          	<form method="POST" action="' . $_SERVER['PHP_SELF'] . '">
              <input type="email" name="email" required>
              <input type="submit" name="sendpassword" value="Send Password">
            </form>';
  }

  // Prints a form for the user to log out.
  function print_logout_form() {
  	echo '<h3>Already logged in as '. htmlentities($_SESSION["username"], ENT_QUOTES, "UTF-8") . '?</h3>
          <a href="logout.php" class="button-small">Log Out</a>
          <br><br>';
  }

?>