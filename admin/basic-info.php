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
        <title>datasol | Basic Info</title>
        <link rel="stylesheet" href="basic-info.css">
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
            <h2>Display of basic information</h2>
            <p>Select what kind of data you want to see by using the dropdown list.</p>
            <button class="dropbtn2" onclick="myFunction()">Choose from the list below<img src="images/arrow-icon.png"></button>
            <div id="myDropdown2" class="dropdown-content2">
                <a href="basic-info.php?dropdown=1">Number of Registered Users</a>
                <a href="basic-info.php?dropdown=2">Number of Records per Request Method</a>
                <a href="basic-info.php?dropdown=3">Number of Records per Response Status</a>
                <a href="basic-info.php?dropdown=4">Number of Unique Domains</a>
                <a href="basic-info.php?dropdown=5">Number of Unique ISPs</a>
                <a href="basic-info.php?dropdown=6">Average Age of Web-Objects per Content-Type</a>
            </div>

            <table class="table-content">
            <?php
            if (isset($_GET['dropdown'])){
              $dropdown = $_GET['dropdown'];
            } else {
              $dropdown = 0;
            }

            if($dropdown == 1){
              echo '
                <div class="table-header">Number of Registered Users</div>
                <thead>
                  <tr>
                    <th>Number of Users</th>
                  </tr>
                </thead>
              ';

              $query = "SELECT COUNT(*) AS num_of_users FROM registration;";
              $result = mysqli_query($conn, $query);

              while($row = mysqli_fetch_array($result))  
              {  
                echo '
                <tbody>
                  <tr>
                    <td>'.$row["num_of_users"].'</td>
                  </tr>
                </tbody>
                ';  
              }
            }
            else if ($dropdown == 2){
              echo '
                <div class="table-header">Number of Records per Request Method</div>
                <thead>
                  <tr>
                    <th>Method Type</th>
                    <th>Count</th>
                  </tr>
                </thead>
              ';

              $query = "SELECT req_method AS method_type, count(req_method) AS count FROM req_res_head GROUP BY req_method HAVING count > 0;";
              $result = mysqli_query($conn, $query);

              while($row = mysqli_fetch_array($result))  
              {
                echo '
                <tbody>
                  <tr>
                    <td>'.$row["method_type"].'</td>
                    <td>'.$row["count"].'</td>
                  </tr>
                </tbody>
                ';
              }
            }
            else if ($dropdown == 3){
              echo '
                <div class="table-header">Number of Records per Response Status</div>
                <thead>
                  <tr>
                    <th>Status Type</th>
                    <th>Count</th>
                  </tr>
                </thead>
              ';

              $query = "SELECT res_status AS status_type, count(res_status) AS count FROM req_res_head GROUP BY res_status HAVING count > 0;";
              $result = mysqli_query($conn, $query);

              while($row = mysqli_fetch_array($result))  
              {
                echo '
                <tbody>
                  <tr>
                    <td>'.$row["status_type"].'</td>
                    <td>'.$row["count"].'</td>
                  </tr>
                </tbody>
                ';
              }
            }
            else if ($dropdown == 4){
              echo '
                <div class="table-header">Number of Unique Domains</div>
                <thead>
                  <tr>
                    <th>Number of Unique Domains</th>
                  </tr>
                </thead>
              ';

              $query = "SELECT count(distinct req_url) AS count FROM req_res_head;";
              $result = mysqli_query($conn, $query);

              while($row = mysqli_fetch_array($result))  
              {  
                echo '
                <tbody>
                  <tr>
                    <td>'.$row["count"].'</td>
                  </tr>
                </tbody>
                ';
              }
            }
            else if ($dropdown == 5){
              echo '
                <div class="table-header">Number of Unique ISPs</div>
                <thead>
                  <tr>
                    <th>Number of Unique ISPs</th>
                  </tr>
                </thead>
              ';

              $query = "SELECT count(distinct ISP) AS count FROM history;";
              $result = mysqli_query($conn, $query);

              while($row = mysqli_fetch_array($result))  
              {  
                echo '
                <tbody>
                  <tr>
                    <td>'.$row["count"].'</td>
                  </tr>
                </tbody>
                ';
              }
            }
            else if ($dropdown == 6){
              echo '
                <div class="table-header">Average Age of Web-Objects per Content-Type</div>
                <thead>
                  <tr>  
                    <th>Type</th>
                    <th>Age</th>
                  </tr>
                </thead>
              ';

              $query ="SELECT A.res_h_value AS content_type, ROUND(AVG(B.res_h_value), 2) AS average_age
              FROM req_res_head AS A
              INNER JOIN req_res_head AS B ON A.entry_id = B.entry_id
              WHERE (A.req_h_name = 'content-type' AND B.req_h_name = 'age') OR (A.res_h_name = 'content-type' AND B.res_h_name = 'age')
              GROUP BY A.res_h_value
              ORDER BY AVG(B.res_h_value);";
              $result = mysqli_query($conn, $query); 

              while($row = mysqli_fetch_array($result))  
              {
                echo '
                <tbody>
                  <tr>
                    <td>'.$row["content_type"].'</td>
                    <td>'.$row["average_age"].'</td>
                  </tr>
                </tbody>
                ';
              }
            }
            ?>
            </table>
        </div>

        <script src="dropdown.js"></script>
    </body>
</html>