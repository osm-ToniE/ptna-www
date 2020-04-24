<!DOCTYPE html>
<html lang="de">

<?php $title="GTFS Analysen"; $inc_lang='../../de/'; include $inc_lang.'html-head.inc'; ?>

<?php include('../../script/globals.php'); ?>
<?php include('../../script/gtfs.php'); ?>

    <body>
      <link rel="stylesheet" href="https://unpkg.com/leaflet@1.6.0/dist/leaflet.css" integrity="sha512-xwE/Az9zrjBIphAcBb3F6JVqxf46+CDLwfLMHloNu6KEQCAWi6HcDUbeOfBIptF7tcCzusKFjFw2yuvEpDL9wQ==" crossorigin=""/>
      <script src="https://unpkg.com/leaflet@1.6.0/dist/leaflet.js" integrity="sha512-gZwIG9x3wUXg2hdXF6+rVkLF/0Vi9U8D2Ntg4Ga5I5BZpVkVxlJWbSQtXPSiUTtC0TjtGOmxa1AJPuV0CPthew==" crossorigin=""></script>
      <script src="/script/gpx.js"></script>
      <script src="/script/showonmap.js"></script>
      <script src="/script/josm.js"></script>


      <div id="wrapper">

<?php include $inc_lang.'header.inc' ?>

        <main id="main" class="results">
<?php
    $network          = ( $_GET['network'] ) ? $_GET['network'] : $_POST['network'];
    $trip_id          = ( $_GET['trip_id'] ) ? $_GET['trip_id'] : $_POST['trip_id'];
    $route_id         = GetGtfsRouteIdFromTripId( $network, $trip_id );
    $route_short_name = GetGtfsRouteShortNameFromTripId( $network, $trip_id );
    $ptna             = GetTripDetails( $network, $trip_id );
    $is_invalid       = $ptna["ptna_is_invalid"];
    $is_wrong         = $ptna["ptna_is_wrong"];
    $comment          = $ptna["ptna_comment"];
    $shape_id         = $ptna["shape_id"];
?>

            <h2 id="DE"><img src="/img/Germany32.png" alt="deutsche Flagge" /> GTFS Analysen für <?php if ( $network && $route_id && $route_short_name && $trip_id ) { echo '<a href="routes.php?network=' .urlencode($network) . '"><span id="network">' . htmlspecialchars($network) . '</span></a> <a href="trips.php?network=' . urlencode($network) . '&route_id=' . urlencode($route_id) . '">Linie "<span id="route_short_name">' . htmlspecialchars($route_short_name) . '</span></a>", Trip-Id = "<span id="trip_id">' . htmlspecialchars($trip_id) . '</span>"'; } else { echo '<span id="network">Deutschland</span>'; } ?></h2>
            <div class="indent">

<?php include $inc_lang.'gtfs-single-trip-head.inc' ?>

                <h3 id="showonmap">Karte</h3>
                <div class="indent">
                    <button class="button-create" type="button" onclick="gpxdownload()">GPX-Download</button>

                    <div id="mapid"></div>
                </div>

                <h3 id="proposal">Vorschlag für OSM Tagging</h3>
                <div class="indent">
<?php $duration = CreateOsmTaggingSuggestion( $network, $trip_id ); ?>
                </div>

                <h3 id="stoplist">Haltestellen</h3>
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
<?php include $inc_lang.'gtfs-single-trip-trth.inc' ?>
                        </thead>
                        <tbody>
<?php $duration += CreateGtfsSingleTripEntry( $network, $trip_id ); ?>
                        </tbody>
                    </table>
                    <p><strong>(1) Alle Abfahrzeiten an der ersten Haltestelle:</strong> <?php $string = GetDepartureTimesGtfsSingleTrip( $network, $trip_id ); if ( $string ) { echo $string; } else { echo 'derzeit nicht verfügbar.'; } ?></p>
                </div>

<?php $duration += CreateGtfsSingleTripShapeEntry( $network, $trip_id ); ?>

<?php printf( "<p>SQL-Abfragen benötigten %f Sekunden</p>\n", $duration ); ?>

            </div>

            <script>
                showtriponmap();
            </script>


        </main> <!-- main -->

        <hr />

<?php include $inc_lang.'gtfs-footer.inc' ?>

      </div> <!-- wrapper -->
      
      <iframe style="display:none" id="hiddenIframe" name="hiddenIframe"></iframe>
      
    </body>
</html>

