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
        <title>datasol | Response Analysis</title>
        <link rel="stylesheet" href="response-analysis.css">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.5.0/chart.min.js"></script>
        <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    </head>

    <body>
        <div class="hero">
            <div class="logo">
                <a href="home.php"><img src="images/logo-icon.png"></a>
            </div>

            <div class="caption">datasol</div>
            
            <div class="navbar">
                <a>
                    <button class="dropbtn1" onclick="myFunction()">
                        <img src="images/mini-avatar-icon.png"> Hello, <?php echo $_SESSION['un1'] ?>!<img src="images/arrow-icon.png">
                    </button>
                    <div id="myDropdown1" class="dropdown-content1">
                        <a href="../logout.php"><img src="images/logout-icon.png"> Log out</a>
                    </div>
                </a>
                <a href="visualize.php"><img src="images/visualize-icon.png"> Visualize Data</a>
                <a href="headers-analysis.php"><img src="images/headers-icon.png"> Headers Analysis</a>
                <a href="response-analysis.php"><img src="images/response-icon.png"> Response Analysis</a>
                <a href="basic-info.php"><img src="images/info-icon.png"> Basic Info</a>
                <a href="home.php"><img src="images/home-icon.png"> Home</a>
            </div>

            <!-- TABLE AND DROPDOWN TO VIEW BASIC INFO -->
            <h2>Analysis of response times to requests</h2>
            <p>Select what kind of data you want to see by using the dropdown list.</p>
            <div class="box">
                <select id="myDropdown2">
                    <option value="-1" hidden>Choose from the list below</option>
                    <option value="Type of Web-Object">Type of Web-Object</option>
                    <option value="Day of Week">Day of Week</option>
                    <option value="HTTP Request Method">HTTP Request Method</option>
                    <option value="ISP">ISP</option>
                </select>
            </div>

            <div class="mychart" id="divChart"></div>
        </div>

        <script src="dropdown.js"></script>
        <script>
            $(document).ready(function(){
                $("#myDropdown2").change(function(){
                    $.ajax({
                        url: "ra-data.php",
                        type: "post",
                        data: {
                            dropdownsel: $(this).val()
                        },
                        success: function(bar_graph){
                            $("#divChart").html(bar_graph);
                            $("#myChart").chart = new Chart($("#myChart"), $("#myChart").data("settings"));
                        }
                    });
                });
            });
        </script>
    </body>
</html>