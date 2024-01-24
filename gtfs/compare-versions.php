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

    <body onload="toggle('hideable')">
      <script>function toggle(thisname) {
                button_text = 'Hide Unchanged';
                tr=document.getElementsByTagName('tr');
                for (i=0;i<tr.length;i++){
                    if (tr[i].getAttribute(thisname)){
                        if ( tr[i].style.display=='none' ){
                           tr[i].style.display = '';
                           button_text = 'Hide Unchanged';
                        } else {
                           tr[i].style.display = 'none';
                           button_text = 'Show all';
                        }
                    }
                }
                document.getElementById('show-hide').innerHTML = button_text;
            }
      </script>
      <div id="wrapper">

<?php   include $lang_dir.'header.inc'; ?>

        <main id="main" class="results">

            <h2 id="compare-versions"><?php echo $STR_compare_gtfs_versions;
                                            if ( $feed == $feed2 ) {
                                                echo ' - ' . $feed;
                                            }
                                      ?></h2>
            <div class="indent tableFixHeadCompare" style="height: 700">

                <form method="get" action="compare-routes.php">
                    <table  id="versions-table" class="compare">
                        <thead>
                            <?php echo '<tr>' . "\n" . '    <th colspan="16" style="text-align: left">' . "\n";
                                  echo '        <button class="button-create" type="submit">' . htmlspecialchars($STR_compare_routes) . '</button>' . "\n";
                                  echo '        <button id="show-hide" class="button-create" type="button" onclick="toggle(\'hideable\');">Hide Unchanged</button>' . "\n";
                                  echo "    </th>\n</tr>\n";
                            ?>
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
