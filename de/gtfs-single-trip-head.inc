                <p>
                    Dieses ist derzeit noch eine Baustelle, geplant sind:
                </p>
                <ul>
                    <li>Ein Button, mit dem man eine GPX-Datei erzeugen kann. Diese Datei kann in JOSM als Route mit Waypoints (Luftlinie zwischen den Haltestellen) verwendet werden.</li>
                    <li>Ein Button, der den Fahrweg auf einer (embedded?) Karte (umap?) anzeigt.</li>
                    <li>Die Möglichkeit bietet, das Umfeld ('bbox') einer Haltestelle in "iD" oder "JOSM" zu bearbeiten.</li>
                    <li> ...</li>
                </ul>
    
<?php if ( $is_invalid || $is_wrong || $comment ) {
           if ( $is_invalid ) { $invalid = 'Ja'; } else { $invalid = 'Nein'; }
           if ( $is_wrong )   { $wrong   = 'Ja'; } else { $wrong   = 'Nein'; }
echo "                <p>\n";
echo "                    Diese Variante wurde als ungültig und/oder fehlerhaft markiert:\n";
echo "                </p>\n";
echo "                <ul>\n";
echo "                    <li>Ungültig: "    . htmlspecialchars($invalid) . "</li>\n";
echo "                    <li>Fehlerhaft: "  . htmlspecialchars($wrong)   . "</li>\n";
echo "                    <li>Kommentar: '"  . htmlspecialchars($comment) . "'</li>\n";
echo "                </ul>\n";    
       }
?>
