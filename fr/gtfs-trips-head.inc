<?php
    echo "                <p>\n";
    echo "                    The second column of the table contains a link to an evaluation of the GTFS data for each variant (the GTFS trips) of the route.\n";
    echo "                </p>\n";
    echo "                <p>\n";
    echo "                    The third column of the table contains a rough calculation of the number of journeys in the validity period.\n";
    echo "                    Where applicable, the number of trips including sub-routes is given in parentheses. Only for data analyzed in July 2023 or later.\n";
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
