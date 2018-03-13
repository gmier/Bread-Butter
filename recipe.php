<?php
  session_start();
?>

<!doctype html>

<!-- CS 304 Project Draft Version
     Giovanina Mier
     April 21, 2015

     FILENAME: recipe.php
     
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
            <li><a href="login.php" accesskey="5" title="">Log In</a></li>
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
            display_full_result($dbh);
          ?>
        </div>

        <div id="sidebar">
          <div class="section">
            <?php
              display_ratings($dbh);
              // Check to see that the user is logged in, if not do not display comment form.
              if(empty($_SESSION['user_id'])) { 
                echo "<a href='login.php' class='button-small'>Please log in to rate recipes!</a>";
              // User is logged in, submit comment and rating from form.
              } else { 
                $RID = $_GET['RID']; 
                print_comment_form();
                addComment($dbh);
             }
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
