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
 -->                        <span style="white-space: nowrap"><button class="button-save"><input type="radio" id="add" checked="" name="selection" title="Add to selection"></input>Add to selection</button></span>
                            <span style="white-space: nowrap"><button class="button-save"><input type="radio" id="replace" name="selection" title="Replace selection"></input>Replace selection</button></span>
                        </div>
                        <div class="tableFixBothCompare" id="routes-table-div" style="max-height: 830px; max-width: 1850px ">
                            <table id="routes-table" class="js-sort-table">
                                <thead id="routes-table-thead" class="compare-routes-thead">
                                </thead>
                                <tbody id="routes-table-tbody" class="compare-routes-tbody">
                                </tbody>
                                <tfoot id="routes-table-tfoot" class="compare-routes-tfoot">
                                    <tr><td colspan=3>Please wait while we're loading and analyzing the data ...</td></tr>
                                    <tr><td style="text-align: left;" class="compare-routes-left">Download Row Data:&nbsp;</td>   <td id="span-download-left"> <progress id="download_left"  value=0 max=2000></progress></td> <td id="download_left_text"  style="text-align: right"></td></tr>
                                    <tr><td style="text-align: left;" class="compare-routes-left">Download Column Data:&nbsp;</td><td id="span-download-right"><progress id="download_right" value=0 max=2000></progress></td> <td id="download_right_text" style="text-align: right"></td></tr>
                                    <tr><td style="text-align: left;" class="compare-routes-left">Analysis:&nbsp;</td>            <td id="span-analysis">      <progress id="analysis"       value=0 max=2000></progress></td> <td id="analysis_text"       style="text-align: right"></td></tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>


                    <h3 id="compare-howto">How to read and use the table</h3>
                    <div class="indent">
                        <h4>Colours</h4>
                        <div class="indent">
                            <table id="colours-table">
                                <thead id="colours-table-thead" class="compare-routes-thead">
                                    <tr><th>Colour</th><th>Score range [%]</th><th>Description</th><th>Mouse-over shows</th><th>Click action</th></tr>
                                </thead>
                                <tbody id="colours-table-tbody" class="compare-routes-left">
                                    <tr><th class="compare-routes-tbody" style="background-color: #6aef00;">Bright Green</th>
                                        <td><span style="display: inline-block; width: 1.3em; text-align: right">0</span> <= score < <span style="display: inline-block; width: 1.3em; text-align: right">2</span></td>
                                        <td></td>
                                        <td rowspan=5>a list of individual scores.</td>
                                        <td rowspan=5>If this page here compares a GTFS route with an OSM route_master, then a click will start a detailed analysis comparing a GTFS trip with an OSM route.<br />
                                                      If this page here compares two GTFS routes, then a click will start a detailed analysis comparing two GTFS trips.
                                        </td>
                                    </tr>
                                    <tr><th style="background-color: #aecd00;">Sheen Green</th>
                                        <td><span style="display: inline-block; width: 1.3em; text-align: right">2</span> <= score < <span style="display: inline-block; width: 1.3em; text-align: right">10</span></td>
                                        <td></td>
                                    </tr>
                                    <tr><th style="background-color: #d7a700;">Buddha Gold</th>
                                        <td><span style="display: inline-block; width: 1.3em; text-align: right">10</span> <= score < <span style="display: inline-block; width: 1.3em; text-align: right">20</span></td>
                                        <td></td>
                                    </tr>
                                    <tr><th style="background-color: #f17a00;">Gold Drop</th>
                                        <td><span style="display: inline-block; width: 1.3em; text-align: right">20</span> <= score < <span style="display: inline-block; width: 1.3em; text-align: right">30</span></td>
                                        <td></td>
                                    </tr>
                                    <tr><th style="background-color: #fe4000;">Vermilion</th>
                                        <td><span style="display: inline-block; width: 1.3em; text-align: right">30</span> <= score</td>
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
                                <thead id="buttons-table-thead"  class="compare-routes-thead">
                                    <tr><th>Button</th><th>Description</th><th>Mouse-over shows</th><th>Click action</th></tr>
                                </thead>
                                <tbody id="buttons-table-tbody" class="compare-routes-left">
                                    <tr><th><button class="button-save">Select rows where all scores &gt;= x %</button><input style="height: 2.2em" class="compare-routes-right" type="number" size="5" value="30" min="1" max="99"></th>
                                        <td></td>
                                        <td>"Select rows with score values"</td>
                                        <td></td>
                                    </tr>
                                    <tr><th><button class="button-save"><input type="radio" checked="" name="selection-doc">Add to selection</button></th>
                                        <td></td>
                                        <td>"Add to selection"</td>
                                        <td></td>
                                    </tr>
                                    <tr><th><button class="button-save"><input type="radio" name="selection-doc">Replace selection</button></th>
                                        <td></td>
                                        <td>"Replace selection"</td>
                                        <td></td>
                                    </tr>
                                    <tr><th><button class="button-save">Show all</button></th>
                                        <td></td>
                                        <td>"Show all rows"</td>
                                        <td></td>
                                    </tr>
                                    <tr><th><button class="button-save" >Hide selected</button></th>
                                        <td></td>
                                        <td>"Hide selected rows"</td>
                                        <td></td>
                                    </tr>
                                    <tr><th><button class="button-save">Clear selections</button></th>
                                        <td></td>
                                        <td>"Clear selections"</td>
                                        <td></td>
                                    </tr>
                                    <tr><th><button class="button-save" >Compare two selected trips</button></th>
                                        <td></td>
                                        <td>"Compare two selected trips"</td>
                                        <td></td>
                                    </tr>
                                </tbody>
                                <tfoot id="buttons-table-tfoot">
                                </tfoot>
                            </table>
                        </div>
                        <h4>Icons</h4>
                        <div class="indent">
                            <table id="icons-table">
                                <thead id="icons-table-thead" class="compare-routes-thead">
                                    <tr><th>Icon</th><th>Description</th><th>Mouse-over shows</th><th>Click action</th><th>Icon name</th></tr>
                                </thead>
                                <tbody id="icons-table-tbody" class="compare-routes-left">
                                    <tr><th><span alt="Alarm Clock" title="Alarm Clock">&#9200;<span></th>
                                        <td>This GTFS trip is no longer valid.</td>
                                        <td>E.g. on 2026-02-10: "Trip is no longer valid, valid from 2025-12-15 to 2026-02-06"</td>
                                        <td>&nbsp;</td>
                                        <td>Alarm Clock</td>
                                    </tr>
                                    <tr><th><span alt="Hourglass With Flowing Sand" title="Hourglass With Flowing Sand">&#9203;<span></th>
                                        <td>This GTFS trip is not yet valid.</td>
                                        <td>E.g. on 2026-02-10: "Trip is not yet valid, valid from 2026-02-23 to 2026-03-24"</td><td>&nbsp;</td>
                                        <td>Hourglass With Flowing Sand</td>
                                    </tr>
                                    <tr><th><img src="/img/2StopsOnly.svg" height="18" width="18" alt="'2' in 'Gold Drop' triangle" title="2 Stops Only" /></th>
                                        <td>This GTFS trip has only two stops.</td>
                                        <td>"Trip with suspicious number of stops: ..."</td>
                                        <td>&nbsp;</td>
                                        <td>'2' in "Gold Drop" triangle</td>
                                    </tr>
                                    <tr><th><img src="/img/Suspicious.svg" height="18" width="18" alt="'!' in 'Gold Drop' triangle" title="Suspicious" /></th>
                                        <td>There is something suspicious with this GTFS trip.</td>
                                        <td>"Trip with suspicious start: 1st and 2nd stop have same stop_name"<br>
                                            "Trip with suspicious start: 1st and 2nd stop have same stop_id"<br>
                                            "Trip with suspicious end: second last and last stop have same stop_name"<br>
                                            "Trip with suspicious end: second last and last stop have same stop_id"<br>
                                            "Trip with suspicious travel time: ..."<br>
                                            "Suspicious trip: ..."</td>
                                        <td>&nbsp;</td>
                                        <td>'!' in "Gold Drop" triangle</td>
                                    </tr>
                                    <tr><th><img src="/img/NearlySame.svg" height="18" width="18" alt="'N' in 'Gold Drop' circle" title="Nearly Same" /></th>
                                        <td>Two or more GTFS trips are nearly identical.</td>
                                        <td>"Trips have identical stop-names but different stop-ids: ..."<br>
                                            "Trips have identical stops (names and ids) but different shape-ids: ..."</td>
                                        <td>&nbsp;</td>
                                        <td>'N' in "Gold Drop" circle</td>
                                    </tr>
                                    <tr><th><img src="/img/Subroute.svg" height="18" width="18" alt="'S' in 'Azure Radiance' circle" title="Subroute" /></th>
                                        <td>This GTFS trip is a subroute of one or more other GTFS trips.</td>
                                        <td>"This trip is subroute of: ..."</td>
                                        <td>&nbsp;</td>
                                        <td>'S' in "Azure Radiance" circle</td>
                                    </tr>
                                    <tr><th><img src="/img/Information.svg" height="18" width="18" alt="'I' in yellow circle" title="Information" /></th>
                                        <td>Other information for this GTFS trip.</td>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td>'I' in yellow circle</td>
                                    </tr>
                                    <tr><th><img src="/img/Magnifier32.png" height="18" width="18" alt="Magnifier" title="Show more ..." /></th>
                                        <td>Detailed information for the object is available.</td>
                                        <td>"Show more information for id ..."</td>
                                        <td>&nbsp;</td>
                                        <td>Magnifier</td>
                                    </tr>
                                    <tr><th><img src="/img/Normalized32.png" height="18" width="18" alt="'i' in blue circle" title="Normalized" /></th>
                                        <td>Abbreviations in the GTFS stop_name have been 'normalized'.</td>
                                        <td>the original GTFS stop_name value.</td>
                                        <td>&nbsp;</td>
                                        <td>'i' in blue circle</td>
                                    </tr>
                                    <tr><th><img src="/img/Node.svg" height="18" width="18" alt="Node" title="Node" /></th>
                                        <td>The object is a node.</td>
                                        <td>OSM object: "Browse on map"</td>
                                        <td></td>
                                        <td>Node</td>
                                    </tr>
                                    <tr><th><img src="/img/Way.svg" height="18" width="18" alt="Way" title="Way" /></th>
                                        <td>The object is a way.</td>
                                        <td>OSM object: "Browse on map"</td>
                                        <td></td>
                                        <td>Way</td>
                                    </tr>
                                    <tr><th><img src="/img/Relation.svg" height="18" width="18" alt="Relation" title="Relation" /></th>
                                        <td>The object is a relation.</td>
                                        <td>GTFS object: "GTFS route" or "GTFS trip"<br />
                                            OSM object: "Browse on map"
                                        </td>
                                        <td></td>
                                        <td>Relation</td>
                                    </tr>
                                    <tr><th><img src="/img/iD-logo32.png" height="18" width="18" alt="iD" title="iD" /></th>
                                        <td>The OSM object can be edited using the editor iD.</td>
                                        <td>"Edit in iD"</td>
                                        <td></td>
                                        <td>iD</td>
                                    </tr>
                                    <tr><th><img src="/img/JOSM-logo32.png" height="18" width="18" alt="JOSM" title="JOSM" /></th>
                                        <td>The OSM object can be edited using the editor JOSM.</td>
                                        <td>"Edit in JOSM"</td>
                                        <td>Sends the "<a target="_blank" href="https://josm.openstreetmap.de/wiki/Help/RemoteControlCommands#load_object" title="JOSM's 'load_object' remote control command">load_object?objects=...</a>" command to JOSM via "<a target="_blank" href="https://josm.openstreetmap.de/wiki/Help/Preferences/RemoteControl" title="Link to JOSM's remote control feature">remote control</a>".</td>
                                        <td>JOSM</td>
                                    </tr>
                                    <tr><th><img src="/img/Relatify-favicon32.png" height="18" width="18" alt="Relatify" title="Relatify" /></th>
                                        <td>The OSM object can be edited using the editor Relatify.</td>
                                        <td>"Edit in Relatify"</td>
                                        <td></td>
                                        <td>Relatify</td>
                                    </tr>
                                    <tr><th><img src="/img/Inject32.png" height="18" width="18" alt="Injection needle" title="Inject data using JOSM" /></th>
                                        <td>OSM object data can be added, modified or deleted using the editor JOSM (inject data). An empty value for a key deletes the key.</td>
                                        <td>the data injected into the OSM object.</td>
                                        <td>Sends the "<a target="_blank" href="https://josm.openstreetmap.de/wiki/Help/RemoteControlCommands#load_object" title="JOSM's 'load_object' remote control command">load_object?objects=...&addtags=...</a>" command to JOSM via "<a target="_blank" href="https://josm.openstreetmap.de/wiki/Help/Preferences/RemoteControl" title="Link to OSM wiki documentaion about JOSM's remote control feature">remote control</a>". You will be asked for confirmation by JOSM.</td>
                                        <td>Injection needle</td>
                                    </tr>
                                    <tr><th><img src="/img/RewindBack.svg" height="18" width="18" alt="Rewind Back" title="Rewind Back" /></th>
                                        <td>Allows better handling of tables with a hight number of columns.</td>
                                        <td></td>
                                        <td>Shift columns of the table to the right, so that the left-most column can be seen.</td>
                                        <td>Rewind back</td>
                                    </tr>
                                    <tr><th><img src="/img/Rewind.svg" height="18" width="18" alt="Rewind" title="Rewind" /></th>
                                        <td>Allows better handling of tables with a hight number of columns.</td>
                                        <td></td>
                                        <td>Shift columns of the table to the right, so that the next hidden column on the left becomes visible.</td>
                                        <td>Rewind</td>
                                    </tr>
                                    <tr><th><img src="/img/Forward.svg" height="18" width="18" alt="Forward" title="Forward" /></th>
                                        <td>Allows better handling of tables with a hight number of columns.</td>
                                        <td></td>
                                        <td>Shift columns of the table to the left, so that the left-most column vanishes.</td>
                                        <td>Forward</td>
                                    </tr>
                                    <tr><th><img src="/img/WindForward.svg" height="18" width="18" alt="Forward to End" title="Forward to End" /></th>
                                        <td>Allows better handling of tables with a hight number of columns.</td>
                                        <td></td>
                                        <td>Shift columns of the table to the left, so that only the right-most column remains visible.</td>
                                        <td>Forward to end</td>
                                    </tr>
                                    <tr><th><span alt="Arrow up and arrow down" title="Unsorted">&#x21C5;</span></th>
                                        <td>The table is not sorted using this column's values.</td>
                                        <td></td>
                                        <td>The table will be sorted (ascending) using this column's values.</td>
                                        <td>Unsorted</td>
                                    </tr>
                                    <tr><th><span alt="Two arrows up" title="Sorted ascending">&#x21C8;</span></th>
                                        <td>The table is sorted (ascending) using this column's values.</td>
                                        <td></td>
                                        <td>The table will be sorted (descending) using this column's values.</td>
                                        <td>Sort descending</td>
                                    </tr>
                                    <tr><th><span alt="two arrows down" title="Sorted descending">&#x21CA;</span></th>
                                        <td>The table is sorted (descending) using this column's values.</td>
                                        <td></td>
                                        <td>The table will be sorted (ascending) using this column's values.</td>
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
