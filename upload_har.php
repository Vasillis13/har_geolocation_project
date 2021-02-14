<?php
  include "db_connection.php";

  session_start();

  if ($_SESSION["name"] == "") {
      header("location:login.php");
  }

  $data = json_decode($_POST['files']);
  $file_name = $data[0];
  $file_name = str_replace('"', "", $file_name);
  $file_name = $_SESSION['name'].'-'.$file_name;
  $file_content = $data[1];
  $user_ip = $data[2];
  $user_city = $data[3];
  $user_isp = $data[4];

  print_r($data);
    
  $file = fopen("./uploads/$file_name", 'w');
  fwrite($file, $file_content);
  fclose($file);

  $destination = "./uploads/$file_name";


  $name = $password = "";

  $name = $_SESSION["name"];
  $password = $_SESSION["password"];

  $connection = connect();

  $sql_password = "SELECT id FROM users WHERE username = '".$name."' AND password = '".$password."'";
  $result = mysqli_query($connection, $sql_password);
  $row = mysqli_fetch_row($result);
  $row_implode = implode($row);
  $int_row = intval($row_implode);


  $sql = "INSERT INTO har_files VALUES ('$int_row', NULL, '$destination')";
  date_default_timezone_set('Europe/Athens');
  $date = date("y-m-d h:i:s");
  mysqli_query($connection, $sql);

  $sql_date = "UPDATE users SET last_upload_data = '$date', user_ip = '$user_ip', user_city = '$user_city', user_isp = '$user_isp'  WHERE username = '".$name."' AND password = '".$password."'";
  mysqli_query($connection, $sql_date);

  $sql_har_id = "SELECT id FROM har_files WHERE file_path = '".$destination."' AND id_user = '".$int_row."' ";
  $result_har_id = mysqli_query($connection, $sql_har_id);
  $har_id_array = mysqli_fetch_row($result_har_id);
  $har_id = intval($har_id_array);

  $i = 0;
  $file_content = json_decode($file_content, true);
  foreach ($file_content['log']['entries'] as $key => $value) {
      $har_file_id = $har_id;
      $request_method = $file_content['log']['entries'][$i]['request']['method'];
      $request_url = $file_content['log']['entries'][$i]['request']['url'];
      $response_status = $file_content['log']['entries'][$i]['response']['status'];
      $response_statusText = $file_content['log']['entries'][$i]['response']['statusText'];
      $serverIPAddress = $file_content['log']['entries'][$i]['serverIPAddress'];
      $startedDateTime = $file_content['log']['entries'][$i]['startedDateTime'];
      $timings_wait = $file_content['log']['entries'][$i]['timings']['wait'];
      $request_headers = json_encode($file_content['log']['entries'][$i]['request']['headers'], true, JSON_PRETTY_PRINT);
      $response_headers = json_encode($file_content['log']['entries'][$i]['response']['headers'], true, JSON_PRETTY_PRINT);

      $sql_entries = "INSERT INTO entries VALUES ('$har_file_id', NULL, '$request_method', '$request_url', '$response_status', '$response_statusText', ' $serverIPAddress', '$startedDateTime', '$timings_wait', '$request_headers', '$response_headers')";
      mysqli_query($connection, $sql_entries);

      ++$i;
  }


  disconnect($connection);


?>


