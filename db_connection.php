<?php

    function connect(){
        $db_servername = "localhost";
        $db_username = "root";
        $db_password = "vasilliskontis2016";
        $db_name = "project_web_users";

        $conn = mysqli_connect($db_servername, $db_username, $db_password, $db_name);
        if(!$conn){
            die("Connection failed: ". mysqli_connect_error());
        }else{
            return $conn;
        }
    }

    function disconnect($conn){
        mysqli_close($conn);
    }

?>