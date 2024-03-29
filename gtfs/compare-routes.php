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
            $title="Compare GTFS route with OSM route_master";
        } else {
            $title="Compare GTFS route with GTFS route";
        }
        include $lang_dir.'html-head.inc';
?>

    <body>
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
        <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

        <script src="/script/gtfs-compare.js"></script>
        <script src="/script/sort-table.js"></script>

        <div id="wrapper">

<?php   include $lang_dir.'header.inc'; ?>

            <main id="main" class="results">

                <?php
                    if ( $osm_relation ) {
                        echo '<h2 id="compare-routes">Compare GTFS route with OSM route_master</h2>' . "\n";
                    } else {
                        echo '<h2 id="compare-routes">Compare two GTFS routes</h2>' . "\n";

                    }
                ?>
                <div class="indent">

                    <h3 id="compare-info">General information</h3>
                    <ul style="list-style-type: none; padding-left: 0px">
                        <li><span style="display: inline-block; width: 5em">Rows:</span>
                            <?php
                                if ( $feed && $route_id && preg_match("/^[0-9A-Za-z_.-]+$/", $feed) ) {
                                    $feed_parts = explode( '-', $feed );
                                    $countrydir = array_shift( $feed_parts );
                                    if ( $release_date ) {
                                        echo '<span style="display: inline-block; width: 9em">GTFS route</span> <a href="/gtfs/' . $countrydir . '/trips.php?feed=' . urlencode($feed) . '&release_date=' . urlencode($release_date) . '&route_id=' . urlencode($route_id) . '" title="Link to GTFS" target="_blank">' .  htmlspecialchars($route_id) . '</a> of ' . htmlspecialchars($feed) . ', Version: ' . htmlspecialchars($release_date);
                                    } else {
                                        echo '<span style="display: inline-block; width: 9em">GTFS route</span> <a href="/gtfs/' . $countrydir . '/trips.php?feed=' . urlencode($feed) . '&release_date=' . urlencode($release_date) . '&route_id=' . urlencode($route_id) . '" title="Link to GTFS" target="_blank">' .  htmlspecialchars($route_id) . '</a> of ' . htmlspecialchars($feed);
                                    }
                                }
                                else {
                                    echo 'No valid GTFS data specified for first source';
                                }
                            ?>
                        </li>
                        <li><span style="display: inline-block; width: 5em">Columns:</span>
                            <?php
                                if ( $osm_relation ) {
                                    echo '<span id="compare-routes-columns-name" style="display: inline-block; width: 9em">OSM route_master</span> <a href="https://osm.org/relation/' . urlencode($osm_relation) . '" title="Link to OSM" target="_blank">' . htmlspecialchars($osm_relation) . '</a>';
                                }
                                else if ( $feed2 && $route_id2 && preg_match("/^[0-9A-Za-z_.-]+$/", $feed2) ) {
                                    $feed_parts = explode( '-', $feed2 );
                                    $countrydir = array_shift( $feed_parts );
                                    if ( $release_date2 ) {
                                        echo '<span id="compare-routes-columns-name" style="display: inline-block; width: 9em">GTFS route</span> <a href="/gtfs/' . $countrydir . '/trips.php?feed=' . urlencode($feed2) . '&release_date=' . urlencode($release_date2) . '&route_id=' . urlencode($route_id2) . '" title="Link to GTFS" target="_blank">' .  htmlspecialchars($route_id2) . '</a> of ' . htmlspecialchars($feed2) . ', Version: ' . htmlspecialchars($release_date2);
                                    } else {
                                        echo '<span id="compare-routes-columns-name" style="display: inline-block; width: 9em">GTFS route</span> <a href="/gtfs/' . $countrydir . '/trips.php?feed=' . urlencode($feed2) . '&release_date=' . urlencode($release_date2) . '&route_id=' . urlencode($route_id2) . '" title="Link to GTFS" target="_blank">' .  htmlspecialchars($route_id2) . '</a> of ' . htmlspecialchars($feed2);
                                    }
                                }
                                else {
                                    echo 'No valid OSM or GTFS data specified for second source';
                                }
                            ?>
                        </li>
                    </ul>

                    <h3 id="compare-table">Score Table</h3>
                    <p>
                        Small values indicate a good match between GTFS trip and OSM route/GTFS trip.<br>
                        For a more detailed comparison, click on a number.
                    </p>
                    <div id="routes-table-buttons">
                        <span style="white-space: nowrap"><button class="button-save" title="Select rows with score values" onclick="SelectRoutesTableRowsByScoreValue()">Select rows where all scores &gt;= x %</button><input style="height: 2.2em" id="hide-value" class="compare-routes-right" type="number" size="5" value="30" min="1" max="99"/></span>
