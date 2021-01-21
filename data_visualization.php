<?php
    session_start();
    include "db_connection.php";
    include "User.php";


    if ($_SESSION["name"] == "") {
        header("location:login.php");
    }

    $id = $_SESSION['id'];
    $id = implode("", $id);

    $connection = connect();
    $sql = "SELECT file_path FROM har_files WHERE id_user = '".$id."' ";
    $result = mysqli_query($connection, $sql);
    
    $options = "";
    while ($row = mysqli_fetch_row($result)) {
        $row = implode("", $row);
        $options = $options."<option id=json-option>$row</option>";
    }

?>
<!doctype html>
<html lang="en">
  <head>
    <title>Οπτικοποίηση δεδομένων</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    

    <style>
        *{font-family: Helvetica;}

        .center{
           text-align: center; 
        }


    </style>


    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  </head>
  <body>
    <nav class="navbar navbar-expand-sm bg-light">
        <a class="navbar-brand" href="user_page.php">
            <img class="img-responsive" src="images/HAR_geo.png" >
        </a>      
    </nav>

    <div class="center"> 
      <h3>Οπτικοποίηση δεδομένων</h3>
      <label for="har_file">Επιλέξτε ένα αρχείο</label>
      <select name="har_file" id="har_file">
        <div class="options" id="options">
          <?php
            echo $options;
          ?>
        </div>
      </select>
      <button type="button" name="submit" id="submit">Επιλογή</button>
    </div>
    
    <script>
      var option = document.getElementById("json-option").value;
      $('#submit').on("click", function(){
        var xhr = new XMLHttpRequest();
        xhr.open("GET", option, true);
        xhr.onreadystatechange = function(){
          if(this.readyState ===4){
            if(this.status === 200){
              var json = JSON.parse(this.responseText);
              console.log(json);
            }else {
              alert("HTTP error " + this.status + " " + this.statusText);
            }
          }
        }
        xhr.send();
      });
        
      
    </script>

    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  </body>
</html>