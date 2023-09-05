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

            <h2 id="compare-versions"><?php echo $STR_compare_gtfs_versions;
                                            if ( $feed == $feed2 ) {
                                                echo ' - ' . $feed;
                                            }
                                      ?></h2>
            <div class="indent">

                <form method="get" action="compare-routes.php">
                    <table id="versions-table" class="compare">
                        <thead>
<?php $duration = CreateCompareVersionsTableHead( $feed, $feed2, $release_date, $release_date2 ); ?>
                        </thead>
                        <tbody>
<?php $duration += CreateCompareVersionsTableBody( $feed, $feed2, $release_date, $release_date2 ); ?>
                        </tbody>
                    </table>
                    <?php if ( $ptna_lang != 'en' ) { echo '<input type="hidden" name="lang" value="' . $ptna_lang . '">'; } ?>

                    <?php printf( $STR_sql_queries_took . "\n", $duration ); ?>
                </form>

            </div>

            </div>

        </main> <!-- main -->

        <hr />

<?php include $lang_dir.'gtfs-footer.inc' ?>

      </div> <!-- wrapper -->
    </body>
</html>
