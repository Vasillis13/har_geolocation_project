<!doctype html>
<html>
<head>
      <title>Εγγραφή</title>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

      <style>
        * {font-family: Helvetica}
        form {border: 3px solid #f1f1f1;}

        input[type=name], input[type=email], input[type=password]{
          width: 100%;
          padding: 12px 20px;
          margin: 8px 0;
          display: inline-block;
          border: 1px solid #ccc;
          box-sizing: border-box;
        }

        input[type=submit]{
          background-color: skyblue;
          color: white;
          padding: 14px 20px;
          margin: 8px 0;
          border: none;
          cursor: pointer;
          width: 100%;
          opacity: 0.9;
        }

        input[type=submit]:hover{
          opacity:1;
        }
        
        .container {
          padding: 16px;
        }
        
        .center {
          text-align: center;
        }

        .box-container{
          width: 40%;
          margin: auto;
          padding: 0rem;
          border: 0rem;
          
          
        }

      </style>

      <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  </head>
  <body>  

    <?php

    include "db_connection.php";
    include "User.php";

    $nameErr = $emailErr = $passwordErr = "";
    $name = $email = $password = "";
    $count = 0;


    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (empty($_POST["name"])) {
            $nameErr = "Συμπληρώστε το όνομά σας";
        } else {
            $name = test_input($_POST["name"]);
            $count ++;
        }

        if (empty($_POST["email"])) {
            $emailErr = "Συμπληρώστε το email σας";
        } else {
            $email = test_input($_POST["email"]);
            $count++;
        }

        if (empty($_POST["password"])) {
            $passwordErr = "Συμπληρώστε τον κωδικό σας";
        } else {
            $password = test_input($_POST["password"]);
            if (! preg_match("/^\S*(?=\S{8,})(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])(?=\S*[\W])\S*$/", $password)) {
                $passwordErr = "Ο κωδικός πρέπει να έχει τουλάχιστον 8 λατινικούς χαρακτήρες και τουλάχιστον ένα : \n 1) πεζό γράμμα \n 2) κεφαλαίο γράμμα \n 3) νούμερο \n 4) χαρακτήρα (π.χ @ # $ ^ & ...) \n ";
            } else {
                $count++;
            }
        }
    }
    if ($count == 3) {
        $connection = connect();
        $sql = "INSERT INTO users (username, email, password, id, isAdmin) VALUES ('$name', '$email', '$password', NULL, DEFAULT)";
        if (mysqli_query($connection, $sql)) {
            echo "Επιτυχής εγγραφή";
        } else {
            echo "Error :" .$sql . "<br>" . mysqli_error($connection);
        }
        disconnect($connection);
    }

    ?>
    
    <nav class="navbar navbar-expand-sm bg-light">
      <a class="navbar-brand" href="index.html">
        <img class="img-responsive" src="images/HAR_geo.png" >
      </a>      
    </nav>
    
    <section class="jumbotron text-center">
        <div class="container">
        <div class="box-container">
      <form method="post"  action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">  
        <div class="center">
          <h2 class="register_heading">Εγγραφή</h2>
        </div>
        <div class="container">
          Όνομα: <input type="name" name="name" autocomplete="off" required>
        </div>

        <div class="container">
          E-mail: <input type="email" name="email" autocomplete="off" required>
        </div>

        <div class="container">
          Κωδικός: <input type="password" name="password" autocomplete="off" required>
        </div>

        <div class="container">
          <input type="submit" name="submit" value="Υποβολή"> 
        </div>

      </form>
    </div>
        </div>
    </section>

    

    </body>
</html>