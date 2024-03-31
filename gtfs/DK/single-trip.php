<!DOCTYPE html>
<?php   include( '../../script/globals.php'     );
        include( '../../script/parse_query.php' );
        include( '../../script/gtfs.php'        );
?>
<html lang="<?php echo $html_lang ?>">

<?php $title="GTFS Analysis"; $lang_dir="../../$ptna_lang/"; include $lang_dir.'html-head.inc'; ?>

    <body>
      <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
      <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
      <script src="/script/gpx.js"></script>
      <script src="/script/showonmap.js"></script>
      <script src="/script/josm.js"></script>
      <script src="/script/routing.js"></script>


      <div id="wrapper">

<?php include $lang_dir.'header.inc' ?>

<?php
    if ( !$trip_id && $shape_id ) {
        echo '<script>window.location.replace("shape.php?feed=' . urlencode($feed) . '&release_date=' . urlencode($release_date) . '&shape_id=' . urlencode($shape_id) . '");</script>';
    }
    $route_id         = GetGtfsRouteIdFromTripId( $feed, $release_date, $trip_id );
    $route_short_name = GetGtfsRouteShortNameFromTripId( $feed, $release_date, $trip_id );
    if ( !$route_short_name ) {
        $route_short_name = 'not set';
    }
    $trips            = GetTripDetails( $feed, $release_date, $trip_id );
    $has_comments     = isset($trips["has_comments"]) ? $trips["has_comments"] : '';
    $shape_id         = isset($trips["shape_id"])     ? $trips["shape_id"]     : '';
    if ( $release_date ) {
        $feed_and_release = $feed . ' - ' . $release_date;
    } else {
        $feed_and_release = $feed;
    }
?>

        <main id="main" class="results">

            <div id="gtfsmap"></div>
            <div class="gtfs-intro">

                <h2 id="DK"><a href="index.php"><img src="/img/Denmark32.png"  class="flagimg" alt="Flag til Danmark" /></a> GTFS-analyser for <?php if ( $feed && $route_id && $route_short_name && $trip_id ) { echo '<a href="routes.php?feed=' . urlencode($feed) . '&release_date=' . urlencode($release_date) . '"><span id="feed">' . htmlspecialchars($feed_and_release) . '</span></a> <a href="trips.php?feed=' . urlencode($feed) . '&release_date=' . urlencode($release_date) . '&route_id=' . urlencode($route_id) . '">Linie "<span id="route_short_name">' . htmlspecialchars($route_short_name) . '</span></a>", Trip-Id = "<span id="trip_id">' . htmlspecialchars($trip_id) . '</span>"'; } else { echo '<span id="feed">Danmark</span>'; } ?></h2>
                <div class="indent">
                <ul>
                    <li><a href="#showonmap">Kort</a></li>
                    <li><a href="#proposal">Forslag til OSM-tagging</a></li>
                    <li><a href="#stoplist">Stops</a></li>
                    <li><a href="#service-times">Trafik tider</a></li>
                    <?php
                        if ( $shape_id ) { echo '                <li><a href="#shapes">GTFS Shape Data</a></li>'; }
                    ?>
                </ul>
                </div>

                <hr />

                <h2 id="showonmap">Kort</h2>
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

                        if ( $has_comments ) {
                            echo "                <p>\n";
                            echo "                    Denne variant er blevet kommenteret:\n";
                            echo "                </p>\n";
                            echo "                <ul>\n";
                            echo "                    <li><strong>"  . preg_replace("/<br \/>/","</strong></li>\n                    <li><strong>", HandlePtnaComment($trips)) . "</strong></li>\n";
                            echo "                </ul>\n";
                        }
                    ?>
                </div>
            </div>

            <div class="clearing">
                <button class="button-create" type="button" onclick="gpxdownload()">GPX-Download</button>
                <button class="button-create" type="button" onclick="callBrouterDe('da','km')">Routing med 'brouter.de'</button>
                <button class="button-create" type="button" onclick="callGraphHopperCom('da','km')">Routing med 'graphhopper.com'</button>
                <button class="button-create" type="button" onclick="callOpenRouteServiceOrg('da','km')">Routing med 'maps.openrouteservice.org'</button>

                <hr />

                <h2 id="proposal">Forslag til OSM-tagging</h2>
                <div class="indent">
<?php $duration = CreateOsmTaggingSuggestion( $feed, $release_date, $trip_id ); ?>
                </div>

                <hr />

                <h2 id="stoplist">Stops</h2>
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
<?php $duration += CreateGtfsSingleTripEntry( $feed, $release_date, $trip_id ); ?>
                        </tbody>
                    </table>
                    <p><strong>(1) Eksempel på afgangstider</strong></p>
                </div>

                <hr />

                <h2 id="service-times">Trafik tider</h2>
                <div class="indent">
                    <table id="gtfs-service-ids">
                        <thead>
                            <tr class="gtfs-tableheaderrow">
                                <th class="gtfs-name" colspan="2">Gyldighedsperiode</th>
                                <th class="gtfs-name" colspan="7">Hverdage</th>
                                <th class="gtfs-name" colspan="2">Undtagelser</th>
                                <th class="gtfs-name" rowspan="2">Afgangstider</th>
                                <th class="gtfs-name" rowspan="2">Varighed</th>
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
<?php $duration += CreateGtfsSingleTripServiceTimesEntry( $feed, $release_date, $trip_id ); ?>
                        </tbody>
                    </table>
                </div>

<?php $duration += CreateGtfsSingleTripShapeEntry( $feed, $release_date, $trip_id ); ?>

                <?php printf( "<p>SQL-forespørgsler tog %f sekunder</p>\n", $duration ); ?>

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
