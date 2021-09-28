<?php 
    session_start();

    if(!isset($_SESSION['logged_in'])){
        header("Location: ../home.php");
    }

    require '../connection.php';

    $sql = "SELECT COUNT(*) as c FROM history WHERE user_id = '{$_SESSION['userid']}'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($result);
    $har_id = $row['c'] + 1;

    if (!empty($_POST)){
        print_r($_POST);
        $entries = $_POST['data'][1][1];
        $responseips = $_POST['data'][0];
        $total_rows = count($entries);
        $insert_limit = 134; 
        $entries_query = "INSERT INTO entries VALUES ";
        $entries_values = '';
        $req_res_head_query = "INSERT INTO req_res_head VALUES ";
        $req_res_head_values = '';
        $responseips_query = "INSERT INTO responseip VALUES ";
        $responseips_values = '';
        $i = 0;

        //INSERT ENTRIES
        foreach($entries as $item){
            $sdt = $item['entries']['startedDateTime'];
            $tw = $item['entries']['timings']['wait'];
            $sia = $item['entries']['serverIPAddress'];

            $entries_values .= "(null, $har_id, '$sdt', $tw, '$sia'),";
            $i += 1;
            if($i % $insert_limit == 0) {
                $entries_values = substr($entries_values, 0, strlen($entries_values) - 1);
                $insert_query = $entries_query . $entries_values;
                $result = mysqli_query($conn, $insert_query);
                $entries_values = '';
            }

            $method = $item['request']['method'];
            $url = $item['request']['url'];

            if(!empty($item['request']['headers'])){
                foreach ($item['request']['headers'] as $header){
                    $req_name = $header['name'];
                    $req_value = $header['value'];

                    $req_res_head_values .= "(null, $i, '$method', '$url', '$req_name', '$req_value', null, null, null, null),";
                }
            }else{
                $req_res_head_values .= "(null, $i, '$method', '$url', null, null, null, null, null, null),";
            }

            $status = $item['response']['status'];
            $statusText = $item['response']['statusText'];

            if(!empty($item['response']['headers'])){
                foreach ($item['response']['headers'] as $header){
                    $res_name = $header['name'];
                    $res_value = $header['value'];

                    $req_res_head_values .= "(null, $i, null, null, null, null, '$status', '$statusText', '$res_name', '$res_value'),";
                }
            }else{
                $req_res_head_values .= "(null, $i, null, null, null, null, '$status', '$statusText', null, null),";
            }

            if($i % $insert_limit == 0) {
                $req_res_head_values = substr($req_res_head_values, 0, strlen($req_res_head_values) - 1);
                $insert_query = $req_res_head_query . $req_res_head_values;
                $result = mysqli_query($conn, $insert_query);
                $req_res_head_values = '';
            }
        }

        $entries_values = substr($entries_values, 0, strlen($entries_values) - 1);
        $insert_query = $entries_query . $entries_values;
        $result = mysqli_query($conn, $insert_query);
        $entries_values = '';

        $req_res_head_values = substr($req_res_head_values, 0, strlen($req_res_head_values) - 1);
        $insert_query = $req_res_head_query . $req_res_head_values;
        $result2 = mysqli_query($conn, $insert_query);
        $req_res_head_values = '';
        
        date_default_timezone_set("Europe/Athens");
        $date =  date('Y-m-d')." ".date('H:i:s');
        $userid = $_SESSION['userid'];
        $userIPAddress = $_POST['data'][1][0]['serverIPAddress'];
        $ISP = $_POST['data'][1][0]['ISP'];
        $lat = $_POST['data'][1][0]['lat'];
        $lon = $_POST['data'][1][0]['lon'];
        $insert_query = "INSERT INTO history VALUES ($userid, null, '$date', $i, '$userIPAddress', '$ISP', $lat, $lon)";
        $result3 = mysqli_query($conn, $insert_query);

        $i = 0;
        foreach($responseips as $item){
            $harIPAddress = $item['harIPAddress'];
            $lat = $item['lat'];
            $lon = $item['lon'];

            $responseips_values .= "(null, '$harIPAddress', $lat, $lon),"; 
            $i += 1;
            if($i % $insert_limit == 0) {
                $responseips_values = substr($responseips_values, 0, strlen($responseips_values) - 1);
                $insert_query = $responseips_query . $responseips_values;
                $result4 = mysqli_query($conn, $insert_query);
                $responseips_values = '';
            }
        }

        $responseips_values = substr($responseips_values, 0, strlen($responseips_values) - 1);
        $insert_query = $responseips_query . $responseips_values;
        $result4 = mysqli_query($conn, $insert_query);
        $responseips_values = '';

        if ($result4){
            echo "<script>
                alert('Upload completed!');
                window.location.href='upload.php';
            </script>";
        }else {
            echo "<script>
                alert('Something went wrong!');
                window.location.href='upload.php';
            </script>";
        }
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <link rel="icon" href="images/favicon.ico" type="image/ico">
        <title>datasol | Upload Data</title>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
        <link rel="stylesheet" href="upload.css">
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

            <h2>Upload your .har file</h2>
            <p>Search for your .har file to upload. File is automatically being processed to remove sensitive data.</p>
            
            <div class="custom-file">
		        <input type="file" class="custom-file-input" id="customFile" accept=".har">
                <label class="custom-file-label" for="customFile">Select a file</label>
            </div>

            <p>After it is selected and processed, you can either upload it or save it locally, by using the buttons bellow.</p>
            <div class="buttons">
                <button type="file" class="btn upload-btn" id="upload">Upload</button>
                <button type="save" class="btn save-btn" id="save">Save</button>
            </div>
        </div>
        
        <script src="dropdown.js"></script>
        <script src="upload.js"></script>
    </body>
</html>