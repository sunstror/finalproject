<?php include "base.php"; ?>
<!DOCTYPE html> 
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />  
 
<title>Video Tracker</title>
<link rel="stylesheet" href="final.css" type="text/css" />
</head>  
<body>  
<div id="main">
<?php
if(!empty($_POST['username']) && !empty($_POST['password']))
{
    $username = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['email'];
     
     $stmt = $mysqli->prepare("SELECT UserId FROM users WHERE Username = ?");
     
      $stmt->bind_param('s', $username);  // Bind "$username" to parameter.
      $stmt->execute();    // Execute the prepared query.
      $stmt->store_result();

      
      if ($stmt->num_rows == 1) 
      {   
          echo "<p>That username has already been taken!</p>";

          echo "<a id = 'title' href = 'register.php'>Click here to try again</a>";
          echo "<a id = 'title' href = 'final.php'>Click here login</a>";
          $stmt->close();
        }else
        {
            $stmt = $mysqli->prepare("INSERT INTO users(Username, Password, EmailAddress) VALUES (?, ?, ?)");
     
              $stmt->bind_param('sss', $username, $password, $email);  // Bind variables to parameter.
              $stmt->execute();    // Execute the prepared query.
              $stmt->close();

              $_SESSION['Username'] = $username;
              $_SESSION['LoggedIn'] = 1;
              echo "<meta http-equiv='refresh' content='2;final.php'>";
        }
    }
    else
    {
        ?>
         
       <h1>Register</h1>
         
       <p>Please enter your details below to register.</p>
         
        <form method="post" action="register.php" name="registerform" id="registerform">
        <fieldset>
            <label for="username">Username:</label><input type="text" name="username" id="username" /><br />
            <label for="password">Password:</label><input type="password" name="password" id="password" /><br />
            <label for="email">Email Address:</label><input type="text" name="email" id="email" /><br />
            <input type="submit" name="register" id="register" value="Register" />
        </fieldset>
        </form>
     
    <?php
}
?>
 
</div>
</body>
</html>