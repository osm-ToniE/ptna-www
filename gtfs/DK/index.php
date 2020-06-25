<!DOCTYPE html>
<html lang="da">

<?php $title="GTFS Analysen"; $inc_lang='../../da/'; include $inc_lang.'html-head.inc'; ?>

<?php include('../../script/globals.php'); ?>
<?php include('../../script/gtfs.php'); ?>

    <body>
      <div id="wrapper">
<?php include $inc_lang.'header.inc' ?>
<?php $duration = 0; ?>
        <main id="main" class="results">

            <h2 id="DK"><img src="/img/Denmark32.png" alt="Flag til Danmark" /> GTFS-analyser for Danmark</h2>
            <div class="indent">
<?php include $inc_lang.'gtfs-head.inc' ?>
                <table id="gtfsDK">
                    <thead>
<?php include $inc_lang.'gtfs-trth.inc' ?>
                    </thead>
                    <tbody>
<?php
    $duration += CreateGtfsEntry( "DK-Alle" );
?>

                    </tbody>
                </table>

                <?php printf( "<p>SQL-forespørgsler tog %f sekunder</p>\n", $duration ); ?>
            </div>
        </main> <!-- main -->

        <hr />

<?php include $inc_lang.'gtfs-footer.inc' ?>

      </div> <!-- wrapper -->
    </body>
</html>
