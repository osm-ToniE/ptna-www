<?php
    if ( $shape_id ) {
        echo "                <p>\n";
        echo "                    Die Fahrtstrecke kann als GPX-Daten mit Hilfe des Buttons unten erzeugt werden.\n";
        echo "                    Es sind so genannte 'shape'-Daten vorhanden.\n";
        echo "                    Die GPX-Daten entsprechen dem tatsächlichen Verlauf.\n";
        echo "                </p>\n";
    } else {
        echo "                <p>\n";
        echo "                    Die Fahrtstrecke kann als GPX-Daten mit Hilfe des Buttons unten erzeugt werden.\n";
        echo "                    Es sind keine so genannte 'shape'-Daten vorhanden.\n";
        echo "                    Die GPX-Daten entsprechen der Luftlinie zwischen den Haltestellen.\n";
        echo "                </p>\n";
    }

    echo "                <p>\n";
    echo "                    Bitte beachten: Die GTFS-Daten können Fehler enthalten, einen ungenauen Fahrverlauf anzeigen.\n";
    echo "                </p>\n";

    if ( $comment ) {
        echo "                <p>\n";
        echo "                    Diese Variante wurde mit einem Kommentar versehen:\n";
        echo "                </p>\n";
        echo "                <ul>\n";
        echo "                    <li>Kommentar: '<strong>"  . htmlspecialchars($comment) . "</strong>'</li>\n";
        echo "                </ul>\n";
    }
?>
