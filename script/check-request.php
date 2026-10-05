<?php
    # check whether request is OK

    $session_id    = 'PTNA-session';
    $request_ok    = 0;
    $response_code = 403;
    $resource_name = '';
    $time_limit    = 10;
    $max_requests  = 100;

    if ( isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] ) {
        if ( preg_match('/(compare|compare-[a-z]*s|routes|trips|single-trip|shape).php.*release_date=(latest|previous|long-term|20)/',$_SERVER['REQUEST_URI'],$matches)    ) {
            $resource_name = $matches[1];
            $max_requests = 3;
        } else {
            $request_ok = 1;
            $response_code = 200;
        }
    } else {
        $resource_name = 'no-referrer';
        $max_requests  = 3;
    }

    if ( $resource_name ) {
        session_id($session_id);
        session_start();
        if (!isset($_SESSION[$resource_name]['count'])) {
            $_SESSION[$resource_name] = ['count' => 1, 'start_time' => time() ];
            $request_ok = 1;
            $response_code = 200;
        } else {
            $_SESSION[$resource_name]['count']++;
            $_SESSION[$resource_name]['time'] = time();
            if ($_SESSION[$resource_name]['count'] > $max_requests && (time() - $_SESSION[$resource_name]['start_time']) < $time_limit) {
                $response_code = 429;
            } else {
                if ( (time() - $_SESSION[$resource_name]['start_time']) >= $time_limit ) {
                    $_SESSION[$resource_name] = ['count' => 1, 'start_time' => time()];
                }
                $request_ok = 1;
                $response_code = 200;
            }
        }
        #setcookie( $resource_name . '-count', $_SESSION[$resource_name]['count'], time()+1, '/', $_SERVER['SERVER_NAME'] );
        #print_r( $matches );
        #print_r( $_SESSION );
        session_write_close();
    }

    if ( $response_code >= 300 ) {
        header( sprintf("Status: %d",$response_code), true, $response_code );
        exit();
    }
?>
