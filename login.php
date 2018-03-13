<?php
   session_start();
?>

<!doctype html>

<!-- CS 304 Project Draft Version
     Giovanina Mier
     April 21, 2015

     FILENAME: login.php
     
-->

<html>
  <head>
    <meta charset='utf-8'>
    <meta name=author content="Giovi Mier">

    <link rel="stylesheet" href="default.css" type="text/css">
    <link href="fonts.css" rel="stylesheet" type="text/css">
    <link href="http://fonts.googleapis.com/css?family=Source+Sans+Pro:200,300,400,600,700,900|Quicksand:400,700|Questrial" rel="stylesheet" />


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
            <li><a href="recipebox.php" accesskey="4" title="">Recipe Box</a></li>
            <li class="current_page_item"><a href="#" accesskey="5" title="">Log In</a></li>
          </ul>
        </div>
      </div>
    </div>
    <!-- end header and nav bar -->

    <div id="page-wrapper">
      <div id="page" class="container">
        <div id="content">
          
          <?php
            include("functions.php");
            include("accounts.php");
            if(empty($_SESSION['user_id'])) { 
              print_login_form();
              logIn($dbh);
              print_forgotpassword_form();
              sendPassword($dbh);
            } else {
              print_logout_form();
            }
          ?>
        </div>

        <div id="sidebar">
          <h2>Create an Account</h2> 
          <br>
          <?php
            print_register_form();
            createAccount($dbh);
          ?>
        </div>

      </div>
    </div>

    <div id="copyright" class="container">
    <p>&copy; Giovanina Mier. All rights reserved. | 
      Design by <a href="http://templated.co" rel="nofollow">TEMPLATED</a>.</p>
    </div>

  </body>

</html>
