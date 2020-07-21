<!DOCTYPE html>
<html lang="en">

<?php $title="GTFS Analysis"; $inc_lang='../../en/'; include $inc_lang.'html-head.inc'; ?>

<?php include('../../script/globals.php'); ?>
<?php include('../../script/gtfs.php'); ?>

    <body>
      <div id="wrapper">
<?php include $inc_lang.'header.inc' ?>
<?php $duration = 0; ?>
        <main id="main" class="results">

            <h2 id="AU"><a href="index.php"><img src="/img/Australia32.png" alt="Flag of Australia" /></a> GTFS Analysis for Australia</h2>
            <div class="indent">
<?php include $inc_lang.'gtfs-head.inc' ?>
                <table id="gtfsAU">
                    <thead>
<?php include $inc_lang.'gtfs-trth.inc' ?>
                    </thead>
                    <tbody>
<?php
    $duration += CreateGtfsEntry( "AU-SA-Adelaide-Metro" );
?>
                    </tbody>
                </table>

                <?php printf( "<p>SQL-Queries took %f seconds to complete</p>\n", $duration ); ?>
            </div>
        </main> <!-- main -->

        <hr />

<?php include $inc_lang.'gtfs-footer.inc' ?>

      </div> <!-- wrapper -->
    </body>
</html>
