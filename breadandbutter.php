<!doctype html>

<!-- CS 304 Project Draft Version
     Giovanina Mier
     April 21, 2015

     FILENAME: breadandbutter.php
     
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
          <h1><a href="#">Bread &amp; Butter</a></h1>
        </div>
        <div id="menu">
          <ul>
            <li class="current_page_item"><a href="#" accesskey="1" title="">Home</a></li>
            <li><a href="search.php" accesskey="2" title="">Search</a></li>
            <li><a href="browse.php" accesskey="3" title="">Browse</a></li>
            <li><a href="recipebox.php" accesskey="4" title="">Recipe Box</a></li>
            <li><a href="login" accesskey="5" title="">Log In</a></li>
          </ul>
        </div>
      </div>
    </div>
    <!-- end header and nav bar -->

    <div id="page-wrapper">
      <div id="page" class="container">
          <h2>Welcome to Bread &amp; Butter!</h2>
          <p>Bread &amp; Butter provides easy access to simple recipes, and the ability to
            search for recipes by not only ingredients, but cooking equipment and time needed.
          </p>
      </div>
    </div>

    <div class="wrapper">
      <div id="three-column" class="container">
        <div id="tbox1">
          <div class="title">
            <h2>Quick Recipes</h2>
          </div>
          <a href="browse.php" class="button">Browse</a> </div>

        <div id="tbox2">
          <div class="title">
            <h2>Essential Ingredients</h2>
          </div>        
          <a href="search.php" class="button">Search</a> </div>

        <div id="tbox3">
          <div class="title">
            <h2>Favorite Meals</h2>
          </div>
          <a href="#" class="button">Recipe Box</a> </div>
        </div> 
    </div>

  </div>
    <div id="copyright" class="container">
    <p>&copy; Giovanina Mier. All rights reserved. | 
      Design by <a href="http://templated.co" rel="nofollow">TEMPLATED</a>.</p>
    </div>
    
  </body>

</html>
