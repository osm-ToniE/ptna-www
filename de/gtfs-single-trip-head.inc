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
           if ( $is_invalid ) { $invalid = '<img src="/img/CheckMark.svg" width=24 height=24 alt="checked" />'; } else { $invalid = ''; }
           if ( $is_wrong )   { $wrong   = '<img src="/img/CheckMark.svg" width=24 height=24 alt="checked" />'; } else { $wrong   = ''; }
echo "                <p>\n";
echo "                    Diese Variante wurde als ungültig und/oder fehlerhaft markiert:\n";
echo "                </p>\n";
echo "                <ul>\n";
echo "                    <li>Ungültig: "    . $invalid . "</li>\n";
echo "                    <li>Fehlerhaft: "  . $wrong   . "</li>\n";
echo "                    <li>Kommentar: '<strong>"  . htmlspecialchars($comment) . "</strong>'</li>\n";
echo "                </ul>\n";    
       }
?>
