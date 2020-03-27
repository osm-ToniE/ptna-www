<?php
    include('../../script/globals.php');

    function FindGtfsSqliteDb( $network ) {
        global $path_to_work;
        
        $return_path = '';

        if ( $network && preg_match("/^[a-zA-Z0-9_-]+$/", $network) ) {
            $prefixparts = explode( '-', $network );
            $countrydir  = array_shift( $prefixparts );
            if ( count($prefixparts) > 1 ) {
                $subdir = array_shift( $prefixparts );
                $return_path = $path_to_work . $countrydir . '/' . $subdir . '/' . $network . '-ptna-gtfs-sqlite.db';
            } else {
                $return_path = $path_to_work . $countrydir . '/' . $network . '-ptna-gtfs-sqlite.db';
            }
        
            if ( file_exists($return_path) ) {
                return $return_path;
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
                 if ( isset($feed["feed_publisher_url"]) ) {
                    echo '                            <td class="gtfs-text"><a target="_blank" href="' . $feed["feed_publisher_url"] . '">' . htmlspecialchars($feed["feed_publisher_name"]) . '</a></td>' . "\n";
                } else {
                    echo '                            <td class="gtfs-text">' . htmlspecialchars($feed["feed_publisher_name"]) . '</td>' . "\n";
                }
                if ( preg_match( "/^(\d{4})(\d{2})(\d{2})$/", $feed["feed_start_date"], $parts ) ) {
                    echo '                            <td class="gtfs-date">' . $parts[1] . '-' .  $parts[2] . '-' .  $parts[3] . '</td>' . "\n";
                } else {
                    echo '                            <td class="gtfs-date">' . htmlspecialchars($feed["feed_start_date"]) . '</td>' . "\n";
                }
                if ( preg_match( "/^(\d{4})(\d{2})(\d{2})$/", $feed["feed_end_date"], $parts ) ) {
                    echo '                            <td class="gtfs-date">' . $parts[1] . '-' .  $parts[2] . '-' .  $parts[3] . '</td>' . "\n";
                } else {
                    echo '                            <td class="gtfs-date">' . htmlspecialchars($feed["feed_end_date"]) . '</td>' . "\n";
                }
                echo '                            <td class="gtfs-number">' . htmlspecialchars($feed["feed_version"]) . '</td>' . "\n";
                if ( isset($ptna["release_url"]) ) {
                    echo '                            <td class="gtfs-date"><a target="_blank" href="' . $ptna["release_url"] . '">' . htmlspecialchars($ptna["release_date"]) . '</a></td>' . "\n";
                } else {
                    echo '                            <td class="gtfs-date">' . htmlspecialchars($ptna["release_date"]) . '</td>' . "\n";
                }
                if ( isset($ptna["original_license_url"]) ) {
                    echo '                            <td class="gtfs-text"><a target="_blank" href="' . $ptna["original_license_url"] . '">' . htmlspecialchars($ptna["original_license"]) . '</a></td>' . "\n";
                } else {
                    echo '                            <td class="gtfs-text">' . htmlspecialchars($row["original_license"]) . '</td>' . "\n";
                }
                if ( isset($ptna["license_url"]) ) {
                    echo '                            <td class="gtfs-text"><a target="_blank" href="' . $ptna["license_url"] . '">' . htmlspecialchars($ptna["license"]) . '</a></td>' . "\n";
                } else {
                    echo '                            <td class="gtfs-text">' . htmlspecialchars($ptna["license"]) . '</td>' . "\n";
                }
                echo '                            <td class="gtfs-checkbox">' . htmlspecialchars($ptna["prepared"])   . '</td>' . "\n";
                echo '                            <td class="gtfs-checkbox">' . htmlspecialchars($ptna["aggregated"]) . '</td>' . "\n";
                echo '                            <td class="gtfs-comment">'  . htmlspecialchars($ptna["normalized"]) .' </td>' . "\n";
                echo '                        </tr>' . "\n";
                
                $db->close();
    
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

    function CreateGtfsRoutesEntry( $network ) {

        $SqliteDb = FindGtfsSqliteDb( $network );
        
        if ( $SqliteDb != '' ) {

           if (  $network ) {
                
               try {
                   
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
                    $route_type_to_string["701"] = 'Bus (701)';
                    $route_type_to_string["702"] = 'Express Bus (702)';
                    $route_type_to_string["715"] = 'Ruftaxi (715)';
                    
                    $today      = new DateTime();
                        
                    $start_time = gettimeofday(true);
                    
                    $db         = new SQLite3( $SqliteDb );
                    
                    $sql        = "SELECT DISTINCT routes.route_short_name,routes.route_long_name,routes.route_id,routes.route_type,agency.agency_name,agency.agency_url,routes.ptna_is_invalid,routes.ptna_is_wrong,routes.ptna_comment 
                                   FROM            routes 
                                   JOIN            agency ON routes.agency_id = agency.agency_id 
                                   ORDER BY        route_short_name;";
    
                    $outerresult = $db->query( $sql );
                    
                    while ( $outerrow=$outerresult->fetchArray() ) {

                        if ( $outerrow["route_type"] && $route_type_to_string[$outerrow["route_type"]] ) {
                            $route_type_text = $route_type_to_string[$outerrow["route_type"]];
                        } else {
                            $route_type_text = $outerrow["route_type"];
                        }
                                
                        $sql = sprintf( "SELECT DISTINCT start_date,end_date 
                                         FROM            trips 
                                         JOIN            calendar ON trips.service_id = calendar.service_id 
                                         WHERE           trip_id  IN 
                                                         (SELECT   trip_id
                                                          FROM     trips
                                                          WHERE    route_id='%s') AND %s < end_date
                                                          ORDER BY start_date;", SQLite3::escapeString($outerrow["route_id"]), $today->format('Ymd') );
                                                   
                        $innerresult = $db->query( $sql );
                    
                        while ( $innerrow=$innerresult->fetchArray() ) {
    
                            echo '                        <tr class="gtfs-tablerow">' . "\n";
                            echo '                            <td class="gtfs-name"><a href="trips.php?network=' . urlencode($network) . '&route_id=' . urlencode($outerrow["route_id"]) . '">' . htmlspecialchars($outerrow["route_short_name"]) . '</a></td>' . "\n";
                            echo '                            <td class="gtfs-text">' . htmlspecialchars($route_type_text) . '</td>' . "\n";
                            echo '                            <td class="gtfs-text">' . htmlspecialchars($outerrow["route_long_name"]) . '</td>' . "\n";
                            if ( preg_match( "/^(\d{4})(\d{2})(\d{2})$/", $innerrow["start_date"], $parts ) ) {
                                echo '                            <td class="gtfs-date">' . $parts[1] . '-' .  $parts[2] . '-' .  $parts[3] . '</td>' . "\n";
                            } else {
                                echo '                            <td class="gtfs-date">' . htmlspecialchars($innerrow["start_date"]) . '</td>' . "\n";
                            }
                            if ( preg_match( "/^(\d{4})(\d{2})(\d{2})$/", $innerrow["end_date"], $parts ) ) {
                                echo '                            <td class="gtfs-date">' . $parts[1] . '-' .  $parts[2] . '-' .  $parts[3] . '</td>' . "\n";
                            } else {
                                echo '                            <td class="gtfs-date">' . htmlspecialchars($innerrow["end_date"]) . '</td>' . "\n";
                            }
                            if ( $outerrow["agency_url"] ) {
                                echo '                            <td class="gtfs-text"><a target="_blank" href="' . $outerrow["agency_url"]. '">' . htmlspecialchars($outerrow["agency_name"]) . '</a></td>' . "\n";
                            } else {
                                echo '                            <td class="gtfs-text">' . htmlspecialchars($outerrow["agency_name"]) . '</td>' . "\n";
                            }
                            if ( $innerrow["ptna_is_invalid"] ) { $checked = '<img src="/img/CheckMark.svg" width=32 height=32 alt="checked" />'; } else { $checked = ''; }
                            echo '                            <td class="gtfs-checkbox">' . $checked . '</td>' . "\n";
                            if ( $innerrow["ptna_is_wrong"]   ) { $checked = '<img src="/img/CheckMark.svg" width=32 height=32 alt="checked" />'; } else { $checked = ''; }
                            echo '                            <td class="gtfs-checkbox">' . $checked . '</td>' . "\n";
                            echo '                            <td class="gtfs-comment">' . htmlspecialchars($innerrow["ptna_comment"]) . '</td>' . "\n";
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

           if (  $route_id && $route_short_name ) {
                
                try {
                   
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
                    
                    while ( $outerrow=$outerresult->fetchArray() ) {
    
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
                    
                        echo '                        <tr class="gtfs-tablerow">' . "\n";
                        echo '                            <td class="gtfs-name">' . htmlspecialchars($route_short_name) . '</td>' . "\n";
                        echo '                            <td class="gtfs-name"><a href="single-trip.php?network=' . urlencode($network) . '&trip_id=' . urlencode($trip_id) . '">' . htmlspecialchars($trip_id) . '</a></td>' . "\n";
                        echo '                            <td class="gtfs-name">'     . htmlspecialchars($first_stop_name)            . '</td>' . "\n";
                        echo '                            <td class="gtfs-text">'     . htmlspecialchars($via_stop_names)             . '</td>' . "\n";
                        echo '                            <td class="gtfs-name">'     . htmlspecialchars($last_stop_name)             . '</td>' . "\n";
                        if ( $ptnarow["ptna_is_invalid"] ) { $checked = '<img src="/img/CheckMark.svg" width=32 height=32 alt="checked" />'; } else { $checked = ''; }
                        echo '                            <td class="gtfs-checkbox">' . $checked . '</td>' . "\n";
                        if ( $ptnarow["ptna_is_wrong"]   ) { $checked = '<img src="/img/CheckMark.svg" width=32 height=32 alt="checked" />'; } else { $checked = ''; }
                        echo '                            <td class="gtfs-checkbox">' . $checked . '</td>' . "\n";
                        echo '                            <td class="gtfs-comment">' . htmlspecialchars($ptnarow["ptna_comment"]) . '</td>' . "\n";
                        echo '                        </tr>' . "\n";
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
    

    function CreateGtfsSingleTripEntry( $network, $trip_id, $edit ) {

        $SqliteDb = FindGtfsSqliteDb( $network );
        
        if ( $SqliteDb != '') {

           if ( $trip_id ) {
                
               try {
                   
                    $start_time = gettimeofday(true);
                    
                    $db = new SQLite3( $SqliteDb );
                    
                    $sql = sprintf( "SELECT   stop_times.stop_id,stops.stop_name,stops.stop_lat,stops.stop_lon,stops.ptna_is_invalid,stops.ptna_is_wrong,stops.ptna_comment 
                                     FROM     stop_times
                                     JOIN     stops ON stop_times.stop_id = stops.stop_id
                                     WHERE    stop_times.trip_id='%s' 
                                     ORDER BY CAST (stop_times.stop_sequence AS INTEGER);",
                                     SQLite3::escapeString($trip_id) 
                                  );
            
                    $result = $db->query( $sql );
                    
                    $counter = 1;
                    while ( $row=$result->fetchArray() ) {
                        echo '                       <tr class="gtfs-tablerow">' . "\n";
                        echo '                           <td class="gtfs-number">'   . $counter++ . '</td>' . "\n";
                        echo '                           <td class="gtfs-name">'     . htmlspecialchars($row["stop_name"])       . '</td>' . "\n";
                        echo '                           <td class="gtfs-lat">'      . htmlspecialchars($row["stop_lat"])        . '</td>' . "\n";
                        echo '                           <td class="gtfs-lon">'      . htmlspecialchars($row["stop_lon"])        . '</td>' . "\n";
                        echo '                           <td class="gtfs-id">'       . htmlspecialchars($row["stop_id"])         . '</td>' . "\n";
                        if ( $row["ptna_is_invalid"] ) { $checked = '<img src="/img/CheckMark.svg" width=32 height=32 alt="checked" />'; } else { $checked = ''; }
                        echo '                           <td class="gtfs-checkbox">' . $checked . '</td>' . "\n";
                        if ( $row["ptna_is_wrong"]   ) { $checked = '<img src="/img/CheckMark.svg" width=32 height=32 alt="checked" />'; } else { $checked = ''; }
                        echo '                           <td class="gtfs-checkbox">' . $checked . '</td>' . "\n";
                        echo '                           <td class="gtfs-comment">' . htmlspecialchars($row["ptna_comment"]) . '</td>' . "\n";
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
    

    function GetPtnaTripDetails( $network, $trip_id ) {

        $SqliteDb = FindGtfsSqliteDb( $network );
        
        if ( $SqliteDb != '' ) {

            if ( $trip_id ) {
                
                try {
    
                    $db  = new SQLite3( $SqliteDb );
                    
                    $sql = sprintf( "SELECT ptna_is_invalid,ptna_is_wrong,ptna_comment 
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
    
?>
