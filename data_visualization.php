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
    $sql_file_paths = "SELECT file_path FROM har_files WHERE id_user = '".$id."' ";
    $result_paths = mysqli_query($connection, $sql_file_paths);
    $file_paths = mysqli_fetch_all($result_paths);

    $user_contents = [];

    foreach ($file_paths as $key => $value) {
        $file_open = fopen($file_paths[$key][0], 'r');
        $file_contents = fread($file_open, filesize($file_paths[$key][0]));
        array_push($user_contents, $file_contents);
        fclose($file_open);
    }
    

    $user_contents = json_encode($user_contents, JSON_PRETTY_PRINT);

    print_r($user_contents);

    disconnect($connection);
