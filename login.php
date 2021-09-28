<?php

    session_start();

    if (isset($_POST['login-submit'])) {

        require 'connection.php';

        $username = mysqli_real_escape_string($conn, $_POST['un1']);
        $password = mysqli_real_escape_string($conn, $_POST['pwd1']);
        $type = mysqli_real_escape_string($conn, $_POST['type']);

        $password = md5($password);

        $sql = "SELECT * FROM registration where username='$username' and password='$password' and user_type='$type'";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_array($result);
        $rows = mysqli_num_rows($result);

        if (($rows !== 0) && ($type == 'User')){
            $_SESSION['logged_in'] = 1;
            $_SESSION['userid'] = $row['id'];
            $_SESSION['un1'] = $row['username'];
            $_SESSION['pwd1'] = $row['password'];

            echo "<script>
                alert('Login successful!');
                window.location.href='user/home.php';
            </script>";
        }
        else if (($rows !== 0) && ($type == 'Admin')){
            $_SESSION['logged_in'] = 1;
            $_SESSION['userid'] = $row['id'];
            $_SESSION['un1'] = $row['username'];
            $_SESSION['pwd1'] = $row['password'];

            echo "<script>
                alert('Login successful!');
                window.location.href='admin/home.php';
            </script>";
        }
        else {
            echo "<script>
                alert('Wrong username, password or user type. Try again!');
                window.location.href='home.php';
            </script>";
        }
    }
?>