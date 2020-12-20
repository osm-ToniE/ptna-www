<!DOCTYPE html>
<?php   include( '../../script/globals.php'     );
        include( '../../script/gtfs.php'        );
        include( '../../script/parse_query.php' );
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

            <h2 id="DE"><a href="index.php"><img src="/img/Germany32.png" alt="deutsche Flagge" /></a> GTFS Analysen für <?php if ( $feed ) { echo '<span id="feed">' . htmlspecialchars($feed_and_release) . '</span>'; } else { echo '<span id="feed">Deutschland</span>'; } ?></h2>
            <div class="indent">

                <h3 id="feeds">Verfügbare GTFS-Quellen</h3>
                <div class="indent">

<?php   $months_short = array( "Jan", "Feb", "Mär", "Apr", "Mai", "Jun", "Jul", "Aug", "Sep", "Okt", "Nov", "Dez" );

        $duration = CreateGtfsTimeLine( $feed, $release_date, $months_short ) ;

        include $lang_dir.'gtfs-feed-legend.inc';
?>
                </div>

                <h3 id="routes"><a href="routes.php?feed=<?php echo urlencode($feed); if ( $release_date ) { echo "&release_date=" . urlencode($release_date); } ?>">Linien</a></h3>
                <div class="indent">

                </div>
<!--
                <h3 id="stops">Haltestellen</h3>
                <div class="indent">

                </div>
-->
                <h3 id="versions">Vergleiche GTFS Versionen</h3>
                <div class="indent">

<?php   include $lang_dir.'gtfs-feed-head.inc' ?>

                    <form method="get" action="compare-routes.php"><button class="button-create" type="submit">Vergleiche Linien</button>
                        <input type="hidden" name="feed" value="<?php echo urlencode($feed); ?>">
                        <table id="gtfs-versions">
                            <thead>
<?php   include $lang_dir.'gtfs-feed-trth.inc' ?>
                            </thead>
                            <tbody>
<?php   $duration += CreateGtfsVersionsTableBody( $feed ); ?>
                            </tbody>
                        </table>
                    </form>
                </div>

            </div>

        </main> <!-- main -->

        <hr />

<?php include $lang_dir.'gtfs-footer.inc' ?>

      </div> <!-- wrapper -->
    </body>
</html>
