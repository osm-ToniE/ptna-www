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
                            <thead id="trips-table-head" class="compare-trips-head">
                            </thead>
                            <tbody id="trips-table-tbody" class="compare-trips-body">
                            </tbody>
                            <tfoot id="trips-table-foot" class="compare-trips-foot">
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
