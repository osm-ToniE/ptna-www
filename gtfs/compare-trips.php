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
            $title="Compare GTFS trip with GTFS trip";
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

<?php   if ( $prove_of_concept ): ?>
                <div id="comparemap"></div>
                <div class="compare-intro">

                    <h2 id="compare-trips-on-map">Compare GTFS trip with OSM route on Map</h2>

                    <div class="indent">
                        <span id="progress_section">Download: <progress id="download" value=0 max=2000></progress> <span id="download_text">0</span> ms /
                                                    Analysis: <progress id="analysis" value=0 max=2000></progress> <span id="analysis_text">0</span> ms
                        </span>
                        <p>
                            <span style="background-color: orange; font-weight: 1000; font-size:2.0em;">This is proof-of-concept (fake) data based on a specific bus: DE-BY-MVV Bus 210. Just to discuss the layout of this page, ...</span>
                        </p>
                    </div>
                </div>

                <hr class="clearing"/>

                <h2 id="compare-trips-side-by-side">Compare GTFS trip with OSM route side-by-side (stops/platforms)</h2>
                <div class="indent">
                    <?php CreateCompareTripsTableStopsPlatforms( $feed, $feed2, $release_date, $release_date2, $trip_id, $trip_id2, $osm_relation ); ?>
                </div>
                <script>
                    showcomparison();
                </script>
<?php   else: ?>
                <h2 id="compare-trips-map">Compare GTFS trip with GTFS trip</h2>
<?php   endif ?>

            </main> <!-- main -->

            <hr />

<?php include $lang_dir.'gtfs-footer.inc' ?>

        </div> <!-- wrapper -->
    </body>
</html>
