<!DOCTYPE html>
<?php   include( '../../script/globals.php'     );
        include( '../../script/gtfs.php'        );
        include( '../../script/parse_query.php' );
?>
<html lang="<?php echo $html_lang ?>">

<?php $title="GTFS Analysen"; $lang_dir="../../$ptna_lang/"; include $lang_dir.'html-head.inc'; ?>

    <body>
      <link rel="stylesheet" href="https://unpkg.com/leaflet@1.6.0/dist/leaflet.css" integrity="sha512-xwE/Az9zrjBIphAcBb3F6JVqxf46+CDLwfLMHloNu6KEQCAWi6HcDUbeOfBIptF7tcCzusKFjFw2yuvEpDL9wQ==" crossorigin=""/>
      <script src="https://unpkg.com/leaflet@1.6.0/dist/leaflet.js" integrity="sha512-gZwIG9x3wUXg2hdXF6+rVkLF/0Vi9U8D2Ntg4Ga5I5BZpVkVxlJWbSQtXPSiUTtC0TjtGOmxa1AJPuV0CPthew==" crossorigin=""></script>
      <script src="/script/gpx.js"></script>
      <script src="/script/showonmap.js"></script>
      <script src="/script/josm.js"></script>
      <script src="/script/routing.js"></script>


      <div id="wrapper">

<?php include $lang_dir.'header.inc' ?>

<?php
    if ( !$trip_id && $shape_id ) {
        $trip_id      = GetGtfsTripIdFromShapeId( $feed, $release_date, $shape_id );
    }
    $route_id         = GetGtfsRouteIdFromTripId( $feed, $release_date, $trip_id );
    $route_short_name = GetGtfsRouteShortNameFromTripId( $feed, $release_date, $trip_id );
    if ( !$route_short_name ) {
        $route_short_name = 'not set';
    }
    $trips            = GetTripDetails( $feed, $release_date, $trip_id );
    $is_invalid       = $trips["ptna_is_invalid"];
    $is_wrong         = $trips["ptna_is_wrong"];
    $comment          = $trips["ptna_comment"];
    $shape_id         = $trips["shape_id"];
    if ( $release_date ) {
        $feed_and_release = $feed . ' - ' . $release_date;
    } else {
        $feed_and_release = $feed;
    }
