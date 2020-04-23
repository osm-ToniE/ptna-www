<?php
    if ( $shape_id ) {
        echo "                <p>\n";
        echo "                    Ruten kan genereres som GPX-data ved hjælp af knappen herunder.\n";
        echo "                    Såkaldte 'shape' data er tilgængelige.\n";
        echo "                    GPX-dataene svarer til den faktiske historie.\n";
        echo "                </p>\n";
    } else {
        echo "                <p>\n";
        echo "                    Ruten kan genereres som GPX-data ved hjælp af knappen herunder. \n";
        echo "                    Der er ingen tilgængelige formdata.\n";
        echo "                    GPX-dataene svarer til den lige linje mellem stop.\n";
        echo "                </p>\n";
    }

    echo "                <p>\n";
    echo "                    Bemærk: GTFS-dataene kan indeholde fejl, hvilket indikerer en unøjagtig kørehistorik.\n";
    echo "                </p>\n";

    if ( $comment ) {
        echo "                <p>\n";
        echo "                    Denne variant er blevet kommenteret:\n";
        echo "                </p>\n";
        echo "                <ul>\n";
        echo "                    <li><strong>"  . preg_replace("/\n/","</strong></li>\n                    <li><strong>", htmlspecialchars($comment)) . "</strong></li>\n";
        echo "                </ul>\n";
    }
?>
