<?php 
  session_start();

  if(!isset($_SESSION['logged_in'])) {
    header("Location: ../home.php");
  }

  require '../connection.php'; 

  $sql = "SELECT upload_date, num_records FROM history WHERE user_id = {$_SESSION['userid']} ORDER BY upload_date DESC LIMIT 1 ;";
  $result = mysqli_query($conn, $sql);
  $activity = mysqli_fetch_assoc($result);

  $sql = "SELECT id, username, password FROM registration WHERE id = '{$_SESSION['userid']}'";
  $result = mysqli_query($conn, $sql);
  $row = mysqli_fetch_array($result);

  if (isset($_POST['username-submit'])) {
      $newusername = $_POST['newusername'];
      
      $sql = "SELECT * FROM registration WHERE username = '$newusername'";
      $result = mysqli_query($conn, $sql);
      $row = mysqli_fetch_array($result);

      if ($row == 0) {
        $s1 = "UPDATE registration SET username = '$newusername' WHERE id='{$_SESSION['userid']}'";
        $result1 = mysqli_query($conn, $s1);

        if ($result1) {
            echo "<script>
                alert('Username changed successfully!');
                window.location.href='profile.php';
            </script>";
        }else {
            echo "<script>
                alert('Something went wrong!');
                window.location.href='profile.php';
            </script>";
        }
      }else {
        echo "<script>
            alert('Username is already taken! Choose something else!');
            window.location.href='profile.php';
        </script>";
      }
  }

  if (isset($_POST['pass-submit'])) {
    $oldpass = $_POST['oldpass'];
    $newpass = $_POST['newpass'];
    $confirmpass = $_POST['confirmpass'];

    if (md5($oldpass) == $row['password']) {

        if ($newpass != $confirmpass) {
            echo "<script>
                alert('Wrong passwords! Try again!');
                window.location.href='profile.php';
            </script>";
        }

        if ($newpass == $confirmpass) {
            $newpass = md5($newpass);
            $s2 = "UPDATE registration SET password = '$newpass' WHERE id='{$_SESSION['userid']}'";
            $result2 = mysqli_query($conn, $s2);

            if ($result2) {
                echo "<script>
                    alert('Password changed successfully!');
                    window.location.href='profile.php';
                </script>";
            }else {
                echo "<script>
                    alert('Something went wrong!');
                    window.location.href='profile.php';
                </script>";
            }
        }
    }else {
        echo "<script>
        alert('Wrong passwords! Try again!');
        window.location.href='profile.php';
    </script>";
    }
  }
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <link rel="icon" href="images/favicon.ico" type="image/ico">
        <title>datasol | Edit Profile</title>
        <link rel="stylesheet" href="profile.css">
    </head>

    <body>
        <div class="hero">
            <div class="logo">
                <a href="home.php"><img src="images/logo-icon.png"></a>
            </div>

            <div class="caption">datasol</div>

            <div class="navbar">
                <a>
                    <button class="dropbtn" onclick="myFunction()">
                        <img class="icons" src="images/mini-avatar-icon.png"> Hello, <?php echo $_SESSION['un1'] ?>!<img class="icons" src="images/arrow-icon.png">
                    </button>
                    <div id="myDropdown" class="dropdown-content">
                        <a href="profile.php"><img class="icons" src="images/settings-icon.png"> Edit Profile</a>
                        <a href="../logout.php"><img class="icons" src="images/logout-icon.png"> Log out</a>
                    </div>
                </a>
                <a href="visualize.php"><img class="icons" src="images/visualize-icon.png"> Visualize Data</a>
                <a href="upload.php"><img class="icons" src="images/upload-icon.png"> Upload Data</a>
                <a href="home.php"><img class="icons" src="images/home-icon.png"> Home</a>
            </div>
            
            <div class="avatar">
                <img src="images/mini-avatar-icon.png">
                <div><?php echo $_SESSION['un1']; ?></div>
                <div><?php echo $_SESSION['userid']; ?></div>
            </div>
            
            <form method="POST" class="input-group-1">
                <h3>Change Username</h3>
                <input type="text" class="input-field" placeholder="New Username" name="newusername" required>
                <button type="submit" class="submit-btn" name="username-submit">Change</button><br>
            </form>

            <form method="POST" class="input-group-2">
                <h3>Change Password</h3>
                <input type="password" class="input-field" placeholder="Old Password" name="oldpass" required>
                <input type="password" class="input-field" pattern="(?=.*\d)(?=.*[#,$,*,&,@])(?=.*[A-Z]).{8,}" placeholder="New Password" name="newpass" required>
                <input type="password" class="input-field" placeholder="Confirm Password" name="confirmpass" required>
                <button type="submit" class="submit-btn" name="pass-submit">Change</button>
            </form>

            <div class="input-group-3">
                <h3>Data Activity</h3>
                <ul class="list-group">
                    <li class="list-group-item"><span class="pull-left"><strong>Date of Last Upload:</strong></span> <?php echo $activity['upload_date'] ?></li>
                    <li class="list-group-item"><span class="pull-left"><strong>Number of Records:</strong></span> <?php echo $activity['num_records'] ?></li>
                </ul>  
            </div>
        </div>

        <script src="dropdown.js"></script>
    </body>
</html>