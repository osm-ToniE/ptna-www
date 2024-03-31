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

            <h2 id="GB"><a href="index.php"><img src="/img/GreatBritain32.png"  class="flagimg" alt="Flag of the United Kingdom" /></a> GTFS Analysis for the United Kingdom</h2>
            <div class="indent">
            <span style="background-color: orange; font-weight: 1000; font-size:2.0em;">There are no updates for "GB-IOW-SV". The Release-URL is not reachable via 'curl' and 'wget' and returns '403 Forbidden'. An automated download is no longer possible.</span>
<?php include $lang_dir.'gtfs-head.inc' ?>
                <table id="gtfsGB">
                    <thead>
<?php include $lang_dir.'gtfs-trth.inc' ?>
                    </thead>
                    <tbody>
<?php
    $duration += CreateGtfsEntry( "GB-IOW-SV" );
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
