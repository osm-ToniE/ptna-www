<!DOCTYPE html>
<?php   include( '../../script/globals.php'     );
        include( '../../script/parse_query.php' );
        include( '../../script/gtfs.php'        );
?>
<html lang="<?php echo $html_lang ?>">

<?php $title="GTFS Analysen"; $lang_dir="../../$ptna_lang/"; include $lang_dir.'html-head.inc'; ?>

    <body>

      <div id="wrapper">

<?php include $lang_dir.'header.inc' ?>

        <main id="main" class="results">
            <?php
                $route_short_name = GetGtfsRouteShortNameFromRouteId( $feed, $release_date, $route_id );
                if ( !$route_short_name ) {
                     $route_short_name = '__not_set__';
                }
                $ptna             = GetRouteDetails( $feed, $release_date, $route_id );
                $is_invalid       = $ptna["ptna_is_invalid"];
                $is_wrong         = $ptna["ptna_is_wrong"];
                $comment          = $ptna["ptna_comment"];
                if ( $release_date ) {
                    $feed_and_release = $feed . ' - ' . $release_date;
                } else {
                    $feed_and_release = $feed;
                }
            ?>

            <h2 id="CH"><a href="index.php"><img src="/img/Switzerland32.png" alt="Schweizerfahne" /></a> GTFS Analysen für <?php if ( $feed && $route_id && $route_short_name ) { echo '<a href="routes.php?feed=' . urlencode($feed) . '&release_date=' . urlencode($release_date) . '">' . htmlspecialchars($feed_and_release) . '</a> Linie "' . htmlspecialchars($route_short_name) . '"'; } else { echo "die Schweiz"; } ?></h2>
            <div class="indent">

                <h3 id="feeds">Verfügbare GTFS-Quellen</h3>
                <div class="indent">

<?php   $months_short = array( "Jan", "Feb", "Mär", "Apr", "Mai", "Jun", "Jul", "Aug", "Sep", "Okt", "Nov", "Dez" );

        CreateGtfsTimeLine( $feed, $release_date, $months_short ) ;

        include $lang_dir.'gtfs-feed-legend.inc';
?>

                </div>

                <h3 id="routes">Existierende Linienvarianten</h3>
                <div class="indent">

<?php include $lang_dir.'gtfs-trips-head.inc' ?>

                    <table id="gtfs-trips">
                        <thead>
<?php include $lang_dir.'gtfs-trips-trth.inc' ?>
                        </thead>
                        <tbody>
<?php $duration = CreateGtfsTripsEntry( $feed, $release_date, $route_id, $route_short_name ); ?>
                        </tbody>
                    </table>

                    <?php printf( "<p>SQL-Abfrage benötigte %f Sekunden</p>\n", $duration ); ?>
                </div>
            </div>

        </main> <!-- main -->

        <hr />

<?php include $lang_dir.'gtfs-footer.inc' ?>

      </div> <!-- wrapper -->
    </body>
</html>
