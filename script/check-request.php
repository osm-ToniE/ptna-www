<?php
    # check whether request is OK

    $request_ok = 0;
    $response_code = 404;

    if ( isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] ) {
        if ( $_SERVER['HTTP_REFERER'] == "https://ptna.openstreetmap.de"              &&
             preg_match('/single-trip.php.*release_date=20/',$_SERVER['REQUEST_URI'])    ) {
            $response_code = 429;
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
