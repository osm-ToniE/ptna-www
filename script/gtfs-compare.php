<?php

    if ( $_GET['feed2'] ) {
        $feed2          = $_GET['feed2'];
    } else {
        $feed2          = $_GET['feed'];
    }
    if ( $_GET['release_date2'] ) {
        $release_date2  = $_GET['release_date2'];
    } else {
        $release_date2  = $_GET['release_date'];
    }
    if ( $_GET['route_id2'] ) {
        $route_id2      = $_GET['route_id2'];
    } else {
        $route_id2      = $_GET['route_id'];
    }
    if ( $_GET['trip_id2'] ) {
        $trip_id2       = $_GET['trip_id2'];
    } else {
        $trip_id2       = $_GET['trip_id'];
    }
    if ( $_GET['shape_id2'] ) {
        $shape_id2      = $_GET['shape_id2'];
    } else {
        $shape_id2      = $_GET['shape_id'];
    }


    #
    # called from compare-feeds.php
    #

    function CreateCompareFeedsTableHead( $button_text, $feed, $feed2 ) {
        global $STR_invalid_input_data;

        $indent = '                            ';
        $feedDB1 = FindGtfsSqliteDb( $feed, '' );
        $feedDB2 = FindGtfsSqliteDb( $feed2, '' );
        if ( $feedDB1 && $feedDB2 ) {
            if ( $feed == $feed2 ) {
                echo $indent . '<tr><th colspan="3" class="gtfs-name"><button class="button-create" type="submit">' . htmlspecialchars($button_text) . '</button></th</tr>' . "\n";
                echo $indent . '<tr><th colspan="3" class="gtfs-name"><input type="hidden" name="feed"  value="' . $feed  . '">'  . $feed . '</th>' . "\n";
                echo $indent . '    <th style="border-left-width: 1px;">feed_publisher_name</th>' . "\n";
                echo $indent . '    <th style="border-left-width: 1px;">feed_start_date</th>' . "\n";
                echo $indent . '    <th style="border-left-width: 1px;">feed_end_date</th>' . "\n";
                echo $indent . '    <th style="border-left-width: 1px;">feed_version</th>' . "\n";
                echo $indent . '</tr>' . "\n";
            } else {
                echo $indent . '<tr><th colspan="4" class="gtfs-name"><button class="button-create" type="submit">' . htmlspecialchars($button_text) . '</button></th</tr>' . "\n";
                echo $indent . '<tr><th colspan="2" class="gtfs-name"><input type="hidden" name="feed"  value="' . $feed  . '">' . $feed  . '</th>' . "\n";
                echo $indent . '    <th colspan="2" class="gtfs-name"><input type="hidden" name="feed2" value="' . $feed2 . '">' . $feed2 . '</th>' . "\n";
                echo $indent . '</tr>' . "\n";
            }
        } else {
            if ( !$feedDB1 )                    { echo "<p>" . htmlspecialchars($STR_invalid_input_data) . ": 'feed'  = '" . htmlspecialchars($feed)  . "'</p>\n"; }
            if ( !$feedDB2 && $feed != $feed2 ) { echo "<p>" . htmlspecialchars($STR_invalid_input_data) . ": 'feed2' = '" . htmlspecialchars($feed2) . "'</p>\n"; }
        }
    }


    function CreateCompareFeedsTableBody( $feed, $feed2 ) {
        $indent = '                            ';

        $release_dates  = array();

        $feedDB1 = FindGtfsSqliteDb( $feed, '' );
        $feedDB2 = FindGtfsSqliteDb( $feed2, '' );

        if ( $feedDB1 && $feedDB2 ) {
            if ( $feed && preg_match("/^[a-zA-Z0-9_.-]+$/", $feed) ) {
                $release_dates = GetGtfsFeedReleaseDatesNonEmpty( $feed );
                rsort( $release_dates );
            }

            if ( $feed == $feed2 ) {
                for ( $i = 0; $i < count($release_dates) ; $i++ ) {
                    $release_date = $release_dates[$i];
                    echo $indent . "<tr>\n";
                    if ( $i == 0 ) {
                        echo $indent . '    <td><input type="radio" name="release_date"  value="' . $release_date . '" checked="checked"></td>' . "\n";
                        if ( count($release_dates) == 1 ) {
                            echo $indent . '    <td><input type="radio" name="release_date2" value="' . $release_date . '" checked="checked"></td>' . "\n";
                        } else {
                            echo $indent . '    <td><input type="radio" name="release_date2" value="' . $release_date . '"></td>' . "\n";
                        }
                    } elseif ( $i == 1 ) {
                        echo $indent . '    <td><input type="radio" name="release_date"  value="' . $release_date . '"></td>' . "\n";
                        echo $indent . '    <td><input type="radio" name="release_date2" value="' . $release_date . '" checked="checked"></td>' . "\n";
                    } else {
                        echo $indent . '    <td><input type="radio" name="release_date"  value="' . $release_date . '"></td>' . "\n";
                        echo $indent . '    <td><input type="radio" name="release_date2" value="' . $release_date . '"></td>' . "\n";
                    }
                    echo $indent . '    <td class="gtfs-name">' . $release_date . '</td>' . "\n";
                    $feed_info = GetFeedDetails( $feed, $release_date );
                    echo $indent . '    <td style="border-left-width: 1px;">' . htmlspecialchars($feed_info['feed_publisher_name']) . '</td>' . "\n";
                    echo $indent . '    <td style="border-left-width: 1px;">' . htmlspecialchars($feed_info['feed_start_date']) . '</td>' . "\n";
                    echo $indent . '    <td style="border-left-width: 1px;">' . htmlspecialchars($feed_info['feed_end_date']) . '</td>' . "\n";
                    echo $indent . '    <td style="border-left-width: 1px;">' . htmlspecialchars($feed_info['feed_version']) . '</td>' . "\n";
                    echo $indent . "</tr>\n";
                }
            } else {
                $release_dates2  = array();

                if ( $feed2 && preg_match("/^[a-zA-Z0-9_.-]+$/", $feed2) ) {
                    $release_dates2 = GetGtfsFeedReleaseDatesNonEmpty( $feed2 );
                    rsort( $release_dates2 );
                }

                $count1 = count($release_dates);
                $count2 = count($release_dates2);
                $maxcount = ($count1 > $count2) ? $count1 : $count2;

                for ( $i = 0; $i < $maxcount ; $i++ ) {
                    if ( $i == 0 ) {
                        $checked = ' checked="checked"';
                    } else {
                        $checked = '';
                    }
                    echo $indent . "<tr>\n";
                    $release_date1 = $release_dates[$i];
                    $release_date2 = $release_dates2[$i];
                    if ( $release_date1 ) {
                        echo $indent . '    <td><input type="radio" name="release_date"  value="' . $release_date1 . '"' . $checked . '></td>' . "\n";
                        echo $indent . '    <td class="gtfs-name">' . $release_date1 . '</td>' . "\n";
                    } else {
                        echo $indent . "    <td>&nbsp;</td>\n";
                        echo $indent . "    <td>&nbsp;</td>\n";
                    }
                    if ( $release_date2 ) {
                        echo $indent . '    <td><input type="radio" name="release_date2" value="' . $release_date2 . '"' . $checked . '></td>' . "\n";
                        echo $indent . '    <td class="gtfs-name">' . $release_date2 . '</td>' . "\n";
                    } else {
                        echo $indent . "    <td>&nbsp;</td>\n";
                        echo $indent . "    <td>&nbsp;</td>\n";
                    }
                    echo $indent . "</tr>\n";
                }
            }
        }
    }

    #
    # called from compare-versions.php
    #

    function CreateCompareVersionsTableHead( $button_text, $feed, $feed2, $release_date, $release_date2 ) {
        global $STR_invalid_input_data;

        $indent = '                            ';
        $feedDB1 = FindGtfsSqliteDb( $feed,  $release_date  );
        $feedDB2 = FindGtfsSqliteDb( $feed2, $release_date2 );
        if ( $feedDB1 && $feedDB2 ) {
            echo $indent . '<tr><th colspan="4" class="gtfs-name"><button class="button-create" type="submit">' . htmlspecialchars($button_text) . '</button></th</tr>' . "\n";
            echo $indent . '<tr><th colspan="2" class="gtfs-name"><input type="hidden" name="feed"          value="' . $feed          . '">'  . $feed;
            echo $indent . '                                      <input type="hidden" name="release_date"  value="' . $release_date  . '"> ' . $release_date  . '</th>' . "\n";;
            echo $indent . '    <th colspan="2" class="gtfs-name" style="border-left-width: 1px;"><input type="hidden" name="feed2"         value="' . $feed2         . '">'  . $feed2;
            echo $indent . '                                                                      <input type="hidden" name="release_date2" value="' . $release_date2 . '"> ' . $release_date2 . '</th>' . "\n";;
            echo $indent . '</tr>' . "\n";
        } else {
            if ( !$feedDB1 )                                                            { echo "<p>" . htmlspecialchars($STR_invalid_input_data) . ": 'feed'  = '" . htmlspecialchars($feed)  . "' + 'release_date'   = '" . htmlspecialchars($release_date)   . "'</p>\n"; }
            if ( !$feedDB2 && ($feed != $feed2 || $release_date != $release_date2) )    { echo "<p>" . htmlspecialchars($STR_invalid_input_data) . ": 'feed2' = '" . htmlspecialchars($feed2) . "' + 'release_date2'  = '" . htmlspecialchars($release_date2)  . "'</p>\n"; }
        }
    }

    function CreateCompareVersionsTableBody( $feed, $feed2, $release_date, $release_date2 ) {
        $indent = '                            ';
        $feedDB1 = FindGtfsSqliteDb( $feed,  $release_date  );
        $feedDB2 = FindGtfsSqliteDb( $feed2, $release_date2 );
        if ( $feedDB1 && $feedDB2 ) {
            $feed1_routes = GetGtfsRoutes($feedDB1);
            $maxcount     = count($feed1_routes);
            if ( $feedDB1 == $feedDB2 ) {
                $feed2_routes = $feed1_routes;
            } else {
                $feed2_routes = GetGtfsRoutes($feedDB2);
                $maxcount = count($feed2_routes) > $maxcount ? count($feed2_routes) : $maxcount;
            }
            if ( $_GET['type'] == 'd' ) {
                echo $indent . "<tr>\n";
                echo $indent . '   <td colspan="2"><select name="route_id">' . "\n";
                for ( $i = 0; $i < count($feed1_routes); $i++ ) {
                    echo $indent . '       <option value="' . htmlspecialchars($feed1_routes[$i]['route_id']) . '">';
                    echo $indent .         htmlspecialchars($feed1_routes[$i]['route_short_name']) . ' (' . htmlspecialchars($feed1_routes[$i]['route_id']) . ')</option>' . "\n";
                }
                echo $indent . "   </select></td>\n";
                echo $indent . '   <td colspan="2"><select name="route_id2">' . "\n";
                for ( $i = 0; $i < count($feed1_routes); $i++ ) {
                    echo $indent . '       <option value="' . htmlspecialchars($feed2_routes[$i]['route_id']) . '">';
                    echo $indent .         htmlspecialchars($feed2_routes[$i]['route_short_name']) . ' (' . htmlspecialchars($feed2_routes[$i]['route_id']) . ')</option>' . "\n";
                }
                echo $indent . "   </select></td>\n";
                echo $indent . "</tr>\n";
            } else {
                for ( $i = 0; $i < $maxcount; $i++ ) {
                    if ( $i == 0 ) {
                        $checked = ' checked="checked"';
                    } else {
                        $checked = '';
                    }
                    echo $indent . "<tr>\n";
                    if ( $feed1_routes[$i] ) {
                        echo $indent . '    <td><input type="radio" name="route_id"  value="' . htmlspecialchars($feed1_routes[$i]['route_id']) . '"' . $checked . '></td>' . "\n";
                        echo $indent . '    <td class="gtfs-name">' . htmlspecialchars($feed1_routes[$i]['route_short_name']) . ' (' . htmlspecialchars($feed1_routes[$i]['route_id']) . ')</td>' . "\n";
                    } else {
                        echo $indent . "    <td>&nbsp;</td>\n";
                        echo $indent . "    <td>&nbsp;</td>\n";
                    }
                    if ( $feed2_routes[$i] ) {
                        echo $indent . '    <td style="border-left-width: 1px;"><input type="radio" name="route_id2"  value="' . htmlspecialchars($feed2_routes[$i]['route_id']) . '"' . $checked . '></td>' . "\n";
                        echo $indent . '    <td class="gtfs-name">' . htmlspecialchars($feed2_routes[$i]['route_short_name']) . ' (' . htmlspecialchars($feed2_routes[$i]['route_id']) . ')</td>' . "\n";
                    } else {
                        echo $indent . '    <td style="border-left-width: 1px;">&nbsp;</td>' . "\n";
                        echo $indent . "    <td>&nbsp;</td>\n";
                    }
                    echo $indent . "</tr>\n";
                }
            }
        }
    }


    #
    # called from compare-routes.php
    #

    function CreateCompareRoutesTableHead( $button_text, $feed, $feed2, $release_date, $release_date2, $route_id, $route_id2 ) {
        global $STR_invalid_input_data;

        $indent = '                            ';
        $feedDB1 = FindGtfsSqliteDb( $feed,  $release_date  );
        $feedDB2 = FindGtfsSqliteDb( $feed2, $release_date2 );
        if ( $feedDB1 && $feedDB2 ) {
            ;
        } else {
            if ( !$feedDB1 )                                                            { echo "<p>" . htmlspecialchars($STR_invalid_input_data) . ": 'feed'  = '" . htmlspecialchars($feed)  . "' + 'release_date'   = '" . htmlspecialchars($release_date)   . "'</p>\n"; }
            if ( !$feedDB2 && ($feed != $feed2 || $release_date != $release_date2) )    { echo "<p>" . htmlspecialchars($STR_invalid_input_data) . ": 'feed2' = '" . htmlspecialchars($feed2) . "' + 'release_date2'  = '" . htmlspecialchars($release_date2)  . "'</p>\n"; }
        }
    }

    function CreateCompareRoutesTableBody( $feed, $feed2, $release_date, $release_date2, $route_id, $route_id2 ) {
        $indent = '                            ';
        $feedDB1 = FindGtfsSqliteDb( $feed,  $release_date  );
        $feedDB2 = FindGtfsSqliteDb( $feed2, $release_date2 );
        if ( $feedDB1 && $feedDB2 ) {
            ;
        }
    }


    #
    # called from compare-trips.php
    #

    function CreateCompareTripsTableHead( $button_text, $feed, $feed2, $release_date, $release_date2, $trip_id, $trip_id2 ) {
        global $STR_invalid_input_data;

        $indent = '                            ';
        $feedDB1 = FindGtfsSqliteDb( $feed,  $release_date  );
        $feedDB2 = FindGtfsSqliteDb( $feed2, $release_date2 );
        if ( $feedDB1 && $feedDB2 ) {
            ;
        } else {
            if ( !$feedDB1 )                                                            { echo "<p>" . htmlspecialchars($STR_invalid_input_data) . ": 'feed'  = '" . htmlspecialchars($feed)  . "' + 'release_date'   = '" . htmlspecialchars($release_date)   . "'</p>\n"; }
            if ( !$feedDB2 && ($feed != $feed2 || $release_date != $release_date2) )    { echo "<p>" . htmlspecialchars($STR_invalid_input_data) . ": 'feed2' = '" . htmlspecialchars($feed2) . "' + 'release_date2'  = '" . htmlspecialchars($release_date2)  . "'</p>\n"; }
        }
    }

    function CreateCompareTripsTableBody( $feed, $feed2, $release_date, $release_date2, $trip_id, $trip_id2 ) {
        $indent = '                            ';
        $feedDB1 = FindGtfsSqliteDb( $feed,  $release_date  );
        $feedDB2 = FindGtfsSqliteDb( $feed2, $release_date2 );
        if ( $feedDB1 && $feedDB2 ) {
            ;
        }
    }


    #
    # called from compare-shapes.php
    #

    function CreateCompareShapesTableHead( $feed, $feed2, $release_date, $release_date2, $shape_id, $shape_id2 ) {
        global $STR_invalid_input_data;

        $indent = '                            ';
        $feedDB1 = FindGtfsSqliteDb( $feed,  $release_date  );
        $feedDB2 = FindGtfsSqliteDb( $feed2, $release_date2 );
        if ( $feedDB1 && $feedDB2 ) {
            ;
        } else {
            if ( !$feedDB1 )                                                            { echo "<p>" . htmlspecialchars($STR_invalid_input_data) . ": 'feed'  = '" . htmlspecialchars($feed)  . "' + 'release_date'   = '" . htmlspecialchars($release_date)   . "'</p>\n"; }
            if ( !$feedDB2 && ($feed != $feed2 || $release_date != $release_date2) )    { echo "<p>" . htmlspecialchars($STR_invalid_input_data) . ": 'feed2' = '" . htmlspecialchars($feed2) . "' + 'release_date2'  = '" . htmlspecialchars($release_date2)  . "'</p>\n"; }
        }
    }

    function CreateCompareShapesTableBody( $feed, $feed2, $release_date, $release_date2, $shape_id, $shape_id2 ) {
        $indent = '                            ';
        $feedDB1 = FindGtfsSqliteDb( $feed,  $release_date  );
        $feedDB2 = FindGtfsSqliteDb( $feed2, $release_date2 );
        if ( $feedDB1 && $feedDB2 ) {
            ;
        }
    }


    function GetGtfsRoutes( $SqliteDb ) {

        $return_array = array();

        if ( $SqliteDb != '' ) {

            try {

                $db         = new SQLite3( $SqliteDb );

                $sql        = "SELECT DISTINCT    *
                               FROM               routes
                               ORDER BY CASE WHEN route_short_name GLOB '[^0-9]*' THEN route_short_name ELSE CAST(route_short_name AS INTEGER) END;";

                $outerresult = $db->query( $sql );

                while ( $outerrow=$outerresult->fetchArray(SQLITE3_ASSOC) ) {
                    array_push( $return_array, array( 'route_id' => $outerrow['route_id'], 'route_short_name' => $outerrow['route_short_name'] ) );
                    #echo "<!-- 'route_id' => " . $outerrow['route_id'] . " 'route_short_name' => " . $outerrow['route_short_name'] . "-->\n";
                }
                $db->close();

            } catch ( Exception $ex ) {
                echo "CreateGtfsRoutesEntry(): Sqlite DB could not be opened: " . htmlspecialchars($ex->getMessage()) . "\n";
            }
        }

        return $return_array;
    }

?>
