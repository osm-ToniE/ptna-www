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

            <h2 id="AT"><a href="index.php"><img src="/img/Austria32.png" alt="österreichische Flagge" /></a> GTFS Analysen für Österreich</h2>
            <div class="indent">
<?php include $lang_dir.'gtfs-head.inc' ?>
                <table id="gtfsDE">
                    <thead>
<?php include $lang_dir.'gtfs-trth.inc' ?>
                    </thead>
                    <tbody>
<?php
    $duration += CreateGtfsEntry( "AT-Eisenbahn" );
    $duration += CreateGtfsEntry( "AT-Linz-AG" );
    $duration += CreateGtfsEntry( "AT-OOeVV" );
    $duration += CreateGtfsEntry( "AT-SVV" );
    $duration += CreateGtfsEntry( "AT-VKG" );
    $duration += CreateGtfsEntry( "AT-VOR" );
    $duration += CreateGtfsEntry( "AT-VVSt" );
    $duration += CreateGtfsEntry( "AT-VVT" );
    $duration += CreateGtfsEntry( "AT-VVV" );
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
