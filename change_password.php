<?php
    session_start();
    include "db_connection.php";
    include "User.php";


    if ($_SESSION["name"] == "") {
        header("location:login.php");
    }

    $password = $_SESSION['password'];
    $new_password = "";
    $id = $_SESSION['id'];

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (empty($_POST['old_password'])) {
        } else {
            $temp_password = $_POST['old_password'];
            if ($temp_password == $_SESSION['password']) {
                $new_password = $_POST['new_password'];
                if (!preg_match("/^\S*(?=\S{8,})(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])(?=\S*[\W])\S*$/", $new_password)) {
                } else {
                    $connection = connect();
                    $sql_password = "UPDATE users SET password = '$new_password' WHERE username = '".$_SESSION['name']."' AND password = '".$password."' ";
                    mysqli_query($connection, $sql_password);
                    disconnect($connection);
                    header("location:logout.php");
                }
            }
        }
    }
