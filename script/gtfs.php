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
                $return_path   = $path_to_work . $countrydir . '/' . $subdir . '/' . $network . '-ptna-gtfs-sqlite.db';
            } else {
                $return_path   = $path_to_work . $countrydir . '/' . $network . '-ptna-gtfs-sqlite.db';
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

            if (  $network ) {
                
                try {
    
                    $start_time = gettimeofday(true);
                    
                    $db = new SQLite3( $SqliteDb );
                    
                    echo "<!-- Sqlite DB erfolgreich geöffnet -->\n";
                            
                    $sql = "SELECT * FROM ptna";
                    
                    $result = $db->query( $sql );
                    
                    $ptna    = $result->fetchArray();
                    
                    $sql = "SELECT * FROM feed_info";
                    
                    $result = $db->query( $sql );
                    
                    $feed    = $result->fetchArray();
                    
                    echo '                    <tr class="results-tablerow">' . "\n";
                    if ( $ptna["duration_hint_routes"] ) {
                        echo '                        <td class="results-name"><a href="routes.php?network=' . urlencode($network) . '" title="' . htmlspecialchars($ptna["duration_hint_routes"]) . '">' . htmlspecialchars($network) . '</a></td>' . "\n";
                    } else {
                        echo '                        <td class="results-name"><a href="routes.php?network=' . urlencode($network) . '">' . htmlspecialchars($network) . '</a></td>' . "\n";
                    }
                    if ( isset($feed["feed_publisher_url"]) ) {
                        echo '                        <td class="results-network"><a target="_blank" href="' . $feed["feed_publisher_url"] . '">' . htmlspecialchars($feed["feed_publisher_name"]) . '</a></td>' . "\n";
                    } else {
                        echo '                        <td class="results-network">' . htmlspecialchars($feed["feed_publisher_name"]) . '</td>' . "\n";
                    }
                    if ( preg_match( "/^(\d{4})(\d{2})(\d{2})$/", $feed["feed_start_date"], $parts ) ) {
                        echo '                        <td class="results-datadate">' . $parts[1] . '-' .  $parts[2] . '-' .  $parts[3] . '</td>' . "\n";
                    } else {
                        echo '                        <td class="results-datadate">' . htmlspecialchars($feed["feed_start_date"]) . '</td>' . "\n";
                    }
                    if ( preg_match( "/^(\d{4})(\d{2})(\d{2})$/", $feed["feed_end_date"], $parts ) ) {
                        echo '                        <td class="results-datadate">' . $parts[1] . '-' .  $parts[2] . '-' .  $parts[3] . '</td>' . "\n";
                    } else {
                        echo '                        <td class="results-datadate">' . htmlspecialchars($feed["feed_end_date"]) . '</td>' . "\n";
                    }
                    echo '                        <td class="results-datadate">' . htmlspecialchars($feed["feed_version"]) . '</td>' . "\n";
                    if ( isset($ptna["release_url"]) ) {
                        echo '                        <td class="results-datadate"><a target="_blank" href="' . $ptna["release_url"] . '">' . htmlspecialchars($ptna["release_date"]) . '</a></td>' . "\n";
                    } else {
                        echo '                        <td class="results-datadate">' . htmlspecialchars($ptna["release_date"]) . '</td>' . "\n";
                    }
                    if ( isset($ptna["original_license_url"]) ) {
                        echo '                        <td class="results-network"><a target="_blank" href="' . $ptna["original_license_url"] . '">' . htmlspecialchars($ptna["original_license"]) . '</a></td>' . "\n";
                    } else {
                        echo '                        <td class="results-network">' . htmlspecialchars($row["original_license"]) . '</td>' . "\n";
                    }
                    if ( isset($ptna["license_url"]) ) {
                        echo '                        <td class="results-network"><a target="_blank" href="' . $ptna["license_url"] . '">' . htmlspecialchars($ptna["license"]) . '</a></td>' . "\n";
                    } else {
                        echo '                        <td class="results-network">' . htmlspecialchars($ptna["license"]) . '</td>' . "\n";
                    }
                    echo '                        <td class="results-datadate">' . htmlspecialchars($ptna["prepared"])   . '</td>' . "\n";
                    echo '                        <td class="results-datadate">' . htmlspecialchars($ptna["aggregated"]) . '</td>' . "\n";
                    echo '                        <td class="results-datadate">' . htmlspecialchars($ptna["normalized"]) .' </td>' . "\n";
                    echo '                    </tr>' . "\n";
                    
                    $db->close();
        
                    $stop_time = gettimeofday(true);
                    
                    return $stop_time - $start_time;
        
                } catch ( Exception $ex ) {
                    echo "Sqlite DB konnte nicht geöffnet werden: " . $ex->getMessage() . "\n";
                }
            }
        } else {
            echo "Sqlite DB konnte für network = '" . $network . "' nicht gefunden werden\n";
        }
        
        return 0;
    }

    function CreateGtfsRoutesEntry( $network ) {

        $SqliteDb = FindGtfsSqliteDb( $network );
        
        if ( $SqliteDb != '' ) {

           if (  $network ) {
                
               try {
                   
                    $today = new DateTime();
                        
                    $start_time = gettimeofday(true);
                    
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
                    
                    $db = new SQLite3( $SqliteDb );
                    
                    echo "<!-- Sqlite DB erfolgreich geöffnet -->\n";
                    
                    $sql = "SELECT duration_hint_trips FROM ptna";
                    
                    $result = $db->query( $sql );
                    
                    $ptna   = $result->fetchArray();
                    
                    $duration_hint_trips = $ptna["duration_hint_trips"];
                    
                    $sql = "SELECT DISTINCT routes.route_short_name,routes.route_long_name,routes.route_id,routes.route_type,agency.agency_name,agency.agency_url,routes.ptna_is_invalid,routes.ptna_is_wrong,routes.ptna_comment FROM routes JOIN agency ON routes.agency_id = agency.agency_id ORDER BY route_short_name;";
    
                    $outerresult = $db->query( $sql );
                    
                    while ( $outerrow=$outerresult->fetchArray() ) {

                        if ( $outerrow["route_type"] && $route_type_to_string[$outerrow["route_type"]] ) {
                            $route_type_text = $route_type_to_string[$outerrow["route_type"]];
                        } else {
                            $route_type_text = $outerrow["route_type"];
                        }
                                
                        $sql = sprintf( "SELECT DISTINCT start_date,end_date FROM trips JOIN calendar ON trips.service_id = calendar.service_id 
                                                WHERE trip_id IN 
                                                      (SELECT trip_id FROM trips
                                                              WHERE route_id='%s') AND
                                                                    %s < end_date
                                                              ORDER BY start_date;", SQLite3::escapeString($outerrow["route_id"]), $today->format('Ymd') );
                                                   
                        $innerresult = $db->query( $sql );
                    
                        while ( $innerrow=$innerresult->fetchArray() ) {
    
                            echo '                    <tr class="results-tablerow">' . "\n";
                            if ( $duration_hint_trips ) {
                                echo '                        <td class="results-name"><a href="trips.php?network=' . urlencode($network) . '&route_id=' . urlencode($outerrow["route_id"]) . '" title="' . htmlspecialchars($duration_hint_trips) . '">' . htmlspecialchars($outerrow["route_short_name"]) . '</a></td>' . "\n";
                            } else {
                                echo '                        <td class="results-name"><a href="trips.php?network=' . urlencode($network) . '&route_id=' . urlencode($outerrow["route_id"]) . '">' . htmlspecialchars($outerrow["route_short_name"]) . '</a></td>' . "\n";
                            }
                            echo '                        <td class="results-name">' . htmlspecialchars($route_type_text) . '</td>' . "\n";
                            echo '                        <td class="results-name">' . htmlspecialchars($outerrow["route_long_name"]) . '</td>' . "\n";
                            if ( preg_match( "/^(\d{4})(\d{2})(\d{2})$/", $innerrow["start_date"], $parts ) ) {
                                echo '                        <td class="results-datadate">' . $parts[1] . '-' .  $parts[2] . '-' .  $parts[3] . '</td>' . "\n";
                            } else {
                                echo '                        <td class="results-datadate">' . htmlspecialchars($innerrow["start_date"]) . '</td>' . "\n";
                            }
                            if ( preg_match( "/^(\d{4})(\d{2})(\d{2})$/", $innerrow["end_date"], $parts ) ) {
                                echo '                        <td class="results-datadate">' . $parts[1] . '-' .  $parts[2] . '-' .  $parts[3] . '</td>' . "\n";
                            } else {
                                echo '                        <td class="results-datadate">' . htmlspecialchars($innerrow["end_date"]) . '</td>' . "\n";
                            }
                            if ( $outerrow["agency_url"] ) {
                                echo '                        <td class="results-name"><a target="_blank" href="' . $outerrow["agency_url"]. '">' . htmlspecialchars($outerrow["agency_name"]) . '</a></td>' . "\n";
                            } else {
                                echo '                        <td class="results-name">' . htmlspecialchars($outerrow["agency_name"]) . '</td>' . "\n";
                            }
                            echo '                        <td class="results-datadate">' . htmlspecialchars($outerrow["ptna_is_invalid"]) . '</td>' . "\n";
                            echo '                        <td class="results-datadate">' . htmlspecialchars($outerrow["ptna_is_wrong"])   . '</td>' . "\n";
                            echo '                        <td class="results-datadate">' . htmlspecialchars($outerrow["ptna_comment"])    . '</td>' . "\n";
                            echo '                    </tr>' . "\n";
                        }
                    }
                    $db->close();
                    
                    $stop_time = gettimeofday(true);
                    
                    return $stop_time - $start_time;
        
                } catch ( Exception $ex ) {
                    echo "Sqlite DB konnte nicht geöffnet werden: " . $ex->getMessage() . "\n";
                }
            }
        } else {
            echo "Sqlite DB konnte für network = '" . $network . "' nicht gefunden werden\n";
        }
        
        return 0;
    }


    function CreateGtfsTripsEntry( $network, $route_id, $route_short_name ) {

        $SqliteDb = FindGtfsSqliteDb( $network );
        
        if ( $SqliteDb != '' ) {

           if (  $network && $route_id && $route_short_name ) {
                
                try {
                   
                    $start_time = gettimeofday(true);
                    
                    $db = new SQLite3( $SqliteDb );
                    
                    echo "<!-- Sqlite DB erfolgreich geöffnet -->\n";
                    
                    $sql = "SELECT duration_hint_single_trip FROM ptna";
                    
                    $result = $db->query( $sql );
                    
                    $ptna   = $result->fetchArray();
                    
                    $duration_hint_single_trip = $ptna["duration_hint_single_trip"];
                    
                    $sql = sprintf( "SELECT trip_id FROM trips WHERE route_id='%s' ORDER BY trip_id;", SQLite3::escapeString($route_id) );
                    
                    set_time_limit( 30 );
                    
                    $outerresult = $db->query( $sql );
                    
                    $trip_array = array ();
                    
                    while ( $outerrow=$outerresult->fetchArray() ) {
    
                        set_time_limit( 30 );
                    
                        $sql = sprintf( "SELECT GROUP_CONCAT(stop_times.stop_id,'|') AS stop_id_list, GROUP_CONCAT(stops.stop_name,'  |') AS stop_name_list FROM stops JOIN stop_times on stop_times.stop_id = stops.stop_id WHERE stop_times.trip_id='%s' ORDER BY CAST (stop_times.stop_sequence AS INTEGER);", SQLite3::escapeString($outerrow["trip_id"]) );
                                                   
                        $innerresult = $db->query( $sql );
                    
                        set_time_limit( 30 );
                    
                        while ( $innerrow=$innerresult->fetchArray() ) {
                            if ( !isset($stoplist[$innerrow["stop_id_list"]]) ) {
                                $stoplist[$innerrow["stop_id_list"]] = $outerrow["trip_id"];
                                $stop_names = $innerrow["stop_name_list"] . '  |' . $outerrow["trip_id"];
                                array_push( $trip_array, $stop_names );
                            }
                        }
                    }
                    
                    sort( $trip_array );
                    foreach ( $trip_array as $stop_names ) {
                        $stop_name_array = explode( '  |', $stop_names );
                        $trip_id         = array_pop($stop_name_array);
                        $first_stop_name = array_shift( $stop_name_array );
                        $last_stop_name  = array_pop(   $stop_name_array );
                        $via_stop_names  = implode( ' => ', $stop_name_array );
                        $sql = sprintf( "SELECT ptna_is_invalid,ptna_is_wrong,ptna_comment FROM trips WHERE trip_id='%s';", SQLite3::escapeString($trip_id) );
                    
                        $ptnarow = $db->querySingle( $sql, true );
                    
                        echo '                    <tr class="results-tablerow">' . "\n";
                        if ( $duration_hint_single_trip ) {
                            echo '                        <td class="results-name"><a href="single-trip.php?network=' . urlencode($network) . '&trip_id=' . urlencode($trip_id) . '" title="' . htmlspecialchars($duration_hint_single_trip) . '">' . htmlspecialchars($route_short_name) . '</a></td>' . "\n";
                        } else {
                            echo '                        <td class="results-name"><a href="single-trip.php?network=' . urlencode($network) . '&trip_id=' . urlencode($trip_id) . '">' . htmlspecialchars($route_short_name) . '</a></td>' . "\n";
                        }
                        echo '                        <td class="results-name">'     . htmlspecialchars($first_stop_name) . '</a></td>' . "\n";
                        echo '                        <td class="results-network">'  . htmlspecialchars($via_stop_names)  . '</a></td>' . "\n";
                        echo '                        <td class="results-name">'     . htmlspecialchars($last_stop_name)  . '</a></td>' . "\n";
                        echo '                        <td class="results-datadate">' . htmlspecialchars($ptnarow["ptna_is_invalid"]) . '</td>' . "\n";
                        echo '                        <td class="results-datadate">' . htmlspecialchars($ptnarow["ptna_is_wrong"])   . '</td>' . "\n";
                        echo '                        <td class="results-network">'  . htmlspecialchars($ptnarow["ptna_comment"])    . '</td>' . "\n";
                        echo '                    </tr>' . "\n";
                    }
                    
                    $db->close();
                    
                    $stop_time = gettimeofday(true);
                    
                    return $stop_time - $start_time;
        
                } catch ( Exception $ex ) {
                    echo "Sqlite DB konnte nicht geöffnet werden: " . $ex->getMessage() . "\n";
                }
            }
        } else {
            echo "Sqlite DB konnte für network = '" . $network . "' nicht gefunden werden\n";
        }
        
        return 0;
    }
    

    function CreateGtfsSingleTripEntry( $network, $trip_id ) {

        $SqliteDb = FindGtfsSqliteDb( $network );
        
        if ( $SqliteDb != '') {

           if (  $network && $trip_id ) {
                
               try {
                   
                    $start_time = gettimeofday(true);
                    
                    $db = new SQLite3( $SqliteDb );
                    
                    echo "<!-- Sqlite DB erfolgreich geöffnet -->\n";
                    
                    $sql = sprintf( "SELECT stop_times.stop_id,stops.stop_name,stops.stop_lat,stops.stop_lon,stops.ptna_is_invalid,stops.ptna_is_wrong,stops.ptna_comment FROM stop_times JOIN stops ON stop_times.stop_id = stops.stop_id WHERE stop_times.trip_id='%s' ORDER BY CAST (stop_times.stop_sequence AS INTEGER);", SQLite3::escapeString($trip_id) );
            
                    $result = $db->query( $sql );
                    
                    $counter = 1;
                    while ( $row=$result->fetchArray() ) {
                        echo '                    <tr class="results-tablerow">' . "\n";
                        echo '                        <td class="results-datadate">' . $counter++ . '</a></td>' . "\n";
                        echo '                        <td class="results-name">'     . htmlspecialchars($row["stop_name"]) . '</a></td>' . "\n";
                        echo '                        <td class="results-name">'     . htmlspecialchars($row["stop_lat"]) . '</a></td>' . "\n";
                        echo '                        <td class="results-name">'     . htmlspecialchars($row["stop_lon"]) . '</a></td>' . "\n";
                        echo '                        <td class="results-name">'     . htmlspecialchars($row["stop_id"]) . '</a></td>' . "\n";
                        echo '                        <td class="results-datadate">' . htmlspecialchars($row["ptna_is_invalid"]) . '</td>' . "\n";
                        echo '                        <td class="results-datadate">' . htmlspecialchars($row["ptna_is_wrong"])   . '</td>' . "\n";
                        echo '                        <td class="results-network">'  . htmlspecialchars($row["ptna_comment"])    . '</td>' . "\n";
                        echo '                    </tr>' . "\n";
                    }
                    
                    $db->close();
                    
                    $stop_time = gettimeofday(true);
                    
                    return $stop_time - $start_time;
        
                } catch ( Exception $ex ) {
                    echo "Sqlite DB konnte nicht geöffnet werden: " . $ex->getMessage() . "\n";
                }
            }
        } else {
            echo "Sqlite DB konnte für network = '" . $network . "' nicht gefunden werden\n";
        }
        
        return 0;
    }
    

    function GetGtfsRouteShortNameFromRouteId( $network, $route_id ) {

        $SqliteDb = FindGtfsSqliteDb( $network );
        
        if ( $SqliteDb != '' ) {

            if ( $network && $route_id ) {
                
                try {
    
                    $db = new SQLite3( $SqliteDb );
                    
                    echo "<!-- Sqlite DB erfolgreich geöffnet -->\n";
                            
                    $sql = sprintf( "SELECT route_short_name FROM routes WHERE route_id='%s';", SQLite3::escapeString($route_id) );

                    $result = $db->query( $sql );
                    
                    $row    = $result->fetchArray();
    
                    return $row["route_short_name"];
                    
                } catch ( Exception $ex ) {
                    echo "Sqlite DB konnte nicht geöffnet werden: " . $ex->getMessage() . "\n";
                }
            }
        } else {
            echo "Sqlite DB konnte für network = '" . $network . "' nicht gefunden werden\n";
        }
        
        return '';
    }
    

    function GetGtfsRouteShortNameFromTripId( $network, $trip_id ) {

        $SqliteDb = FindGtfsSqliteDb( $network );
        
        if ( $SqliteDb != '' ) {

            if ( $network && $trip_id ) {
                
                try {
    
                    $db = new SQLite3( $SqliteDb );
                    
                    echo "<!-- Sqlite DB erfolgreich geöffnet -->\n";
                            
                    $sql = sprintf( "SELECT route_short_name FROM routes JOIN trips ON trips.route_id = routes.route_id WHERE trip_id='%s';", SQLite3::escapeString($trip_id) );

                    $result = $db->query( $sql );
                    
                    $row    = $result->fetchArray();
    
                    return $row["route_short_name"];
                    
                } catch ( Exception $ex ) {
                    echo "Sqlite DB konnte nicht geöffnet werden: " . $ex->getMessage() . "\n";
                }
            }
        } else {
            echo "Sqlite DB konnte für network = '" . $network . "' nicht gefunden werden\n";
        }
        
        return '';
    }
    

    function GetPtnaTripDetails( $network, $trip_id ) {

        $SqliteDb = FindGtfsSqliteDb( $network );
        
        if ( $SqliteDb != '' ) {

            if ( $network && $trip_id ) {
                
                try {
    
                    $db = new SQLite3( $SqliteDb );
                    
                    echo "<!-- Sqlite DB erfolgreich geöffnet -->\n";
                    
                    $sql = sprintf( "SELECT ptna_is_invalid,ptna_is_wrong,ptna_comment FROM trips WHERE trip_id='%s';", SQLite3::escapeString($trip_id) );
                    
                    set_time_limit( 30 );
                    
                    $result = $db->query( $sql );

                    $row    = $result->fetchArray();

                    return $row;
                    
                } catch ( Exception $ex ) {
                    echo "Sqlite DB konnte nicht geöffnet werden: " . $ex->getMessage() . "\n";
                }
            }
        } else {
            echo "Sqlite DB konnte für network = '" . $network . "' nicht gefunden werden\n";
        }
        
        return array();
    }
    

?>
file:///usr/share/applications/bluefish.desktop