<!DOCTYPE html>
<html lang="de">

<?php $title="GTFS Analysen"; $inc_lang='../../de/'; include $inc_lang.'html-head.inc'; ?>

<?php include('../../script/gtfs.php'); ?>

    <body>
      <div id="wrapper">
      
<?php include $inc_lang.'header.inc' ?>

        <main id="main" class="results">
<?php $network  = $_GET['network']; ?>

            <h2 id="DE"><img src="/img/Germany32.png" alt="deutsche Flagge" /> GTFS Analysen für <?php if ( $network ) { echo htmlspecialchars($network); } else { echo "Deutschland"; } ?></h2>
            <div class="indent">
<?php include $inc_lang.'gtfs-routes-head.inc' ?>

                <form class="ptna-data" action="routes.php?network=<?php echo urlencode($network);?>" method="post">

                <?php
                    $comment = GetPtnaComment( $network );
                    if ( $comment ) {
                        printf( "<p>%s</p>\n", htmlspecialchars($comment) );
                    }
                ?>
                <table id="gtfs-routes">
                    <thead>
<?php include $inc_lang.'gtfs-routes-trth.inc' ?>
                    </thead>
                    <tbody>
<?php $duration = CreateGtfsRoutesEntry( $network ); ?>
                    </tbody>
                </table>
                
                </form>
                
                <?php printf( "<p>SQL-Abfrage benötigte %f Sekunden</p>\n", $duration ); ?>

            </div>
            
        </main> <!-- main -->

        <hr />

<?php include $inc_lang.'gtfs-footer.inc' ?>

      </div> <!-- wrapper -->
    </body>
</html>

