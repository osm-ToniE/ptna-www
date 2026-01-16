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
        <script src="https://cdn.jsdelivr.net/npm/leaflet-polylinedecorator@1.6.0/dist/leaflet.polylineDecorator.min.js"></script>
        <script src="/script/diff.js"></script>
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
                        <span id="progress-section"><span style="display: inline-block; width: 11em">Download GTFS (left): </span><span id="span-download-left"><progress id="download_left" value=0 max=2000></progress></span> <span id="download_left_text" style="display: inline-block; width: 2em; text-align: right">0</span> ms<br/>
                            <?php
                                if ( $osm_relation ) {
                                    echo '<span style="display: inline-block; width: 11em">Download OSM (right): </span><span id="span-download-right"><progress id="download_right" value=0 max=2000></progress></span> <span id="download_right_text"  style="display: inline-block; width: 2em; text-align: right">0</span> ms<br/>' . "\n";
                                } else {
                                    echo '<span style="display: inline-block; width: 11em">Download GTFS (right): </span><span id="span-download-right"><progress id="download_right" value=0 max=2000></progress></span> <span id="download_right_text" style="display: inline-block; width: 2em; text-align: right">0</span> ms<br/>' . "\n";
                                }
                            ?>
                            <span style="display: inline-block; width: 11em">Analysis: </span><span id="span-analysis"><progress id="analysis" value=0 max=2000></progress></span> <span id="analysis_text" style="display: inline-block; width: 2em; text-align: right">0</span> ms
                        </span>
                        <span id="compare-source-section">
                            <table class="compare">
                                <thead class="compare">
                                    <tr class="compare compare-routes-left"><th>&nbsp;</th><th>type</th><th>links</th><th>id</th><th>ref</th><th>feed</th><th>release date</th></tr>
                                </thead>
                                <tbody class="compare">
                                    <tr id="compare-trips-left-info"  class="compare"><td><img  src="/img/marker-left.png"  alt="left marker"  height="24" width="24" style="padding-right: 10px"><span style="display: inline-block; font-weight: 700">Left:</span></td></tr>
                                    <tr id="compare-trips-right-info" class="compare"><td><img src="/img/marker-right.png" alt="right marker" height="24" width="24" style="padding-right: 10px"><span style="display: inline-block; font-weight: 700">Right:</span></td></tr>
                                </tbody>
                            </table>
                        </span>
                    </div>

                    <h2 id="scores">Mismatch Scores (low score)</h2>
                    <div class="indent">
                        <p>The values indicate the mismatch between the two routes, smaller is better.</p>
                        <div>
                            <!-- table will be filled on the fly using JavaScript -->
                            <table id="scores-table" class="scores-table scores">
                                <thead id="scores-table-thead" class="scores-table-thead">
                                    <tr>
                                        <th colspan="2">Score</th>
                                        <th rowspan="2">Description</th>
                                        <th rowspan="2">Weight</th>
                                    </tr>
                                    <tr>
                                        <th>Total</th>
                                        <th>Indiv.</th>
                                    </tr>
                                </thead>
                                <tbody id="scores-table-tbody" class="scores-table-tbody">
                                    <tr>
                                        <td id="score-total" rowspan="12" class="scores-no-padding"></td>
                                        <td id="score-diff"        class="scores-center"></td>
                                        <td id="score-diff-text">xx diffference(s) in visited stops (in same stop area)</td>
                                        <td id="score-diff-weight" class="scores-center"></td>
                                    </tr>
                                    <tr>
                                        <td id="score-stops"        class="scores-center"></td>
                                        <td id="score-stops-text">mismatch of number of stops</td>
                                        <td id="score-stops-weight" class="scores-center"></td>
                                    </tr>
                                    <tr>
                                        <td id="score-distance0"        class="scores-center"></td>
                                        <td id="score-distance0-text"><span title="Override value with URL parameter 'd0'">mismatch of positions of stops by more than xx m</span></td>
                                        <td id="score-distance0-weight" class="scores-center"></td>
                                    </tr>
                                    <tr>
                                        <td id="score-distance1"        class="scores-center"></td>
                                        <td id="score-distance1-text"><span title="Override value with URL parameter 'd1'">mismatch of positions of stops by more than xx m</span></td>
                                        <td id="score-distance1-weight" class="scores-center"></td>
                                    </tr>
                                    <tr>
                                        <td id="score-distance2"        class="scores-center"></td>
                                        <td id="score-distance2-text"><span title="Override value with URL parameter 'd2'">mismatch of positions of stops by more than xx m</span></td>
                                        <td id="score-distance2-weight" class="scores-center"></td>
                                    </tr>
                                    <tr>
                                        <td id="score-name"        class="scores-center"></td>
                                        <td id="score-name-text">mismatch of names of stops</td>
                                        <td id="score-name-weight" class="scores-center"></td>
                                    </tr>
                                    <tr>
                                        <td id="score-ref-name" class="scores-center"></td>
                                        <td id="score-ref-name-text">mismatch of 'stop_name' of GTFS with 'ref_name' of OSM</td>
                                        <td id="score-ref-name-weight" class="scores-center"></td>
                                    </tr>
                                    <tr>
                                        <td id="score-stop-id" class="scores-center"></td>
                                        <td id="score-stop-id-text">mismatch of 'stop_id' of GTFS stops</td>
                                        <td id="score-stop-id-weight" class="scores-center"></td>
                                    </tr>
                                    <tr>
                                        <td id="score-gtfs-stop-id" class="scores-center"></td>
                                        <td id="score-gtfs-stop-id-text">mismatch of 'stop_id' of GTFS with 'gtfs:stop_id' of OSM</td>
                                        <td id="score-gtfs-stop-id-weight" class="scores-center"></td>
                                    </tr>
                                    <tr>
                                        <td id="score-gtfs-stop-id-feed" class="scores-center"></td>
                                        <td id="score-gtfs-stop-id-feed-text">mismatch of 'stop_id' of GTFS with 'gtfs:stop_id:[feed suffix]' of OSM</td>
                                        <td id="score-gtfs-stop-id-feed-weight" class="scores-center"></td>
                                    </tr>
                                    <tr>
                                        <td id="score-ref-ifopt" class="scores-center"></td>
                                        <td id="score-ref-ifopt-text">mismatch of 'stop_id' of GTFS with 'ref:IFOPT' of OSM</td>
                                        <td id="score-ref-ifopt-weight" class="scores-center"></td>
                                    </tr>
                                    <tr>
                                        <td id="score-platform-code" class="scores-center"></td>
                                        <td id="score-platform-code-text">mismatch of 'platform_code' of GTFS with 'local_ref' of OSM</td>
                                        <td id="score-platform-code-weight" class="scores-center"></td>
                                    </tr>
                                 </tbody>
                                <tfoot id="scores-table-tfoot" class="scores-table-tfoot">
                                </tfoot>
                            </table>
                            <p><span style="font-weight: 1000; font-size:1.2em;">Before fixing potential errors in OSM data: consider that GTFS data can be wrong as well!</span></p>
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

        <iframe style="display:none" id="hiddenIframe" name="hiddenIframe"></iframe>

    </body>
</html>
