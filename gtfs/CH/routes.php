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

<?php $title="GTFS Analysen"; $lang_dir="../../$ptna_lang/"; include $lang_dir.'html-head.inc'; ?>

    <body>
      <script src="/script/ptna-list.js"></script>

      <div id="wrapper">

<?php   include $lang_dir.'header.inc' ?>

        <main id="main" class="results">

            <h2 id="CH"><a href="index.php"><img src="/img/Switzerland32.png" alt="Schweizerfahne" /></a> GTFS Analysen für <?php if ( $feed ) { echo '<span id="feed">' . htmlspecialchars($feed_and_release) . '</span>'; } else { echo '<span id="feed">die Schweiz</span>'; } ?></h2>
            <div class="indent">

                <h3 id="feeds">Verfügbare GTFS-Quellen</h3>
                <div class="indent">

<?php   $months_short = array( "Jan", "Feb", "Mär", "Apr", "Mai", "Jun", "Jul", "Aug", "Sep", "Okt", "Nov", "Dez" );

        CreateGtfsTimeLine( $feed, $release_date, $months_short ) ;

        include $lang_dir.'gtfs-feed-legend.inc';
?>

                </div>

                <h3 id="routes">Existierende Linien</h3>
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

                    <button class="button-create" type="button" onclick="ptnalistdownload( <?php echo $include_agency; ?> )">Download als CSV-Liste für PTNA</button>

                    <table id="gtfs-routes">
                        <thead>
<?php include $lang_dir.'gtfs-routes-trth.inc' ?>
                        </thead>
                        <tbody>
<?php $duration = CreateGtfsRoutesEntry( $feed, $release_date ); ?>
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
