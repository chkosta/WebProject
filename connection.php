<?php

    $servername = "127.0.0.1:3306";
    $dBUsername = "root";
    $dBPassword = "";
    $dBName = "project";

    $conn = mysqli_connect($servername, $dBUsername, $dBPassword, $dBName);

    if (!$conn) {
        die("Connection failed: ".mysqli_connect_error());
    }

    $connectdb = mysqli_select_db($conn, $dBName);

?>