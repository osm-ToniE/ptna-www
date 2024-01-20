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
        $title=$STR_gtfs_comparison;
        include $lang_dir.'html-head.inc';
?>

    <body>

      <div id="wrapper">

<?php   include $lang_dir.'header.inc'; ?>

        <main id="main" class="results">

<?php   if ( $osm_relation ): ?>
            <h2 id="compare-routes">Compare GTFS route with OSM route_master</h2>
            <div class="indent">
                <p>
                    <span style="background-color: orange; font-weight: 1000; font-size:2.0em;">This is proof-of-concept (fake) data based on a specific bus: DE-BY-MVV Bus 210. Just to discuss the layout of this page, ...</span>
                </p>
                <?php $duration = CreateCompareRoutesTable( $feed, $feed2, $release_date, $release_date2, $route_id, $route_id2, $osm_relation, $ptna_lang ); ?>
                <?php printf( $STR_sql_queries_took . "\n", $duration ); ?>
            </div>
<?php   else: ?>
            <h2 id="compare-routes">Compare GTFS route with GTFS route</h2>
<?php   endif ?>

        </main> <!-- main -->

        <hr />

<?php include $lang_dir.'gtfs-footer.inc' ?>

      </div> <!-- wrapper -->
    </body>
</html>
