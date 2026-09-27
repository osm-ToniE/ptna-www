<?php
    # check whether request is OK

    $request_ok = 0;
    $response_code = 404;

    if ( isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] ) {
        $request_ok = 1;
        $response_code = 200;
    }

    if ( $response_code >= 300 ) {
        header( sprintf("Status: %d",$response_code), true, $response_code );
        exit();
    }
?>
