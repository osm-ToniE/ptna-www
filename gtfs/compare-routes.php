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
                            <span style="white-space: nowrap"><button class="button-save" title="Select subroutes" onclick="SelectRoutesTableRowsIfSubrouteOf()">Select subroutes <img src="/img/Subroute.svg" height="14" width="14" alt="Subroute"></button></span>
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
                        <h4>Colours</h4>
                        <div class="indent">
                            <table id="colours-table">
                                <thead id="colours-table-thead" class="compare-routes-left">
                                    <tr><th>Colour</th><th>Score range [%]</th><th>Description</th><th>Mouse-over shows</th><th>Click action</th></tr>
                                </thead>
                                <tbody id="colours-table-tbody" class="compare-routes-left">
                                    <tr><th class="compare-routes-tbody" style="background-color: #6aef00;">Bright Green</th>
                                        <td>0 <= score < 2</td>
                                        <td></td>
                                        <td>A list of individual scores</td>
                                        <td>A detailed analysis of the data</td>
                                    </tr>
                                    <tr><th class="compare-routes-tbody" style="background-color: #aecd00;">Sheen Green</th>
                                        <td>2 <= score < 10</td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr><th class="compare-routes-tbody" style="background-color: #d7a700;">Buddha Gold</th>
                                        <td>10 <= score < 20</td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr><th class="compare-routes-tbody" style="background-color: #f17a00;">Gold Drop</th>
                                        <td>20 <= score < 30</td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr><th class="compare-routes-tbody" style="background-color: #fe4000;">Vermilion</th>
                                        <td>30 <= score</td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                </tbody>
                                <tfoot id="colours-table-tfoot">
                                </tfoot>
                            </table>
                            <p>Note: colour names taken from <a target="_blank" href="https://hexcolor.co/" title="Colour names taken from">hexcolor.co</a> (e.g. 'https://hexcolor.co/hex/fe4000')</p>
                        </div>
                        <h4>Buttons</h4>
                        <div class="indent">
                            <table id="buttons-table">
                                <thead id="buttons-table-thead" class="compare-routes-left">
                                    <tr><th>Button</th><th>Description</th><th>Mouse-over shows</th><th>Click action</th><th>Button name</th></tr>
                                </thead>
                                <tbody id="buttons-table-tbody" class="compare-routes-left">
                                    <tr><th><button class="button-save">Select rows where all scores &gt;= x %</button><input style="height: 2.2em" id="hide-value" class="compare-routes-right" type="number" size="5" value="30" min="1" max="99"/></th>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr><th><button class="button-save"><input type="radio" name="invalid" checked></input>Add to selection</button></th>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr><th><button class="button-save"><input type="radio" name="invalid"></input>Replace selection</button></th>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr><th></th>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr><th></th>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr><th></th>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr><th></th>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr><th></th>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                </tbody>
                                <tfoot id="icons-table-tfoot">
                                </tfoot>
                            </table>
                        </div>
                        <h4>Icons</h4>
                        <div class="indent">
                            <table id="icons-table">
                                <thead id="icons-table-thead" class="compare-routes-left">
                                    <tr><th>Icon</th><th>Description</th><th>Mouse-over shows</th><th>Click action</th><th>Icon name</th></tr>
                                </thead>
                                <tbody id="icons-table-tbody" class="compare-routes-left">
                                    <tr><th class="compare-routes-tbody"><span alt="Alarm Clock" title="Alarm Clock">&#9200;<span></th>
                                        <td>This GTFS trip is no longer valid</td>
                                        <td>E.g. on 2026-02-10: "Trip is no longer valid, valid from 2025-12-15 to 2026-02-06"</td>
                                        <td>&nbsp;</td>
                                        <td>Alarm Clock</td>
                                    </tr>
                                    <tr><th class="compare-routes-tbody"><span alt="Hourglass With Flowing Sand" title="Hourglass With Flowing Sand">&#9203;<span></th>
                                        <td>This GTFS trip is not yet valid</td>
                                        <td>E.g. on 2026-02-10: "Trip is not yet valid, valid from 2026-02-23 to 2026-03-24"</td><td>&nbsp;</td>
                                        <td>Hourglass With Flowing Sand</td>
                                    </tr>
                                    <tr><th class="compare-routes-tbody"><img src="/img/2StopsOnly.svg" height="18" width="18" alt="'2' in 'Gold Drop' triangle" title="2 Stops Only" /></th>
                                        <td>This GTFS trip has only two stops</td>
                                        <td>"Trip with suspicious number of stops: ..."</td>
                                        <td></td><td>'2' in "Gold Drop" triangle</td>
                                    </tr>
                                    <tr><th class="compare-routes-tbody"><img src="/img/Suspicious.svg" height="18" width="18" alt="'!' in 'Gold Drop' triangle" title="Suspicious" /></th>
                                        <td>There is something suspicious with this GTFS trip</td>
                                        <td>"Trip with suspicious start: 1st and 2nd stop have same stop_name"<br>
                                            "Trip with suspicious start: 1st and 2nd stop have same stop_id"<br>
                                            "Trip with suspicious end: second last and last stop have same stop_name"<br>
                                            "Trip with suspicious end: second last and last stop have same stop_id"<br>
                                            "Trip with suspicious travel time: ..."<br>
                                            "Suspicious trip: ..."</td>
                                        <td></td><td>'!' in "Gold Drop" triangle</td>
                                    </tr>
                                    <tr><th class="compare-routes-tbody"><img src="/img/NearlySame.svg" height="18" width="18" alt="'N' in 'Gold Drop' circle" title="Nearly Same" /></th>
                                        <td>Two or more GTFS trips are nearly identical</td>
                                        <td>"Trips have identical stop-names but different stop-ids: ..."<br>
                                            "Trips have identical stops (names and ids) but different shape-ids: ..."</td>
                                        <td></td><td>'N' in "Gold Drop" circle</td>
                                    </tr>
                                    <tr><th class="compare-routes-tbody"><img src="/img/Subroute.svg" height="18" width="18" alt="'S' in 'Azure Radiance' circle" title="Subroute" /></th>
                                        <td>This GTFS trip is a subroute of one or more other GTFS trips</td>
                                        <td>"This trip is subroute of: ..."</td>
                                        <td></td><td>'S' in "Azure Radiance" circle</td>
                                    </tr>
                                    <tr><th class="compare-routes-tbody"><img src="/img/Information.svg" height="18" width="18" alt="'I' in yellow circle" title="Information" /></th>
                                        <td>Other information for this GTFS trip</td>
                                        <td></td><td></td><td>'I' in yellow circle</td>
                                    </tr>
                                    <tr><th class="compare-routes-tbody"><img src="/img/Magnifier32.png" height="18" width="18" alt="Magnifier" title="Show more ..." /></th>
                                        <td>Detailed information for the object is available</td>
                                        <td></td><td></td><td>Magnifier</td>
                                    </tr>
                                    <tr><th class="compare-routes-tbody"><img src="/img/Normalized32.png" height="18" width="18" alt="'i' in blue circle" title="Normalized" /></th>
                                        <td>Abbreviations in the GTFS stop_name have been 'normalized'</td>
                                        <td>The original GTFS stop_name value</td>
                                        <td></td><td>'i' in blue circle</td>
                                    </tr>
                                    <tr><th class="compare-routes-tbody"><img src="/img/Node.svg" height="18" width="18" alt="Node" title="Node" /></th>
                                        <td>The object is a node</td>
                                        <td></td><td></td><td>Node</td>
                                    </tr>
                                    <tr><th class="compare-routes-tbody"><img src="/img/Way.svg" height="18" width="18" alt="Way" title="Way" /></th>
                                        <td>The object is a way</td>
                                        <td></td><td></td><td>Way</td>
                                    </tr>
                                    <tr><th class="compare-routes-tbody"><img src="/img/Relation.svg" height="18" width="18" alt="Relation" title="Relation" /></th>
                                        <td>The object is a relation</td>
                                        <td></td><td></td><td>Relation</td>
                                    </tr>
                                    <tr><th class="compare-routes-tbody"><img src="/img/iD-logo32.png" height="18" width="18" alt="iD" title="iD" /></th>
                                        <td>The OSM object can be edited using the editor iD</td>
                                        <td></td><td></td><td>iD</td>
                                    </tr>
                                    <tr><th class="compare-routes-tbody"><img src="/img/JOSM-logo32.png" height="18" width="18" alt="JOSM" title="JOSM" /></th>
                                        <td>The OSM object can be edited using the editor JOSM</td>
                                        <td></td><td></td><td>JOSM</td>
                                    </tr>
                                    <tr><th class="compare-routes-tbody"><img src="/img/Relatify-favicon32.png" height="18" width="18" alt="Relatify" title="Relatify" /></th>
                                        <td>The OSM object can be edited using the editor Relatify</td>
                                        <td></td><td></td><td>Relatify</td>
                                    </tr>
                                    <tr><th class="compare-routes-tbody"><img src="/img/Inject32.png" height="18" width="18" alt="Injection needle" title="Inject data using JOSM" /></th>
                                        <td>Data can be added to the OSM object using the editor JOSM (inject data)</td>
                                        <td></td><td></td><td>Injection needle</td>
                                    </tr>
                                    <tr><th class="compare-routes-tbody"><img src="/img/RewindBack.svg" height="18" width="18" alt="Rewind Back" title="Rewind Back" /></th>
                                        <td></td>
                                        <td></td><td></td><td>Rewind back</td>
                                    </tr>
                                    <tr><th class="compare-routes-tbody"><img src="/img/Rewind.svg" height="18" width="18" alt="Rewind" title="Rewind" /></th>
                                        <td></td>
                                        <td></td><td></td><td>Rewind</td>
                                    </tr>
                                    <tr><th class="compare-routes-tbody"><img src="/img/Forward.svg" height="18" width="18" alt="Forward" title="Forward" /></th>
                                        <td></td>
                                        <td></td><td></td><td>Forward</td>
                                    </tr>
                                    <tr><th class="compare-routes-tbody"><img src="/img/WindForward.svg" height="18" width="18" alt="Forward to End" title="Forward to End" /></th>
                                        <td></td>
                                        <td></td><td></td><td>Forward to end</td>
                                    </tr>
                                    <tr><th class="compare-routes-tbody"><span alt="Arrow up and arrow down" title="Unsorted">&#x21C5;</span></th>
                                        <td>The table is not sorted using this column's values</td>
                                        <td></td>
                                        <td>The table will be sorted (ascending) using this column's values</td>
                                        <td>Unsorted</td>
                                    </tr>
                                    <tr><th class="compare-routes-tbody"><span alt="Two arrows up" title="Sorted ascending">&#x21C8;</span></th>
                                        <td>The table is sorted (ascending) using this column's values</td>
                                        <td></td>
                                        <td>The table will be sorted (descending) using this column's values</td>
                                        <td>Sort descending</td>
                                    </tr>
                                    <tr><th class="compare-routes-tbody"><span alt="two arrows down" title="Sorted descending">&#x21CA;</span></th>
                                        <td>The table is sorted (descending) using this column's values</td>
                                        <td></td>
                                        <td>The table will be sorted (ascending) using this column's values</td>
                                        <td>Sort ascending</td>
                                    </tr>
                                </tbody>
                                <tfoot id="icons-table-tfoot">
                                </tfoot>
                            </table>
                            <p>Note: colour names taken from <a target="_blank" href="https://hexcolor.co/" title="Colour names taken from">hexcolor.co</a> (e.g. 'https://hexcolor.co/hex/fe4000')</p>
                        </div>
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
