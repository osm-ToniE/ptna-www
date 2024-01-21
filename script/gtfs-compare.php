<?php

    if ( isset($_GET['feed2']) ) {
        $feed2          = $_GET['feed2'];
    } else {
        $feed2          = isset($_GET['feed']) ? $_GET['feed'] : '';
    }
    if ( isset($_GET['release_date2']) ) {
        $release_date2  = $_GET['release_date2'];
    } else {
        $release_date2  = '';  # leading to 'latest'
    }
    if ( isset($_GET['route_id2']) ) {
        $route_id2      = $_GET['route_id2'];
    } else {
        $route_id2      = isset($_GET['route_id']) ? $_GET['route_id'] : '';
    }
    if ( isset($_GET['trip_id2']) ) {
        $trip_id2       = $_GET['trip_id2'];
    } else {
        $trip_id2       = isset($_GET['trip_id']) ? $_GET['trip_id'] : '';
    }
    if ( isset($_GET['shape_id2']) ) {
        $shape_id2      = $_GET['shape_id2'];
    } else {
        $shape_id2      = isset($_GET['shape_id']) ? $_GET['shape_id'] : '';
    }
    if ( isset($_GET['relation_id']) ) {
        $osm_relation    = $_GET['relation_id'];
    } elseif  ( isset($_GET['relation']) ) {
        $osm_relation    = $_GET['relation'];
    } else {
        $osm_relation    = '';
    }


    #
    # called from compare-feeds.php
    #

    function CreateCompareFeedsTableHead( $feed, $feed2 ) {
        global $STR_compare_versions;
        global $STR_invalid_input_data;

        $indent = '                            ';
        $feedDB1 = FindGtfsSqliteDb( $feed, '' );
        $feedDB2 = FindGtfsSqliteDb( $feed2, '' );
        if ( $feedDB1 && $feedDB2 ) {
            if ( $feed == $feed2 ) {
                echo $indent . '<tr><th colspan="7" class="gtfs-name"><button class="button-create" type="submit">' . htmlspecialchars($STR_compare_versions) . '</button></th>' . "\n";
#                echo $indent . '    <th colspan="4" class="gtfs-name"><input type="checkbox" name="type" value="d">Drop down list</th>' . "\n";
                echo $indent . '</tr>' . "\n";
                echo $indent . '<tr><th colspan="3" class="gtfs-name"><input type="hidden" name="feed"  value="' . $feed  . '">'  . $feed . '</th>' . "\n";
                echo $indent . '    <th style="border-left-width: 1px">feed_publisher_name</th>' . "\n";
                echo $indent . '    <th style="border-left-width: 1px">feed_start_date</th>' . "\n";
                echo $indent . '    <th style="border-left-width: 1px">feed_end_date</th>' . "\n";
                echo $indent . '    <th style="border-left-width: 1px">feed_version</th>' . "\n";
                echo $indent . '</tr>' . "\n";
            } else {
                echo $indent . '<tr><th colspan="7" class="gtfs-name"><button class="button-create" type="submit">' . htmlspecialchars($STR_compare_versions) . '</button></th>' . "\n";
#                echo $indent . '    <th colspan="4" class="gtfs-name"><input type="checkbox" name="type" value="d">Drop down liste</th>' . "\n";
                echo $indent . '</tr>' . "\n";
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
            if ( $feed && preg_match("/^[0-9A-Za-z_.-]+$/", $feed) ) {
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
                    $info = isset($feed_info['feed_publisher_name']) ? htmlspecialchars($feed_info['feed_publisher_name']) : '&nbsp;';
                    echo $indent . '    <td style="border-left-width: 1px;">' . $info . '</td>' . "\n";
                    $info = isset($feed_info['feed_start_date'])     ? htmlspecialchars($feed_info['feed_start_date']) : '&nbsp;';
                    echo $indent . '    <td style="border-left-width: 1px;">' . $info . '</td>' . "\n";
                    $info = isset($feed_info['feed_end_date'])       ? htmlspecialchars($feed_info['feed_end_date']) : '&nbsp;';
                    echo $indent . '    <td style="border-left-width: 1px;">' . $info . '</td>' . "\n";
                    $info = isset($feed_info['feed_version'])        ? htmlspecialchars($feed_info['feed_version']) : '&nbsp;';
                    echo $indent . '    <td style="border-left-width: 1px;">' . $info . '</td>' . "\n";
                    echo $indent . "</tr>\n";
                }
            } else {
                $release_dates2  = array();

                if ( $feed2 && preg_match("/^[0-9A-Za-z_.-]+$/", $feed2) ) {
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

    function CreateCompareVersionsTableHead( $feed, $feed2, $release_date, $release_date2 ) {
        global $STR_compare_routes;
        global $STR_invalid_input_data;

        $start_time = gettimeofday(true);
        $indent = '                            ';
        $feedDB1 = FindGtfsSqliteDb( $feed,  $release_date  );
        $feedDB2 = FindGtfsSqliteDb( $feed2, $release_date2 );
        $release_date_display  = $release_date  ? $release_date  : 'latest';
        $release_date2_display = $release_date2 ? $release_date2 : 'latest';
        if ( $feedDB1 && $feedDB2 ) {
            if ( isset($_GET['type']) && $_GET['type'] == 'd' ) {
                echo $indent . '<tr><th colspan="3" class="gtfs-name"><button class="button-create" type="submit">' . htmlspecialchars($STR_compare_routes) . '</button></th</tr>' . "\n";
                echo $indent . '<tr><th class="gtfs-name">feed</th>' . "\n";
                echo $indent . '    <th class="gtfs-name">release_date</th>' . "\n";
                echo $indent . '    <th class="gtfs-name">Line (type, route_id, route_long_name)</th>'   . "\n";
                echo $indent . '</tr>' . "\n";
           } else {
                if ( $feed == $feed2 ) {
                    echo $indent . '<tr><th colspan="2" class="gtfs-name" style="border-left-width: 2px"><input type="hidden" name="feed"  value="' . $feed  . '"><input type="hidden" name="feed2" value="' . $feed2 . '">Release Date</th>' . "\n";
                } else {
                    echo $indent . '<tr><th colspan="1" class="gtfs-name" style="border-left-width: 2px"><input type="hidden" name="feed"  value="' . $feed  . '">'  . $feed  . "</th>\n";
                    echo $indent . '    <th colspan="1" class="gtfs-name" style="border-left-width: 2px"><input type="hidden" name="feed2" value="' . $feed2 . '">'  . $feed2 . "</th>\n";
                }
                echo $indent . '    <th colspan="3" class="gtfs-name" style="border-left-width: 2px">Route</th>' . "\n";
                echo $indent . '    <th colspan="4" class="gtfs-name" style="border-left-width: 2px">Number of</th>' . "\n";
                echo $indent . '    <th colspan="3" class="gtfs-name" style="border-left-width: 2px">Stop sequence indicator by</th>' . "\n";
                echo $indent . '    <th colspan="2" class="gtfs-name" style="border-left-width: 2px">Dates</th>' . "\n";
                echo $indent . '    <th class="gtfs-name" style="border-left-width: 2px">&nbsp;</th>' . "\n";
                echo $indent . '    <th class="gtfs-name" style="border-left-width: 2px">&nbsp;</th>' . "\n";
                echo $indent . '</tr>' . "\n";
                echo $indent . '<tr><th class="gtfs-name" style="border-left-width: 2px;"><input type="hidden" name="release_date"  value="' . $release_date  . '">' . $release_date_display  . '</th>' . "\n";
                echo $indent . '    <th class="gtfs-name" style="border-left-width: 2px;"><input type="hidden" name="release_date2" value="' . $release_date2 . '">' . $release_date2_display . '</th>' . "\n";
                echo $indent . '    <th class="gtfs-name" style="border-left-width: 2px;">route_short_name</th>' . "\n";
                echo $indent . '    <th class="gtfs-name">route_type</th>' . "\n";
                echo $indent . '    <th class="gtfs-name">route_id</th>' . "\n";
                echo $indent . '    <th class="gtfs-name" style="border-left-width: 2px;">Variants</th>' . "\n";
                echo $indent . '    <th class="gtfs-name" style="border-left-width: 2px;">Stops</th>' . "\n";
                echo $indent . '    <th class="gtfs-name" style="border-left-width: 2px;">stop_id</th>' . "\n";
                echo $indent . '    <th class="gtfs-name" style="border-left-width: 2px;">stop_name</th>' . "\n";
                echo $indent . '    <th class="gtfs-name" style="border-left-width: 2px;">stop_id</th>' . "\n";
                echo $indent . '    <th class="gtfs-name" style="border-left-width: 2px;">stop_name</th>' . "\n";
                echo $indent . '    <th class="gtfs-name" style="border-left-width: 2px;">stop_lat / stop_lon</th>' . "\n";
                echo $indent . '    <th class="gtfs-name" style="border-left-width: 2px;">Start</th>' . "\n";
                echo $indent . '    <th class="gtfs-name">End</th>' . "\n";
                echo $indent . '    <th class="gtfs-name" style="border-left-width: 2px;">agency_name</th>' . "\n";
                echo $indent . '    <th class="gtfs-name" style="border-left-width: 2px;">route_long_name</th>' . "\n";
                echo $indent . '</tr>' . "\n";
            }
        } else {
            if ( !$feedDB1 )                                                            { echo "<p>" . htmlspecialchars($STR_invalid_input_data) . ": 'feed'  = '" . htmlspecialchars($feed)  . "' + 'release_date'   = '" . htmlspecialchars($release_date)   . "'</p>\n"; }
            if ( !$feedDB2 && ($feed != $feed2 || $release_date != $release_date2) )    { echo "<p>" . htmlspecialchars($STR_invalid_input_data) . ": 'feed2' = '" . htmlspecialchars($feed2) . "' + 'release_date2'  = '" . htmlspecialchars($release_date2)  . "'</p>\n"; }
        }
        $stop_time = gettimeofday(true);
        return $stop_time - $start_time;
    }

    function CreateCompareVersionsTableBody( $feed, $feed2, $release_date, $release_date2 ) {
        $start_time = gettimeofday(true);
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
            if ( isset($_GET['type']) && $_GET['type'] == 'd' ) {
                echo $indent . "<tr>\n";
                echo $indent . '   <td><input type="hidden" name="feed"         value="' . $feed .          '">'  . $feed         . "</td>\n";
                echo $indent . '   <td><input type="hidden" name="release_date" value="' . $release_date  . '"> ' . $release_date . "</td>\n";
                echo $indent . '   <td><select name="route_id">' . "\n";
                for ( $i = 0; $i < count($feed1_routes); $i++ ) {
                    echo $indent . '       <option value="' . htmlspecialchars($feed1_routes[$i]['route_id']) . '">';
                    echo htmlspecialchars($feed1_routes[$i]['route_short_name']) . ' (' . htmlspecialchars(RouteType2OsmRoute($feed1_routes[$i]['route_type'])) . ', ' . htmlspecialchars($feed1_routes[$i]['route_id']) . ', ' . htmlspecialchars($feed1_routes[$i]['route_long_name']) . ')</option>' . "\n";
                }
                echo $indent . "   </select></td>\n";
                echo $indent . "</tr>\n";
                echo $indent . "<tr>\n";
                echo $indent . '   <td><input type="hidden" name="feed2"         value="' . $feed2 .          '">'  . $feed2         . "</td>\n";
                echo $indent . '   <td><input type="hidden" name="release_date2" value="' . $release_date2  . '"> ' . $release_date2 . "</td>\n";
                echo $indent . '   <td><select name="route_id2">' . "\n";
                for ( $i = 0; $i < count($feed2_routes); $i++ ) {
                    echo $indent . '       <option value="' . htmlspecialchars($feed2_routes[$i]['route_id']) . '">';
                    echo htmlspecialchars($feed2_routes[$i]['route_short_name']) . ' (' . htmlspecialchars(RouteType2OsmRoute($feed2_routes[$i]['route_type'])) . ', ' . htmlspecialchars($feed2_routes[$i]['route_id']) . ', ' . htmlspecialchars($feed2_routes[$i]['route_long_name']) . ')</option>' . "\n";
                }
                echo $indent . "   </select></td>\n";
                echo $indent . "</tr>\n";
            } else {
                $left  = 0;
                $right = 0;
                while ( (isset($feed1_routes[$left]) && $feed1_routes[$left]) || (isset($feed2_routes[$right]) && $feed2_routes[$right]) ) {
                    if ( $left == 0 ) {
                        $leftchecked = ' checked="checked"';
                    } else {
                        $leftchecked = '';
                    }
                    if ( $right == 0 ) {
                        $rightchecked = ' checked="checked"';
                    } else {
                        $rightchecked = '';
                    }
                    if ( isset($feed1_routes[$left]) && $feed1_routes[$left] && isset($feed2_routes[$right]) && $feed2_routes[$right] ) {
                        if ( $feed1_routes[$left]['sort_key'] == $feed2_routes[$right]['sort_key'] ) {
                            if ( $feed1_routes[$left]['number_of_variants']          != $feed2_routes[$right]['number_of_variants']          ||
                                 $feed1_routes[$left]['number_of_stops']             != $feed2_routes[$right]['number_of_stops']             ||
                                 $feed1_routes[$left]['number_of_unique_stopids']    != $feed2_routes[$right]['number_of_unique_stopids']    ||
                                 $feed1_routes[$left]['number_of_unique_stopnames']  != $feed2_routes[$right]['number_of_unique_stopnames']  ||
                                 $feed1_routes[$left]['md5_over_stopid_sequences']   != $feed2_routes[$right]['md5_over_stopid_sequences']   ||
                                 $feed1_routes[$left]['md5_over_stopname_sequences'] != $feed2_routes[$right]['md5_over_stopname_sequences'] ||
                                 $feed1_routes[$left]['md5_over_stoppos_sequences']  != $feed2_routes[$right]['md5_over_stoppos_sequences']     ) {
                                echo $indent . "<tr>\n";
                            } else{
                                echo $indent . '<tr hideable="yes">'."\n";
                            }
                            echo $indent . '    <td style="border-left-width: 2px;"><input type="radio" name="route_id"  value="' . htmlspecialchars($feed1_routes[$left]['route_id']) . '"' . $leftchecked . "></td>\n";
                            echo $indent . '    <td style="border-left-width: 2px;"><input type="radio" name="route_id2" value="' . htmlspecialchars($feed2_routes[$right]['route_id']) . '"' . $rightchecked . "></td>\n";
                            echo $indent . '    <td style="border-left-width: 2px;" class="gtfs-name">' . htmlspecialchars($feed2_routes[$right]['route_short_name'])                           . "</td>\n";
                            echo $indent . '    <td class="gtfs-name">' . htmlspecialchars(RouteType2String($feed2_routes[$right]['route_type']))       . "</td>\n";
                            echo $indent . '    <td class="gtfs-name">' . htmlspecialchars($feed2_routes[$right]['route_id'])                           . "</td>\n";
                            if ( $feed1_routes[$left]['number_of_variants'] == $feed2_routes[$right]['number_of_variants'] ) {
                                echo $indent . '    <td class="gtfs-name" style="border-left-width: 2px;">' . htmlspecialchars($feed1_routes[$left]['number_of_variants']) . "</td>\n";
                            } else {
                                echo $indent . '    <td class="gtfs-name" style="background-color: orange; border-left-width: 2px;">' . htmlspecialchars($feed1_routes[$left]['number_of_variants']) . " vs " .  htmlspecialchars($feed2_routes[$right]['number_of_variants']) . "</td>\n";
                            }
                            if ( $feed1_routes[$left]['number_of_stops'] == $feed2_routes[$right]['number_of_stops'] ) {
                                echo $indent . '    <td class="gtfs-name" style="border-left-width: 2px;">' . htmlspecialchars($feed1_routes[$left]['number_of_stops']) . "</td>\n";
                            } else {
                                echo $indent . '    <td class="gtfs-name" style="background-color: orange; border-left-width: 2px;">' . htmlspecialchars($feed1_routes[$left]['number_of_stops']) . " vs " .  htmlspecialchars($feed2_routes[$right]['number_of_stops']) . "</td>\n";
                            }
                            if ( $feed1_routes[$left]['number_of_unique_stopids'] == $feed2_routes[$right]['number_of_unique_stopids'] ) {
                                echo $indent . '    <td class="gtfs-name" style="border-left-width: 2px;">' . htmlspecialchars($feed1_routes[$left]['number_of_unique_stopids']) . "</td>\n";
                            } else {
                                echo $indent . '    <td class="gtfs-name" style="background-color: orange; border-left-width: 2px;">' . htmlspecialchars($feed1_routes[$left]['number_of_unique_stopids']) . " vs " .  htmlspecialchars($feed2_routes[$right]['number_of_unique_stopids']) . "</td>\n";
                            }
                            if ( $feed1_routes[$left]['number_of_unique_stopnames'] == $feed2_routes[$right]['number_of_unique_stopnames'] ) {
                                echo $indent . '    <td class="gtfs-name" style="border-left-width: 2px;">' . htmlspecialchars($feed1_routes[$left]['number_of_unique_stopnames']) . "</td>\n";
                            } else {
                                echo $indent . '    <td class="gtfs-name" style="background-color: orange; border-left-width: 2px;">' . htmlspecialchars($feed1_routes[$left]['number_of_unique_stopnames']) . " vs " .  htmlspecialchars($feed2_routes[$right]['number_of_unique_stopnames']) . "</td>\n";
                            }
                            if ( $feed1_routes[$left]['md5_over_stopid_sequences'] == $feed2_routes[$right]['md5_over_stopid_sequences'] ) {
                                echo $indent . '    <td class="gtfs-name" style="border-left-width: 2px;">' . ShortenMD5String($feed1_routes[$left]['md5_over_stopid_sequences']) . "</td>\n";
                            } else {
                                echo $indent . '    <td class="gtfs-name" style="background-color: orange; border-left-width: 2px;">' . ShortenMD5String($feed1_routes[$left]['md5_over_stopid_sequences']) . " vs " .  ShortenMD5String($feed2_routes[$right]['md5_over_stopid_sequences']) . "</td>\n";
                            }
                            if ( $feed1_routes[$left]['md5_over_stopname_sequences'] == $feed2_routes[$right]['md5_over_stopname_sequences'] ) {
                                echo $indent . '    <td class="gtfs-name" style="border-left-width: 2px;">' . ShortenMD5String($feed1_routes[$left]['md5_over_stopname_sequences']) . "</td>\n";
                            } else {
                                echo $indent . '    <td class="gtfs-name" style="background-color: orange; border-left-width: 2px;">' . ShortenMD5String($feed1_routes[$left]['md5_over_stopname_sequences']) . " vs " .  ShortenMD5String($feed2_routes[$right]['md5_over_stopname_sequences']) . "</td>\n";
                            }
                            if ( $feed1_routes[$left]['md5_over_stoppos_sequences'] == $feed2_routes[$right]['md5_over_stoppos_sequences'] ) {
                                echo $indent . '    <td class="gtfs-name" style="border-left-width: 2px;">' . ShortenMD5String($feed1_routes[$left]['md5_over_stoppos_sequences']) . "</td>\n";
                            } else {
                                echo $indent . '    <td class="gtfs-name" style="background-color: orange; border-left-width: 2px;">' . ShortenMD5String($feed1_routes[$left]['md5_over_stoppos_sequences']) . " vs " .  ShortenMD5String($feed2_routes[$right]['md5_over_stoppos_sequences']) . "</td>\n";
                            }
                            if ( $feed1_routes[$left]['min_start_date'] == $feed2_routes[$right]['min_start_date'] ) {
                                echo $indent . '    <td class="gtfs-name" style="border-left-width: 2px;">' . htmlspecialchars($feed1_routes[$left]['min_start_date']) . "</td>\n";
                            } else {
                                echo $indent . '    <td class="gtfs-name" style="background-color: orange; border-left-width: 2px;">' . htmlspecialchars($feed1_routes[$left]['min_start_date']) . " vs " .  htmlspecialchars($feed2_routes[$right]['min_start_date']) . "</td>\n";
                            }
                            if ( $feed1_routes[$left]['max_end_date'] == $feed2_routes[$right]['max_end_date'] ) {
                                echo $indent . '    <td class="gtfs-name">' . htmlspecialchars($feed1_routes[$left]['max_end_date']) . "</td>\n";
                            } else {
                                echo $indent . '    <td class="gtfs-name" style="background-color: orange;">' . htmlspecialchars($feed1_routes[$left]['max_end_date']) . " vs " .  htmlspecialchars($feed2_routes[$right]['max_end_date']) . "</td>\n";
                            }
                            if ( $feed1_routes[$left]['agency_name'] == $feed2_routes[$right]['agency_name'] ) {
                                echo $indent . '    <td class="gtfs-name" style="border-left-width: 2px;">"' . htmlspecialchars($feed1_routes[$left]['agency_name']) . '"</td>' . "\n";
                            } else {
                                echo $indent . '    <td class="gtfs-name" style="background-color: orange; border-left-width: 2px;">"' . htmlspecialchars($feed1_routes[$left]['agency_name']) . '" vs "' .  htmlspecialchars($feed2_routes[$right]['agency_name']) . '"</td>' . "\n";
                            }
                            if ( $feed1_routes[$left]['route_long_name'] == $feed2_routes[$right]['route_long_name'] ) {
                                echo $indent . '    <td class="gtfs-name" style="border-left-width: 2px;">"' . htmlspecialchars($feed1_routes[$left]['route_long_name']) . '"</td>' . "\n";
                            } else {
                                echo $indent . '    <td class="gtfs-name" style="background-color: orange; border-left-width: 2px;">"' . htmlspecialchars($feed1_routes[$left]['route_long_name']) . '" vs "' .  htmlspecialchars($feed2_routes[$right]['route_long_name']) . '"</td>' . "\n";
                            }
                            echo $indent . "</tr>\n";
                            $left++;
                            $right++;
                        } elseif ( $feed1_routes[$left]['sort_key'] < $feed2_routes[$right]['sort_key'] ) {
                            echo $indent . "<tr>\n";
                            echo $indent . '    <td style="background-color: orange; border-left-width: 2px;"><input type="radio" name="route_id"  value="'        . htmlspecialchars($feed1_routes[$left]['route_id']) . '"' . $leftchecked . "></td>\n";
                            echo $indent . '    <td style="border-left-width: 2px;">&nbsp;</td>'. "\n";
                            echo $indent . '    <td style="border-left-width: 2px;" class="gtfs-name">' . htmlspecialchars($feed1_routes[$left]['route_short_name'])                         . "</td>\n";
                            echo $indent . '    <td class="gtfs-name">' . htmlspecialchars(RouteType2String($feed1_routes[$left]['route_type']))     . "</td>\n";
                            echo $indent . '    <td class="gtfs-name">' . htmlspecialchars($feed1_routes[$left]['route_id'])                         . "</td>\n";
                            echo $indent . '    <td class="gtfs-name" style="border-left-width: 2px;">' . htmlspecialchars($feed1_routes[$left]['number_of_variants']) . "</td>\n";
                            echo $indent . '    <td class="gtfs-name" style="border-left-width: 2px;">' . htmlspecialchars($feed1_routes[$left]['number_of_stops']) . "</td>\n";
                            echo $indent . '    <td class="gtfs-name" style="border-left-width: 2px;">' . htmlspecialchars($feed1_routes[$left]['number_of_unique_stopids']) . "</td>\n";
                            echo $indent . '    <td class="gtfs-name" style="border-left-width: 2px;">' . htmlspecialchars($feed1_routes[$left]['number_of_unique_stopnames']) . "</td>\n";
                            echo $indent . '    <td class="gtfs-name" style="border-left-width: 2px;">' . ShortenMD5String($feed1_routes[$left]['md5_over_stopid_sequences']) . "</td>\n";
                            echo $indent . '    <td class="gtfs-name" style="border-left-width: 2px;">' . ShortenMD5String($feed1_routes[$left]['md5_over_stopname_sequences']) . "</td>\n";
                            echo $indent . '    <td class="gtfs-name" style="border-left-width: 2px;">' . ShortenMD5String($feed1_routes[$left]['md5_over_stoppos_sequences']) . "</td>\n";
                            echo $indent . '    <td class="gtfs-name" style="border-left-width: 2px;">' . htmlspecialchars($feed1_routes[$left]['min_start_date']) . "</td>\n";
                            echo $indent . '    <td class="gtfs-name">' . htmlspecialchars($feed1_routes[$left]['max_end_date']) . "</td>\n";
                            echo $indent . '    <td class="gtfs-name" style="border-left-width: 2px;">"' . htmlspecialchars($feed1_routes[$left]['agency_name']) . '"</td>' . "\n";
                            echo $indent . '    <td class="gtfs-name" style="border-left-width: 2px;">"' . htmlspecialchars($feed1_routes[$left]['route_long_name']) . '"</td>' . "\n";
                            echo $indent . "</tr>\n";
                            $left++;
                        } else {
                            # $feed1_routes[$left]['sort_key'] > $feed2_routes[$right]['sort_key']
                            echo $indent . "<tr>\n";
                            echo $indent . '    <td style="border-left-width: 2px;">&nbsp;</td>' . "\n";
                            echo $indent . '    <td style="background-color: orange; border-left-width: 2px;"><input type="radio" name="route_id2"  value="' . htmlspecialchars($feed2_routes[$right]['route_id']) . '"' . $rightchecked . "></td>\n";
                            echo $indent . '    <td style="border-left-width: 2px;" class="gtfs-name">' . htmlspecialchars($feed2_routes[$right]['route_short_name']) . "</td>\n";
                            echo $indent . '    <td class="gtfs-name">' . htmlspecialchars(RouteType2String($feed2_routes[$right]['route_type'])) . "</td>\n";
                            echo $indent . '    <td class="gtfs-name">' . htmlspecialchars($feed2_routes[$right]['route_id']) . "</td>\n";
                            echo $indent . '    <td class="gtfs-name" style="border-left-width: 2px;">' . htmlspecialchars($feed2_routes[$right]['number_of_variants']) . "</td>\n";
                            echo $indent . '    <td class="gtfs-name" style="border-left-width: 2px;">' . htmlspecialchars($feed2_routes[$right]['number_of_stops']) . "</td>\n";
                            echo $indent . '    <td class="gtfs-name" style="border-left-width: 2px;">' . htmlspecialchars($feed2_routes[$right]['number_of_unique_stopids']) . "</td>\n";
                            echo $indent . '    <td class="gtfs-name" style="border-left-width: 2px;">' . htmlspecialchars($feed2_routes[$right]['number_of_unique_stopnames']) . "</td>\n";
                            echo $indent . '    <td class="gtfs-name" style="border-left-width: 2px;">' . ShortenMD5String($feed2_routes[$right]['md5_over_stopid_sequences']) . "</td>\n";
                            echo $indent . '    <td class="gtfs-name" style="border-left-width: 2px;">' . ShortenMD5String($feed2_routes[$right]['md5_over_stopname_sequences']) . "</td>\n";
                            echo $indent . '    <td class="gtfs-name" style="border-left-width: 2px;">' . ShortenMD5String($feed2_routes[$right]['md5_over_stoppos_sequences']) . "</td>\n";
                            echo $indent . '    <td class="gtfs-name" style="border-left-width: 2px;">' . htmlspecialchars($feed2_routes[$right]['min_start_date']) . "</td>\n";
                            echo $indent . '    <td class="gtfs-name">' . htmlspecialchars($feed2_routes[$right]['max_end_date']) . "</td>\n";
                            echo $indent . '    <td class="gtfs-name" style="border-left-width: 2px;">"' . htmlspecialchars($feed2_routes[$right]['agency_name']) . '"</td>' . "\n";
                            echo $indent . '    <td class="gtfs-name" style="border-left-width: 2px;">"' . htmlspecialchars($feed2_routes[$right]['route_long_name']) . '"</td>' . "\n";
                            echo $indent . "</tr>\n";
                            $right++;
                        }
                    } else {
                        if ( isset($feed1_routes[$left]) && $feed1_routes[$left] ) {
                            echo $indent . "<tr>\n";
                            echo $indent . '    <td style="background-color: orange; border-left-width: 2px;"><input type="radio" name="route_id"  value="'        . htmlspecialchars($feed1_routes[$left]['route_id']) . '"' . $leftchecked . "></td>\n";
                            echo $indent . '    <td style="border-left-width: 2px;">&nbsp;</td>' . "\n";
                            echo $indent . '    <td style="border-left-width: 2px;" class="gtfs-name">' . htmlspecialchars($feed1_routes[$left]['route_short_name']) . "</td>\n";
                            echo $indent . '    <td class="gtfs-name">' . htmlspecialchars(RouteType2String($feed1_routes[$left]['route_type'])) . "</td>\n";
                            echo $indent . '    <td class="gtfs-name">' . htmlspecialchars($feed1_routes[$left]['route_id']) . "</td>\n";
                            echo $indent . '    <td class="gtfs-name" style="border-left-width: 2px;">' . htmlspecialchars($feed1_routes[$left]['number_of_variants']) . "</td>\n";
                            echo $indent . '    <td class="gtfs-name" style="border-left-width: 2px;">' . htmlspecialchars($feed1_routes[$left]['number_of_stops']) . "</td>\n";
                            echo $indent . '    <td class="gtfs-name" style="border-left-width: 2px;">' . htmlspecialchars($feed1_routes[$left]['number_of_unique_stopids']) . "</td>\n";
                            echo $indent . '    <td class="gtfs-name" style="border-left-width: 2px;">' . htmlspecialchars($feed1_routes[$left]['number_of_unique_stopnames']) . "</td>\n";
                            echo $indent . '    <td class="gtfs-name" style="border-left-width: 2px;">' . ShortenMD5String($feed1_routes[$left]['md5_over_stopid_sequences']) . "</td>\n";
                            echo $indent . '    <td class="gtfs-name" style="border-left-width: 2px;">' . ShortenMD5String($feed1_routes[$left]['md5_over_stopname_sequences']) . "</td>\n";
                            echo $indent . '    <td class="gtfs-name" style="border-left-width: 2px;">' . ShortenMD5String($feed1_routes[$left]['md5_over_stoppos_sequences']) . "</td>\n";
                            echo $indent . '    <td class="gtfs-name" style="border-left-width: 2px;">' . htmlspecialchars($feed1_routes[$left]['min_start_date']) . "</td>\n";
                            echo $indent . '    <td class="gtfs-name">' . htmlspecialchars($feed1_routes[$left]['max_end_date']) . "</td>\n";
                            echo $indent . '    <td class="gtfs-name" style="border-left-width: 2px;">"' . htmlspecialchars($feed1_routes[$left]['agency_name']) . '"</td>' . "\n";
                            echo $indent . '    <td class="gtfs-name" style="border-left-width: 2px;">"' . htmlspecialchars($feed1_routes[$left]['route_long_name']) . '"</td>' . "\n";
                            echo $indent . "</tr>\n";
                            $left++;
                        } else {
                            echo $indent . "<tr>\n";
                            echo $indent . '    <td style="border-left-width: 2px;">&nbsp;</td>' . "\n";
                            echo $indent . '    <td style="background-color: orange; border-left-width: 2px;"><input type="radio" name="route_id2"  value="' . htmlspecialchars($feed2_routes[$right]['route_id']) . '"' . $rightchecked . "></td>\n";
                            echo $indent . '    <td style="border-left-width: 2px;" class="gtfs-name">' . htmlspecialchars($feed2_routes[$right]['route_short_name']) . "</td>\n";
                            echo $indent . '    <td class="gtfs-name">' . htmlspecialchars(RouteType2String($feed2_routes[$right]['route_type'])) . "</td>\n";
                            echo $indent . '    <td class="gtfs-name">' . htmlspecialchars($feed2_routes[$right]['route_id']) . "</td>\n";
                            echo $indent . '    <td class="gtfs-name" style="border-left-width: 2px;">' . htmlspecialchars($feed2_routes[$right]['number_of_variants']) . "</td>\n";
                            echo $indent . '    <td class="gtfs-name" style="border-left-width: 2px;">' . htmlspecialchars($feed2_routes[$right]['number_of_stops']) . "</td>\n";
                            echo $indent . '    <td class="gtfs-name" style="border-left-width: 2px;">' . htmlspecialchars($feed2_routes[$right]['number_of_unique_stopids']) . "</td>\n";
                            echo $indent . '    <td class="gtfs-name" style="border-left-width: 2px;">' . htmlspecialchars($feed2_routes[$right]['number_of_unique_stopnames']) . "</td>\n";
                            echo $indent . '    <td class="gtfs-name" style="border-left-width: 2px;">' . ShortenMD5String($feed2_routes[$right]['md5_over_stopid_sequences']) . "</td>\n";
                            echo $indent . '    <td class="gtfs-name" style="border-left-width: 2px;">' . ShortenMD5String($feed2_routes[$right]['md5_over_stopname_sequences']) . "</td>\n";
                            echo $indent . '    <td class="gtfs-name" style="border-left-width: 2px;">' . ShortenMD5String($feed2_routes[$right]['md5_over_stoppos_sequences']) . "</td>\n";
                            echo $indent . '    <td class="gtfs-name" style="border-left-width: 2px;">' . htmlspecialchars($feed2_routes[$right]['min_start_date']) . "</td>\n";
                            echo $indent . '    <td class="gtfs-name">' . htmlspecialchars($feed2_routes[$right]['max_end_date']) . "</td>\n";
                            echo $indent . '    <td class="gtfs-name" style="border-left-width: 2px;">"' . htmlspecialchars($feed2_routes[$right]['agency_name']) . '"</td>' . "\n";
                            echo $indent . '    <td class="gtfs-name" style="border-left-width: 2px;">"' . htmlspecialchars($feed2_routes[$right]['route_long_name']) . '"</td>' . "\n";
                            echo $indent . "</tr>\n";
                            $right++;
                        }
                    }
                }
            }
        }
        $stop_time = gettimeofday(true);
        return $stop_time - $start_time;
    }


    #
    # called from compare-routes.php
    #
    # colour palette: 6 resp. 11 colours RGB
    # #00ff00
    #         #6aef00
    # #91df00
    #         #aecd00
    # #c4ba00
    #         #d7a700
    # #e59100
    #         #f17a00
    # #f96000
    #         #fe4000
    # #ff0000
    #

    function CreateCompareRoutesTable( $feed, $feed2, $release_date, $release_date2, $route_id, $route_id2, $osm_relation, $ptna_lang ) {
        $start_time = gettimeofday(true);
        $indent = '                ';
        #$feedDB1 = FindGtfsSqliteDb( $feed,  $release_date  );
        #if ( $feed2 ) {
        #    $feedDB2 = FindGtfsSqliteDb( $feed2, $release_date2 );
        #}
        #if ( $feedDB1 && ( $feedDB2 || $osm_relation ) ) {
            $feed = "DE-BY-MVV";
            echo "\n";
            echo $indent . '<div class="tableFixHead" style="height: 300px; max-height: 550px">' . "\n";
            echo $indent . '    <table id="routes-table" class="compare">' . "\n";
            echo $indent . '        <thead>' . "\n";
            echo $indent . '            <tr>' . "\n";
            echo $indent . '                <th rowspan="2" colspan="3" style="background-color: #6698FF; text-align: left">&nbsp;' . "</th>\n";
            echo $indent . '                <th colspan="4" style="background-color: #bbbbbb" title="Route-Master relation-ID 67811"><a target="_blank" href="https://www.openstreetmap.org/relation/67811">OSM route_master</a>' . "</th>\n";
            echo $indent . '            </tr>' . "\n";
            echo $indent . '            <tr>' . "\n";
            echo $indent . '                <th style="background-color: #cccccc" ' .
                                            'title="Route relation-ID 9797611' . "\n" . 'Bus 210: Neuperlach Süd (S/U) => Ottobrunn, Ortsmitte">Neuperlach Süd (S/U)<br/>... 4 stops ...<br/>Ottobrunn, Ortsmitte' . "</th>\n";
            echo $indent . '                <th style="background-color: #dddddd" ' .
                                            'title="Route relation-ID 1549762' . "\n" . 'Bus 210: Neuperlach Süd (S/U) => Brunnthal, Zusestraße">Neuperlach Süd (S/U)<br/>... 13 stops ...<br/>Brunnthal, Zusestraße' . "</th>\n";
            echo $indent . '                <th style="background-color: #cccccc" ' .
                                            'title="Route relation-ID 9797610' . "\n" . 'Bus 210: Ottobrunn, Jahnstraße => Neuperlach Süd (S/U)">Ottobrunn, Jahnstraße<br/>... 3 stops ...<br/>Neuperlach Süd (S/U)' . "</th>\n";
            echo $indent . '                <th style="background-color: #dddddd" ' .
                                            'title="Route relation-ID 1549761' . "\n" . 'Bus 210: Brunnthal, Zusestraße => Neuperlach Süd (S/U)">Brunnthal, Zusestraße<br/>... 12 stops ...<br/>Neuperlach Süd (S/U)' . "</th>\n";
            echo $indent . '            </tr>' . "\n";
            echo $indent . '        </thead>' . "\n";
            echo $indent . '        <tbody>' . "\n";
            echo $indent . '            <tr>' . "\n";
            echo $indent . '                <td align="right"  rowspan="7" style="background-color: #bbbbbb" ' .
                                            'title="GTFS route_id 19-210-s24-1"><a target="_blank" href="/gtfs/DE/trips.php?feed=DE-BY-MVV&release_date=&route_id=19-210-s24-1">GTFS route</a>' . "</td>\n";
            echo $indent . '                <td align="right"  style="background-color: #cccccc" ' .
                                            'title="GTFS trip_id 242.T0.19-210-s24-1.5.R">Brunnthal, Zusestraße ... 0 stops ... Brunnthal, Zusestraße' . "</td>\n";
            echo $indent . '                <td align="center" style="background-color: #cccccc"><img src="/img/Attention32.png" height="18" width="18" alt="Information" ' .
                                            'title="Suspicious start of trip: same \'stop_name\'.' . "\n" .
                                            'Suspicious end of trip: same \'stop_name\'.' . "\n" .
                                            'Suspicious number of stops: \'2\'.' . "\n" .
                                            'Suspicious travel time: \'0:00\'"/>' . "</td>\n";
            echo $indent . '                <td align="center" style="background-color: #c4ba00"><a target="_blank"  href="/gtfs/compare-trips.php?feed=' . htmlspecialchars($feed) . '&release_date=' . htmlspecialchars($release_date) . '&trip_id=' . htmlspecialchars("242.T0.19-210-s24-1.5.R") . '&relation=' . htmlspecialchars("9797611") . '" title="">4S / 8P' . "</a></td>\n";
            echo $indent . '                <td align="center" style="background-color: #d7a700"><a target="_blank"  href="" title="">13S / 16P' . "</a></td>\n";
            echo $indent . '                <td align="center" style="background-color: #91df00"><a target="_blank"  href="" title="">3S / 7P' . "</a></td>\n";
            echo $indent . '                <td align="center" style="background-color: #f96000"><a target="_blank"  href="" title="">12S / 13P' . "</a></td>\n";
            echo $indent . '            </tr>' . "\n";
            echo $indent . '            <tr>' . "\n";
            echo $indent . '                <td align="right"  style="background-color: #dddddd" ' .
                                            'title="GTFS trip_id 320.T0.19-210-s24-1.1.H">Brunnthal, Zusestraße ... 12 stops ... Neuperlach Süd' . "</td>\n";
            echo $indent . '                <td align="center" style="background-color: #dddddd">&nbsp;' . "</td>\n";
            echo $indent . '                <td align="center" style="background-color: #ff0000"><a target="_blank"  href="" title="">8S / 20P' . "</a></td>\n";
            echo $indent . '                <td align="center" style="background-color: #f96000"><a target="_blank"  href="" title="">1S / 29P' . "</a></td>\n";
            echo $indent . '                <td align="center" style="background-color: #e59100"><a target="_blank"  href="" title="">9S / 9P' . "</a></td>\n";
            echo $indent . '                <td align="center" style="background-color: #00ff00"><a target="_blank"  href="" title="">0S / 0P' . "</a></td>\n";
            echo $indent . '            </tr>' . "\n";
            echo $indent . '            <tr>' . "\n";
            echo $indent . '                <td align="right"  style="background-color: #cccccc" ' .
                                            'title="GTFS trip_id 1.T0.19-210-s24-1.4.R">Neuperlach Süd ... 13 stops ... Brunnthal, Zusestraße' . "</td>\n";
            echo $indent . '                <td align="center" style="background-color: #cccccc">&nbsp;' . "</td>\n";
            echo $indent . '                <td align="center" style="background-color: #e59100"><a target="_blank"  href="" title="">9S / 9P' . "</a></td>\n";
            echo $indent . '                <td align="center" style="background-color: #00ff00"><a target="_blank"  href="" title="">0S / 0P' . "</a></td>\n";
            echo $indent . '                <td align="center" style="background-color: #ff0000"><a target="_blank"  href="" title="">10S / 19P' . "</a></td>\n";
            echo $indent . '                <td align="center" style="background-color: #c4ba00"><a target="_blank"  href="" title="">1S / 14P' . "</a></td>\n";
            echo $indent . '            </tr>' . "\n";
            echo $indent . '            <tr>' . "\n";
            echo $indent . '                <td align="right"  style="background-color: #dddddd" ' .
                                            'title="GTFS trip_id 222.T0.19-210-s24-1.3.H">Neuperlach Süd ... 0 stops ... Ottobrunn, Jahnstraße' . "</td>\n";
            echo $indent . '                <td align="center" style="background-color: #dddddd"><img src="/img/Attention32.png" height="18" width="18" alt="Information" ' .
                                            'title="Suspicious number of stops: \'2\'"/>' . "</td>\n";
            echo $indent . '                <td align="center" style="background-color: #91df00"><a target="_blank"  href="" title="">4S / 6P' . "</a></td>\n";
            echo $indent . '                <td align="center" style="background-color: #ff0000"><a target="_blank"  href="" title="">13S / 15P' . "</a></td>\n";
            echo $indent . '                <td align="center" style="background-color: #91df00"><a target="_blank"  href="" title="">3S / 7P' . "</a></td>\n";
            echo $indent . '                <td align="center" style="background-color: #f96000"><a target="_blank"  href="" title="">12S / 13P' . "</a></td>\n";
            echo $indent . '            </tr>' . "\n";
            echo $indent . '            <tr>' . "\n";
            echo $indent . '                <td align="right"  style="background-color: #cccccc" ' .
                                            'title="GTFS trip_id 225.T0.19-210-s24-1.7.R">Neuperlach Süd ... 4 stops ... Ottobrunn, Ortsmitte' . "</td>\n";
            echo $indent . '                <td align="center" style="background-color: #cccccc">&nbsp;' . "</td>\n";
            echo $indent . '                <td align="center" style="background-color: #00ff00"><a target="_blank"  href="" title="">0S / 0P' . "</a></td>\n";
            echo $indent . '                <td align="center" style="background-color: #e59100"><a target="_blank"  href="" title="">9S / 9P' . "</a></td>\n";
            echo $indent . '                <td align="center" style="background-color: #91df00"><a target="_blank"  href="" title="">1S / 9P' . "</a></td>\n";
            echo $indent . '                <td align="center" style="background-color: #ff0000"><a target="_blank"  href="" title="">8S / 18P' . "</a></td>\n";
            echo $indent . '            </tr>' . "\n";
            echo $indent . '            <tr>' . "\n";
            echo $indent . '                <td align="right"  style="background-color: #dddddd" ' .
                                            'title="GTFS trip_id 219.T0.19-210-s24-1.2.H">Ottobrunn, Jahnstraße ... 3 stops ... Neuperlach Süd' . "</td>\n";
            echo $indent . '                <td align="center" style="background-color: #dddddd"><img src="/img/Information32.png" height="18" width="18" alt="Information" title="Trip is subroute of: 320.T0.19-210-s24-1.1.H"/>' . "</td>\n";
            echo $indent . '                <td align="center" style="background-color: #e59100"><a target="_blank"  href="" title="">1S / 18P' . "</a></td>\n";
            echo $indent . '                <td align="center" style="background-color: #ff0000"><a target="_blank"  href="" title="">10S / 18P' . "</a></td>\n";
            echo $indent . '                <td align="center" style="background-color: #00ff00"><a target="_blank"  href="" title="">0S / 0P' . "</a></td>\n";
            echo $indent . '                <td align="center" style="background-color: #e59100"><a target="_blank"  href="" title="">9S / 10P' . "</a></td>\n";
            echo $indent . '            </tr>' . "\n";
            echo $indent . '            <tr>' . "\n";
            echo $indent . '                <td align="right"  style="background-color: #cccccc" ' .
                                            'title="GTFS trip_id 308.T0.19-210-s24-1.6.R">Ottobrunn, Ortsmitte ... 0 stops ... Neuperlach Süd' . "</td>\n";
            echo $indent . '                <td align="center" style="background-color: #cccccc"><img src="/img/Attention32.png" height="18" width="18" alt="Information" ' .
                                            'title="Suspicious number of stops: \'2\'"/>' . "</td>\n";
            echo $indent . '                <td align="center" style="background-color: #c4ba00"><a target="_blank"  href="" title="">4S / 8P' . "</a></td>\n";
            echo $indent . '                <td align="center" style="background-color: #ff0000"><a target="_blank"  href="" title="">13S / 15P' . "</a></td>\n";
            echo $indent . '                <td align="center" style="background-color: #91df00"><a target="_blank"  href="" title="">3S / 5P' . "</a></td>\n";
            echo $indent . '                <td align="center" style="background-color: #ff0000"><a target="_blank"  href="" title="">12S / 14P' . "</a></td>\n";
            echo $indent . '            </tr>' . "\n";
            echo $indent . '        </tbody>' . "\n";
            echo $indent . '    </table>' . "\n";
            echo $indent . '</div>' . "\n";
            #}
        $stop_time = gettimeofday(true);
        return $stop_time - $start_time;
    }


    #
    # called from compare-trips.php
    #

    function CreateCompareTripsTableHead( $feed, $feed2, $release_date, $release_date2, $trip_id, $trip_id2, $osm_relation ) {
        global $STR_compare_shapes;
        global $STR_invalid_input_data;

        $start_time = gettimeofday(true);
        $indent = '                            ';
        $feedDB1 = FindGtfsSqliteDb( $feed,  $release_date  );
        $feedDB2 = FindGtfsSqliteDb( $feed2, $release_date2 );
        if ( $feedDB1 && $feedDB2 ) {
            ;
        } else {
            if ( !$feedDB1 )                                                            { echo "<p>" . htmlspecialchars($STR_invalid_input_data) . ": 'feed'  = '" . htmlspecialchars($feed)  . "' + 'release_date'   = '" . htmlspecialchars($release_date)   . "'</p>\n"; }
            if ( !$feedDB2 && ($feed != $feed2 || $release_date != $release_date2) )    { echo "<p>" . htmlspecialchars($STR_invalid_input_data) . ": 'feed2' = '" . htmlspecialchars($feed2) . "' + 'release_date2'  = '" . htmlspecialchars($release_date2)  . "'</p>\n"; }
        }
        $stop_time = gettimeofday(true);
        return $stop_time - $start_time;
    }

    function CreateCompareTripsTableBody( $feed, $feed2, $release_date, $release_date2, $trip_id, $trip_id2, $osm_relation ) {
        $start_time = gettimeofday(true);
        $indent = '                            ';
        $feedDB1 = FindGtfsSqliteDb( $feed,  $release_date  );
        $feedDB2 = FindGtfsSqliteDb( $feed2, $release_date2 );
        if ( $feedDB1 && $feedDB2 ) {
            ;
        }
        $stop_time = gettimeofday(true);
        return $stop_time - $start_time;
    }


    #
    # called from compare-shapes.php
    #

    function CreateCompareShapesTableHead( $feed, $feed2, $release_date, $release_date2, $shape_id, $shape_id2 ) {
        global $STR_invalid_input_data;

        $start_time = gettimeofday(true);
        $indent = '                            ';
        $feedDB1 = FindGtfsSqliteDb( $feed,  $release_date  );
        $feedDB2 = FindGtfsSqliteDb( $feed2, $release_date2 );
        if ( $feedDB1 && $feedDB2 ) {
            ;
        } else {
            if ( !$feedDB1 )                                                            { echo "<p>" . htmlspecialchars($STR_invalid_input_data) . ": 'feed'  = '" . htmlspecialchars($feed)  . "' + 'release_date'   = '" . htmlspecialchars($release_date)   . "'</p>\n"; }
            if ( !$feedDB2 && ($feed != $feed2 || $release_date != $release_date2) )    { echo "<p>" . htmlspecialchars($STR_invalid_input_data) . ": 'feed2' = '" . htmlspecialchars($feed2) . "' + 'release_date2'  = '" . htmlspecialchars($release_date2)  . "'</p>\n"; }
        }
        $stop_time = gettimeofday(true);
        return $stop_time - $start_time;
    }

    function CreateCompareShapesTableBody( $feed, $feed2, $release_date, $release_date2, $shape_id, $shape_id2 ) {
        $start_time = gettimeofday(true);
        $indent = '                            ';
        $feedDB1 = FindGtfsSqliteDb( $feed,  $release_date  );
        $feedDB2 = FindGtfsSqliteDb( $feed2, $release_date2 );
        if ( $feedDB1 && $feedDB2 ) {
            ;
        }
        $stop_time = gettimeofday(true);
        return $stop_time - $start_time;
    }


    function GetGtfsRoutes( $SqliteDb ) {

        $return_array = array();

        if ( $SqliteDb != '' ) {

            try {

                $db          = new SQLite3( $SqliteDb );

                $sql         = "SELECT * FROM osm;";
                $osm         = $db->querySingle( $sql, true );

                $sql         = "SELECT DISTINCT * FROM routes;";

                $outerresult = $db->query( $sql );

                while ( $outerrow=$outerresult->fetchArray(SQLITE3_ASSOC) ) {
                    if ( preg_match('/^([0-9]+)(.*)$/',$outerrow['route_short_name'],$parts) ) {
                        $rsn = sprintf("%20s%s ",$parts[1],$parts[2]);
                    } elseif ( preg_match('/^([^0-9][^0-9]*)([0-9][0-9]*)(.*)$/',$outerrow['route_short_name'],$parts) ) {
                        $rsn = sprintf("%s%20s%s ",$parts[1],$parts[2],$parts[3]);
                    } else {
                        $rsn = sprintf("%s%20s ",$outerrow['route_short_name'],' ');
                    }
                    # if trip_id_regex is set, we can assume that this is OK for route_id_version as well (w/ different regex though)
                    if ( isset($osm['trip_id_regex']) && $osm['trip_id_regex'] != '' &&
                         preg_match('/^(.*)-([0-9]+)$/',$outerrow['route_id'],$parts)    ) {
                        $route_id         = $parts[1];
                        $route_id_version = sprintf("%03d", $parts[2] );
                        $outerrow['sort_key'] = RouteType2OsmRouteImportance($outerrow['route_type']) . ";" . $rsn . ";" . $route_id_version .';' . $route_id;
                    } else {
                        $outerrow['sort_key'] = RouteType2OsmRouteImportance($outerrow['route_type']) . ";" . $rsn . ";" . $outerrow['route_id'];
                    }
                    $sql_agency = sprintf( "SELECT agency_name FROM agency WHERE agency_id='%s' LIMIT 1;", SQLite3::escapeString($outerrow["agency_id"]) );
                    $agency     = $db->querySingle( $sql_agency, true );
                    $outerrow['agency_name'] = isset($agency['agency_name']) ? $agency['agency_name'] : '';
                    $sql_trips  = sprintf( "SELECT * FROM trips WHERE route_id='%s';", SQLite3::escapeString($outerrow["route_id"]) );
                    $tripresult = $db->query( $sql_trips );
                    $min_start_date     = '20500101';
                    $max_end_date       = '19700101';
                    $number_of_variants = 0;
                    $route_stop_id_array = array();
                    $route_stop_name_array = array();
                    $route_stop_id_md5_array = array();
                    $route_stop_name_md5_array = array();
                    $route_stop_pos_md5_array = array();
                    while ( $triprow=$tripresult->fetchArray(SQLITE3_ASSOC) ) {
                        $number_of_variants += 1;
                        $start_end_array = GetStartEndDateAndRidesOfIdenticalTrips( $db, $triprow["trip_id"], False );
                        if ( preg_match( "/^(\d{4})(\d{2})(\d{2})$/", $start_end_array["start_date"], $parts ) ) {
                            if ( $start_end_array["start_date"] < $min_start_date ) {
                                $min_start_date = $start_end_array["start_date"];
                            }
                        }
                        if ( preg_match( "/^(\d{4})(\d{2})(\d{2})$/", $start_end_array["end_date"], $parts ) ) {
                            if ( $start_end_array["end_date"] > $max_end_date ) {
                                $max_end_date = $start_end_array["end_date"];
                            }
                        }
                        $sql_stoptime  = sprintf( "SELECT stop_times.stop_id AS stopid, stops.stop_name AS stopname, stops.stop_lat AS stoplat , stops.stop_lon AS stoplon FROM stop_times JOIN stops ON stop_times.stop_id = stops.stop_id WHERE stop_times.trip_id='%s' ORDER BY CAST (stop_times.stop_sequence AS INTEGER) ASC;", SQLite3::escapeString($triprow["trip_id"]) );
                        $stoptimeresult = $db->query( $sql_stoptime );
                        $trip_stop_id_array = array();
                        $trip_stop_name_array = array();
                        $trip_stop_pos_array = array();
                        while  ( $stoptimerow=$stoptimeresult->fetchArray(SQLITE3_ASSOC) ) {
                            array_push( $route_stop_id_array,   $stoptimerow['stopid'] );
                            array_push( $route_stop_name_array, $stoptimerow['stopname'] );
                            array_push( $trip_stop_id_array,    $stoptimerow['stopid'] );
                            array_push( $trip_stop_name_array,  $stoptimerow['stopname'] );
                            array_push( $trip_stop_pos_array,   $stoptimerow['stoplat'] . ';' . $stoptimerow['stoplon'] );
                        }
                        array_push($route_stop_id_md5_array,  md5(implode(';',$trip_stop_id_array  )));
                        array_push($route_stop_name_md5_array,md5(implode(';',$trip_stop_name_array)));
                        array_push($route_stop_pos_md5_array, md5(implode(';',$trip_stop_pos_array)));
                    }
                    $outerrow['min_start_date']               = $min_start_date != '20500101' ? $min_start_date : '';
                    if ( preg_match( "/^(\d{4})(\d{2})(\d{2})$/", $outerrow['min_start_date'], $parts ) ) {
                        $outerrow['min_start_date'] = $parts[1] . '-' . $parts[2] . '-' . $parts[3];
                    }
                    $outerrow['max_end_date']                 = $max_end_date   != '19700101' ? $max_end_date : '';
                    if ( preg_match( "/^(\d{4})(\d{2})(\d{2})$/", $outerrow['max_end_date'], $parts ) ) {
                        $outerrow['max_end_date'] = $parts[1] . '-' . $parts[2] . '-' . $parts[3];
                    }
                    $outerrow['number_of_variants']           = $number_of_variants;
                    $outerrow['number_of_stops']              = count($route_stop_id_array);
                    $outerrow['number_of_unique_stopids']     = count(array_unique($route_stop_id_array));
                    $outerrow['number_of_unique_stopnames']   = count(array_unique($route_stop_name_array));
                    sort($route_stop_id_md5_array);
                    $outerrow['md5_over_stopid_sequences']    = md5(implode(';',$route_stop_id_md5_array));
                    sort($route_stop_name_md5_array);
                    $outerrow['md5_over_stopname_sequences']  = md5(implode(';',$route_stop_name_md5_array));
                    sort($route_stop_pos_md5_array);
                    $outerrow['md5_over_stoppos_sequences']   = md5(implode(';',$route_stop_pos_md5_array));

                    array_push( $return_array, $outerrow );
                }
                $db->close();

                usort($return_array,"sort_array_by_sort_key");

            } catch ( Exception $ex ) {
                echo "CreateGtfsRoutesEntry(): Sqlite DB could not be opened: " . htmlspecialchars($ex->getMessage()) . "\n";
            }
        }

        return $return_array;
    }


    function ShortenMD5String( $string ) {

        $ret = $string;

        if ( strlen($string) > 8 ) {
            $ret = substr($string,0,5) . '...';
        }
        return $ret;
    }
?>
