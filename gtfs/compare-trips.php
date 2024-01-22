<!DOCTYPE html>
<?php   include( '../script/globals.php'      );
        include( '../script/parse_query.php'  );
        $lang_dir="../$ptna_lang/";
?>
<html lang="<?php echo $html_lang ?>">

<?php   include '../en/gtfs-compare-strings.inc';
        if ( file_exists($lang_dir.'gtfs-compare-strings.inc') ) {
            include $lang_dir.'gtfs-compare-strings.inc';
        }
        include( '../script/gtfs.php'         );
        include( '../script/gtfs-compare.php' );
        if ( $osm_relation ) {
            $title="Compare GTFS trip with OSM route";
        } else {
            $title="Compare GTFS trip with GTFS trip";
        }
        include $lang_dir.'html-head.inc';
?>

    <body>

      <div id="wrapper">

<?php   include $lang_dir.'header.inc'; ?>

        <main id="main" class="results">

<?php   if ( $prove_of_concept ): ?>
            <h2 id="compare-routes">Compare GTFS trip with OSM route</h2>
            <div class="indent">
                <p>
                    <span style="background-color: orange; font-weight: 1000; font-size:2.0em;">This is proof-of-concept (fake) data based on a specific bus: DE-BY-MVV Bus 210. Just to discuss the layout of this page, ...</span>
                </p>

                <?php CreateCompareTripsTable( $feed, $feed2, $release_date, $release_date2, $trip_id, $trip_id2, $osm_relation ); ?>

            </div>
<?php   else: ?>
            <h2 id="compare-routes">Compare GTFS trip with GTFS trip</h2>
<?php   endif ?>

        </main> <!-- main -->

        <hr />

<?php include $lang_dir.'gtfs-footer.inc' ?>

      </div> <!-- wrapper -->
    </body>
</html>
