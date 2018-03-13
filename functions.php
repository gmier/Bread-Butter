<?php

  /* FILENAME: functions.php
     Giovanina Mier
     April 24, 2014
     CS 304: Final Project
     Bread & Butter

     Contains all needed php methods to search and browse recipes
     in the database. Included as needed in pages of the web interface.
  */

  require_once("MDB2.php");
  require_once("/home/cs304/public_html/php/MDB2-functions.php");
  require_once('gmier-dsn.inc');

  //database handle
  $dbh = db_connect($gmier_dsn);

  // ------------------------------------------------------------------------------------------------
  // SEARCH METHODS
  // ------------------------------------------------------------------------------------------------

  // Function to search the recipe table using a keyword. Searches for
  // partial matches of the keyword in the name attribute and prints
  // A list which links to each recipes individual page. Displays
  // the number of recipes found matching search criteria.
  function basic_search($dbh) {
    if (isset($_POST['criteria']) ) {

      $search_by = $_POST['criteria'];
      $search_term = $_POST['search_term'];

      //search using keyword (recipe name)
      if ($search_by == 'keyword') {
        $sql = "SELECT RID, name, time FROM recipe WHERE name LIKE ?";
        $values = array("%".$search_term."%");

      // search using time in minutes less than or equal to search term
      } else if ($search_by == 'time') {
        $sql = "SELECT RID, name, time FROM recipe WHERE time <= ?";
        $values = array($search_term); 

      // search using ingredient name
      } else if ($search_by == 'ingredient') {
        $sql = "SELECT RID, recipe.name, time FROM recipe, ingredient 
                WHERE ingredient.name LIKE ? AND RID = recipeID";
        $values = array("%".$search_term."%");

      // search using equipment name
      } else if ($search_by == 'equipment') {
        $sql = "SELECT RID, recipe.name, time FROM recipe, equipment 
                WHERE equipment.name LIKE ? AND RID = recipeID";
        $values = array("%".$search_term."%");
      }  
 
        $resultset = prepared_query($dbh,$sql,$values);
        $num_rows = $resultset->numRows();
        $resultURL = "recipe.php"; //$_SERVER['PHP_SELF'];

        echo "<p>$num_rows results found.";
        while($row = $resultset->fetchRow(MDB2_FETCHMODE_ASSOC)) {
            $RID = $row['RID'];
            $name = $row['name'];
            $time = $row['time'];
            echo "<p><a href='$resultURL?RID=$RID' id='recipelink'>$name</a> $time minutes\n";
        }
    }
  }

  // ------------------------------------------------------------------------------------------------
  // DISPLAY METHODS
  // ------------------------------------------------------------------------------------------------

  // Function to display all recipes currently in the database in
  // a simple list format. Will link to pages displaying full 
  // information of recipe. Includes a sorting mechanism
  // so the user can browse recipes according to preferences of title
  // rating, newest, or quickest.
	function display_all($dbh) {

      $sql = "SELECT RID, name, time FROM recipe ORDER BY name ASC";

      if (isset($_POST['sort_by']) ) {
        $sort_by = $_POST['sort_by'];
        // sort recipes alphabetically
        if ($sort_by == 'title') {
          $sql = "SELECT RID, name, time FROM recipe ORDER BY name ASC";
        // sort recipes by highest rating
        } else if ($sort_by == 'rating') {
          $sql = "SELECT RID, name, time, num_stars FROM recipe, rating
                  WHERE RID = recipeID ORDER BY num_stars DESC";
        // sort recipes by most recently added
        } else if ($sort_by == 'newest') {
          $sql = "SELECT RID, name, time FROM recipe ORDER BY RID DESC";
        // sort recipes by shortest time
        } else if ($sort_by == 'quickest') {
          $sql = "SELECT RID, name, time FROM recipe ORDER BY time ASC";
        }
      }

      $resultset = query($dbh, $sql);
      $resultURL = "recipe.php"; //$_SERVER['PHP_SELF'];
      
      while($row = $resultset->fetchRow(MDB2_FETCHMODE_ASSOC)) {
        $RID = $row['RID'];
        $name = $row['name'];
        $time = $row['time'];
        echo "<p><a href='$resultURL?RID=$RID'>$name</a> $time minutes\n";
      }
  }

  // Function to display all recipes associated to one user's account in
  // a simple list format. Will link to pages displaying full 
  // information of recipe. Includes a sorting mechanism
  // so the user can browse recipes according to preferences.
  function display_users($dbh, $id) {

      $sql = "SELECT RID, name, time FROM recipe WHERE userID = $id ORDER BY name ASC";

      if (isset($_POST['sort_by']) ) {
        $sort_by = $_POST['sort_by'];
        // sort recipes alphabetically
        if ($sort_by == 'title') {
          $sql = "SELECT RID, name, time FROM recipe WHERE userID = $id ORDER BY name ASC";
        // sort recipes by highest rating
        //} else if ($sort_by == 'rating') {
        //  $sql = "SELECT RID, name, time, num_stars FROM recipe, rating
        //          WHERE RID = recipeID AND rating.userID = $id ORDER BY num_stars DESC";
        // sort recipes by most recently added
        } else if ($sort_by == 'newest') {
          $sql = "SELECT RID, name, time FROM recipe WHERE userID = $id ORDER BY RID DESC";
        // sort recipes by shortest time
        } else if ($sort_by == 'quickest') {
          $sql = "SELECT RID, name, time FROM recipe WHERE userID = $id ORDER BY time ASC";
        }
      }

      $resultset = query($dbh, $sql);
      $resultURL = "recipe.php"; 

      while($row = $resultset->fetchRow(MDB2_FETCHMODE_ASSOC)) {
        $RID = $row['RID'];
        $name = $row['name'];
        $time = $row['time'];
        echo "<p><a href='$resultURL?RID=$RID'>$name</a> $time minutes\n";
      }

  }


  // Function to display a full view of a recipe, including its name,
  // time required, url, ingredients, and equipment. Displays page using
  // the recipe's RID. 
  function display_full_result($dbh) {
    if (isset($_GET['RID'])) {
      
      $search_ID = $_GET['RID'];
      $sql = "SELECT RID, name, time, link FROM recipe WHERE RID = ?";

      $values = array($search_ID);
      $resultset = prepared_query($dbh,$sql,$values);
      $num_rows = $resultset->numRows();
      $resultURL = $_SERVER['PHP_SELF'];

      $row = $resultset->fetchRow(MDB2_FETCHMODE_ASSOC);

      $RID = $row['RID'];
      $name = $row['name'];
      $time = $row['time'];
      $link = $row['link'];

      echo "<p><h2>$name</h2>
            <p>Time Required: $time minutes
            <h3>Ingredients:</h3>
            <ol>\n";
      display_list($dbh, $RID, "ingredient");
      echo "</ol>\n";

      echo "<h3>Equipment:</h3>
            <ul>\n";
      display_list($dbh, $RID, "equipment");
      echo "</ul>
            <p><a href='$link' class='button-small'>View Full Recipe</a>\n";
    }
  }

  // Adds ingredients or equipment from the given table that are
  // associated with a given recipe ID to a list. 
  function display_list($dbh, $RID, $tablename) {
    $sql = "SELECT name FROM $tablename WHERE recipeID = $RID";
    $resultset = query($dbh, $sql);
    
    while($row = $resultset->fetchRow(MDB2_FETCHMODE_ASSOC)) {
        $name = $row['name'];
        echo "<li>$name";
      }
  }


  function display_ratings($dbh) {
    if (isset($_GET['RID'])) {
      
      $search_ID = $_GET['RID'];
      $sql = "SELECT num_stars, comment_text, username FROM rating, user 
              WHERE userID = UID AND recipeID = ? ORDER BY r_ID DESC";

      $values = array($search_ID);
      $resultset = prepared_query($dbh,$sql,$values);

      $resultURL = $_SERVER['PHP_SELF'];

      echo "<h2>Comments</h2>\n";

      while($row = $resultset->fetchRow(MDB2_FETCHMODE_ASSOC)) {

        $stars = $row['num_stars'];
        $comment = $row['comment_text'];
        $user = $row['username'];

        echo "<h4>$user gave this recipe a $stars star rating:</h4>
              <p>$comment</p>\n";
      }
       echo "<br><br>\n";
    }
  }

  // ------------------------------------------------------------------------------------------------
  // INSERT METHODS 
  // ------------------------------------------------------------------------------------------------

  // Inserts a recipe into the database. Currently the required 
  // fields are name, link, and time required. 
  function insertRecipe($dbh) {
   
    if(isset($_POST['rname']) && isset($_POST['link']) && isset($_POST['time'])) {
      if(!($_POST['rname'] == "") && !($_POST['link'] == "") && !($_POST['time'] == "")) {
        $recipe_name = $_POST['rname'];
        $link = $_POST['link'];
        $time = $_POST['time'];

        $insert_recipe = "INSERT INTO recipe VALUES (null, ?, ?, null, ?, 1)";
        $values = array(htmlspecialchars($recipe_name), $time, htmlspecialchars($link));
        prepared_statement($dbh,$insert_recipe,$values);

        // retrieve the last recipe ID to use for adding ingredients/equipment
        $rs = query($dbh,"SELECT last_insert_id()");
        $row = $rs->fetchRow();
        $id = $row[0];

        // add ingredients to the database
        if (isset($_POST['ingredients'])) {
          foreach($_POST['ingredients'] as $key => $text_field) {
            $insert_ingredient = "INSERT INTO ingredient 
                                  VALUES (null, ?, (SELECT RID FROM recipe WHERE RID=$id))";
            $values = array(htmlspecialchars($text_field));
            prepared_statement($dbh,$insert_ingredient,$values);
          }
        } 

        // add equipment to the database
        if (isset($_POST['equipment'])) {
          foreach($_POST['equipment'] as $key => $text_field) {
            $insert_equipment = "INSERT INTO equipment
                                 VALUES (null, ?, (SELECT RID FROM recipe WHERE RID=$id))";
            $values = array(htmlspecialchars($text_field));
            prepared_statement($dbh,$insert_equipment,$values);
          }
        }

        header("Location: recipebox.php");
      } 
    }
  }

  // Method to add a comment and rating (out of 5 stars). Ratings are linked to the user
  // submitting them, and the recipe they are about.
  function addComment($dbh) {
    if (isset($_POST['newcomment']) && isset($_POST['starrating']) && isset($_GET['RID'])) {
      
        $comment = $_POST['newcomment'];
        $rating = $_POST['starrating'];
        $RID = $_GET['RID'];
        $UID = $_SESSION['user_id'];

	echo "<p>RID is $RID";  // scott
        $insert_rating = "INSERT INTO rating VALUES (null, ?, ?, $RID, $UID)";
	echo "<p>SQL is $insert_rating"; // scott
        $values = array($rating, htmlspecialchars($comment));
        prepared_statement($dbh,$insert_rating,$values);

	// omitted by scott
        // header("Location: recipe.php?RID=$RID");
    }
  }

  // ------------------------------------------------------------------------------------------------
  // FORMS
  // ------------------------------------------------------------------------------------------------

  // Prints a form to add a recipe. 
  function print_add_form() {
    echo '<form method="POST" action="' . $_SERVER['PHP_SELF'] . '">';
    echo '<label>Recipe Name:</label><input type="text" name="rname" required><br><br>
          <label>Recipe URL:</label><input type="url" name="link" required><br><br>
          <label>Time Needed (minutes):</label><input type="text" name="time" required><br><br>   
          <h4>Ingredients:</h4>
          <p>Enter each ingredient needed by name.
          <div class="ingredient-fields-wrap">
            <button class="add-ingredient-button">Add More Ingredients</button><br>
            <div><input type="text" name="ingredients[]"></div>
          </div>
          <h4>Equipment:</h4>
          <p>Enter each type of equipment needed by name.
          <div class="equipment-fields-wrap">
            <button class="add-equipment-button">Add More Equipment</button><br>
            <div><input type="text" name="equipment[]"></div>
          </div>
          <p><input type="submit" value="Add Recipe" name="submit" class="button-small">
          </form>';
  }

  // Prints a form to search for a recipe.
  function print_search_form() {
    echo '<form method="POST" action="' . $_SERVER['PHP_SELF'] . '">';
    echo '<select name="criteria">
            <option value="keyword">Name
            <option value="ingredient">Ingredient
            <option value="time">Time
            <option value="equipment">Equipment
          </select>
          <input type="text" name="search_term" data-error="cannot be empty" placeholder="">
          <input type="submit" name="submit" value="Search">
          </form>';
  }

  // Prints a form to sort recipes.
  function print_sort_form() {
    echo '<form method="POST" action="' . $_SERVER['PHP_SELF'] . '">';
    echo '<select name="sort_by">
            <option value="title">Title
            <option value="rating">Highest Rated
            <option value="newest">Most Recent
            <option value="quickest">Quickest
          </select>
          <input type="submit" name="submit" value="Sort By">
          </form><br><br>';
  }

  function print_comment_form() {
    echo '<form method="POST" action="' . $_SERVER['PHP_SELF'] .'?RID='. $_GET['RID'] . '">';
    echo '<h2>Rate this Recipe</h2>
            <textarea rows="1" cols="55" name="newcomment"></textarea>
            <h4>Rating:</h4>
            <select name="starrating">
              <option value="5">5
              <option value="4">4
              <option value="3">3
              <option value="2">2
              <option value="1">1
            </select>
            <br><br>
            <p><input type="submit" name="submit" value="Submit"></input>
          </form>';
  }

?>