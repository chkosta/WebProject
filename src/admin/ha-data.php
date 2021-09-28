<?php

    session_start();

    if(!isset($_SESSION['logged_in'])){
        header("Location: ../home.php");
    }

    require '../connection.php';

    if (isset($_POST['dropdownsel'])){
        $dropdown = $_POST['dropdownsel'];
    } else {
        $dropdown = "";
    }

    $bar_graph = "";

    if ($dropdown == "TTL Distribution Histogram"){
        $data1 = array(
        'text'=>[0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
        'application'=>[0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
        'image'=>[0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
        'font'=>[0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
        'video'=>[0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
        'audio'=>[0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
        'binary'=>[0, 0, 0, 0, 0, 0, 0, 0, 0, 0]);
        
        $sum1 = array(
        'text'=>[0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
        'application'=>[0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
        'image'=>[0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
        'font'=>[0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
        'video'=>[0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
        'audio'=>[0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
        'binary'=>[0, 0, 0, 0, 0, 0, 0, 0, 0, 0]);

        $data2 = array('Vodafone-panafon Hellenic Telecommunications Company SA'=>[0, 0, 0, 0, 0, 0, 0, 0, 0, 0], 'OTEnet'=>[0, 0, 0, 0, 0, 0, 0, 0, 0, 0], 'UPATRAS'=>[0, 0, 0, 0, 0, 0, 0, 0, 0, 0], 'Cablenet Communication Systems plc'=>[0, 0, 0, 0, 0, 0, 0, 0, 0, 0]);
        $sum2 = array('Vodafone-panafon Hellenic Telecommunications Company SA'=>[0, 0, 0, 0, 0, 0, 0, 0, 0, 0], 'OTEnet'=>[0, 0, 0, 0, 0, 0, 0, 0, 0, 0], 'UPATRAS'=>[0, 0, 0, 0, 0, 0, 0, 0, 0, 0], 'Cablenet Communication Systems plc'=>[0, 0, 0, 0, 0, 0, 0, 0, 0, 0]);

        $data3 = array(
        'text'=>[0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
        'application'=>[0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
        'image'=>[0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
        'font'=>[0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
        'video'=>[0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
        'audio'=>[0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
        'binary'=>[0, 0, 0, 0, 0, 0, 0, 0, 0, 0]);

        $sum3 = array(
        'text'=>[0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
        'application'=>[0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
        'image'=>[0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
        'font'=>[0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
        'video'=>[0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
        'audio'=>[0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
        'binary'=>[0, 0, 0, 0, 0, 0, 0, 0, 0, 0]);

        $data4 = array('Vodafone-panafon Hellenic Telecommunications Company SA'=>[0, 0, 0, 0, 0, 0, 0, 0, 0, 0], 'OTEnet'=>[0, 0, 0, 0, 0, 0, 0, 0, 0, 0], 'UPATRAS'=>[0, 0, 0, 0, 0, 0, 0, 0, 0, 0], 'Cablenet Communication Systems plc'=>[0, 0, 0, 0, 0, 0, 0, 0, 0, 0]);
        $sum4 = array('Vodafone-panafon Hellenic Telecommunications Company SA'=>[0, 0, 0, 0, 0, 0, 0, 0, 0, 0], 'OTEnet'=>[0, 0, 0, 0, 0, 0, 0, 0, 0, 0], 'UPATRAS'=>[0, 0, 0, 0, 0, 0, 0, 0, 0, 0], 'Cablenet Communication Systems plc'=>[0, 0, 0, 0, 0, 0, 0, 0, 0, 0]);


        $query = "SELECT ISP, A.res_h_value AS last_modified, B.res_h_value AS expires, SUBSTRING_INDEX(C.res_h_value, '/', 1) AS content_type, ROUND(COUNT(*)/3, 0) as total FROM req_res_head AS A
        INNER JOIN req_res_head AS B ON A.entry_id = B.entry_id
        INNER JOIN req_res_head AS C ON B.entry_id = C.entry_id
        INNER JOIN entries ON C.entry_id = entries.id
        INNER JOIN history ON entries.har_id = history.har_id
        WHERE (A.res_h_name = 'last-modified') AND (B.res_h_name = 'expires') AND (C.res_h_name = 'content-type') AND (A.res_h_value NOT LIKE '%max-age%' AND B.res_h_value NOT LIKE '%max-age%')
        GROUP BY C.res_h_value, ISP;";
        $result = mysqli_query($conn, $query);

        while($row = mysqli_fetch_array($result))
        {
            $last_modified = date("Y-m-d H:i:s", strtotime($row['last_modified']));
            $expires = date("Y-m-d H:i:s", strtotime($row['expires']));

            $expires_is_zero = $row['expires'];

            if ($expires_is_zero == '0') {
                continue;
            }
            
            $diff = abs(strtotime($last_modified) - strtotime($expires));

            if ($diff <= 98501439){
                $sum3[$row['content_type']][0] = $sum3[$row['content_type']][0] + $row['total'];
                $data3[$row['content_type']][0] = $sum3[$row['content_type']][0];

                $sum4[$row['ISP']][0] = $sum4[$row['ISP']][0] + $row['total'];
                $data4[$row['ISP']][0] = $sum4[$row['ISP']][0];
            }
            else if ($diff >= 98501440 && $diff <= 197002879){
                $sum3[$row['content_type']][1] = $sum3[$row['content_type']][1] + $row['total'];
                $data3[$row['content_type']][1] =  $sum3[$row['content_type']][1];

                $sum4[$row['ISP']][1] = $sum4[$row['ISP']][1] + $row['total'];
                $data4[$row['ISP']][1] = $sum4[$row['ISP']][1];
            }
            else if ($diff >= 197002880 && $diff <= 295504319){
                $sum3[$row['content_type']][2] = $sum3[$row['content_type']][2] + $row['total'];
                $data3[$row['content_type']][2] =  $sum3[$row['content_type']][2];

                $sum4[$row['ISP']][2] = $sum4[$row['ISP']][2] + $row['total'];
                $data4[$row['ISP']][2] = $sum4[$row['ISP']][2];
            }
            else if ($diff >= 295504320 && $diff <= 394005759){
                $sum3[$row['content_type']][3] = $sum3[$row['content_type']][3] + $row['total'];
                $data3[$row['content_type']][3] =  $sum3[$row['content_type']][3];

                $sum4[$row['ISP']][3] = $sum4[$row['ISP']][3] + $row['total'];
                $data4[$row['ISP']][3] = $sum4[$row['ISP']][3];
            }
            else if ($diff >= 394005760 && $diff <= 492507199){
                $sum3[$row['content_type']][4] = $sum3[$row['content_type']][4] + $row['total'];
                $data3[$row['content_type']][4] = $sum3[$row['content_type']][4];

                $sum4[$row['ISP']][4] = $sum4[$row['ISP']][4] + $row['total'];
                $data4[$row['ISP']][4] = $sum4[$row['ISP']][4];
            }
            else if ($diff >= 492507200 && $diff <= 591008639){
                $sum3[$row['content_type']][5] = $sum3[$row['content_type']][5] + $row['total'];
                $data3[$row['content_type']][5] = $sum3[$row['content_type']][5];

                $sum4[$row['ISP']][5] = $sum4[$row['ISP']][5] + $row['total'];
                $data4[$row['ISP']][5] = $sum4[$row['ISP']][5];
            }
            else if ($diff >= 591008640 && $diff <= 689510079){
                $sum3[$row['content_type']][6] = $sum3[$row['content_type']][6] + $row['total'];
                $data3[$row['content_type']][6] = $sum3[$row['content_type']][6];

                $sum4[$row['ISP']][6] = $sum4[$row['ISP']][6] + $row['total'];
                $data4[$row['ISP']][6] = $sum4[$row['ISP']][6];
            }
            else if ($diff >= 689510080 && $diff <= 788011519){
                $sum3[$row['content_type']][7] = $sum3[$row['content_type']][7] + $row['total'];
                $data3[$row['content_type']][7] = $sum3[$row['content_type']][7];

                $sum4[$row['ISP']][7] = $sum4[$row['ISP']][7] + $row['total'];
                $data4[$row['ISP']][7] = $sum4[$row['ISP']][7];
            }
            else if ($diff >= 788011520 && $diff <= 886512959){
                $sum3[$row['content_type']][8] = $sum3[$row['content_type']][8] + $row['total'];
                $data3[$row['content_type']][8] = $sum3[$row['content_type']][8];

                $sum4[$row['ISP']][8] = $sum4[$row['ISP']][8] + $row['total'];
                $data4[$row['ISP']][8] = $sum4[$row['ISP']][8];
            }
            else if ($diff >= 886512960 && $diff <= 985014399){
                $sum3[$row['content_type']][9] = $sum3[$row['content_type']][9] + $row['total'];
                $data3[$row['content_type']][9] = $sum3[$row['content_type']][9];

                $sum4[$row['ISP']][9] = $sum4[$row['ISP']][9] + $row['total'];
                $data4[$row['ISP']][9] = $sum4[$row['ISP']][9];
            }
        }
        

        $query = "SELECT ISP, SUBSTRING_INDEX(A.res_h_value, '/', 1) AS content_type, B.res_h_value AS max_age, ROUND(COUNT(*)/2, 0) as total FROM req_res_head AS A
        INNER JOIN req_res_head AS B ON A.entry_id = B.entry_id
        INNER JOIN entries ON A.entry_id = entries.id
        INNER JOIN history ON entries.har_id = history.har_id
        WHERE (A.res_h_name = 'content-type') AND (B.res_h_name = 'cache-control') AND (B.res_h_value LIKE '%max-age%')
        GROUP BY A.res_h_value, ISP;";
        $result = mysqli_query($conn, $query);

        while($row = mysqli_fetch_array($result))
        {
            preg_match_all('!\d+!', $row['max_age'], $max_age);
            $max_age = $max_age[0][0];

            if ($max_age <= 98501439){
                $sum1[$row['content_type']][0] = $sum1[$row['content_type']][0] + $row['total'];
                $data1[$row['content_type']][0] = $sum1[$row['content_type']][0];

                $sum2[$row['ISP']][0] = $sum2[$row['ISP']][0] + $row['total'];
                $data2[$row['ISP']][0] = $sum2[$row['ISP']][0];
            }
            else if ($max_age >= 98501440 && $max_age <= 197002879){
                $sum1[$row['content_type']][1] = $sum1[$row['content_type']][1] + $row['total'];
                $data1[$row['content_type']][1] =  $sum1[$row['content_type']][1];

                $sum2[$row['ISP']][1] = $sum2[$row['ISP']][1] + $row['total'];
                $data2[$row['ISP']][1] = $sum2[$row['ISP']][1];
            }
            else if ($max_age >= 197002880 && $max_age <= 295504319){
                $sum1[$row['content_type']][2] = $sum1[$row['content_type']][2] + $row['total'];
                $data1[$row['content_type']][2] =  $sum1[$row['content_type']][2];

                $sum2[$row['ISP']][2] = $sum2[$row['ISP']][2] + $row['total'];
                $data2[$row['ISP']][2] = $sum2[$row['ISP']][2];
            }
            else if ($max_age >= 295504320 && $max_age <= 394005759){
                $sum1[$row['content_type']][3] = $sum1[$row['content_type']][3] + $row['total'];
                $data1[$row['content_type']][3] =  $sum1[$row['content_type']][3];

                $sum2[$row['ISP']][3] = $sum2[$row['ISP']][3] + $row['total'];
                $data2[$row['ISP']][3] = $sum2[$row['ISP']][3];
            }
            else if ($max_age >= 394005760 && $max_age <= 492507199){
                $sum1[$row['content_type']][4] = $sum1[$row['content_type']][4] + $row['total'];
                $data1[$row['content_type']][4] = $sum1[$row['content_type']][4];

                $sum2[$row['ISP']][4] = $sum2[$row['ISP']][4] + $row['total'];
                $data2[$row['ISP']][4] = $sum2[$row['ISP']][4];
            }
            else if ($max_age >= 492507200 && $max_age <= 591008639){
                $sum1[$row['content_type']][5] = $sum1[$row['content_type']][5] + $row['total'];
                $data1[$row['content_type']][5] = $sum1[$row['content_type']][5];

                $sum2[$row['ISP']][5] = $sum2[$row['ISP']][5] + $row['total'];
                $data2[$row['ISP']][5] = $sum2[$row['ISP']][5];
            }
            else if ($max_age >= 591008640 && $max_age <= 689510079){
                $sum1[$row['content_type']][6] = $sum1[$row['content_type']][6] + $row['total'];
                $data1[$row['content_type']][6] = $sum1[$row['content_type']][6];

                $sum2[$row['ISP']][6] = $sum2[$row['ISP']][6] + $row['total'];
                $data2[$row['ISP']][6] = $sum2[$row['ISP']][6];
            }
            else if ($max_age >= 689510080 && $max_age <= 788011519){
                $sum1[$row['content_type']][7] = $sum1[$row['content_type']][7] + $row['total'];
                $data1[$row['content_type']][7] = $sum1[$row['content_type']][7];

                $sum2[$row['ISP']][7] = $sum2[$row['ISP']][7] + $row['total'];
                $data2[$row['ISP']][7] = $sum2[$row['ISP']][7];
            }
            else if ($max_age >= 788011520 && $max_age <= 886512959){
                $sum1[$row['content_type']][8] = $sum1[$row['content_type']][8] + $row['total'];
                $data1[$row['content_type']][8] = $sum1[$row['content_type']][8];

                $sum2[$row['ISP']][8] = $sum2[$row['ISP']][8] + $row['total'];
                $data2[$row['ISP']][8] = $sum2[$row['ISP']][8];
            }
            else if ($max_age >= 886512960 && $max_age <= 985014399){
                $sum1[$row['content_type']][9] = $sum1[$row['content_type']][9] + $row['total'];
                $data1[$row['content_type']][9] = $sum1[$row['content_type']][9];

                $sum2[$row['ISP']][9] = $sum2[$row['ISP']][9] + $row['total'];
                $data2[$row['ISP']][9] = $sum2[$row['ISP']][9];
            }
        }

        $sums1 = array();
        foreach (array_keys($data1 + $data3) as $key) {
            $sums1[$key][0] = $data1[$key][0] + $data3[$key][0];
            $sums1[$key][1] = $data1[$key][1] + $data3[$key][1];
            $sums1[$key][2] = $data1[$key][2] + $data3[$key][2];
            $sums1[$key][3] = $data1[$key][3] + $data3[$key][3];
            $sums1[$key][4] = $data1[$key][4] + $data3[$key][4];
            $sums1[$key][5] = $data1[$key][5] + $data3[$key][5];
            $sums1[$key][6] = $data1[$key][6] + $data3[$key][6];
            $sums1[$key][7] = $data1[$key][7] + $data3[$key][7];
            $sums1[$key][8] = $data1[$key][8] + $data3[$key][8];
            $sums1[$key][9] = $data1[$key][9] + $data3[$key][9];
        }

        $sums2 = array();
        foreach (array_keys($data2 + $data4) as $key) {
            $sums2[$key][0] = $data2[$key][0] + $data4[$key][0];
            $sums2[$key][1] = $data2[$key][1] + $data4[$key][1];
            $sums2[$key][2] = $data2[$key][2] + $data4[$key][2];
            $sums2[$key][3] = $data2[$key][3] + $data4[$key][3];
            $sums2[$key][4] = $data2[$key][4] + $data4[$key][4];
            $sums2[$key][5] = $data2[$key][5] + $data4[$key][5];
            $sums2[$key][6] = $data2[$key][6] + $data4[$key][6];
            $sums2[$key][7] = $data2[$key][7] + $data4[$key][7];
            $sums2[$key][8] = $data2[$key][8] + $data4[$key][8];
            $sums2[$key][9] = $data2[$key][9] + $data4[$key][9];
        }


        $vodafone = array_values($sums2['Vodafone-panafon Hellenic Telecommunications Company SA']);
        $vodafone = json_encode($vodafone);
        
        $ote = array_values($sums2['OTEnet']);
        $ote = json_encode($ote);

        $upatras = array_values($sums2['UPATRAS']);
        $upatras = json_encode($upatras);

        $cablenet = array_values($sums2['Cablenet Communication Systems plc']);
        $cablenet = json_encode($cablenet);

        $text = array_values($sums1['text']);
        $text = json_encode($text);

        $application = array_values($sums1['application']);
        $application = json_encode($application);

        $image = array_values($sums1['image']);
        $image = json_encode($image);

        $font = array_values($sums1['font']);
        $font = json_encode($font);

        $video = array_values($sums1['video']);
        $video = json_encode($video);

        $audio = array_values($sums1['audio']);
        $audio = json_encode($audio);

        $binary = array_values($sums1['binary']);
        $binary = json_encode($binary);

        $bar_graph = '
        <canvas id="myChart" data-settings=
        \'{
            "type": "bar",
            "data": {
            "labels": ["0-98501439", "98501440-197002879", "197002880-295504319", "295504320-394005759",
            "394005760-492507199", "492507200-591008639", "591008640-689510079", "689510080-788011519",
            "788011520-886512959", "886512960-985014399"],
            "datasets": [{
                "data": '.$vodafone.',
                "label": "Vodafone-panafon Hellenic Telecommunications Company SA",
                "backgroundColor": "black"
            }, {
                "data": '.$ote.',
                "label": "OTEnet",
                "backgroundColor": "orange"
            }, {
                "data": '.$upatras.',
                "label": "UPATRAS",
                "backgroundColor": "white"
            }, {
                "data": '.$cablenet.',
                "label": "Cablenet Communication Systems plc",
                "backgroundColor": "pink"
            }, {
                "data": '.$text.',
                "label": "text",
                "backgroundColor": "green"
            }, {
                "data": '.$application.',
                "label": "application",
                "backgroundColor": "purple"
            }, {
                "data": '.$image.',
                "label": "image",
                "backgroundColor": "gray"
            }, {
                "data": '.$font.',
                "label": "font",
                "backgroundColor": "blue"
            }, {
                "data": '.$video.',
                "label": "video",
                "backgroundColor": "yellow"
            }, {
                "data": '.$audio.',
                "label": "audio",
                "backgroundColor": "red"
            }, {
                "data": '.$binary.',
                "label": "binary",
                "backgroundColor": "brown"
            }]
            },
            "options": {
                "plugins": {
                    "title": {
                        "display": true,
                        "text": "TTL Distribution Histogram of Web-Objects",
                        "font": {
                            "size": 20
                        },
                        "color": "black"
                    }
                },
                "scales": {
                    "yAxes": {
                        "title": {
                            "display": true,
                            "text": "Number of Web-Objects",
                            "font": {
                                "size": 15
                            },
                            "color": "black"
                        }
                    },
                    "xAxes": {
                        "title": {
                            "display": true,
                            "text": "Sections of TTL",
                            "font": {
                                "size": 15
                            },
                            "color": "black"
                        }
                    }
                }
            }
        }\'
        ></canvas>';
    }
    
    else if ($dropdown == "Max-Min Directives"){
        $data1 = array('text'=>[0, 0], 'application'=>[0, 0], 'image'=>[0, 0], 'font'=>[0, 0], 'video'=>[0, 0], 'audio'=>[0, 0], 'binary'=>[0, 0]);
        $sum1 = array('text'=>[0, 0], 'application'=>[0, 0], 'image'=>[0, 0], 'font'=>[0, 0], 'video'=>[0, 0], 'audio'=>[0, 0], 'binary'=>[0, 0]);

        $data2 = array('Vodafone-panafon Hellenic Telecommunications Company SA'=>[0, 0], 'OTEnet'=>[0, 0], 'UPATRAS'=>[0, 0], 'Cablenet Communication Systems plc'=>[0, 0]);
        $sum2 = array('Vodafone-panafon Hellenic Telecommunications Company SA'=>[0, 0], 'OTEnet'=>[0, 0], 'UPATRAS'=>[0, 0], 'Cablenet Communication Systems plc'=>[0, 0]);

        $query = "SELECT COUNT(*) AS total FROM req_res_head AS A
        INNER JOIN req_res_head AS B ON A.entry_id = B.entry_id
        INNER JOIN entries ON A.entry_id = entries.id
        INNER JOIN history ON entries.har_id = history.har_id
        WHERE A.res_h_name = 'cache-control' AND ((B.res_h_value LIKE '%min-fresh%') OR (B.res_h_value LIKE '%max-stale%'));";
        $result = mysqli_query($conn, $query);

        while ($row = mysqli_fetch_array($result)){
            $count = $row['total'];
        }

        $query = "SELECT ISP, SUBSTRING_INDEX(A.res_h_value, '/', 1) AS content_type, B.res_h_value AS minfresh_maxstale_directives, COUNT(B.res_h_value) AS total FROM req_res_head AS A
        INNER JOIN req_res_head AS B ON A.entry_id = B.entry_id
        INNER JOIN entries ON A.entry_id = entries.id
        INNER JOIN history ON entries.har_id = history.har_id
        WHERE A.res_h_name = 'content-type' AND ((B.res_h_value LIKE '%min-fresh%') OR (B.res_h_value LIKE '%max-stale%'))
        GROUP BY A.res_h_value, ISP;";
        $result = mysqli_query($conn, $query);

        while($row = mysqli_fetch_array($result))
        {

            $max_stale = stripos($row['minfresh_maxstale_directives'], 'max-stale');
            $min_fresh = stripos($row['minfresh_maxstale_directives'], 'min-fresh');

            if ($max_stale !== false){
                $sum1[$row['content_type']][0] = $sum1[$row['content_type']][0] + $row['total'];
                $sum2[$row['ISP']][0] = $sum2[$row['ISP']][0] + $row['total'];
            }
            else if ($min_fresh !== false){
                $sum1[$row['content_type']][1] = $sum1[$row['content_type']][1] + $row['total'];
                $sum2[$row['ISP']][1] = $sum2[$row['ISP']][1] + $row['total'];
            }
        }

        
        for ($i = 0; $i < 2; $i++) {
            $data1['text'][$i] = round($sum1["text"][$i]*100 / 1, 2);
            $data1['application'][$i] = round($sum1["application"][$i]*100 / 1, 2);
            $data1['image'][$i] = round($sum1["image"][$i]*100 / 1, 2);
            $data1['font'][$i] = round($sum1["font"][$i]*100 / 1, 2);
            $data1['video'][$i] = round($sum1["video"][$i]*100 / 1, 2);
            $data1['audio'][$i] = round($sum1["audio"][$i]*100 / 1, 2);
            $data1['binary'][$i] = round($sum1["binary"][$i]*100 / 1, 2);
            $data2['Vodafone-panafon Hellenic Telecommunications Company SA'][$i] = round($sum2["Vodafone-panafon Hellenic Telecommunications Company SA"][$i]*100 / 1, 2);
            $data2['OTEnet'][$i] = round($sum2["OTEnet"][$i]*100 / 1, 2);
            $data2['UPATRAS'][$i] = round($sum2["UPATRAS"][$i]*100 / 1, 2);
            $data2['Cablenet Communication Systems plc'][$i] = round($sum2["Cablenet Communication Systems plc"][$i]*100 / 1, 2);
        }


        $vodafone = array_values($data2['Vodafone-panafon Hellenic Telecommunications Company SA']);
        $vodafone = json_encode($vodafone);

        $ote = array_values($data2['OTEnet']);
        $ote = json_encode($ote);

        $upatras = array_values($data2['UPATRAS']);
        $upatras = json_encode($upatras);

        $cablenet = array_values($data2['Cablenet Communication Systems plc']);
        $cablenet = json_encode($cablenet);

        $text = array_values($data1['text']);
        $text = json_encode($text);

        $application = array_values($data1['application']);
        $application = json_encode($application);
            
        $image = array_values($data1['image']);
        $image = json_encode($image);

        $font = array_values($data1['font']);
        $font = json_encode($font);

        $video = array_values($data1['video']);
        $video = json_encode($video);

        $audio = array_values($data1['audio']);
        $audio = json_encode($audio);

        $binary = array_values($data1['binary']);
        $binary = json_encode($binary);

        $bar_graph = '
        <canvas id="myChart" data-settings=
        \'{
            "type": "bar",
            "data": {
                "labels": ["max-stale", "min-fresh"],
                "datasets": [{
                    "data": '.$vodafone.',
                    "label": "Vodafone-panafon Hellenic Telecommunications Company SA",
                    "backgroundColor": "black"
                }, {
                    "data": '.$ote.',
                    "label": "OTEnet",
                    "backgroundColor": "orange"
                }, {
                    "data": '.$upatras.',
                    "label": "UPATRAS",
                    "backgroundColor": "white"
                }, {
                    "data": '.$cablenet.',
                    "label": "Cablenet Communication Systems plc",
                    "backgroundColor": "pink"
                }, {
                    "data": '.$text.',
                    "label": "text",
                    "backgroundColor": "green"
                }, {
                    "data": '.$application.',
                    "label": "application",
                    "backgroundColor": "purple"
                }, {
                    "data": '.$image.',
                    "label": "image",
                    "backgroundColor": "gray"
                }, {
                    "data": '.$font.',
                    "label": "font",
                    "backgroundColor": "blue"
                }, {
                    "data": '.$video.',
                    "label": "video",
                    "backgroundColor": "yellow"
                }, {
                    "data": '.$audio.',
                    "label": "audio",
                    "backgroundColor": "red"
                }, {
                    "data": '.$binary.',
                    "label": "binary",
                    "backgroundColor": "brown"
                }]
            },
            "options": {
                "plugins": {
                    "title": {
                        "display": true,
                        "text": "Max-Stale and Min-Stale Directives Percentage",
                        "font": {
                            "size": 20
                        },
                        "color": "black"
                    }
                },
                "scales": {
                    "yAxes": {
                        "title": {
                            "display": true,
                            "text": "Percentage",
                            "font": {
                                "size": 15
                            },
                            "color": "black"
                        }
                    },
                    "xAxes": {
                        "title": {
                            "display": true,
                            "text": "Max-Stale and Min-Stale Directives",
                            "font": {
                                "size": 15
                            },
                            "color": "black"
                        }
                    }
                }
            }
        }\'
        ></canvas>';
    }

    else if ($dropdown == "Cacheability Directives"){
        $data1 = array('text'=>[0, 0, 0, 0], 'application'=>[0, 0, 0, 0], 'image'=>[0, 0, 0, 0], 'font'=>[0, 0, 0, 0], 'video'=>[0, 0, 0, 0], 'audio'=>[0, 0, 0, 0], 'binary'=>[0, 0, 0, 0]);
        $sum1 = array('text'=>[0, 0, 0, 0], 'application'=>[0, 0, 0, 0], 'image'=>[0, 0, 0, 0], 'font'=>[0, 0, 0, 0], 'video'=>[0, 0, 0, 0], 'audio'=>[0, 0, 0, 0], 'binary'=>[0, 0, 0, 0]);

        $data2 = array('Vodafone-panafon Hellenic Telecommunications Company SA'=>[0, 0, 0, 0], 'OTEnet'=>[0, 0, 0, 0], 'UPATRAS'=>[0, 0, 0, 0], 'Cablenet Communication Systems plc'=>[0, 0, 0, 0]);
        $sum2 = array('Vodafone-panafon Hellenic Telecommunications Company SA'=>[0, 0, 0, 0], 'OTEnet'=>[0, 0, 0, 0], 'UPATRAS'=>[0, 0, 0, 0], 'Cablenet Communication Systems plc'=>[0, 0, 0, 0]);

        $query = "SELECT COUNT(*) AS total FROM req_res_head AS A
        INNER JOIN req_res_head AS B ON A.entry_id = B.entry_id
        INNER JOIN entries ON A.entry_id = entries.id
        INNER JOIN history ON entries.har_id = history.har_id
        WHERE A.res_h_name = 'content-type' AND ((B.res_h_value LIKE '%public%') OR (B.res_h_value LIKE '%private%') OR (B.res_h_value LIKE '%no-cache%') OR (B.res_h_value like '%no-store%'));";
        $result = mysqli_query($conn, $query);

        while ($row = mysqli_fetch_array($result)){
            $count = $row['total'];
        }

        $query = "SELECT ISP, SUBSTRING_INDEX(A.res_h_value, '/', 1) AS content_type, B.res_h_value AS cacheability_directive, COUNT(B.res_h_value) AS total FROM req_res_head AS A
        INNER JOIN req_res_head AS B ON A.entry_id = B.entry_id
        INNER JOIN entries ON A.entry_id = entries.id
        INNER JOIN history ON entries.har_id = history.har_id
        WHERE A.res_h_name = 'content-type' AND ((B.res_h_value LIKE '%public%') OR (B.res_h_value LIKE '%private%') OR (B.res_h_value LIKE '%no-cache%') OR (B.res_h_value like '%no-store%'))
        GROUP BY A.res_h_value, ISP;";
        $result = mysqli_query($conn, $query);

        while($row = mysqli_fetch_array($result))
        {

            $cs = stripos($row['cacheability_directive'], 'no-cache, no-store');
            $public = stripos($row['cacheability_directive'], 'public');
            $private = stripos($row['cacheability_directive'], 'private');
            $no_cache = stripos($row['cacheability_directive'], 'no-cache');


            if ($cs !== false){
                $sum1[$row['content_type']][0] = $sum1[$row['content_type']][0] + $row['total'];
                $sum2[$row['ISP']][0] = $sum2[$row['ISP']][0] + $row['total'];
            }
            else if ($public !== false){
                $sum1[$row['content_type']][1] = $sum1[$row['content_type']][1] + $row['total'];
                $sum2[$row['ISP']][1] = $sum2[$row['ISP']][1] + $row['total'];
            }
            else if ($private !== false){
                $sum1[$row['content_type']][2] = $sum1[$row['content_type']][2] + $row['total'];
                $sum2[$row['ISP']][2] = $sum2[$row['ISP']][2] + $row['total'];
            }
            else if ($no_cache !== false){
                $sum1[$row['content_type']][3] = $sum1[$row['content_type']][3] + $row['total'];
                $sum2[$row['ISP']][3] = $sum2[$row['ISP']][3] + $row['total'];
            }
        }

        for ($i = 0; $i < 4; $i++) {
            $data1['text'][$i] = round($sum1["text"][$i]*100 / $count, 2);
            $data1['application'][$i] = round($sum1["application"][$i]*100 / $count, 2);
            $data1['image'][$i] = round($sum1["image"][$i]*100 / $count, 2);
            $data1['font'][$i] = round($sum1["font"][$i]*100 / $count, 2);
            $data1['video'][$i] = round($sum1["video"][$i]*100 / $count, 2);
            $data1['audio'][$i] = round($sum1["audio"][$i]*100 / $count, 2);
            $data1['binary'][$i] = round($sum1["binary"][$i]*100 / $count, 2);
            $data2['Vodafone-panafon Hellenic Telecommunications Company SA'][$i] = round($sum2["Vodafone-panafon Hellenic Telecommunications Company SA"][$i]*100 / $count, 2);
            $data2['OTEnet'][$i] = round($sum2["OTEnet"][$i]*100 / $count, 2);
            $data2['UPATRAS'][$i] = round($sum2["UPATRAS"][$i]*100 / $count, 2);
            $data2['Cablenet Communication Systems plc'][$i] = round($sum2["Cablenet Communication Systems plc"][$i]*100 / $count, 2);
        }


        $vodafone = array_values($data2['Vodafone-panafon Hellenic Telecommunications Company SA']);
        $vodafone = json_encode($vodafone);

        $ote = array_values($data2['OTEnet']);
        $ote = json_encode($ote);

        $upatras = array_values($data2['UPATRAS']);
        $upatras = json_encode($upatras);

        $cablenet = array_values($data2['Cablenet Communication Systems plc']);
        $cablenet = json_encode($cablenet);
        
        $text = array_values($data1['text']);
        $text = json_encode($text);

        $application = array_values($data1['application']);
        $application = json_encode($application);

        $image = array_values($data1['image']);
        $image = json_encode($image);

        $font = array_values($data1['font']);
        $font = json_encode($font);

        $video = array_values($data1['video']);
        $video = json_encode($video);

        $audio = array_values($data1['audio']);
        $audio = json_encode($audio);

        $binary = array_values($data1['binary']);
        $binary = json_encode($binary);

        $bar_graph = '
        <canvas id="myChart" data-settings=
        \'{
            "type": "bar",
            "data": {
                "labels": ["no-cache, no-store", "public", "private", "no-cache"],
                "datasets": [{
                    "data": '.$vodafone.',
                    "label": "Vodafone-panafon Hellenic Telecommunications Company SA",
                    "backgroundColor": "black"
                }, {
                    "data": '.$ote.',
                    "label": "OTEnet",
                    "backgroundColor": "orange"
                }, {
                    "data": '.$upatras.',
                    "label": "UPATRAS",
                    "backgroundColor": "white"
                }, {
                    "data": '.$cablenet.',
                    "label": "Cablenet Communication Systems plc",
                    "backgroundColor": "pink"
                }, {
                    "data": '.$text.',
                    "label": "text",
                    "backgroundColor": "green"
                }, {
                    "data": '.$application.',
                    "label": "application",
                    "backgroundColor": "purple"
                }, {
                    "data": '.$image.',
                    "label": "image",
                    "backgroundColor": "gray"
                }, {
                    "data": '.$font.',
                    "label": "font",
                    "backgroundColor": "blue"
                }, {
                    "data": '.$video.',
                    "label": "video",
                    "backgroundColor": "yellow"
                }, {
                    "data": '.$audio.',
                    "label": "audio",
                    "backgroundColor": "red"
                }, {
                    "data": '.$binary.',
                    "label": "binary",
                    "backgroundColor": "brown"
                }
                ]
            },
            "options": {
                "plugins": {
                    "title": {
                        "display": true,
                        "text": "Cacheability Directives Percentage",
                        "font": {
                            "size": 20
                        },
                        "color": "black"
                    }
                },
                "scales": {
                    "yAxes": {
                        "title": {
                            "display": true,
                            "text": "Percentage",
                            "font": {
                                "size": 15
                            },
                            "color": "black"
                        }
                    },
                    "xAxes": {
                        "title": {
                            "display": true,
                            "text": "Cacheability Directives",
                            "font": {
                                "size": 15
                            },
                            "color": "black"
                        }
                    }
                }
            }
        }\'
        ></canvas>';
    }
            
    echo $bar_graph;

?>