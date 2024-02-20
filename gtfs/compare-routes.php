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
        #if ( $osm_relation ) {
            $title="Compare GTFS route with OSM route_master";
        #} else {
        #    $title="Compare GTFS route with GTFS route";
        #}
        include $lang_dir.'html-head.inc';
?>

    <body>

      <div id="wrapper">

<?php   include $lang_dir.'header.inc'; ?>

        <main id="main" class="results">

            <h2 id="compare-routes">Compare GTFS route with OSM route_master</h2>
            <div class="indent">
                <p>
                    <span style="background-color: orange; font-weight: 1000; font-size:2.0em;">This is proof-of-concept (manually compiled) data based on a specific bus: DE-BY-MVV Bus 210.<br/>Just to discuss the layout of this page, ...</span>
                </p>

                <?php CreateCompareRoutesTable( $feed, $feed2, $release_date, $release_date2, $route_id, $route_id2, $osm_relation, $ptna_lang ); ?>

                Small values indicate a good match between GTFS trip and OSM route.<br/>
                <p>For a more detailed comparison, click on a number.</p>
                <p>Colours are calculated as follows:</p>
                <ul>
                <li><span style="background-color: #6aef00;">0 <= score < 2</span></li>
                <li><span style="background-color: #aecd00;">2 <= score < 12</span></li>
                <li><span style="background-color: #d7a700;">12 <= score < 24</span></li>
                <li><span style="background-color: #f17a00;">24 <= score < 48</span></li>
                <li><span style="background-color: #fe4000;">48 <= score</span></li>
                </ul>
                <p>Move the mouse over a cell and it will pop-up a list of individual scores (yet to be done).</p>
                <ul>
                    <li>xS == number of stops differ by "x%"</li>
                    <li>(a,b,c)P == percentage of stops where positions differ by more than 20 / 100 / 1000 meters</li>
                    <li>xN == percentage of stops where the 'name' differs (GTFS-'stop_name' / OSM-'name')</li>
                    <li>xR == percentage of stops where the GTFS-'Stop_name' fiffers from OSM-'ref_name' (if tagged)</li>
                    <li>xI == percentage of stops where the GTFS-'stop_id' differ (GTFS/GTFS comparison)</li>
                    <li>xG == percentage of stops where the GTFS-'stop_id' differs from OSM-'gtfs:stop_id' (if tagged)</li>
                    <li>xF == percentage of stops where the GTFS-'stop_id' differs from OSM-'ref:IFOPT' (if tagged)</li>
                </ul>
            </div>

        </main> <!-- main -->

        <hr />

<?php include $lang_dir.'gtfs-footer.inc' ?>

      </div> <!-- wrapper -->
    </body>
</html>
