<?php
    session_start();
    include "db_connection.php";
    include "User.php";


    if ($_SESSION["name"] == "") {
        header("location:login.php");
    }


    $connection = connect();
    $name = $_SESSION['name'];
    $password = $_SESSION['password'];

    $sql = "SELECT last_upload_data FROM users WHERE username = '".$name."' AND password = '".$password."'";
    $result = mysqli_query($connection, $sql);
    $last_upload = mysqli_fetch_row($result);
    $last_upload = implode("", $last_upload);
    

    $sql_id_user = "SELECT id FROM users WHERE username = '".$name."' AND password = '".$password."'";
    $result_id_user = mysqli_query($connection, $sql_id_user);
    $row_id_user = mysqli_fetch_row($result_id_user);
    $row_id_user = implode("", $row_id_user);
    
    $sql_upload_count = "SELECT count(id_user) AS count_id FROM har_files WHERE id_user = '".$row_id_user."'";
    $result_upload_count = mysqli_query($connection, $sql_upload_count);
    $row_upload_count = mysqli_fetch_row($result_upload_count);
    $row_upload_count = implode("", $row_upload_count);

    $sql_update_upload_count = "UPDATE users SET upload_count = '$row_upload_count' WHERE username = '".$name."' AND password = '".$password."' ";
    mysqli_query($connection, $sql_update_upload_count);

    disconnect($connection);

?>

