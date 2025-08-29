<!DOCTYPE html>
<?php   include( '../../script/globals.php'     );
        include( '../../script/parse_query.php' );
        include( '../../script/gtfs.php'        );
?>
<html lang="<?php echo $html_lang ?>">

<?php $title="GTFS Analysis"; $lang_dir="../../$ptna_lang/"; include $lang_dir.'html-head.inc'; ?>

    <body>
      <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
      <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
      <script src="https://cdn.jsdelivr.net/npm/leaflet-polylinedecorator@1.6.0/dist/leaflet.polylineDecorator.min.js"></script>
      <script src="/script/gpx.js"></script>
      <script src="/script/showonmap.js"></script>

      <div id="wrapper">

<?php include $lang_dir.'header.inc' ?>

<?php
    if ( $release_date ) {
        $feed_and_release = $feed . ' - ' . $release_date;
    } else {
        $feed_and_release = $feed;
    }
?>
        <main id="main" class="results">

            <div id="gtfsmap"></div>
            <div class="gtfs-intro">

                <h2 id="RS"><a href="index.php"><img src="/img/Serbia32.png"  class="flagimg" alt="Flag of Serbia" /></a> GTFS Analysis for
                    <?php if ( $feed && $shape_id ) {
                              echo '<a href="routes.php?feed=' . urlencode($feed) . '&release_date=' . urlencode($release_date) . '"><span id="feed">' . htmlspecialchars($feed_and_release) . '</span></a>, Shape-Id = "<span id="shape_id">' . htmlspecialchars($shape_id) . '</span>' . "\n";
                          } else {
                              echo '<span id="feed">Serbia</span>' . "\n";
                          }
                    ?>
                </h2>
                <div class="indent">
                    <ul>
                        <li><a href="#showonmap">Map</a></li>
                        <li><a href="#trips">Trips following this route</a></li>
                        <li><a href="#shapes">GTFS Shape Data</a></li>
                    </ul>
                </div>

                <hr />

                <h2 id="showonmap">Map</h2>
                <div class="indent">
                    <p>
                        The route can be generated as GPX data using the button below.
                        The GPX data corresponds to the actual course.
                    </p>
                    <p>
                        Please note: The GTFS data may contain errors, indicate an inaccurate route, be incomplete.
                    </p>
                </div>
                <h2 id="trips">Trips following this route</h2>
                <div class="indent">
                    <ul>
<?php $duration = CreateGtfsShapeTripList( $feed, $release_date, $shape_id ); ?>
                    </ul>
                </div>

            </div>

            <div class="clearing">
                <button class="button-create" type="button" onclick="gpxdownloadforshape()">GPX-Download</button>

<?php $duration += CreateGtfsShapeEntry( $feed, $release_date, $shape_id ); ?>

                <?php printf( "<p>SQL-Queries took %f seconds to complete</p>\n", $duration ); ?>

            </div>

            <script>
                showshapeonmap();
            </script>


        </main> <!-- main -->

        <hr />

<?php include $lang_dir.'gtfs-footer.inc' ?>

      </div> <!-- wrapper -->

      <iframe style="display:none" id="hiddenIframe" name="hiddenIframe"></iframe>

    </body>
</html>
