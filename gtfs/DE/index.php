<!DOCTYPE html>
<html lang="de">

<?php $title="GTFS Analysen"; $inc_lang='../../de/'; include $inc_lang.'html-head.inc'; ?>

<?php include('../../script/globals.php'); ?>
<?php include('../../script/gtfs.php'); ?>

    <body>
      <div id="wrapper">
<?php include $inc_lang.'header.inc' ?>
<?php $duration = 0; ?>
        <main id="main" class="results">

            <h2 id="DE"><img src="/img/Germany32.png" alt="deutsche Flagge" /> GTFS Analysen für Deutschland</h2>
            <div class="indent">
<?php include $inc_lang.'gtfs-head.inc' ?>
                <table id="gtfsDE">
                    <thead>
<?php include $inc_lang.'gtfs-trth.inc' ?>
                    </thead>
                    <tbody>
<?php $duration += CreateGtfsEntry( "DE-BE-VBB" ); ?>
<?php $duration += CreateGtfsEntry( "DE-BW-DING" ); ?>
<?php $duration += CreateGtfsEntry( "DE-BW-S-Bahn-Stuttgart" ); ?>
<?php $duration += CreateGtfsEntry( "DE-BW-VHB" ); ?>
<?php $duration += CreateGtfsEntry( "DE-BY-MVV" ); ?>
<?php $duration += CreateGtfsEntry( "DE-NW-AVV" ); ?>
<?php $duration += CreateGtfsEntry( "DE-NW-VRR" ); ?>
                    </tbody>
                </table>
                
                <?php printf( "<p>SQL-Abfragen benötigten %f Sekunden</p>\n", $duration ); ?>
            </div>
        </main> <!-- main -->

        <hr />

<?php include $inc_lang.'gtfs-footer.inc' ?>

      </div> <!-- wrapper -->
    </body>
</html>

