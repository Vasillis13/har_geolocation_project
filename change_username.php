<?php
    session_start();
    include "db_connection.php";
    include "User.php";


    if ($_SESSION["name"] == "") {
        header("location:login.php");
    }

    $id = $_SESSION['id'];
    $error_message = '';

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (empty($_POST['_name'])) {
        } else {
            $name = $_POST['_name'];
        }
        if (empty($_POST['_password'])) {
        } else {
            $password = $_POST['_password'];
            if ($password == $_SESSION['password']) {
                $connection = connect();
                $sql = "UPDATE users SET username = '$name' WHERE username = '".$_SESSION['name']."' AND password = '".$password."' ";
                mysqli_query($connection, $sql);
                disconnect($connection);
                header("location:logout.php");
            }
        }
    }
