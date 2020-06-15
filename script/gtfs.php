<?php

    function FindGtfsSqliteDb( $network ) {
        global $path_to_work;

        $return_path = '';

        if ( $network && preg_match("/^[a-zA-Z0-9_.-]+$/", $network) ) {
            $prefixparts = explode( '-', $network );
            $countrydir  = array_shift( $prefixparts );

            $return_path = $path_to_work . $countrydir . '/' . $network . '-ptna-gtfs-sqlite.db';

            if ( file_exists($return_path) ) {
                return $return_path;
            } else {
                $subdir = array_shift( $prefixparts );

                $return_path = $path_to_work . $countrydir . '/' . $subdir . '/' . $network . '-ptna-gtfs-sqlite.db';

                if ( file_exists($return_path) ) {
                    return $return_path;
                }
            }

        }

        return '';
    }


    function CreateGtfsEntry( $network ) {

        $SqliteDb = FindGtfsSqliteDb( $network );

        if ( $SqliteDb != '' ) {

            try {

                $start_time = gettimeofday(true);

                $db         = new SQLite3( $SqliteDb );

                $sql        = "SELECT * FROM ptna";

                $ptna       = $db->querySingle( $sql, true );

                $sql        = "SELECT * FROM feed_info";

                $feed       = $db->querySingle( $sql, true );

                echo '                        <tr class="gtfs-tablerow">' . "\n";
                echo '                            <td class="gtfs-name"><a href="routes.php?network=' . urlencode($network) . '">' . htmlspecialchars($network) . '</a></td>' . "\n";
                if ( $ptna["network_name"] ) {
                    if ( $ptna["network_name_url"] ) {
                        echo '                            <td class="gtfs-text"><a target="_blank" href="' . $ptna["network_name_url"] . '">' . htmlspecialchars($ptna["network_name"]) . '</a></td>' . "\n";
                    } else {
                        echo '                            <td class="gtfs-text">' . htmlspecialchars($ptna["network_name"]) . '</td>' . "\n";
                    }
                } else {
                    echo '                            <td class="gtfs-text">&nbsp;</td>' . "\n";
                }
                if ( $feed["feed_publisher_name"] ) {
                    if ( $feed["feed_publisher_url"] ) {
                        echo '                            <td class="gtfs-text"><a target="_blank" href="' . $feed["feed_publisher_url"] . '" title="From GTFS">' . htmlspecialchars($feed["feed_publisher_name"]) . '</a></td>' . "\n";
                    } else {
                        echo '                            <td class="gtfs-text">' . htmlspecialchars($feed["feed_publisher_name"]) . '</td>' . "\n";
                    }
                } else {
                    if ( $ptna["feed_publisher_url"] ) {
                        echo '                            <td class="gtfs-text"><a target="_blank" href="' . $ptna["feed_publisher_url"] . '" title="From PTNA">' . htmlspecialchars($ptna["feed_publisher_name"]) . '</a></td>' . "\n";
                    } else {
                        echo '                            <td class="gtfs-text">' . htmlspecialchars($ptna["feed_publisher_name"]) . '</td>' . "\n";
                    }
                }
                if ( $feed["feed_start_date"] ) {
                    if ( preg_match( "/^(\d{4})(\d{2})(\d{2})$/", $feed["feed_start_date"], $parts ) ) {
                        echo '                            <td class="gtfs-date">' . $parts[1] . '-' .  $parts[2] . '-' .  $parts[3] . '</td>' . "\n";
                    } else {
                        echo '                            <td class="gtfs-date">' . htmlspecialchars($feed["feed_start_date"]) . '</td>' . "\n";
                    }
                } else {
                    echo '                            <td class="gtfs-date">&nbsp;</td>' . "\n";
                }
                if ( $feed["feed_end_date"] ) {
                    if ( preg_match( "/^(\d{4})(\d{2})(\d{2})$/", $feed["feed_end_date"], $parts ) ) {
                        $class = "gtfs-date";
                        $today = new DateTime();
                        if ( $feed["feed_end_date"] < $today->format('Ymd') )
                        {
                            $class = "gtfs-dateold";
                        }
                        echo '                            <td class="' . $class . '">' . $parts[1] . '-' .  $parts[2] . '-' .  $parts[3] . '</td>' . "\n";
                    } else {
                        echo '                            <td class="gtfs-date">' . htmlspecialchars($feed["feed_end_date"]) . '</td>' . "\n";
                    }
                } else {
                    echo '                            <td class="gtfs-date">&nbsp;</td>' . "\n";
                }
                echo '                            <td class="gtfs-number">' . htmlspecialchars($feed["feed_version"]) . '</td>' . "\n";
                if ( $ptna["release_date"] ) {
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
                if ( $ptna["prepared"] ) {
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
                if ( $ptna["details"] ) {
                    echo '                            <td class="gtfs-text"><a href="/en/gtfs-details.php?network=' . urlencode($network) . '">' . htmlspecialchars($ptna["details"]) . '</a></td>' . "\n";
                } else {
                    echo '                            <td class="gtfs-text"><a href="/en/gtfs-details.php?network=' . urlencode($network) . '">Details, ...</a></td>' . "\n";
                }
                echo '                        </tr>' . "\n";

                $db->close();

                $stop_time = gettimeofday(true);

                return $stop_time - $start_time;

            } catch ( Exception $ex ) {
                echo '                        <tr class="gtfs-tablerow">' . "\n";
                echo '                            <td class="gtfs-name">' . htmlspecialchars($network) . '</a></td>' . "\n";
                echo '                            <td class="gtfs-comment" colspan=7>SQLite DB: error opening data base</td>' . "\n";
                echo '                        </tr>' . "\n";
            }
        } else {
            echo '                        <tr class="gtfs-tablerow">' . "\n";
            echo '                            <td class="gtfs-name">' . htmlspecialchars($network) . '</a></td>' . "\n";
            echo '                            <td class="gtfs-comment" colspan=7>SQLite DB: data base not found (data not yet available?)</td>' . "\n";
            echo '                        </tr>' . "\n";
        }

        return 0;
    }

    function CreateGtfsRoutesEntry( $network ) {

        ob_implicit_flush(true);


        $SqliteDb = FindGtfsSqliteDb( $network );

        if ( $SqliteDb != '' ) {

           if (  $network ) {

               try {

                    $today      = new DateTime();

                    set_time_limit( 30 );

                    $start_time = gettimeofday(true);

                    $db         = new SQLite3( $SqliteDb );

                    $sql        = "SELECT * FROM ptna";

                    $ptna       = $db->querySingle( $sql, true );

                    $sql        = "SELECT DISTINCT    *
                                   FROM               routes
                                   JOIN               agency ON routes.agency_id = agency.agency_id
                                   ORDER BY CASE WHEN route_short_name GLOB '[^0-9]*' THEN route_short_name ELSE CAST(route_short_name AS INTEGER) END;";

                    $outerresult = $db->query( $sql );

                    $alternative_or_not    = 'alt';
                    $last_route_short_name = '__dummy__';
                    $last_agency_name      = '__dummy__';
                    $last_route_type       = '__dummy__';
                    $last_route_desc       = '__dummy__';

                    while ( $outerrow=$outerresult->fetchArray(SQLITE3_ASSOC) ) {

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
                            $last_route_desc       = $outerrow["route_desc"];
                        }

                        if ( isset($outerrow["route_type"]) ) {
                            $route_type_text = RouteType2String($outerrow["route_type"]);
                        } else {
                            $route_type_text = '???';
                        }

                        if ( $ptna['consider_calendar'] ) {
                            $sql = sprintf( "SELECT DISTINCT calendar.start_date,calendar.end_date
                                             FROM            trips
                                             JOIN            calendar ON trips.service_id = calendar.service_id
                                             WHERE           trip_id  IN
                                                             (SELECT   trips.trip_id
                                                              FROM     trips
                                                              WHERE    trips.route_id='%s') AND %s >= calendar.start_date AND %s <= calendar.end_date
                                                              ORDER BY calendar.end_date DESC, calendar.start_date ASC LIMIT 1;", SQLite3::escapeString($outerrow["route_id"]), $today->format('Ymd'), $today->format('Ymd') );
                        } else {
                            $sql = sprintf( "SELECT DISTINCT calendar.start_date,calendar.end_date
                                             FROM            trips
                                             JOIN            calendar ON trips.service_id = calendar.service_id
                                             WHERE           trip_id  IN
                                                             (SELECT   trips.trip_id
                                                              FROM     trips
                                                              WHERE    trips.route_id='%s')
                                                              ORDER BY calendar.end_date DESC, calendar.start_date ASC;", SQLite3::escapeString($outerrow["route_id"]), $today->format('Ymd'), $today->format('Ymd') );
                        }

                        $innerresult = $db->query( $sql );

                        while ( $innerrow=$innerresult->fetchArray(SQLITE3_ASSOC) ) {

                            echo '                        <tr class="gtfs-tablerow' . $alternative_or_not . '">' . "\n";
                            if ( $outerrow["route_short_name"] ) {
                                echo '                            <td class="gtfs-name"><a href="trips.php?network=' . urlencode($network) . '&route_id=' . urlencode($outerrow["route_id"]) . '"><span class="route_short_name">' . htmlspecialchars($outerrow["route_short_name"]) . '</span><span class="route_id" style="display: none;">' . htmlspecialchars($outerrow["route_id"]) . '</span></a></td>' . "\n";
                            } else {
                                echo '                            <td class="gtfs-name"><a href="trips.php?network=' . urlencode($network) . '&route_id=' . urlencode($outerrow["route_id"]) . '"><span class="route_short_name">not set</span><span class="route_id" style="display: none;">' . htmlspecialchars($outerrow["route_id"]) . '</span></td>' . "\n";
                            }
                            echo '                            <td class="gtfs-text"><span class="route_type">' . htmlspecialchars($route_type_text) . '</span></td>' . "\n";
                            if ( preg_match( "/^(\d{4})(\d{2})(\d{2})$/", $innerrow["start_date"], $parts ) ) {
                                $class = "gtfs-date";
                                $today = new DateTime();
                                if ( $innerrow["start_date"] > $today->format('Ymd') )
                                {
                                    $class = "gtfs-datenew";
                                }
                                echo '                            <td class="' . $class . '">' . $parts[1] . '-' .  $parts[2] . '-' .  $parts[3] . '</td>' . "\n";
                            } else {
                                echo '                            <td class="gtfs-date">' . htmlspecialchars($innerrow["start_date"]) . '</td>' . "\n";
                            }
                            if ( preg_match( "/^(\d{4})(\d{2})(\d{2})$/", $innerrow["end_date"], $parts ) ) {
                                $class = "gtfs-date";
                                $today = new DateTime();
                                if ( $innerrow["end_date"] < $today->format('Ymd') )
                                {
                                    $class = "gtfs-dateold";
                                }
                                echo '                            <td class="' . $class . '">' . $parts[1] . '-' .  $parts[2] . '-' .  $parts[3] . '</td>' . "\n";
                            } else {
                                echo '                            <td class="gtfs-date">' . htmlspecialchars($innerrow["end_date"]) . '</td>' . "\n";
                            }
                            if ( $outerrow["normalized_route_long_name"] ) {
                                echo '                            <td class="gtfs-text"><span class="route_long_name">' . htmlspecialchars($outerrow["normalized_route_long_name"]) . '</span></td>' . "\n";
                            } elseif ( $outerrow["route_long_name"] ) {
                                echo '                            <td class="gtfs-text"><span class="route_long_name">' . htmlspecialchars($outerrow["route_long_name"]) . '</span></td>' . "\n";
                            } elseif ( $outerrow["route_desc"] ) {
                                echo '                            <td class="gtfs-text"><span class="route_long_name">' . htmlspecialchars($outerrow["route_desc"]) . '</span></td>' . "\n";
                            } else {
                                echo '                            <td class="gtfs-text"><span class="route_long_name">' . htmlspecialchars($outerrow["route_id"]) . '</span></td>' . "\n";
                            }
                            if ( $outerrow["agency_url"] ) {
                                echo '                            <td class="gtfs-text"><a target="_blank" href="' . $outerrow["agency_url"]. '"><span class="agency_name">' . htmlspecialchars($outerrow["agency_name"]) . '</span></a></td>' . "\n";
                            } else {
                                echo '                            <td class="gtfs-text"><span class="agency_name">' . htmlspecialchars($outerrow["agency_name"]) . '</span></td>' . "\n";
                            }
                            $sql    = sprintf( "SELECT ptna_is_invalid,ptna_is_wrong,ptna_comment
                                                FROM   routes
                                                WHERE  route_id='%s';",
                                                SQLite3::escapeString($outerrow["route_id"])
                                             );

                            $ptnarow = $db->querySingle( $sql, true );

#                            if ( $ptnarow["ptna_is_invalid"] ) { $checked = '<img src="/img/CheckMark.svg" width=32 height=32 alt="checked" />'; } else { $checked = ''; }
#                            echo '                            <td class="gtfs-checkbox">' . $checked . '</td>' . "\n";
#                            if ( $ptnarow["ptna_is_wrong"]   ) { $checked = '<img src="/img/CheckMark.svg" width=32 height=32 alt="checked" />'; } else { $checked = ''; }
#                            echo '                            <td class="gtfs-checkbox">' . $checked . '</td>' . "\n";
                            echo '                            <td class="gtfs-comment">' . LF2BR(htmlspecialchars($ptnarow["ptna_comment"])) . '</td>' . "\n";
                            echo '                        </tr>' . "\n";
                        }
                    }
                    $db->close();

                    $stop_time = gettimeofday(true);

                    return $stop_time - $start_time;

                } catch ( Exception $ex ) {
                    echo "Sqlite DB could not be opened: " . $ex->getMessage() . "\n";
                }
            }
        } else {
            echo "Sqlite DB not found for network = '" . $network . "'\n";
        }

        return 0;
    }


    function CreateGtfsTripsEntry( $network, $route_id, $route_short_name ) {

        $SqliteDb = FindGtfsSqliteDb( $network );

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
                            $stop_names = $innerrow["stop_name_list"] . '  |' . $outerrow["trip_id"];
                            array_push( $trip_array, $stop_names );
                        }
                    }

                    sort( $trip_array );

                    $index = 1;
                    foreach ( $trip_array as $stop_names ) {

                        $stop_name_array = explode( '  |', $stop_names );
                        $trip_id         = array_pop($stop_name_array);
                        $first_stop_name = array_shift( $stop_name_array );
                        $last_stop_name  = array_pop(   $stop_name_array );
                        $via_stop_names  = implode( ' => ', $stop_name_array );

                        $sql    = sprintf( "SELECT ptna_is_invalid,ptna_is_wrong,ptna_comment
                                            FROM   trips
                                            WHERE  trip_id='%s';",
                                            SQLite3::escapeString($trip_id)
                                         );

                        $ptnarow = $db->querySingle( $sql, true );

                        $start_end_array = GetStartEndDateOfIdenticalTrips( $network, $trip_id );

                        echo '                        <tr class="gtfs-tablerow">' . "\n";
                        echo '                            <td class="gtfs-number">' . $index . '</td>' . "\n";
                        echo '                            <td class="gtfs-name"><a href="single-trip.php?network=' . urlencode($network) . '&trip_id=' . urlencode($trip_id) . '">' . htmlspecialchars($trip_id) . '</a></td>' . "\n";
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
#                        if ( $ptnarow["ptna_is_invalid"] ) { $checked = '<img src="/img/CheckMark.svg" width=32 height=32 alt="checked" />'; } else { $checked = ''; }
#                        echo '                            <td class="gtfs-checkbox">' . $checked . '</td>' . "\n";
#                        if ( $ptnarow["ptna_is_wrong"]   ) { $checked = '<img src="/img/CheckMark.svg" width=32 height=32 alt="checked" />'; } else { $checked = ''; }
#                        echo '                            <td class="gtfs-checkbox">' . $checked . '</td>' . "\n";
                        echo '                            <td class="gtfs-comment">' . LF2BR(htmlspecialchars($ptnarow["ptna_comment"])) . '</td>' . "\n";
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
            echo "Sqlite DB not found for network = '" . $network . "'\n";
        }

        return 0;
    }


    function CreateOsmTaggingSuggestion( $network, $trip_id ) {

        $SqliteDb = FindGtfsSqliteDb( $network );

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

                    $sql = sprintf( "SELECT *
                                     FROM   routes
                                     JOIN   trips ON trips.route_id = routes.route_id
                                     WHERE  trip_id='%s';",
                                     SQLite3::escapeString($trip_id)
                                  );

                    $routes = $db->querySingle( $sql, true );

                    $sql = sprintf( "SELECT *
                                     FROM   trips
                                     WHERE  trip_id='%s';",
                                     SQLite3::escapeString($trip_id)
                                  );

                    $trips = $db->querySingle( $sql, true );

                    $sql = sprintf( "SELECT   *
                                     FROM     stops
                                     JOIN     stop_times ON stop_times.stop_id = stops.stop_id
                                     WHERE    stop_times.trip_id='%s'
                                     ORDER BY CAST (stop_times.stop_sequence AS INTEGER) ASC
                                     LIMIT 1;",
                                     SQLite3::escapeString($trip_id)
                                  );

                    $stops1 = $db->querySingle( $sql, true );

                    $sql = sprintf( "SELECT   *
                                     FROM     stops
                                     JOIN     stop_times ON stop_times.stop_id = stops.stop_id
                                     WHERE    stop_times.trip_id='%s'
                                     ORDER BY CAST (stop_times.stop_sequence AS INTEGER) DESC
                                     LIMIT 1;",
                                     SQLite3::escapeString($trip_id)
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
                    $osm_ref_trips     = htmlspecialchars( $trip_id );
                    $osm_gtfs_route_id = htmlspecialchars( $routes['route_id'] );
                    $osm_gtfs_trip_id  = htmlspecialchars( $trip_id );
                    $osm_gtfs_shape_id = htmlspecialchars( $trips['shape_id'] );
                    if ( $osm['trip_id_regex'] && preg_match("/^".$osm['trip_id_regex']."$/",$trip_id) ) {
                        $osm_ref_trips         = preg_replace( "/".$osm['trip_id_regex']."/","\\1", $trip_id );
                        $osm_gtfs_trip_id_like = preg_replace( "/".$osm['trip_id_regex']."/","\\1", $trip_id );
                        if ( !preg_match("/^^\(/",$osm['trip_id_regex']) ) {
                            $osm_gtfs_trip_id_like = "%" . $osm_gtfs_trip_id_like;
                        }
                        if ( !preg_match("/\)\\$$/",$osm['trip_id_regex']) ) {
                            $osm_gtfs_trip_id_like = $osm_gtfs_trip_id_like . "%";
                        }
                        $osm_ref_trips         = htmlspecialchars( $osm_ref_trips         );
                        $osm_gtfs_trip_id_like = htmlspecialchars( $osm_gtfs_trip_id_like );
                    }

                    # ROUTE-MASTER
                    echo '                    <table id="osm-route-master" style="float: left; margin-right: 20px;">' . "\n";
                    echo '                        <thead>' . "\n";
                    echo '                            <tr class="gtfs-tableheaderrow">' . "\n";
                    echo '                                <th class="gtfs-name" colspan="2">Route-Master</th>' . "\n";
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
                    echo '                                <th class="gtfs-name" colspan="2">Route</th>' . "\n";
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
                    if ( $osm_gtfs_route_id ) {
                        echo '                            <tr class="gtfs-tablerow">' . "\n";
                        echo '                                <td class="gtfs-name">gtfs:route_id</td>' . "\n";
                        echo '                                <td class="gtfs-name">' . $osm_gtfs_route_id . '</td>' . "\n";
                        echo '                            </tr>' . "\n";
                    }
                    if ( $osm_gtfs_trip_id ) {
                        echo '                            <tr class="gtfs-tablerow">' . "\n";
                        echo '                                <td class="gtfs-name">gtfs:trip_id</td>' . "\n";
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

                } catch ( Exception $ex ) {
                    echo "Sqlite DB could not be opened: " . $ex->getMessage() . "\n";
                }
            }
        } else {
            echo "Sqlite DB not found for network = '" . $network . "'\n";
        }

        return 0;
    }


    function CreateGtfsSingleTripEntry( $network, $trip_id ) {

        $SqliteDb = FindGtfsSqliteDb( $network );

        if ( $SqliteDb != '') {

           if ( $trip_id ) {

               try {

                    set_time_limit( 30 );

                    $start_time = gettimeofday(true);

                    $db = new SQLite3( $SqliteDb );

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
                        echo '                       <tr class="gtfs-tablerow">' . "\n";
                        echo '                           <td class="gtfs-number">'   . $counter++ . '</td>' . "\n";
                        echo '                           <td class="gtfs-name">'     . htmlspecialchars($row["stop_name"]) . '</td>' . "\n";
                        echo '                           <td class="gtfs-comment">';
                        printf( '%s%s/%s%s', '<a href="https://www.openstreetmap.org/edit?editor=id#map=21/', $row["stop_lat"], $row["stop_lon"], '" target="_blank" title="Edit area in iD">iD</a>' );
                        $bbox = GetBbox( $row["stop_lat"], $row["stop_lon"], 15 );
                        printf( ', %sleft=%s&right=%s&top=%s&bottom=%s%s', '<a href="http://127.0.0.1:8111/load_and_zoom?', $bbox['left'],$bbox['right'],$bbox['top'],$bbox['bottom'], '&new_layer=false" target="hiddenIframe" title="Download area (30 m * 30 m) in JOSM">JOSM</a>' );
                        echo '</td>' . "\n";
                        echo '                           <td class="gtfs-date">'     . htmlspecialchars($row["departure_time"])        . '</td>' . "\n";
                        echo '                           <td class="gtfs-lat">'      . htmlspecialchars($row["stop_lat"])        . '</td>' . "\n";
                        echo '                           <td class="gtfs-lon">'      . htmlspecialchars($row["stop_lon"])        . '</td>' . "\n";
                        echo '                           <td class="gtfs-id">'       . htmlspecialchars($row["stop_id"])         . '</td>' . "\n";
#                        if ( $row["ptna_is_invalid"] ) { $checked = '<img src="/img/CheckMark.svg" width=32 height=32 alt="checked" />'; } else { $checked = ''; }
#                        echo '                           <td class="gtfs-checkbox">' . $checked . '</td>' . "\n";
#                        if ( $row["ptna_is_wrong"]   ) { $checked = '<img src="/img/CheckMark.svg" width=32 height=32 alt="checked" />'; } else { $checked = ''; }
#                        echo '                           <td class="gtfs-checkbox">' . $checked . '</td>' . "\n";
                        echo '                           <td class="gtfs-comment">'  . LF2BR(htmlspecialchars($row["ptna_comment"])) . '</td>' . "\n";
                        echo '                       </tr>' . "\n";
                    }

                    $db->close();

                    $stop_time = gettimeofday(true);

                    return $stop_time - $start_time;

                } catch ( Exception $ex ) {
                    echo "Sqlite DB could not be opened: " . $ex->getMessage() . "\n";
                }
            }
        } else {
            echo "Sqlite DB not found for network = '" . $network . "'\n";
        }

        return 0;
    }


    function GetStartEndDateOfIdenticalTrips( $network, $trip_id ) {

        $return_array = array();

        $return_array["start_date"] = '';
        $return_array["end_date"]   = '';

        $SqliteDb = FindGtfsSqliteDb( $network );

        if ( $SqliteDb != '' ) {

           if ( $trip_id ) {

               try {

                    $db = new SQLite3( $SqliteDb );

                    $sql        = "SELECT name FROM sqlite_master WHERE type='table' AND name='ptna_trips';";

                    $sql_master = $db->querySingle( $sql, true );

                    if ( $sql_master['name'] ) {

                        $sql    = sprintf( "SELECT DISTINCT *
                                            FROM            ptna_trips
                                            WHERE           trip_id='%s'",
                                            SQLite3::escapeString($trip_id)
                                         );
                        $result = $db->querySingle( $sql, true );

                        if ( $result['list_service_ids'] ) {
                            $temp_array = array();
                            $temp_array = array_flip( array_flip( explode( '|', $result['list_service_ids'] ) ) );
                            $where_clause = "service_id='";
                            foreach ( $temp_array as $service_id ) {
                                $where_clause .= SQLite3::escapeString($service_id) . "' OR service_id='";
                            }
                            $sql = sprintf( "SELECT start_date,end_date
                                             FROM   calendar
                                             WHERE  %s
                                             ORDER BY end_date DESC, start_date ASC LIMIT 1;", preg_replace( "/ OR service_id='$/", "", $where_clause ) );

                            $result = $db->querySingle( $sql, true );

                            $return_array["start_date"] = $result["start_date"];
                            $return_array["end_date"]   = $result["end_date"];
                        }
                    }

                    $db->close();

                } catch ( Exception $ex ) {
                    echo "Sqlite DB could not be opened: " . $ex->getMessage() . "\n";
                }
            }
        } else {
            echo "Sqlite DB not found for network = '" . $network . "'\n";
        }

        return $return_array;
    }


    function GetDepartureTimesGtfsSingleTrip( $network, $trip_id ) {

        $return_value = '';
        $temp_array   = array();

        $SqliteDb = FindGtfsSqliteDb( $network );

        if ( $SqliteDb != '') {

           if ( $trip_id ) {

               try {

                    $start_time = gettimeofday(true);

                    $db = new SQLite3( $SqliteDb );

                    $sql        = "SELECT name FROM sqlite_master WHERE type='table' AND name='ptna_trips';";

                    $sql_master = $db->querySingle( $sql, true );

                    if ( $sql_master['name'] ) {

                        $sql    = sprintf( "SELECT DISTINCT list_departure_times
                                            FROM            ptna_trips
                                            WHERE           trip_id='%s'",
                                            SQLite3::escapeString($trip_id)
                                         );
                        $result = $db->querySingle( $sql, true );

                        if ( $result['list_departure_times'] ) {
                            $result['list_departure_times'] = preg_replace('/:\d\d$/',  '', $result['list_departure_times'] );
                            $result['list_departure_times'] = preg_replace('/:\d\d\|/', '|', $result['list_departure_times'] );
                            $temp_array = array_flip( explode( '|', $result['list_departure_times'] ) );
                            ksort( $temp_array );
                            return implode( ', ', array_keys($temp_array) );
                        }
                    }
                    $db->close();

                    $stop_time = gettimeofday(true);

                } catch ( Exception $ex ) {
                    echo "Sqlite DB could not be opened: " . $ex->getMessage() . "\n";
                }
            }
        } else {
            echo "Sqlite DB not found for network = '" . $network . "'\n";
        }

        $return_value;
    }


    function CreateGtfsSingleTripServiceTimesEntry( $network, $trip_id ) {

        $SqliteDb = FindGtfsSqliteDb( $network );

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
                                            WHERE           trip_id='%s'",
                                            SQLite3::escapeString($trip_id)
                                         );
                        $result = $db->querySingle( $sql, true );

                        if ( $result['list_service_ids'] ) {
                            $service_ids = array_flip( array_flip( explode( '|', $result['list_service_ids'] ) ) );
                            sort( $service_ids );
                            foreach ( $service_ids as $service_id ) {
                                echo '                          <tr class="gtfs-tablerow">' . "\n";
                                echo '                              <td class="gtfs-name" colspan="12">... coming soon ...</td>' . "\n";
                                echo '                              <td class="gtfs-text">' . $service_id . '</td>' . "\n";
                                echo '                          </tr>' . "\n";
                            }
                        } else {
                            echo '                          <tr class="gtfs-tablerow">' . "\n";
                            echo '                              <td class="gtfs-name" colspan="13">... not yet available ...</td>' . "\n";
                            echo '                          </tr>' . "\n";
                        }
                    }
                    $db->close();

                    $stop_time = gettimeofday(true);

                    return $stop_time - $start_time;

                } catch ( Exception $ex ) {
                    echo "Sqlite DB could not be opened: " . $ex->getMessage() . "\n";
                }
            }
        } else {
            echo "Sqlite DB not found for network = '" . $network . "'\n";
        }

        return 0;
    }



    function CreateGtfsSingleTripShapeEntry( $network, $trip_id ) {

        $SqliteDb = FindGtfsSqliteDb( $network );

        if ( $SqliteDb != '') {

           if ( $trip_id ) {

               try {

                    $start_time = gettimeofday(true);

                    $db = new SQLite3( $SqliteDb );

                    $sql        = "SELECT * FROM ptna";

                    $ptna       = $db->querySingle( $sql, true );

                    if ( $ptna["has_shapes"] ) {

                        $sql        = sprintf( "SELECT * FROM trips WHERE trip_id='%s'", SQLite3::escapeString($trip_id) );

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

                            echo '              <h3>GTFS Shape Data, Shape-id: "' . $shape_id . '"</h3>' ."\n";
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
                                if ( preg_match('/^\d+(\.\d+)?$/',$row["shape_dist_traveled"],$parts) ) {
                                    echo '                              <td class="gtfs-distance">'  . sprintf( "%.3f", $parts[0]/1000) . '</td>' . "\n";
                                } else {
                                    echo '                              <td class="gtfs-distance">'  . htmlspecialchars($row["shape_dist_traveled"]) . '</td>' . "\n";
                                }
                                echo '                          </tr>' . "\n";
                            }
                            echo '                      </tbody>' . "\n";
                            echo '                  </table>' . "\n";
                            echo '              </div>' . "\n";
                        }
                    }
                    $db->close();

                    $stop_time = gettimeofday(true);

                    return $stop_time - $start_time;

                } catch ( Exception $ex ) {
                    echo "Sqlite DB could not be opened: " . $ex->getMessage() . "\n";
                }
            }
        } else {
            echo "Sqlite DB not found for network = '" . $network . "'\n";
        }

        return 0;
    }


    function GetGtfsRouteShortNameFromRouteId( $network, $route_id ) {

        $SqliteDb = FindGtfsSqliteDb( $network );

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
                    echo "Sqlite DB could not be opened: " . $ex->getMessage() . "\n";
                }
            }
        } else {
            echo "Sqlite DB not found for network = '" . $network . "'\n";
        }

        return '';
    }


    function GetGtfsRouteIdFromTripId( $network, $trip_id ) {

        $SqliteDb = FindGtfsSqliteDb( $network );

        if ( $SqliteDb != '' ) {

            if ( $trip_id ) {

                try {

                    $db = new SQLite3( $SqliteDb );

                    $sql = sprintf( "SELECT route_id
                                     FROM   trips
                                     WHERE  trip_id='%s';",
                                     SQLite3::escapeString($trip_id)
                                  );

                    $row = $db->querySingle( $sql, true );

                    return $row["route_id"];

                } catch ( Exception $ex ) {
                    echo "Sqlite DB could not be opened: " . $ex->getMessage() . "\n";
                }
            }
        } else {
            echo "Sqlite DB not found for network = '" . $network . "'\n";
        }

        return '';
    }


    function GetGtfsRouteShortNameFromTripId( $network, $trip_id ) {

        $SqliteDb = FindGtfsSqliteDb( $network );

        if ( $SqliteDb != '' ) {

            if ( $trip_id ) {

                try {

                    $db = new SQLite3( $SqliteDb );

                    $sql = sprintf( "SELECT route_short_name
                                     FROM   routes
                                     JOIN   trips ON trips.route_id = routes.route_id
                                     WHERE  trip_id='%s';",
                                     SQLite3::escapeString($trip_id)
                                  );

                    $row = $db->querySingle( $sql, true );

                    return $row["route_short_name"];

                } catch ( Exception $ex ) {
                    echo "Sqlite DB could not be opened: " . $ex->getMessage() . "\n";
                }
            }
        } else {
            echo "Sqlite DB not found for network = '" . $network . "'\n";
        }

        return '';
    }


    function GetGtfsTripIdFromShapeId( $network, $shape_id ) {

        $SqliteDb = FindGtfsSqliteDb( $network );

        if ( $SqliteDb != '' ) {

            if ( $shape_id ) {

                try {

                    $db = new SQLite3( $SqliteDb );

                    $sql = sprintf( "SELECT trip_id
                                     FROM   trips
                                     WHERE  shape_id='%s';",
                                     SQLite3::escapeString($shape_id)
                                  );

                    $row = $db->querySingle( $sql, true );

                    return $row["trip_id"];

                } catch ( Exception $ex ) {
                    echo "Sqlite DB could not be opened: " . $ex->getMessage() . "\n";
                }
            }
        } else {
            echo "Sqlite DB not found for network = '" . $network . "'\n";
        }

        return '';
    }


    function GetOsmDetails( $network ) {

        $SqliteDb = FindGtfsSqliteDb( $network );

        if ( $SqliteDb != '' ) {

            try {

                $db  = new SQLite3( $SqliteDb );

                $sql = sprintf( "SELECT * FROM osm" );

                $row = $db->querySingle( $sql, true );

                return $row;

            } catch ( Exception $ex ) {
                echo "Sqlite DB could not be opened: " . $ex->getMessage() . "\n";
            }
        } else {
            echo "Sqlite DB not found for network = '" . $network . "'\n";
        }

        return array();
    }


    function GetPtnaDetails( $network ) {

        $SqliteDb = FindGtfsSqliteDb( $network );

        if ( $SqliteDb != '' ) {

            try {

                $db  = new SQLite3( $SqliteDb );

                $sql = sprintf( "SELECT * FROM ptna" );

                $row = $db->querySingle( $sql, true );

                return $row;

            } catch ( Exception $ex ) {
                echo "Sqlite DB could not be opened: " . $ex->getMessage() . "\n";
            }
        } else {
            echo "Sqlite DB not found for network = '" . $network . "'\n";
        }

        return array();
    }


    function GetTripDetails( $network, $trip_id ) {

        $SqliteDb = FindGtfsSqliteDb( $network );

        if ( $SqliteDb != '' ) {

            if ( $trip_id ) {

                try {

                    $db  = new SQLite3( $SqliteDb );

                    $sql = sprintf( "SELECT *
                                     FROM   trips
                                     WHERE  trip_id='%s';",
                                     SQLite3::escapeString($trip_id)
                                  );

                    $row = $db->querySingle( $sql, true );

                    return $row;

                } catch ( Exception $ex ) {
                    echo "Sqlite DB could not be opened: " . $ex->getMessage() . "\n";
                }
            }
        } else {
            echo "Sqlite DB not found for network = '" . $network . "'\n";
        }

        return array();
    }


    function GetRouteDetails( $network, $route_id ) {

        $SqliteDb = FindGtfsSqliteDb( $network );

        if ( $SqliteDb != '' ) {

            if ( $route_id ) {

                try {

                    $db  = new SQLite3( $SqliteDb );

                    $sql = sprintf( "SELECT *
                                     FROM   routes
                                     WHERE  route_id='%s';",
                                     SQLite3::escapeString($route_id)
                                  );

                    $row = $db->querySingle( $sql, true );

                    return $row;

                } catch ( Exception $ex ) {
                    echo "Sqlite DB could not be opened: " . $ex->getMessage() . "\n";
                }
            }
        } else {
            echo "Sqlite DB not found for network = '" . $network . "'\n";
        }

        return array();
    }


    function CreatePtnaDetails( $network ) {

        $SqliteDb = FindGtfsSqliteDb( $network );

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
                    echo '                           <td class="gtfs-text"><img src="/img/CheckMark.svg" width=32 height=32 alt="yes" /></td>' . "\n";
                } else {
                    echo '                           <td class="gtfs-text"></td>' . "\n";
                }
                echo '                        </tr>' . "\n";

                echo '                        <tr class="statistics-tablerow">' . "\n";
                echo '                            <td class="gtfs-name">Consider calendar data</td>' . "\n";
                if ( $ptna["consider_calendar"] ) {
                    echo '                           <td class="gtfs-text"><img src="/img/CheckMark.svg" width=32 height=32 alt="yes" /></td>' . "\n";
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
                echo "Sqlite DB could not be opened: " . $ex->getMessage() . "\n";
            }
        } else {
            echo "Sqlite DB not found for network = '" . $network . "'\n";
        }

        return 0;
    }


    function CreateOsmDetails( $network ) {

        $SqliteDb = FindGtfsSqliteDb( $network );

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
                        echo '                                       <td class="gtfs-text"><img src="/img/CheckMark.svg" width=32 height=32 alt="yes" /></td>' . "\n";
                    } else {
                        echo '                                       <td class="gtfs-text"></td>' . "\n";
                    }

                    echo '                                    <tr class="statistics-tablerow">' . "\n";
                    echo '                                        <td class="gtfs-name">"ref_trips" can be taken as part of GTFS trip_id. Regular expression to extract this part.</td>' . "\n";
                    echo '                                        <td class="gtfs-text">' . htmlspecialchars($osm["trip_id_regex"]) . '</td>' . "\n";
                    echo '                                    </tr>' . "\n";
                }

                $stop_time = gettimeofday(true);

                return $stop_time - $start_time;

            } catch ( Exception $ex ) {
                echo "Sqlite DB could not be opened: " . $ex->getMessage() . "\n";
            }
        } else {
            echo "Sqlite DB not found for network = '" . $network . "'\n";
        }

        return 0;
    }


   function CreatePtnaAggregationStatistics( $network ) {

        $SqliteDb = FindGtfsSqliteDb( $network );

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
                echo "Sqlite DB could not be opened: " . $ex->getMessage() . "\n";
            }
        } else {
            echo "Sqlite DB not found for network = '" . $network . "'\n";
        }

        return 0;
    }


    function CreatePtnaAnalysisStatistics( $network ) {

        $SqliteDb = FindGtfsSqliteDb( $network );

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
                    if ( $ptna["count_subroute"] ) {
                        echo '                        <tr class="statistics-tablerow">' . "\n";
                        echo '                            <td class="statistics-name">Sub-Routes</td>' . "\n";
                        echo '                            <td class="statistics-number">'  . htmlspecialchars($ptna["count_subroute"]) . '</td>' . "\n";
                        echo '                            <td class="statistics-number">[1]</td>' . "\n";
                        echo '                        </tr>' . "\n";
                    }
                    if ( $ptna["count_same_names_but_different_ids"] ) {
                        echo '                        <tr class="statistics-tablerow">' . "\n";
                        echo '                            <td class="statistics-name">Trips with identical stop-names but different stop-ids</td>' . "\n";
                        echo '                            <td class="statistics-number">'  . htmlspecialchars($ptna["count_same_names_but_different_ids"]) . '</td>' . "\n";
                        echo '                            <td class="statistics-number">[1]</td>' . "\n";
                        echo '                        </tr>' . "\n";
                    }
                    if ( $ptna["count_suspicious_start"] ) {
                        echo '                        <tr class="statistics-tablerow">' . "\n";
                        echo '                            <td class="statistics-name">Trips with suspicious start</td>' . "\n";
                        echo '                            <td class="statistics-number">'  . htmlspecialchars($ptna["count_suspicious_start"]) . '</td>' . "\n";
                        echo '                            <td class="statistics-number">[1]</td>' . "\n";
                        echo '                        </tr>' . "\n";
                    }
                    if ( $ptna["count_suspicious_end"] ) {
                        echo '                        <tr class="statistics-tablerow">' . "\n";
                        echo '                            <td class="statistics-name">Trips with suspicious end</td>' . "\n";
                        echo '                            <td class="statistics-number">'  . htmlspecialchars($ptna["count_suspicious_end"]) . '</td>' . "\n";
                        echo '                            <td class="statistics-number">[1]</td>' . "\n";
                        echo '                        </tr>' . "\n";
                    }
                }

                $stop_time = gettimeofday(true);

                return $stop_time - $start_time;

            } catch ( Exception $ex ) {
                echo "Sqlite DB could not be opened: " . $ex->getMessage() . "\n";
            }
        } else {
            echo "Sqlite DB not found for network = '" . $network . "'\n";
        }

        return 0;
    }


    function CreatePtnaNormalizationStatistics( $network ) {

        $SqliteDb = FindGtfsSqliteDb( $network );

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
                echo "Sqlite DB could not be opened: " . $ex->getMessage() . "\n";
            }
        } else {
            echo "Sqlite DB not found for network = '" . $network . "'\n";
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
        } elseif ( preg_match("/metro/",$rt) || preg_match("/subway/",$rt) || preg_match("/underground/",$rt) ) {
            $rt = 'subway';
        } else {
            $rt = 'bus';
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
            } else {
                $rt = 'bus';
            }
        }

        return $rt;
    }


    function LF2BR( $string ) {
        return preg_replace("/\n/","<br />",$string);
    }


?>
