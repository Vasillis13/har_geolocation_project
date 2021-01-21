<?php
  include "db_connection.php";

  session_start();

  if ($_SESSION["name"] == "") {
      header("location:login.php");
  }

  if (isset($_FILES['file']['name'])) {
      $tmp_file_name = $_FILES['file']['tmp_name'];
      $tmp_destination = "./tmp_uploads/" . $_SESSION['name'] . '-' . $_FILES['file']['name'];

      move_uploaded_file($tmp_file_name, $tmp_destination);

      $tmp_file = strval($_FILES['file']['name']);
      $tmp_path = "./tmp_uploads/" . $_SESSION['name'] . '-' . $tmp_file;
      $tmp_file_contents = file_get_contents($tmp_path, null);
      $file_array = json_decode($tmp_file_contents, true);
      $file_array = array($file_array);

      foreach ($file_array as $key => $value) {
      }

      $final_array = array_values($file_array);
     
      $json_text = json_encode($final_array, JSON_PRETTY_PRINT);
      $destination = $destination = "./uploads/" . $_SESSION['name'] . '-' . $_FILES['file']['name'];
      file_put_contents($destination, $json_text);
      echo "Το αρχείο ανέβηκε επιτυχώς";

      


      $name = $password = "";

      $name = $_SESSION["name"];
      $password = $_SESSION["password"];

      $connection = connect();

      $sql_password = "SELECT id FROM users WHERE username = '".$name."' AND password = '".$password."'";
      $result = mysqli_query($connection, $sql_password);
      $row = mysqli_fetch_row($result);
      $row_implode = implode($row);
      $int_row = intval($row_implode);

      $sql = "INSERT INTO har_files (id_user, id, file_path) VALUES ('$int_row', NULL, '$destination')";
      date_default_timezone_set('Europe/Athens');
      $date = date("y-m-d h:i:s");
      mysqli_query($connection, $sql);

      $sql_date = "UPDATE users SET last_upload_data = '$date' WHERE username = '".$name."' AND password = '".$password."'";
      mysqli_query($connection, $sql_date);

      disconnect($connection);
  }


?>


<!doctype html>
<html>
  <head>
    <title>Ανέβασμα αρχείων</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    
    <style>
      * {font-family: Helvetica;}
      .center {
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
    <!-- Η φ΄όρμα που χρησιμοποιώ για την υποβολή και την αποθήκευση . Χρησιμοποιώ multipart/form-data για να καταλάβει ο server ότι το input που αποστέλλω είναι τύπου file  -->
      <h2>Ανέβασμα αρχείων HAR</h2>
      <form enctype="multipart/form-data" name="form" id="form" method="POST" action= "<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        <input type="hidden" name="MAX_FILE_SIZE" value="30000000000">
        <input type="file" name="file" id="file" accept=".json, .har">
        <button type="submit" id="upload-btn">Υποβολή</button>
        <button type="button" id="download-btn" name="download-btn">Αποθήκευση</button>
      </form>
    </div>
    
    <script>
            //Event Listener που πυροδοτείται όταν αλλάζει το input file και μέσα σε αυτό υλοποιείται η ενέργεια της αποθήκευσης τοπικά και της υποβολής του αρχείου
            const doc = document.getElementById("file").addEventListener("change", function() {
            var file_to_read = document.getElementById("file").files[0];
            var fileread = new FileReader();
            fileread.onload = function(e) {

              //στις επόμενες γραμμές κώδικα αλλάζω το περιεχόμενο του JSON αρχείου διαγ΄ραφοντας τα περιττά στοιχεία
              var content = e.target.result;
              var intern = JSON.parse(content);

              delete intern.log.creator;

              delete intern.log.pages;

              delete intern.log.version;

              for(let i = 0; i<intern.log.entries.length; i++){
                delete intern.log.entries[i].cache;
                delete intern.log.entries[i].connection;
                delete intern.log.entries[i].pageref;
                delete intern.log.entries[i].time;
                delete intern.log.entries[i].timings.blocked;
                delete intern.log.entries[i].timings.connect;
                delete intern.log.entries[i].timings.dns;
                delete intern.log.entries[i].timings.receive;
                delete intern.log.entries[i].timings.send;
                delete intern.log.entries[i].timings.ssl;
                delete intern.log.entries[i].timings._blocked_queueing;
              }
              
              for(let i = 0; i<intern.log.entries.length; i++){
                delete intern.log.entries[i].request.bodySize;
                delete intern.log.entries[i].request.cookies;
                delete intern.log.entries[i].request.headersSize;
                delete intern.log.entries[i].request.httpVersion;
                delete intern.log.entries[i].request.queryString;
                
                for(let y = 0; y<intern.log.entries[i].request.headers.length; y++){
                  if(intern.log.entries[i].request.headers[y].name !== "content-type" && intern.log.entries[i].request.headers[y].name !== "Host" && intern.log.entries[i].request.headers[y].name !== "Cache-Control" && intern.log.entries[i].request.headers[y].name !== "Pragma" && intern.log.entries[i].request.headers[y].name !== "Expires" && intern.log.entries[i].request.headers[y].name !== "Age" && intern.log.entries[i].request.headers[y].name !== "Last-Modified"){
                    delete intern.log.entries[i].request.headers[y];
                  }
                }
                
              }

              for(let i = 0; i<intern.log.entries.length; i++){
                delete intern.log.entries[i].response.bodySize;
                delete intern.log.entries[i].response.content;
                delete intern.log.entries[i].response.cookies;
                delete intern.log.entries[i].response.headersSize;
                delete intern.log.entries[i].response.httpVersion;
                delete intern.log.entries[i].response.redirectURL;
                delete intern.log.entries[i].response._error;
                delete intern.log.entries[i].response._transferSize;

                for(let y = 0; y<intern.log.entries[i].response.headers.length; y++){
                  if(intern.log.entries[i].response.headers[y].name !== "content-type" && intern.log.entries[i].response.headers[y].name !== "Host" && intern.log.entries[i].response.headers[y].name !== "Cache-Control" && intern.log.entries[i].response.headers[y].name !== "Pragma" && intern.log.entries[i].response.headers[y].name !== "Expires" && intern.log.entries[i].response.headers[y].name !== "Age" && intern.log.entries[i].response.headers[y].name !== "Last-Modified"){
                    delete intern.log.entries[i].response.headers[y];
                  }
                }
              }
              
              // Η json_data είναι η μεταβλητή string που θέλω να υποβάλλω στον server αντί του αρχείου που αρχικά επιλέχθηκε
              var json_data = JSON.stringify(intern.log, null, 2);

              // Εδώ πρέπει να φτιάξω μια συνάρτηση uploadFile πιθανότατα που θα αλλάζει το περιεχόμενο του FormData και θα το στέλνει ασύγχρονα στον server

              // Η συνάρτηση που υλοποιεί το download button και αποθηκε΄ύει το επιλεγμένο αρχείο στον υπολογιστή του χρ΄ήστη
              function download(filename, text){
                var element = document.createElement('a');
                element.style.display = "none";

                element.setAttribute("href", "data:text/plain;charset=utf8," +encodeURIComponent(text));

                element.setAttribute("download", filename);
                document.body.appendChild(element);

                element.click();

                document.body.removeChild(element);
              }
              document.getElementById("download-btn").addEventListener("click", function(){
                var text = JSON.stringify(intern.log, null, 2);
                var fileInput = document.getElementById('file');
                var filename = "sanitized-" + fileInput.files[0].name;

                download(filename, text);
              }, false);

            };
            fileread.readAsText(file_to_read); 
        });     

    </script>
    
  
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  </body>
</html>