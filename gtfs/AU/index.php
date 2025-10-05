<!DOCTYPE html>
<?php   include( '../../script/globals.php'     );
        include( '../../script/parse_query.php' );
        include( '../../script/gtfs.php'        );
?>
<html lang="<?php echo $html_lang ?>">

<?php $title="GTFS Analysis"; $lang_dir="../../$ptna_lang/"; include $lang_dir.'html-head.inc'; ?>

    <body>
      <div id="wrapper">
<?php include $lang_dir.'header.inc' ?>
<?php $duration = 0; ?>
        <main id="main" class="results">

            <h2 id="AU"><a href="index.php"><img src="/img/Australia32.png"  class="flagimg" alt="Flag of Australia" /></a> GTFS Analysis for Australia</h2>
            <div class="indent">
<?php include $lang_dir.'gtfs-head.inc' ?>
                <table id="gtfsAU">
                    <thead>
<?php include $lang_dir.'gtfs-trth.inc' ?>
                    </thead>
                    <tbody>
<?php
    $duration += CreateGtfsEntry( "AU-NSW-TfNSW" );
    $duration += CreateGtfsEntry( "AU-QLD-South-East-Queensland" );
    $duration += CreateGtfsEntry( "AU-SA-Adelaide-Metro" );
    $duration += CreateGtfsEntry( "AU-TAS-DoSG" );
    $duration += CreateGtfsEntry( "AU-VIC-DTP-1" );
    $duration += CreateGtfsEntry( "AU-VIC-DTP-2" );
    $duration += CreateGtfsEntry( "AU-VIC-DTP-3" );
    $duration += CreateGtfsEntry( "AU-VIC-DTP-4" );
    $duration += CreateGtfsEntry( "AU-VIC-DTP-5" );
    $duration += CreateGtfsEntry( "AU-VIC-DTP-6" );
    $duration += CreateGtfsEntry( "AU-VIC-DTP-10" );
    $duration += CreateGtfsEntry( "AU-VIC-DTP-11" );
?>
                    </tbody>
                </table>

                <?php printf( "<p>SQL-Queries took %f seconds to complete</p>\n", $duration ); ?>
            </div>
        </main> <!-- main -->

        <hr />

<?php include $lang_dir.'gtfs-footer.inc' ?>

      </div> <!-- wrapper -->
    </body>
</html>
