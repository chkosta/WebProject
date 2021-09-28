<?php

    session_start();

    if (isset($_POST['register-submit'])) {
        
        require 'connection.php';

        $username = mysqli_real_escape_string($conn, $_POST['un2']);
        $password = mysqli_real_escape_string($conn, $_POST['pwd2']);
        $confirm_pass = mysqli_real_escape_string($conn, $_POST['pwd2-confirm']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);

        if ($password != $confirm_pass) {
            echo "<script>
                alert('Wrong passwords! Try again!');
                window.location.href='home.php';
            </script>";
        }
        
        if ($password == $confirm_pass) {
            $check = "SELECT * FROM registration WHERE username = '$username'";
            $result = mysqli_query($conn, $check);
            $rows = mysqli_num_rows($result);

            if ($rows >= 1){
                echo "<script>
                    alert('Username is already taken! Choose something else!');
                    window.location.href='home.php';
                </script>";
            } else {
                $password = md5($password);
                $reg = "INSERT INTO registration VALUES (null, '$username', '$password', '$email', 'User')";
                mysqli_query($conn, $reg);
                echo "<script>
                    alert('Your registration is successfully completed!');
                    window.location.href='home.php';
                </script>";
            }
        }
    }
?>