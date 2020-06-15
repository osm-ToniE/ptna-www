<!DOCTYPE html>
<html lang="dk">

<?php $title="GTFS Analysen"; $inc_lang='../../dk/'; include $inc_lang.'html-head.inc'; ?>

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
    $shape_id         = ( $_GET['shape_id'] ) ? $_GET['shape_id'] : $_POST['shape_id'];
    if ( !$trip_id && $shape_id ) {
        $trip_id      = GetGtfsTripIdFromShapeId( $network, $shape_id );
    }
    $route_id         = GetGtfsRouteIdFromTripId( $network, $trip_id );
    $route_short_name = GetGtfsRouteShortNameFromTripId( $network, $trip_id );
    if ( !$route_short_name ) {
        $route_short_name = 'not set';
    }
    $trips            = GetTripDetails( $network, $trip_id );
    $is_invalid       = $trips["ptna_is_invalid"];
    $is_wrong         = $trips["ptna_is_wrong"];
    $comment          = $trips["ptna_comment"];
    $shape_id         = $trips["shape_id"];
?>

            <h2 id="DK"><img src="/img/Denmark32.png" alt="Flag til Danmark" /> GTFS-analyser for <?php if ( $network && $route_id && $route_short_name && $trip_id ) { echo '<a href="routes.php?network=' .urlencode($network) . '"><span id="network">' . htmlspecialchars($network) . '</span></a> <a href="trips.php?network=' . urlencode($network) . '&route_id=' . urlencode($route_id) . '">Linie "<span id="route_short_name">' . htmlspecialchars($route_short_name) . '</span></a>", Trip-Id = "<span id="trip_id">' . htmlspecialchars($trip_id) . '</span>"'; } else { echo '<span id="network">Danmark</span>'; } ?></h2>
            <div class="indent">

                <?php
                    if ( $shape_id ) {
                        echo "                <p>\n";
                        echo "                    Ruten kan genereres som GPX-data ved hjælp af knappen herunder.\n";
                        echo "                    Såkaldte 'shape' data er tilgængelige: shape_id = \"" . htmlspecialchars($shape_id) . "\".\n";
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
                    echo "                    Bemærk: GTFS-dataene kan indeholde fejl, hvilket indikerer en unøjagtig kørehistorik, være ufuldstændig.\n";
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

                <h3 id="showonmap">Kort</h3>
                <div class="indent">
                    <button class="button-create" type="button" onclick="gpxdownload()">GPX-Download</button>

                    <div id="gtfsmap"></div>
                </div>

                <h3 id="proposal">Forslag til OSM-tagging</h3>
                <div class="indent">
<?php $duration = CreateOsmTaggingSuggestion( $network, $trip_id ); ?>
                </div>

                <h3 id="stoplist">Stops</h3>
                <div class="indent">
                    <p>
                        Med <strong>iD</strong> og <strong>JOSM</strong> kan omgivelserne ved et stop indlæses i en editor.
                    </p>
                    <ul>
                        <li> <strong>iD</strong> - displayet er i et nyt vindue på zoomniveau 21.</li>
                        <li> <strong>JOSM</strong> - et område på 30 m * 30 m omkring stop vil blive downloadet.</li>
                    </ul>
                    <p>
                         I begge tilfælde er der ingen garanti for, at stoppet, der kan være til stede i OSM, er synligt (er det lidt uden for området, eller findes det ikke?).<br />
                         I begge tilfælde kan stopens position i henhold til koordinaterne her (i øjeblikket?) Ikke synliggøres.
                    </p>

                    <button class="button-create" type="button" onclick="josm_load_and_zoom_stops()">Download omkring alle stop i JOSM</button>

                    <table id="gtfs-single-trip">
                        <thead>
                            <tr class="gtfs-tableheaderrow">
                                <th class="gtfs-name" colspan="7">Stops</th>
                                <th class="gtfs-name" colspan="1">PTNA info om stop</th>
                            </tr>
                            <tr class="gtfs-tableheaderrow">
                                <th class="gtfs-name">Nummer</th>
                                <th class="gtfs-name">Navn</th>
                                <th class="gtfs-name">Download</th>
                                <th class="gtfs-date">Afgangstid (1)</th>
                                <th class="gtfs-number">Latitude</th>
                                <th class="gtfs-number">Longitude</th>
                                <th class="gtfs-text">Stop-ID</th>
                                <th class="gtfs-comment">Kommentar</th>
                            </tr>
                        </thead>
                        <tbody>
<?php $duration += CreateGtfsSingleTripEntry( $network, $trip_id ); ?>
                        </tbody>
                    </table>
                    <p><strong>(1) Alle afgangstider ved første stop:</strong> <?php $string = GetDepartureTimesGtfsSingleTrip( $network, $trip_id ); if ( $string ) { echo $string; } else { echo 'i øjeblikket ikke tilgængelig.'; } ?></p>
                </div>

                <h3 id="service-times">Trafik tider</h3>
                <div class="indent">
                    <table id="gtfs-service-ids">
                        <thead>
                            <tr class="gtfs-tableheaderrow">
                                <th class="gtfs-name" colspan="2">Gyldighedsperiode</th>
                                <th class="gtfs-name" colspan="7">Hverdage</th>
                                <th class="gtfs-name" colspan="2">Undtagelser</th>
                                <th class="gtfs-name" rowspan="2">Afgangstider</th>
                                <th class="gtfs-name" rowspan="2">Service-ID</th>
                            </tr>
                            <tr class="gtfs-tableheaderrow">
                                <th class="gtfs-name">Fra</th>
                                <th class="gtfs-name">Til</th>
                                <th class="gtfs-name">Ma</th>
                                <th class="gtfs-name">Ti</th>
                                <th class="gtfs-name">On</th>
                                <th class="gtfs-name">To</th>
                                <th class="gtfs-name">Fr</th>
                                <th class="gtfs-name">Lø</th>
                                <th class="gtfs-name">Sø</th>
                                <th class="gtfs-name">Også tændt</th>
                                <th class="gtfs-name">Ikke tændt</th>
                            </tr>
                        </thead>
                        <tbody>
<?php $duration = CreateGtfsSingleTripServiceTimesEntry( $network, $trip_id ); ?>
                        </tbody>
                    </table>
                </div>

<?php $duration += CreateGtfsSingleTripShapeEntry( $network, $trip_id ); ?>

<?php printf( "<p>SQL-forespørgsler tog %f sekunder</p>\n", $duration ); ?>

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
