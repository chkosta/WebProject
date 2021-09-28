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

    $bar_graph = "";

    if ($dropdown == "Type of Web-Object"){
        $data = array('text'=>[0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0], 
        'application'=>[0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0], 
        'image'=>[0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0], 
        'font'=>[0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0], 
        'video'=>[0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0], 
        'audio'=>[0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
        'binary'=>[0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0]);
    
        $query = "SELECT ROUND(AVG(timings_wait), 2) AS total, SUBSTRING_INDEX(res_h_value, '/', 1) AS content_type, HOUR(DATE_FORMAT(startedDateTime,'%Y-%c-%d %T')) AS h FROM entries
        INNER JOIN req_res_head ON entries.id = req_res_head.entry_id
        WHERE res_h_name = 'content-type'
        GROUP BY content_type, h;";
        $result = mysqli_query($conn, $query);
    
        while($row = mysqli_fetch_array($result)){
            $data[$row['content_type']][$row['h'] - 1] = $row['total'];
        }
    
        $text = array_values($data['text']);
        $text = json_encode($text);
    
        $application = array_values($data['application']);
        $application = json_encode($application);
        
        $image = array_values($data['image']);
        $image = json_encode($image);
    
        $font = array_values($data['font']);
        $font = json_encode($font);
    
        $video = array_values($data['video']);
        $video = json_encode($video);
    
        $audio = array_values($data['audio']);
        $audio = json_encode($audio);
        
        $binary = array_values($data['binary']);
        $binary = json_encode($binary);
        
        $bar_graph = '
        <canvas id="myChart" data-settings=
        \'{
            "type": "bar",
            "data": {
                "labels": [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24],
                "datasets": [{
                    "data": '.$text.',
                    "label": "text",
                    "backgroundColor": "green"
                }, {
                    "data": '.$application.',
                    "label": "application",
                    "backgroundColor": "black"
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
                        "text": "Type of Web-Object",
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
                            "text": "Mean Response Time",
                            "font": {
                                "size": 15
                            },
                            "color": "black"
                        }
                    },
                    "xAxes": {
                        "title": {
                            "display": true,
                            "text": "Hour Of Day",
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

    else if ($dropdown == "Day of Week"){
        $data = array('Sunday'=>[0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0], 
        'Monday'=>[0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0], 
        'Tuesday'=>[0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0], 
        'Wednesday'=>[0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0], 
        'Thursday'=>[0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0], 
        'Friday'=>[0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0], 
        'Saturday'=>[0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0]);
    
        $query = "SELECT ROUND(AVG(timings_wait), 2) AS total, DAYNAME(startedDateTime) AS day_of_week, HOUR(DATE_FORMAT(startedDateTime,'%Y-%c-%d %T')) AS h, startedDateTime FROM entries
        GROUP BY day_of_week, h;";
        $result = mysqli_query($conn, $query);
    
        while($row = mysqli_fetch_array($result)){
            $data[$row['day_of_week']][$row['h'] - 1] = $row['total'];
        }
    
        $Sunday = array_values($data['Sunday']);
        $Sunday = json_encode($Sunday);
    
        $Monday = array_values($data['Monday']);
        $Monday = json_encode($Monday);
        
        $Tuesday = array_values($data['Tuesday']);
        $Tuesday = json_encode($Tuesday);
    
        $Wednesday = array_values($data['Wednesday']);
        $Wednesday = json_encode($Wednesday);
    
        $Thursday = array_values($data['Thursday']);
        $Thursday = json_encode($Thursday);
    
        $Friday = array_values($data['Friday']);
        $Friday = json_encode($Friday);
    
        $Saturday = array_values($data['Saturday']);
        $Saturday = json_encode($Saturday);

        $bar_graph = '
        <canvas id="myChart" data-settings=
        \'{
            "type": "bar",
            "data": {
                "labels": [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24],
                "datasets": [{
                    "data": '.$Sunday.',
                    "label": "Sunday",
                    "backgroundColor": "green"
                }, {
                    "data": '.$Monday.',
                    "label": "Monday",
                    "backgroundColor": "black"
                }, {
                    "data": '.$Tuesday.',
                    "label": "Tuesday",
                    "backgroundColor": "gray"
                }, {
                    "data": '.$Wednesday.',
                    "label": "Wednesday",
                    "backgroundColor": "blue"
                }, {
                    "data": '.$Thursday.',
                    "label": "Thursday",
                    "backgroundColor": "yellow"
                }, {
                    "data": '.$Friday.',
                    "label": "Friday",
                    "backgroundColor": "red"
                }, {
                    "data": '.$Saturday.',
                    "label": "Saturday",
                    "backgroundColor": "purple"
                }
                ]
            },
            "options": {
                "plugins": {
                    "title": {
                        "display": true,
                        "text": "Day of Week",
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
                            "text": "Mean Response Time",
                            "font": {
                                "size": 15
                            },
                            "color": "black"
                        }
                    },
                    "xAxes": {
                        "title": {
                            "display": true,
                            "text": "Hour Of Day",
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

    else if ($dropdown == "HTTP Request Method"){
        $data = array('GET'=>[0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0], 
        'HEAD'=>[0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0], 
        'OPTIONS'=>[0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0], 
        'POST'=>[0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0], 
        'PUT'=>[0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0]
        );
    
        $query = "SELECT ROUND(AVG(timings_wait), 2) AS total, req_method AS method, HOUR(DATE_FORMAT(startedDateTime,'%Y-%c-%d %T')) AS h FROM req_res_head
        INNER JOIN entries ON req_res_head.entry_id = entries.id
        WHERE req_method IS NOT NULL
        GROUP BY method, h;";
        $result = mysqli_query($conn, $query);
    
        while($row = mysqli_fetch_array($result)){
            $data[$row['method']][$row['h'] - 1] = $row['total'];
        }
    
        $get = array_values($data['GET']);
        $get = json_encode($get);
        
        $head = array_values($data['HEAD']);
        $head = json_encode($head);
    
        $options = array_values($data['OPTIONS']);
        $options = json_encode($options);
    
        $post = array_values($data['POST']);
        $post = json_encode($post);
    
        $put = array_values($data['PUT']);
        $put = json_encode($put);

        $bar_graph = '
        <canvas id="myChart" data-settings=
        \'{
            "type": "bar",
            "data": {
                "labels": [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24],
                "datasets": [{
                    "data": '.$get.',
                    "label": "GET",
                    "backgroundColor": "black"
                }, {
                    "data": '.$head.',
                    "label": "HEAD",
                    "backgroundColor": "orange"
                }, {
                    "data": '.$options.',
                    "label": "OPTIONS",
                    "backgroundColor": "white"
                }, {
                    "data": '.$post.',
                    "label": "POST",
                    "backgroundColor": "green"
                }, {
                    "data": '.$put.',
                    "label": "PUT",
                    "backgroundColor": "purple"
                }]
            },
            "options": {
                "plugins": {
                    "title": {
                        "display": true,
                        "text": "HTTP Request Method",
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
                            "text": "Mean Response Time",
                            "font": {
                                "size": 15
                            },
                            "color": "black"
                        }
                    },
                    "xAxes": {
                        "title": {
                            "display": true,
                            "text": "Hour Of Day",
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

    else if ($dropdown == "ISP"){
        $data = array('Vodafone-panafon Hellenic Telecommunications Company SA'=>[0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
                      'OTEnet'=>[0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
                      'UPATRAS'=>[0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
                      'Cablenet Communication Systems plc'=>[0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0]);

        $query = "SELECT ROUND(AVG(timings_wait), 2) AS total, ISP, HOUR(DATE_FORMAT(startedDateTime,'%Y-%c-%d %T')) AS h, startedDateTime FROM entries
        INNER JOIN history ON entries.har_id = history.har_id
        GROUP BY ISP, h;";
        $result = mysqli_query($conn, $query);

        while($row = mysqli_fetch_array($result)){
            $data[$row['ISP']][$row['h'] - 1] = $row['total'];
        }


        $vodafone = array_values($data['Vodafone-panafon Hellenic Telecommunications Company SA']);
        $vodafone = json_encode($vodafone);

        $ote = array_values($data['OTEnet']);
        $ote = json_encode($ote);

        $upatras = array_values($data['UPATRAS']);
        $upatras = json_encode($upatras);

        $cablenet = array_values($data['Cablenet Communication Systems plc']);
        $cablenet = json_encode($cablenet);

        $bar_graph = '
        <canvas id="myChart" data-settings=
        \'{
            "type": "bar",
            "data": {
                "labels": [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24],
                "datasets": [{
                    "data": '.$vodafone.',
                    "label": "Vodafone-panafon Hellenic Telecommunications Company SA",
                    "backgroundColor": "black"
                },
                {
                    "data": '.$ote.',
                    "label": "OTEnet",
                    "backgroundColor": "orange"
                },
                {
                    "data": '.$upatras.',
                    "label": "UPATRAS",
                    "backgroundColor": "white"
                },
                {
                    "data": '.$cablenet.',
                    "label": "Cablenet Communication Systems plc",
                    "backgroundColor": "pink"
                }]
            },
            "options": {
                "plugins": {
                    "title": {
                        "display": true,
                        "text": "ISP",
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
                            "text": "Mean Response Time",
                            "font": {
                                "size": 15
                            },
                            "color": "black"
                        }
                    },
                    "xAxes": {
                        "title": {
                            "display": true,
                            "text": "Hour Of Day",
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