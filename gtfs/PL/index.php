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

            <h2 id="PL"><a href="index.php"><img src="/img/Poland32.png" alt="Flaga Polski" /></a> GTFS wyniki dla Polski</h2>
            <div class="indent">
                <p>
                    <span style="background-color: orange; font-weight: 1000; font-size:2.0em;">There are no updates "PL-24-ZTM-Katowice". The Release-URL is not reachable via 'curl' and 'wget': a firewall rule seems to block that. An automated download is no longer possible.</span>
                </p>
<?php include $lang_dir.'gtfs-head.inc' ?>
                <table id="gtfsPL">
                    <thead>
<?php include $lang_dir.'gtfs-trth.inc' ?>
                    </thead>
                    <tbody>
<?php
    $duration += CreateGtfsEntry( "PL-14-ZTM-Warszawa" );
    $duration += CreateGtfsEntry( "PL-24-ZTM-Katowice" );
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
