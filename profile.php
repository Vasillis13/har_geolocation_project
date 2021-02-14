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

    $sql_ip = "SELECT user_ip FROM users WHERE username = '".$name."' AND password = '".$password."' ";
    $ip_result = mysqli_query($connection, $sql_ip);
    $user_ip = mysqli_fetch_row($ip_result);
    $user_ip = implode("", $user_ip);

    $sql_city = "SELECT user_city FROM users WHERE username = '".$name."' AND password = '".$password."' ";
    $city_result = mysqli_query($connection, $sql_city);
    $user_city = mysqli_fetch_row($city_result);
    $user_city = implode("", $user_city);

    $sql_isp = "SELECT user_isp FROM users WHERE username = '".$name."' AND password = '".$password."' ";
    $isp_result = mysqli_query($connection, $sql_isp);
    $user_isp = mysqli_fetch_row($isp_result);
    $user_isp = implode("", $user_isp);

    $sql_user_files = "SELECT id FROM har_files WHERE id_user = '".$row_id_user."' ";
    $user_files_result = mysqli_query($connection, $sql_user_files);
    $user_files = mysqli_fetch_all($user_files_result);

    $user_files_id = [];
    foreach ($user_files as $key => $value) {
        $user_files_id[$key] = $user_files[$key][0];
    }
    $entries_count = 0;
    foreach ($user_files_id as $key_2 => $values_2) {
        $sql_count = "SELECT COUNT(id) FROM entries WHERE har_file_id = '".$user_files_id[$key_2]."' ";
        $count_result = mysqli_query($connection, $sql_count);
        $count = mysqli_fetch_row($count_result);
        $count = implode("", $count);
        $entries_count = $entries_count + $count;
    }

    $ajax_response = array(
      'last_upload' => $last_upload,
      'row_upload_count' => $row_upload_count,
      'username' => $_SESSION['name'],
      'user_ip' => $user_ip,
      'user_city' => $user_city,
      'user_isp' => $user_isp,
      'entries_count' => $entries_count
    );

    print_r(json_encode($ajax_response, JSON_PRETTY_PRINT));

    disconnect($connection);

?>

