<?php
    session_start();
    include "db_connection.php";
    include "User.php";


    if ($_SESSION["name"] == "") {
        header("location:login.php");
    }

    $connection = connect();

    $sql_user_ip = "SELECT user_ip FROM users WHERE isAdmin = 0 ";
    $user_ip_result = mysqli_query($connection, $sql_user_ip);
    $user_ip = mysqli_fetch_all($user_ip_result);

    print_r(json_encode($user_ip, JSON_PRETTY_PRINT));

    disconnect($connection);
