<?php 
  session_start();

  if(!isset($_SESSION['logged_in'])){
    header("Location: ../home.php");
  }

  require '../connection.php';
  
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
                        <a href="../logout.php"><img src="images/logout-icon.png"> Log out</a>
                    </div>
                </a>
                <a href="visualize.php"><img src="images/visualize-icon.png"> Visualize Data</a>
                <a href="headers-analysis.php"><img src="images/headers-icon.png"> Headers Analysis</a>
                <a href="response-analysis.php"><img src="images/response-icon.png"> Response Analysis</a>
                <a href="basic-info.php"><img src="images/info-icon.png"> Basic Info</a>
                <a href="home.php"><img src="images/home-icon.png"> Home</a>
            </div>

            <div class="welcome-section">
                <h1>WELCOME</h1>
                <hr size="2" width="570px" color="black" align="left">
                <p>This website was created as a project for the course "Programming and Systems on the World Wide Web".</p>
            </div>

            <div class="card-section">
                <div class="team1">
                <a href="basic-info.php">
                    <div class="card card1">
                        <h5>Basic Info</h5>
                        <p>View basic information about the data uploaded by the users</p>
                    </div>
                </a>
                <a href="response-analysis.php">
                    <div class="card card2">
                        <h5>Response Analysis</h5>
                        <p>View response times conserning data uploaded by the users</p>
                    </div>
                </a>
                </div>
                <div class="team2">
                <a href="headers-analysis.php">
                    <div class="card card3">
                        <h5>Headers Analysis</h5>
                        <p>View HTTP headers of data uploaded by the users</p>
                    </div>
                </a>
                <a href="visualize.php">
                    <div class="card card4">
                        <h5>Visualize Data</h5>
                        <p>View a map of the users and the data they uploaded</p>
                    </div>
                </a>
                </div>
            </div>
        </div>

        <script src="../user/dropdown.js"></script>
    </body>
</html>