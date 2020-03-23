            <p>
                Dieses ist derzeit noch eine Baustelle, geplant sind:
            </p>
            <ul>
                <li>Ein Button, mit dem man eine GPX-Datei erzeugen kann. Diese Datei kann in JOSM als Route mit Waypoints (Luftlinie zwischen den Haltestellen) verwendet werden.</li>
                <li>Ein Button, der den Fahrweg auf einer Karte (umap?) anzeigt.</li>
                <li>Die Möglichkeit bietet, das Umfeld ('bbox') einer Haltestelle in "iD" oder "JOSM" zu bearbeiten.</li>
                <li> ...</li>
            </ul>

            <?php if ( $is_invalid || $is_wrong || $comment ) {
                       echo "<p>";
                       echo "    Diese Variante wurde als ungültig und/oder fehlerhaft markiert:";
                       echo "    <ul>";
                       if ( $is_invalid ) { echo "        <li>Ungültig: Ja</li>";   } else { echo "        <li>Ungültig: Nein</li>";   }
                       if ( $is_wrong    ) { echo "        <li>Fehlerhaft: Ja</li>"; } else { echo "        <li>Fehlerhaft: Nein</li>"; }
                       echo "        <li>Kommentar: '" . htmlspecialchars($comment) . "'</li>";
                       echo "    </ul>";    
                       echo "</p>";
                   }
            ?>

            <p>
                Die erste Spalte der Tabelle enthält einen Link auf eine Auswertung der GTFS Daten für eine einzelne Variante der Linie.
            </p>