<!doctype html>
<html>
  <head>
    <title>Προφίλ</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <style>

      *{
        font-family: Helvetica;
        box-sizing: border-box;
      }
      
      .center {
        text-align: center;
        margin: auto;
      }

      .open-button{
        background-color: skyblue;
        color: white;
        padding: 16px 20px;
        border: none;
        cursor: pointer;
        opacity: 0.8;
        position: fixed;
        bottom: 340px;
        right: 800px;
        width: 280px;
      }

      .open-button-password{
        background-color: skyblue;
        color: white;
        padding: 16px 20px;
        border: none;
        cursor: pointer;
        opacity: 0.8;
        position: fixed;
        bottom: 340px;
        right: 450px;
        width: 280px;
      }

      .form-popup{
        display: none;
        position: fixed;
        bottom: 150px;
        right: 500px;
        border: 1px solid #f1f1f1;
        z-index: 9;
      }

      .form-popup-password{
        display: none;
        position: fixed;
        bottom: 150px;
        right: 500px;
        border: 1px solid #f1f1f1;
        z-index: 9;
      }

      .form-container {
        max-width: 500px;
        padding: 15px;
        background-color: white;
      }

      .form-container-password{
        max-width: 500px;
        padding: 15px;
        background-color: white;
      }

      .form-container input[type=name], .form-container input[type=password] {
        width: 100%;
        padding: 15px;
        margin: 5px 0 22px 0;
        border: none;
        background: #f1f1f1;
      }

      .form-container-password input[type=password], .form-container-password input[type=password] {
        width: 100%;
        padding: 15px;
        margin: 5px 0 22px 0;
        border: none;
        background: #f1f1f1;
      }

      .form-container input[type=name]:focus, .form-container input[type=password]:focus {
        background-color: #ddd;
        outline: none;
      }

      .form-container-password input[type=password]:focus, .form-container-password input[type=text] {
        background-color: #ddd;
        outline: none;
      }

      .form-container .btn, .cancel {
        background-color: skyblue;
        color: white;
        padding: 16px 20px;
        border: none;
        cursor: pointer;
        width: 100%;
        margin-bottom:10px;
        opacity: 0.8;
      }

      .form-container-password .btn-password {
        background-color: skyblue;
        color: white;
        padding: 16px 20px;
        border: none;
        cursor: pointer;
        width: 100%;
        margin-bottom:10px;
        opacity: 0.8;
      }

      .form-container-password .cancel-password{
        background-color: skyblue;
        color: white;
        padding: 16px 20px;
        border: none;
        cursor: pointer;
        width: 100%;
        margin-bottom:10px;
        opacity: 0.8;
      }

      .form-container .cancel, .form-container-password .cancel-password {
        background-color: red;
      }

      .form-container .btn:hover, .open-button:hover {
        opacity: 1;
        color: black;
        -moz-transition: all 0.4s ease-out;
        -o-transition: all 0.4s ease-out;
        -webkit-transition: all 0.4s ease-out;
        -ms-transition: all 0.4s ease-out;
        transition: all 0.4s ease-out;
      }

     .open-button-password:hover {
        opacity: 1;
        color: black;
        -moz-transition: all 0.4s ease-out;
        -o-transition: all 0.4s ease-out;
        -webkit-transition: all 0.4s ease-out;
        -ms-transition: all 0.4s ease-out;
        transition: all 0.4s ease-out; 
     }

      .form-container-password .btn-password:hover{
        opacity: 1;
        color: black;
        -moz-transition: all 0.4s ease-out;
        -o-transition: all 0.4s ease-out;
        -webkit-transition: all 0.4s ease-out;
        -ms-transition: all 0.4s ease-out;
        transition: all 0.4s ease-out;  
      }

    </style>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  </head>
  <body>
    <nav class="navbar navbar-expand-sm bg-light">
        <a class="navbar-brand" href="user_page.php">
            <img class="img-responsive" src="images/HAR_geo.png" >
        </a>      
    </nav>

    <div class="center">
      <h3>Βασικά στοιχεία προφίλ</h3>
      <p id="user-name">
        <?php
          echo "<p>Όνομα χρήστη : " .$_SESSION["name"] . "</p>";
        ?>
      </p>
      <?php echo "<p class='last-upload' >Ημερομηνία τελευταίου upload : $last_upload </p>"; ?>
      <?php echo "<p class='upload-count'> Σύνολο ανεβασμένων αρχείων : $row_upload_count </p>"; ?>
      <br><br>
      <h3>Αλλαγή στοιχείων</h3>
    </div>

    <button class="open-button" onclick="openForm()">Αλλάξτε το Όνομα</button>

    <div class="form-popup" id="change-username">
      <form action="change_username.php" method="POST" class="form-container">

        <label for="username"><b>Νέο όνομα χρήστη :</b></label>
        <input type="name" name="_name" required>
        <label for="password"><b>Επιβεβαίωση κωδικού :</b></label>
        <input type="password" name="_password" required>
        <button type="submit" value="name_submit" class="btn">Επιβεβαίωση αλλαγής</button>
        <button type="button" class="cancel" onclick="closeForm()">Ακύρωση</button>
      </form>
    </div>

    <button class="open-button-password" onclick="openFormPassword()">Αλλάξτε τον Κωδικό</button>

    <div class="form-popup-password" id="change-password">
      <form name="password_form" action="change_password.php" method="POST" class="form-container-password" onSubmit="return validatePassword()" >

        <label for="password"><b>Πληκτρολογήστε τον παλαιό κωδικό σας :</b></label>
        <input type="password" name="old_password" id="old_password" required>
        <label for="password"><b>Νέος Κωδικός πρόσβασης :</b></label>
        <input type="password" name="new_password" id="new_password" required>
        <button type="submit" value="password_submit" class="btn-password">Επιβεβαίωση αλλαγής</button>
        <button type="button" class="cancel-password" onclick="closeFormPassword()">Ακύρωση</button>
      </form>
    </div>
    

    

    <script>
      function openForm(){
        document.getElementById("change-username").style.display = "block";
      }

      function closeForm(){
        document.getElementById("change-username").style.display = "none";
      }


      function openFormPassword(){
        document.getElementById("change-password").style.display = "block";
      }

      function closeFormPassword(){
        document.getElementById("change-password").style.display = "none";
      }

    </script>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  </body>
</html>