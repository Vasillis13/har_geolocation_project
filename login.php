<?php
        
        include "User.php";
        include "db_connection.php";

        session_start();

        $nameErr = $passwordErr = $passnameErr =  "";
        $name = $password = "";
        $i = 0;

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (empty($_POST["name"])) {
            } else {
                $name = test_input($_POST["_name"]);
                $i++;
            }

            if (empty($_POST["password"])) {
            } else {
                $password = test_input($_POST["password"]);
                $i++;
            }
            
            $conn = connect();
            
            $name = mysqli_real_escape_string($conn, $_POST["name"]);
            $password = mysqli_real_escape_string($conn, $_POST["password"]);

            $sql = "SELECT count(*) AS countUser FROM users WHERE username = '".$name."' AND password = '".$password."' ";
            $result = mysqli_query($conn, $sql);
            $row = mysqli_fetch_array($result);
            
            $sql_b = "SELECT isAdmin AS isADMIN FROM users WHERE username = '".$name."' AND password = '".$password."' ";
            $result_b = mysqli_query($conn, $sql_b);
            $row_b = mysqli_fetch_array($result_b);

            $sql_c = "SELECT id FROM users WHERE username = '".$name."' AND password = '".$password."'";
            $result_c = mysqli_query($conn, $sql_c);
            $row_c = mysqli_fetch_row($result_c);
           

            disconnect($conn);
            
            $countUser = $row["countUser"];
            
            if (isset($row_b["isADMIN"])) {
                $countisAdmin = $row_b["isADMIN"];
            }

            if ($countUser > 0) {
                if ($countisAdmin == 1) {
                    $_SESSION["id"] = $row_c;
                    $_SESSION["name"] = $name;
                    $_SESSION["password"] = $password;
                    $_SESSION["success"] = "Επιτυχής σύνδεση";
                    header("Location:admin_page.html");
                } else {
                    $_SESSION["id"] = $row_c;
                    $_SESSION["name"] = $name;
                    $_SESSION["password"] = $password;
                    $_SESSION["success"] = "Επιτυχής σύνδεση";
                    header("Location: user_page.html");
                }
            } else {
                $passnameErr = "Λανθασμένο όνομα ή κωδικός πρόσβασης";
            }
        }

?>

<!doctype html>
<html>

<head>
  <title>Εγγραφή</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js"></script>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
    integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc="
    crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
    integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous">
  </script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
    integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
  </script>

  <style>
    * {
      font-family: Helvetica;
    }

    form {
      border: 3px solid #f1f1f1;
    }

    input[type=name],
    input[type=password] {
      width: 100%;
      padding: 12px 20px;
      margin: 8px 0;
      display: inline-block;
      border: 1px solid #ccc;
      box-sizing: border-box;
    }

    input[type=submit] {
      background-color: skyblue;
      color: white;
      padding: 14px 20px;
      margin: 8px 0;
      border: none;
      cursor: pointer;
      width: 100%;
    }

    input[type=submit]:hover {
      opacity: 0.8;
    }

    .container {
      padding: 16px;
    }

    span.password {
      float: right;
      padding-top: 16px;
    }

    .center {
      text-align: center;
    }

    .box-container {
      width: 40%;
      margin: auto;
      padding: 0rem;
      border: 0rem;
    }
  </style>

</head>

<body>

  <nav class="navbar navbar-expand-sm bg-light">
    <a class="navbar-brand" href="index.html">
      <img class="img-responsive" src="images/HAR_geo.png">
    </a>
  </nav>

  <section class="jumbotron text-center">
    <div class="container">
      <div class="box-container">
        <form method="POST" action="<?php echo $_SERVER['PHP_SELF'] ?>">
          <div class="center">
            <h1>Σύνδεση</h1>
          </div>
          <div class="container">
            Όνομα: <input type="name" name="name" autocomplete="off" required>
            
            Κωδικός: <input type="password" name="password" autocomplete="off" required>

            <input type="submit" name="submit" value="Υποβολή">
            <div>
        </form>
      </div>
    </div>
  </section>



</body>

</html>