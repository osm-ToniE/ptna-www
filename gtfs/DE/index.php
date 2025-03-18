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
<?php $duration = 0; ?>
        <main id="main" class="results">

            <h2 id="DE"><a href="index.php"><img src="/img/Germany32.png"  class="flagimg" alt="deutsche Flagge" /></a> GTFS Analysen für Deutschland</h2>
            <div class="indent">
<?php include $lang_dir.'gtfs-head.inc' ?>
                <table id="gtfsDE">
                    <thead>
<?php include $lang_dir.'gtfs-trth.inc' ?>
                    </thead>
                    <tbody>
<?php
    $duration += CreateGtfsEntry( "DE-S-und-U-Bahnen" );
    $duration += CreateGtfsEntry( "DE-BE-VBB" );
    $duration += CreateGtfsEntry( "DE-BW-DING" );
    $duration += CreateGtfsEntry( "DE-BW-HNV" );
    $duration += CreateGtfsEntry( "DE-BW-KV.SHA" );
    $duration += CreateGtfsEntry( "DE-BW-KVV" );
    $duration += CreateGtfsEntry( "DE-BW-OstalbMobil" );
    $duration += CreateGtfsEntry( "DE-BW-RVF" );
    $duration += CreateGtfsEntry( "DE-BW-TGO" );
    $duration += CreateGtfsEntry( "DE-BW-VAG" );
    $duration += CreateGtfsEntry( "DE-BW-VGC" );
    $duration += CreateGtfsEntry( "DE-BW-VGF" );
    $duration += CreateGtfsEntry( "DE-BW-VHB" );
    $duration += CreateGtfsEntry( "DE-BW-VPE" );
    $duration += CreateGtfsEntry( "DE-BW-VVS" );
    $duration += CreateGtfsEntry( "DE-BW-bodo" );
    $duration += CreateGtfsEntry( "DE-BW-move" );
    $duration += CreateGtfsEntry( "DE-BW-naldo" );
    $duration += CreateGtfsEntry( "DE-BY-MVG" );
    $duration += CreateGtfsEntry( "DE-BY-MVV" );
    $duration += CreateGtfsEntry( "DE-BY-VGN" );
    $duration += CreateGtfsEntry( "DE-HE-REB" );
    $duration += CreateGtfsEntry( "DE-HH-HVV" );
    $duration += CreateGtfsEntry( "DE-NW-AVV" );
    $duration += CreateGtfsEntry( "DE-NW-SWM" );
    $duration += CreateGtfsEntry( "DE-NW-VRR" );
    $duration += CreateGtfsEntry( "DE-NW-VRS" );
    $duration += CreateGtfsEntry( "DE-SH-Landesweit" );
    $duration += CreateGtfsEntry( "DE-SN-MDV" );
    $duration += CreateGtfsEntry( "DE-SN-VMS" );
?>
                    </tbody>
                </table>
                </div>

                <h3 id="nosupport">Auslaufender Support für GTFS Analysen</h3>
                <div class="indent">
                <p>
                    Für die folgenden GTFS-Quellen läuft der Support durch PTNA (vorläufig) aus.
                    Es liegen keine Aktualisierungen seitens NVBW mehr vor.
                </p>
                <table id="gtfsDEno">
                    <thead>
<?php include $lang_dir.'gtfs-trth.inc' ?>
                    </thead>
                    <tbody>
<?php
    $duration += CreateGtfsEntry( "DE-SPNV" );
    $duration += CreateGtfsEntry( "DE-BW-NVH" );
    $duration += CreateGtfsEntry( "DE-BW-RAB" );
    $duration += CreateGtfsEntry( "DE-BW-RBS" );
    $duration += CreateGtfsEntry( "DE-BW-RVS" );
    $duration += CreateGtfsEntry( "DE-BW-SBG" );
    $duration += CreateGtfsEntry( "DE-BW-SWEG" );
    $duration += CreateGtfsEntry( "DE-BW-TUTicket" );
    $duration += CreateGtfsEntry( "DE-BW-VAG-NVBW" );
?>
                    </tbody>
                </table>


<?php printf( "<p>SQL-Abfragen benötigten %f Sekunden</p>\n", $duration ); ?>
            </div>
        </main> <!-- main -->

        <hr />

<?php include $lang_dir.'gtfs-footer.inc' ?>

      </div> <!-- wrapper -->
    </body>
</html>
