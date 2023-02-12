<?php
    echo "                <p>\n";
    echo "                    Die zweite Spalte der Tabelle enthält einen Link auf eine Auswertung der GTFS Daten für die einzelnen Varianten (die GTFS-Trips) der Linie.\n";
    echo "                </p>\n";
    echo "                <p>\n";
    echo "                    Die dritte Spalte der Tabelle enthält eine grobe Berechnung der Anzahl der Fahrten im Gültigkeitszeitraum.\n";
    echo "                </p>\n";

    if ( $comment ) {
        echo "                <p>\n";
        echo "                    Diese Route wurde mit einem Kommentar versehen:\n";
        echo "                </p>\n";
        echo "                <ul>\n";
        echo "                    <li><strong>"  . preg_replace("/\n/","</strong></li>\n                    <li><strong>", HandlePtnaComment($comment)) . "</strong></li>\n";
        echo "                </ul>\n";
    }
?>
