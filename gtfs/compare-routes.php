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

            <h2 id="compare-routes">DE-BY-MVV Bus 210: compare GTFS route (<a target="_blank" href="/gtfs/DE/trips.php?feed=DE-BY-MVV&release_date=&route_id=19-210-s24-1">19-210-s24-1</a>) with OSM route_master (<a target="_blank" href="https://www.openstreetmap.org/relation/67811">67811</a>)<!-- <?php echo $STR_compare_gtfs_routes;
                                          if ( $feed == $feed2 ) {
                                             echo ' - ' . $feed;
                                          }
                                     ?> --> </h2>
            <div class="indent">
                <p>
                    <span style="background-color: orange; font-weight: 1000; font-size:2.0em;">This is proof-of-concept (fake) data based on a specific bus: DE-BY-MVV Bus 210. Just to discuss the layout of this page, ...</span>
                </p>
                <form method="get" action="compare-trips.php">
<?php $duration = CreateCompareRoutesTable( $feed, $feed2, $release_date, $release_date2, $route_id, $route_id2, $osm_relation ); ?>
                    <?php if ( $ptna_lang != 'en' ) { echo '<input type="hidden" name="lang" value="' . $ptna_lang . '">'; } ?>
                    <?php printf( $STR_sql_queries_took . "\n", $duration ); ?>
                </form>
            </div>

            <hr />

            <h2 id="calculate-score"><?php echo "Calculation of Score"; ?></h2>
            <div class="indent">
                <p>
                    Currently, the scores are not calulated but set manually to an arbritary value.
                </p>
            </div>

        </main> <!-- main -->

        <hr />

<?php include $lang_dir.'gtfs-footer.inc' ?>

      </div> <!-- wrapper -->
    </body>
</html>
