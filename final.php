<?php include "base.php"; ?>
<!DOCTYPE html>
<html>
   <head>
  	<meta charset="utf-8" />
    <link rel="stylesheet" href="final.css" type="text/css" />
  	<title>Video Tracker</title>
  </head>
  <body>
     <h1 id = "title">Video Tracker </h1>
     <br>
     <h2 id = "title">Now you can track your video collection like a pro!</h2>
     <br>
    <div id = "main">

    <?php
    if(!empty($_SESSION['LoggedIn']) && !empty($_SESSION['Username']))
    {
      $username = $_SESSION['Username'];

       echo "<form method='post' action='final.php'>";
       echo "<p>Name <br /> <input type='text' name='name'><br /></p>";
       echo "<p>Genre <br /> <input type='text' name='genre'><br /></p>";
       echo "<p>Length <br /> <input type='text' name='length'><br /></p>";
       echo "<p><input type='submit' value='Add Video'></p>";
       echo "</form>";

       echo "<br>";
       echo "<br>";
        
        $stmt = $mysqli->prepare("SELECT name, genre, length FROM videos2 WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->bind_result($vidName, $vidGen, $vidLen);
        $stmt->store_result();
         
          echo "<table border = '1'>";
          while($stmt->fetch())
            {
              echo "<tr>";
              echo "<td> $vidName </td>";
              echo "<td> $vidGen </td>";
              echo "<td> $vidLen </td>";
              echo "</tr>";
              }
            echo "</table>";   

      if($_SERVER['REQUEST_METHOD'] == 'POST')
      { 
        
          $name = $_POST['name'];
          $genre = $_POST['genre'];
          $length = $_POST['length'];

          /* Prepared statement, stage 1: prepare */
          if (!($stmt = $mysqli->prepare("INSERT INTO videos2(username, name, genre, length) VALUES (?, ?, ?, ?)")))
          {
            echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
          }

            /* Prepared statement, stage 2: bind and execute */
          
          if (!$stmt->bind_param("sssi", $username, $name, $genre, $length)) 
          {
            echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
          }

          if (!$stmt->execute()) 
          {
            echo "Execute failed: (" . $mysqli->errno . ") " . $mysqli->error;
          }
        
        if (!($stmt = $mysqli->prepare("SELECT name, genre, length FROM videos2 WHERE username = ?")))
          {
            echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
          }
          if (!$stmt->bind_param("s", $username)) 
          {
            echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
          }
           
          if (!$stmt->execute()) 
          {
            echo "Execute failed: (" . $mysqli->errno . ") " . $mysqli->error;
          }
          if(!($stmt->bind_result($vidName, $vidGen, $vidLen)))
          {
            echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
          }
           $stmt->store_result();
         
          echo "<table border = '1'>";
          while($stmt->fetch())
            {
              echo "<tr>";
              echo "<td> $vidName </td>";
              echo "<td> $vidGen </td>";
              echo "<td> $vidLen </td>";
              echo "</tr>";
              }
            echo "</table>";   
        }
        echo "<br>";
        echo "<br>";
        echo "<a href = 'logout.php'>Click here to logout</a>";
    }
    elseif(!empty($_POST['username']) && !empty($_POST['password']))
    {
      $username = $_POST['username'];
      $password = $_POST['password'];
      
      $stmt = $mysqli->prepare("SELECT password FROM users WHERE Username = ?");
     
      $stmt->bind_param('s', $username);  // Bind "$username" to parameter.
      $stmt->execute();    // Execute the prepared query.
      $stmt->store_result();

      // get variables from result.
      $stmt->bind_result($db_password);
      $stmt->fetch();
      
      if ($stmt->num_rows == 1) 
      {
        if($db_password == $password)
        {
          $_SESSION['Username'] = $username;
          $_SESSION['LoggedIn'] = 1;
           echo "<meta http-equiv='refresh' content='2;final.php'/>";
        }else
        {
          
          
           echo "<h1 id = 'title'>Login was not successful</h1>"; 
           echo "<a id = 'title' href = 'final.php'>Click here to try again</a>";

          

          
        }
      }
    }
    else
    {
      ?>
      <h1>Member Login</h1>

      <p>Thanks for visiting! Please either login below, or <a href="register.php">click here to register</a>.</p>

      <form method="post" action="final.php" name="loginform" id="loginform">
      <fieldset>
      <label for="username">Username:</label><input type="text" name="username" id="username" /><br />
      <label for="password">Password:</label><input type="password" name="password" id="password" /><br />
      <input type="submit" name="login" id="login" value="Login" />
      </fieldset>
      </form>
    <?php
    }
    ?> 
  </div> 
  </body>
</html>