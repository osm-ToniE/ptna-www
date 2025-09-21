<?php

    $gtfs_strings['subroute_of']                        = 'Trip is subroute of:';
    $gtfs_strings['suspicious_start']                   = 'Suspicious start of trip: same';
    $gtfs_strings['suspicious_end']                     = 'Suspicious end of trip: same';
    $gtfs_strings['suspicious_number_of_stops']         = 'Suspicious number of stops:';
    $gtfs_strings['suspicious_trip_duration']           = 'Suspicious travel time:';
    $gtfs_strings['suspicious_other']                   = 'Suspicious trip:';
    $gtfs_strings['same_names_but_different_ids']       = 'Trips have same Stop-Names but different Stop-Ids:';
    $gtfs_strings['same_stops_but_different_shape_ids'] = 'Trips have same Stops but different Shape-Ids:';

    if ( $lang ) {
        if ( $lang == 'de' ) {
            $gtfs_strings['subroute_of']                        = 'Fahrt ist Teilroute von:';
            $gtfs_strings['suspicious_start']                   = 'Verdächtiger Anfang der Fahrt: gleiche';
            $gtfs_strings['suspicious_end']                     = 'Verdächtiges Ende der Fahrt: gleiche';
            $gtfs_strings['suspicious_number_of_stops']         = 'Verdächtige Anzahl von Haltestellen:';
            $gtfs_strings['suspicious_trip_duration']           = 'Verdächtige Fahrzeit:';
            $gtfs_strings['suspicious_other']                   = 'Verdächtige Fahrt:';
            $gtfs_strings['same_names_but_different_ids']       = 'Fahrten haben gleiche Haltestellennamen aber unterschiedliche Haltestellennummern:';
            $gtfs_strings['same_stops_but_different_shape_ids'] = 'Fahrten haben gleiche Haltestellen aber unterschiedliche Shape-Ids:';
        } else if ( $lang == 'fr' ) {
            $gtfs_strings['subroute_of']                        = "Le voyage fait partie de l'itinéraire:";
            $gtfs_strings['suspicious_start']                   = 'Début de parcours suspect : même';
            $gtfs_strings['suspicious_end']                     = 'Fin de parcours suspecte : même';
            $gtfs_strings['suspicious_number_of_stops']         = "Nombre d'arrêts suspect:";
            $gtfs_strings['suspicious_trip_duration']           = 'Durée de parcours suspecte:';
            $gtfs_strings['suspicious_other']                   = 'Parcours suspect:';
            $gtfs_strings['same_names_but_different_ids']       = "Les parcours ont les mêmes nom d'arrêt mais des numéros d'arrêt différents:";
            $gtfs_strings['same_stops_but_different_shape_ids'] = "Les parcours ont les mêmes arrêts mais des Shape-Ids différents:";
        }
    }

    $route_type_to_string    = array();
    $route_type_to_sort_key  = array();
    $route_type_to_osm_route = array();
    $osm_route_to_string     = array();
    #
    # https://developers.google.com/transit/gtfs/reference/extended-route-types
    #
    #                      Code 	Description 	                  Support 	   Examples
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
    $route_type_to_string["200"] = 'Coach Service';
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
    $route_type_to_string["1002"] = 'National Car Ferry Service';             # ENTUR Norway
    $route_type_to_string["1004"] = 'Local Car Ferry Service';                # ENTUR Norway
    $route_type_to_string["1008"] = 'Local Passenger Ferry Service';          # ENTUR Norway
    $route_type_to_string["1013"] = 'Car High-Speed Ferry Service';           # ENTUR Norway
    $route_type_to_string["1014"] = 'Passenger High-Speed Ferry Service';     # ENTUR Norway
    $route_type_to_string["1015"] = 'Sightseeing Boat Service';               # ENTUR Norway
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
    $route_type_to_string["9999"] = 'Light Rail (OSM)';


    function FindGtfsSqliteDb( $feed, $release_date ) {
        global $path_to_work;
        global $route_type_to_string;
        global $route_type_to_sort_key;
        global $route_type_to_osm_route;
        global $osm_route_to_string;

        $return_path = '';

        if ( $release_date ) {
            $feed_release = $feed . '-' . $release_date;
        } else {
            $feed_release = $feed;
        }
        if ( $feed_release && preg_match("/^[0-9A-Za-z_.-]+$/", $feed_release) ) {
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

            if ( count($route_type_to_osm_route) == 0 ) {
                try {

                    $db         = new SQLite3( $return_path );

                    $sql        = "SELECT name FROM sqlite_master WHERE type='table' AND name='gtfs_route_types';";

                    $sql_master = $db->querySingle( $sql, true );

                    if ( isset($sql_master['name']) ) {
                        $route_type_to_string    = array();
                        $route_type_to_sort_key  = array();
                        $route_type_to_osm_route = array();
                        $osm_route_to_string     = array();

                        $sql = sprintf( "SELECT * FROM gtfs_route_types;" );

                        $gtfs_route_types = $db->query( $sql );

                        while ( $row=$gtfs_route_types->fetchArray(SQLITE3_ASSOC) ) {
                            $route_type_to_string[$row["route_type"]]    = $row["string"];
                            $route_type_to_sort_key[$row["route_type"]]  = $row["sort_key"];
                            $route_type_to_osm_route[$row["route_type"]] = $row["osm_route"];
                            #echo "<!-- route_type_to_string[" . $row["route_type"] . "]    = " . $row["string"] . "    -->\n";
                            #echo "<!-- route_type_to_sort_key[" . $row["route_type"] . "]  = " . $row["sort_key"] . "  -->\n";
                            #echo "<!-- route_type_to_osm_route[" . $row["route_type"] . "] = " . $row["osm_route"] . " -->\n";
                        }

                        $sql = sprintf( "SELECT * FROM osm_routes;" );

                        $osm_routes = $db->query( $sql );

                        while ( $row=$osm_routes->fetchArray(SQLITE3_ASSOC) ) {
                            $osm_route_to_string["en"][$row["osm_route"]] = $row["string"];
                            $osm_route_to_string["de"][$row["osm_route"]] = $row["string_de"];
                            #echo "<!-- osm_route_to_string[en][" . $row["osm_route"] . "] = " . $row["string"] . "    -->\n";
                            #echo "<!-- osm_route_to_string[de][" . $row["osm_route"] . "] = " . $row["string_de"] . " -->\n";
                        }
                    }
                } catch ( Exception $ex ) {
                    echo "<!-- FindGtfsSqliteDb( " . $feed . ", " . $release_date . " ) error opening data base -->\n";
                }
            }
            return $return_path;
        } else {
            return '';
        }
    }


    function CreateGtfsVersionsTableBody( $feed ) {

        $release_dates  = array();          # i.e. all months are relevant

        if ( $feed && preg_match("/^[0-9A-Za-z_.-]+$/", $feed) ) {
            $release_dates = GetGtfsFeedReleaseDatesNonEmpty( $feed );

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

        if ( $feed && preg_match("/^[0-9A-Za-z_.-]+$/", $feed) ) {
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

        if ( $feed && preg_match("/^[0-9A-Za-z_.-]+$/", $feed) ) {
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

        if ( $feed && preg_match("/^[0-9A-Za-z_.-]+$/", $feed) ) {
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

        if ( $feed && preg_match("/^[0-9A-Za-z_.-]+$/",$feed) ) {
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

        if ( $feed          && preg_match("/^[0-9A-Za-z_.-]+$/",$feed)              &&
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

        # here are fall-back values
        $last_year   = date( "Y" );
        $last_month  = date( "n" );
        $start_year  = intdiv( ($last_year * 12 + $last_month) - $gtfs_show_number_of_months, 12 );
        $start_month = (($last_year * 12 + $last_month) - $gtfs_show_number_of_months) % 12 + 1;
        $date_rows   = 1;

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
                    if ( isset($lt['release_date']) && $lt['release_date'] ) {
                        if ( isset($lt['language']) && $lt['language'] == 'de' ) {
                            $long_term_img_title = 'Langzeit-Version von ' . $lt['release_date'];
                        } else {
                            $long_term_img_title = 'long term version as of ' . $lt['release_date'];
                        }
                    } else {
                        if ( isset($ptna['language']) && $ptna['language'] == 'de' ) {
                            $long_term_img_title = 'Langzeit-Version';
                        } else {
                            $long_term_img_title = 'long term version';
                        }
                    }
                }
                $PreviousSqliteDb = FindGtfsSqliteDb( $feed, 'previous' );
                if ( $PreviousSqliteDb ) {
                    $prev = GetPtnaDetails( $feed, 'previous' );
                    if ( isset($prev['release_date']) && $prev['release_date'] ) {
                        if ( isset($ptna['language']) && $ptna['language'] == 'de' ) {
                            $previous_img_title = 'vorherige Version von ' . $prev['release_date'];
                            $compare_img_title  = 'vergleiche Versionen';
                        } else {
                            $previous_img_title = 'previous version as of ' . $prev['release_date'];
                            $compare_img_title  = 'compare versions';
                        }
                    } else {
                        if ( isset($ptna['language']) && $ptna['language'] == 'de' ) {
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
                if ( isset($ptna["network_name"]) && $ptna["network_name"] ) {
                    if ( isset($ptna["network_name_url"]) && $ptna["network_name_url"] ) {
                        echo '                            <td class="gtfs-text"><a target="_blank" href="' . $ptna["network_name_url"] . '">' . htmlspecialchars($ptna["network_name"]) . '</a></td>' . "\n";
                    } else {
                        echo '                            <td class="gtfs-text">' . htmlspecialchars($ptna["network_name"]) . '</td>' . "\n";
                    }
                } else {
                    echo '                            <td class="gtfs-text">&nbsp;</td>' . "\n";
                }
                if ( isset($feed_info["feed_publisher_name"]) && $feed_info["feed_publisher_name"] ) {
                    if ( isset($feed_info["feed_publisher_url"]) && $feed_info["feed_publisher_url"] ) {
                        echo '                            <td class="gtfs-text"><a target="_blank" href="' . $feed_info["feed_publisher_url"] . '" title="From GTFS">' . htmlspecialchars($feed_info["feed_publisher_name"]) . '</a></td>' . "\n";
                    } else {
                        echo '                            <td class="gtfs-text">' . htmlspecialchars($feed_info["feed_publisher_name"]) . '</td>' . "\n";
                    }
                } else {
                    if ( isset($ptna["feed_publisher_url"]) && $ptna["feed_publisher_url"] ) {
                        echo '                            <td class="gtfs-text"><a target="_blank" href="' . $ptna["feed_publisher_url"] . '" title="From PTNA">' . htmlspecialchars($ptna["feed_publisher_name"]) . '</a></td>' . "\n";
                    } else {
                        echo '                            <td class="gtfs-text">' . htmlspecialchars($ptna["feed_publisher_name"]) . '</td>' . "\n";
                    }
                }
                if ( isset($feed_info["feed_start_date"]) && $feed_info["feed_start_date"] ) {
                    if ( preg_match( "/^(\d{4})(\d{2})(\d{2})$/", $feed_info["feed_start_date"], $parts ) ) {
                        echo '                            <td class="gtfs-date">' . $parts[1] . '-' .  $parts[2] . '-' .  $parts[3] . '</td>' . "\n";
                    } else {
                        echo '                            <td class="gtfs-date">' . htmlspecialchars($feed_info["feed_start_date"]) . '</td>' . "\n";
                    }
                } else {
                    echo '                            <td class="gtfs-date">&nbsp;</td>' . "\n";
                }
                if ( isset($feed_info["feed_end_date"]) && $feed_info["feed_end_date"] ) {
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
                if ( isset($feed_info["feed_version"]) && $feed_info["feed_version"] ) {
                    echo '                            <td class="gtfs-number">' . htmlspecialchars($feed_info["feed_version"]) . '</td>' . "\n";
                } else {
                    echo '                            <td class="gtfs-number">&nbsp;</td>' . "\n";
                }
                if ( isset($ptna["release_date"]) && $ptna["release_date"] ) {
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
                    if ( isset($ptna["release_url"]) && $ptna["release_url"] ) {
                        echo '                            <td class="' . $tdclass . '"><a target="_blank" href="' . $ptna["release_url"] . '"><span ' . $txclasstag . '>' . htmlspecialchars($ptna["release_date"]) . '</span></a></td>' . "\n";
                    } else {
                        echo '                            <td class="' . $tdclass . '"><span ' . $txclasstag . '>' . htmlspecialchars($ptna["release_date"]) . '</span></td>' . "\n";
                    }
                } else {
                    echo '                            <td class="gtfs-date">&nbsp;</td>' . "\n";
                }
                if ( isset($ptna["prepared"]) && $ptna["prepared"] ) {
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
            echo '                            <td class="gtfs-name">' . htmlspecialchars($feed) . '</td>' . "\n";
            echo '                            <td class="gtfs-comment" colspan=8>SQLite DB: data base not found (data not yet available?)</td>' . "\n";
            echo '                        </tr>' . "\n";
        }

        return 0;
    }

    function CreateGtfsRoutesEntry( $feed, $release_date ) {

        ob_implicit_flush(true);

        $SqliteDb = FindGtfsSqliteDb( $feed, $release_date );

        if ( $SqliteDb != '' ) {

            if ( $feed ) {

                try {

                    $today      = new DateTime();

                    set_time_limit( 30 );

                    $start_time = gettimeofday(true);

                    $db         = new SQLite3( $SqliteDb );

                    $sql        = "SELECT * FROM ptna";

                    $ptna       = $db->querySingle( $sql, true );

                    $sql        = "SELECT name FROM sqlite_master WHERE type='table' AND name='ptna_routes';";

                    $sql_master = $db->querySingle( $sql, true );

                    if ( isset($sql_master['name']) ) {
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
                        $help = preg_replace( '/ /', '', $outerrow['route_short_name'] );
                        if ( preg_match('/^([0-9]+)(.*)$/',$help,$parts) ) {
                            $rsn = sprintf("%20s%s ",$parts[1],$parts[2]);
                        } elseif ( preg_match('/^([^0-9][^0-9]*)([0-9][0-9]*)(.*)$/',$help,$parts) ) {
                            $rsn = sprintf("%s%20s%s ",$parts[1],$parts[2],$parts[3]);
                        } else {
                            $rsn = sprintf("%s%20s ",$help,' ');
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

                        if ( isset($outerrow["route_type"]) ) {
                            $route_type_text = RouteType2String( $outerrow["route_type"] );
                            $osm_route_type  = RouteType2OsmRoute( $outerrow["route_type"] );
                        } else {
                            $route_type_text = '???';
                            $osm_route_type  = '???';
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
                                $start_end_array = GetStartEndDateAndRidesOfIdenticalTrips( $db, $innerrow["trip_id"], False );
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

                        $route_short_name = '???';
                        if ( isset($outerrow["route_short_name"]) && $outerrow["route_short_name"] != '' ) {
                            $route_short_name = $outerrow["route_short_name"];
                        }

                        $id_string = preg_replace( '/[^0-9A-Za-z_.-]/', '_', $osm_route_type . '_' . $route_short_name );
                        if ( isset($id_markers[$id_string]) ) {                                        # if the same combination appears more than once, add a number as suffix (e.g. "Bus A" of VMS in Saxony, Germany
                            $id_markers[$id_string]++;
                            $id_string .= '-' . $id_markers[$id_string];
                        } else {
                            $id_markers[$id_string] = 1;
                        }

                        echo '                        <tr id="' . $id_string . '" class="gtfs-tablerow' . $alternative_or_not . '">' . "\n";
                        echo '                            <td class="gtfs-name"><a href="trips.php?feed=' . urlencode($feed) . '&release_date=' . urlencode($release_date) . '&route_id=' . urlencode($outerrow["route_id"]) . '"><span class="route_short_name">' . htmlspecialchars($route_short_name) . '</span><span class="route_id" style="display: none;">' . htmlspecialchars($outerrow["route_id"]) . '</span></a></td>' . "\n";
                        echo '                            <td class="gtfs-text"><span class="route_type">' . htmlspecialchars($route_type_text) . '</span></td>' . "\n";
                        echo '                            <td class="gtfs-text"><span class="route_type">' . htmlspecialchars($osm_route_type) . '</span></td>' . "\n";
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

                        if ( isset($sql_master['name']) ) {
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

           if (  $route_id != '' ) {

                try {
                    $list_separator = '|';

                    set_time_limit( 30 );

                    $start_time = gettimeofday(true);

                    $db         = new SQLite3( $SqliteDb );

                    $sql        = "SELECT * FROM ptna";

                    $ptna       = $db->querySingle( $sql, true );

                    if ( isset($ptna['list_separator']) && $ptna['list_separator'] ) {
                        $list_separator = $ptna['list_separator'];
                    }

                    $sql        = sprintf( "SELECT   *
                                            FROM     trips
                                            WHERE    route_id='%s'
                                            ORDER BY trip_id;",
                                            SQLite3::escapeString($route_id)
                                         );

                    $outerresult = $db->query( $sql );

                    $trip_array = array ();

                    while ( $outerrow=$outerresult->fetchArray(SQLITE3_ASSOC) ) {
                        $trip_id = $outerrow["trip_id"];
                        $shape_id = isset($outerrow["shape_id"]) ? $outerrow["shape_id"] : '-';

                        # an 'ORDER BY CAST(stop_sequence as INTEGER) ASC' is not safe, does not sort by stop_sequence as expected.
                        # GTFS refences says anyway that they must be sorted asc
                        # see gtfs-aggregate-ptna-sqlite.pl - FillNewStopTimesTable, where we ensure that stop_times entries are sorted ascending
                        # even if the original GTFS data is wrongly sorted (desc or not at all)
                        $sql = sprintf( "SELECT   GROUP_CONCAT(stop_times.stop_id,'%s') AS stop_id_list, GROUP_CONCAT(stops.stop_name,'  %s') AS stop_name_list
                                         FROM     stops
                                         JOIN     stop_times on stop_times.stop_id = stops.stop_id
                                         WHERE    stop_times.trip_id='%s';",
                                         $list_separator,
                                         $list_separator,
                                         SQLite3::escapeString($trip_id)
                                      );

                        $innerrow = $db->querySingle( $sql, true );
                        # print "<!-- trip_id = " . $trip_id . " shape_id = . " . $shape_id . " stop_id_list = . " . $innerrow["stop_id_list"] . " -->\n";
                        if ( $innerrow["stop_id_list"] && !isset($stoplist[$innerrow["stop_id_list"].$list_separator.$shape_id]) ) {
                            $stoplist[$innerrow["stop_id_list"].$list_separator.$shape_id] = $outerrow["trip_id"];
                            # the next 4 lines are used to sort the output 'trip_array' by frist, by last and then by via stop names
                            $stop_name_array = explode( '  '.$list_separator, $innerrow["stop_name_list"] );
                            $first_stop_name = array_shift( $stop_name_array );
                            $last_stop_name  = array_pop(   $stop_name_array );
                            $stop_names      = $first_stop_name . '  ' . $list_separator . $last_stop_name . '  ' . $list_separator . implode('  '.$list_separator,$stop_name_array) . '  ' . $list_separator . $outerrow["trip_id"];
                            array_push( $trip_array, $stop_names );
                        }
                    }

                    sort( $trip_array );

                    $index = 1;

                    $sql = "SELECT name FROM sqlite_master WHERE type='table' AND name='ptna_trips_comments';";
                    $sql_master = $db->querySingle( $sql, true );
                    if ( isset($sql_master['name']) ) {
                        $join_statement = 'LEFT OUTER JOIN ptna_trips_comments ON trips.trip_id = ptna_trips_comments.trip_id';
                    } else {
                        $join_statement = '';
                    }

                    foreach ( $trip_array as $stop_names ) {

                        $stop_name_array = explode( '  '.$list_separator, $stop_names );
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

                        $start_end_rides_array = GetStartEndDateAndRidesOfIdenticalTrips( $db, $trip_id, True );

                        echo '                        <tr class="gtfs-tablerow">' . "\n";
                        echo '                            <td class="gtfs-number">' . $index . '</td>' . "\n";
                        echo '                            <td class="gtfs-name"><a href="single-trip.php?feed=' . urlencode($feed) . '&release_date=' . urlencode($release_date) . '&trip_id=' . urlencode($trip_id) . '">' . htmlspecialchars($trip_id) . '</a></td>' . "\n";
                        if ( $start_end_rides_array["sum_rides"] > $start_end_rides_array["rides"] ) {
                            echo '                            <td class="gtfs-number">' . htmlspecialchars($start_end_rides_array["rides"]) . ' (' . htmlspecialchars($start_end_rides_array["sum_rides"]) . ')</td>' . "\n";
                        } else {
                            echo '                            <td class="gtfs-number">' . htmlspecialchars($start_end_rides_array["rides"]) . '</td>' . "\n";
                        }
                        if ( preg_match( "/^(\d{4})(\d{2})(\d{2})$/", $start_end_rides_array["start_date"], $parts ) ) {
                            $class = "gtfs-date";
                            $today = new DateTime();
                            if ( $start_end_rides_array["start_date"] > $today->format('Ymd') )
                            {
                                $class = "gtfs-datenew";
                            }
                            echo '                            <td class="' . $class . '">' . $parts[1] . '-' .  $parts[2] . '-' .  $parts[3] . '</td>' . "\n";
                        } else {
                            echo '                            <td class="gtfs-date">' . htmlspecialchars($start_end_rides_array["start_date"]) . '</td>' . "\n";
                        }
                        if ( preg_match( "/^(\d{4})(\d{2})(\d{2})$/", $start_end_rides_array["end_date"], $parts ) ) {
                            $class = "gtfs-date";
                            $today = new DateTime();
                            if ( $start_end_rides_array["end_date"] < $today->format('Ymd') )
                            {
                                $class = "gtfs-dateold";
                            }
                            echo '                            <td class="' . $class . '">' . $parts[1] . '-' .  $parts[2] . '-' .  $parts[3] . '</td>' . "\n";
                        } else {
                            echo '                            <td class="gtfs-date">' . htmlspecialchars($start_end_rides_array["end_date"]) . '</td>' . "\n";
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


    function CreateLinksToPtnaDataEntry( $feed, $release_date, $route_id, $route_short_name, $osm_ref, $osm_route_type, $ptna_analysis_source ) {

        global $path_to_www;

        $start_time = gettimeofday(true);

        #echo "<!-- CreateLinksToPtnaData( feed = "                 . htmlspecialchars($feed)
        #                             . ", release_date = "         . htmlspecialchars($release_date)
        #                             . ", route_id = "             . htmlspecialchars($route_id)
        #                             . ", route_short_name = "     . htmlspecialchars($route_short_name)
        #                             . ", osm_ref = "              . htmlspecialchars($osm_ref)
        #                             . ", osm_route_type = "       . htmlspecialchars($osm_route_type)
        #                             . ", ptna_analysis_source = " . htmlspecialchars($ptna_analysis_source) . " ); -->\n";
        $matches      = 0;
        $good_matches = 0;

        if ( $feed                   && preg_match("/^[0-9A-Za-z_.-]+$/",          $feed)                     &&
             ($release_date == ''    || preg_match("/^[0-9-]+$/",                  $release_date) )           &&
             $route_id != ''         && preg_match("/^[a-zA-Z0-9_. :\|\+-]+$/",    $route_id)                 &&
             $route_short_name != '' && preg_match("/^[a-zA-Z0-9_. \(\)\/-]+$/",   $route_short_name)         &&
             $osm_ref                && preg_match("/^[a-zA-Z0-9_. \(\)\/-]+$/",   $osm_ref)                  &&
             $osm_route_type         && preg_match("/^[0-9A-Za-z_.-]+$/",          $osm_route_type)           &&
             $ptna_analysis_source   && preg_match("/^[0-9A-Za-z_.-]+$/",          $ptna_analysis_source)        ) {

            $prefixparts = explode( '-', $ptna_analysis_source );
            $countrydir  = array_shift( $prefixparts );
            if ( count($prefixparts) > 1 ) {
                $subdir = array_shift( $prefixparts );
                $analysis_filename = $subdir . '/' . $ptna_analysis_source . '-Analysis.html';
                $analysis_webpath  = "/results/" . $countrydir . '/' . $analysis_filename;
            } else {
                $analysis_filename = $ptna_analysis_source . '-Analysis.html';
                $analysis_webpath  = "/results/" . $countrydir . '/' . $analysis_filename;
            }

            $analysis_filepath = $path_to_www . preg_replace("/^\//",'',$analysis_webpath);

            # allow each character of osm_ref be followed by zero or more ' '
            # do not consider any blanks in osm_ref and the route_short_name (osm_ref is derived from route_short_name)
            $match_osm_ref = preg_replace('/\s*/','',$osm_ref);
            $match_osm_ref = preg_replace('/(.)/','${1}\\s*',$match_osm_ref);

            $shell_command = "egrep 'id=" . '"' . "[^0-9].*data-ref=" . '"' . $match_osm_ref . '"' . "' " . $analysis_filepath . " 2>&1";
            #echo "<!-- ". htmlspecialchars($shell_command) . " -->\n";
            $matching_ptna_lines = shell_exec( $shell_command );
            #echo "<!-- ". htmlspecialchars($matching_ptna_lines) . " -->\n";
            $matching_ptna_array = explode( "\n", $matching_ptna_lines );
            foreach ( $matching_ptna_array as $match ) {
                if ( preg_match("/data-ref/",$match) ) {
                    $matches += 1;
                    $id        = preg_replace('/".*$/','',
                                    preg_replace('/^.*id="/','',$match)
                                 );
                    $data_ref  = preg_replace('/".*$/','',
                                    preg_replace('/^.*data-ref="/','',$match)
                                 );
                    $data_info = preg_replace('/_>/','',
                                    preg_replace('/<[^>]*>/','',
                                        preg_replace('/;; /','; ',
                                            preg_replace('/,*\s*GTFS-Feed: /','; ',
                                                preg_replace('/, GTFS-Release-Date: /',';',
                                                    preg_replace('/, GTFS-Route-Id: /',';',
                                                        preg_replace('/GTFS<\/a>/','',
                                                            preg_replace('/<a[^>]*title=_/','',
                                                                preg_replace('/".*$/','',
                                                                    preg_replace('/^.*data-info="/','',$match)
                                                                )
                                                            )
                                                        )
                                                    )
                                                )
                                            )
                                        )
                                    )
                                );
                    if ( preg_match("/^share_taxi/",$id) ){
                        $osm_route  = 'share_taxi';
                    } else if ( preg_match("/^light_rail/",$id) ){
                        $osm_route  = 'light_rail';
                    } else {
                        $osm_route  = preg_replace('/_.*$/','',$id);
                    }
                    $escaped_route_id = preg_replace('/\./','\\.',
                                            preg_replace('/\+/','\\+',
                                                preg_replace('/\|/','\\|',$route_id)
                                            )
                                        );
                    if ( preg_match("/$escaped_route_id/",$match) ) {
                        $good_id_match     = ' style="background-color: lightgreen;"';
                        $good_id_indicator = '* ';
                        $good_matches     += 1;
                    } else {
                        $good_id_match     = '';
                        $good_id_indicator = '';
                    }
                    if ( $osm_route == $osm_route_type ) {
                        $good_route_match     = ' style="background-color: lightgreen;"';
                    } else {
                        $good_route_match     = '';
                    }
                    echo '                            <tr id="' . $id . '" class="gtfs-tablerow">' . "\n";
                    echo '                                <td class="gtfs-number"' . $good_id_match    . '>' . $good_id_indicator    . '<a href="' . $analysis_webpath . '#' . $id . '">' . htmlspecialchars($data_ref) . '</a></td>' . "\n";
                    echo '                                <td class="gtfs-name"'   . $good_route_match . '>' . htmlspecialchars($osm_route) . '</td>' . "\n";
                    echo '                                <td class="gtfs-name">'                      .  '<a href="' . $analysis_webpath             . '">' . htmlspecialchars($ptna_analysis_source) . '</td>' . "\n";
                    echo '                                <td class="gtfs-name">'                                     . htmlspecialchars($data_info) . '</td>' . "\n";
                    echo '                            </tr>' . "\n";
                } elseif ( $match ) {
                    echo "<!-- ". htmlspecialchars($match) . " -->\n";
                }
            }
        } else {
            echo '                            <tr class="gtfs-tablerow">' . "\n";
            echo '                                <td class="gtfs-name">Error</td>' . "\n";
            echo '                                <td class="gtfs-name">&nbsp;</td>' . "\n";
            echo '                                <td class="gtfs-name">'                         . htmlspecialchars($ptna_analysis_source) . '</td>' . "\n";
            echo '                                <td class="gtfs-name"> feed = '                 . htmlspecialchars($feed)
                                                                    . ", release_date = "         . htmlspecialchars($release_date)
                                                                    . ", route_id = "             . htmlspecialchars($route_id)
                                                                    . ", route_short_name = "     . htmlspecialchars($route_short_name)
                                                                    . ", osm_ref = "              . htmlspecialchars($osm_ref)
                                                                    . ", osm_route_type = "       . htmlspecialchars($osm_route_type) . '</td>' . "\n";
            echo '                            </tr>' . "\n";
        }

        $stop_time = gettimeofday(true);

        $ret['duration']     = $stop_time - $start_time;
        $ret['matches']      = $matches;
        $ret['good_matches'] = $good_matches;

        return $ret;
    }


    function CreateOsmTaggingSuggestion( $feed, $release_date, $trip_id ) {

        $SqliteDb = FindGtfsSqliteDb( $feed, $release_date );

        if ( $SqliteDb != '') {

           if ( $trip_id ) {

               try {
                    $list_separator = '|';

                    set_time_limit( 30 );

                    $start_time = gettimeofday(true);

                    $db = new SQLite3( $SqliteDb );

                    $sql        = "SELECT name FROM sqlite_master WHERE type='table' AND name='osm';";

                    $sql_master = $db->querySingle( $sql, true );

                    if ( isset($sql_master['name']) ) {
                        $sql        = "SELECT * FROM osm";

                        $osm       = $db->querySingle( $sql, true );
                    }

                    $sql  = "SELECT * FROM ptna";

                    $ptna = $db->querySingle( $sql, true );

                    $ptna['language'] = isset($ptna['language']) ? $ptna['language'] : '';

                    if ( isset($ptna['list_separator']) && $ptna['list_separator'] ) {
                        $list_separator = $ptna['list_separator'];
                    }

                    $sql        = "SELECT name FROM sqlite_master WHERE type='table' AND name='ptna_stops';";

                    $sql_master = $db->querySingle( $sql, true );

                    if ( isset($sql_master['name']) ) {
                        $join_ptna_stops = 'LEFT OUTER JOIN ptna_stops ON stops.stop_id = ptna_stops.stop_id';
                    } else {
                        $join_ptna_stops = '';
                    }

                    $sql        = sprintf( "SELECT trip_id
                                            FROM   ptna_trips
                                            WHERE  trip_id='%s' OR list_trip_ids LIKE '%s%s%%' OR list_trip_ids LIKE '%%%s%s%s%%' OR list_trip_ids LIKE '%%%s%s'",
                                            SQLite3::escapeString($trip_id), $list_separator, SQLite3::escapeString($trip_id), $list_separator, SQLite3::escapeString($trip_id), $list_separator, SQLite3::escapeString($trip_id), $list_separator );

                    $trip       = $db->querySingle( $sql, true );

                    $rep_trip_id    = isset($trip['trip_id']) ? $trip['trip_id'] : '';

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
                        $osm_ref            = $routes['route_short_name'] != '' ? htmlspecialchars($routes['route_short_name']) : '????';
                        if ( isset($osm['gtfs_short_name_hack1'])               &&
                             $osm['gtfs_short_name_hack1']                      &&
                             $routes['route_long_name']                         &&
                             $routes['route_id'] != ''                          &&
                             $routes['route_long_name'] != $routes['route_id']      ) {
                             $osm_ref = htmlspecialchars( $routes['route_long_name'] );
                        }
                        if ( preg_match("/$osm_vehicle$/",$osm_ref) ) {
                            $osm_ref = preg_replace( "/\s+$osm_vehicle$/", "", $osm_ref );
                        }
                        $osm_colour         = isset($routes['route_color'])          ? htmlspecialchars($routes['route_color'])          : 'ffffff';
                        $osm_text_colour    = isset($routes['route_text_color'])     ? htmlspecialchars($routes['route_text_color'])     : '000000';
                        if ( isset($stops1['stop_name'] ) ) {
                            $osm_from = (isset($stops1['normalized_stop_name']) && $stops1['normalized_stop_name'] != '')
                                           ? '<span class="normalized-name" title="GTFS: stop_name=\'' . htmlspecialchars($stops1["stop_name"]) . '\'">' . htmlspecialchars($stops1['normalized_stop_name']) . '</span>'
                                           : htmlspecialchars($stops1['stop_name']);
                        } else {
                            $osm_from = '';
                        }
                        if ( isset($stops2['stop_name'] ) ) {
                            $osm_to   = (isset($stops2['normalized_stop_name']) && $stops2['normalized_stop_name'] != '')
                                           ? '<span class="normalized-name" title="GTFS: stop_name=\'' . htmlspecialchars($stops2["stop_name"]) . '\'">' . htmlspecialchars($stops2['normalized_stop_name']) . '</span>'
                                           : htmlspecialchars($stops2['stop_name']);
                        } else {
                            $osm_to = '';
                        }
                        $osm_route_master_name    = $osm_vehicle . ' ' . $osm_ref;
                        if ( isset($osm['route_master_name_suggestion']) ) {
                            if ( $osm['route_master_name_suggestion'] ) {
                                $name_suggestion = $osm['route_master_name_suggestion'];
                                if ( $name_suggestion != 'PTv2' ) {
                                    $matches = [];
                                    if ( preg_match_all('/\{[^}]+\}/',$name_suggestion,$matches) ) {
                                        foreach ( $matches[0] as $match ) {
                                            echo "<!-- " . $match . " -->\n";
                                            $key = preg_replace('/[{}]/','',$match);
                                            if ( $key == 'osm_vehicle' ) {
                                                $new_value = $osm_vehicle;
                                            } elseif ( isset($routes[$key]) ) {
                                                $new_value = $routes[$key];
                                            } elseif ( isset($trips[$key]) ) {
                                                $new_value = $trips[$key];
                                            } else {
                                                $new_value = '[' . $key . ']';
                                            }
                                            $name_suggestion = preg_replace('/\{[^}]+\}/',$new_value,$name_suggestion,1 );
                                        }
                                    }
                                    $osm_route_master_name = htmlspecialchars($name_suggestion);
                                }
                            } else {
                                $osm_route_master_name = '';
                            }
                        }
                        $osm_route_name = $osm_vehicle . ' ' . $osm_ref . ': ' . $osm_from . ' => ' . $osm_to;
                        if ( isset($osm['route_name_suggestion']) ) {
                            if ( $osm['route_name_suggestion'] ) {
                                $name_suggestion = $osm['route_name_suggestion'];
                                if ( $name_suggestion != 'PTv2' ) {
                                    $matches = [];
                                    if ( preg_match_all('/\{[^}]+\}/',$name_suggestion,$matches) ) {
                                        foreach ( $matches[0] as $match ) {
                                            $key = preg_replace('/[{}]/','',$match);
                                            if ( $key == 'osm_vehicle' ) {
                                                $new_value = $osm_vehicle;
                                            } elseif ( isset($routes[$key]) ) {
                                                $new_value = $routes[$key];
                                            } elseif ( isset($trips[$key]) ) {
                                                $new_value = $trips[$key];
                                            } else {
                                                $new_value = '[' . $key . ']';
                                            }
                                            $name_suggestion = preg_replace('/\{[^}]+\}/',$new_value,$name_suggestion,1 );
                                        }
                                    }
                                    $osm_route_name = htmlspecialchars($name_suggestion);
                                }
                            } else {
                                $osm_route_name = '';
                            }
                        }
                        if ( preg_match('/[{}]/',$osm['network']) ) {
                            $matches = [];
                            $name_suggestion = $osm['network'];
                            if ( preg_match_all('/\{[^}]+\}/',$name_suggestion,$matches) ) {
                                foreach ( $matches[0] as $match ) {
                                    $key = preg_replace('/[{}]/','',$match);
                                    if ( isset($agency[$key]) ) {
                                        if ( preg_match('/\/ \(\.\*\)\/\//',$name_suggestion) ) {
                                            $short_agency    = preg_replace( '/ \(.*\)/','', $agency[$key] );
                                            $name_suggestion = preg_replace( '/\{[^}]+\}\/ \(\.\*\)\/\//', $short_agency, $name_suggestion, 1 );
                                        } else {
                                            $name_suggestion = preg_replace( '/\{[^}]+\}/', $agency[$key], $name_suggestion, 1 );
                                        }
                                    } elseif ( isset($routes[$key]) ) {
                                        $name_suggestion = preg_replace( '/\{[^}]+\}/', $routes[$key], $name_suggestion, 1 );
                                    } elseif ( isset($trips[$key]) ) {
                                        $name_suggestion = preg_replace( '/\{[^}]+\}/', $trips[$key], $name_suggestion, 1 );
                                    } else {
                                        $name_suggestion = preg_replace( '/\{[^}]+\}/','['.$key.']', $name_suggestion, 1 );
                                    }
                                }
                            }
                            $osm_network = htmlspecialchars($name_suggestion);
                        } else {
                            $osm_network = htmlspecialchars($osm['network']);
                        }
                        $osm_network_short  = htmlspecialchars($osm['network_short']);
                        $osm_network_guid   = htmlspecialchars($osm['network_guid']);
                        $osm_operator       = '';
                        $osm_website        = '';
                        if ( isset($osm['gtfs_agency_is_operator']) && $osm['gtfs_agency_is_operator'] ) {
                            if ( isset($agency['agency_name']) && $agency['agency_name'] != 'Sonstige' ) {
                                $osm_operator   = isset($agency['agency_name']) ? htmlspecialchars($agency['agency_name']) : '';
                                $osm_website    = isset($routes['route_url'])   ? htmlspecialchars($routes['route_url'])   : htmlspecialchars($agency['agency_url']);
                            }
                        }
                        $osm_ref_trips          = htmlspecialchars( $trip_id );
                        $osm_gtfs_feed          = htmlspecialchars( $feed );
                        #$osm_gtfs_release_date  = htmlspecialchars( $ptna["release_date"] );
                        $osm_gtfs_route_id      = htmlspecialchars( $routes['route_id'] );
                        $osm_gtfs_trip_id       = htmlspecialchars( $trip_id );
                        $osm_gtfs_shape_id      = isset($trips['shape_id']) ? htmlspecialchars( $trips['shape_id'] ) : '';
                        $osm_gtfs_trip_id_like  = '';
                        if ( isset($osm['trip_id_regex']) && $osm['trip_id_regex'] && preg_match("/^".$osm['trip_id_regex']."$/",$trip_id) ) {
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
                        echo '                                <th class="gtfs-button"><button class="button-create" type="button" onclick="copy_to_clipboard(\'osm-route-master\')">Copy to Clipboard</button></th>' . "\n";
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
                        if ( $osm_route_master_name ) {
                            echo '                            <tr class="gtfs-tablerow">' . "\n";
                            echo '                                <td class="gtfs-name">name</td>' . "\n";
                            echo '                                <td class="gtfs-text">' . $osm_route_master_name . '</td>' . "\n";
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
                        if ( $osm_colour != '' ) {
                            echo '                            <tr class="gtfs-tablerow">' . "\n";
                            echo '                                <td class="gtfs-name">colour</td>' . "\n";
                            echo '                                <td class="gtfs-name">#' . $osm_colour . '</td>' . "\n";
                            echo '                            </tr>' . "\n";
                        }
                        if ( $osm_text_colour != '' ) {
                            echo '                            <tr class="gtfs-tablerow">' . "\n";
                            echo '                                <td class="gtfs-name">colour:text</td>' . "\n";
                            echo '                                <td class="gtfs-name">#' . $osm_text_colour . '</td>' . "\n";
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
                        #echo '                            <tr class="gtfs-tablerow">' . "\n";
                        #echo '                                <td class="gtfs-name">gtfs:release_date</td>' . "\n";
                        #echo '                                <td class="gtfs-name">' . $osm_gtfs_release_date . '</td>' . "\n";
                        #echo '                            </tr>' . "\n";
                        if ( $osm_gtfs_route_id != '') {
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
                        echo '                                <th class="gtfs-button"><button class="button-create" type="button" onclick="copy_to_clipboard(\'osm-route\')">Copy to Clipboard</button></th>' . "\n";
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
                        if ( $osm_route_name ) {
                            echo '                            <tr class="gtfs-tablerow">' . "\n";
                            echo '                                <td class="gtfs-name">name</td>' . "\n";
                            echo '                                <td class="gtfs-text">' . $osm_route_name . '</td>' . "\n";
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
                        if ( $osm_text_colour != '' ) {
                            echo '                            <tr class="gtfs-tablerow">' . "\n";
                            echo '                                <td class="gtfs-name">colour:text</td>' . "\n";
                            echo '                                <td class="gtfs-name">#' . $osm_text_colour . '</td>' . "\n";
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
                        #echo '                            <tr class="gtfs-tablerow">' . "\n";
                        #echo '                                <td class="gtfs-name">gtfs:release_date</td>' . "\n";
                        #echo '                                <td class="gtfs-name">' . $osm_gtfs_release_date . '</td>' . "\n";
                        #echo '                            </tr>' . "\n";
                        if ( $osm_gtfs_route_id != '' ) {
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
                    $list_separator = '|';

                    set_time_limit( 30 );

                    $start_time = gettimeofday(true);

                    $db = new SQLite3( $SqliteDb );

                    $sql        = "SELECT * FROM ptna";

                    $ptna       = $db->querySingle( $sql, true );

                    if ( isset($ptna['list_separator']) && $ptna['list_separator'] ) {
                        $list_separator = $ptna['list_separator'];
                    }

                    $sql        = sprintf( "SELECT trip_id
                                            FROM   ptna_trips
                                            WHERE  trip_id='%s' OR list_trip_ids LIKE '%s%s%%' OR list_trip_ids LIKE '%%%s%s%s%%' OR list_trip_ids LIKE '%%%s%s'",
                                            SQLite3::escapeString($trip_id), $list_separator, SQLite3::escapeString($trip_id), $list_separator, SQLite3::escapeString($trip_id), $list_separator, SQLite3::escapeString($trip_id), $list_separator );

                    $trip       = $db->querySingle( $sql, true );

                    $trip_id    = isset($trip['trip_id']) ? $trip['trip_id'] : '';

                    if ( $trip_id ) {
                        $sql        = "SELECT name FROM sqlite_master WHERE type='table' AND name='ptna_stops';";

                        $sql_master = $db->querySingle( $sql, true );

                        if ( isset($sql_master['name']) ) {
                            $join_ptna_stops = 'LEFT OUTER JOIN ptna_stops ON stop_times.stop_id = ptna_stops.stop_id';
                        } else {
                            $join_ptna_stops = '';
                        }

                        $sql = sprintf( "SELECT          *, stop_times.stop_id
                                         FROM            stop_times
                                         JOIN            stops ON stop_times.stop_id = stops.stop_id
                                         %s
                                         WHERE           stop_times.trip_id='%s'
                                         ORDER BY        CAST (stop_times.stop_sequence AS INTEGER) ASC;",
                                         $join_ptna_stops, SQLite3::escapeString($trip_id)
                                    );

                        $result = $db->query( $sql );

                        $counter = 1;
                        while ( $row=$result->fetchArray(SQLITE3_ASSOC) ) {
                            if ( $row["departure_time"] ) {
                                $row["departure_time"] = preg_replace('/:\d\d$/', '', $row["departure_time"] );
                            }
                            echo '                            <tr class="gtfs-tablerow">' . "\n";
                            echo '                                <td class="gtfs-number">'    . $counter++ . '</td>' . "\n";
                            if ( isset($row["normalized_stop_name"]) && $row["normalized_stop_name"] != '') {
                                echo '                                <td class="gtfs-stop-name normalized-name"><div title="GTFS: stop_name=\'' . htmlspecialchars($row["stop_name"]) . '\'">' . htmlspecialchars($row["normalized_stop_name"]) . '</div></td>' . "\n";
                            } else {
                                echo '                                <td class="gtfs-stop-name">' . htmlspecialchars($row["stop_name"]) . '</td>' . "\n";
                            }
                            echo '                                <td class="gtfs-comment">';
                            printf( '%s%s/%s%s', '<a href="https://www.openstreetmap.org/edit?editor=id#map=21/', $row["stop_lat"], $row["stop_lon"], '" target="_blank" title="Edit area in iD">iD</a>' );
                            $bbox = GetBbox( $row["stop_lat"], $row["stop_lon"], 15 );
                            printf( ', %sleft=%s&right=%s&top=%s&bottom=%s%s', '<a href="http://127.0.0.1:8111/load_and_zoom?', $bbox['left'],$bbox['right'],$bbox['top'],$bbox['bottom'], '&new_layer=false" target="hiddenIframe" title="Download area (30 m * 30 m) in JOSM">JOSM</a>' );
                            echo '</td>' . "\n";
                            echo '                                <td class="gtfs-date">'         . htmlspecialchars($row["departure_time"])                                     . '</td>' . "\n";
                            echo '                                <td class="gtfs-lat">'          . htmlspecialchars($row["stop_lat"])                                           . '</td>' . "\n";
                            echo '                                <td class="gtfs-lon">'          . htmlspecialchars($row["stop_lon"])                                           . '</td>' . "\n";
                            echo '                                <td class="gtfs-stop-id">'      . htmlspecialchars($row["stop_id"])                                            . '</td>' . "\n";
                            echo '                                <td class="gtfs-platform-id">'  . htmlspecialchars(isset($row["platform_code"]) ? $row["platform_code"] : '') . '</td>' . "\n";
                            echo '                                <td class="gtfs-comment">'      . HandlePtnaComment($row)                                                      . '</td>' . "\n";
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


    function GetStartEndDateAndRidesOfIdenticalTrips( $db, $trip_id, $get_rides ) {

        $return_array = array();

        $return_array["start_date"] = '20500101';
        $return_array["end_date"]   = '19700101';
        if ( $get_rides ) {
            $return_array["rides"]     = -1;
            $return_array["sum_rides"] = -1;
            $weekdays = array( "monday", "tuesday", "wednesday", "thursday", "friday", "saturday", "sunday" );
        }

        $has_min_max_dates    = 0;
        $has_list_service_ids = 0;
        $has_rides            = 0;

        if ( $db ) {

            if ( $trip_id ) {
                $list_separator = '|';

                set_time_limit( 60 );

                $sql        = "SELECT * FROM ptna";

                $ptna       = $db->querySingle( $sql, true );

                if ( isset($ptna['list_separator']) && $ptna['list_separator'] ) {
                    $list_separator = $ptna['list_separator'];
                }

                $sql        = "SELECT name FROM sqlite_master WHERE type='table' AND name='ptna_trips';";

                $sql_master = $db->querySingle( $sql, true );

                if ( isset($sql_master['name']) ) {

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
                        $has_min_max_dates  = 1;
                        if ( isset($result['rides']) && isset($result['sum_rides']) ) {
                            $return_array["rides"]     = $result['rides'];
                            $return_array["sum_rides"] = $result['sum_rides'];
                            $has_rides = 1;
                        }
                    }
                    if ( isset($result['list_service_ids']) && $has_rides == 0 ) {
                        if ( isset($result['rides']) && isset($result['sum_rides']) ) {
                            $return_array["rides"]     = $result['rides'];
                            $return_array["sum_rides"] = $result['sum_rides'];
                            $has_rides = 1;
                        }
                        if ( $has_min_max_dates == 0 || $has_rides == 0 ) {
                            $has_list_service_ids = 1;
                            #$departures_array = array_count_values( explode( $list_separator, $result['list_departure_times'] ) );
                            #print "<!-- list_departure_times: " . count(explode( $list_separator, $result['list_departure_times'])) . ' = ' . $result['list_departure_times'] . " -->\n";
                            #print "<!-- departure_times: " . implode(',',array_keys($departures_array)) . " -->\n";
                            #print "<!-- counts: " . implode(',',array_values($departures_array)) . " -->\n";
                            $service_id_array = array_count_values( explode( $list_separator, $result['list_service_ids'] ) );
                            #print "<!-- list_service_ids: " . count(explode( $list_separator, $result['list_service_ids'])) . ' = ' . $result['list_service_ids'] . " -->\n";
                            #print "<!-- service_ids: " . implode(',',array_keys($service_id_array)) . " -->\n";
                            #print "<!-- counts: " . implode(',',array_values($service_id_array)) . " -->\n";
                            $where_clause = "service_id='";
                            $counter = 0;
                            foreach ( array_keys($service_id_array) as $service_id ) {
                                $where_clause .= SQLite3::escapeString($service_id) . "' OR service_id='";
                                $counter = $counter + 1;
                                if ( $counter > 999 ) {
                                    break;
                                }
                            }
                            $days_of_service_id_array = array();
                            $sql = sprintf( "SELECT *
                                            FROM   calendar
                                            WHERE  %s;", preg_replace( "/ OR service_id='$/", "", $where_clause ) );

                            $result = $db->query( $sql );

                            $return_array["rides"] = 0;
                            while ( $row=$result->fetchArray(SQLITE3_ASSOC) ) {
                                if ( $has_min_max_dates == 0 ) {
                                    if ( $row["start_date"] < $return_array["start_date"] ) {
                                        $return_array["start_date"] = $row["start_date"];
                                    }
                                    if ( $row["end_date"] > $return_array["end_date"] ) {
                                        $return_array["end_date"]   = $row["end_date"];
                                    }
                                }
                                if ( $get_rides && $has_rides == 0 && $row["start_date"] <= $row["end_date"] ) {
                                    $servive_id = $row["service_id"];
                                    $interval = date_diff(date_create($row["start_date"]), date_create($row["end_date"]));
                                    #print "<!-- Totaldays: " . $servive_id . '=' . $interval->format("%a") . " -->\n";
                                    $days_of_week = 0;
                                    foreach ( $weekdays as $dow ) {
                                        if ( $row[$dow] == 1 ) {
                                            $days_of_week += 1;
                                        }
                                    }
                                    $days_of_service_id_array[$servive_id] = ceil($interval->format("%a") * $days_of_week / 7);
                                    if ( $days_of_service_id_array[$servive_id] < 1 && $days_of_week > 0 ) {
                                        $days_of_service_id_array[$servive_id] = $days_of_week;
                                    }
                                    #print "<!-- Service days per week: " . $days_of_week . ' -> ' . $servive_id . '=' . $days_of_service_id_array[$servive_id] . " -->\n";
                                    $sql_also_on = sprintf( "SELECT COUNT(exception_type) as also_on
                                                            FROM   calendar_dates
                                                            WHERE  service_id='%s' AND exception_type=1;",
                                                            SQLite3::escapeString($servive_id) );
                                    $also_on = $db->querySingle( $sql_also_on, true );
                                    $sql_not_on  = sprintf( "SELECT COUNT(exception_type) as not_on
                                                            FROM   calendar_dates
                                                            WHERE  service_id='%s' AND exception_type=2;",
                                                            SQLite3::escapeString($servive_id) );
                                    $not_on = $db->querySingle( $sql_not_on, true );
                                    $days_of_service_id_array[$servive_id] += $also_on['also_on'];
                                    #print "<!-- Also on days: " . $also_on['also_on'] . ' -> ' . $servive_id . '=' . $days_of_service_id_array[$servive_id] . " -->\n";
                                    $days_of_service_id_array[$servive_id] -= $not_on['not_on'];
                                    #print "<!-- Not on days: " . $not_on['not_on'] . ' -> ' . $servive_id . '=' . $days_of_service_id_array[$servive_id] . " -->\n";
                                    $days_of_service_id_array[$servive_id] *= $service_id_array[$servive_id];
                                    #print "<!-- Rides per day: " . $service_id_array[$servive_id] . ' -> ' . $servive_id . '=' . $days_of_service_id_array[$servive_id] . " -->\n";
                                    $return_array["rides"] += $days_of_service_id_array[$servive_id];
                                }
                            }
                        }
                    }
                }

                # alternatively, if there are no 'list_service_ids' and no 'min_date' and no 'max_date' columns in 'ptna_trips' tablethe DB
                if ( $has_min_max_dates == 0 && $has_list_service_ids == 0 ) {
                    print "<!-- Oops! Shouldn't come here -->\n";
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
                    $list_separator = '|';

                    $start_time = gettimeofday(true);

                    $db = new SQLite3( $SqliteDb );

                    $sql        = "SELECT * FROM ptna";

                    $ptna       = $db->querySingle( $sql, true );

                    if ( isset($ptna['list_separator']) && $ptna['list_separator'] ) {
                        $list_separator = $ptna['list_separator'];
                    }

                    $sql        = "SELECT name FROM sqlite_master WHERE type='table' AND name='ptna_trips';";

                    $sql_master = $db->querySingle( $sql, true );

                    if ( isset($sql_master['name']) ) {

                        $sql    = sprintf( "SELECT DISTINCT *
                                            FROM            ptna_trips
                                            WHERE           trip_id='%s' OR list_trip_ids LIKE '%s%s%%' OR list_trip_ids LIKE '%%%s%s%s%%' OR list_trip_ids LIKE '%%%s%s'",
                                            SQLite3::escapeString($trip_id), $list_separator, SQLite3::escapeString($trip_id), $list_separator, SQLite3::escapeString($trip_id), $list_separator, SQLite3::escapeString($trip_id), $list_separator
                                         );
                        $result = $db->querySingle( $sql, true );

                        if ( isset($result['list_trip_ids']) && isset($result['list_departure_times']) && isset($result['list_service_ids']) ) {
                            $list_trip_ids        = explode( $list_separator, $result['list_trip_ids'] );
                            $list_departure_times = explode( $list_separator, $result['list_departure_times'] );
                            $list_service_ids     = explode( $list_separator, $result['list_service_ids'] );
                            for ( $i = 0; $i < count($list_trip_ids); $i++ ) {
                                if ( isset($list_service_ids[$i]) && isset($list_departure_times[$i]) ) {
                                    if ( !isset($service_departure[$list_service_ids[$i]]) ) {
                                        $service_departure[$list_service_ids[$i]] = $list_departure_times[$i] . ',';
                                    } else {
                                        $service_departure[$list_service_ids[$i]] .= $list_departure_times[$i] . ',';
                                    }
                                }
                            }
                            if ( isset($result['list_durations']) ) {
                                $list_durations = explode( $list_separator, $result['list_durations'] );
                                for ( $i = 0; $i < count($list_trip_ids); $i++ ) {
                                    if ( isset($list_service_ids[$i]) && isset($list_durations[$i]) ) {
                                        if ( !isset($service_durations[$list_service_ids[$i]]) ) {
                                            $service_durations[$list_service_ids[$i]] = $list_durations[$i] . ',';
                                        } else {
                                            $service_durations[$list_service_ids[$i]] .= $list_durations[$i] . ',';
                                        }
                                    }
                                }
                            }

                            $service_ids = array_flip( array_flip( $list_service_ids ) );
                            $where_clause = "service_id='";
                            $counter = 1;
                            foreach ( $service_ids as $service_id ) {
                                $where_clause .= SQLite3::escapeString($service_id) . "' OR service_id='";
                                $counter = $counter + 1;
                                if ( $counter > 999 ) {
                                    break;
                                }
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
                                        $arr = explode( ', ', $cal_pos["dates"] );
                                        sort( $arr );
                                        $service_row .= preg_replace( "/(\d\d\d\d)(\d\d)(\d\d)/", "\\1-\\2-\\3", implode( ', ', $arr ) );
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
                                        $arr = explode( ', ', $cal_neg["dates"] );
                                        sort( $arr );
                                        $service_row .= preg_replace( "/(\d\d\d\d)(\d\d)(\d\d)/", "\\1-\\2-\\3", implode( ', ', $arr ) );
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
                                    if ( $result['list_durations'] && count($different_durations) > 1 ) {
                                        $array_departures = explode( ',', $departures );
                                    } else {
                                        $array_departures = array_flip( array_flip( explode( ',', $departures ) ) );
                                        sort( $array_departures );
                                    }
                                    $service_row .= htmlspecialchars( implode( ', ', $array_departures ) );
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
                            if ( $counter > 999 ) {
                                echo '                            <tr class="gtfs-tablerow">' . "\n";
                                echo '                              <td class="gtfs-text" colspan=14>' . "\n";
                                echo '                                  There are even more ... but we exeeded the query limit of the database';
                                echo '                              </td>' . "\n";
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
                    $list_separator = '|';

                    $start_time = gettimeofday(true);

                    $db = new SQLite3( $SqliteDb );

                    $sql        = "SELECT * FROM ptna";

                    $ptna       = $db->querySingle( $sql, true );

                    if ( isset($ptna['list_separator']) && $ptna['list_separator'] ) {
                        $list_separator = $ptna['list_separator'];
                    }

                    if ( $ptna["has_shapes"] ) {

                        $sql        = sprintf( "SELECT trip_id
                                                FROM   ptna_trips
                                                WHERE  trip_id='%s' OR list_trip_ids LIKE '%s%s%%' OR list_trip_ids LIKE '%%%s%s%s%%' OR list_trip_ids LIKE '%%%s%s'",
                                                SQLite3::escapeString($trip_id), $list_separator, SQLite3::escapeString($trip_id), $list_separator, SQLite3::escapeString($trip_id), $list_separator, SQLite3::escapeString($trip_id), $list_separator );

                        $trip       = $db->querySingle( $sql, true );

                        if ( isset($trip['trip_id']) && $trip['trip_id'] ) {
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
                                                ORDER BY CAST (shape_pt_sequence AS INTEGER) ASC;",
                                                SQLite3::escapeString($shape_id)
                                            );

                                $result = $db->query( $sql );

                                echo "              <hr />\n\n";
                                echo '              <h2 id="shapes">GTFS Shape Data, Shape-id: "' . $shape_id . '"</h2>' ."\n";
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
                                    if ( isset($row["shape_pt_lat"]) ) {
                                        echo '                              <td class="gtfs-lat">'     . htmlspecialchars($row["shape_pt_lat"])        . '</td>' . "\n";
                                    } else {
                                        echo '                              <td class="gtfs-lat">&nbsp;</td>' . "\n";
                                    }
                                    if ( isset($row["shape_pt_lon"]) ) {
                                        echo '                              <td class="gtfs-lon">'     . htmlspecialchars($row["shape_pt_lon"])        . '</td>' . "\n";
                                    } else {
                                        echo '                              <td class="gtfs-lon">&nbsp;</td>' . "\n";
                                    }
                                    if ( isset($row["shape_dist_traveled"]) ) {
                                        echo '                              <td class="gtfs-distance">'  . htmlspecialchars($row["shape_dist_traveled"]) . '</td>' . "\n";
                                    } else {
                                        echo '                              <td class="gtfs-distance">&nbsp;</td>' . "\n";
                                    }
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


    function CreateGtfsShapeEntry( $feed, $release_date, $shape_id ) {

        $SqliteDb = FindGtfsSqliteDb( $feed, $release_date );

        if ( $SqliteDb != '') {

           if ( $shape_id ) {

               try {
                    $start_time = gettimeofday(true);

                    $db = new SQLite3( $SqliteDb );

                    $sql        = "SELECT * FROM ptna";

                    $ptna       = $db->querySingle( $sql, true );

                    if ( $ptna["has_shapes"] ) {

                        $sql = sprintf( "SELECT   *
                                         FROM     shapes
                                         WHERE    shape_id='%s'
                                         ORDER BY CAST (shape_pt_sequence AS INTEGER) ASC;",
                                         SQLite3::escapeString($shape_id)
                                    );

                        $result = $db->query( $sql );

                        echo "              <hr />\n\n";
                        echo '              <h2 id="shapes">GTFS Shape Data, Shape-id: "' . $shape_id . '"</h2>' ."\n";
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
                            if ( isset($row["shape_pt_sequence"]) ) {
                                echo '                              <td class="gtfs-number">'  . $row["shape_pt_sequence"] . '</td>' . "\n";
                            } else {
                                echo '                              <td class="gtfs-number">'  . $counter++ . '</td>' . "\n";
                            }
                            if ( isset($row["shape_pt_lat"]) ) {
                                echo '                              <td class="gtfs-lat">'     . htmlspecialchars($row["shape_pt_lat"])        . '</td>' . "\n";
                            } else {
                                echo '                              <td class="gtfs-lat">&nbsp;</td>' . "\n";
                            }
                            if ( isset($row["shape_pt_lon"]) ) {
                                echo '                              <td class="gtfs-lon">'     . htmlspecialchars($row["shape_pt_lon"])        . '</td>' . "\n";
                            } else {
                                echo '                              <td class="gtfs-lon">&nbsp;</td>' . "\n";
                            }
                            if ( isset($row["shape_dist_traveled"]) ) {
                                echo '                              <td class="gtfs-distance">'  . htmlspecialchars($row["shape_dist_traveled"]) . '</td>' . "\n";
                            } else {
                                echo '                              <td class="gtfs-distance">&nbsp;</td>' . "\n";
                            }
                            echo '                          </tr>' . "\n";
                        }
                        echo '                      </tbody>' . "\n";
                        echo '                  </table>' . "\n";
                        echo '              </div>' . "\n";
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


    function CreateGtfsShapeTripList( $feed, $release_date, $shape_id ) {

        $SqliteDb = FindGtfsSqliteDb( $feed, $release_date );

        if ( $SqliteDb != '') {

           if ( $shape_id ) {

               try {
                    $start_time = gettimeofday(true);

                    $db = new SQLite3( $SqliteDb );

                    $sql        = "SELECT * FROM ptna";

                    $ptna       = $db->querySingle( $sql, true );

                    if ( $ptna["has_shapes"] ) {

                        $sql = sprintf( "SELECT   *
                                         FROM     trips
                                         JOIN     routes ON routes.route_id = trips.route_id
                                         WHERE    shape_id='%s'
                                         ORDER BY route_short_name ASC, trip_id DESC;",
                                         SQLite3::escapeString($shape_id)
                                    );

                        $result = $db->query( $sql );

                        while ( $row=$result->fetchArray(SQLITE3_ASSOC) ) {
                            echo '              <li class="gtfs-name"><a href="single-trip.php?feed=' . urlencode($feed) . '&release_date=' . urlencode($release_date) . '&trip_id=' . urlencode(htmlspecialchars($row["trip_id"])) . '">';
                            if ( isset($row["route_short_name"]) ) {
                                echo htmlspecialchars($row["route_short_name"]);
                            } else {
                                echo '????';
                            }
                            echo ' - '  . htmlspecialchars($row["trip_id"]) . '</a>';
                            if ( isset($row["trip_short_name"]) && $row["trip_short_name"] ) {
                                echo ' - ' . htmlspecialchars($row["trip_short_name"]);
                            }
                            if ( isset($row["trip_headsign"]) && $row["trip_headsign"] ) {
                                echo ' => ' . htmlspecialchars($row["trip_headsign"]);
                            }
                            echo '</li>' . "\n";
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

            if ( $route_id != '' ) {

                try {

                    $db = new SQLite3( $SqliteDb );

                    $sql = sprintf( "SELECT route_short_name
                                     FROM   routes
                                     WHERE  route_id='%s';",
                                     SQLite3::escapeString($route_id)
                                  );

                    $row = $db->querySingle( $sql, true );

                    if ( isset($row["route_short_name"]) ) {
                        return $row["route_short_name"];
                    } else {
                        return '';
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


    function GetGtfsRouteIdFromTripId( $feed, $release_date, $trip_id ) {

        $SqliteDb = FindGtfsSqliteDb( $feed, $release_date );

        if ( $SqliteDb != '' ) {

            if ( $trip_id ) {

                try {
                    $list_separator = '|';

                    $db = new SQLite3( $SqliteDb );

                    $sql        = "SELECT * FROM ptna";

                    $ptna       = $db->querySingle( $sql, true );

                    if ( isset($ptna['list_separator']) && $ptna['list_separator'] ) {
                        $list_separator = $ptna['list_separator'];
                    }

                    $sql        = sprintf( "SELECT trip_id
                                            FROM   ptna_trips
                                            WHERE  trip_id='%s' OR list_trip_ids LIKE '%s%s%%' OR list_trip_ids LIKE '%%%s%s%s%%' OR list_trip_ids LIKE '%%%s%s'",
                                            SQLite3::escapeString($trip_id), $list_separator, SQLite3::escapeString($trip_id), $list_separator, SQLite3::escapeString($trip_id), $list_separator, SQLite3::escapeString($trip_id), $list_separator );

                    $trip       = $db->querySingle( $sql, true );

                    $trip_id    = isset($trip['trip_id']) ? $trip['trip_id'] : '';

                    if ( $trip_id ) {
                        $sql = sprintf( "SELECT route_id
                                         FROM   trips
                                         WHERE  trip_id='%s';",
                                         SQLite3::escapeString($trip_id)
                                      );

                        $row = $db->querySingle( $sql, true );

                        if ( isset($row["route_id"]) ) {
                            return $row["route_id"];
                        } else {
                            return '';
                        }
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
                    $list_separator = '|';

                    $db = new SQLite3( $SqliteDb );

                    $sql        = "SELECT * FROM ptna";

                    $ptna       = $db->querySingle( $sql, true );

                    if ( isset($ptna['list_separator']) && $ptna['list_separator'] ) {
                        $list_separator = $ptna['list_separator'];
                    }

                    $sql        = sprintf( "SELECT trip_id
                                            FROM   ptna_trips
                                            WHERE  trip_id='%s' OR list_trip_ids LIKE '%s%s%%' OR list_trip_ids LIKE '%%%s%s%s%%' OR list_trip_ids LIKE '%%%s%s'",
                                            SQLite3::escapeString($trip_id), $list_separator, SQLite3::escapeString($trip_id), $list_separator, SQLite3::escapeString($trip_id), $list_separator, SQLite3::escapeString($trip_id), $list_separator );

                    $trip       = $db->querySingle( $sql, true );

                    $trip_id    = isset($trip['trip_id']) ? $trip['trip_id'] : '';

                    if ( $trip_id ) {
                        $sql = sprintf( "SELECT route_short_name
                                         FROM   routes
                                         JOIN   trips ON trips.route_id = routes.route_id
                                         WHERE  trip_id='%s';",
                                         SQLite3::escapeString($trip_id)
                                    );

                        $row = $db->querySingle( $sql, true );

                        if ( isset($row["route_short_name"]) ) {
                            return $row["route_short_name"];
                        } else {
                            return '';
                        }
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


    function GetGtfsTripIdsFromShapeId( $feed, $release_date, $shape_id ) {

        $SqliteDb = FindGtfsSqliteDb( $feed, $release_date );

        $ret_array = array();

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

                        $row = $db->query( $sql );

                        while ( $row=$result->fetchArray(SQLITE3_ASSOC) ) {
                            if ( isset($row["trip_id"]) ) {
                                array_push($ret_array,$row["trip_id"]);
                            }
                        }
                    }
                } catch ( Exception $ex ) {
                    echo "Sqlite DB could not be opened: " . htmlspecialchars($ex->getMessage()) . "\n";
                }
            }
        } else {
            echo "Sqlite DB not found for feed = '" . htmlspecialchars($feed) . "'\n";
        }

        return $ret_array;
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
                    $list_separator = '|';

                    $db  = new SQLite3( $SqliteDb );

                    $sql        = "SELECT * FROM ptna";

                    $ptna       = $db->querySingle( $sql, true );

                    if ( isset($ptna['list_separator']) && $ptna['list_separator'] ) {
                        $list_separator = $ptna['list_separator'];
                    }

                    $sql        = sprintf( "SELECT trip_id
                                            FROM   ptna_trips
                                            WHERE  trip_id='%s' OR list_trip_ids LIKE '%s%s%%' OR list_trip_ids LIKE '%%%s%s%s%%' OR list_trip_ids LIKE '%%%s%s'",
                                            SQLite3::escapeString($trip_id), $list_separator, SQLite3::escapeString($trip_id), $list_separator, SQLite3::escapeString($trip_id), $list_separator, SQLite3::escapeString($trip_id), $list_separator );

                    $trip       = $db->querySingle( $sql, true );

                    $trip_id    = isset($trip['trip_id']) ? $trip['trip_id'] : '';

                    $sql        = "SELECT name FROM sqlite_master WHERE type='table' AND name='ptna_trips_comments';";
                    $sql_master = $db->querySingle( $sql, true );

                    if ( isset($sql_master['name']) ) {
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

                        if ( (isset($row['commment'])                           && $row['commment']                           ) ||
                             (isset($row['subroute_of'])                        && $row['subroute_of']                        ) ||
                             (isset($row['suspicious_start'])                   && $row['suspicious_start']                   ) ||
                             (isset($row['suspicious_end'])                     && $row['suspicious_end']                     ) ||
                             (isset($row['suspicious_number_of_stops'])         && $row['suspicious_number_of_stops']         ) ||
                             (isset($row['suspicious_other'])                   && $row['suspicious_other']                   ) ||
                             (isset($row['same_names_but_different_ids'])       && $row['same_names_but_different_ids']       ) ||
                             (isset($row['same_stops_but_different_shape_ids']) && $row['same_stops_but_different_shape_ids'] )    ) {
                            $row['has_comments'] = 'yes';
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

            if ( $route_id != '' ) {

                try {

                    $db  = new SQLite3( $SqliteDb );

                    $sql = "SELECT name FROM sqlite_master WHERE type='table' AND name='ptna_routes_comments';";
                    $sql_master = $db->querySingle( $sql, true );

                    if ( isset($sql_master['name']) ) {
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
                if ( isset($feed["feed_publisher_name"]) && $feed["feed_publisher_name"] ) {
                    if ( isset($feed["feed_publisher_url"]) && $feed["feed_publisher_url"] ) {
                        echo '                            <td class="gtfs-text"><a target="_blank" href="' . $feed["feed_publisher_url"] . '" title="From GTFS">' . htmlspecialchars($feed["feed_publisher_name"]) . '</a></td>' . "\n";
                    } else {
                        echo '                            <td class="gtfs-text">' . htmlspecialchars($feed["feed_publisher_name"]) . '</td>' . "\n";
                    }
                } elseif ( isset($ptna["feed_publisher_name"]) && $ptna["feed_publisher_name"] ) {
                    if ( isset($ptna["feed_publisher_url"]) && $ptna["feed_publisher_url"] ) {
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
                if ( isset($feed["feed_start_date"]) && $feed["feed_start_date"] ) {
                    if ( preg_match( "/^(\d{4})(\d{2})(\d{2})$/", $feed["feed_start_date"], $parts ) ) {
                        echo '                            <td class="gtfs-text">' . $parts[1] . '-' .  $parts[2] . '-' .  $parts[3] . '</td>' . "\n";
                    } else {
                        echo '                            <td class="gtfs-text">' . htmlspecialchars($feed["feed_start_date"]) . '</td>' . "\n";
                    }
                } else {
                    echo '                            <td class="gtfs-text">&nbsp;</td>' . "\n";
                }
                echo '                        </tr>' . "\n";

                echo '                        <tr class="statistics-tablerow">' . "\n";
                echo '                            <td class="gtfs-name">Feed End Date</td>' . "\n";
                if ( isset($feed["feed_end_date"]) && $feed["feed_end_date"] ) {
                    if ( preg_match( "/^(\d{4})(\d{2})(\d{2})$/", $feed["feed_end_date"], $parts ) ) {
                        echo '                            <td class="gtfs-text">' . $parts[1] . '-' .  $parts[2] . '-' .  $parts[3] . '</td>' . "\n";
                    } else {
                        echo '                            <td class="gtfs-text">' . htmlspecialchars($feed["feed_end_date"]) . '</td>' . "\n";
                    }
                } else {
                    echo '                            <td class="gtfs-text">&nbsp;</td>' . "\n";
                }
                echo '                        </tr>' . "\n";

                echo '                        <tr class="statistics-tablerow">' . "\n";
                echo '                            <td class="gtfs-name">Feed Version</td>' . "\n";
                if ( isset($feed["feed_version"]) && $feed["feed_version"] ) {
                    echo '                            <td class="gtfs-text">' . htmlspecialchars($feed["feed_version"]) . '</td>' . "\n";
                } else {
                    echo '                            <td class="gtfs-text">&nbsp;</td>' . "\n";
                }
                echo '                        </tr>' . "\n";

                echo '                        <tr class="statistics-tablerow">' . "\n";
                echo '                            <td class="gtfs-name">Release Date</td>' . "\n";
                if ( isset($ptna["release_date"]) && $ptna["release_date"] ) {
                    echo '                            <td class="gtfs-text">' . htmlspecialchars($ptna["release_date"]) . '</td>' . "\n";
                } else {
                    echo '                            <td class="gtfs-text">&nbsp;</td>' . "\n";
                }
                echo '                        </tr>' . "\n";

                echo '                        <tr class="statistics-tablerow">' . "\n";
                echo '                            <td class="gtfs-name">Release Url</td>' . "\n";
                if ( isset($ptna["release_url"]) && $ptna["release_url"] ) {
                    echo '                            <td class="gtfs-text"><a target="_blank" href="' . $ptna["release_url"] . '">' . htmlspecialchars($ptna["release_url"]) . '</a></td>' . "\n";
                } else {
                    echo '                            <td class="gtfs-text">&nbsp;</td>' . "\n";
                }
                echo '                        </tr>' . "\n";

                echo '                        <tr class="statistics-tablerow">' . "\n";
                echo '                            <td class="gtfs-name">Download Date</td>' . "\n";
                if ( isset($ptna["release_url"]) && $ptna["release_url"] ) {
                    echo '                            <td class="gtfs-text">' . htmlspecialchars($ptna["prepared"])   . '</td>' . "\n";
                } else {
                    echo '                            <td class="gtfs-text">&nbsp;</td>' . "\n";
                }
                echo '                        </tr>' . "\n";

                echo '                        <tr class="statistics-tablerow">' . "\n";
                echo '                            <td class="gtfs-name">Publisher\'s License</td>' . "\n";
                if ( isset($ptna["original_license_url"]) && $ptna["original_license_url"] ) {
                    echo '                            <td class="gtfs-text">';
                    $list_original_license     = explode(';',$ptna["original_license"]);
                    $list_original_license_url = explode(';',$ptna["original_license_url"]);
                    if ( count($list_original_license) == count($list_original_license_url) ) {
                        $counter = count($list_original_license);
                        for ( $i = 0; $i < $counter; $i++ ) {
                            echo '<a target="_blank" href="' . $list_original_license_url[$i] . '">' . htmlspecialchars($list_original_license[$i]) . '</a>';
                            if ( $i < $counter-1 ) {
                                echo ' ; ';
                            }
                        }
                    } else {
                        echo '<a target="_blank" href="' . $ptna["original_license_url"] . '">' . htmlspecialchars($ptna["original_license"]) . '</a>';
                    }
                    echo '</td>' . "\n";
                } else {
                    echo '                            <td class="gtfs-text">' . htmlspecialchars($ptna["original_license"]) . '</td>' . "\n";
                }
                echo '                        </tr>' . "\n";

                echo '                        <tr class="statistics-tablerow">' . "\n";
                echo '                            <td class="gtfs-name">License given for use in OSM</td>' . "\n";
                if ( isset($ptna["license_url"]) && $ptna["license_url"]  ) {
                    echo '                            <td class="gtfs-text"><a target="_blank" href="' . $ptna["license_url"] . '">' . htmlspecialchars($ptna["license"]) . '</a></td>' . "\n";
                } else {
                    echo '                            <td class="gtfs-text">' . htmlspecialchars($ptna["license"]) . '</td>' . "\n";
                }
                echo '                        </tr>' . "\n";

                echo '                        <tr class="statistics-tablerow">' . "\n";
                echo '                            <td class="gtfs-name">Has Shape Data</td>' . "\n";
                if ( isset($ptna["has_shapes"]) && $ptna["has_shapes"] ) {
                    echo '                           <td class="gtfs-text"><img src="/img/CheckMark.png" width=32 height=32 alt="yes" /></td>' . "\n";
                } else {
                    echo '                           <td class="gtfs-text"></td>' . "\n";
                }
                echo '                        </tr>' . "\n";

                echo '                        <tr class="statistics-tablerow">' . "\n";
                echo '                            <td class="gtfs-name">Consider calendar data</td>' . "\n";
                if ( isset($ptna["consider_calendar"]) && $ptna["consider_calendar"] ) {
                    echo '                           <td class="gtfs-text"><img src="/img/CheckMark.png" width=32 height=32 alt="yes" /></td>' . "\n";
                } else {
                    echo '                           <td class="gtfs-text"></td>' . "\n";
                }
                echo '                        </tr>' . "\n";

                echo '                        <tr class="statistics-tablerow">' . "\n";
                echo '                            <td class="gtfs-name">GTFS data prepared for PTNA</td>' . "\n";
                if ( isset($ptna["prepared"]) && $ptna["prepared"] ) {
                    echo '                            <td class="gtfs-text">' . htmlspecialchars($ptna["prepared"])   . '</td>' . "\n";
                } else {
                    echo '                           <td class="gtfs-text"></td>' . "\n";
                }
                echo '                        </tr>' . "\n";

                echo '                        <tr class="statistics-tablerow">' . "\n";
                echo '                            <td class="gtfs-name">GTFS data aggregated for PTNA</td>' . "\n";
                if ( isset($ptna["aggregated"]) && $ptna["aggregated"]  ) {
                    echo '                            <td class="gtfs-text">' . htmlspecialchars($ptna["aggregated"]) . '</td>' . "\n";
                } else {
                    echo '                           <td class="gtfs-text"></td>' . "\n";
                }
                echo '                        </tr>' . "\n";

                echo '                        <tr class="statistics-tablerow">' . "\n";
                echo '                            <td class="gtfs-name">GTFS data analyzed for PTNA</td>' . "\n";
                if ( isset($ptna["analyzed"]) && $ptna["analyzed"] ) {
                    echo '                            <td class="gtfs-text">' . htmlspecialchars($ptna["analyzed"])   . '</td>' . "\n";
                } else {
                    echo '                           <td class="gtfs-text"></td>' . "\n";
                }
                echo '                        </tr>' . "\n";

                echo '                        <tr class="statistics-tablerow">' . "\n";
                echo '                            <td class="gtfs-name">GTFS data normalized for PTNA</td>' . "\n";
                if ( isset($ptna["normalized"])&& $ptna["normalized"] ) {
                    echo '                            <td class="gtfs-text">' . htmlspecialchars($ptna["normalized"])  . '</td>' . "\n";
                } else {
                    echo '                           <td class="gtfs-text"></td>' . "\n";
                }
                echo '                        </tr>' . "\n";

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


    function CreateOsmDetails( $feed, $release_date ) {

        $SqliteDb = FindGtfsSqliteDb( $feed, $release_date );

        if ( $SqliteDb != '' ) {

            try {

                $start_time = gettimeofday(true);

                $db  = new SQLite3( $SqliteDb );

                $sql = "SELECT name FROM sqlite_master WHERE type='table' AND name='osm';";

                $sql_master = $db->querySingle( $sql, true );

                if ( isset($sql_master['name']) ) {

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
                    if ( isset($osm["gtfs_short_name_hack1"]) && $osm["gtfs_short_name_hack1"] ) {
                        echo '                                       <td class="gtfs-text"><img src="/img/CheckMark.png" width=32 height=32 alt="yes" /></td>' . "\n";
                    } else {
                        echo '                                       <td class="gtfs-text"></td>' . "\n";
                    }
                    echo '                                    </tr>' . "\n";

                    echo '                                    <tr class="statistics-tablerow">' . "\n";
                    echo '                                        <td class="gtfs-name">Where to search for PTNA analysis information of routes</td>' . "\n";
                    if ( isset($osm["ptna_analysis"]) ) {
                        echo '                                       <td class="gtfs-text">' . htmlspecialchars($osm["ptna_analysis"]) . ' </td>' . "\n";
                    } else {
                        echo '                                       <td class="gtfs-text"></td>' . "\n";
                    }
                    echo '                                    </tr>' . "\n";

                    if ( isset($osm["route_master_name_suggestion"]) ) {
                        echo '                                    <tr class="statistics-tablerow">' . "\n";
                        echo '                                        <td class="gtfs-name">Contents of \'name\' suggestion for OSM route_master</td>' . "\n";
                        if ( $osm["route_master_name_suggestion"] ) {
                            if ( $osm["route_master_name_suggestion"] == 'PTv2' ) {
                                echo '                                       <td class="gtfs-text">[according to PTV2 proposal]</td>' . "\n";
                            } else {
                                echo '                                       <td class="gtfs-text">' . htmlspecialchars($osm["route_master_name_suggestion"]) . ' </td>' . "\n";
                            }
                        } else {
                            echo '                                       <td class="gtfs-text">[no suggestion]</td>' . "\n";
                        }
                        echo '                                    </tr>' . "\n";
                    }

                    if ( isset($osm["route_name_suggestion"]) ) {
                        echo '                                    <tr class="statistics-tablerow">' . "\n";
                        echo '                                        <td class="gtfs-name">Contents of \'name\' suggestion for OSM route</td>' . "\n";
                        if ( $osm["route_name_suggestion"] ) {
                            if ( $osm["route_name_suggestion"] == 'PTv2' ) {
                                echo '                                       <td class="gtfs-text">[according to PTV2 proposal]</td>' . "\n";
                            } else {
                                echo '                                       <td class="gtfs-text">' . htmlspecialchars($osm["route_name_suggestion"]) . ' </td>' . "\n";
                            }
                        } else {
                            echo '                                       <td class="gtfs-text">[no suggestion]</td>' . "\n";
                        }
                        echo '                                    </tr>' . "\n";
                    }

                    if ( isset($osm["wn"]) ) {
                        echo '                                    <tr class="statistics-tablerow">' . "\n";
                        echo '                                        <td class="gtfs-name">Weight for comparison of GTFS \'stop_name\' versus OSM platform \'name\'</td>' . "\n";
                        if ( $osm["wn"] == '' ) {
                            echo '                                       <td class="gtfs-text">[default value]</td>' . "\n";
                        } elseif ( $osm["wn"] == 0 ) {
                            echo '                                       <td class="gtfs-text">0 [disabled]</td>' . "\n";
                        } else {
                            echo '                                       <td class="gtfs-text">' . htmlspecialchars($osm["wn"]) . ' </td>' . "\n";
                        }
                        echo '                                    </tr>' . "\n";
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


   function CreatePtnaAggregationStatistics( $feed, $release_date ) {

        $SqliteDb = FindGtfsSqliteDb( $feed, $release_date );

        if ( $SqliteDb != '' ) {

            try {

                $start_time = gettimeofday(true);

                $db  = new SQLite3( $SqliteDb );

                $sql = "SELECT name FROM sqlite_master WHERE type='table' AND name='ptna_aggregation';";

                $sql_master = $db->querySingle( $sql, true );

                if ( isset($sql_master['name']) ) {

                    $sql = sprintf( "SELECT * FROM ptna_aggregation;" );

                    $ptna = $db->querySingle( $sql, true );

                    if ( isset($ptna["date"]) && $ptna["date"] ) {
                        echo '                        <tr class="statistics-tablerow">' . "\n";
                        echo '                            <td class="statistics-name">Date</td>' . "\n";
                        echo '                            <td class="statistics-number">'  . htmlspecialchars($ptna["date"]) . '</td>' . "\n";
                        echo '                            <td class="statistics-number">[YYYY-MM-DD]</td>' . "\n";
                        echo '                        </tr>' . "\n";
                    }
                    if ( isset($ptna["duration"]) ) {
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
                    if ( isset($ptna["size_before"]) ) {
                        echo '                        <tr class="statistics-tablerow">' . "\n";
                        echo '                            <td class="statistics-name">SQLite-DB size before</td>' . "\n";
                        echo '                            <td class="statistics-number">'  . sprintf( "%2.2f", htmlspecialchars($ptna["size_before"]) / 1024 / 1024 ) . '</td>' . "\n";
                        echo '                            <td class="statistics-number">[MB]</td>' . "\n";
                        echo '                        </tr>' . "\n";
                    }
                    if ( isset($ptna["size_after"]) ) {
                        echo '                        <tr class="statistics-tablerow">' . "\n";
                        echo '                            <td class="statistics-name">SQLite-DB size after</td>' . "\n";
                        echo '                            <td class="statistics-number">'  . sprintf( "%2.2f", htmlspecialchars($ptna["size_after"]) / 1024 / 1024 ) . '</td>' . "\n";
                        echo '                            <td class="statistics-number">[MB]</td>' . "\n";
                        echo '                        </tr>' . "\n";
                    }
                    if ( isset($ptna["routes_before"]) ) {
                        echo '                        <tr class="statistics-tablerow">' . "\n";
                        echo '                            <td class="statistics-name">Number of Routes before</td>' . "\n";
                        echo '                            <td class="statistics-number">'  . sprintf( "%d", htmlspecialchars($ptna["routes_before"]) ) . '</td>' . "\n";
                        echo '                            <td class="statistics-number">[1]</td>' . "\n";
                        echo '                        </tr>' . "\n";
                    }
                    if ( isset($ptna["routes_after"]) ) {
                        echo '                        <tr class="statistics-tablerow">' . "\n";
                        echo '                            <td class="statistics-name">Number of Routes after</td>' . "\n";
                        echo '                            <td class="statistics-number">'  . sprintf( "%d", htmlspecialchars($ptna["routes_after"]) ) . '</td>' . "\n";
                        echo '                            <td class="statistics-number">[1]</td>' . "\n";
                        echo '                        </tr>' . "\n";
                    }
                    if ( isset($ptna["trips_before"]) ) {
                        echo '                        <tr class="statistics-tablerow">' . "\n";
                        echo '                            <td class="statistics-name">Number of Trips before</td>' . "\n";
                        echo '                            <td class="statistics-number">'  . sprintf( "%d", htmlspecialchars($ptna["trips_before"]) ) . '</td>' . "\n";
                        echo '                            <td class="statistics-number">[1]</td>' . "\n";
                        echo '                        </tr>' . "\n";
                    }
                    if ( isset($ptna["trips_after"]) ) {
                        echo '                        <tr class="statistics-tablerow">' . "\n";
                        echo '                            <td class="statistics-name">Number of Trips after</td>' . "\n";
                        echo '                            <td class="statistics-number">'  . sprintf( "%d", htmlspecialchars($ptna["trips_after"]) ) . '</td>' . "\n";
                        echo '                            <td class="statistics-number">[1]</td>' . "\n";
                        echo '                        </tr>' . "\n";
                    }
                    if ( isset($ptna["stops_before"]) ) {
                        echo '                        <tr class="statistics-tablerow">' . "\n";
                        echo '                            <td class="statistics-name">Number of Stops before</td>' . "\n";
                        echo '                            <td class="statistics-number">'  . sprintf( "%d", htmlspecialchars($ptna["stops_before"]) ) . '</td>' . "\n";
                        echo '                            <td class="statistics-number">[1]</td>' . "\n";
                        echo '                        </tr>' . "\n";
                    }
                    if ( isset($ptna["stops_after"]) ) {
                        echo '                        <tr class="statistics-tablerow">' . "\n";
                        echo '                            <td class="statistics-name">Number of Stops after</td>' . "\n";
                        echo '                            <td class="statistics-number">'  . sprintf( "%d", htmlspecialchars($ptna["stops_after"]) ) . '</td>' . "\n";
                        echo '                            <td class="statistics-number">[1]</td>' . "\n";
                        echo '                        </tr>' . "\n";
                    }
                    if ( isset($ptna["stop_times_before"]) ) {
                        echo '                        <tr class="statistics-tablerow">' . "\n";
                        echo '                            <td class="statistics-name">Number of Stop-Times before</td>' . "\n";
                        echo '                            <td class="statistics-number">'  . sprintf( "%d", htmlspecialchars($ptna["stop_times_before"]) ) . '</td>' . "\n";
                        echo '                            <td class="statistics-number">[1]</td>' . "\n";
                        echo '                        </tr>' . "\n";
                    }
                    if ( isset($ptna["stop_times_after"]) ) {
                        echo '                        <tr class="statistics-tablerow">' . "\n";
                        echo '                            <td class="statistics-name">Number of Stop-Times after</td>' . "\n";
                        echo '                            <td class="statistics-number">'  . sprintf( "%d", htmlspecialchars($ptna["stop_times_after"]) ) . '</td>' . "\n";
                        echo '                            <td class="statistics-number">[1]</td>' . "\n";
                        echo '                        </tr>' . "\n";
                    }
                    if ( isset($ptna["shapes_before"]) && isset($ptna["shapes_after"]) ) {
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

                if ( isset($sql_master['name']) ) {

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
                        if ( $duration >= 3600 ) {
                            printf( "%2d:", $duration / 3600 );
                            $format_mins = '%02d:';
                        }
                        if ( $duration >= 60 ) {
                            printf( $format_mins, ($duration % 3600) / 60 );
                            $format_secs = '%02d';
                        }
                        printf( $format_secs, ($duration % 60) );
                        echo '                            <td class="statistics-number">[hh:mm:ss]</td>' . "\n";
                        echo '                        </tr>' . "\n";
                    }

                    $sql        = "SELECT name FROM sqlite_master WHERE type='table' AND name='ptna_trips_comments';";
                    $sql_master = $db->querySingle( $sql, true );

                    if ( isset($sql_master['name']) ) {
                        $sql     = sprintf( "PRAGMA table_info(ptna_trips_comments)" );
                        $result  = $db->query( $sql );
                        $columns = [];
                        while ( $row=$result->fetchArray(SQLITE3_ASSOC) ) {
                            if ( $row["name"] ) {
                                $columns[$row["name"]] = 1;
                            }
                        }
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
                        if ( isset($columns['same_stops_but_different_shape_ids']) ) {
                            $sql  = sprintf( "SELECT COUNT(*) as count FROM ptna_trips_comments WHERE same_stops_but_different_shape_ids != '';" );
                            $ptna = $db->querySingle( $sql, true );
                            if ( $ptna["count"] ) {
                                echo '                        <tr class="statistics-tablerow">' . "\n";
                                echo '                            <td class="statistics-name">Trips with identical stops but different shape-ids</td>' . "\n";
                                echo '                            <td class="statistics-number"><a href="gtfs-analysis-details.php?feed=' . urlencode($feed) . '&release_date=' . urlencode($release_date) . '&topic=DIFFSHAPES">'  . htmlspecialchars($ptna["count"]) . '</a></td>' . "\n";
                                echo '                            <td class="statistics-number">[1]</td>' . "\n";
                                echo '                        </tr>' . "\n";
                            }
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
                        if ( isset($columns['suspicious_number_of_stops']) ) {
                            $sql  = sprintf( "SELECT COUNT(*) as count FROM ptna_trips_comments WHERE suspicious_number_of_stops != '';" );
                            $ptna = $db->querySingle( $sql, true );
                            if ( $ptna["count"] ) {
                                echo '                        <tr class="statistics-tablerow">' . "\n";
                                echo '                            <td class="statistics-name">Trips with suspicious number of stops</td>' . "\n";
                                echo '                            <td class="statistics-number"><a href="gtfs-analysis-details.php?feed=' . urlencode($feed) . '&release_date=' . urlencode($release_date) . '&topic=SUSPCOUNT">'  . htmlspecialchars($ptna["count"]) . '</a></td>' . "\n";
                                echo '                            <td class="statistics-number">[1]</td>' . "\n";
                                echo '                        </tr>' . "\n";
                            }
                        }
                        if ( isset($columns['suspicious_trip_duration']) ) {
                            $sql  = sprintf( "SELECT COUNT(*) as count FROM ptna_trips_comments WHERE suspicious_trip_duration != '';" );
                            $ptna = $db->querySingle( $sql, true );
                            if ( $ptna["count"] ) {
                                echo '                        <tr class="statistics-tablerow">' . "\n";
                                echo '                            <td class="statistics-name">Trips with suspicious travel time</td>' . "\n";
                                echo '                            <td class="statistics-number"><a href="gtfs-analysis-details.php?feed=' . urlencode($feed) . '&release_date=' . urlencode($release_date) . '&topic=TIME">'  . htmlspecialchars($ptna["count"]) . '</a></td>' . "\n";
                                echo '                            <td class="statistics-number">[1]</td>' . "\n";
                                echo '                        </tr>' . "\n";
                            }
                        }
                        if ( isset($columns['suspicious_other']) ) {
                            $sql  = sprintf( "SELECT COUNT(*) as count FROM ptna_trips_comments WHERE suspicious_other != '';" );
                            $ptna = $db->querySingle( $sql, true );
                            if ( $ptna["count"] ) {
                                echo '                        <tr class="statistics-tablerow">' . "\n";
                                echo '                            <td class="statistics-name">Suspicious trip</td>' . "\n";
                                echo '                            <td class="statistics-number"><a href="gtfs-analysis-details.php?feed=' . urlencode($feed) . '&release_date=' . urlencode($release_date) . '&topic=OTHER">'  . htmlspecialchars($ptna["count"]) . '</a></td>' . "\n";
                                echo '                            <td class="statistics-number">[1]</td>' . "\n";
                                echo '                        </tr>' . "\n";
                            }
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

                if ( isset($sql_master['name']) ) {

                    $sql = sprintf( "SELECT * FROM ptna_normalization;" );

                    $ptna = $db->querySingle( $sql, true );

                    if ( isset($ptna["date"]) ) {
                        echo '                        <tr class="statistics-tablerow">' . "\n";
                        echo '                            <td class="statistics-name">Date</td>' . "\n";
                        echo '                            <td class="statistics-date">'  . htmlspecialchars($ptna["date"]) . '</td>' . "\n";
                        echo '                            <td class="statistics-number">[YYYY-MM-DD]</td>' . "\n";
                        echo '                        </tr>' . "\n";
                    }
                    if ( isset($ptna["duration"]) ) {
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
                    if ( isset($ptna["routes"]) ) {
                        echo '                        <tr class="statistics-tablerow">' . "\n";
                        echo '                            <td class="statistics-name">Routes</td>' . "\n";
                        echo '                            <td class="statistics-number">'  . htmlspecialchars($ptna["routes"]) . '</td>' . "\n";
                        echo '                            <td class="statistics-number">[1]</td>' . "\n";
                        echo '                        </tr>' . "\n";
                    }
                    if ( isset($ptna["stops"]) ) {
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

           if ( !$topic || preg_match("/^[ 0-9A-Za-z_.-]+$/", $topic) ) {

                try {

                    set_time_limit( 30 );

                    $start_time = gettimeofday(true);

                    $feed_array  = explode( '-', $feed );
                    $countrydir = array_shift( $feed_array );

                    $db = new SQLite3( $SqliteDb );

                    $sql        = "SELECT name FROM sqlite_master WHERE type='table' AND name='ptna_trips_comments';";
                    $sql_master = $db->querySingle( $sql, true );

                    if ( isset($sql_master['name']) ) {

                        $result = $db->query( "PRAGMA table_info(ptna_trips_comments);" );

                        $col_name['SUBR']      = '';
                        $col_name['SUSPSTART'] = '';
                        $col_name['SUSPEND']   = '';
                        $col_name['SUSPCOUNT'] = '';
                        $col_name['IDENT']     = '';
                        $col_name['TIME']      = '';
                        $col_name['OTHER']     = '';
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
                            elseif ( $row["name"] == 'suspicious_number_of_stops' ) {
                                $col_name['SUSPCOUNT']  = 'suspicious_number_of_stops';
                            }
                            elseif ( $row["name"] == 'suspicious_trip_duration' ) {
                                $col_name['TIME']  = 'suspicious_trip_duration';
                            }
                            elseif ( $row["name"] == 'suspicious_other' ) {
                                $col_name['OTHER'] = 'suspicious_other';
                            }
                            elseif ( $row["name"] == 'same_names_but_different_ids' ) {
                                $col_name['IDENT'] = 'same_names_but_different_ids';
                            }
                            elseif ( $row["name"] == 'same_stops_but_different_shape_ids' ) {
                                $col_name['DIFFSHAPES']  = 'same_stops_but_different_shape_ids';
                            }
                        }

                        $sql = '';

                        if ( $topic ) {
                            if ( $col_name[$topic] ) {
                                $sql = sprintf( "SELECT             routes.route_id,route_short_name,ptna_trips_comments.trip_id,%s
                                                 FROM               ptna_trips_comments
                                                 JOIN               trips              ON   ptna_trips_comments.trip_id = trips.trip_id
                                                 JOIN               routes             ON   trips.route_id              = routes.route_id
                                                 WHERE              %s != ''
                                                 ORDER BY CASE WHEN route_short_name GLOB '[^0-9]*'  THEN route_short_name ELSE CAST(route_short_name AS INTEGER) END;",
                                                 $col_name[$topic], $col_name[$topic]
                                              );
                            }
                        } else {
                            $col_names = sprintf( "%s,%s,%s", $col_name['SUBR'], $col_name['SUSPSTART'], $col_name['SUSPEND'], $col_name['IDENT'] );
                            $where_ors = sprintf( "%s != '' OR %s != '' OR %s != '' OR %s != ''", $col_name['SUBR'], $col_name['SUSPSTART'], $col_name['SUSPEND'], $col_name['IDENT'] );
                            if ( $col_name['SUSPCOUNT'] ) {
                                $col_names = sprintf( "%s,%s", $col_names, $col_name['SUSPCOUNT'] );
                                $where_ors = sprintf( "%s OR %s != ''", $where_ors, $col_name['SUSPCOUNT'] );
                            }
                            if ( $col_name['TIME'] ) {
                                $col_names = sprintf( "%s,%s", $col_names, $col_name['TIME'] );
                                $where_ors = sprintf( "%s OR %s != ''", $where_ors, $col_name['TIME'] );
                            }
                            if ( $col_name['OTHER'] ) {
                                $col_names = sprintf( "%s,%s", $col_names, $col_name['OTHER'] );
                                $where_ors = sprintf( "%s OR %s != ''", $where_ors, $col_name['OTHER'] );
                            }
                            $sql = sprintf( "SELECT             routes.route_id,route_short_name,ptna_trips_comments.trip_id,%s
                                             FROM               ptna_trips_comments
                                             JOIN               trips              ON   ptna_trips_comments.trip_id = trips.trip_id
                                             JOIN               routes             ON   trips.route_id              = routes.route_id
                                             WHERE              %s
                                             ORDER BY CASE WHEN route_short_name GLOB '[^0-9]*' THEN route_short_name ELSE CAST(route_short_name AS INTEGER) END;",
                                             $col_names, $where_ors
                                        );
                        }

                        if ( $sql ) {
                            $result = $db->query( $sql );

                            while ( $row=$result->fetchArray(SQLITE3_ASSOC) ) {
                                echo '                            <tr class="gtfs-tablerow">'    . "\n";
                                echo '                                <td class="gtfs-name"><a href="/gtfs/' . $countrydir . '/trips.php?feed='       . urlencode($feed) . '&release_date=' . urlencode($release_date) . '&route_id=' . urlencode($row["route_id"]) . '">' . htmlspecialchars($row["route_short_name"]) . '</a></td>' . "\n";
                                echo '                                <td class="gtfs-name"><a href="/gtfs/' . $countrydir . '/single-trip.php?feed=' . urlencode($feed) . '&release_date=' . urlencode($release_date) . '&trip_id='  . urlencode($row["trip_id"]) . '">' . htmlspecialchars($row["trip_id"]) . '</td>' . "\n";
                                echo '                                <td class="gtfs-comment">' . HandlePtnaComment($row) . '</td>' . "\n";
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
        global  $route_type_to_string;

        if ( isset($route_type_to_string[$rt]) ) {
            return $route_type_to_string[$rt];
        } else {
            return $rt;
        }
    }


    function RouteType2OsmRoute( $rt ) {
        global $route_type_to_osm_route;

        $ort = 'unkonwn';

        if ( count($route_type_to_osm_route) > 0 ) {
            if ( isset($route_type_to_osm_route[$rt]) ) {
                $ort = $route_type_to_osm_route[$rt];
            }
        } else {
            $lrt = strtolower(RouteType2String($rt));

            if ( preg_match("/trolleybus/",$lrt) ) {
                $ort = 'trolleybus';
            } elseif ( preg_match("/demand and response bus/",$lrt) ) {
                $ort = 'share_taxi';
            } elseif ( preg_match("/tram/",$lrt) ) {
                $ort = 'tram';
            } elseif ( preg_match("/bus/",$lrt) ) {
                $ort = 'bus';
            } elseif ( preg_match("/monorail/",$lrt) ) {
                $ort = 'monorail';
            } elseif ( preg_match("/light rail/",$lrt) ) {
                $ort = 'light_rail';
            } elseif ( preg_match("/ferry/",$lrt) || preg_match("/water transport service/",$lrt) ) {
                $ort = 'ferry';
            } elseif ( preg_match("/rail/",$lrt)  || preg_match("/train/",$lrt) ) {
                $ort = 'train';
            } elseif ( preg_match("/funicular/",$lrt) ) {
                $ort = 'funicular';
            } elseif ( preg_match("/aerial/",$lrt) ) {
                $ort = 'aerialway';
            } elseif ( preg_match("/metro/",$lrt) || preg_match("/subway/",$lrt) || preg_match("/underground/",$lrt) ) {
                $ort = 'subway';
            } elseif ( preg_match("/undefined/",$lrt) ) {
                $ort = RouteType2String($rt);
            } else {
                if ( preg_match("/^[0-9]+$/",$lrt) && $lrt >= 1000 && $lrt < 2000 ) {
                    $ort = 'ferry';
                } else {
                    $ort = 'bus';
                }
            }
        }

        return $ort;
    }


    function RouteType2OsmRouteImportance( $rt ) {
        global $route_type_to_sort_key;

        $rti = 6300;

        if ( count($route_type_to_sort_key) > 0 ) {
            if ( isset($route_type_to_sort_key[$rt]) ) {
                $rti = $route_type_to_sort_key[$rt];
            }
        } else {
            $rts = strtolower(RouteType2String($rt));

            if ( preg_match("/metro/",$rts) || preg_match("/subway/",$rts) || preg_match("/underground/",$rts) ) {
                $rti = '2000';
            } elseif ( preg_match("/tram/",$rts) || preg_match("/streetcar/",$rts) ) {
                $rti= '3000';
            } elseif ( preg_match("/coach/",$rts) ) {
                $rti= '40' . sprintf("%02d",$rt % 200);
            } elseif ( $rt == 3 || ($rt >= 700 && $rt < 800) ) {
                if ( $rt == 701 ) {     # Regional Bus service shall have lower prio than Express Bus service
                    $rt = 702;
                } elseif ( $rt == 702) {
                    $rt = 701;
                } elseif ( $rt == 3 ) {
                    $rt = 701;
                }
                $rti= '50' . sprintf("%02d",$rt % 700);
            } elseif ( preg_match("/taxi/",$rts) ) {
                $rti= '6900';
            } elseif ( preg_match("/monorail/",$rts) ) {
                $rti= '7000';
            } elseif ( preg_match("/funicular/",$rts) ) {
                $rti= '8000';
            } elseif ( $rt == 4 || ($rt >= 1000 && $rt < 1100) ) {
                $rti= '99' . sprintf("%02d",$rt % 1000);
            } elseif ( $rt == 6 || ($rt >= 1300 && $rt < 1400) ) {
                $rti= '9000';
            } elseif ( preg_match("/rail/",$rts)  || preg_match("/train/",$rts)) {
                if ( preg_match("/high speed/",$rts) ) {
                    $rti= '1000';
                } elseif ( preg_match("/long distance/",$rts) ) {
                    $rti= '1100';
                } elseif ( preg_match("/inter regional/",$rts) ) {
                    $rti= '1200';
                } elseif ( preg_match("/regional/",$rts) ) {
                    $rti= '1400';
                } elseif ( preg_match("/suburban/",$rts) ) {
                    $rti= '1600';
                } elseif ( preg_match("/light rail/",$rts) ) {
                    $rti= '1599';
                } else {
                    $rti= '1900';
                }
            } else {
                $rti= '6300';
            }
        }

        return $rti;
    }


    function OsmRoute2Vehicle( $rt, $language ) {
        global $osm_route_to_string;

        $orv = 'unkonwn';

        if ( !$language ) {
            $language = 'en';
        }
        if ( count($osm_route_to_string) > 0 ) {
            if ( !isset($osm_route_to_string[$language]) ) {
                $language = 'en';
            }
            if ( isset($osm_route_to_string[$language][$rt]) ) {
                $orv = $osm_route_to_string[$language][$rt];
                #echo "<!-- OsmRoute2Vehicle( " . $rt . ", " . $language . " ) = " . $orv . " -->\n";
            }
        } else {
            if ( $language == 'de' ) {
                if ( $rt == 'trolleybus' ) {
                    $orv = 'Oberleitungsbus';
                } elseif ( $rt == 'share_taxi' ) {
                    $orv = 'Sammeltaxi';
                } elseif ( $rt == 'tram' ) {
                    $orv = 'Tram';
                } elseif ( $rt == 'bus' ) {
                    $orv = 'Bus';
                } elseif ( $rt == 'monorail' ) {
                    $orv = 'Einschienenbahn';
                } elseif ( $rt == 'ferry' ) {
                    $orv = 'Fähre';
                } elseif ( $rt == 'train' ) {
                    $orv = 'Zug';
                } elseif ( $rt == 'light_rail' ) {
                    $orv = 'Light Rail';
                } elseif ( $rt == 'funicular' ) {
                    $orv = 'Drahtseilbahn';
                } elseif ( $rt == 'subway' ) {
                    $orv = 'U-Bahn';
                } elseif ( $rt == 'aerialway' ) {
                    $orv = 'Seilbahn';
                }
            } else {
                if ( $rt == 'trolleybus' ) {
                    $orv = 'Trolleybus';
                } elseif ( $rt == 'share_taxi' ) {
                    $orv = 'Share Taxi';
                } elseif ( $rt == 'tram' ) {
                    $orv = 'Tram';
                } elseif ( $rt == 'bus' ) {
                    $orv = 'Bus';
                } elseif ( $rt == 'monorail' ) {
                    $orv = 'Monorail';
                } elseif ( $rt == 'ferry' ) {
                    $orv = 'Ferry';
                } elseif ( $rt == 'train' ) {
                    $orv = 'Train';
                } elseif ( $rt == 'light_rail' ) {
                    $orv = 'Light Rail';
                } elseif ( $rt == 'funicular' ) {
                    $orv = 'Funicular';
                } elseif ( $rt == 'subway' ) {
                    $orv = 'Subway';
                } elseif ( $rt == 'aerialway' ) {
                    $orv = 'Aerialway';
                }
            }
        }

        return $orv;
    }


    function HandlePtnaComment( $param ) {
        global $gtfs_strings;
        $string = '';
        if ( is_string($param) ) {
            $string = preg_replace( "/::[A-Z]+::/", "", $param );
        } else {
            if ( isset($param['comment']) && $param['comment'] ) {
                $string = preg_replace( "/::[A-Z]+::/", "", $param['comment'] );
            }
            if ( isset($param['suspicious_start']) && $param['suspicious_start'] ) {
                $string .= "\n" . $gtfs_strings['suspicious_start'] . " '" . $param['suspicious_start'] . "'";
            }
            if ( isset($param['suspicious_end']) && $param['suspicious_end'] ) {
                $string .= "\n" . $gtfs_strings['suspicious_end'] . " '" . $param['suspicious_end'] . "'";
            }
            if ( isset($param['suspicious_number_of_stops']) && $param['suspicious_number_of_stops'] ) {
                $string .= "\n" . $gtfs_strings['suspicious_number_of_stops'] . " '" . $param['suspicious_number_of_stops'] . "'";
            }
            if ( isset($param['suspicious_trip_duration']) && $param['suspicious_trip_duration'] ) {
                $string .= "\n" . $gtfs_strings['suspicious_trip_duration'] . " '" . $param['suspicious_trip_duration'] . "'";
            }
            if ( isset($param['suspicious_other']) && $param['suspicious_other'] ) {
                $string .= "\n" . $gtfs_strings['suspicious_other'] . " '" . $param['suspicious_other'] . "'";
            }
            if ( isset($param['subroute_of']) && $param['subroute_of'] ) {
                $string .= "\n" . $gtfs_strings['subroute_of'] . " " . preg_replace( "/,\s*/",", ", $param['subroute_of'] );
            }
            if ( isset($param['same_names_but_different_ids']) && $param['same_names_but_different_ids'] ) {
                $string .= "\n" . $gtfs_strings['same_names_but_different_ids'] . " " . preg_replace( "/,\s*/",", ", $param['same_names_but_different_ids'] );
            }
            if ( isset($param['same_stops_but_different_shape_ids']) && $param['same_stops_but_different_shape_ids'] ) {
                $string .= "\n" . $gtfs_strings['same_stops_but_different_shape_ids'] . " " . preg_replace( "/,\s*/",", ", $param['same_stops_but_different_shape_ids'] );
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
