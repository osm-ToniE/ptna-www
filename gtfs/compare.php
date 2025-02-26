<!DOCTYPE html>
<?php   include( '../script/globals.php'     );
        include( '../script/parse_query.php' );
        $lang_dir="../$ptna_lang/";
?>
<html lang="<?php echo $html_lang ?>">

<?php   include '../en/gtfs-compare-strings.inc';
        if ( file_exists($lang_dir.'gtfs-compare-strings.inc') ) {
            include $lang_dir.'gtfs-compare-strings.inc';
        }
        $title=$STR_gtfs_comparison;
        include $lang_dir.'html-head.inc';

        $feed2          = (isset($_GET['feed2'])         && preg_match( '/^[0-9A-Za-z_.-]+$/',$_GET['feed2'])) ? $_GET['feed2']         : '';
        $release_date2  = (isset($_GET['release_date2']) && preg_match( '/^[0-9-]+$/',$_GET['release_date2'])) ? $_GET['release_date2'] : '';
        $route_id2      = isset($_GET['route_id2'])     ? $_GET['route_id2']     : '';
        $trip_id2       = isset($_GET['trip_id2'])      ? $_GET['trip_id2']      : '';
        $shape_id2      = isset($_GET['shape_id2'])     ? $_GET['shape_id2']     : '';

?>

    <body>

      <div id="wrapper">

