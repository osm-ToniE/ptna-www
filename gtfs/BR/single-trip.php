<!DOCTYPE html>
<?php   include( '../../script/globals.php'     );
        include( '../../script/gtfs.php'        );
        include( '../../script/parse_query.php' );
?>
<html lang="<?php echo $html_lang ?>">

<?php $title="GTFS Análise"; $lang_dir="../../$ptna_lang/"; include $lang_dir.'html-head.inc'; ?>

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
?>

        <main id="main" class="results">

            <div id="gtfsmap"></div>
            <div class="gtfs-intro">

                <h2 id="BR"><a href="index.php"><img src="/img/Brasil32.png" alt="bandeira do brasil" /></a> GTFS Análise sobre <?php if ( $feed && $route_id && $route_short_name && $trip_id ) { echo '<a href="routes.php?network=' .urlencode($network) . '"><span id="feed">' . htmlspecialchars($feed) . '</span></a> <a href="trips.php?network=' . urlencode($network) . '&route_id=' . urlencode($route_id) . '">Rota "<span id="route_short_name">' . htmlspecialchars($route_short_name) . '</span></a>", Trip-Id = "<span id="trip_id">' . htmlspecialchars($trip_id) . '</span>"'; } else { echo '<span id="feed">Brasil</span>'; } ?></h2>
                <div class="indent">
                    <ul>
                        <li><a href="#showonmap">Map</a></li>
                        <li><a href="#proposal">Suggestion for OSM Tagging</a></li>
                        <li><a href="#stoplist">Stops</a></li>
                        <li><a href="#service-times">Service Times</a></li>
                        <?php
                            if ( $shape_id ) { echo '                <li><a href="#shapes">GTFS Shape Data</a></li>'; }
                        ?>
                    </ul>
                </div>

                <hr />

                <h2 id="showonmap">Map</h2>
                <div class="indent">
                    <?php
                        if ( $shape_id ) {
                            echo "                <p>\n";
                            echo "                    The route can be generated as GPX data using the buttons below.\n";
                            echo "                    So-called 'shape' data are available: shape_id = \"" . htmlspecialchars($shape_id) . "\".\n";
                            echo "                    The GPX data corresponds to the actual course.\n";
                            echo "                </p>\n";
                        } else {
                            echo "                <p>\n";
                            echo "                    The route can be generated as GPX data using the buttons below.\n";
                            echo "                    There are no so-called 'shape' data.\n";
                            echo "                    The GPX data corresponds to the linear distance between the stops.\n";
                            echo "                </p>\n";
                        }

                        echo "                <p>\n";
                        echo "                    Please note: The GTFS data may contain errors, indicate an inaccurate route, be incomplete.\n";
                        echo "                </p>\n";

                        if ( $comment ) {
                            echo "                <p>\n";
                            echo "                    This variant was provided with comments:\n";
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
                <button class="button-create" type="button" onclick="callBrouterDe('en','km')">Routing with 'brouter.de'</button>
                <button class="button-create" type="button" onclick="callGraphHopperCom('en','km')">Routing with 'graphhopper.com'</button>
                <button class="button-create" type="button" onclick="callOpenRouteServiceOrg('en','km')">Routing with 'maps.openrouteservice.org'</button>

                <hr />

                <h2 id="proposal">Suggestion for OSM Tagging</h2>
                <div class="indent">
<?php $duration = CreateOsmTaggingSuggestion( $feed, $release_date, $trip_id ); ?>
                </div>

                <hr />

                <h2 id="stoplist">Stops</h2>
                <div class="indent">
                    <p>
                    With <strong>iD</strong> and <strong>JOSM</strong> the environment of a stop can be loaded into an editor.
                    </p>
                    <ul>
                        <li><strong>iD</strong> - the display appears in a new window at zoom level 21.</li>
                        <li><strong>JOSM</strong> - an area of 30 m * 30 m around the stop(s) is downloaded.</li>
                    </ul>
                    <p>
                        In both cases it is not guaranteed that a stop that may be present in OSM is visible (is slightly outside the area or does not exist?).<br />
                        In both cases the position of the stop according to the coordinates available here can unfortunately not be made visible.
                    </p>

                    <button class="button-create" type="button" onclick="josm_load_and_zoom_stops()">Download OSM data around all stops in JOSM</button>

                    <table id="gtfs-single-trip">
                        <thead>
                            <tr class="gtfs-tableheaderrow">
                                <th class="gtfs-name" colspan="7">Stops</th>
                                <th class="gtfs-name" colspan="1">PTNA info for stop</th>
                            </tr>
                            <tr class="gtfs-tableheaderrow">
                                <th class="gtfs-name">Number</th>
                                <th class="gtfs-name">Name</th>
                                <th class="gtfs-name">Download</th>
                                <th class="gtfs-date">Departure time (1)</th>
                                <th class="gtfs-number">Latitude</th>
                                <th class="gtfs-number">Longitude</th>
                                <th class="gtfs-text">Stop-ID</th>
                                <th class="gtfs-comment">Comment</th>
                            </tr>
                        </thead>
                        <tbody>
<?php $duration += CreateGtfsSingleTripEntry( $feed, $release_date, $trip_id ); ?>
                        </tbody>
                    </table>
                    <p><strong>(1) Example for departure time</strong></p>
                </div>

                <hr />

                <h2 id="service-times">Service Times</h2>
                <div class="indent">
                    <table id="gtfs-service-ids">
                        <thead>
                            <tr class="gtfs-tableheaderrow">
                                <th class="gtfs-name" colspan="2">Valid</th>
                                <th class="gtfs-name" colspan="7">Weekday</th>
                                <th class="gtfs-name" colspan="2">Exceptions</th>
                                <th class="gtfs-name" rowspan="2">Departure times</th>
                                <th class="gtfs-name" rowspan="2">Duration</th>
                                <th class="gtfs-name" rowspan="2">Service-ID</th>
                            </tr>
                            <tr class="gtfs-tableheaderrow">
                                <th class="gtfs-name">From</th>
                                <th class="gtfs-name">Until</th>
                                <th class="gtfs-name">Mo</th>
                                <th class="gtfs-name">Tu</th>
                                <th class="gtfs-name">We</th>
                                <th class="gtfs-name">Th</th>
                                <th class="gtfs-name">Fr</th>
                                <th class="gtfs-name">Sa</th>
                                <th class="gtfs-name">Su</th>
                                <th class="gtfs-name">Also on</th>
                                <th class="gtfs-name">Not on</th>
                            </tr>
                        </thead>
                        <tbody>
<?php $duration += CreateGtfsSingleTripServiceTimesEntry( $feed, $release_date, $trip_id ); ?>
                        </tbody>
                    </table>
                </div>

<?php $duration += CreateGtfsSingleTripShapeEntry( $feed, $release_date, $trip_id ); ?>

                <?php printf( "<p>As consultas SQL levaram %f segundos para serem concluídas</p>\n", $duration ); ?>

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
