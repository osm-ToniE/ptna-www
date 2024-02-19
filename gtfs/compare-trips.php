<!DOCTYPE html>
<?php   include( '../script/globals.php'      );
        include( '../script/parse_query.php'  );
        $lang_dir="../$ptna_lang/";
?>
<html lang="<?php echo $html_lang ?>">

<?php   include '../en/gtfs-compare-strings.inc';
        if ( file_exists($lang_dir.'gtfs-compare-strings.inc') ) {
            include $lang_dir.'gtfs-compare-strings.inc';
        }
        include( '../script/gtfs.php'         );
        include( '../script/gtfs-compare.php' );
        if ( $osm_relation ) {
            $title="Compare GTFS trip with OSM route";
        } else {
            $title="Compare two GTFS trips";
        }
        include $lang_dir.'html-head.inc';
?>

    <body>
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
        <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

        <script src="/script/gtfs-compare.js"></script>

        <div id="wrapper">

<?php   include $lang_dir.'header.inc'; ?>

            <main id="main" class="results">

                <div id="comparemap"></div>
                <div class="compare-intro">

                    <?php
                        if ( $osm_relation ) {
                            echo '<h2 id="compare-on-map">Compare GTFS trip with OSM route on Map</h2>' . "\n";
                        } else {
                            echo '<h2 id="compare-on-map">Compare two GTFS trips on Map</h2>' . "\n";

                        }
                    ?>

                    <div class="indent">
                        <span id="progress_section"><span style="display: inline-block; width: 11em">Download GTFS (left): </span><progress id="download_left" value=0 max=2000></progress> <span id="download_left_text" style="display: inline-block; width: 2em; text-align: right">0</span> ms<br/>
                                                    <?php
                                                        if ( $osm_relation ) {
                                                            echo '<span style="display: inline-block; width: 11em">Download OSM (right): </span><progress id="download_right" value=0 max=2000></progress> <span id="download_right_text"  style="display: inline-block; width: 2em; text-align: right">0</span> ms<br/>' . "\n";
                                                        } else {
                                                            echo '<span style="display: inline-block; width: 11em">Download GTFS (right): </span><progress id="download_right" value=0 max=2000></progress> <span id="download_right_text" style="display: inline-block; width: 2em; text-align: right">0</span> ms<br/>' . "\n";
                                                        }
                                                    ?>
                                                    <span style="display: inline-block; width: 11em">Analysis: </span><progress id="analysis" value=0 max=2000></progress> <span id="analysis_text" style="display: inline-block; width: 2em; text-align: right">0</span> ms
                        </span>
                        <ul style="list-style-type: none; padding-left: 0px">
                            <li><img src="/img/marker-left.png"  alt="left marker"  height="24" width="24" style="padding-right: 10px"><span style="display: inline-block; width: 3em">Left:</span>
                                <?php
                                    if ( $feed && $trip_id && preg_match("/^[0-9A-Za-z_.-]+$/", $feed) ) {
                                        $feed_parts = explode( '-', $feed );
                                        $countrydir = array_shift( $feed_parts );
                                        if ( $release_date ) {
                                            echo '<span style="display: inline-block; width: 5em">GTFS trip</span> <a href="/gtfs/' . $countrydir . '/single-trip.php?feed=' . urlencode($feed) . '&release_date=' . urlencode($release_date) . '&trip_id=' . urlencode($trip_id) . '" title="Link to GTFS" target="_blank">' .  htmlspecialchars($trip_id) . '</a> of ' . htmlspecialchars($feed) . ' as of ' . htmlspecialchars($release_date);
                                        } else {
                                            echo '<span style="display: inline-block; width: 5em">GTFS trip</span> <a href="/gtfs/' . $countrydir . '/single-trip.php?feed=' . urlencode($feed) . '&release_date=' . urlencode($release_date) . '&trip_id=' . urlencode($trip_id) . '" title="Link to GTFS" target="_blank">' .  htmlspecialchars($trip_id) . '</a> of ' . htmlspecialchars($feed);
                                        }
                                    }
                                    else {
                                        echo 'No valid GTFS data specified for first source';
                                    }
                                ?>
                            </li>
                            <li><img src="/img/marker-right.png" alt="right marker" height="24" width="24" style="padding-right: 10px"><span style="display: inline-block; width: 3em">Right:</span>
                                <?php
                                    if ( $osm_relation ) {
                                        echo '<span style="display: inline-block; width: 5em">OSM route</span> <a href="/relation.php?id=' . urlencode($osm_relation) . '" title="Link to PTNA" target="_blank">' . htmlspecialchars($osm_relation) . '</a>';
                                    }
                                    else if ( $feed2 && $trip_id2 && preg_match("/^[0-9A-Za-z_.-]+$/", $feed2) ) {
                                        $feed_parts = explode( '-', $feed2 );
                                        $countrydir = array_shift( $feed_parts );
                                        if ( $release_date2 ) {
                                            echo '<span style="display: inline-block; width: 5em">GTFS trip</span> <a href="/gtfs/' . $countrydir . '/single-trip.php?feed=' . urlencode($feed2) . '&release_date=' . urlencode($release_date2) . '&trip_id=' . urlencode($trip_id2) . '" title="Link to GTFS" target="_blank">' .  htmlspecialchars($trip_id2) . '</a> of ' . htmlspecialchars($feed2) . ' as of ' . htmlspecialchars($release_date2);
                                        } else {
                                            echo '<span style="display: inline-block; width: 5em">GTFS trip</span> <a href="/gtfs/' . $countrydir . '/single-trip.php?feed=' . urlencode($feed2) . '&release_date=' . urlencode($release_date2) . '&trip_id=' . urlencode($trip_id2) . '" title="Link to GTFS" target="_blank">' .  htmlspecialchars($trip_id2) . '</a> of ' . htmlspecialchars($feed2);
                                        }
                                    }
                                    else {
                                        echo 'No valid OSM or GTFS data specified for second source';
                                    }
                                ?>
                            </li>
                        </ul>
                    </div>

                    <hr/>

                    <h2 id="scores">Scores (low score)</h2>
                    <div class="indent">
                        <p>The values indicate how well the two routes match, smaller is better.</p>
                        <div>
                            <!-- table will be filled on the fly using JavaScript -->
                            <table id="scores-table" class="scores-table scores">
                                <thead id="scores-table-thead" class="scores-table-thead">
                                    <tr>
                                        <th colspan="2">Score</th>
                                        <th>Weight</th>
                                        <th rowspan="2">Description</th>
                                    </tr>
                                    <tr>
                                        <th>Total</th>
                                        <th>Indiv.</th>
                                        <th>[1]</th>
                                    </tr>
                                </thead>
                                <tbody id="scores-table-tbody" class="scores-table-tbody">
                                    <tr>
                                        <td id="score-total" rowspan="9" class="scores-no-padding"></td>
                                        <td id="score-stops"        class="scores-center"></td>
                                        <td id="score-stops-weight" class="scores-center"></td>
                                        <td id="score-stops-text">mismatch of number of stops</td>
                                    </tr>
                                    <tr>
                                        <td id="score-distance0"        class="scores-center"></td>
                                        <td id="score-distance0-weight" class="scores-center"></td>
                                        <td id="score-distance0-text">mismatch of positions of stops by more than xx m</td>
                                    </tr>
                                    <tr>
                                        <td id="score-distance1"        class="scores-center"></td>
                                        <td id="score-distance1-weight" class="scores-center"></td>
                                        <td id="score-distance1-text">mismatch of positions of stops by more than xx m</td>
                                    </tr>
                                    <tr>
                                        <td id="score-distance2"        class="scores-center"></td>
                                        <td id="score-distance2-weight" class="scores-center"></td>
                                        <td id="score-distance2-text">mismatch of positions of stops by more than xx m</td>
                                    </tr>
                                    <tr>
                                        <td id="score-name"        class="scores-center"></td>
                                        <td id="score-name-weight" class="scores-center"></td>
                                        <td id="score-name-text">mismatch of names of stops</td>
                                    </tr>
                                    <tr>
                                        <td id="score-ref-name" class="scores-center"></td>
                                        <td id="score-ref-name-weight" class="scores-center"></td>
                                        <td id="score-ref-name-text">mismatch of 'stop_name' of GTFS with 'ref_name' of OSM</td>
                                    </tr>
                                    <tr>
                                        <td id="score-stop-id" class="scores-center"></td>
                                        <td id="score-stop-id-weight" class="scores-center"></td>
                                        <td id="score-stop-id-text">mismatch of 'stop_id' of GTFS stops</td>
                                    </tr>
                                    <tr>
                                        <td id="score-gtfs-stop-id" class="scores-center"></td>
                                        <td id="score-gtfs-stop-id-weight" class="scores-center"></td>
                                        <td id="score-gtfs-stop-id-text">mismatch of 'stop_id' of GTFS with 'gtfs:stop_id' of OSM</td>
                                    </tr>
                                    <tr>
                                        <td id="score-ref-ifopt" class="scores-center"></td>
                                        <td id="score-ref-ifopt-weight" class="scores-center"></td>
                                        <td id="score-ref-ifopt-text">mismatch of 'stop_id' of GTFS with 'ref:IFOPT' of OSM</td>
                                    </tr>
                                 </tbody>
                                <tfoot id="scores-table-tfoot" class="scores-table-tfoot">
                                </tfoot>
                            </table>
                            <span>"n/a" : these combinations have not been detected</span>
                        </div>
                    </div>
                </div>

                <hr class="clearing"/>

                <?php
                    if ( $osm_relation ) {
                        echo '<h2 id="compare-side-by-side">Compare GTFS trip with OSM route side-by-side (stops/platforms)</h2>' . "\n";
                    } else {
                        echo '<h2 id="compare-side-by-side">Compare two GTFS trips side-by-side</h2>' . "\n";
                    }
                ?>
                <div class="indent">
                    <div id="trips-table-div" class="tableFixHeadCompare" style="height: 2em; max-height: 43em">
                        <!-- table will be filled on the fly using JavaScript ; arrows &#x2BC7; &#x2BC8;-->
                        <table id="trips-table" class="compare">
                            <thead id="trips-table-thead" class="compare-trips-thead">
                            </thead>
                            <tbody id="trips-table-tbody" class="compare-trips-tbody">
                            </tbody>
                            <tfoot id="trips-table-tfoot" class="compare-trips-tfoot">
                            </tfoot>
                        </table>
                    </div>
                </div>
                <script>
                    showtripcomparison();
                </script>

            </main> <!-- main -->

            <hr />

<?php include $lang_dir.'gtfs-footer.inc' ?>

        </div> <!-- wrapper -->
    </body>
</html>
