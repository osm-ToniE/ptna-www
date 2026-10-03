<?php
    # check whether request is OK

    $request_ok = 0;
    $response_code = 403;

    if ( isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] ) {
        if ( preg_match('/(compare|compare-[a-z]*s|routes|trips|single-trip|shape).php.*release_date=(latest|previous|long-term|20)/',$_SERVER['REQUEST_URI'],$matches)    ) {
            $script_name = $matches[1];
            $session_id = 'PTNA-session';
            session_id($session_id);
            session_start();
            $time_limit = 10; // max requests within 10 seconds
            $max_requests = 5;
            if (!isset($_SESSION[$script_name]['count'])) {
                $_SESSION[$script_name] = ['count' => 1, 'start_time' => time() ];
                $request_ok = 1;
                $response_code = 200;
            } else {
                $_SESSION[$script_name]['count']++;
                $_SESSION[$script_name]['time'] = time();
                if ($_SESSION[$script_name]['count'] > $max_requests && (time() - $_SESSION[$script_name]['start_time']) < $time_limit) {
                    $response_code = 429;
                } else {
                    if ( (time() - $_SESSION[$script_name]['start_time']) >= $time_limit ) {
                        $_SESSION[$script_name] = ['count' => 1, 'start_time' => time()];
                    }
                    $request_ok = 1;
                    $response_code = 200;
                }
            }
            #setcookie( $script_name . '-count', $_SESSION[$script_name]['count'], time()+1, '/', $_SERVER['SERVER_NAME'] );
            #print_r( $matches );
            #print_r( $_SESSION );
            session_write_close();
        } else {
            $request_ok = 1;
            $response_code = 200;
        }
    }

    if ( $response_code >= 300 ) {
        header( sprintf("Status: %d",$response_code), true, $response_code );
        exit();
    }
?>
