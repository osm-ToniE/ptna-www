<!DOCTYPE html>
<?php   include( '../script/globals.php'     );
        include( '../script/gtfs.php'        );
        include( '../script/parse_query.php' );
        $feed2          = $_GET['feed2'];
        $release_date2  = $_GET['release_date2'];
        $route_id2      = $_GET['route_id2'];
        $trip_id2       = $_GET['trip_id2'];
        $shape_id2      = $_GET['shape_id2'];

        $lang_dir="../$ptna_lang/";
?>
<html lang="<?php echo $html_lang ?>">

<?php   include '../en/gtfs-compare-strings.inc';
        if ( file_exists($lang_dir.'gtfs-compare-strings.inc') ) {
            include $lang_dir.'gtfs-compare-strings.inc';
        }
        $title=$STR_gtfs_comparison;
        include $lang_dir.'html-head.inc';
?>

    <body>

      <div id="wrapper">

<?php   include $lang_dir.'header.inc'; ?>

        <main id="main" class="results">

            <h2 id="compare"><?php echo $STR_gtfs_comparison; ?></h2>
            <div class="indent">

                <h3 id="feeds"><?php echo $STR_compare_gtfs_data; ?></h3>
                <div class="indent">

                    <?php echo $STR_compare_head_feeds; ?>

                    <form method="get" action="compare-feeds.php">
                        <table id="feeds-table" class="compare">
                            <tbody>
                                <tr><th rowspan="4"><button class="button-create" type="submit"><?php echo $STR_compare_feeds; ?></button></th>
                                    <th class="gtfs-number"><?php echo $STR_number; ?></th>
                                    <th class="gtfs-name">GTFS Feed</th>
                                </tr>
                                <tr><td class="gtfs-number">1</td>
                                    <td class="gtfs-name"><input type="text" name="feed" value="<?php echo $feed; ?>" size="30" maxlength="30" pattern="^[0-9A-Za-z-]+$"></td>
                                </tr>
                                <tr><td class="gtfs-number">2</td>
                                    <td class="gtfs-name"><input type="text" name="feed2" value="<?php echo $feed2; ?>" size="30" maxlength="30" pattern="^[0-9A-Za-z-]+$"></td>
                                </tr>
                                <tr><td>&nbsp;</td>
                                    <td class="gtfs-name"><small><?php echo $STR_empty_fields_in; ?></small></td>
                                </tr>
                            </tbody>
                        </table>
                        <?php if ( $ptna_lang != 'en' ) { echo '<input type="hidden" name="lang" value="' . $ptna_lang . '">'; } ?>
                    </form>
                </div>

                <hr />

                <h3 id="routes"><?php echo $STR_compare_gtfs_feed_versions; ?></h3>
                <div class="indent">

                    <?php echo $STR_compare_head_versions; ?>

                    <form method="get" action="compare-versions.php">
                        <table id="versions-table" class="compare">
                            <tbody>
                                <tr><th rowspan="4"><button class="button-create" type="submit"><?php echo $STR_compare_versions; ?></button></th>
                                    <th class="gtfs-number"><?php echo $STR_number; ?></th>
                                    <th class="gtfs-name">GTFS Feed</th>
                                    <th class="gtfs-name"><?php echo $STR_release_date_ymd; ?></th>
                                    <th>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
                                </tr>
                                <tr><td class="gtfs-number">1</td>
                                    <td class="gtfs-name"><input type="text" name="feed" value="<?php echo $feed; ?>" size="30" maxlength="30" pattern="^[0-9A-Za-z-]+$"></td>
                                    <td class="gtfs-name"><input type="text" name="release_date" value="<?php echo $release_date; ?>" size="10" maxlength="10" pattern="^((20\d{2}-(0[1-9]|1[012]|[1-9])-(31|30|0[1-9]|[12][0-9]|[1-9]))|long-term|previous|latest)$"></td>
                                    <td>&nbsp;</td>
                                </tr>
                                <tr><td class="gtfs-number">2</td>
                                    <td class="gtfs-name"><input type="text" name="feed2" value="<?php echo $feed2; ?>" size="30" maxlength="30" pattern="^[0-9A-Za-z-]+$"></td>
                                    <td class="gtfs-name"><input type="text" name="release_date2" value="<?php echo $release_date2; ?>" size="10" maxlength="10" pattern="^((20\d{2}-(0[1-9]|1[012]|[1-9])-(31|30|0[1-9]|[12][0-9]|[1-9]))|long-term|previous|latest)$"></td>
                                    <td>&nbsp;</td>
                                </tr>
                                <tr><td>&nbsp;</td>
                                    <td class="gtfs-name" colspan="3"><small><?php echo $STR_empty_fields_in; ?></small></td>
                                </tr>
                            </tbody>
                        </table>
                        <?php if ( $ptna_lang != 'en' ) { echo '<input type="hidden" name="lang" value="' . $ptna_lang . '">'; } ?>
                    </form>
                </div>

                <hr />

                <h3 id="routes">Compare GTFS Routes</h3>
                <div class="indent">

                    <?php echo $STR_compare_head_routes; ?>

                    <form method="get" action="compare-routes.php">
                        <button class="button-create" type="submit">Compare Routes</button>
                        <table id="routes-table" class="compare">
                            <thead>
                                <tr><th class="gtfs-number"><?php echo $STR_number; ?></th><th class="gtfs-name">GTFS Feed</th><th class="gtfs-name"><?php echo $STR_release_date_ymd; ?></th><th class="gtfs-name">Route ID</th></tr>
                            </thead>
                            <tbody>
                                <tr><td class="gtfs-number">1</td>
                                    <td class="gtfs-name"><input type="text" name="feed" value="<?php echo $feed; ?>" size="30" maxlength="30" pattern="^[0-9A-Za-z-]+$"></td>
                                    <td class="gtfs-name"><input type="text" name="release_date" value="<?php echo $release_date; ?>" size="10" maxlength="10" pattern="^((20\d{2}-(0[1-9]|1[012]|[1-9])-(31|30|0[1-9]|[12][0-9]|[1-9]))|long-term|previous|latest)$"></td>
                                    <td class="gtfs-name"><input type="text" name="route_id"><?php echo $route_id; ?></td>
                                </tr>
                                <tr><td class="gtfs-number">2</td>
                                    <td class="gtfs-name"><input type="text" name="feed2" value="<?php echo $feed2; ?>" size="30" maxlength="30" pattern="^[0-9A-Za-z-]+$"></td>
                                    <td class="gtfs-name"><input type="text" name="release_date2" value="<?php echo $release_date2; ?>" size="10" maxlength="10" pattern="^((20\d{2}-(0[1-9]|1[012]|[1-9])-(31|30|0[1-9]|[12][0-9]|[1-9]))|long-term|previous|latest)$"></td>
                                    <td class="gtfs-name"><input type="text" name="route_id2"><?php echo $route_id2; ?></td>
                                </tr>
                            </tbody>
                        </table>
                        <small><?php echo $STR_empty_fields_in; ?></small>
                        <?php if ( $ptna_lang != 'en' ) { echo '<input type="hidden" name="lang" value="' . $ptna_lang . '">'; } ?>
                    </form>
                </div>

                <hr />

                <h3 id="trips">Compare GTFS Trips</h3>
                <div class="indent">

                    <?php echo $STR_compare_head_trips; ?>

                    <form method="get" action="compare-trips.php">
                        <button class="button-create" type="submit">Compare Trips</button>
                        <table id="trips-table" class="compare">
                            <thead>
                                <tr><th class="gtfs-number"><?php echo $STR_number; ?></th><th class="gtfs-name">GTFS Feed</th><th class="gtfs-name"><?php echo $STR_release_date_ymd; ?></th><th class="gtfs-name">Trip ID</th></tr>
                            </thead>
                            <tbody>
                                <tr><td class="gtfs-number">1</td>
                                    <td class="gtfs-name"><input type="text" name="feed" value="<?php echo $feed; ?>" size="30" maxlength="30" pattern="^[0-9A-Za-z-]+$"></td>
                                    <td class="gtfs-name"><input type="text" name="release_date" value="<?php echo $release_date; ?>" size="10" maxlength="10" pattern="^((20\d{2}-(0[1-9]|1[012]|[1-9])-(31|30|0[1-9]|[12][0-9]|[1-9]))|long-term|previous|latest)$"></td>
                                    <td class="gtfs-name"><input type="text" name="trip_id"><?php echo $trip_id; ?></td>
                                </tr>
                                <tr><td class="gtfs-number">2</td>
                                    <td class="gtfs-name"><input type="text" name="feed2" value="<?php echo $feed2; ?>" size="30" maxlength="30" pattern="^[0-9A-Za-z-]+$"></td>
                                    <td class="gtfs-name"><input type="text" name="release_date2" value="<?php echo $release_date2; ?>" size="10" maxlength="10" pattern="^((20\d{2}-(0[1-9]|1[012]|[1-9])-(31|30|0[1-9]|[12][0-9]|[1-9]))|long-term|previous|latest)$"></td>
                                    <td class="gtfs-name"><input type="text" name="trip_id2"><?php echo $trip_id2; ?></td>
                                </tr>
                            </tbody>
                        </table>
                        <small><?php echo $STR_empty_fields_in; ?></small>
                        <?php if ( $ptna_lang != 'en' ) { echo '<input type="hidden" name="lang" value="' . $ptna_lang . '">'; } ?>
                    </form>
                </div>

                <hr />

                <h3 id="shapes">Compare GTFS Shapes</h3>
                <div class="indent">

                    <?php echo $STR_compare_head_shapes; ?>

                    <form method="get" action="compare-shapes.php">
                        <button class="button-create" type="submit">Compare Shapes</button>
                        <table id="shapes-table" class="compare">
                            <thead>
                                <tr><th class="gtfs-number"><?php echo $STR_number; ?></th><th class="gtfs-name">GTFS Feed</th><th class="gtfs-name"><?php echo $STR_release_date_ymd; ?></th><th class="gtfs-name">Shape ID</th></tr>
                            </thead>
                            <tbody>
                                <tr><td class="gtfs-number">1</td>
                                    <td class="gtfs-name"><input type="text" name="feed" value="<?php echo $feed; ?>" size="30" maxlength="30" pattern="^[0-9A-Za-z-]+$"></td>
                                    <td class="gtfs-name"><input type="text" name="release_date" value="<?php echo $release_date; ?>" size="10" maxlength="10" pattern="^((20\d{2}-(0[1-9]|1[012]|[1-9])-(31|30|0[1-9]|[12][0-9]|[1-9]))|long-term|previous|latest)$"></td>
                                    <td class="gtfs-name"><input type="text" name="shape_id"><?php echo $shape_id; ?></td>
                                </tr>
                                <tr><td class="gtfs-number">2</td>
                                    <td class="gtfs-name"><input type="text" name="feed2" value="<?php echo $feed2; ?>" size="30" maxlength="30" pattern="^[0-9A-Za-z-]+$"></td>
                                    <td class="gtfs-name"><input type="text" name="release_date2" value="<?php echo $release_date2; ?>" size="10" maxlength="10" pattern="^((20\d{2}-(0[1-9]|1[012]|[1-9])-(31|30|0[1-9]|[12][0-9]|[1-9]))|long-term|previous|latest)$"></td>
                                    <td class="gtfs-name"><input type="text" name="shape_id2"><?php echo $shape_id2; ?></td>
                                </tr>
                            </tbody>
                        </table>
                        <small><?php echo $STR_empty_fields_in; ?></small>
                        <?php if ( $ptna_lang != 'en' ) { echo '<input type="hidden" name="lang" value="' . $ptna_lang . '">'; } ?>
                    </form>
                </div>

            </div>

        </main> <!-- main -->

        <hr />

<?php include $lang_dir.'gtfs-footer.inc' ?>

      </div> <!-- wrapper -->
    </body>
</html>
