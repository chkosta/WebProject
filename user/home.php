<?php 
  session_start();

  if(!isset($_SESSION['logged_in'])){
    header("Location: ../home.php");
  }
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <link rel="icon" href="images/favicon.ico" type="image/ico">
        <title>datasol | Home</title>
        <link rel="stylesheet" href="home.css">
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
                        <img src="images/mini-avatar-icon.png"> Hello, <?php echo $_SESSION['un1'] ?>!<img src="images/arrow-icon.png">
                    </button>
                    <div id="myDropdown" class="dropdown-content">
                        <a href="profile.php"><img src="images/settings-icon.png"> Edit Profile</a>
                        <a href="../logout.php"><img src="images/logout-icon.png"> Log out</a>
                    </div>
                </a>
                <a href="visualize.php"><img src="images/visualize-icon.png"> Visualize Data</a>
                <a href="upload.php"><img src="images/upload-icon.png"> Upload Data</a>
                <a href="home.php"><img src="images/home-icon.png"> Home</a>
            </div>

            <div class="welcome-section">
                <h1>WELCOME</h1>
                <hr size="2" width="570px" color="black" align="left">
                <p>This website was created as a project for the course "Programming and Systems on the World Wide Web".</p>
            </div>

            <div class="card-section">
                <a href="upload.php">
                    <div class="card card1">
                        <h5>Upload Data</h5>
                        <p>Process your data and upload or store them</p>
                    </div>
                </a>
                <a href="visualize.php">
                    <div class="card card2">
                        <h5>Visualize Data</h5>
                        <p>Visualize your data that you uploaded</p>
                    </div>
                </a>
                <a href="profile.php">
                    <div class="card card3">
                        <h5>Edit Profile</h5>
                        <p>Edit your profile</p>
                    </div>
                </a>
            </div>
        </div>

        <script src="dropdown.js"></script>
    </body>
</html>