<?php
    echo "                <p>\n";
    echo "                    Den anden søjle i tabellen indeholder et link til en evaluering af GTFS-data for liniens individuelle varianter (GTFS-ture).\n";
    echo "                </p>\n";
    echo "                <p>\n";
    echo "                    Den tredje kolonne i tabellen indeholder en grov beregning af antallet af rejser i gyldighedsperioden.\n";
    echo "                </p>\n";

    if ( $comment ) {
        echo "                <p>\n";
        echo "                    Denne linje er blevet kommenteret:\n";
        echo "                </p>\n";
        echo "                <ul>\n";
        echo "                    <li><strong>"  . preg_replace("/\n/","</strong></li>\n                    <li><strong>", HandlePtnaComment($comment)) . "</strong></li>\n";
        echo "                </ul>\n";
    }
?>
