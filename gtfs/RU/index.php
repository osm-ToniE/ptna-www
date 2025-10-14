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

            <h2 id="RU"><a href="index.php"><img src="/img/Russia32.png"  class="flagimg" alt="Флаг России" /></a> Анализ GTFS для России</h2>
            <div class="indent">
<?php include $lang_dir.'gtfs-head.inc' ?>
                <table id="gtfsRU">
                    <thead>
<?php include $lang_dir.'gtfs-trth.inc' ?>
                    </thead>
                    <tbody>
<?php
    $duration += CreateGtfsEntry( "RU-SPB-TransportSpb" );
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
