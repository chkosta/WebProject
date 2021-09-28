<?php
    session_start();
    
    unset($_SESSION['logged_in']);
    session_destroy();
    echo "<script>
        alert('Goodbye!');
        window.location.href='home.php';
    </script>";
?>