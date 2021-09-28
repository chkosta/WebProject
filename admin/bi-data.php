<?php

    session_start();

    if(!isset($_SESSION['logged_in'])){
        header("Location: ../home.php");
    }

    require '../connection.php';

    if (isset($_POST['dropdownsel'])){
        $dropdown = $_POST['dropdownsel'];
    } else {
        $dropdown = "None";
    }

    if ($dropdown == "1"){
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
    else if ($dropdown == "2"){
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
    else if ($dropdown == "3"){
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
    else if ($dropdown == "4"){
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
    else if ($dropdown == "5"){
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
    else if ($dropdown == "6"){
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