<!--                        <span style="white-space: nowrap"><button class="button-save" title="Select trips with only 2 stops" onclick="SelectRoutesTableRows2StopsOnly()">Select trips with only 2 stops <img src="/img/2StopsOnly.svg" height="14" width="14" alt="2StopsOnly"></button></span>
                        <span style="white-space: nowrap"><button class="button-save" title="Select nearly identical trips" onclick="SelectRoutesTableRowsIfSuspicious()">Select nearly identical trips <img src="/img/NearlySame.svg" height="14" width="14" alt="NearlySame"></button></span>
                        <span style="white-space: nowrap"><button class="button-save" title="Select suspicious trips" onclick="SelectRoutesTableRowsIfNearlySame()">Select suspicious trips <img src="/img/Suspicious.svg" height="14" width="14" alt="Suspicious"></button></span>
                        <span style="white-space: nowrap"><button class="button-save" title="Select sub-routes" onclick="SelectRoutesTableRowsIfSubrouteOf()">Select sub-routes <img src="/img/Subroute.svg" height="14" width="14" alt="Subroute"></button></span>
                            -->                        <span style="white-space: nowrap"><button class="button-save"><input type="radio" id="add" checked name="selection"></input>Add to selection</button></span>
                        <span style="white-space: nowrap"><button class="button-save"><input type="radio" id="replace" name="selection"></input>Replace selection</button></span>
                    </div>
                    <div class="tableFixBothCompare" id="routes-table-div" style="max-height: 830px; max-width: 1850px ">
                        <table id="routes-table" class="js-sort-table">
                            <thead id="routes-table-thead" class="compare-routes-thead">
                            </thead>
                            <tbody id="routes-table-tbody" class="compare-routes-tbody">
                            </tbody>
                            <tfoot id="routes-table-tfoot" class="compare-routes-tfoot">
                                <tr><td>Please wait while we're loading and analyzing the data ...</td></tr>
                                <tr><td><span id="progress_section">
                                            <span style="display: inline-block; width: 13em" class="compare-routes-left">Download Row Data: </span><span id="span-download-left"><progress id="download_left" value=0 max=10000></progress></span> <span id="download_left_text" style="display: inline-block; width: 4em; text-align: right">0</span> ms<br/>
                                            <span style="display: inline-block; width: 13em" class="compare-routes-left">Download Column Data: </span><span id="span-download-right"><progress id="download_right"  value=0 max=10000></progress></span> <span id="download_right_text"  style="display: inline-block; width: 4em; text-align: right">0</span> ms<br/>
                                            <span style="display: inline-block; width: 13em" class="compare-routes-left">Analysis: </span><span id="span-analysis"><progress id="analysis" value=0 max=10000></progress></span> <span id="analysis_text" style="display: inline-block; width: 4em; text-align: right">0</span> ms
                                        </span>
                                </td></tr>
                            </tfoot>
                        </table>
                    </div>
                    <h3 id="compare-howto">How to read and use the table</h3>
                    <p>Colours are calculated as follows:</p>
                    <ul>
                    <li><span style="background-color: #6aef00;">0 <= score < 2</span></li>
                    <li><span style="background-color: #aecd00;">2 <= score < 12</span></li>
                    <li><span style="background-color: #d7a700;">12 <= score < 24</span></li>
                    <li><span style="background-color: #f17a00;">24 <= score < 48</span></li>
                    <li><span style="background-color: #fe4000;">48 <= score</span></li>
                    </ul>
                    <p>Move the mouse over a cell and it will pop-up a list of individual scores.<br/>
                       Click on a cell and you'll see a detailed analyis of the data.</p>
                </div>
                <span id="hiddenmap"></span>
                <script>
                    showroutecomparison();
                </script>

            </main> <!-- main -->

            <hr />

<?php include $lang_dir.'gtfs-footer.inc' ?>

        </div> <!-- wrapper -->

        <iframe style="display:none" id="hiddenIframe" name="hiddenIframe"></iframe>

    </body>
</html>
