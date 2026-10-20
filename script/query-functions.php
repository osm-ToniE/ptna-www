<?php

    # get the HTTP request type

    function GetHttpRequestType() {
        return $_SERVER["REQUEST_METHOD"];
    }


    # read the body of an HTTP POST request

    function GetHttpPostRequestBody() {
        #
        # we rely on "post_max_size" of the PHP server (default: 8M)
        #
        if ( isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] == "POST" ) {
            return file_get_contents('php://input');
        }
        return '';
    }
?>
