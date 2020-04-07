<!DOCTYPE html>
<html lang="de">

<?php $title="GTFS Analysen"; $inc_lang='../../de/'; include $inc_lang.'html-head.inc'; ?>

<?php include('../../script/globals.php'); ?>
<?php include('../../script/gtfs.php'); ?>

    <body>
      <link rel="stylesheet" href="https://unpkg.com/leaflet@1.6.0/dist/leaflet.css" integrity="sha512-xwE/Az9zrjBIphAcBb3F6JVqxf46+CDLwfLMHloNu6KEQCAWi6HcDUbeOfBIptF7tcCzusKFjFw2yuvEpDL9wQ==" crossorigin=""/>
      <script src="https://unpkg.com/leaflet@1.6.0/dist/leaflet.js" integrity="sha512-gZwIG9x3wUXg2hdXF6+rVkLF/0Vi9U8D2Ntg4Ga5I5BZpVkVxlJWbSQtXPSiUTtC0TjtGOmxa1AJPuV0CPthew==" crossorigin=""></script>
      <script src="/script/gpx.js"></script>
      <script src="/script/showonmap.js"></script>
      
   
      <div id="wrapper">

<?php include $inc_lang.'header.inc' ?>

        <main id="main" class="results">
<?php
    $network          = ( $_GET['network'] ) ? $_GET['network'] : $_POST['network'];
    $trip_id          = ( $_GET['trip_id'] ) ? $_GET['trip_id'] : $_POST['trip_id'];
    $route_short_name = GetGtfsRouteShortNameFromTripId( $network, $trip_id );
    $ptna             = GetPtnaTripDetails( $network, $trip_id );
    $is_invalid       = $ptna["ptna_is_invalid"];
    $is_wrong         = $ptna["ptna_is_wrong"];
    $comment          = $ptna["ptna_comment"];
    $ptna             = GetPtnaNetworkDetails( $network );
    $has_shapes       = $ptna["has_shapes"];
?>

            <h2 id="DE"><img src="/img/Germany32.png" alt="deutsche Flagge" /> GTFS Analysen für <?php if ( $network && $route_short_name && $trip_id ) { echo '<span id="network">' . htmlspecialchars($network) . '</span> Linie "<span id="route_short_name">' . htmlspecialchars($route_short_name) . '</span>", Trip-Id = "<span id="trip_id">' . htmlspecialchars($trip_id) . '</span>"'; } else { echo '<span id="network">Deutschland</span>'; } ?></h2>
            <div class="indent">

<?php include $inc_lang.'gtfs-single-trip-head.inc' ?>

                <button class="button-create" type="button" onclick="gpxdownload()">GPX-Download</button>

                <div id="mapid"></div>

                <table id="gtfs-single-trip">
                    <thead>
<?php include $inc_lang.'gtfs-single-trip-trth.inc' ?>
                    </thead>
                    <tbody>
<?php $duration = CreateGtfsSingleTripEntry( $network, $trip_id, $edit ); ?>
                    </tbody>
                </table>

<?php $duration += CreateGtfsSingleTripShapeEntry( $network, $trip_id ); ?>

<?php printf( "<p>SQL-Abfrage benötigte %f Sekunden</p>\n", $duration ); ?>

            </div>

            <script>
                showtriponmap();
            </script>


        </main> <!-- main -->

        <hr />

<?php include $inc_lang.'gtfs-footer.inc' ?>

      </div> <!-- wrapper -->
    </body>
</html>

