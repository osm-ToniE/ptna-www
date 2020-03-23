<!DOCTYPE html>
<html lang="de">

<?php $title="GTFS Analysen"; $inc_lang='../../de/'; include $inc_lang.'html-head.inc'; ?>

<?php include('../../script/gtfs.php'); ?>

    <body>
      <div id="wrapper">
      
<?php include $inc_lang.'header.inc' ?>

        <main id="main" class="results">

            <?php 
                $network          = $_GET['network'];
                $trip_id          = $_GET['trip_id'];
                $route_short_name = GetGtfsRouteShortNameFromTripId( $network, $trip_id ); 
                $ptna             = GetPtnaTripDetails( $network, $trip_id );
                $is_invalid       = $ptna["ptna_is_invalid"];
                $is_wrong         = $ptna["ptna_is_wrong"];
                $comment          = $ptna["ptna_comment"];
            ?>
            
            <h2 id="DE"><img src="/img/Germany32.png" alt="deutsche Flagge" /> GTFS Analysen für <?php if ( $network && $route_short_name && $trip_id ) { echo htmlspecialchars($network) . ' Linie "' . htmlspecialchars($route_short_name) . '", Trip-Id = "' . htmlspecialchars($trip_id) . '"'; } else { echo "Deutschland"; } ?></h2>
            <div class="indent">

<?php include $inc_lang.'gtfs-single-trip-head.inc' ?>

                <table id="gtfsDE">
                    <thead>
<?php include $inc_lang.'gtfs-single-trip-trth.inc' ?>
                    </thead>
                    <tbody>
    
                        <?php $duration = CreateGtfsSingleTripEntry( $network, $trip_id ); ?>
    
                    </tbody>
                </table>
                
                <?php printf( "<p>SQL-Abfrage benötigte %f Sekunden</p>\n", $duration ); ?>

            </div>
            
        </main> <!-- main -->

        <hr />

<?php include $inc_lang.'gtfs-footer.inc' ?>

      </div> <!-- wrapper -->
    </body>
</html>

