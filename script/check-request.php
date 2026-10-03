<?php
    # check whether request is OK

    $request_ok = 0;
    $response_code = 403;
    session_start();

    if ( isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] ) {
        if ( preg_match('/(compare|compare-[a-z]*s|routes|trips|single-trip).php.*release_date=(latest|previous|long-term|20)/',$_SERVER['REQUEST_URI'],$matches)    ) {
            $script_name = $matches[1];
            #print_r( $matches );
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
