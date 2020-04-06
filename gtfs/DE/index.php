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
<?php 
    $duration += CreateGtfsEntry( "DE-S-und-U-Bahnen" );
    $duration += CreateGtfsEntry( "DE-SPNV" );
    $duration += CreateGtfsEntry( "DE-BE-VBB" );
    $duration += CreateGtfsEntry( "DE-BW-DING" );
    $duration += CreateGtfsEntry( "DE-BW-Filsland" );
    $duration += CreateGtfsEntry( "DE-BW-HNV" );
    $duration += CreateGtfsEntry( "DE-BW-HVG" );
    $duration += CreateGtfsEntry( "DE-BW-KV.SHA" );
    $duration += CreateGtfsEntry( "DE-BW-KVV" );
    $duration += CreateGtfsEntry( "DE-BW-OstablbMobil" );
    $duration += CreateGtfsEntry( "DE-BW-RAB" );
    $duration += CreateGtfsEntry( "DE-BW-RBS" );
    $duration += CreateGtfsEntry( "DE-BW-RVS" );
    $duration += CreateGtfsEntry( "DE-BW-Rexer" );
    $duration += CreateGtfsEntry( "DE-BW-S-Bahn-Stuttgart" );
    $duration += CreateGtfsEntry( "DE-BW-SBG" );
    $duration += CreateGtfsEntry( "DE-BW-SWEG" );
    $duration += CreateGtfsEntry( "DE-BW-SWHN" );
    $duration += CreateGtfsEntry( "DE-BW-TGO" );
    $duration += CreateGtfsEntry( "DE-BW-TUTicket" );
    $duration += CreateGtfsEntry( "DE-BW-VBC" );
    $duration += CreateGtfsEntry( "DE-BW-VGV" );
    $duration += CreateGtfsEntry( "DE-BW-VPE" );
    $duration += CreateGtfsEntry( "DE-BW-VRN" );
    $duration += CreateGtfsEntry( "DE-BW-VVS" );
    $duration += CreateGtfsEntry( "DE-BW-bodo" );
    $duration += CreateGtfsEntry( "DE-BW-naldo" );
    $duration += CreateGtfsEntry( "DE-BY-MVV" );
    $duration += CreateGtfsEntry( "DE-NW-AVV" );
    $duration += CreateGtfsEntry( "DE-NW-VRR" );
    $duration += CreateGtfsEntry( "DE-NW-VRS" );
    $duration += CreateGtfsEntry( "DE-SN-MDV" );
?>
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