<?php   include $lang_dir.'header.inc'; ?>

        <main id="main" class="results">

            <h2 id="compare"><?php echo $STR_gtfs_comparison; ?></h2>
            <div class="indent">

                <h3 id="feeds"><?php echo $STR_compare_gtfs_feeds; ?></h3>
                <div class="indent">

                    <?php echo $STR_compare_head_feeds; ?>

                    <form method="get" action="compare-feeds.php">
                        <table id="feeds-table" class="compare">
                            <thead>
                                <tr><th class="gtfs-number"><?php echo $STR_number; ?></th>
                                <th class="gtfs-name">GTFS Feed</th>
                                <th class="gtfs-name">&nbsp;</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr><td class="gtfs-number">1</td>
                                    <td class="gtfs-name"><input type="text" name="feed" value="<?php echo $feed; ?>" maxlength="30" pattern="^[0-9A-Za-z_.-]+$"></td>
                                    <td rowspan="2"><button class="button-create" type="submit"><?php echo preg_replace('/ /','<br />',$STR_compare_feeds); ?></button></td>
                                </tr>
                                <tr><td class="gtfs-number">2</td>
                                    <td class="gtfs-name"><input type="text" name="feed2" value="<?php echo $feed2; ?>" maxlength="30" pattern="^[0-9A-Za-z_.-]+$"></td>
                                </tr>
                            </tbody>
                        </table>
                        <?php if ( $ptna_lang != 'en' ) { echo '<input type="hidden" name="lang" value="' . $ptna_lang . '">'; } ?>
                        <small><?php echo $STR_empty_fields_in; ?></small>
                    </form>
                </div>

                <hr />

                <h3 id="versions"><?php echo $STR_compare_gtfs_versions; ?></h3>
                <div class="indent">

                    <?php echo $STR_compare_head_versions; ?>

                    <form method="get" action="compare-versions.php">
                        <table id="versions-table" class="compare">
                            <thead>
                                <tr><th class="gtfs-number"><?php echo $STR_number; ?></th>
                                    <th class="gtfs-name">GTFS Feed</th>
                                    <th class="gtfs-name"><?php echo $STR_release_date; ?></th>
                                    <th class="gtfs-name">&nbsp;</th>
                                </tr>
                            </thead>
                            <tbody>
                                 <tr><td class="gtfs-number">1</td>
                                    <td class="gtfs-name"><input type="text" name="feed" value="<?php echo $feed; ?>" maxlength="30" pattern="^[0-9A-Za-z_.-]+$"></td>
                                    <td class="gtfs-name"><input type="text" name="release_date" value="<?php echo $release_date; ?>" size="10" maxlength="10" pattern="^((20\d{2}-(0[1-9]|1[012]|[1-9])-(31|30|0[1-9]|[12][0-9]|[1-9]))|long-term|previous|latest)$"></td>
                                    <td rowspan="2"><button class="button-create" type="submit"><?php echo preg_replace('/ /','<br />',$STR_compare_versions); ?></button></td>
                                </tr>
                                <tr><td class="gtfs-number">2</td>
                                    <td class="gtfs-name"><input type="text" name="feed2" value="<?php echo $feed2; ?>" maxlength="30" pattern="^[0-9A-Za-z_.-]+$"></td>
                                    <td class="gtfs-name"><input type="text" name="release_date2" value="<?php echo $release_date2; ?>" size="10" maxlength="10" pattern="^((20\d{2}-(0[1-9]|1[012]|[1-9])-(31|30|0[1-9]|[12][0-9]|[1-9]))|long-term|previous|latest)$"></td>
                                </tr>
                            </tbody>
                        </table>
                        <?php if ( $ptna_lang != 'en' ) { echo '<input type="hidden" name="lang" value="' . $ptna_lang . '">'; } ?>
                        <small><?php echo $STR_release_date_legend; ?></small><br />
                        <small><?php echo $STR_empty_fields_in; ?></small>
                    </form>
                </div>

                <hr />

                <h3 id="routes"><?php echo $STR_compare_gtfs_routes; ?></h3>
                <div class="indent">

                    <?php echo $STR_compare_head_routes; ?>

                    <form method="get" action="compare-routes.php">
                        <table id="routes-table" class="compare">
                            <thead>
                                <tr><th class="gtfs-number"><?php echo $STR_number; ?></th>
                                    <th class="gtfs-name">GTFS Feed</th>
                                    <th class="gtfs-name"><?php echo $STR_release_date; ?></th>
                                    <th class="gtfs-name">Route ID</th>
                                    <th class="gtfs-name">&nbsp;</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr><td class="gtfs-number">1</td>
                                    <td class="gtfs-name"><input type="text" name="feed" value="<?php echo $feed; ?>" maxlength="30" pattern="^[0-9A-Za-z_.-]+$"></td>
                                    <td class="gtfs-name"><input type="text" name="release_date" value="<?php echo $release_date; ?>" size="10" maxlength="10" pattern="^((20\d{2}-(0[1-9]|1[012]|[1-9])-(31|30|0[1-9]|[12][0-9]|[1-9]))|long-term|previous|latest)$"></td>
                                    <td class="gtfs-name"><input type="text" name="route_id" value="<?php echo preg_replace('/"/','&quot;',$route_id); ?>"></td>
                                    <td rowspan="2"><button class="button-create" type="submit"><?php echo preg_replace('/ /','<br />',$STR_compare_routes); ?></button></td>
                                </tr>
                                <tr><td class="gtfs-number">2</td>
                                    <td class="gtfs-name"><input type="text" name="feed2" value="<?php echo $feed2; ?>" maxlength="30" pattern="^[0-9A-Za-z_.-]+$"></td>
                                    <td class="gtfs-name"><input type="text" name="release_date2" value="<?php echo $release_date2; ?>" size="10" maxlength="10" pattern="^((20\d{2}-(0[1-9]|1[012]|[1-9])-(31|30|0[1-9]|[12][0-9]|[1-9]))|long-term|previous|latest)$"></td>
                                    <td class="gtfs-name"><input type="text" name="route_id2" value="<?php echo preg_replace('/"/','&quot;',$route_id2); ?>"></td>
                                </tr>
                            </tbody>
                        </table>
                        <?php if ( $ptna_lang != 'en' ) { echo '<input type="hidden" name="lang" value="' . $ptna_lang . '">'; } ?>
                        <small><?php echo $STR_release_date_legend; ?></small><br />
                        <small><?php echo $STR_empty_fields_in; ?></small>
                    </form>
                </div>

                <hr />

                <h3 id="trips"><?php echo $STR_compare_gtfs_trips; ?></h3>
                <div class="indent">

                    <?php echo $STR_compare_head_trips; ?>

                    <form method="get" action="compare-trips.php">
                        <table id="trips-table" class="compare">
                            <thead>
                                <tr><th class="gtfs-number"><?php echo $STR_number; ?></th>
                                    <th class="gtfs-name">GTFS Feed</th>
                                    <th class="gtfs-name"><?php echo $STR_release_date; ?></th>
                                    <th class="gtfs-name">Trip ID</th>
                                    <th class="gtfs-name">&nbsp;</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr><td class="gtfs-number">1</td>
                                    <td class="gtfs-name"><input type="text" name="feed" value="<?php echo $feed; ?>" maxlength="30" pattern="^[0-9A-Za-z_.-]+$"></td>
                                    <td class="gtfs-name"><input type="text" name="release_date" value="<?php echo $release_date; ?>" size="10" maxlength="10" pattern="^((20\d{2}-(0[1-9]|1[012]|[1-9])-(31|30|0[1-9]|[12][0-9]|[1-9]))|long-term|previous|latest)$"></td>
                                    <td class="gtfs-name"><input type="text" name="trip_id" value="<?php echo preg_replace('/"/','&quot;',$trip_id); ?>"></td>
                                    <td rowspan="2"><button class="button-create" type="submit"><?php echo preg_replace('/ /','<br />',$STR_compare_trips); ?></button></td>
                                </tr>
                                <tr><td class="gtfs-number">2</td>
                                    <td class="gtfs-name"><input type="text" name="feed2" value="<?php echo $feed2; ?>" maxlength="30" pattern="^[0-9A-Za-z_.-]+$"></td>
                                    <td class="gtfs-name"><input type="text" name="release_date2" value="<?php echo $release_date2; ?>" size="10" maxlength="10" pattern="^((20\d{2}-(0[1-9]|1[012]|[1-9])-(31|30|0[1-9]|[12][0-9]|[1-9]))|long-term|previous|latest)$"></td>
                                    <td class="gtfs-name"><input type="text" name="trip_id2" value="<?php echo preg_replace('/"/','&quot;',$trip_id2); ?>"></td>
                                </tr>
                            </tbody>
                        </table>
                        <?php if ( $ptna_lang != 'en' ) { echo '<input type="hidden" name="lang" value="' . $ptna_lang . '">'; } ?>
                        <small><?php echo $STR_release_date_legend; ?></small><br />
                        <small><?php echo $STR_empty_fields_in; ?></small>
                    </form>
                </div>

                <hr />

                <h3 id="shapes"><?php echo $STR_compare_gtfs_shapes; ?></h3>
                <div class="indent">

                    <?php echo $STR_compare_head_shapes; ?>

                    <form method="get" action="compare-shapes.php">
                        <table id="shapes-table" class="compare">
                            <thead>
                                <tr><th class="gtfs-number"><?php echo $STR_number; ?></th>
                                    <th class="gtfs-name">GTFS Feed</th>
                                    <th class="gtfs-name"><?php echo $STR_release_date; ?></th>
                                    <th class="gtfs-name">Shape ID</th>
                                    <th class="gtfs-name">&nbsp;</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr><td class="gtfs-number">1</td>
                                    <td class="gtfs-name"><input type="text" name="feed" value="<?php echo $feed; ?>" maxlength="30" pattern="^[0-9A-Za-z_.-]+$"></td>
                                    <td class="gtfs-name"><input type="text" name="release_date" value="<?php echo $release_date; ?>" size="10" maxlength="10" pattern="^((20\d{2}-(0[1-9]|1[012]|[1-9])-(31|30|0[1-9]|[12][0-9]|[1-9]))|long-term|previous|latest)$"></td>
                                    <td class="gtfs-name"><input type="text" name="shape_id" value="<?php echo preg_replace('/"/','&quot;',$shape_id); ?>"></td>
                                    <td rowspan="2"><button class="button-create" type="submit"><?php echo preg_replace('/ /','<br />',$STR_compare_shapes); ?></button></td>
                                </tr>
                                <tr><td class="gtfs-number">2</td>
                                    <td class="gtfs-name"><input type="text" name="feed2" value="<?php echo $feed2; ?>" maxlength="30" pattern="^[0-9A-Za-z_.-]+$"></td>
                                    <td class="gtfs-name"><input type="text" name="release_date2" value="<?php echo $release_date2; ?>" size="10" maxlength="10" pattern="^((20\d{2}-(0[1-9]|1[012]|[1-9])-(31|30|0[1-9]|[12][0-9]|[1-9]))|long-term|previous|latest)$"></td>
                                    <td class="gtfs-name"><input type="text" name="shape_id2" value="<?php echo preg_replace('/"/','&quot;',$shape_id2); ?>"></td>
                                </tr>
                            </tbody>
                        </table>
                        <?php if ( $ptna_lang != 'en' ) { echo '<input type="hidden" name="lang" value="' . $ptna_lang . '">'; } ?>
                        <small><?php echo $STR_release_date_legend; ?></small><br />
                        <small><?php echo $STR_empty_fields_in; ?></small>
                    </form>
                </div>

            </div>

        </main> <!-- main -->

        <hr />

<?php include $lang_dir.'gtfs-footer.inc' ?>

      </div> <!-- wrapper -->
    </body>
</html>
