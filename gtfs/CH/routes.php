<!DOCTYPE html>
<html lang="de">

<?php $title="GTFS Analysen"; $inc_lang='../../de/'; include $inc_lang.'html-head.inc'; ?>

<?php include('../../script/globals.php'); ?>
<?php include('../../script/gtfs.php'); ?>

    <body>
      <script src="/script/ptna-list.js"></script>

      <div id="wrapper">

<?php include $inc_lang.'header.inc' ?>

        <main id="main" class="results">
<?php $network  = $_GET['network']; ?>

            <h2 id="CH"><a href="index.php"><img src="/img/Switzerland32.png" alt="Schweizerfahne" /></a> GTFS Analysen für <?php if ( $network ) { echo '<span id="network">' . htmlspecialchars($network) . '</span>'; } else { echo '<span id="network">die Schweiz</span>'; } ?></h2>
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

                <button class="button-create" type="button" onclick="ptnalistdownload( <?php echo $include_agency; ?> )">Download als CSV-Liste für PTNA</button>

                <table id="gtfs-routes">
                    <thead>
<?php include $inc_lang.'gtfs-routes-trth.inc' ?>
                    </thead>
                    <tbody>
<?php $duration = CreateGtfsRoutesEntry( $network ); ?>
                    </tbody>
                </table>

                <?php printf( "<p>SQL-Abfrage benötigte %f Sekunden</p>\n", $duration ); ?>

            </div>

        </main> <!-- main -->

        <hr />

<?php include $inc_lang.'gtfs-footer.inc' ?>

      </div> <!-- wrapper -->
    </body>
</html>
