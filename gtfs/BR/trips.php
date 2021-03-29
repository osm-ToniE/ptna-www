<!DOCTYPE html>
<?php   include( '../../script/globals.php'     );
        include( '../../script/parse_query.php' );
        include( '../../script/gtfs.php'        );
?>
<html lang="<?php echo $html_lang ?>">

<?php $title="GTFS Análise"; $lang_dir="../../$ptna_lang/"; include $lang_dir.'html-head.inc'; ?>

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

            <h2 id="BR"><a href="index.php"><img src="/img/Brasil32.png" alt="bandeira do brasil" /></a> GTFS Análise sobre <?php if ( $feed && $route_id && $route_short_name ) { echo '<a href="routes.php?feed=' . urlencode($feed) . '&release_date=' . urlencode($release_date) . '">' . htmlspecialchars($feed_and_release) . '</a> Rota "' . htmlspecialchars($route_short_name) . '"'; } else { echo "Brasil"; } ?></h2>
            <div class="indent">

                <h3 id="feeds">Available GTFS sources</h3>
                <div class="indent">

<?php   $months_short = array( "Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec" );

        CreateGtfsTimeLine( $feed, $release_date, $months_short ) ;

        include $lang_dir.'gtfs-feed-legend.inc';
?>

                </div>

                <h3 id="routes">Existing Route Variants</h3>
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

                    <?php printf( "<p>As consultas SQL levaram %f segundos para serem concluídas</p>\n", $duration ); ?>
                </div>
            </div>

        </main> <!-- main -->

        <hr />

<?php include $lang_dir.'gtfs-footer.inc' ?>

      </div> <!-- wrapper -->
    </body>
</html>
