<?php
    echo "                <p>\n";
    echo "                    The second column of the table contains a link to an evaluation of the GTFS data for each variant (the GTFS trips) of the route.\n";
    echo "                </p>\n";

    if ( $comment ) {
        echo "                <p>\n";
        echo "                    A comment has been added to this route:\n";
        echo "                </p>\n";
        echo "                <ul>\n";
        echo "                    <li><strong>"  . preg_replace("/\n/","</strong></li>\n                    <li><strong>", HandlePtnaComment($comment)) . "</strong></li>\n";
        echo "                </ul>\n";
    }
?>
