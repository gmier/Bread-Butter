<?php
  session_start();

  if(empty($_SESSION['user_id'])) { 
    // If they are not, redirect them to the login page. 
    header("Location: login.php"); 
    die("Redirecting to login.php"); 
  } 
?>

<!doctype html>

<!-- CS 304 Project Draft Version
     Giovanina Mier
     April 21, 2015

     FILENAME: recipebox.php
     
-->

<html>
  <head>
    <meta charset='utf-8'>
    <meta name=author content="Giovi Mier">

    <link rel="stylesheet" href="default.css" type="text/css">
    <link href="fonts.css" rel="stylesheet" type="text/css">
    <link href="http://fonts.googleapis.com/css?family=Source+Sans+Pro:200,300,400,600,700,900|Quicksand:400,700|Questrial" rel="stylesheet" />

    <link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.17/themes/base/jquery-ui.css" rel="stylesheet" type="text/css" />
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.17/jquery-ui.min.js"></script>
    <script src="addRecipe.js"></script>
    <title>Bread &amp; Butter</title>
  </head>

  <body>
    <!-- header and nav bar -->
    <div id="header-wrapper">
      <div id="header" class="container">
        <div id="logo">
          <h1><a href="breadandbutter.php">Bread &amp; Butter</a></h1>
        </div>
        <div id="menu">
          <ul>
            <li><a href="breadandbutter.php" accesskey="1" title="">Home</a></li>
            <li><a href="search.php" accesskey="2" title="">Search</a></li>
            <li><a href="browse.php" accesskey="3" title="">Browse</a></li>
            <li class="current_page_item"><a href="#" accesskey="4" title="">Recipe Box</a></li>
            <li><a href="login.php" accesskey="5" title="">Log In</a></li>
          </ul>
        </div>
      </div>
    </div>
    <!-- end header and nav bar -->

    <div id="page-wrapper">
      <div id="page" class="container">
        <div id="content">
          <h2>Welcome to your recipe box <?php echo htmlentities($_SESSION['username'], ENT_QUOTES, 'UTF-8');?>!</h2>
          <!--<span id="addbutton">ADD RECIPE</span>-->
          <br>
          <?php
            include("functions.php");
	          print_sort_form();
            $id = $_SESSION['user_id'];
            display_users($dbh, $id);
          ?>
        </div>

        <div id="sidebar">
          <div class="default">
            <h2>Add a New Recipe</h2>  
            <?php 
              print_add_form();
              insertRecipe($dbh);
            ?>    
          </div>
        </div>
      </div>
    </div>

    <div id="copyright" class="container">
    <p>&copy; Giovanina Mier. All rights reserved. |  
      Design by <a href="http://templated.co" rel="nofollow">TEMPLATED</a>.</p>
    </div>

  </body>

</html>
