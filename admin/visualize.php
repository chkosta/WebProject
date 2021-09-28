<?php 
  session_start();

  if(!isset($_SESSION['logged_in'])){
    header("Location: ../home.php");
  }

  require '../connection.php';

  $sql = "SELECT history.user_id, entries.har_id, history.userIPAddress, history.latitude AS user_lat, history.longitude AS user_long, responseip.harIPAddress, responseip.latitude, responseip.longitude, count(entries.serverIPAddress) AS count FROM history
  INNER JOIN entries ON history.har_id = entries.har_id
  INNER JOIN responseip ON entries.serverIPAddress = responseip.harIPAddress
  GROUP BY user_id, har_id, responseip.harIPAddress;";

  $result = mysqli_query($conn, $sql);
  $map = [];

  if($result) {
    while($row = mysqli_fetch_assoc($result)){
        $map[] = $row;
    }
  }

  $sql = "SELECT user_id, latitude, longitude FROM history GROUP BY user_id;";
  $result2 = mysqli_query($conn, $sql);
  $users = [];
  
  if($result2) {
    while($row = mysqli_fetch_assoc($result2)){
        $users[] = $row;
    }
  }

?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <link rel="icon" href="images/favicon.ico" type="image/ico">
        <title>datasol | Visualize Data</title>
        <link rel="stylesheet" href="visualize.css">
        <!--LEAFLET CSS-->
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A==" crossorigin=""/>
        <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js" integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA==" crossorigin=""></script>
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
        </div>

        <script src="../user/dropdown.js"></script>

        <div id="mapid" style="height: 100%; width: 100%;"></div>
        <script> var jArray =<?php echo json_encode($map); ?>; </script>
        <script> var users =<?php echo json_encode($users); ?>; </script>
        <script language="JavaScript" type="text/javascript" src="map.js"></script>
    </body>
</html>