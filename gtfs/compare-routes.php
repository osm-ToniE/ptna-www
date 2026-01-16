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
        <script src="/script/diff.js"></script>
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

                    <h3 id="compare-info">General information</h3>
                    <div class="indent">
                        <table class="compare">
                            <thead class="compare">
                                <tr class="compare compare-routes-left"><th>&nbsp;</th><th>type</th><th>links</th><th>id</th><th>ref</th><th>feed</th><th>release date</th><th>members</th></tr>
                            </thead>
                            <tbody class="compare">
                                <tr id="compare-routes-row-info" class="compare"><td><span style="display: inline-block; font-weight: 700">Rows:</td></tr>
                                <tr id="compare-routes-col-info" class="compare"><td><span style="display: inline-block; font-weight: 700">Columns:</td></tr>
                            </tbody>
                        </table>
                    </div>

                    <h3 id="compare-table">Mismatch Score Table</h3>
                    <div class="indent">
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
                    </div>


                    <h3 id="compare-howto">How to read and use the table</h3>
                    <div class="indent">
                        <p>Colours are calculated as follows:</p>
                        <ul>
                        <li><span style="background-color: #6aef00;">0 <= score < 2</span></li>
                        <li><span style="background-color: #aecd00;">2 <= score < 12</span></li>
                        <li><span style="background-color: #d7a700;">12 <= score < 24</span></li>
                        <li><span style="background-color: #f17a00;">24 <= score < 48</span></li>
                        <li><span style="background-color: #fe4000;">48 <= score</span></li>
                        </ul>
                        <p>Move the mouse over a cell and it will pop-up a list of individual scores.<br/>
                        Click on a cell and you'll see a detailed analysis of the data.</p>
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