?>

        <main id="main" class="results">

            <div id="gtfsmap"></div>
            <div class="gtfs-intro">

                <h2 id="DE"><a href="index.php"><img src="/img/Germany32.png" alt="deutsche Flagge" /></a> GTFS Analysen für <?php if ( $feed && $route_id && $route_short_name && $trip_id ) { echo '<a href="routes.php?feed=' . urlencode($feed) . '&release_date=' . urlencode($release_date) . '"><span id="feed">' . htmlspecialchars($feed_and_release) . '</span></a> <a href="trips.php?feed=' . urlencode($feed) . '&release_date=' . urlencode($release_date) . '&route_id=' . urlencode($route_id) . '">Linie "<span id="route_short_name">' . htmlspecialchars($route_short_name) . '</span></a>", Trip-Id = "<span id="trip_id">' . htmlspecialchars($trip_id) . '</span>"'; } else { echo '<span id="feed">Deutschland</span>'; } ?></h2>
                <div class="indent">
                    <ul>
                        <li><a href="#showonmap">Karte</a></li>
                        <li><a href="#proposal">Vorschlag für OSM Tagging</a></li>
                        <li><a href="#stoplist">Haltestellen</a></li>
                        <li><a href="#service-times">Verkehrszeiten</a></li>
                        <?php
                            if ( $shape_id ) { echo '                <li><a href="#shapes">GTFS Shape Data</a></li>'; }
                        ?>
                    </ul>
                </div>

                <hr />

                <h2 id="showonmap">Karte</h2>
                <div class="indent">
                    <?php
                        if ( $shape_id ) {
                            echo "                <p>\n";
                            echo "                    Die Fahrtstrecke kann als GPX-Daten mit Hilfe des Buttons unten erzeugt werden.\n";
                            echo "                    Es sind so genannte 'shape'-Daten vorhanden: shape_id = \"" . htmlspecialchars($shape_id) . "\".\n";
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
                        echo "                    Bitte beachten: Die GTFS-Daten können Fehler enthalten, einen ungenauen Fahrverlauf anzeigen, unvollständig sein.\n";
                        echo "                </p>\n";

                        if ( $comment ) {
                            echo "                <p>\n";
                            echo "                    Diese Variante wurde mit Kommentar versehen:\n";
                            echo "                </p>\n";
                            echo "                <ul>\n";
                            echo "                    <li><strong>"  . preg_replace("/\n/","</strong></li>\n                    <li><strong>", HandlePtnaComment($comment)) . "</strong></li>\n";
                            echo "                </ul>\n";
                        }
                    ?>

                </div>
            </div>

            <div class="clearing">
                <button class="button-create" type="button" onclick="gpxdownload()">GPX-Download</button>
                <button class="button-create" type="button" onclick="callBrouterDe('de','km')">Routing mit 'brouter.de'</button>
                <button class="button-create" type="button" onclick="callGraphHopperCom('de','km')">Routing mit 'graphhopper.com'</button>
                <button class="button-create" type="button" onclick="callOpenRouteServiceOrg('de','km')">Routing mit 'maps.openrouteservice.org'</button>

                <hr />

                <h2 id="proposal">Vorschlag für OSM Tagging</h2>
                <div class="indent">
<?php $duration = CreateOsmTaggingSuggestion( $feed, $release_date, $trip_id ); ?>
                </div>

                <hr />

                <h2 id="stoplist">Haltestellen</h2>
                <div class="indent">
                    <p>
                        Mit <strong>iD</strong> und <strong>JOSM</strong> kann die Umgebung einer Haltestelle in einen Editor geladen werden.
                    </p>
                    <ul>
                        <li><strong>iD</strong> - die Anzeige erfolgt in einem neuen Fenster auf Zoom-Level 21.</li>
                        <li><strong>JOSM</strong> - es wird eine Fläche von 30 m * 30 m um die Haltestelle(n) herum heruntergeladen.</li>
                    </ul>
                    <p>
                        In beiden Fällen ist nicht garantiert, dass eine in OSM eventuell vorhandene Haltestelle sichtbar ist (liegt leicht außerhalb des Gebietes oder existiert nicht?).<br />
                        In beiden Fällen kann die Position der Haltestelle gemäß der hier vorliegenden Koordinaten (derzeit?) leider nicht sichtbar gemacht werden.
                    </p>

                    <button class="button-create" type="button" onclick="josm_load_and_zoom_stops()">Download um alle Stops herum in JOSM</button>

                    <table id="gtfs-single-trip">
                        <thead>
                            <tr class="gtfs-tableheaderrow">
                                <th class="gtfs-name" colspan="7">Haltestellen</th>
                                <th class="gtfs-name" colspan="1">PTNA Info zur Haltestelle</th>
                            </tr>
                            <tr class="gtfs-tableheaderrow">
                                <th class="gtfs-name">Nummer</th>
                                <th class="gtfs-name">Name</th>
                                <th class="gtfs-name">Download</th>
                                <th class="gtfs-date">Abfahrtszeit (1)</th>
                                <th class="gtfs-number">Latitude</th>
                                <th class="gtfs-number">Longitude</th>
                                <th class="gtfs-text">Stop-ID</th>
                                <th class="gtfs-comment">Kommentar</th>
                            </tr>
                        </thead>
                        <tbody>
<?php $duration += CreateGtfsSingleTripEntry( $feed, $release_date, $trip_id ); ?>
                        </tbody>
                    </table>
                    <p><strong>(1) Beispiel für Abfahrzeiten</strong></p>
                </div>

                <hr />

                <h2 id="service-times">Verkehrszeiten</h2>
                <div class="indent">
                    <table id="gtfs-service-ids">
                        <thead>
                            <tr class="gtfs-tableheaderrow">
                                <th class="gtfs-name" colspan="2">Gültigkeit</th>
                                <th class="gtfs-name" colspan="7">Wochentage</th>
                                <th class="gtfs-name" colspan="2">Ausnahmen</th>
                                <th class="gtfs-name" rowspan="2">Abfahrtzeiten</th>
                                <th class="gtfs-name" rowspan="2">Dauer</th>
                                <th class="gtfs-name" rowspan="2">Service-ID</th>
                            </tr>
                            <tr class="gtfs-tableheaderrow">
                                <th class="gtfs-name">Von</th>
                                <th class="gtfs-name">Bis</th>
                                <th class="gtfs-name">Mo</th>
                                <th class="gtfs-name">Di</th>
                                <th class="gtfs-name">Mi</th>
                                <th class="gtfs-name">Do</th>
                                <th class="gtfs-name">Fr</th>
                                <th class="gtfs-name">Sa</th>
                                <th class="gtfs-name">So</th>
                                <th class="gtfs-name">Auch am</th>
                                <th class="gtfs-name">Nicht am</th>
                            </tr>
                        </thead>
                        <tbody>
<?php $duration += CreateGtfsSingleTripServiceTimesEntry( $feed, $release_date, $trip_id ); ?>
                        </tbody>
                    </table>
                </div>

<?php $duration += CreateGtfsSingleTripShapeEntry( $feed, $release_date, $trip_id ); ?>

                <?php printf( "<p>SQL-Abfragen benötigten %f Sekunden</p>\n", $duration ); ?>

            </div>

            <script>
                showtriponmap();
            </script>


        </main> <!-- main -->

        <hr />

<?php include $lang_dir.'gtfs-footer.inc' ?>

      </div> <!-- wrapper -->

      <iframe style="display:none" id="hiddenIframe" name="hiddenIframe"></iframe>

    </body>
</html>
