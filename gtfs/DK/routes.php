<!DOCTYPE html>
<html lang="dk">

<?php $title="GTFS Analysen"; $inc_lang='../../dk/'; include $inc_lang.'html-head.inc'; ?>

<?php include('../../script/globals.php'); ?>
<?php include('../../script/gtfs.php'); ?>

    <body>
      <script src="/script/ptna-list.js" type="text/javascript"></script>

      <div id="wrapper">

<?php include $inc_lang.'header.inc' ?>

        <main id="main" class="results">
<?php $network  = $_GET['network']; ?>

            <h2 id="DK"><img src="/img/Denmark32.png" alt="Flag til Danmark" /> GTFS-analyser for <?php if ( $network ) { echo '<span id="network">' . htmlspecialchars($network) . '</span>'; } else { echo '<span id="network">Danmark</span>'; } ?></h2>
            <div class="indent">
<?php include $inc_lang.'gtfs-routes-head.inc' ?>

                <?php
                    $ptna = GetPtnaDetails( $network );
                    if ( $ptna['comment'] ) {
                        printf( "<p><strong>%s</strong></p>\n", htmlspecialchars($ptna['comment']) );
                    }
                    $osm = GetOsmDetails( $network );
                    if ( $osm['gtfs_agency_is_operator'] ) {
                        $include_agency = 1;
                    } else {
                        $include_agency = 0;
                    }
               ?>

                <button class="button-create" type="button" onclick="ptnalistdownload( <?php echo $include_agency; ?> )">Download som en CSV-liste til PTNA</button>

                <table id="gtfs-routes">
                    <thead>
<?php include $inc_lang.'gtfs-routes-trth.inc' ?>
                    </thead>
                    <tbody>
<?php $duration = CreateGtfsRoutesEntry( $network ); ?>
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
