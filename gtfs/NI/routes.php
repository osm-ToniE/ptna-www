<!DOCTYPE html>
<html lang="en">

<?php $title="GTFS Analysis"; $inc_lang='../../es/'; include $inc_lang.'html-head.inc'; ?>

<?php include('../../script/globals.php'); ?>
<?php include('../../script/gtfs.php'); ?>

    <body>
      <script src="/script/ptna-list.js"></script>

      <div id="wrapper">

<?php include $inc_lang.'header.inc' ?>

        <main id="main" class="results">
<?php $network  = $_GET['network']; ?>

            <h2 id="NI"><a href="index.php"><img src="/img/Nicaragua32.png" alt="bandera Nicaragua" /></a> GTFS Analysis for <?php if ( $network ) { echo '<span id="network">' . htmlspecialchars($network) . '</span>'; } else { echo '<span id="network">Nicaragua</span>'; } ?></h2>
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

                <button class="button-create" type="button" onclick="ptnalistdownload( <?php echo $include_agency; ?> )">Download as CSV list for PTNA</button>

                <table id="gtfs-routes">
                    <thead>
<?php include $inc_lang.'gtfs-routes-trth.inc' ?>
                    </thead>
                    <tbody>
<?php $duration = CreateGtfsRoutesEntry( $network ); ?>
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
