<!DOCTYPE html>
<?php   include( '../../script/globals.php'     );
        include( '../../script/parse_query.php' );
        include( '../../script/gtfs.php'        );
        if ( $release_date ) {
            $feed_and_release = $feed . ' - ' . $release_date;
        } else {
            $feed_and_release = $feed;
        }
?>
<html lang="<?php echo $html_lang ?>">

<?php $title="GTFS Análise"; $lang_dir="../../$ptna_lang/"; include $lang_dir.'html-head.inc'; ?>

    <body>
      <script src="/script/ptna-list.js"></script>
      <script src="/script/sort-table.js"></script>
      <script> // Run sortTable.init() when the page loads - disabled in sort-table.js for race-condition reasons
                window.addEventListener
                    ? window.addEventListener('load', sortTable.init, false)
                    : window.attachEvent && window.attachEvent('onload', sortTable.init)
                    ;
      </script>

      <div id="wrapper">

<?php   include $lang_dir.'header.inc' ?>

        <main id="main" class="results">

            <h2 id="BR"><a href="index.php"><img src="/img/Brasil32.png" alt="bandeira do brasil" /></a> GTFS Análise sobre <?php if ( $feed ) { echo '<span id="feed">' . htmlspecialchars($feed_and_release) . '</span>'; } else { echo '<span id="feed">Brasil</span>'; } ?></h2>
            <div class="indent">

                <h3 id="feeds">Available GTFS sources</h3>
                <div class="indent">

<?php   $months_short = array( "Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec" );

        CreateGtfsTimeLine( $feed, $release_date, $months_short ) ;

        include $lang_dir.'gtfs-feed-legend.inc';
?>

                </div>

                <h3 id="routes">Existing Routes</h3>
                <div class="indent">

<?php
    $ptna = GetPtnaDetails( $feed, $release_date );
    if ( isset($ptna['comment']) && $ptna['comment'] ) {
        printf( "<p><strong>%s</strong></p>\n", htmlspecialchars($ptna['comment']) );
    }
    $osm = GetOsmDetails( $feed, $release_date );
    if ( isset($osm['gtfs_agency_is_operator']) && $osm['gtfs_agency_is_operator'] ) {
        $include_agency = 1;
    } else {
        $include_agency = 0;
    }
?>

<?php   include $lang_dir.'gtfs-routes-head.inc' ?>

                    <button class="button-create" type="button" onclick="ptnalistdownload( <?php echo $include_agency; ?> )">Baixar como lista CSV para PTNA</button>

                    <table id="gtfs-routes" class="js-sort-table">
                        <thead>
<?php include $lang_dir.'gtfs-routes-trth.inc' ?>
                        </thead>
                        <tbody>
<?php $duration = CreateGtfsRoutesEntry( $feed, $release_date ); ?>
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
