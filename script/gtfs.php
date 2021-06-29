<?php

    $gtfs_strings['subroute_of']                    = 'Trip is subroute of:';
    $gtfs_strings['suspicious_start']               = 'Suspicious start of trip: same';
    $gtfs_strings['suspicious_end']                 = 'Suspicious end of trip: same';
    $gtfs_strings['same_names_but_different_ids']   = 'Trips have same Stop-Names but different Stop-Ids:';

    if ( $lang ) {
        if ( $lang == 'en' ) {
            ;
        } elseif ( $lang == 'de' ) {
            $gtfs_strings['subroute_of']                    = 'Fahrt ist Teilroute von:';
            $gtfs_strings['suspicious_start']               = 'Verdächtiger Anfang der Fahrt: gleiche';
            $gtfs_strings['suspicious_end']                 = 'Verdächtiges Ende der Fahrt: gleiche';
            $gtfs_strings['same_names_but_different_ids']   = 'Fahrten haben gleiche Haltestellennamen aber unterschiedliche Haltestellennummern:';
        }
    }

    function FindGtfsSqliteDb( $feed, $release_date ) {
        global $path_to_work;

        $return_path = '';

        if ( $release_date ) {
            $feed_release = $feed . '-' . $release_date;
        } else {
            $feed_release = $feed;
        }
        if ( $feed_release && preg_match("/^[a-zA-Z0-9_.-]+$/", $feed_release) ) {
            $feed_parts = explode( '-', $feed );
            $countrydir = array_shift( $feed_parts );

            $return_path = $path_to_work . $countrydir . '/' . $feed_release . '-ptna-gtfs-sqlite.db';

            if ( file_exists($return_path) ) {
                if ( preg_match("/-previous$/", $feed_release) || preg_match("/-long-term$/", $feed_release) ) {
                    if ( is_link($return_path) ) {
                        $return_path = $path_to_work . $countrydir . '/' . readlink( $return_path );
                    }
                }
             }
             if ( !file_exists($return_path) ) {
                $subdir = array_shift( $feed_parts );

                $return_path = $path_to_work . $countrydir . '/' . $subdir . '/' . $feed_release . '-ptna-gtfs-sqlite.db';

                if ( file_exists($return_path) ) {
                    if (  preg_match("/-previous$/", $feed_release) || preg_match("/-long-term$/", $feed_release) ) {
                        if ( is_link($return_path) ) {
                            $return_path = $path_to_work . $countrydir . '/' . $subdir . '/' . readlink( $return_path );
                        }
                    }
                }
            }
        }

        if ( file_exists($return_path) && filesize($return_path) ) {
            return $return_path;
        } else {
            return '';
        }
    }


    function CreateGtfsVersionsTableBody( $feed ) {

        $release_dates  = array();          # i.e. all months are relevant

        if ( $feed && preg_match("/^[a-zA-Z0-9_.-]+$/", $feed) ) {
            $release_dates =GetGtfsFeedReleaseDatesNonEmpty( $feed );

            rsort( $release_dates );

            $line = 1;
            foreach ( $release_dates as $rd ) {
                if ( $line == 1 ) {
                    $checked_1 = 'checked="checked"';
                    if ( count($release_dates) == 1) {
                        $checked_2 = 'checked="checked"';
                    } else {
                        $checked_2 = '';
                    }
                } else {
                    $checked_1 = '';
                    if ( $line == 2 ) {
                        $checked_1 = '';
                        $checked_2 = 'checked="checked"';
                    } else {
                        $checked_2 = '';
                    }
                }
                echo "<tr>\n";
                echo '<td class="gtfs-radiobox"><input class="button-radio" type="radio" name="release_date_1" id="' . $rd .'_1" value="' . $rd .'" ' . $checked_1 . '></td>' . "\n";
                echo '<td class="gtfs-date"><label for="' . $rd .'_1">' . $rd .'</label></td>' . "\n";
                echo '<td class="gtfs-radiobox"><input class="button-radio" type="radio" name="release_date_2" id="' . $rd .'_2" value="' . $rd .'" ' . $checked_2 . '></td>' . "\n";
                echo '<td class="gtfs-date"><label for="' . $rd .'_2">' . $rd .'</label></td>' . "\n";
                echo "</tr>\n";
                $line++;
            }
        }
        return 0;
    }


    function CreateGtfsTimeLine( $feed, $release_date, $months_short ) {

        $release_dates  = array();          # i.e. all months are relevant

        if ( $feed && preg_match("/^[a-zA-Z0-9_.-]+$/", $feed) ) {
            $release_dates = GetGtfsFeedReleaseDates( $feed );
            CreateGtfsTimeLineBasis( $release_dates, $months_short );
            CreateGtfsTimeLineEntries( $feed, $release_date, $release_dates );
        } else {
            CreateGtfsTimeLineBasis( $release_dates, $months_short );
        }
        echo "</div>\n<br />\n\n";
        return 0;
    }


    function GetGtfsFeedReleaseDates( $feed ) {
        global $path_to_work;

        $release_dates_array = array();

        if ( $feed && preg_match("/^[a-zA-Z0-9_.-]+$/", $feed) ) {
            $feed_parts = explode( '-', $feed );
            $countrydir = array_shift( $feed_parts );
            $subdir     = array_shift( $feed_parts );

            $search_path    = $path_to_work . $countrydir;

            if ( is_dir($search_path) ) {
                if ( $subdir && is_dir($search_path.'/'.$subdir) ) {
                    $search_path = $search_path.'/'.$subdir;
                }

                $search_dir = opendir( $search_path );

                while ( ($entry = readdir($search_dir)) !== false ) {
                    if ( preg_match( "/^$feed-(\d\d\d\d-\d\d\-\d\d)-ptna-gtfs-sqlite.db$/",$entry,$parts) ) {
                        array_push( $release_dates_array, $parts[1] );
                    }
                }
            }
        }
        return $release_dates_array;
    }


    function GetGtfsFeedReleaseDatesNonEmpty( $feed ) {
        global $path_to_work;

        $release_dates_array = array();

        if ( $feed && preg_match("/^[a-zA-Z0-9_.-]+$/", $feed) ) {
            $feed_parts = explode( '-', $feed );
            $countrydir = array_shift( $feed_parts );
            $subdir     = array_shift( $feed_parts );

            $search_path    = $path_to_work . $countrydir;

            if ( is_dir($search_path) ) {
                if ( $subdir && is_dir($search_path.'/'.$subdir) ) {
                    $search_path = $search_path.'/'.$subdir;
                }

                $search_dir = opendir( $search_path );

                while ( ($entry = readdir($search_dir)) !== false ) {
                    if ( preg_match( "/^$feed-(\d\d\d\d-\d\d\-\d\d)-ptna-gtfs-sqlite.db$/",$entry,$parts) ) {
                        if ( filesize($search_path . '/' . $entry) > 0 ) {
                            array_push( $release_dates_array, $parts[1] );
                        }
                    }
                }
            }
        }
        return $release_dates_array;
    }


    function GtfsReadLink( $feed, $linkname ) {
        global $path_to_work;

        if ( $feed && preg_match("/^[a-zA-Z0-9_.-]+$/",$feed) ) {
            $feed_parts = explode( '-', $feed );
            $countrydir = array_shift( $feed_parts );
            $subdir     = array_shift( $feed_parts );

            $search_path    = $path_to_work . $countrydir;

            if ( is_dir($search_path) ) {
                if ( $subdir && is_dir($search_path.'/'.$subdir) ) {
                    $search_path = $search_path.'/'.$subdir;
                }
            }

            if ( $linkname && ( $linkname == "previous" || $linkname == "long-term" ) ) {
                $filename = $search_path . '/' . $feed . '-' . $linkname . '-ptna-gtfs-sqlite.db';
            } else {
                $filename = $search_path . '/' . $feed . '-ptna-gtfs-sqlite.db';
            }

            if ( is_link($filename) ) {
                return readlink( $filename );
            }
        }

        return '';
    }


    function GtfsDbSize( $feed, $release_date ) {
        global $path_to_work;

        if ( $feed          && preg_match("/^[a-zA-Z0-9_.-]+$/",$feed)              &&
             $release_date  && preg_match("/^\d\d\d\d-\d\d-\d\d+$/",$release_date)      ) {

            $feed_parts = explode( '-', $feed );
            $countrydir = array_shift( $feed_parts );
            $subdir     = array_shift( $feed_parts );

            $search_path    = $path_to_work . $countrydir;

            if ( is_dir($search_path) ) {
                if ( $subdir && is_dir($search_path.'/'.$subdir) ) {
                    $search_path = $search_path.'/'.$subdir;
                }
            }

            $filename = $search_path . '/' . $feed . '-' . $release_date . '-ptna-gtfs-sqlite.db';

            if ( is_file($filename) ) {
                return filesize($filename);
            }
        }
        return -1;
    }


    function CreateGtfsTimeLineEntries( $feed, $release_date, $release_dates ) {

        $current_target   = GtfsReadLink( $feed, ''          );
        $previous_target  = GtfsReadLink( $feed, 'previous'  );
        $long_term_target = GtfsReadLink( $feed, 'long-term' );

        $target_script = preg_replace( '/trips.php/', 'routes.php', $_SERVER['SCRIPT_NAME'] );

        foreach ( $release_dates as $rd ) {
            $ym = preg_replace( '/^(\d\d\d\d)-(\d\d)-\d\d$/', '\\1\\2', $rd );

            if ( isset($relevant_dates[$ym]) ) {
                $relevant_dates[$ym]++;
            } else {
                $relevant_dates[$ym] = 1;
            }
        }

        if ( !$release_date ) {
            $viewing = $current_target;
        } elseif ( $release_date == 'previous' ) {
            $viewing = $previous_target;
        } elseif ( $release_date == 'long-term' ) {
            $viewing = $long_term_target;
        } else {
            $viewing = $feed . '-'. $release_date . '-ptna-gtfs-sqlite.db';
        }

        sort( $release_dates );

        foreach ( $release_dates as $rd ) {
            $ym = preg_replace( '/^(\d\d\d\d)-(\d\d)-\d\d$/', '\\1\\2', $rd );

            $add_style = '';
            $contents  = $rd;

            if ( GtfsDbSize($feed,$rd) == 0 ) {
                $add_style = "background-color: lightgray; text-decoration: line-through;";
            } else {
                if (  $viewing == $feed.'-'.$rd.'-ptna-gtfs-sqlite.db' ) {
                    $add_style = "background-color: limegreen;";
                }
                if ( $long_term_target == $feed.'-'.$rd.'-ptna-gtfs-sqlite.db' ) {
                    $contents = '<a href="' . $target_script . '?feed=' . urlencode($feed) . '&release_date=long-term"><img src="/img/long-term19.png" width="19px" height="19px" title="long-term" /></a> ';
                } else {
                    $contents = '';
                }
                if ( $current_target == $feed.'-'.$rd.'-ptna-gtfs-sqlite.db' ) {
                    $contents .= '<a href="' . $target_script . '?feed=' . urlencode($feed) . '"><img src="/img/CheckMark.png" width="19px" height="19px" title="current" /></a> ';
                    $contents .= '<a href="' . $target_script . '?feed=' . urlencode($feed) . '&release_date=' . urlencode($rd) . '">' . htmlspecialchars($rd) . "</a>";
                } elseif ( $previous_target == $feed.'-'.$rd.'-ptna-gtfs-sqlite.db' ) {
                    $contents .= '<a href="' . $target_script . '?feed=' . urlencode($feed) . '&release_date=' . urlencode($rd) . '"><img src="/img/previous.svg" width="19px" height="19px" title="previous" /></a> ';
                    $contents .= '<a href="' . $target_script . '?feed=' . urlencode($feed) . '&release_date=' . urlencode($rd) . '">' . htmlspecialchars($rd) . "</a>";
                } else {
                    $contents .= '<a href="' . $target_script . '?feed=' . urlencode($feed) . '&release_date=' . urlencode($rd) . '">' . htmlspecialchars($rd) . "</a>";
                }
            }

            echo '    <div style="grid-column: m' . $ym . '; grid-row: date' . $relevant_dates[$ym]-- . '; margin: 1px; border: 1px dotted gray; border-radius: 5px; padding: 0.2em; '
                      . $add_style . '">' . $contents . "</div>\n";
        }
    }


    function CreateGtfsTimeLineBasis( $release_dates, $months_short ) {

        $gtfs_show_number_of_months = 14;
        $months_colour              = array( "white", "#dddddd" );

        $date_rows   = 1;

        $months_colour = array( "white", "#dddddd" );

        $number_of_dot_boxes    = 1;    # at the start
        $time_line_covers_boxes = 0;    # dots at the start, arrow at the end

        if ( count($release_dates) > 0 ) {
            #print_r($release_dates );
            # ensure that this month and year is shown in the time line
            # also ensure that month and year 14 monthago is also in the timeline
            $this_year  = date( "Y" );
            $this_month = date( "n" );
            $start_year = intdiv( ($this_year * 12 + $this_month) - $gtfs_show_number_of_months, 12 );
            $start_month = (($this_year * 12 + $this_month) - $gtfs_show_number_of_months) % 12 + 1;
            $enhanced_release_dates = $release_dates;
            array_push( $enhanced_release_dates, sprintf( "%04d-%02d-01", $this_year, $this_month ) );
            array_push( $enhanced_release_dates, sprintf( "%04d-%02d-01", $start_year, $start_month ) );

            # sort enhanced release dates by date and get oldes date and youngest date
            sort( $enhanced_release_dates );
            $first = array_shift( $enhanced_release_dates );
            $last  = array_pop  ( $enhanced_release_dates );
            $start_year  = preg_replace( '/^(\d\d\d\d)-\d\d-\d\d$/', '\\1', $first );
            $start_month = preg_replace( '/^\d\d\d\d-(\d\d)-\d\d$/', '\\1', $first );
            $last_year   = preg_replace( '/^(\d\d\d\d)-\d\d-\d\d$/', '\\1', $last );
            $last_month  = preg_replace( '/^\d\d\d\d-(\d\d)-\d\d$/', '\\1', $last );

            foreach ( $release_dates as $release_date ) {
                $ym = 'Y' . preg_replace( '/^(\d\d\d\d)-(\d\d)-\d\d$/', '\\1\\2', $release_date );

                if ( isset($relevant_dates[$ym]) ) {
                    $relevant_dates[$ym]++;
                } else {
                    $relevant_dates[$ym] = 1;
                }
                $date_rows = ( $relevant_dates[$ym] > $date_rows ) ? $relevant_dates[$ym] : $date_rows;
            }
        }

        # here are fall-back values
        if ( !$last_year   ) { $last_year   = date( "Y" ); }
        if ( !$last_month  ) { $last_month  = date( "n" ); }
        if ( !$start_year  ) { $start_year  = intdiv( ($last_year * 12 + $last_month) - $gtfs_show_number_of_months, 12 ); }
        if ( !$start_month ) { $start_month = (($last_year * 12 + $last_month) - $gtfs_show_number_of_months) % 12 + 1; }
        if ( !$date_rows   ) { $date_rows   = 1; }

        # echo 'last_year = ' . $last_year . ', start_year = ' . $start_year . ', last_month = ' . $last_month . ', start_month = ' . $start_month . ', date_rows = ' . $date_rows . "<br>\n\n";

        echo '<div style="display: grid; grid-template-rows: ';
        for ( $i = $date_rows; $i > 0; $i-- ) {
            echo '[date' . $i . '] 1fr ';
        }
        echo '[line] 30px [month] 1fr; grid-template-columns: [dots0] 0.5fr ';

        $month_div_data = array();
        $number_of_vertical_bars = 0;
        # start_year
        for ( $m = $start_month; $m <= 12; $m++ ) {
            $time_line_covers_boxes++;
            printf( "[m%04d%02d] 1fr ", $start_year, $m );
            array_push( $month_div_data, sprintf( "<div style=\"grid-column: m%04d%02d; grid-row: month; font-weight: bold; background-color: %s; padding: 0.2em;\">%s '%02d</div>", $start_year, $m, $months_colour[$m%2], $months_short[$m-1], $start_year % 2000 ) );
        }
        echo '[vbar' . (++$number_of_vertical_bars) . '] 3px ';

        # interim years, not always present
        for ( $y = $start_year+1; $y < $last_year; $y++ ) {
            for ( $m = 1; $m <= 12; $m++ ) {
                $time_line_covers_boxes++;
                printf( "[m%04d%02d] 1fr ", $y, $m );
                array_push( $month_div_data, sprintf( "<div style=\"grid-column: m%04d%02d; grid-row: month; font-weight: bold; background-color: %s; padding: 0.2em;\">%s '%02d</div>", $y, $m, $months_colour[$m%2], $months_short[$m-1], $y % 2000 ) );
            }
            echo '[vbar' . (++$number_of_vertical_bars) . '] 3px ';
        }
        # this year
        for ( $m = 1; $m <= $last_month; $m++ ) {
            $time_line_covers_boxes++;
            printf( "[m%04d%02d] 1fr ", $last_year, $m );
            array_push( $month_div_data, sprintf( "<div style=\"grid-column: m%04d%02d; grid-row: month; font-weight: bold; background-color: %s; padding: 0.2em;\">%s '%02d</div>", $last_year, $m, $months_colour[$m%2], $months_short[$m-1], $last_year % 2000 ) );
        }
        echo '[arrow-right] 0.5fr; text-align:center; border: 1px dotted gray; border-radius: 5px; padding: 0.5em;">';
        echo "\n\n";

        # print vertical bars for the changes of year

        for ( $i = 1; $i <= $number_of_vertical_bars; $i++ ) {
            echo '    <div style="grid-column: vbar' . ($i) . '; grid-row: date' . $date_rows . ' / span ' . ($date_rows+2) . '; background: silver;"></div>' . "\n";
        }
        echo "\n";

        # print dots in time line where we start (or have longer gaps: todo)

        for ( $i = 0; $i < $number_of_dot_boxes; $i++ ) {
            echo '    <div style="grid-column: dots' . $i . '; grid-row: line;"><img src="/img/dots.png" style="margin-top: 10px; margin-bottom: 10px; margin-right: -50%; text-align:right; height: 10px; "/></div>' . "\n";
        }
        echo "\n";

        echo '    <div style="grid-column: m' . sprintf("%04d%02d",$start_year,$start_month) . ' / span ' . ($time_line_covers_boxes+$number_of_vertical_bars) . '; grid-row: line; margin-top: 10px; margin-bottom: 10px;
                background-image: -moz-linear-gradient(right, #aaaaaa 0%, gray 100%); /* FF3.6+ */
                background-image: -webkit-gradient(linear, left top, right bottom, color-stop(0%,#aaaaaa), color-stop(100%,#gray)); /* Chrome,Safari4+ */
                background-image: -webkit-linear-gradient(left,  #aaaaaa 0%,#gray 100%); /* Chrome10+,Safari5.1+ */
                background-image: -o-linear-gradient(left,  #aaaaaa 0%,#gray 100%); /* Opera 11.10+ */
                background-image: -ms-linear-gradient(left,  #aaaaaa 0%,#gray 100%); /* IE10+ */
                background-image: linear-gradient(to right,  #aaaaaa 0%,#gray 100%); /* W3C */"></div>' . "\n\n";

        echo '    <div style="grid-column: arrow-right; grid-row: line"><img src="/img/arrow-right.png" style="margin-top: 5px; margin-bottom: 5px; margin-left: -50%; text-align:left; height: 20px;"/></div>' . "\n\n";

        foreach ( $month_div_data as $div_data ) {
            echo "    " . $div_data . "\n";
        }

    }


    function CreateGtfsEntry( $feed ) {

        $SqliteDb = FindGtfsSqliteDb( $feed, '' );

        if ( $SqliteDb != '' ) {

            try {

                $start_time = gettimeofday(true);

                $db         = new SQLite3( $SqliteDb );

                $sql        = "SELECT * FROM ptna";

                $ptna       = $db->querySingle( $sql, true );

                $sql        = "SELECT * FROM feed_info";

                $feed_info  = $db->querySingle( $sql, true );

                $LongTermSqliteDb = FindGtfsSqliteDb( $feed, 'long-term' );
                if ( $LongTermSqliteDb ) {
                    $lt = GetPtnaDetails( $feed, 'long-term' );
                    if ( $lt['release_date'] ) {
                        if ( $lt['language'] == 'de' ) {
                            $long_term_img_title = 'Langzeit-Version von ' . $lt['release_date'];
                        } else {
                            $long_term_img_title = 'long term version as of ' . $lt['release_date'];
                        }
                    } else {
                        if ( $ptna['language'] == 'de' ) {
                            $long_term_img_title = 'Langzeit-Version';
                        } else {
                            $long_term_img_title = 'long term version';
                        }
                    }
                }
                $PreviousSqliteDb = FindGtfsSqliteDb( $feed, 'previous' );
                if ( $PreviousSqliteDb ) {
                    $prev = GetPtnaDetails( $feed, 'previous' );
                    if ( $prev['release_date'] ) {
                        if ( $ptna['language'] == 'de' ) {
                            $previous_img_title = 'vorherige Version von ' . $prev['release_date'];
                            $compare_img_title  = 'vergleiche Versionen';
                        } else {
                            $previous_img_title = 'previous version as of ' . $prev['release_date'];
                            $compare_img_title  = 'compare versions';
                        }
                    } else {
                        if ( $ptna['language'] == 'de' ) {
                            $previous_img_title = 'vorherige Version';
                            $compare_img_title  = 'vergleiche Versionen';
                        } else {
                            $previous_img_title = 'previous version';
                            $compare_img_title  = 'compare versions';
                        }
                    }
                }

                echo '                        <tr class="gtfs-tablerow">' . "\n";
                echo '                            <td class="gtfs-name"><a href="routes.php?feed=' . urlencode($feed) . '">' . htmlspecialchars($feed) . '</a> ';
#                if ( $LongTermSqliteDb ) {
#                    echo '<a href="routes.php?feed=' . urlencode($feed) . '&release_date=long-term"><img src="/img/long-term19.png" title="' . htmlspecialchars($long_term_img_title) . '" /></a> ';
#                }
#                if ( $PreviousSqliteDb ) {
#                    echo '<a href="routes.php?feed=' . urlencode($feed) . '&release_date=previous"><img src="/img/previous.svg" width="19px" height="19px" title="' . htmlspecialchars($previous_img_title) . '" /></a> ';
#                    echo '<a href="/gtfs/compare-feeds.php?feed=' . urlencode($feed) . '"><img src="/img/compare19.png" title="' . htmlspecialchars($compare_img_title) . '" /></a>';
#                }
                echo '</td>' . "\n";
                if ( $ptna["network_name"] ) {
                    if ( $ptna["network_name_url"] ) {
                        echo '                            <td class="gtfs-text"><a target="_blank" href="' . $ptna["network_name_url"] . '">' . htmlspecialchars($ptna["network_name"]) . '</a></td>' . "\n";
                    } else {
                        echo '                            <td class="gtfs-text">' . htmlspecialchars($ptna["network_name"]) . '</td>' . "\n";
                    }
                } else {
                    echo '                            <td class="gtfs-text">&nbsp;</td>' . "\n";
                }
                if ( isset($feed_info["feed_publisher_name"]) ) {
                    if ( $feed_info["feed_publisher_url"] ) {
                        echo '                            <td class="gtfs-text"><a target="_blank" href="' . $feed_info["feed_publisher_url"] . '" title="From GTFS">' . htmlspecialchars($feed_info["feed_publisher_name"]) . '</a></td>' . "\n";
                    } else {
                        echo '                            <td class="gtfs-text">' . htmlspecialchars($feed_info["feed_publisher_name"]) . '</td>' . "\n";
                    }
                } else {
                    if ( $ptna["feed_publisher_url"] ) {
                        echo '                            <td class="gtfs-text"><a target="_blank" href="' . $ptna["feed_publisher_url"] . '" title="From PTNA">' . htmlspecialchars($ptna["feed_publisher_name"]) . '</a></td>' . "\n";
                    } else {
                        echo '                            <td class="gtfs-text">' . htmlspecialchars($ptna["feed_publisher_name"]) . '</td>' . "\n";
                    }
                }
                if ( isset($feed_info["feed_start_date"]) ) {
                    if ( preg_match( "/^(\d{4})(\d{2})(\d{2})$/", $feed_info["feed_start_date"], $parts ) ) {
                        echo '                            <td class="gtfs-date">' . $parts[1] . '-' .  $parts[2] . '-' .  $parts[3] . '</td>' . "\n";
                    } else {
                        echo '                            <td class="gtfs-date">' . htmlspecialchars($feed_info["feed_start_date"]) . '</td>' . "\n";
                    }
                } else {
                    echo '                            <td class="gtfs-date">&nbsp;</td>' . "\n";
                }
                if ( isset($feed_info["feed_end_date"]) ) {
                    if ( preg_match( "/^(\d{4})(\d{2})(\d{2})$/", $feed_info["feed_end_date"], $parts ) ) {
                        $class = "gtfs-date";
                        $today = new DateTime();
                        if ( $feed_info["feed_end_date"] < $today->format('Ymd') )
                        {
                            $class = "gtfs-dateold";
                        }
                        echo '                            <td class="' . $class . '">' . $parts[1] . '-' .  $parts[2] . '-' .  $parts[3] . '</td>' . "\n";
                    } else {
                        echo '                            <td class="gtfs-date">' . htmlspecialchars($feed_info["feed_end_date"]) . '</td>' . "\n";
                    }
                } else {
                    echo '                            <td class="gtfs-date">&nbsp;</td>' . "\n";
                }
                if ( isset($feed_info["feed_version"]) ) {
                    echo '                            <td class="gtfs-number">' . htmlspecialchars($feed_info["feed_version"]) . '</td>' . "\n";
                } else {
                    echo '                            <td class="gtfs-number">&nbsp;</td>' . "\n";
                }
                if ( isset($ptna["release_date"]) ) {
                    $tdclass    = "gtfs-date";
                    $txclasstag = "";
                    if ( preg_match( "/^(\d{4})-(\d{2})-(\d{2})$/", $ptna["release_date"], $parts ) ) {
                        $timestampTwoDaysAgo   = time() - ( 2 * 24 * 3600);
                        $timestampFiveDaysAgo  = time() - ( 5 * 24 * 3600);
                        $timestampTenDaysAgo   = time() - (10 * 24 * 3600);
                        $release_day           = new DateTime( $ptna["release_date"] );
                        $timestampReleaseDate  = $release_day->format( 'U' );
                        if ( $timestampReleaseDate >= $timestampTenDaysAgo )
                        {
                            $tdclass = "gtfs-datenew";
                            if ( $timestampReleaseDate >= $timestampFiveDaysAgo )
                            {
                                $tdclass = "gtfs-datenewer";
                                if ( $timestampReleaseDate >= $timestampTwoDaysAgo )
                                {
                                    $tdclass    = "gtfs-dateverynew";
                                    $txclasstag = 'class="gtfs-whitetext"';
                                }
                            }
                        }
                    }
                    if ( $ptna["release_url"] ) {
                        echo '                            <td class="' . $tdclass . '"><a target="_blank" href="' . $ptna["release_url"] . '"><span ' . $txclasstag . '>' . htmlspecialchars($ptna["release_date"]) . '</span></a></td>' . "\n";
                    } else {
                        echo '                            <td class="' . $tdclass . '"><span ' . $txclasstag . '>' . htmlspecialchars($ptna["release_date"]) . '</span></td>' . "\n";
                    }
                } else {
                    echo '                            <td class="gtfs-date">&nbsp;</td>' . "\n";
                }
                if ( isset($ptna["prepared"]) ) {
                    $tdclass    = "gtfs-date";
                    $txclasstag = "";
                    if ( preg_match( "/^(\d{4})-(\d{2})-(\d{2})$/", $ptna["prepared"], $parts ) ) {
                        $timestampTwoDaysAgo   = time() - ( 2 * 24 * 3600);
                        $timestampFiveDaysAgo  = time() - ( 5 * 24 * 3600);
                        $timestampTenDaysAgo   = time() - (10 * 24 * 3600);
                        $release_day           = new DateTime( $ptna["prepared"] );
                        $timestampReleaseDate  = $release_day->format( 'U' );
                        if ( $timestampReleaseDate >= $timestampTenDaysAgo )
                        {
                            $tdclass = "gtfs-datenew";
                            if ( $timestampReleaseDate >= $timestampFiveDaysAgo )
                            {
                                $tdclass = "gtfs-datenewer";
                                if ( $timestampReleaseDate >= $timestampTwoDaysAgo )
                                {
                                    $tdclass    = "gtfs-dateverynew";
                                    $txclasstag = 'class="gtfs-whitetext"';
                                }
                            }
                        }
                    }
                    echo '                            <td class="' . $tdclass . '"><span ' . $txclasstag . '>' . htmlspecialchars($ptna["prepared"]) . '</span></td>' . "\n";
                } else {
                    echo '                            <td class="gtfs-date">&nbsp;</td>' . "\n";
                }
                if ( isset($ptna["details"]) ) {
                    $details = $ptna["details"];
                } else {
                    $details = 'Details, ...';
                }
                echo '                            <td class="gtfs-text"><a href="/en/gtfs-details.php?feed=' . urlencode($feed) . '">' . htmlspecialchars($details) . '</a> ';
                if ( $LongTermSqliteDb ) {
                    echo '<a href="/en/gtfs-details.php?feed=' . urlencode($feed) . '&release_date=long-term"><img src="/img/long-term19.png" title="' . htmlspecialchars($long_term_img_title) . '" /></a> ';
                }
                if ( $PreviousSqliteDb ) {
                    echo '<a href="/en/gtfs-details.php?feed=' . urlencode($feed) . '&release_date=previous"><img src="/img/previous.svg" width="19px" height="19px" title="' . htmlspecialchars($previous_img_title) . '" /></a> ';
                    echo '<a href="/gtfs/compare-feeds.php?feed=' . urlencode($feed) . '"><img src="/img/compare19.png" title="' . htmlspecialchars($compare_img_title) . '" /></a>';
                }
                echo '</td>' . "\n";
                echo '                        </tr>' . "\n";

                $db->close();

                $stop_time = gettimeofday(true);

                return $stop_time - $start_time;

            } catch ( Exception $ex ) {
                echo '                        <tr class="gtfs-tablerow">' . "\n";
                echo '                            <td class="gtfs-name">' . htmlspecialchars($feed) . '</a></td>' . "\n";
                echo '                            <td class="gtfs-comment" colspan=8>SQLite DB: error opening data base</td>' . "\n";
                echo '                        </tr>' . "\n";
            }
        } else {
            echo '                        <tr class="gtfs-tablerow">' . "\n";
            echo '                            <td class="gtfs-name">' . htmlspecialchars($feed) . '</a></td>' . "\n";
            echo '                            <td class="gtfs-comment" colspan=8>SQLite DB: data base not found (data not yet available?)</td>' . "\n";
            echo '                        </tr>' . "\n";
        }

        return 0;
    }

    function CreateGtfsRoutesEntry( $feed, $release_date ) {

        ob_implicit_flush(true);


        $SqliteDb = FindGtfsSqliteDb( $feed, $release_date );

        if ( $SqliteDb != '' ) {

            if (  $feed ) {

                try {

                    $today      = new DateTime();

                    set_time_limit( 30 );

                    $start_time = gettimeofday(true);

                    $db         = new SQLite3( $SqliteDb );

                    $sql        = "SELECT * FROM ptna";

                    $ptna       = $db->querySingle( $sql, true );

                    $sql        = "SELECT name FROM sqlite_master WHERE type='table' AND name='ptna_routes';";

                    $sql_master = $db->querySingle( $sql, true );

                    if ( $sql_master['name'] ) {
                        # 1. ptna_routes because ptna_routes.route_id can be ''
                        # 2. routes      because routes.route_id is what we want and
                        #                2nd appearance overwrites 1st appearance of identical column names in the returned hash
                        $sql        = "SELECT DISTINCT    ptna_routes.*,routes.*,agency.*
                                       FROM               routes
                                       LEFT OUTER JOIN    ptna_routes ON   routes.route_id  = ptna_routes.route_id
                                       JOIN               agency      ON   routes.agency_id = agency.agency_id;";
                    } else {
                        $sql        = "SELECT DISTINCT    routes.*,agency.*
                                       FROM               routes
                                       JOIN               agency      ON   routes.agency_id = agency.agency_id;";
                    }

                    $outerresult = $db->query( $sql );

                    $outerresult_array = array();
                    while ( $outerrow=$outerresult->fetchArray(SQLITE3_ASSOC) ) {
                        if ( preg_match('/^([0-9]+)(.*)$/',$outerrow['route_short_name'],$parts) ) {
                            $rsn = sprintf("%20s%s ",$parts[1],$parts[2]);
                        } elseif ( preg_match('/^([^0-9][^0-9]*)([0-9][0-9]*)(.*)$/',$outerrow['route_short_name'],$parts) ) {
                            $rsn = sprintf("%s%20s%s ",$parts[1],$parts[2],$parts[3]);
                        } else {
                            $rsn = sprintf("%s%20s ",$outerrow['route_short_name'],' ');
                        }
                        $outerrow['sort_key'] = RouteType2OsmRouteImportance($outerrow['route_type']) . ";" . $rsn . ";" . $outerrow['route_id'];
                        array_push( $outerresult_array, $outerrow );
                    }
                    usort($outerresult_array,"sort_array_by_sort_key");

                    $alternative_or_not    = 'alt';
                    $last_route_short_name = '__dummy__';
                    $last_agency_name      = '__dummy__';
                    $last_route_type       = '__dummy__';
                    $last_route_desc       = '__dummy__';

                    foreach ( $outerresult_array as $outerrow ) {

                        $outerrow["route_desc"] = isset($outerrow["route_desc"]) ? $outerrow["route_desc"] : '';

                        if ( $outerrow["route_short_name"] != $last_route_short_name ||
                             $outerrow["agency_name"]      != $last_agency_name      ||
                             $outerrow["route_type"]       != $last_route_type       ||
                             $outerrow["route_desc"]       != $last_route_desc          ) {
                            if ( $alternative_or_not ) {
                                $alternative_or_not = '';
                            } else {
                                $alternative_or_not = 'alt';
                            }
                            $last_route_short_name = $outerrow["route_short_name"];
                            $last_agency_name      = $outerrow["agency_name"];
                            $last_route_type       = $outerrow["route_type"];
                            if ( isset($outerrow["route_desc"]) ) {
                                $last_route_desc       = $outerrow["route_desc"];
                            }
                        }

                        if ( $outerrow["route_type"] ) {
                            $route_type_text = RouteType2String( $outerrow["route_type"] );
                            $osm_route_type  = RouteType2OsmRoute( $outerrow["route_type"] );
                        } else {
                            $route_type_text = '???';
                            $osm_route_type  = 'not set';
                        }

                        if ( $ptna['consider_calendar'] ) {
                            $sql = sprintf( "SELECT DISTINCT trip_id
                                             FROM            trips
                                             JOIN            calendar ON trips.service_id = calendar.service_id
                                             WHERE           trips.route_id='%s' AND %s >= calendar.start_date AND %s <= calendar.end_date;", SQLite3::escapeString($outerrow["route_id"]), $today->format('Ymd'), $today->format('Ymd') );
                        } else {
                            $sql = sprintf( "SELECT DISTINCT trip_id
                                             FROM            trips
                                             WHERE           trips.route_id='%s';", SQLite3::escapeString($outerrow["route_id"]) );
                        }

                        $innerresult = $db->query( $sql );

                        if ( isset($outerrow['min_start_date']) && isset($outerrow['max_end_date']) ) {  # from ptna_routes, filled during gtfs-aggregation.pl
                            $min_start_date = $outerrow["min_start_date"];
                            $max_end_date   = $outerrow["max_end_date"];
                        } else {
                            $min_start_date = '20500101';
                            $max_end_date   = '19700101';
                            while ( $innerrow=$innerresult->fetchArray(SQLITE3_ASSOC) ) {
                                $start_end_array = GetStartEndDateOfIdenticalTrips( $db, $innerrow["trip_id"] );
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
                            }
                        }

                        $route_short_name = "not set";
                        if ( $outerrow["route_short_name"] ) {
                            $route_short_name = $outerrow["route_short_name"];
                        }

                        $id_string = preg_replace( '/[^0-9A-Za-z_.-]/', '_', $osm_route_type . '_' . $route_short_name );
                        if ( isset($id_markers[$id_string]) ) {                                        # if the same combination appears more than one, add a number as suffix (e.g. "Bus A" of VMS in Saxony, Germany
                            $id_markers[$id_string]++;
                            $id_string .= '-' . $id_markers[$id_string];
                        } else {
                            $id_markers[$id_string] = 1;
                        }

                        echo '                        <tr id="' . $id_string . '" class="gtfs-tablerow' . $alternative_or_not . '">' . "\n";
                        echo '                            <td class="gtfs-name"><a href="trips.php?feed=' . urlencode($feed) . '&release_date=' . urlencode($release_date) . '&route_id=' . urlencode($outerrow["route_id"]) . '"><span class="route_short_name">' . htmlspecialchars($route_short_name) . '</span><span class="route_id" style="display: none;">' . htmlspecialchars($outerrow["route_id"]) . '</span></a></td>' . "\n";
                        echo '                            <td class="gtfs-text"><span class="route_type">' . htmlspecialchars($route_type_text) . '</span></td>' . "\n";
                        if ( preg_match( "/^(\d{4})(\d{2})(\d{2})$/", $min_start_date, $parts ) ) {
                            $class = "gtfs-date";
                            $today = new DateTime();
                            if ( $min_start_date > $today->format('Ymd') )
                            {
                                $class = "gtfs-datenew";
                            }
                            echo '                            <td class="' . $class . '"><span class="valid_from">' . $parts[1] . '-' .  $parts[2] . '-' .  $parts[3] . '</span></td>' . "\n";
                        } else {
                            echo '                            <td class="gtfs-date"><span class="valid_from">' . htmlspecialchars($min_start_date) . '</span></td>' . "\n";
                        }
                        if ( preg_match( "/^(\d{4})(\d{2})(\d{2})$/", $max_end_date, $parts ) ) {
                            $class = "gtfs-date";
                            $today = new DateTime();
                            if ( $max_end_date < $today->format('Ymd') )
                            {
                                $class = "gtfs-dateold";
                            }
                            echo '                            <td class="' . $class . '"><span class="valid_until">' . $parts[1] . '-' .  $parts[2] . '-' .  $parts[3] . '</span></td>' . "\n";
                        } else {
                            echo '                            <td class="gtfs-date"><span class="valid_until">' . htmlspecialchars($max_end_date) . '</span></td>' . "\n";
                        }
                        if ( $outerrow["normalized_route_long_name"] ) {
                            echo '                            <td class="gtfs-text"><span class="route_long_name">' . htmlspecialchars($outerrow["normalized_route_long_name"]) . '</span></td>' . "\n";
                        } elseif ( $outerrow["route_long_name"] ) {
                            echo '                            <td class="gtfs-text"><span class="route_long_name">' . htmlspecialchars($outerrow["route_long_name"]) . '</span></td>' . "\n";
                        } elseif ( isset($outerrow["route_desc"]) ) {
                            echo '                            <td class="gtfs-text"><span class="route_long_name">' . htmlspecialchars($outerrow["route_desc"]) . '</span></td>' . "\n";
                        } else {
                            echo '                            <td class="gtfs-text"><span class="route_long_name">' . htmlspecialchars($outerrow["route_id"]) . '</span></td>' . "\n";
                        }
                        if ( $outerrow["agency_url"] ) {
                            echo '                            <td class="gtfs-text"><a target="_blank" href="' . $outerrow["agency_url"]. '"><span class="agency_name">' . htmlspecialchars($outerrow["agency_name"]) . '</span></a></td>' . "\n";
                        } else {
                            echo '                            <td class="gtfs-text"><span class="agency_name">' . htmlspecialchars($outerrow["agency_name"]) . '</span></td>' . "\n";
                        }

                        $sql = "SELECT name FROM sqlite_master WHERE type='table' AND name='ptna_routes_comments';";
                        $sql_master = $db->querySingle( $sql, true );

                        if ( $sql_master['name'] ) {
                            $sql    = sprintf( "SELECT *
                                                FROM   ptna_routes_comments
                                                WHERE  route_id='%s';",
                                                SQLite3::escapeString($outerrow["route_id"])
                                                );
                            $ptnarow = $db->querySingle( $sql, true );

                            echo '                            <td class="gtfs-comment">' . HandlePtnaComment($ptnarow) . '</td>' . "\n";
                        } else {
                            echo '                            <td class="gtfs-comment">&nbsp;</td>' . "\n";
                        }
                        echo '                        </tr>' . "\n";
                    }
                    $db->close();

                    $stop_time = gettimeofday(true);

                    return $stop_time - $start_time;

                } catch ( Exception $ex ) {
                    echo "CreateGtfsRoutesEntry(): Sqlite DB could not be opened: " . htmlspecialchars($ex->getMessage()) . "\n";
                }
            }
        } else {
            echo "Sqlite DB not found for feed = '" . htmlspecialchars($feed) . "'\n";
        }

        return 0;
    }


    function CreateGtfsTripsEntry( $feed, $release_date, $route_id, $route_short_name ) {

        $SqliteDb = FindGtfsSqliteDb( $feed, $release_date );

        if ( $SqliteDb != '' ) {

           if (  $route_id ) {

                try {

                    set_time_limit( 30 );

                    $start_time = gettimeofday(true);

                    $db         = new SQLite3( $SqliteDb );

                    $sql        = sprintf( "SELECT   trip_id
                                            FROM     trips
                                            WHERE    route_id='%s'
                                            ORDER BY trip_id;",
                                            SQLite3::escapeString($route_id)
                                         );

                    $outerresult = $db->query( $sql );

                    $trip_array = array ();

                    while ( $outerrow=$outerresult->fetchArray(SQLITE3_ASSOC) ) {

                        $sql = sprintf( "SELECT   GROUP_CONCAT(stop_times.stop_id,'|') AS stop_id_list, GROUP_CONCAT(stops.stop_name,'  |') AS stop_name_list
                                         FROM     stops
                                         JOIN     stop_times on stop_times.stop_id = stops.stop_id
                                         WHERE    stop_times.trip_id='%s'
                                         ORDER BY CAST (stop_times.stop_sequence AS INTEGER);",
                                         SQLite3::escapeString($outerrow["trip_id"])
                                      );

                        $innerrow = $db->querySingle( $sql, true );

                        if ( $innerrow["stop_id_list"] && !isset($stoplist[$innerrow["stop_id_list"]]) ) {
                            $stoplist[$innerrow["stop_id_list"]] = $outerrow["trip_id"];
                            # the next 4 lines are used to sort the output 'trip_array' by frist, by last and then by via stop names
                            $stop_name_array = explode( '  |', $innerrow["stop_name_list"] );
                            $first_stop_name = array_shift( $stop_name_array );
                            $last_stop_name  = array_pop(   $stop_name_array );
                            $stop_names      = $first_stop_name . '  |' . $last_stop_name . '  |' . implode('  |',$stop_name_array) . '  |' . $outerrow["trip_id"];
                            array_push( $trip_array, $stop_names );
                        }
                    }

                    sort( $trip_array );

                    $index = 1;

                    $sql = "SELECT name FROM sqlite_master WHERE type='table' AND name='ptna_trips_comments';";
                    $sql_master = $db->querySingle( $sql, true );
                    if ( $sql_master['name'] ) {
                        $join_statement = 'LEFT OUTER JOIN ptna_trips_comments ON trips.trip_id = ptna_trips_comments.trip_id';
                    } else {
                        $join_statement = '';
                    }

                    foreach ( $trip_array as $stop_names ) {

                        $stop_name_array = explode( '  |', $stop_names );
                        $trip_id         = array_pop($stop_name_array);
                        $first_stop_name = array_shift( $stop_name_array );
                        $last_stop_name  = array_shift( $stop_name_array ); # last stop name ist really the second in the list
                        $via_stop_names  = implode( ' => ', $stop_name_array );

                        $sql    = sprintf( "SELECT *
                                            FROM   trips
                                            %s
                                            WHERE  trips.trip_id='%s';",
                                            $join_statement, SQLite3::escapeString($trip_id)
                                         );

                        $ptnarow = $db->querySingle( $sql, true );

                        $start_end_array = GetStartEndDateOfIdenticalTrips( $db, $trip_id );

                        echo '                        <tr class="gtfs-tablerow">' . "\n";
                        echo '                            <td class="gtfs-number">' . $index . '</td>' . "\n";
                        echo '                            <td class="gtfs-name"><a href="single-trip.php?feed=' . urlencode($feed) . '&release_date=' . urlencode($release_date) . '&trip_id=' . urlencode($trip_id) . '">' . htmlspecialchars($trip_id) . '</a></td>' . "\n";
                        if ( preg_match( "/^(\d{4})(\d{2})(\d{2})$/", $start_end_array["start_date"], $parts ) ) {
                            $class = "gtfs-date";
                            $today = new DateTime();
                            if ( $start_end_array["start_date"] > $today->format('Ymd') )
                            {
                                $class = "gtfs-datenew";
                            }
                            echo '                            <td class="' . $class . '">' . $parts[1] . '-' .  $parts[2] . '-' .  $parts[3] . '</td>' . "\n";
                        } else {
                            echo '                            <td class="gtfs-date">' . htmlspecialchars($start_end_array["start_date"]) . '</td>' . "\n";
                        }
                        if ( preg_match( "/^(\d{4})(\d{2})(\d{2})$/", $start_end_array["end_date"], $parts ) ) {
                            $class = "gtfs-date";
                            $today = new DateTime();
                            if ( $start_end_array["end_date"] < $today->format('Ymd') )
                            {
                                $class = "gtfs-dateold";
                            }
                            echo '                            <td class="' . $class . '">' . $parts[1] . '-' .  $parts[2] . '-' .  $parts[3] . '</td>' . "\n";
                        } else {
                            echo '                            <td class="gtfs-date">' . htmlspecialchars($start_end_array["end_date"]) . '</td>' . "\n";
                        }
                        echo '                            <td class="gtfs-name">'     . htmlspecialchars($first_stop_name)            . '</td>' . "\n";
                        echo '                            <td class="gtfs-text">'     . htmlspecialchars($via_stop_names)             . '</td>' . "\n";
                        echo '                            <td class="gtfs-name">'     . htmlspecialchars($last_stop_name)             . '</td>' . "\n";
                        echo '                            <td class="gtfs-comment">'  . HandlePtnaComment($ptnarow)                   . '</td>' . "\n";
                        echo '                        </tr>' . "\n";
                        $index++;
                    }

                    $db->close();

                    $stop_time = gettimeofday(true);

                    return $stop_time - $start_time;

                } catch ( Exception $ex ) {
                    echo "Sqlite DB could not be opened: " . $ex->getMessage() . "\n";
                }
            }
        } else {
            echo "Sqlite DB not found for feed = '" . htmlspecialchars($feed) . "'\n";
        }

        return 0;
    }


    function CreateOsmTaggingSuggestion( $feed, $release_date, $trip_id ) {

        $SqliteDb = FindGtfsSqliteDb( $feed, $release_date );

        if ( $SqliteDb != '') {

           if ( $trip_id ) {

               try {

                    set_time_limit( 30 );

                    $start_time = gettimeofday(true);

                    $db = new SQLite3( $SqliteDb );

                    $sql        = "SELECT name FROM sqlite_master WHERE type='table' AND name='osm';";

                    $sql_master = $db->querySingle( $sql, true );

                    if ( $sql_master['name'] ) {
                        $sql        = "SELECT * FROM osm";

                        $osm       = $db->querySingle( $sql, true );
                    }

                    $sql  = "SELECT * FROM ptna";

                    $ptna = $db->querySingle( $sql, true );

                    $sql        = "SELECT name FROM sqlite_master WHERE type='table' AND name='ptna_stops';";

                    $sql_master = $db->querySingle( $sql, true );

                    if ( $sql_master['name'] ) {
                        $join_ptna_stops = 'LEFT OUTER JOIN ptna_stops ON stops.stop_id = ptna_stops.stop_id';
                    } else {
                        $join_ptna_stops = '';
                    }

                    $sql        = sprintf( "SELECT trip_id
                                            FROM   ptna_trips
                                            WHERE  trip_id='%s' OR list_trip_ids LIKE '%s|%%' OR list_trip_ids LIKE '%%|%s|%%' OR list_trip_ids LIKE '%%|%s'",
                                            SQLite3::escapeString($trip_id), SQLite3::escapeString($trip_id), SQLite3::escapeString($trip_id), SQLite3::escapeString($trip_id) );

                    $trip       = $db->querySingle( $sql, true );

                    $rep_trip_id    = $trip['trip_id'];

                    if ( $rep_trip_id ) {
                        $sql = sprintf( "SELECT *
                                         FROM   routes
                                         JOIN   trips ON trips.route_id = routes.route_id
                                         WHERE  trip_id='%s';",
                                         SQLite3::escapeString($rep_trip_id)
                                      );

                        $routes = $db->querySingle( $sql, true );

                        $sql = sprintf( "SELECT *
                                         FROM   trips
                                         WHERE  trip_id='%s';",
                                         SQLite3::escapeString($rep_trip_id)
                                      );

                        $trips = $db->querySingle( $sql, true );

                        $sql = sprintf( "SELECT   *
                                         FROM     stops
                                         %s
                                         JOIN     stop_times ON stop_times.stop_id = stops.stop_id
                                         WHERE    stop_times.trip_id='%s'
                                         ORDER BY CAST (stop_times.stop_sequence AS INTEGER) ASC
                                         LIMIT 1;",
                                         $join_ptna_stops, SQLite3::escapeString($rep_trip_id)
                                      );

                        $stops1 = $db->querySingle( $sql, true );

                        $sql = sprintf( "SELECT   *
                                         FROM     stops
                                         %s
                                         JOIN     stop_times ON stop_times.stop_id = stops.stop_id
                                         WHERE    stop_times.trip_id='%s'
                                         ORDER BY CAST (stop_times.stop_sequence AS INTEGER) DESC
                                         LIMIT 1;",
                                         $join_ptna_stops, SQLite3::escapeString($rep_trip_id)
                                      );

                        $stops2 = $db->querySingle( $sql, true );

                        $sql = sprintf( "SELECT   agency.agency_name,agency.agency_url
                                         FROM     agency
                                         JOIN     routes ON agency.agency_id = routes.agency_id
                                         WHERE    routes.route_id='%s'
                                         LIMIT    1;",
                                         SQLite3::escapeString($routes['route_id'])
                                      );

                        $agency = $db->querySingle( $sql, true );

                        $osm_route          = htmlspecialchars(RouteType2OsmRoute($routes['route_type']));
                        $osm_vehicle        = OsmRoute2Vehicle($osm_route,$ptna['language']);
                        $osm_ref            = $routes['route_short_name']       ? htmlspecialchars($routes['route_short_name'])     : '???';
                        if ( $osm['gtfs_short_name_hack1']                      &&
                            $routes['route_long_name']                         &&
                            $routes['route_id']                                &&
                            $routes['route_long_name'] != $routes['route_id']      ) {
                            $osm_ref = htmlspecialchars( $routes['route_long_name'] );
                        }
                        if ( preg_match("/$osm_vehicle$/",$osm_ref) ) {
                            $osm_ref = preg_replace( "/\s+$osm_vehicle$/", "", $osm_ref );
                        }
                        $osm_colour         = $routes['route_color']            ? htmlspecialchars($routes['route_color'])          : 'ffffff';
                        $osm_website        = $routes['route_url']              ? htmlspecialchars($routes['route_url'])            : htmlspecialchars($agency['agency_url']);
                        $osm_from           = $stops1['normalized_stop_name']   ? htmlspecialchars($stops1['normalized_stop_name']) : htmlspecialchars($stops1['stop_name']);
                        $osm_to             = $stops2['normalized_stop_name']   ? htmlspecialchars($stops2['normalized_stop_name']) : htmlspecialchars($stops2['stop_name']);
                        $osm_network        = htmlspecialchars($osm['network']);
                        $osm_network_short  = htmlspecialchars($osm['network_short']);
                        $osm_network_guid   = htmlspecialchars($osm['network_guid']);
                        if ( $osm['gtfs_agency_is_operator'] ) {
                            if ( $agency['agency_name'] != 'Sonstige' ) {
                                $osm_operator   = htmlspecialchars($agency['agency_name']);
                            }
                        }
                        $osm_ref_trips          = htmlspecialchars( $trip_id );
                        $osm_gtfs_feed          = htmlspecialchars( $feed );
                        $osm_gtfs_release_date  = htmlspecialchars( $ptna["release_date"] );
                        $osm_gtfs_route_id      = htmlspecialchars( $routes['route_id'] );
                        $osm_gtfs_trip_id       = htmlspecialchars( $trip_id );
                        $osm_gtfs_shape_id      = htmlspecialchars( $trips['shape_id'] );
                        if ( $osm['trip_id_regex'] && preg_match("/^".$osm['trip_id_regex']."$/",$trip_id) ) {
                            $osm_gtfs_trip_id_like = preg_replace( "/".$osm['trip_id_regex']."/","\\1", $trip_id );
                            if ( !preg_match("/^^\(/",$osm['trip_id_regex']) ) {
                                $osm_gtfs_trip_id_like = "%" . $osm_gtfs_trip_id_like;
                            }
                            if ( !preg_match("/\)\\$$/",$osm['trip_id_regex']) ) {
                                $osm_gtfs_trip_id_like = $osm_gtfs_trip_id_like . "%";
                            }
                            $osm_gtfs_trip_id_like = htmlspecialchars( $osm_gtfs_trip_id_like );
                        }

                        # ROUTE-MASTER
                        echo '                    <table id="osm-route-master" style="float: left; margin-right: 20px;">' . "\n";
                        echo '                        <thead>' . "\n";
                        echo '                            <tr class="gtfs-tableheaderrow">' . "\n";
                        echo '                                <th class="gtfs-name">Route-Master</th>' . "\n";
                        echo '                                <th class="gtfs-name"><button class="button-create" type="button" onclick="route_master_osm()">Create *.osm template for JOSM</button></th>' . "\n";
                        echo '                            </tr>' . "\n";
                        echo '                            <tr class="gtfs-tableheaderrow">' . "\n";
                        echo '                                <th class="gtfs-name">Key</th>' . "\n";
                        echo '                                <th class="gtfs-name">Value</th>' . "\n";
                        echo '                            </tr>' . "\n";
                        echo '                        </thead>' . "\n";
                        echo '                        <tbody>' . "\n";
                        echo '                            <tr class="gtfs-tablerow">' . "\n";
                        echo '                                <td class="gtfs-name">type</td>' . "\n";
                        echo '                                <td class="gtfs-name">route_master</td>' . "\n";
                        echo '                            </tr>' . "\n";
                        echo '                            <tr class="gtfs-tablerow">' . "\n";
                        echo '                                <td class="gtfs-name">route_master</td>' . "\n";
                        echo '                                <td class="gtfs-name">' . $osm_route . '</td>' . "\n";
                        echo '                            </tr>' . "\n";
                        echo '                            <tr class="gtfs-tablerow">' . "\n";
                        echo '                                <td class="gtfs-name">ref</td>' . "\n";
                        echo '                                <td class="gtfs-name">' . $osm_ref . '</td>' . "\n";
                        echo '                            </tr>' . "\n";
                        if ( $osm_route ) {
                            echo '                            <tr class="gtfs-tablerow">' . "\n";
                            echo '                                <td class="gtfs-name">name</td>' . "\n";
                            echo '                                <td class="gtfs-text">' . $osm_vehicle . ' ' . $osm_ref . '</td>' . "\n";
                            echo '                            </tr>' . "\n";
                        }
                        if ( $osm_network ) {
                            echo '                            <tr class="gtfs-tablerow">' . "\n";
                            echo '                                <td class="gtfs-name">network</td>' . "\n";
                            echo '                                <td class="gtfs-text">' . $osm_network . '</td>' . "\n";
                            echo '                            </tr>' . "\n";
                        }
                        if ( $osm_network_guid ) {
                            echo '                            <tr class="gtfs-tablerow">' . "\n";
                            echo '                                <td class="gtfs-name">network:guid</td>' . "\n";
                            echo '                                <td class="gtfs-name">' . $osm_network_guid . '</td>' . "\n";
                            echo '                            </tr>' . "\n";
                        }
                        if ( $osm_network_short ) {
                            echo '                            <tr class="gtfs-tablerow">' . "\n";
                            echo '                                <td class="gtfs-name">network:short</td>' . "\n";
                            echo '                                <td class="gtfs-name">' . $osm_network_short . '</td>' . "\n";
                            echo '                            </tr>' . "\n";
                        }
                        if ( $osm_operator ) {
                            echo '                            <tr class="gtfs-tablerow">' . "\n";
                            echo '                                <td class="gtfs-name">operator</td>' . "\n";
                            echo '                                <td class="gtfs-text">' . $osm_operator . '</td>' . "\n";
                            echo '                            </tr>' . "\n";
                        }
                        if ( $osm_colour ) {
                            echo '                            <tr class="gtfs-tablerow">' . "\n";
                            echo '                                <td class="gtfs-name">colour</td>' . "\n";
                            echo '                                <td class="gtfs-name">#' . $osm_colour . '</td>' . "\n";
                            echo '                            </tr>' . "\n";
                        }
                        if ( $osm_website ) {
                            echo '                            <tr class="gtfs-tablerow">' . "\n";
                            echo '                                <td class="gtfs-name">website</td>' . "\n";
                            echo '                                <td class="gtfs-text">' . $osm_website . '</td>' . "\n";
                            echo '                            </tr>' . "\n";
                        }
                        echo '                            <tr class="gtfs-tablerow">' . "\n";
                        echo '                                <td class="gtfs-name">gtfs:feed</td>' . "\n";
                        echo '                                <td class="gtfs-name">' . $osm_gtfs_feed . '</td>' . "\n";
                        echo '                            </tr>' . "\n";
                        echo '                            <tr class="gtfs-tablerow">' . "\n";
                        echo '                                <td class="gtfs-name">gtfs:release_date</td>' . "\n";
                        echo '                                <td class="gtfs-name">' . $osm_gtfs_release_date . '</td>' . "\n";
                        echo '                            </tr>' . "\n";
                        if ( $osm_gtfs_route_id ) {
                            echo '                            <tr class="gtfs-tablerow">' . "\n";
                            echo '                                <td class="gtfs-name">gtfs:route_id</td>' . "\n";
                            echo '                                <td class="gtfs-name">' . $osm_gtfs_route_id . '</td>' . "\n";
                            echo '                            </tr>' . "\n";
                        }
                        echo '                        </tbody>' . "\n";
                        echo '                    </table>' . "\n";

                        # ROUTE
                        echo '                    <table id="osm-route">' . "\n";
                        echo '                        <thead>' . "\n";
                        echo '                            <tr class="gtfs-tableheaderrow">' . "\n";
                        echo '                                <th class="gtfs-name">Route</th>' . "\n";
                        echo '                                <th class="gtfs-name"><button class="button-create" type="button" onclick="route_osm()">Create *.osm template for JOSM</button></th>' . "\n";
                        echo '                            </tr>' . "\n";
                        echo '                            <tr class="gtfs-tableheaderrow">' . "\n";
                        echo '                                <th class="gtfs-name">Key</th>' . "\n";
                        echo '                                <th class="gtfs-name">Value</th>' . "\n";
                        echo '                            </tr>' . "\n";
                        echo '                        </thead>' . "\n";
                        echo '                        <tbody>' . "\n";
                        echo '                            <tr class="gtfs-tablerow">' . "\n";
                        echo '                                <td class="gtfs-name">type</td>' . "\n";
                        echo '                                <td class="gtfs-name">route</td>' . "\n";
                        echo '                            </tr>' . "\n";
                        echo '                            <tr class="gtfs-tablerow">' . "\n";
                        echo '                                <td class="gtfs-name">route</td>' . "\n";
                        echo '                                <td class="gtfs-name">' . $osm_route . '</td>' . "\n";
                        echo '                            </tr>' . "\n";
                        echo '                            <tr class="gtfs-tablerow">' . "\n";
                        echo '                                <td class="gtfs-name">ref</td>' . "\n";
                        echo '                                <td class="gtfs-name">' . $osm_ref . '</td>' . "\n";
                        echo '                            </tr>' . "\n";
                        if ( $osm_route ) {
                            echo '                            <tr class="gtfs-tablerow">' . "\n";
                            echo '                                <td class="gtfs-name">name</td>' . "\n";
                            echo '                                <td class="gtfs-text">' . $osm_vehicle . ' ' . $osm_ref . ': ' . $osm_from . ' => ' . $osm_to . '</td>' . "\n";
                            echo '                            </tr>' . "\n";
                        }
                        if ( $osm_network ) {
                            echo '                            <tr class="gtfs-tablerow">' . "\n";
                            echo '                                <td class="gtfs-name">network</td>' . "\n";
                            echo '                                <td class="gtfs-text">' . $osm_network . '</td>' . "\n";
                            echo '                            </tr>' . "\n";
                        }
                        if ( $osm_network_guid ) {
                            echo '                            <tr class="gtfs-tablerow">' . "\n";
                            echo '                                <td class="gtfs-name">network:guid</td>' . "\n";
                            echo '                                <td class="gtfs-name">' . $osm_network_guid . '</td>' . "\n";
                            echo '                            </tr>' . "\n";
                        }
                        if ( $osm_network_short ) {
                            echo '                            <tr class="gtfs-tablerow">' . "\n";
                            echo '                                <td class="gtfs-name">network:short</td>' . "\n";
                            echo '                                <td class="gtfs-name">' . $osm_network_short . '</td>' . "\n";
                            echo '                            </tr>' . "\n";
                        }
                        if ( $osm_operator ) {
                            echo '                            <tr class="gtfs-tablerow">' . "\n";
                            echo '                                <td class="gtfs-name">operator</td>' . "\n";
                            echo '                                <td class="gtfs-text">' . $osm_operator . '</td>' . "\n";
                            echo '                            </tr>' . "\n";
                        }
                        if ( $osm_colour ) {
                            echo '                            <tr class="gtfs-tablerow">' . "\n";
                            echo '                                <td class="gtfs-name">colour</td>' . "\n";
                            echo '                                <td class="gtfs-name">#' . $osm_colour . '</td>' . "\n";
                            echo '                            </tr>' . "\n";
                        }
                        if ( $osm_website ) {
                            echo '                            <tr class="gtfs-tablerow">' . "\n";
                            echo '                                <td class="gtfs-name">website</td>' . "\n";
                            echo '                                <td class="gtfs-text">' . $osm_website . '</td>' . "\n";
                            echo '                            </tr>' . "\n";
                        }
                        echo '                            <tr class="gtfs-tablerow">' . "\n";
                        echo '                                <td class="gtfs-name">gtfs:feed</td>' . "\n";
                        echo '                                <td class="gtfs-name">' . $osm_gtfs_feed . '</td>' . "\n";
                        echo '                            </tr>' . "\n";
                        echo '                            <tr class="gtfs-tablerow">' . "\n";
                        echo '                                <td class="gtfs-name">gtfs:release_date</td>' . "\n";
                        echo '                                <td class="gtfs-name">' . $osm_gtfs_release_date . '</td>' . "\n";
                        echo '                            </tr>' . "\n";
                        if ( $osm_gtfs_route_id ) {
                            echo '                            <tr class="gtfs-tablerow">' . "\n";
                            echo '                                <td class="gtfs-name">gtfs:route_id</td>' . "\n";
                            echo '                                <td class="gtfs-name">' . $osm_gtfs_route_id . '</td>' . "\n";
                            echo '                            </tr>' . "\n";
                        }
                        if ( $osm_gtfs_trip_id ) {
                            echo '                            <tr class="gtfs-tablerow">' . "\n";
                            echo '                                <td class="gtfs-name">gtfs:trip_id:sample</td>' . "\n";
                            echo '                                <td class="gtfs-name">' . $osm_gtfs_trip_id . '</td>' . "\n";
                            echo '                            </tr>' . "\n";
                        }
                        if ( $osm_gtfs_trip_id_like ) {
                            echo '                            <tr class="gtfs-tablerow">' . "\n";
                            echo '                                <td class="gtfs-name">gtfs:trip_id:like</td>' . "\n";
                            echo '                                <td class="gtfs-name">' . $osm_gtfs_trip_id_like . '</td>' . "\n";
                            echo '                            </tr>' . "\n";
                        }
                        if ( $osm_gtfs_shape_id ) {
                            echo '                            <tr class="gtfs-tablerow">' . "\n";
                            echo '                                <td class="gtfs-name">gtfs:shape_id</td>' . "\n";
                            echo '                                <td class="gtfs-name">' . $osm_gtfs_shape_id . '</td>' . "\n";
                            echo '                            </tr>' . "\n";
                        }
                        if ( $osm_ref_trips ) {
                            echo '                            <tr class="gtfs-tablerow">' . "\n";
                            echo '                                <td class="gtfs-name">ref_trips</td>' . "\n";
                            echo '                                <td class="gtfs-name">' . $osm_ref_trips . '</td>' . "\n";
                            echo '                            </tr>' . "\n";
                        }
                        if ( $osm_from ) {
                            echo '                            <tr class="gtfs-tablerow">' . "\n";
                            echo '                                <td class="gtfs-name">from</td>' . "\n";
                            echo '                                <td class="gtfs-text">' . $osm_from . '</td>' . "\n";
                            echo '                            </tr>' . "\n";
                        }
                        if ( $osm_to ) {
                            echo '                            <tr class="gtfs-tablerow">' . "\n";
                            echo '                                <td class="gtfs-name">to</td>' . "\n";
                            echo '                                <td class="gtfs-text">' . $osm_to . '</td>' . "\n";
                            echo '                            </tr>' . "\n";
                        }
                        if ( $osm_from && $osm_to && $osm_from == $osm_to ) {
                            echo '                            <tr class="gtfs-tablerow">' . "\n";
                            echo '                                <td class="gtfs-name">roundtrip</td>' . "\n";
                            echo '                                <td class="gtfs-name">yes</td>' . "\n";
                            echo '                            </tr>' . "\n";
                        }
                        echo '                            <tr class="gtfs-tablerow">' . "\n";
                        echo '                                <td class="gtfs-name">public_transport:version</td>' . "\n";
                        echo '                                <td class="gtfs-name">2</td>' . "\n";
                        echo '                            </tr>' . "\n";
                        echo '                        </tbody>' . "\n";
                        echo '                    </table>' . "\n";

                        $stop_time = gettimeofday(true);

                        return $stop_time - $start_time;
                    }

                } catch ( Exception $ex ) {
                    echo "Sqlite DB could not be opened: " . htmlspecialchars($ex->getMessage()) . "\n";
                }
            }
        } else {
            echo "Sqlite DB not found for feed = '" . htmlspecialchars($feed) . "'\n";
        }

        return 0;
    }


    function CreateGtfsSingleTripEntry( $feed, $release_date, $trip_id ) {

        $SqliteDb = FindGtfsSqliteDb( $feed, $release_date );

        if ( $SqliteDb != '') {

           if ( $trip_id ) {

               try {

                    set_time_limit( 30 );

                    $start_time = gettimeofday(true);

                    $db = new SQLite3( $SqliteDb );

                    $sql        = sprintf( "SELECT trip_id
                                            FROM   ptna_trips
                                            WHERE  trip_id='%s' OR list_trip_ids LIKE '%s|%%' OR list_trip_ids LIKE '%%|%s|%%' OR list_trip_ids LIKE '%%|%s'",
                                            SQLite3::escapeString($trip_id), SQLite3::escapeString($trip_id), SQLite3::escapeString($trip_id), SQLite3::escapeString($trip_id) );

                    $trip       = $db->querySingle( $sql, true );

                    $trip_id    = $trip['trip_id'];

                    if ( $trip_id ) {
                        $sql = sprintf( "SELECT   stop_times.stop_id,stop_times.departure_time,stops.*
                                         FROM     stop_times
                                         JOIN     stops ON stop_times.stop_id = stops.stop_id
                                         WHERE    stop_times.trip_id='%s'
                                         ORDER BY CAST (stop_times.stop_sequence AS INTEGER);",
                                         SQLite3::escapeString($trip_id)
                                    );

                        $result = $db->query( $sql );

                        $counter = 1;
                        while ( $row=$result->fetchArray(SQLITE3_ASSOC) ) {
                            if ( $row["departure_time"] ) {
                                $row["departure_time"] = preg_replace('/:\d\d$/', '', $row["departure_time"] );
                            }
                            echo '                            <tr class="gtfs-tablerow">' . "\n";
                            echo '                                <td class="gtfs-number">'    . $counter++ . '</td>' . "\n";
                            if ( $row["normalized_stop_name"] ) {
                                echo '                                <td class="gtfs-stop-name">' . htmlspecialchars($row["normalized_stop_name"]) . '</td>' . "\n";
                            } else {
                                echo '                                <td class="gtfs-stop-name">' . htmlspecialchars($row["stop_name"]) . '</td>' . "\n";
                            }
                            echo '                                <td class="gtfs-comment">';
                            printf( '%s%s/%s%s', '<a href="https://www.openstreetmap.org/edit?editor=id#map=21/', $row["stop_lat"], $row["stop_lon"], '" target="_blank" title="Edit area in iD">iD</a>' );
                            $bbox = GetBbox( $row["stop_lat"], $row["stop_lon"], 15 );
                            printf( ', %sleft=%s&right=%s&top=%s&bottom=%s%s', '<a href="http://127.0.0.1:8111/load_and_zoom?', $bbox['left'],$bbox['right'],$bbox['top'],$bbox['bottom'], '&new_layer=false" target="hiddenIframe" title="Download area (30 m * 30 m) in JOSM">JOSM</a>' );
                            echo '</td>' . "\n";
                            echo '                                <td class="gtfs-date">'     . htmlspecialchars($row["departure_time"])  . '</td>' . "\n";
                            echo '                                <td class="gtfs-lat">'      . htmlspecialchars($row["stop_lat"])        . '</td>' . "\n";
                            echo '                                <td class="gtfs-lon">'      . htmlspecialchars($row["stop_lon"])        . '</td>' . "\n";
                            echo '                                <td class="gtfs-id">'       . htmlspecialchars($row["stop_id"])         . '</td>' . "\n";
                            echo '                                <td class="gtfs-comment">'  . HandlePtnaComment($row)                   . '</td>' . "\n";
                            echo '                            </tr>' . "\n";
                        }

                        $db->close();

                        $stop_time = gettimeofday(true);

                        return $stop_time - $start_time;
                    }

                } catch ( Exception $ex ) {
                    echo "Sqlite DB could not be opened: " . htmlspecialchars($ex->getMessage()) . "\n";
                }
            }
        } else {
            echo "Sqlite DB not found for feed = '" . htmlspecialchars($feed) . "'\n";
        }

        return 0;
    }


    function GetStartEndDateOfIdenticalTrips( $db, $trip_id ) {

        $return_array = array();

        $return_array["start_date"] = '20500101';
        $return_array["end_date"]   = '19700101';

        $has_min_max_dates    = 0;
        $has_list_service_ids = 0;

        if ( $db ) {

            if ( $trip_id ) {

                $sql        = "SELECT name FROM sqlite_master WHERE type='table' AND name='ptna_trips';";

                $sql_master = $db->querySingle( $sql, true );

                if ( $sql_master['name'] ) {

                    $sql        = sprintf( "SELECT *
                                            FROM   ptna_trips
                                            WHERE  trip_id='%s'",
                                            SQLite3::escapeString($trip_id) );
                    $result     = $db->querySingle( $sql, true );

                    if ( $result['trip_id'] ) {
                        $trip_id = $result['trip_id'];
                    }
                    if ( isset($result['min_start_date']) && isset($result['max_end_date']) ) {   # from ptna_trips, filled during gtfs-aggregation.pl
                        $return_array["start_date"] = $result["min_start_date"];
                        $return_array["end_date"]   = $result["max_end_date"];
                    } elseif ( isset($result['list_service_ids']) ) {
                        $has_list_service_ids = 1;
                        $temp_array = array();
                        $temp_array = array_flip( array_flip( explode( '|', $result['list_service_ids'] ) ) );
                        $where_clause = "service_id='";
                        foreach ( $temp_array as $service_id ) {
                            $where_clause .= SQLite3::escapeString($service_id) . "' OR service_id='";
                        }
                        $sql = sprintf( "SELECT start_date,end_date
                                         FROM   calendar
                                         WHERE  %s;", preg_replace( "/ OR service_id='$/", "", $where_clause ) );

                        $result = $db->query( $sql );

                        while ( $row=$result->fetchArray(SQLITE3_ASSOC) ) {
                            if ( $row["start_date"] < $return_array["start_date"] ) {
                                $return_array["start_date"] = $row["start_date"];
                            }
                            if ( $row["end_date"] > $return_array["end_date"] ) {
                                $return_array["end_date"]   = $row["end_date"];
                            }
                        }
                    }
                }

                if ( $has_min_max_dates == 0 && $has_list_service_ids == 0 ) {
                    $sql = sprintf( "SELECT start_date,end_date
                                     FROM   calendar
                                     JOIN   trips ON trips.service_id = calendar.service_id
                                     WHERE  trip_id='%s';", SQLite3::escapeString($trip_id) );

                    $result = $db->query( $sql );

                    while ( $row=$result->fetchArray(SQLITE3_ASSOC) ) {
                        if ( $row["start_date"] < $return_array["start_date"] ) {
                            $return_array["start_date"] = $row["start_date"];
                        }
                        if ( $row["end_date"] > $return_array["end_date"] ) {
                            $return_array["end_date"]   = $row["end_date"];
                        }
                    }
                }
            }
        }

        return $return_array;
    }


    function CreateGtfsSingleTripServiceTimesEntry( $feed, $release_date, $trip_id ) {

        $SqliteDb = FindGtfsSqliteDb( $feed, $release_date );

        if ( $SqliteDb != '') {

           if ( $trip_id ) {

               try {

                    $start_time = gettimeofday(true);

                    $db = new SQLite3( $SqliteDb );

                    $sql        = "SELECT name FROM sqlite_master WHERE type='table' AND name='ptna_trips';";

                    $sql_master = $db->querySingle( $sql, true );

                    if ( $sql_master['name'] ) {

                        $sql    = sprintf( "SELECT DISTINCT *
                                            FROM            ptna_trips
                                            WHERE           trip_id='%s' OR list_trip_ids LIKE '%s|%%' OR list_trip_ids LIKE '%%|%s|%%' OR list_trip_ids LIKE '%%|%s'",
                                            SQLite3::escapeString($trip_id), SQLite3::escapeString($trip_id), SQLite3::escapeString($trip_id), SQLite3::escapeString($trip_id)
                                         );
                        $result = $db->querySingle( $sql, true );

                        if ( isset($result['list_trip_ids']) && isset($result['list_departure_times']) && isset($result['list_service_ids']) ) {
                            $list_trip_ids        = explode( '|', $result['list_trip_ids'] );
                            $list_departure_times = explode( '|', $result['list_departure_times'] );
                            $list_service_ids     = explode( '|', $result['list_service_ids'] );
                            for ( $i = 0; $i < count($list_trip_ids); $i++ ) {
                                if ( isset($service_departure[$list_service_ids[$i]]) ) {
                                    $service_departure[$list_service_ids[$i]] = $list_departure_times[$i] . ',';
                                } else {
                                    $service_departure[$list_service_ids[$i]] .= $list_departure_times[$i] . ',';
                                }
                            }
                            if ( isset($result['list_durations']) ) {
                                $list_durations = explode( '|', $result['list_durations'] );
                                for ( $i = 0; $i < count($list_trip_ids); $i++ ) {
                                    if ( isset($service_departure[$list_service_ids[$i]]) ) {
                                        $service_durations[$list_service_ids[$i]] = $list_durations[$i] . ',';
                                    } else {
                                        $service_durations[$list_service_ids[$i]] .= $list_durations[$i] . ',';
                                    }
                                }
                            }

                            $service_ids = array_flip( array_flip( $list_service_ids ) );
                            $where_clause = "service_id='";
                            foreach ( $service_ids as $service_id ) {
                                $where_clause .= SQLite3::escapeString($service_id) . "' OR service_id='";
                            }
                            $sql = sprintf( "SELECT *
                                             FROM   calendar
                                             WHERE  %s;", preg_replace( "/ OR service_id='$/", "", $where_clause ) );
                            $cal_result = $db->query( $sql );

                            $service_rows = array();
                            while ( $row=$cal_result->fetchArray(SQLITE3_ASSOC) ) {
                                if ( $row["service_id"] ) {
                                    $service_row = '';
                                    if ( preg_match( "/^(\d{4})(\d{2})(\d{2})$/", $row["start_date"], $parts ) ) {
                                        $class = "gtfs-date";
                                        $today = new DateTime();
                                        if ( $row["start_date"] > $today->format('Ymd') )
                                        {
                                            $class = "gtfs-datenew";
                                        }
                                        $service_row .= '<td class="' . $class . '">';
                                        $service_row .= $parts[1] . '-' . $parts[2] . '-' . $parts[3];
                                    } else {
                                        $service_row .= '<td class="gtfs-date">';
                                        $service_row .= htmlspecialchars($row["start_date"]);
                                    }
                                    $service_row .= "</td>\n                                ";
                                    if ( preg_match( "/^(\d{4})(\d{2})(\d{2})$/", $row["end_date"], $parts ) ) {
                                        $class = "gtfs-date";
                                        $today = new DateTime();
                                        if ( $row["end_date"] < $today->format('Ymd') )
                                        {
                                            $class = "gtfs-dateold";
                                        }
                                        $service_row .= '<td class="' . $class . '">';
                                        $service_row .= $parts[1] . '-' . $parts[2] . '-' . $parts[3];
                                    } else {
                                        $service_row .= '<td class="gtfs-date">';
                                        $service_row .= htmlspecialchars($row["end_date"]);
                                    }
                                    $service_row .= "</td>\n                                ";
                                    $service_row .= '<td class="gtfs-date">';
                                    $service_row .= ($row["monday"] == 1 ? 'X' : 'Y____');
                                    $service_row .= "</td>\n                                ";
                                    $service_row .= '<td class="gtfs-date">';
                                    $service_row .= ($row["tuesday"] == 1 ? 'X' : 'Y____');
                                    $service_row .= "</td>\n                                ";
                                    $service_row .= '<td class="gtfs-date">';
                                    $service_row .= ($row["wednesday"] == 1 ? 'X' : 'Y____');
                                    $service_row .= "</td>\n                                ";
                                    $service_row .= '<td class="gtfs-date">';
                                    $service_row .= ($row["thursday"] == 1 ? 'X' : 'Y____');
                                    $service_row .= "</td>\n                                ";
                                    $service_row .= '<td class="gtfs-date">';
                                    $service_row .= ($row["friday"] == 1 ? 'X' : 'Y____');
                                    $service_row .= "</td>\n                                ";
                                    $service_row .= '<td class="gtfs-date">';
                                    $service_row .= ($row["saturday"] == 1 ? 'X' : 'Y____');
                                    $service_row .= "</td>\n                                ";
                                    $service_row .= '<td class="gtfs-date">';
                                    $service_row .= ($row["sunday"] == 1 ? 'X' : 'Y____');
                                    $service_row .= "</td>\n                                ";
                                    $service_row .= '<td class="gtfs-text">';
                                    $sql = sprintf( "SELECT GROUP_CONCAT(date,', ') as dates
                                                     FROM   calendar_dates
                                                     WHERE  service_id='%s' AND exception_type=1;", SQLite3::escapeString(($row["service_id"]) ) );
                                    $cal_pos = $db->querySingle( $sql, true );
                                    if ( $cal_pos['dates'] ) {
                                        $service_row .= preg_replace( "/(\d\d\d\d)(\d\d)(\d\d)/", "\\1-\\2-\\3", $cal_pos["dates"] );
                                    } else {
                                        $service_row .= '&nbsp;';
                                    }
                                    $service_row .= "</td>\n                                ";
                                    $service_row .= '<td class="gtfs-text">';
                                    $sql = sprintf( "SELECT GROUP_CONCAT(date,', ') AS dates
                                                     FROM   calendar_dates
                                                     WHERE  service_id='%s' AND exception_type=2;", SQLite3::escapeString(($row["service_id"]) ) );
                                    $cal_neg = $db->querySingle( $sql, true );
                                    if ( $cal_neg['dates'] ) {
                                        $service_row .= preg_replace( "/(\d\d\d\d)(\d\d)(\d\d)/", "\\1-\\2-\\3", $cal_neg["dates"] );
                                    } else {
                                        $service_row .= '&nbsp;';
                                    }
                                    $service_row .= "</td>\n                                ";

                                    if ( $result['list_durations'] ) {
                                        $durations_string    = preg_replace( "/(\d{1,2}:\d\d):\d\d,/", "\\1,", $service_durations[$row["service_id"]] );
                                        $durations_string    = preg_replace( "/,$/", "", $durations_string );
                                        $durations           = explode( ',', $durations_string );
                                        $different_durations = array_flip( $durations );
                                        if ( count($different_durations) == 1 ) {
                                            $style_width_departures = '';
                                            $style_width_durations  = '';
                                        } else {
                                            $style_width_departures = ' style="width:26%;"';
                                            $style_width_durations  = ' style="width:21.2%;"';
                                        }
                                    }
                                    $service_row .= '<td class="gtfs-text"' . $style_width_departures . '>';
                                    $departures  = preg_replace( "/(\d{1,2}:\d\d):\d\d,/", "\\1,", $service_departure[$row["service_id"]] );
                                    $departures  = preg_replace( "/,$/", "", $departures );
                                    $unique_departures = array_flip( array_flip( explode( ',', $departures ) ) );
                                    sort( $unique_departures );
                                    $service_row .= htmlspecialchars( implode( ', ', $unique_departures ) );
                                    $service_row .= "</td>\n                                ";
                                    $service_row .= '<td class="gtfs-text"' . $style_width_durations . '>';
                                    if ( $result['list_durations'] ) {
                                        if ( count($different_durations) == 1 ) {
                                            $service_row .= htmlspecialchars($durations[0]);
                                        } else {
                                            $service_row .= htmlspecialchars( implode( ', ', $durations ) );
                                        }
                                    } else {
                                        $service_row .= 'not available';
                                    }
                                    $service_row .= "</td>\n                                ";
                                    $service_row .= '<td class="gtfs-text">';
                                    $service_row .=  htmlspecialchars($row["service_id"]);
                                    $service_row .= "</td>\n";
                                    array_push( $service_rows, $service_row );
                                }
                            }

                            sort ( $service_rows );
                            foreach ( $service_rows as $service_row ) {
                                $service_row = preg_replace( "/Y____/", "&nbsp;", $service_row );
                                echo '                            <tr class="gtfs-tablerow">' . "\n";
                                echo '                                ' . $service_row;
                                echo '                            </tr>' . "\n";
                            }
                        }
                    }
                    $db->close();

                    $stop_time = gettimeofday(true);

                    return $stop_time - $start_time;

                } catch ( Exception $ex ) {
                    echo "Sqlite DB could not be opened: " . htmlspecialchars($ex->getMessage()) . "\n";
                }
            }
        } else {
            echo "Sqlite DB not found for feed = '" . htmlspecialchars($feed) . "'\n";
        }

        return 0;
    }


    function CreateGtfsSingleTripShapeEntry( $feed, $release_date, $trip_id ) {

        $SqliteDb = FindGtfsSqliteDb( $feed, $release_date );

        if ( $SqliteDb != '') {

           if ( $trip_id ) {

               try {

                    $start_time = gettimeofday(true);

                    $db = new SQLite3( $SqliteDb );

                    $sql        = "SELECT * FROM ptna";

                    $ptna       = $db->querySingle( $sql, true );

                    if ( $ptna["has_shapes"] ) {

                        $sql        = sprintf( "SELECT trip_id
                                                FROM   ptna_trips
                                                WHERE  trip_id='%s' OR list_trip_ids LIKE '%s|%%' OR list_trip_ids LIKE '%%|%s|%%' OR list_trip_ids LIKE '%%|%s'",
                                                SQLite3::escapeString($trip_id), SQLite3::escapeString($trip_id), SQLite3::escapeString($trip_id), SQLite3::escapeString($trip_id) );

                        $trip       = $db->querySingle( $sql, true );

                        if ( $trip['trip_id'] ) {
                            $sql        = sprintf( "SELECT shape_id
                                                    FROM   trips
                                                    WHERE  trip_id='%s'",
                                                    SQLite3::escapeString($trip['trip_id']) );

                            $trip       = $db->querySingle( $sql, true );

                            $shape_id   = $trip["shape_id"];

                            if ( $shape_id ) {

                                $sql = sprintf( "SELECT   *
                                                FROM     shapes
                                                WHERE    shape_id='%s'
                                                ORDER BY CAST (shape_pt_sequence AS INTEGER);",
                                                SQLite3::escapeString($shape_id)
                                            );

                                $result = $db->query( $sql );

                                echo "              <hr />\n\n";
                                echo '              <h2 id="shapes">GTFS Shape Data, Shape-id: "' . $shape_id . '"</h3>' ."\n";
                                echo '              <div class="indent">' . "\n";
                                echo '                  <table id="gtfs-shape">' . "\n";
                                echo '                      <thead>' . "\n";
                                echo '                          <tr class="gtfs-tableheaderrow">' . "\n";
                                echo '                              <th class="gtfs-name">Number</th>' . "\n";
                                echo '                              <th class="gtfs-number">Latitude</th>' . "\n";
                                echo '                              <th class="gtfs-number">Longitude</th>' . "\n";
                                echo '                              <th class="gtfs-distance">Distance</th>' . "\n";
                                echo '                          </tr>' . "\n";
                                echo '                      </thead>' . "\n";
                                echo '                      <tbody>' . "\n";
                                $counter = 1;
                                while ( $row=$result->fetchArray(SQLITE3_ASSOC) ) {
                                    echo '                          <tr class="gtfs-tablerow">' . "\n";
                                    echo '                              <td class="gtfs-number">'  . $counter++ . '</td>' . "\n";
                                    echo '                              <td class="gtfs-lat">'     . htmlspecialchars($row["shape_pt_lat"])        . '</td>' . "\n";
                                    echo '                              <td class="gtfs-lon">'     . htmlspecialchars($row["shape_pt_lon"])        . '</td>' . "\n";
                                    #if ( preg_match('/^\d+(\.\d+)?$/',$row["shape_dist_traveled"],$parts) ) {
                                    #    echo '                              <td class="gtfs-distance">'  . sprintf( "%.3f", $parts[0]/1000) . '</td>' . "\n";
                                    #} else {
                                        echo '                              <td class="gtfs-distance">'  . htmlspecialchars($row["shape_dist_traveled"]) . '</td>' . "\n";
                                    #}
                                    echo '                          </tr>' . "\n";
                                }
                                echo '                      </tbody>' . "\n";
                                echo '                  </table>' . "\n";
                                echo '              </div>' . "\n";
                            }
                        }
                    }
                    $db->close();

                    $stop_time = gettimeofday(true);

                    return $stop_time - $start_time;

                } catch ( Exception $ex ) {
                    echo "Sqlite DB could not be opened: " . htmlspecialchars($ex->getMessage()) . "\n";
                }
            }
        } else {
            echo "Sqlite DB not found for feed = '" . htmlspecialchars($feed) . "'\n";
        }

        return 0;
    }


    function GetGtfsRouteShortNameFromRouteId( $feed, $release_date, $route_id ) {

        $SqliteDb = FindGtfsSqliteDb( $feed, $release_date );

        if ( $SqliteDb != '' ) {

            if ( $route_id ) {

                try {

                    $db = new SQLite3( $SqliteDb );

                    $sql = sprintf( "SELECT route_short_name
                                     FROM   routes
                                     WHERE  route_id='%s';",
                                     SQLite3::escapeString($route_id)
                                  );

                    $row = $db->querySingle( $sql, true );

                    return $row["route_short_name"];

                } catch ( Exception $ex ) {
                    echo "Sqlite DB could not be opened: " . htmlspecialchars($ex->getMessage()) . "\n";
                }
            }
        } else {
            echo "Sqlite DB not found for feed = '" . htmlspecialchars($feed) . "'\n";
        }

        return '';
    }


    function GetGtfsRouteIdFromTripId( $feed, $release_date, $trip_id ) {

        $SqliteDb = FindGtfsSqliteDb( $feed, $release_date );

        if ( $SqliteDb != '' ) {

            if ( $trip_id ) {

                try {

                    $db = new SQLite3( $SqliteDb );

                    $sql        = sprintf( "SELECT trip_id
                                            FROM   ptna_trips
                                            WHERE  trip_id='%s' OR list_trip_ids LIKE '%s|%%' OR list_trip_ids LIKE '%%|%s|%%' OR list_trip_ids LIKE '%%|%s'",
                                            SQLite3::escapeString($trip_id), SQLite3::escapeString($trip_id), SQLite3::escapeString($trip_id), SQLite3::escapeString($trip_id) );

                    $trip       = $db->querySingle( $sql, true );

                    $trip_id    = $trip['trip_id'];

                    if ( $trip_id ) {
                        $sql = sprintf( "SELECT route_id
                                         FROM   trips
                                         WHERE  trip_id='%s';",
                                         SQLite3::escapeString($trip_id)
                                      );

                        $row = $db->querySingle( $sql, true );

                        return $row["route_id"];
                    }

                } catch ( Exception $ex ) {
                    echo "Sqlite DB could not be opened: " . htmlspecialchars($ex->getMessage()) . "\n";
                }
            }
        } else {
            echo "Sqlite DB not found for feed = '" . htmlspecialchars($feed) . "'\n";
        }

        return '';
    }


    function GetGtfsRouteShortNameFromTripId( $feed, $release_date, $trip_id ) {

        $SqliteDb = FindGtfsSqliteDb( $feed, $release_date );

        if ( $SqliteDb != '' ) {

            if ( $trip_id ) {

                try {

                    $db = new SQLite3( $SqliteDb );

                    $sql        = sprintf( "SELECT trip_id
                                            FROM   ptna_trips
                                            WHERE  trip_id='%s' OR list_trip_ids LIKE '%s|%%' OR list_trip_ids LIKE '%%|%s|%%' OR list_trip_ids LIKE '%%|%s'",
                                            SQLite3::escapeString($trip_id), SQLite3::escapeString($trip_id), SQLite3::escapeString($trip_id), SQLite3::escapeString($trip_id) );

                    $trip       = $db->querySingle( $sql, true );

                    $trip_id    = $trip['trip_id'];

                    if ( $trip_id ) {
                        $sql = sprintf( "SELECT route_short_name
                                         FROM   routes
                                         JOIN   trips ON trips.route_id = routes.route_id
                                         WHERE  trip_id='%s';",
                                         SQLite3::escapeString($trip_id)
                                    );

                        $row = $db->querySingle( $sql, true );

                        return $row["route_short_name"];
                    }

                } catch ( Exception $ex ) {
                    echo "Sqlite DB could not be opened: " . htmlspecialchars($ex->getMessage()) . "\n";
                }
            }
        } else {
            echo "Sqlite DB not found for feed = '" . htmlspecialchars($feed) . "'\n";
        }

        return '';
    }


    function GetGtfsTripIdFromShapeId( $feed, $release_date, $shape_id ) {

        $SqliteDb = FindGtfsSqliteDb( $feed, $release_date );

        if ( $SqliteDb != '' ) {

            if ( $shape_id ) {

                try {

                    $db = new SQLite3( $SqliteDb );

                    $result = $db->query( "PRAGMA table_info(trips);" );

                    $trips_has_shape_id = 0;
                    while ( $row=$result->fetchArray(SQLITE3_ASSOC) ) {
                        if ( $row["name"] == 'shape_id') {
                            $trips_has_shape_id = 1;
                            break;
                        }
                    }

                    if ( $trips_has_shape_id ) {
                        $sql = sprintf( "SELECT trip_id
                                         FROM   trips
                                         WHERE  shape_id='%s';",
                                         SQLite3::escapeString($shape_id)
                                      );

                        $row = $db->querySingle( $sql, true );

                        return $row["trip_id"];
                    }

                } catch ( Exception $ex ) {
                    echo "Sqlite DB could not be opened: " . htmlspecialchars($ex->getMessage()) . "\n";
                }
            }
        } else {
            echo "Sqlite DB not found for feed = '" . htmlspecialchars($feed) . "'\n";
        }

        return '';
    }


    function GetFeedDetails( $feed, $release_date ) {

        $SqliteDb = FindGtfsSqliteDb( $feed, $release_date );

        if ( $SqliteDb != '' ) {

            try {

                $db  = new SQLite3( $SqliteDb );

                $sql = sprintf( "SELECT * FROM feed_info" );

                $row = $db->querySingle( $sql, true );

                return $row;

            } catch ( Exception $ex ) {
                echo "Sqlite DB could not be opened: " . htmlspecialchars($ex->getMessage()) . "\n";
            }
        } else {
            echo "Sqlite DB not found for feed = '" . htmlspecialchars($feed) . "'\n";
        }

        return array();
    }


    function GetOsmDetails( $feed, $release_date ) {

        $SqliteDb = FindGtfsSqliteDb( $feed, $release_date );

        if ( $SqliteDb != '' ) {

            try {

                $db  = new SQLite3( $SqliteDb );

                $sql = sprintf( "SELECT * FROM osm" );

                $row = $db->querySingle( $sql, true );

                return $row;

            } catch ( Exception $ex ) {
                echo "Sqlite DB could not be opened: " . htmlspecialchars($ex->getMessage()) . "\n";
            }
        } else {
            echo "Sqlite DB not found for feed = '" . htmlspecialchars($feed) . "'\n";
        }

        return array();
    }


    function GetPtnaDetails( $feed, $release_date ) {

        $SqliteDb = FindGtfsSqliteDb( $feed, $release_date );

        if ( $SqliteDb != '' ) {

            try {

                $db  = new SQLite3( $SqliteDb );

                $sql = sprintf( "SELECT * FROM ptna" );

                $row = $db->querySingle( $sql, true );

                return $row;

            } catch ( Exception $ex ) {
                echo "Sqlite DB could not be opened: " . htmlspecialchars($ex->getMessage()) . "\n";
            }
        } else {
            echo "Sqlite DB not found for feed = '" . htmlspecialchars($feed) . "'\n";
        }

        return array();
    }


    function GetTripDetails( $feed, $release_date, $trip_id ) {

        $SqliteDb = FindGtfsSqliteDb( $feed, $release_date );

        if ( $SqliteDb != '' ) {

            if ( $trip_id ) {

                try {

                    $db  = new SQLite3( $SqliteDb );

                    $sql        = sprintf( "SELECT trip_id
                                            FROM   ptna_trips
                                            WHERE  trip_id='%s' OR list_trip_ids LIKE '%s|%%' OR list_trip_ids LIKE '%%|%s|%%' OR list_trip_ids LIKE '%%|%s'",
                                            SQLite3::escapeString($trip_id), SQLite3::escapeString($trip_id), SQLite3::escapeString($trip_id), SQLite3::escapeString($trip_id) );

                    $trip       = $db->querySingle( $sql, true );

                    $trip_id    = $trip['trip_id'];

                    $sql        = "SELECT name FROM sqlite_master WHERE type='table' AND name='ptna_trips_comments';";
                    $sql_master = $db->querySingle( $sql, true );

                    if ( $sql_master['name'] ) {
                        $join_statement = 'LEFT OUTER JOIN ptna_trips_comments ON trips.trip_id = ptna_trips_comments.trip_id';
                    } else {
                        $join_statement = '';
                    }
                    if ( $trip_id ) {
                        $sql = sprintf( "SELECT *
                                         FROM   trips
                                         %s
                                         WHERE  trips.trip_id='%s';",
                                         $join_statement, SQLite3::escapeString($trip_id)
                                      );
                        $row = $db->querySingle( $sql, true );

                        if ( isset($row['commment'])                     ||
                             isset($row['subroute_of'])                  ||
                             isset($row['suspicious_start'])             ||
                             isset($row['suspicious_end'])               ||
                             isset($row['same_names_but_different_ids'])    ) {
                             $row['has_comments'] = 'yes';
                        }
                        if ( !isset($row['shape_id']) ) {
                            $row['shape_id'] = '';
                        }

                        return $row;
                    }

                } catch ( Exception $ex ) {
                    echo "Sqlite DB could not be opened: " . htmlspecialchars($ex->getMessage()) . "\n";
                }
            }
        } else {
            echo "Sqlite DB not found for feed = '" . htmlspecialchars($feed) . "'\n";
        }

        return array();
    }


    function GetRouteDetails( $feed, $release_date, $route_id ) {

        $SqliteDb = FindGtfsSqliteDb( $feed, $release_date );

        if ( $SqliteDb != '' ) {

            if ( $route_id ) {

                try {

                    $db  = new SQLite3( $SqliteDb );

                    $sql = "SELECT name FROM sqlite_master WHERE type='table' AND name='ptna_routes_comments';";
                    $sql_master = $db->querySingle( $sql, true );

                    if ( $sql_master['name'] ) {
                        # 1. ptna_routes_comments   because ptna_routes_comments.route_id can be ''
                        # 2. routes                 because routes.route_id is what we want and
                        #                           2nd appearance overwrites 1st appearance of identical column names in the returned hash
                        $sql = sprintf( "SELECT ptna_routes_comments.*,routes.*
                                         FROM   routes
                                         LEFT OUTER JOIN ptna_routes_comments ON routes.route_id = ptna_routes_comments.route_id
                                         WHERE  routes.route_id='%s';",
                                         SQLite3::escapeString($route_id)
                                      );
                    } else {
                        $sql = sprintf( "SELECT *
                                         FROM   routes
                                         WHERE  route_id='%s';",
                                         SQLite3::escapeString($route_id)
                                      );
                    }
                    $row = $db->querySingle( $sql, true );

                    return $row;

                } catch ( Exception $ex ) {
                    echo "Sqlite DB could not be opened: " . htmlspecialchars($ex->getMessage()) . "\n";
                }
            }
        } else {
            echo "Sqlite DB not found for feed = '" . htmlspecialchars($feed) . "'\n";
        }

        return array();
    }


    function CreatePtnaDetails( $feed, $release_date ) {

        $SqliteDb = FindGtfsSqliteDb( $feed, $release_date );

        if ( $SqliteDb != '' ) {

            try {

                $start_time = gettimeofday(true);

                $db  = new SQLite3( $SqliteDb );

                $sql = sprintf( "SELECT * FROM ptna;" );

                $ptna = $db->querySingle( $sql, true );

                $sql        = "SELECT * FROM feed_info";

                $feed       = $db->querySingle( $sql, true );

                echo '                        <tr class="statistics-tablerow">' . "\n";
                echo '                            <td class="gtfs-name">Network / Coverage</td>' . "\n";
                if ( $ptna["network_name_url"] ) {
                    echo '                            <td class="gtfs-text"><a target="_blank" href="' . $ptna["network_name_url"] . '">' . htmlspecialchars($ptna["network_name"]) . '</a></td>' . "\n";
                } else {
                    echo '                            <td class="gtfs-text">' . htmlspecialchars($ptna["network_name"]) . '</td>' . "\n";
                }
                echo '                        </tr>' . "\n";

                echo '                        <tr class="statistics-tablerow">' . "\n";
                echo '                            <td class="gtfs-name">Comment on data</td>' . "\n";
                if ( $ptna["comment"] ) {
                    echo '                            <td class="gtfs-text">' . htmlspecialchars($ptna["comment"])  . '</td>' . "\n";
                } else {
                    echo '                            <td class="gtfs-text"></td>' . "\n";
                }
                echo '                        </tr>' . "\n";

                echo '                        <tr class="statistics-tablerow">' . "\n";
                echo '                            <td class="gtfs-name">Feed Publisher</td>' . "\n";
                if ( $feed["feed_publisher_name"] ) {
                    if ( $feed["feed_publisher_url"] ) {
                        echo '                            <td class="gtfs-text"><a target="_blank" href="' . $feed["feed_publisher_url"] . '" title="From GTFS">' . htmlspecialchars($feed["feed_publisher_name"]) . '</a></td>' . "\n";
                    } else {
                        echo '                            <td class="gtfs-text">' . htmlspecialchars($feed["feed_publisher_name"]) . '</td>' . "\n";
                    }
                } elseif ( $ptna["feed_publisher_name"] ) {
                    if ( $ptna["feed_publisher_url"] ) {
                        echo '                            <td class="gtfs-text"><a target="_blank" href="' . $ptna["feed_publisher_url"] . '" title="From PTNA">' . htmlspecialchars($ptna["feed_publisher_name"]) . '</a></td>' . "\n";
                    } else {
                        echo '                            <td class="gtfs-text">' . htmlspecialchars($ptna["feed_publisher_name"]) . '</td>' . "\n";
                    }
                } else {
                    echo '                            <td class="gtfs-text">&nbsp;</td>' . "\n";
                }
                echo '                        </tr>' . "\n";

                echo '                        <tr class="statistics-tablerow">' . "\n";
                echo '                            <td class="gtfs-name">Feed Start Date</td>' . "\n";
                if ( preg_match( "/^(\d{4})(\d{2})(\d{2})$/", $feed["feed_start_date"], $parts ) ) {
                    echo '                            <td class="gtfs-text">' . $parts[1] . '-' .  $parts[2] . '-' .  $parts[3] . '</td>' . "\n";
                } else {
                    echo '                            <td class="gtfs-text">' . htmlspecialchars($feed["feed_start_date"]) . '</td>' . "\n";
                }
                echo '                        </tr>' . "\n";

                echo '                        <tr class="statistics-tablerow">' . "\n";
                echo '                            <td class="gtfs-name">Feed End Date</td>' . "\n";
                if ( preg_match( "/^(\d{4})(\d{2})(\d{2})$/", $feed["feed_end_date"], $parts ) ) {
                    echo '                            <td class="gtfs-text">' . $parts[1] . '-' .  $parts[2] . '-' .  $parts[3] . '</td>' . "\n";
                } else {
                    echo '                            <td class="gtfs-text">' . htmlspecialchars($feed["feed_end_date"]) . '</td>' . "\n";
                }
                echo '                        </tr>' . "\n";

                echo '                        <tr class="statistics-tablerow">' . "\n";
                echo '                            <td class="gtfs-name">Feed Version</td>' . "\n";
                echo '                            <td class="gtfs-text">' . htmlspecialchars($feed["feed_version"]) . '</td>' . "\n";
                echo '                        </tr>' . "\n";

                echo '                        <tr class="statistics-tablerow">' . "\n";
                echo '                            <td class="gtfs-name">Release Date</td>' . "\n";
                echo '                            <td class="gtfs-text">' . htmlspecialchars($ptna["release_date"]) . '</td>' . "\n";
                echo '                        </tr>' . "\n";

                echo '                        <tr class="statistics-tablerow">' . "\n";
                echo '                            <td class="gtfs-name">Release Url</td>' . "\n";
                if ( $ptna["release_url"] ) {
                    echo '                            <td class="gtfs-text"><a target="_blank" href="' . $ptna["release_url"] . '">' . htmlspecialchars($ptna["release_url"]) . '</a></td>' . "\n";
                } else {
                    echo '                            <td class="gtfs-text">&nbsp;</td>' . "\n";
                }
                echo '                        </tr>' . "\n";

                echo '                        <tr class="statistics-tablerow">' . "\n";
                echo '                            <td class="gtfs-name">Download Date</td>' . "\n";
                echo '                            <td class="gtfs-text">' . htmlspecialchars($ptna["prepared"])   . '</td>' . "\n";
                echo '                        </tr>' . "\n";

                echo '                        <tr class="statistics-tablerow">' . "\n";
                echo '                            <td class="gtfs-name">Publisher\'s License</td>' . "\n";
                if ( $ptna["original_license_url"] ) {
                    echo '                            <td class="gtfs-text"><a target="_blank" href="' . $ptna["original_license_url"] . '">' . htmlspecialchars($ptna["original_license"]) . '</a></td>' . "\n";
                } else {
                    echo '                            <td class="gtfs-text">' . htmlspecialchars($ptna["original_license"]) . '</td>' . "\n";
                }
                echo '                        </tr>' . "\n";

                echo '                        <tr class="statistics-tablerow">' . "\n";
                echo '                            <td class="gtfs-name">License given for use in OSM</td>' . "\n";
                if ( $ptna["license_url"] ) {
                    echo '                            <td class="gtfs-text"><a target="_blank" href="' . $ptna["license_url"] . '">' . htmlspecialchars($ptna["license"]) . '</a></td>' . "\n";
                } else {
                    echo '                            <td class="gtfs-text">' . htmlspecialchars($ptna["license"]) . '</td>' . "\n";
                }
                echo '                        </tr>' . "\n";

                echo '                        <tr class="statistics-tablerow">' . "\n";
                echo '                            <td class="gtfs-name">Has Shape Data</td>' . "\n";
                if ( $ptna["has_shapes"] ) {
                    echo '                           <td class="gtfs-text"><img src="/img/CheckMark.png" width=32 height=32 alt="yes" /></td>' . "\n";
                } else {
                    echo '                           <td class="gtfs-text"></td>' . "\n";
                }
                echo '                        </tr>' . "\n";

                echo '                        <tr class="statistics-tablerow">' . "\n";
                echo '                            <td class="gtfs-name">Consider calendar data</td>' . "\n";
                if ( $ptna["consider_calendar"] ) {
                    echo '                           <td class="gtfs-text"><img src="/img/CheckMark.png" width=32 height=32 alt="yes" /></td>' . "\n";
                } else {
                    echo '                           <td class="gtfs-text"></td>' . "\n";
                }
                echo '                        </tr>' . "\n";

                echo '                        <tr class="statistics-tablerow">' . "\n";
                echo '                            <td class="gtfs-name">GTFS data prepared for PTNA</td>' . "\n";
                echo '                            <td class="gtfs-text">' . htmlspecialchars($ptna["prepared"])   . '</td>' . "\n";
                echo '                        </tr>' . "\n";

                echo '                        <tr class="statistics-tablerow">' . "\n";
                echo '                            <td class="gtfs-name">GTFS data aggregated for PTNA</td>' . "\n";
                echo '                            <td class="gtfs-text">' . htmlspecialchars($ptna["aggregated"]) . '</td>' . "\n";
                echo '                        </tr>' . "\n";

                echo '                        <tr class="statistics-tablerow">' . "\n";
                echo '                            <td class="gtfs-name">GTFS data analyzed for PTNA</td>' . "\n";
                echo '                            <td class="gtfs-text">' . htmlspecialchars($ptna["analyzed"])   . '</td>' . "\n";
                echo '                        </tr>' . "\n";

                echo '                        <tr class="statistics-tablerow">' . "\n";
                echo '                            <td class="gtfs-name">GTFS data normalized for PTNA</td>' . "\n";
                echo '                            <td class="gtfs-text">' . htmlspecialchars($ptna["normalized"])  . '</td>' . "\n";
                echo '                        </tr>' . "\n";

                $stop_time = gettimeofday(true);

                return $stop_time - $start_time;

            } catch ( Exception $ex ) {
                echo "Sqlite DB could not be opened: " . htmlspecialchars($ex->getMessage()) . "\n";
            }
        } else {
            echo "Sqlite DB not found for feed = '" . $htmlspecialchars($feed) . "'\n";
        }

        return 0;
    }


    function CreateOsmDetails( $feed, $release_date ) {

        $SqliteDb = FindGtfsSqliteDb( $feed, $release_date );

        if ( $SqliteDb != '' ) {

            try {

                $start_time = gettimeofday(true);

                $db  = new SQLite3( $SqliteDb );

                $sql = "SELECT name FROM sqlite_master WHERE type='table' AND name='osm';";

                $sql_master = $db->querySingle( $sql, true );

                if ( $sql_master['name'] ) {

                    $sql = sprintf( "SELECT * FROM osm;" );

                    $osm = $db->querySingle( $sql, true );

                    echo '                                    <tr class="statistics-tablerow">' . "\n";
                    echo '                                        <td class="gtfs-name">"network"</td>' . "\n";
                    echo '                                        <td class="gtfs-text">' . htmlspecialchars($osm["network"]) . '</td>' . "\n";
                    echo '                                    </tr>' . "\n";

                    echo '                                    <tr class="statistics-tablerow">' . "\n";
                    echo '                                        <td class="gtfs-name">"network:short"</td>' . "\n";
                    echo '                                        <td class="gtfs-text">' . htmlspecialchars($osm["network_short"]) . '</td>' . "\n";
                    echo '                                    </tr>' . "\n";

                    echo '                                    <tr class="statistics-tablerow">' . "\n";
                    echo '                                        <td class="gtfs-name">"network:guid"</td>' . "\n";
                    echo '                                        <td class="gtfs-text">' . htmlspecialchars($osm["network_guid"]) . '</td>' . "\n";
                    echo '                                    </tr>' . "\n";

                    echo '                                    <tr class="statistics-tablerow">' . "\n";
                    echo '                                        <td class="gtfs-name">"operator" can be taken from "agency_name" of GTFS</td>' . "\n";
                    if ( $osm["gtfs_agency_is_operator"] ) {
                        echo '                                       <td class="gtfs-text"><img src="/img/CheckMark.png" width=32 height=32 alt="yes" /></td>' . "\n";
                    } else {
                        echo '                                       <td class="gtfs-text"></td>' . "\n";
                    }
                    echo '                                    </tr>' . "\n";

                    echo '                                    <tr class="statistics-tablerow">' . "\n";
                    echo '                                        <td class="gtfs-name">"gtfs:trip_id:like" can be taken as part of GTFS "trip_id". Regular expression to extract this part.</td>' . "\n";
                    echo '                                        <td class="gtfs-text">' . htmlspecialchars($osm["trip_id_regex"]) . '</td>' . "\n";
                    echo '                                    </tr>' . "\n";

                    echo '                                    <tr class="statistics-tablerow">' . "\n";
                    echo '                                        <td class="gtfs-name">"ref" shall be taken from GTFS "route_long_name" instead of "route_short_name" (provided that "route_long_name" differs from "route_id")</td>' . "\n";
                    if ( $osm["gtfs_short_name_hack1"] ) {
                        echo '                                       <td class="gtfs-text"><img src="/img/CheckMark.png" width=32 height=32 alt="yes" /></td>' . "\n";
                    } else {
                        echo '                                       <td class="gtfs-text"></td>' . "\n";
                    }
                    echo '                                    </tr>' . "\n";
               }

                $stop_time = gettimeofday(true);

                return $stop_time - $start_time;

            } catch ( Exception $ex ) {
                echo "Sqlite DB could not be opened: " . htmlspecialchars($ex->getMessage()) . "\n";
            }
        } else {
            echo "Sqlite DB not found for feed = '" . htmlspecialchars($feed) . "'\n";
        }

        return 0;
    }


   function CreatePtnaAggregationStatistics( $feed, $release_date ) {

        $SqliteDb = FindGtfsSqliteDb( $feed, $release_date );

        if ( $SqliteDb != '' ) {

            try {

                $start_time = gettimeofday(true);

                $db  = new SQLite3( $SqliteDb );

                $sql = "SELECT name FROM sqlite_master WHERE type='table' AND name='ptna_aggregation';";

                $sql_master = $db->querySingle( $sql, true );

                if ( $sql_master['name'] ) {

                    $sql = sprintf( "SELECT * FROM ptna_aggregation;" );

                    $ptna = $db->querySingle( $sql, true );

                    if ( $ptna["date"] ) {
                        echo '                        <tr class="statistics-tablerow">' . "\n";
                        echo '                            <td class="statistics-name">Date</td>' . "\n";
                        echo '                            <td class="statistics-number">'  . htmlspecialchars($ptna["date"]) . '</td>' . "\n";
                        echo '                            <td class="statistics-number">[YYYY-MM-DD]</td>' . "\n";
                        echo '                        </tr>' . "\n";
                    }
                    if ( $ptna["duration"] ) {
                        $duration = $ptna["duration"];
                        echo '                        <tr class="statistics-tablerow">' . "\n";
                        echo '                            <td class="statistics-name">Duration</td>' . "\n";
                        echo '                            <td class="statistics-number">';
                        $format_mins = '%2d:';
                        $format_secs = '%2d';
                        if ( $duration > 3600 ) {
                            printf( "%2d:", $duration / 3600 );
                            $format_mins = '%02d:';
                        }
                        if ( $duration > 60 ) {
                            printf( $format_mins, ($duration % 3600) / 60 );
                            $format_secs = '%02d';
                        }
                        printf( $format_secs, ($duration % 60) );
                        echo '                            <td class="statistics-number">[hh:mm:ss]</td>' . "\n";
                        echo '                        </tr>' . "\n";
                    }
                    if ( $ptna["size_before"] ) {
                        echo '                        <tr class="statistics-tablerow">' . "\n";
                        echo '                            <td class="statistics-name">SQLite-DB size before</td>' . "\n";
                        echo '                            <td class="statistics-number">'  . sprintf( "%2.2f", htmlspecialchars($ptna["size_before"]) / 1024 / 1024 ) . '</td>' . "\n";
                        echo '                            <td class="statistics-number">[MB]</td>' . "\n";
                        echo '                        </tr>' . "\n";
                    }
                    if ( $ptna["size_after"] ) {
                        echo '                        <tr class="statistics-tablerow">' . "\n";
                        echo '                            <td class="statistics-name">SQLite-DB size after</td>' . "\n";
                        echo '                            <td class="statistics-number">'  . sprintf( "%2.2f", htmlspecialchars($ptna["size_after"]) / 1024 / 1024 ) . '</td>' . "\n";
                        echo '                            <td class="statistics-number">[MB]</td>' . "\n";
                        echo '                        </tr>' . "\n";
                    }
                    if ( $ptna["routes_before"] ) {
                        echo '                        <tr class="statistics-tablerow">' . "\n";
                        echo '                            <td class="statistics-name">Number of Routes before</td>' . "\n";
                        echo '                            <td class="statistics-number">'  . sprintf( "%d", htmlspecialchars($ptna["routes_before"]) ) . '</td>' . "\n";
                        echo '                            <td class="statistics-number">[1]</td>' . "\n";
                        echo '                        </tr>' . "\n";
                    }
                    if ( $ptna["routes_after"] ) {
                        echo '                        <tr class="statistics-tablerow">' . "\n";
                        echo '                            <td class="statistics-name">Number of Routes after</td>' . "\n";
                        echo '                            <td class="statistics-number">'  . sprintf( "%d", htmlspecialchars($ptna["routes_after"]) ) . '</td>' . "\n";
                        echo '                            <td class="statistics-number">[1]</td>' . "\n";
                        echo '                        </tr>' . "\n";
                    }
                    if ( $ptna["trips_before"] ) {
                        echo '                        <tr class="statistics-tablerow">' . "\n";
                        echo '                            <td class="statistics-name">Number of Trips before</td>' . "\n";
                        echo '                            <td class="statistics-number">'  . sprintf( "%d", htmlspecialchars($ptna["trips_before"]) ) . '</td>' . "\n";
                        echo '                            <td class="statistics-number">[1]</td>' . "\n";
                        echo '                        </tr>' . "\n";
                    }
                    if ( $ptna["trips_after"] ) {
                        echo '                        <tr class="statistics-tablerow">' . "\n";
                        echo '                            <td class="statistics-name">Number of Trips after</td>' . "\n";
                        echo '                            <td class="statistics-number">'  . sprintf( "%d", htmlspecialchars($ptna["trips_after"]) ) . '</td>' . "\n";
                        echo '                            <td class="statistics-number">[1]</td>' . "\n";
                        echo '                        </tr>' . "\n";
                    }
                    if ( $ptna["stops_before"] ) {
                        echo '                        <tr class="statistics-tablerow">' . "\n";
                        echo '                            <td class="statistics-name">Number of Stops before</td>' . "\n";
                        echo '                            <td class="statistics-number">'  . sprintf( "%d", htmlspecialchars($ptna["stops_before"]) ) . '</td>' . "\n";
                        echo '                            <td class="statistics-number">[1]</td>' . "\n";
                        echo '                        </tr>' . "\n";
                    }
                    if ( $ptna["stops_after"] ) {
                        echo '                        <tr class="statistics-tablerow">' . "\n";
                        echo '                            <td class="statistics-name">Number of Stops after</td>' . "\n";
                        echo '                            <td class="statistics-number">'  . sprintf( "%d", htmlspecialchars($ptna["stops_after"]) ) . '</td>' . "\n";
                        echo '                            <td class="statistics-number">[1]</td>' . "\n";
                        echo '                        </tr>' . "\n";
                    }
                    if ( $ptna["stop_times_before"] ) {
                        echo '                        <tr class="statistics-tablerow">' . "\n";
                        echo '                            <td class="statistics-name">Number of Stop-Times before</td>' . "\n";
                        echo '                            <td class="statistics-number">'  . sprintf( "%d", htmlspecialchars($ptna["stop_times_before"]) ) . '</td>' . "\n";
                        echo '                            <td class="statistics-number">[1]</td>' . "\n";
                        echo '                        </tr>' . "\n";
                    }
                    if ( $ptna["stop_times_after"] ) {
                        echo '                        <tr class="statistics-tablerow">' . "\n";
                        echo '                            <td class="statistics-name">Number of Stop-Times after</td>' . "\n";
                        echo '                            <td class="statistics-number">'  . sprintf( "%d", htmlspecialchars($ptna["stop_times_after"]) ) . '</td>' . "\n";
                        echo '                            <td class="statistics-number">[1]</td>' . "\n";
                        echo '                        </tr>' . "\n";
                    }
                    if ( $ptna["shapes_before"] && $ptna["shapes_after"] ) {
                        echo '                        <tr class="statistics-tablerow">' . "\n";
                        echo '                            <td class="statistics-name">Number of Shape Data before</td>' . "\n";
                        echo '                            <td class="statistics-number">'  . sprintf( "%d", htmlspecialchars($ptna["shapes_before"]) ) . '</td>' . "\n";
                        echo '                            <td class="statistics-number">[1]</td>' . "\n";
                        echo '                        </tr>' . "\n";
                        echo '                        <tr class="statistics-tablerow">' . "\n";
                        echo '                            <td class="statistics-name">Number of Shape Data after</td>' . "\n";
                        echo '                            <td class="statistics-number">'  . sprintf( "%d", htmlspecialchars($ptna["shapes_after"]) ) . '</td>' . "\n";
                        echo '                            <td class="statistics-number">[1]</td>' . "\n";
                        echo '                        </tr>' . "\n";
                    }
                }

                $stop_time = gettimeofday(true);

                return $stop_time - $start_time;

            } catch ( Exception $ex ) {
                echo "Sqlite DB could not be opened: " . htmlspecialchars($ex->getMessage()) . "\n";
            }
        } else {
            echo "Sqlite DB not found for feed = '" . htmlspecialchars($feed) . "'\n";
        }

        return 0;
    }


    function CreatePtnaAnalysisStatistics( $feed, $release_date ) {

        $SqliteDb = FindGtfsSqliteDb( $feed, $release_date );

        if ( $SqliteDb != '' ) {

            try {

                $start_time = gettimeofday(true);

                $db  = new SQLite3( $SqliteDb );

                $sql = "SELECT name FROM sqlite_master WHERE type='table' AND name='ptna_analysis';";

                $sql_master = $db->querySingle( $sql, true );

                if ( $sql_master['name'] ) {

                    $sql = sprintf( "SELECT * FROM ptna_analysis;" );

                    $ptna = $db->querySingle( $sql, true );

                    if ( $ptna["date"] ) {
                        echo '                        <tr class="statistics-tablerow">' . "\n";
                        echo '                            <td class="statistics-name">Date</td>' . "\n";
                        echo '                            <td class="statistics-date">'  . htmlspecialchars($ptna["date"]) . '</td>' . "\n";
                        echo '                            <td class="statistics-number">[YYYY-MM-DD]</td>' . "\n";
                        echo '                        </tr>' . "\n";
                    }
                    if ( $ptna["duration"] ) {
                        $duration = $ptna["duration"];
                        echo '                        <tr class="statistics-tablerow">' . "\n";
                        echo '                            <td class="statistics-name">Duration</td>' . "\n";
                        echo '                            <td class="statistics-number">';
                        $format_mins = '%2d:';
                        $format_secs = '%2d';
                        if ( $duration > 3600 ) {
                            printf( "%2d:", $duration / 3600 );
                            $format_mins = '%02d:';
                        }
                        if ( $duration > 60 ) {
                            printf( $format_mins, ($duration % 3600) / 60 );
                            $format_secs = '%02d';
                        }
                        printf( $format_secs, ($duration % 60) );
                        echo '                            <td class="statistics-number">[hh:mm:ss]</td>' . "\n";
                        echo '                        </tr>' . "\n";
                    }

                    $sql        = "SELECT name FROM sqlite_master WHERE type='table' AND name='ptna_trips_comments';";
                    $sql_master = $db->querySingle( $sql, true );

                    if ( $sql_master['name'] ) {
                        $sql  = sprintf( "SELECT COUNT(*) as count FROM ptna_trips_comments WHERE subroute_of != '';" );
                        $ptna = $db->querySingle( $sql, true );
                        if ( $ptna["count"] ) {
                            echo '                        <tr class="statistics-tablerow">' . "\n";
                            echo '                            <td class="statistics-name">Sub-Routes</td>' . "\n";
                            echo '                            <td class="statistics-number"><a href="gtfs-analysis-details.php?feed=' . urlencode($feed) . '&release_date=' . urlencode($release_date) . '&topic=SUBR">'  . htmlspecialchars($ptna["count"]) . '</a></td>' . "\n";
                            echo '                            <td class="statistics-number">[1]</td>' . "\n";
                            echo '                        </tr>' . "\n";
                        }
                        $sql  = sprintf( "SELECT COUNT(*) as count FROM ptna_trips_comments WHERE same_names_but_different_ids != '';" );
                        $ptna = $db->querySingle( $sql, true );
                        if ( $ptna["count"] ) {
                            echo '                        <tr class="statistics-tablerow">' . "\n";
                            echo '                            <td class="statistics-name">Trips with identical stop-names but different stop-ids</td>' . "\n";
                            echo '                            <td class="statistics-number"><a href="gtfs-analysis-details.php?feed=' . urlencode($feed) . '&release_date=' . urlencode($release_date) . '&topic=IDENT">'  . htmlspecialchars($ptna["count"]) . '</a></td>' . "\n";
                            echo '                            <td class="statistics-number">[1]</td>' . "\n";
                            echo '                        </tr>' . "\n";
                        }
                        $sql  = sprintf( "SELECT COUNT(*) as count FROM ptna_trips_comments WHERE suspicious_start != '';" );
                        $ptna = $db->querySingle( $sql, true );
                        if ( $ptna["count"] ) {
                            echo '                        <tr class="statistics-tablerow">' . "\n";
                            echo '                            <td class="statistics-name">Trips with suspicious start</td>' . "\n";
                            echo '                            <td class="statistics-number"><a href="gtfs-analysis-details.php?feed=' . urlencode($feed) . '&release_date=' . urlencode($release_date) . '&topic=SUSPSTART">'  . htmlspecialchars($ptna["count"]) . '</a></td>' . "\n";
                            echo '                            <td class="statistics-number">[1]</td>' . "\n";
                            echo '                        </tr>' . "\n";
                        }
                        $sql  = sprintf( "SELECT COUNT(*) as count FROM ptna_trips_comments WHERE suspicious_end != '';" );
                        $ptna = $db->querySingle( $sql, true );
                        if ( $ptna["count"] ) {
                            echo '                        <tr class="statistics-tablerow">' . "\n";
                            echo '                            <td class="statistics-name">Trips with suspicious end</td>' . "\n";
                            echo '                            <td class="statistics-number"><a href="gtfs-analysis-details.php?feed=' . urlencode($feed) . '&release_date=' . urlencode($release_date) . '&topic=SUSPEND">'  . htmlspecialchars($ptna["count"]) . '</a></td>' . "\n";
                            echo '                            <td class="statistics-number">[1]</td>' . "\n";
                            echo '                        </tr>' . "\n";
                        }
                    }
                }

                $stop_time = gettimeofday(true);

                return $stop_time - $start_time;

            } catch ( Exception $ex ) {
                echo "Sqlite DB could not be opened: " . htmlspecialchars($ex->getMessage()) . "\n";
            }
        } else {
            echo "Sqlite DB not found for feed = '" . htmlspecialchars($feed) . "'\n";
        }

        return 0;
    }


    function CreatePtnaNormalizationStatistics( $feed, $release_date ) {

        $SqliteDb = FindGtfsSqliteDb( $feed, $release_date );

        if ( $SqliteDb != '' ) {

            try {

                $start_time = gettimeofday(true);

                $db  = new SQLite3( $SqliteDb );

                $sql = "SELECT name FROM sqlite_master WHERE type='table' AND name='ptna_normalization';";

                $sql_master = $db->querySingle( $sql, true );

                if ( $sql_master['name'] ) {

                    $sql = sprintf( "SELECT * FROM ptna_normalization;" );

                    $ptna = $db->querySingle( $sql, true );

                    if ( $ptna["date"] ) {
                        echo '                        <tr class="statistics-tablerow">' . "\n";
                        echo '                            <td class="statistics-name">Date</td>' . "\n";
                        echo '                            <td class="statistics-date">'  . htmlspecialchars($ptna["date"]) . '</td>' . "\n";
                        echo '                            <td class="statistics-number">[YYYY-MM-DD]</td>' . "\n";
                        echo '                        </tr>' . "\n";
                    }
                    if ( $ptna["duration"] ) {
                        $duration = $ptna["duration"];
                        echo '                        <tr class="statistics-tablerow">' . "\n";
                        echo '                            <td class="statistics-name">Duration</td>' . "\n";
                        echo '                            <td class="statistics-number">';
                        $format_mins = '%2d:';
                        $format_secs = '%2d';
                        if ( $duration > 3600 ) {
                            printf( "%2d:", $duration / 3600 );
                            $format_mins = '%02d:';
                        }
                        if ( $duration > 60 ) {
                            printf( $format_mins, ($duration % 3600) / 60 );
                            $format_secs = '%02d';
                        }
                        printf( $format_secs, ($duration % 60) );
                        echo '                            <td class="statistics-number">[hh:mm:ss]</td>' . "\n";
                        echo '                        </tr>' . "\n";
                    }
                    if ( $ptna["routes"] ) {
                        echo '                        <tr class="statistics-tablerow">' . "\n";
                        echo '                            <td class="statistics-name">Routes</td>' . "\n";
                        echo '                            <td class="statistics-number">'  . htmlspecialchars($ptna["routes"]) . '</td>' . "\n";
                        echo '                            <td class="statistics-number">[1]</td>' . "\n";
                        echo '                        </tr>' . "\n";
                    }
                    if ( $ptna["stops"] ) {
                        echo '                        <tr class="statistics-tablerow">' . "\n";
                        echo '                            <td class="statistics-name">Stops</td>' . "\n";
                        echo '                            <td class="statistics-number">'  . htmlspecialchars($ptna["stops"]) . '</td>' . "\n";
                        echo '                            <td class="statistics-number">[1]</td>' . "\n";
                        echo '                        </tr>' . "\n";
                    }
                }

                $stop_time = gettimeofday(true);

                return $stop_time - $start_time;

            } catch ( Exception $ex ) {
                echo "Sqlite DB could not be opened: " . htmlspecialchars($ex->getMessage()) . "\n";
            }
        } else {
            echo "Sqlite DB not found for feed = '" . htmlspecialchars($feed) . "'\n";
        }

        return 0;
    }


    function CreateAnalysisDetailsForTrips( $feed, $release_date, $topic ) {

        $SqliteDb = FindGtfsSqliteDb( $feed, $release_date );

        if ( $SqliteDb != '') {

           if ( !$topic || preg_match("/^[ a-zA-Z0-9_.-]+$/", $topic) ) {

                try {

                    set_time_limit( 30 );

                    $start_time = gettimeofday(true);

                    $countrydir = array_shift( explode( '-', $feed ) );

                    $db = new SQLite3( $SqliteDb );

                    $sql        = "SELECT name FROM sqlite_master WHERE type='table' AND name='ptna_trips_comments';";
                    $sql_master = $db->querySingle( $sql, true );

                    if ( $sql_master['name'] ) {

                        $result = $db->query( "PRAGMA table_info(ptna_trips_comments);" );

                        $col_name['SUBR']      = '';
                        $col_name['SUSPSTART'] = '';
                        $col_name['SUSPEND']   = '';
                        $col_name['IDENT']     = '';
                        while ( $row=$result->fetchArray(SQLITE3_ASSOC) ) {
                            if ( $row["name"] == 'subroute_of' ) {
                                $col_name['SUBR']  = 'subroute_of';
                            }
                            elseif ( $row["name"] == 'suspicious_start' ) {
                                $col_name['SUSPSTART']  = 'suspicious_start';
                            }
                            elseif ( $row["name"] == 'suspicious_end' ) {
                                $col_name['SUSPEND']  = 'suspicious_end';
                            }
                            elseif ( $row["name"] == 'same_names_but_different_ids' ) {
                                $col_name['IDENT']  = 'same_names_but_different_ids';
                            }
                        }

                        if ( $topic ) {
                            $sql = sprintf( "SELECT             routes.route_id,route_short_name,ptna_trips_comments.trip_id,%s
                                             FROM               ptna_trips_comments
                                             JOIN               trips              ON   ptna_trips_comments.trip_id = trips.trip_id
                                             JOIN               routes             ON   trips.route_id              = routes.route_id
                                             WHERE              %s != ''
                                             ORDER BY CASE WHEN route_short_name GLOB '[^0-9]*'  THEN route_short_name ELSE CAST(route_short_name AS INTEGER) END;",
                                             $col_name[$topic], $col_name[$topic]
                                        );
                        } else {
                            $col_names = sprintf( "%s,%s,%s,%s", $col_name['SUBR'], $col_name['SUSPSTART'], $col_name['SUSPEND'], $col_name['IDENT'] );
                            $where_ors = sprintf( "%s != '' OR %s != '' OR %s != '' OR %s != ''", $col_name['SUBR'], $col_name['SUSPSTART'], $col_name['SUSPEND'], $col_name['IDENT'] );
                            $sql = sprintf( "SELECT             routes.route_id,route_short_name,ptna_trips_comments.trip_id,%s
                                             FROM               ptna_trips_comments
                                             JOIN               trips              ON   ptna_trips_comments.trip_id = trips.trip_id
                                             JOIN               routes             ON   trips.route_id              = routes.route_id
                                             WHERE              %s
                                             ORDER BY CASE WHEN route_short_name GLOB '[^0-9]*' THEN route_short_name ELSE CAST(route_short_name AS INTEGER) END;",
                                             $col_names, $where_ors
                                        );
                        }

                        $result = $db->query( $sql );

                        while ( $row=$result->fetchArray(SQLITE3_ASSOC) ) {
                            echo '                            <tr class="gtfs-tablerow">'    . "\n";
                            echo '                                <td class="gtfs-name"><a href="/gtfs/' . $countrydir . '/trips.php?feed='       . urlencode($feed) . '&release_date=' . urlencode($release_date) . '&route_id=' . urlencode($row["route_id"]) . '">' . htmlspecialchars($row["route_short_name"]) . '</a></td>' . "\n";
                            echo '                                <td class="gtfs-name"><a href="/gtfs/' . $countrydir . '/single-trip.php?feed=' . urlencode($feed) . '&release_date=' . urlencode($release_date) . '&trip_id='  . urlencode($row["trip_id"]) . '">' . htmlspecialchars($row["trip_id"]) . '</td>' . "\n";
                            echo '                                <td class="gtfs-comment">' . HandlePtnaComment($row) . '</td>' . "\n";
                            echo '                            </tr>' . "\n";
                        }
                    }

                    $db->close();

                    $stop_time = gettimeofday(true);

                    return $stop_time - $start_time;

                } catch ( Exception $ex ) {
                    echo "Sqlite DB could not be opened: " . htmlspecialchars($ex->getMessage()) . "\n";
                }
            }
        } else {
            echo "Sqlite DB not found for feed = '" . htmlspecialchars($feed) . "'\n";
        }

        return 0;

    }


    function GetBbox( $lat, $lon, $offset ) {
        $bbox['left']   = -0.0001;
        $bbox['right']  = +0.0001;
        $bbox['top']    = +0.0001;
        $bbox['bottom'] = -0.0001;

        $R  =   6378137;

        //offsets in meters
        $dn = $offset;
        $de = $offset;

        //Coordinate offsets in radians
        $dLat = $dn/$R;
        $dLon = $de/($R*cos(pi()*$lat/180));

        //OffsetPosition, decimal degrees
        $bbox['top']    = $lat + $dLat * 180/pi();
        $bbox['right']  = $lon + $dLon * 180/pi();
        $bbox['bottom'] = $lat - $dLat * 180/pi();
        $bbox['left']   = $lon - $dLon * 180/pi() ;

        return $bbox;
    }


    function RouteType2String( $rt ) {

        $route_type_to_string["0"]   = 'Tram, Streetcar, Light rail';
        $route_type_to_string["1"]   = 'Subway, Metro';
        $route_type_to_string["2"]   = 'Rail';
        $route_type_to_string["3"]   = 'Bus';
        $route_type_to_string["4"]   = 'Ferry';
        $route_type_to_string["5"]   = 'Cable tram';
        $route_type_to_string["6"]   = 'Aerialway';
        $route_type_to_string["7"]   = 'Funicular';
        $route_type_to_string["11"]  = 'Trolleybus';
        $route_type_to_string["12"]  = 'Monorail';

        # https://developers.google.com/transit/gtfs/reference/extended-route-types

        #                      Code 	Description 	                  Support 	   Examples
        $route_type_to_string["100"] = 'Railway Service';                 # Yes
        $route_type_to_string["101"] = 'High Speed Rail Service';               # Yes 	TGV (FR), ICE (DE), Eurostar (GB)
        $route_type_to_string["102"] = 'Long Distance Trains';            	      # Yes 	InterCity/EuroCity
        $route_type_to_string["103"] = 'Inter Regional Rail Service';               # Yes 	InterRegio (DE), Cross County Rail (GB)
        $route_type_to_string["104"] = 'Car Transport Rail Service';
        $route_type_to_string["105"] = 'Sleeper Rail Service';            	     # Yes 	GNER Sleeper (GB)
        $route_type_to_string["106"] = 'Regional Rail Service';                 # Yes 	TER (FR), Regionalzug (DE)
        $route_type_to_string["107"] = 'Tourist Railway Service';            	      # Yes 	Romney, Hythe & Dymchurch (GB)
        $route_type_to_string["108"] = 'Rail Shuttle (Within Complex)';                 # Yes 	Gatwick Shuttle (GB), Sky Line (DE)
        $route_type_to_string["109"] = 'Suburban Railway';            	     # Yes 	S-Bahn (DE), RER (FR), S-tog (Kopenhagen)
        $route_type_to_string["110"] = 'Replacement Rail Service';
        $route_type_to_string["111"] = 'Special Rail Service';
        $route_type_to_string["112"] = 'Lorry Transport Rail Service';
        $route_type_to_string["113"] = 'All Rail Services';
        $route_type_to_string["114"] = 'Cross-Country Rail Service';
        $route_type_to_string["115"] = 'Vehicle Transport Rail Service';
        $route_type_to_string["116"] = 'Rack and Pinion Railway';            	      # Rochers de Naye (CH), Dolderbahn (CH)
        $route_type_to_string["117"] = 'Additional Rail Service';
        $route_type_to_string["200"] = 'Coach Service 	Yes';
        $route_type_to_string["201"] = 'International Coach Service';            	     # Yes 	EuroLine, Touring
        $route_type_to_string["202"] = 'National Coach Service';            	      # Yes 	National Express (GB)
        $route_type_to_string["203"] = 'Shuttle Coach Service';            	 	      # Roissy Bus (FR), Reading-Heathrow (GB)
        $route_type_to_string["204"] = 'Regional Coach Service';            	     # Yes
        $route_type_to_string["205"] = 'Special Coach Service';
        $route_type_to_string["206"] = 'Sightseeing Coach Service';
        $route_type_to_string["207"] = 'Tourist Coach Service';
        $route_type_to_string["208"] = 'Commuter Coach Service';
        $route_type_to_string["209"] = 'All Coach Services';
        $route_type_to_string["400"] = 'Urban Railway Service';            	      # 	Yes
        $route_type_to_string["401"] = 'Metro Service';                # Yes 	Métro de Paris
        $route_type_to_string["402"] = 'Underground Service';                # Yes 	London Underground, U-Bahn
        $route_type_to_string["403"] = 'Urban Railway Service';                # Yes
        $route_type_to_string["404"] = 'All Urban Railway Services';
        $route_type_to_string["405"] = 'Monorail';                # Yes
        $route_type_to_string["700"] = 'Bus Service';                # Yes
        $route_type_to_string["701"] = 'Regional Bus Service';                # Yes 	Eastbourne-Maidstone (GB)
        $route_type_to_string["702"] = 'Express Bus Service';                # Yes 	X19 Wokingham-Heathrow (GB)
        $route_type_to_string["703"] = 'Stopping Bus Service'; 	  	     # 38 London: Clapton Pond-Victoria (GB)
        $route_type_to_string["704"] = 'Local Bus Service';                # Yes
        $route_type_to_string["705"] = 'Night Bus Service'; 	      # N prefixed buses in London (GB)
        $route_type_to_string["706"] = 'Post Bus Service'; 	       # Maidstone P4 (GB)
        $route_type_to_string["707"] = 'Special Needs Bus';
        $route_type_to_string["708"] = 'Mobility Bus Service';
        $route_type_to_string["709"] = 'Mobility Bus for Registered Disabled';
        $route_type_to_string["710"] = 'Sightseeing Bus';
        $route_type_to_string["711"] = 'Shuttle Bus'; 	  	     # 747 Heathrow-Gatwick Airport Service (GB)
        $route_type_to_string["712"] = 'School Bus';
        $route_type_to_string["713"] = 'School and Public Service Bus';
        $route_type_to_string["714"] = 'Rail Replacement Bus Service';
        $route_type_to_string["715"] = 'Demand and Response Bus Service';                # Yes
        $route_type_to_string["716"] = 'All Bus Services';
        $route_type_to_string["800"] = 'Trolleybus Service';                # Yes
        $route_type_to_string["900"] = 'Tram Service';                # Yes
        $route_type_to_string["901"] = 'City Tram Service';
        $route_type_to_string["902"] = 'Local Tram Service'; 	      # Munich (DE), Brussels (BE), Croydon (GB)
        $route_type_to_string["903"] = 'Regional Tram Service';
        $route_type_to_string["904"] = 'Sightseeing Tram Service'; 	      # Blackpool Seafront (GB)
        $route_type_to_string["905"] = 'Shuttle Tram Service';
        $route_type_to_string["906"] = 'All Tram Services';
        $route_type_to_string["907"] = 'Aerial Lift Service';               # Switzerland: 'Kabinenbahn'
        $route_type_to_string["1000"] = 'Water Transport Service';                # Yes
        $route_type_to_string["1100"] = 'Air Service';
        $route_type_to_string["1200"] = 'Ferry Service';                    # Yes
        $route_type_to_string["1300"] = 'Aerial Lift Service';              # Yes 	Telefèric de Montjuïc (ES), Saleve (CH), Roosevelt Island Tramway (US)
        $route_type_to_string["1400"] = 'Funicular Service';                # Yes 	Rigiblick (Zürich, CH)
        $route_type_to_string["1500"] = 'Taxi Service';
        $route_type_to_string["1501"] = 'Communal Taxi Service';            # Yes 	Marshrutka (RU), dolmuş (TR)
        $route_type_to_string["1502"] = 'Water Taxi Service';
        $route_type_to_string["1503"] = 'Rail Taxi Service';
        $route_type_to_string["1504"] = 'Bike Taxi Service';
        $route_type_to_string["1505"] = 'Licensed Taxi Service';
        $route_type_to_string["1506"] = 'Private Hire Service Vehicle';
        $route_type_to_string["1507"] = 'All Taxi Services';
        $route_type_to_string["1700"] = 'Miscellaneous Service';            # Yes
        $route_type_to_string["1702"] = 'Horse-drawn Carriage';             # Yes

        if ( $route_type_to_string[$rt] ) {
            return $route_type_to_string[$rt];
        } else {
            return $rt;
        }
    }


    function RouteType2OsmRoute( $rt ) {

        $rt = strtolower(RouteType2String($rt));

        if ( preg_match("/trolleybus/",$rt) ) {
            $rt = 'trolleybus';
        } elseif ( preg_match("/demand and response bus/",$rt) ) {
            $rt = 'share_taxi';
        } elseif ( preg_match("/tram/",$rt) ) {
            $rt = 'tram';
        } elseif ( preg_match("/bus/",$rt) ) {
            $rt = 'bus';
        } elseif ( preg_match("/monorail/",$rt) ) {
            $rt = 'monorail';
        } elseif ( preg_match("/ferry/",$rt) || preg_match("/water transport service/",$rt) ) {
            $rt = 'ferry';
        } elseif ( preg_match("/rail/",$rt) ) {
            $rt = 'train';
        } elseif ( preg_match("/funicular/",$rt) ) {
            $rt = 'funicular';
        } elseif ( preg_match("/aerial/",$rt) ) {
            $rt = 'aerialway';
        } elseif ( preg_match("/metro/",$rt) || preg_match("/subway/",$rt) || preg_match("/underground/",$rt) ) {
            $rt = 'subway';
        } else {
            $rt = 'bus';
        }

        return $rt;
    }


    function RouteType2OsmRouteImportance( $rt ) {

        $rt = strtolower(RouteType2String($rt));

        if ( preg_match("/trolleybus/",$rt) ) {
            $rt = '05';
        } elseif ( preg_match("/demand and response bus/",$rt) ) {
            $rt = '06';
        } elseif ( preg_match("/tram/",$rt) ) {
            $rt = '03';
        } elseif ( preg_match("/bus/",$rt) ) {
            $rt = '04';
        } elseif ( preg_match("/monorail/",$rt) ) {
            $rt = '07';
        } elseif ( preg_match("/ferry/",$rt) || preg_match("/water transport service/",$rt) ) {
            $rt = '10';
        } elseif ( preg_match("/rail/",$rt) ) {
            $rt = '01';
        } elseif ( preg_match("/funicular/",$rt) ) {
            $rt = '08';
        } elseif ( preg_match("/aerial/",$rt) ) {
            $rt = '09';
        } elseif ( preg_match("/metro/",$rt) || preg_match("/subway/",$rt) || preg_match("/underground/",$rt) ) {
            $rt = '02';
        } else {
            $rt = '04';
        }

        return $rt;
    }


    function OsmRoute2Vehicle( $rt, $language ) {
        if ( !$language || $language == 'de' ) {
            if ( $rt == 'trolleybus' ) {
                $rt = 'Trolleybus';
            } elseif ( $rt == 'share_taxi' ) {
                $rt = 'Ruftaxi';
            } elseif ( $rt == 'tram' ) {
                $rt = 'Tram';
            } elseif ( $rt == 'bus' ) {
                $rt = 'Bus';
            } elseif ( $rt == 'monorail' ) {
                $rt = 'Monorail';
            } elseif ( $rt == 'ferry' ) {
                $rt = 'Fähre';
            } elseif ( $rt == 'train' ) {
                $rt = 'Zug';
            } elseif ( $rt == 'funicular' ) {
                $rt = 'Drahtseilbahn';
            } elseif ( $rt == 'subway' ) {
                $rt = 'U-Bahn';
            } elseif ( $rt == 'aerialway' ) {
                $rt = 'Seilbahn';
            } else {
                $rt = 'bus';
            }
        } else {
            if ( $rt == 'trolleybus' ) {
                $rt = 'Trolleybus';
            } elseif ( $rt == 'share_taxi' ) {
                $rt = 'Share Taxi';
            } elseif ( $rt == 'tram' ) {
                $rt = 'Tram';
            } elseif ( $rt == 'bus' ) {
                $rt = 'Bus';
            } elseif ( $rt == 'monorail' ) {
                $rt = 'Monorail';
            } elseif ( $rt == 'ferry' ) {
                $rt = 'Ferry';
            } elseif ( $rt == 'train' ) {
                $rt = 'Train';
            } elseif ( $rt == 'funicular' ) {
                $rt = 'Funicular';
            } elseif ( $rt == 'subway' ) {
                $rt = 'Subway';
            } elseif ( $rt == 'aerialway' ) {
                $rt = 'Aerialway';
            } else {
                $rt = 'bus';
            }
        }

        return $rt;
    }


    function HandlePtnaComment( $param ) {
        global $gtfs_strings;
        $string = '';
        if ( is_string($param) ) {
            $string = preg_replace( "/::[A-Z]+::/", "", $param );
        } else {
            if ( isset($param['comment']) ) {
                $string = preg_replace( "/::[A-Z]+::/", "", $param['comment'] );
            }
            if ( isset($param['suspicious_start']) ) {
                $string .= "\n" . $gtfs_strings['suspicious_start'] . " '" . $param['suspicious_start'] . "'";
            }
            if ( isset($param['suspicious_end']) ) {
                $string .= "\n" . $gtfs_strings['suspicious_end'] . " '" . $param['suspicious_end'] . "'";
            }
            if ( isset($param['subroute_of']) ) {
                $string .= "\n" . $gtfs_strings['subroute_of'] . " " . preg_replace( "/,\s*/",", ", $param['subroute_of'] );
            }
            if ( isset($param['same_names_but_different_ids']) ) {
                $string .= "\n" . $gtfs_strings['same_names_but_different_ids'] . " " . preg_replace( "/,\s*/",", ", $param['same_names_but_different_ids'] );
            }
        }
        $string = preg_replace("/^\n/","", $string );
        return preg_replace("/\n/","<br />", htmlspecialchars($string) );
    }


    function sort_array_by_sort_key( $a, $b ) {
        if ( $a['sort_key'] == $b['sort_key'] ) {
            return 0;
        } elseif ( $a['sort_key'] > $b['sort_key'] ) {
            return 1;
        } else {
            return -1;
        }
    }
?>
