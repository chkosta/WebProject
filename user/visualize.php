<?php 
  session_start();

  if(!isset($_SESSION['logged_in'])){
    header("Location: ../home.php");
  }

  require '../connection.php';

  $sql = "SELECT responseip.harIPAddress, responseip.latitude, responseip.longitude, count(entries.serverIPAddress) AS count FROM history 
        INNER JOIN entries ON history.har_id = entries.har_id
        INNER JOIN req_res_head ON entries.id = req_res_head.entry_id
        INNER JOIN responseip ON entries.serverIPAddress = responseip.harIPAddress
        WHERE history.user_id = ". $_SESSION['userid'] ." AND (req_res_head.res_h_value LIKE '%html%' OR req_res_head.res_h_value LIKE '%php%' OR req_res_head.res_h_value LIKE '%asp%' OR req_res_head.res_h_value LIKE '%javascript%')
        GROUP BY responseip.harIPAddress;";

  $result = mysqli_query($conn, $sql);
  $heatmap = [];

  if($result) {
    while($row = mysqli_fetch_assoc($result)){
        $heatmap[] = $row;
    }
  }
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <link rel="icon" href="images/favicon.ico" type="image/ico">
        <title>datasol | Visualize Data</title>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
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
                        <a href="profile.php"><img src="images/settings-icon.png"> Edit Profile</a>
                        <a href="../logout.php"><img src="images/logout-icon.png"> Log out</a>
                    </div>
                </a>
                <a href="visualize.php"><img src="images/visualize-icon.png"> Visualize Data</a>
                <a href="upload.php"><img src="images/upload-icon.png"> Upload Data</a>
                <a href="home.php"><img src="images/home-icon.png"> Home</a>
            </div>
        </div>

        <script src="dropdown.js"></script>

        <div id="mapid" style="height: 100%; width: 100%;"></div>
        <script> var jArray =<?php echo json_encode($heatmap); ?>; </script>
        <script language="JavaScript" type="text/javascript" src="map.js"></script>
        <script language="JavaScript" type="text/javascript" src="HeatLayer.js"></script>
        <script language="JavaScript" type="text/javascript" src="leaflet-heat.js" ></script>
    </body>
</html>