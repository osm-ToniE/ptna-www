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

            <h2 id="compare-shapes"><?php echo $STR_compare_gtfs_shapes; ?></h2>
            <div class="indent">

                <table id="versions-table" class="compare">
                    <thead>
<?php CreateCompareShapesTableHead( $feed, $feed2, $release_date, $release_date2, $shape_id, $shape_id2 ); ?>
                    </thead>
                    <tbody>
<?php CreateCompareShapesTableBody( $feed, $feed2, $release_date, $release_date2, $shape_id, $shape_id2 ); ?>
                    </tbody>
                </table>

            </div>

        </main> <!-- main -->

        <hr />

<?php include $lang_dir.'gtfs-footer.inc' ?>

      </div> <!-- wrapper -->
    </body>
</html>
