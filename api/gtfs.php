<?php
date_default_timezone_set('UTC');

include('../script/globals.php');

if ( isset($_SERVER['SERVER_NAME']) && $_SERVER['SERVER_NAME'] != 'localhost' ) {
    define("PTNA_VERSION",substr(file_get_contents($path_to_www.'.git/ORIG_HEAD'),0,6));
    define("PTNA_DATE",date("Y-m-d\TH:i:s\Z",filemtime($path_to_www.'.git/ORIG_HEAD')));
} else {
    define("PTNA_VERSION","on localhost");
    define("PTNA_DATE",date("Y-m-d\TH:i:s\Z"));
}

# parse query parameters

$feed         = isset($_GET['feed'])         ? $_GET['feed']         : '';
$release_date = isset($_GET['release_date']) ? $_GET['release_date'] : '';
$route_id     = isset($_GET['route_id'])     ? $_GET['route_id']     : '';
$trip_id      = isset($_GET['trip_id'])      ? $_GET['trip_id']      : '';
$full         = isset($_GET['full'])         ? true                  : false;

$gtfs_license               = "Creative Commons Attribution License (cc-by)";
$gtfs_license_url           = "https://opendefinition.org/licenses/cc-by/";

$elements                   = "";

header( 'Content-Type: application/json', true, 200 );
echo "{\r\n";
echo '    "timestamp" : ' . json_encode(date("Y-m-d\TH:i:s\Z")) . ",\r\n";
FillGeneratorInfo();

$start_time = gettimeofday(true);

if ( $feed ) {
    $SqliteDb = FindGtfsSqliteDb( $feed, $release_date );

    if ( $SqliteDb != '' ) {

        try {
            $db         = new SQLite3( $SqliteDb );

            if ( $full ) { FillTableInfo( $db, 'osm' );    }
                           FillTableInfo( $db, 'feed_info' );
            if ( $full ) { FillTableInfo( $db, 'agency' ); }
            FillLicense( $db );

            if ( $route_id ) {
                $elements = FillRouteElements( $db, $route_id, $full );
            } elseif ( $trip_id ) {
                $elements = FillTripElements( $db, $trip_id, $full );
            }

        } catch ( Exception $ex ) {
            echo '    "error" : ' . json_encode(sprintf("%s - feed = '%s'",$ex->getMessage(),$feed)) . ",\r\n";
        }
    } else {
        echo '    "error" : ' . json_encode(sprintf("Data base for GTFS feed ('%s') not found",$feed)) . ",\r\n";
    }
} else {
    echo '    "error" : "Name of GTFS feed not specified: use parameter \'feed\'",' . "\r\n";
}
$duration = gettimeofday(true) - $start_time;
echo '    "duration" : '. json_encode(sprintf("%.6F",$duration)) . ",\r\n";
echo '    "elements" : ' . "[ " . $elements . "\r\n    ]\r\n}\r\n";


######################
#
#
#
######################
function FillGeneratorInfo() {
    echo '    "generator" : { "version" : "PTNA ' . PTNA_VERSION . '", "date" : "' . PTNA_DATE . '", "url" : "https://ptna.openstreetmap.de/api/gtfs.php", ';
    echo '"params" : { ';
    $params_array = array();
    foreach ( array_keys($_GET) as $get_key ) {
        array_push( $params_array, json_encode($get_key) . ' : '. json_encode($_GET[$get_key]) );
    }
    echo implode(', ', $params_array );
    echo " } },\r\n";
}


function FindGtfsSqliteDb( $feed, $release_date ) {
    global $path_to_work;

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
        return $return_path;
    } else {
        return '';
    }
}


function FillTableInfo( $db, $table_name ) {

    $sql = sprintf( "SELECT name FROM sqlite_master WHERE type='table' AND name='%s';", SQLite3::escapeString($table_name) );

    $sql_master = $db->querySingle( $sql, true );

    if ( isset($sql_master['name']) ) {

        $sql = sprintf( "SELECT * FROM %s", SQLite3::escapeString($table_name) );

        $result = $db->query( $sql );

        $json_out_array = array();

        echo '    ' . json_encode($table_name) . ' : [ ';
        while ( $table_infos=$result->fetchArray(SQLITE3_ASSOC) ) {
            $json_row_array = array();
            foreach ( array_keys($table_infos) as $table_info ) {
                array_push( $json_row_array, json_encode($table_info) . ' : ' . json_encode($table_infos[$table_info]) );
            }
            array_push( $json_out_array, '{ ' . implode( ', ', $json_row_array ) . ' }' );
        }
        echo implode( ', ', $json_out_array );
        echo " ],\r\n";
    }
}


function FillLicense( $db ) {

    $sql = "SELECT name FROM sqlite_master WHERE type='table' AND name='ptna';";

    $sql_master = $db->querySingle( $sql, true );

    if ( isset($sql_master['name']) ) {

        $sql = sprintf( "SELECT * FROM ptna" );

        $result = $db->query( $sql );

        $license_array = array();

        echo '    "license" : { ';
        while ( $ptna_infos=$result->fetchArray(SQLITE3_ASSOC) ) {
            if ( isset($ptna_infos['original_license'] ) ) {
                array_push( $license_array, '"type" : ' . json_encode($ptna_infos['original_license']) );
            }
            if ( isset($ptna_infos['original_license_url'] ) ) {
                array_push( $license_array, '"url" : ' . json_encode($ptna_infos['original_license_url']) );
            }
            if ( isset($ptna_infos['license'] ) ) {
                array_push( $license_array, '"use for OSM" : ' . json_encode($ptna_infos['license']) );
            }
            if ( isset($ptna_infos['license'] ) ) {
                array_push( $license_array, '"url for OSM" : ' . json_encode($ptna_infos['license_url']) );
            }
        }
        echo implode( ', ', $license_array );
        echo " },\r\n";
    }
}


function FillRouteElements( $db, $route_id, $full ) {

    $sql = "SELECT name FROM sqlite_master WHERE type='table' AND name='ptna_route';";

    $sql_master = $db->querySingle( $sql, true );

    if ( isset($sql_master['name']) ) {

        $sql = sprintf( "SELECT * FROM ptna_route" );

        $result = $db->query( $sql );

        $element_array = array();

        return implode( ', ', $element_array );
    }
}


function FillTripElements( $db, $trip_id, $full ) {

    $return_string            = '';
    $element_array            = array();
    $table_array              = array();
    $member_array             = array();
    $list_separator           = '|';
    $rep_trip_id              = $trip_id;

    $sql = "SELECT name FROM sqlite_master WHERE type='table';";

    $sql_master = $db->query( $sql );

    while ( $table_infos=$sql_master->fetchArray(SQLITE3_ASSOC) ) {
        if ( $table_infos['name'] == 'ptna_trips' ) {
            $table_array['ptna_trips'] = true;
        }
        if ( $table_infos['name'] == 'ptna_stops' ) {
            $table_array['ptna_stops'] = true;
        }
        if ( $table_infos['name'] == 'ptna_trips_comments' ) {
            $table_array['ptna_trips_comments'] = true;
        }
        if ( $table_infos['name'] == 'shapes' ) {
            $table_array['shapes'] = true;
        }
    }

    $sql  = sprintf( "SELECT * FROM ptna;" );
    $ptna = $db->query( $sql );
    while ( $ptna_infos=$ptna->fetchArray(SQLITE3_ASSOC) ) {
        if ( isset($ptna_infos['list_separator']) ) {
            $list_separator = $ptna_infos['list_separator'];
        }
    }

    if ( $table_array['ptna_trips'] ) {
        $sql  = sprintf( "SELECT trip_id FROM ptna_trips WHERE (list_trip_ids LIKE '%s%s%%' OR list_trip_ids LIKE '%%%s%s%s%%' OR list_trip_ids LIKE '%%%s%s');",
                          SQLite3::escapeString($trip_id), SQLite3::escapeString($list_separator),
                          SQLite3::escapeString($list_separator), SQLite3::escapeString($trip_id), SQLite3::escapeString($list_separator),
                          SQLite3::escapeString($list_separator), SQLite3::escapeString($trip_id)
                       );
        $trids = $db->query( $sql );
        while ( $trids_info=$trids->fetchArray(SQLITE3_ASSOC) ) {
            if ( isset($trids_info['trip_id']) ) {
                $rep_trip_id = $trids_info['trip_id'];
            }
        }
    }

    $sql = sprintf( "SELECT   stops.*
                     FROM     stops
                     JOIN     stop_times ON stop_times.stop_id = stops.stop_id
                     WHERE    stop_times.trip_id='%s'
                     ORDER BY CAST (stop_times.stop_sequence AS INTEGER) ASC;",
                     SQLite3::escapeString($rep_trip_id)
                  );
    $stops = $db->query( $sql );

    while ( $stops_infos=$stops->fetchArray(SQLITE3_ASSOC) ) {
        if ( isset($stops_infos['stop_id']) &&  isset($stops_infos['stop_lat']) &&  isset($stops_infos['stop_lon']) &&
                (!isset($stops_infos['location_type']) || $stops_infos['location_type'] == '' || $stops_infos['location_type'] == 0) ) {
            $node_string  = "\r\n{ ";
            $node_string .= '"type" : "node", ';
            $node_string .= '"id" : ' . json_encode($stops_infos['stop_id']) . ', ';
            $node_string .= '"lat" : ' . json_encode($stops_infos['stop_lat']) . ', ';
            $node_string .= '"lon" : ' . json_encode($stops_infos['stop_lon']) . ', ';
            $node_string .= '"tags" : { ';
            $tags_array = array();
            foreach ( array_keys($stops_infos) as $stops_info ) {
                if ( $stops_infos[$stops_info] ) {
                    array_push( $tags_array, json_encode($stops_info) . ' : ' . json_encode($stops_infos[$stops_info]) );
                }
            }
            $node_string .= implode( ', ', $tags_array );

            if ( $table_array['ptna_stops'] ) {
                $sql = sprintf( "SELECT   *
                                 FROM     ptna_stops
                                 WHERE    stop_id='%s';",
                                 SQLite3::escapeString($stops_infos['stop_id'])
                            );
                $ptna_stops = $db->query( $sql );
                $ptna_array = array();
                while ( $ptna_stops_infos=$ptna_stops->fetchArray(SQLITE3_ASSOC) ) {
                    foreach ( array_keys($ptna_stops_infos) as $ptna_stops_info ) {
                        if ( $ptna_stops_info != "stop_id" ) {
                            if ( $ptna_stops_infos[$ptna_stops_info] ) {
                                if ( $ptna_stops_info == 'normalized_stop_name' ) {
                                    array_push( $ptna_array, json_encode('stop_name') . ' : ' . json_encode($ptna_stops_infos[$ptna_stops_info]) );
                                } else {
                                    array_push( $ptna_array, json_encode($ptna_stops_info) . ' : ' . json_encode($ptna_stops_infos[$ptna_stops_info]) );
                                }
                            }
                        }
                    }
                }
                if ( count($ptna_array) > 0 ) {
                    $node_string .= '}, "ptna" : { ';
                    $node_string .= implode( ', ', $ptna_array );
                }
            }
            $node_string .= ' } }';
            array_push( $member_array, '    { "ref" : ' . json_encode($stops_infos['stop_id']) . ', "role" : "stop", "type" : "node" }' );
        }
        array_push( $element_array, $node_string );
    }

    if ( count($member_array) > 0 ) {
        $sql = sprintf( "SELECT   *
                         FROM     trips
                         WHERE    trip_id='%s';",
                         SQLite3::escapeString($rep_trip_id)
                    );
        $trips = $db->query( $sql );

        $tags_array = array();
        array_push( $tags_array, '"type" : "trip"' );
        $shape_id   = '';
        while ( $trips_infos=$trips->fetchArray(SQLITE3_ASSOC) ) {
            foreach ( array_keys($trips_infos) as $trips_info ) {
                if ( $trips_infos[$trips_info] ) {
                    array_push( $tags_array, json_encode($trips_info) . ' : ' . json_encode($trips_infos[$trips_info]) );
                } elseif ( $trips_info == 'trip_id' ) {
                    array_push( $tags_array, json_encode($trips_info) . ' : ' . json_encode($trip_id) );
                }
                if ( $trips_info == 'shape_id' ) {
                    $shape_id = $trips_infos[$trips_info];
                }
            }
        }

        if ( $full && $shape_id ) {
            $sql = sprintf( "SELECT   *
                             FROM     shapes
                             WHERE    shape_id='%s' ORDER BY CAST (shape_pt_sequence AS INTEGER) ASC;",
                             SQLite3::escapeString($shape_id)
                          );
            $shapes = $db->query( $sql );

            $shape_node_array = array ();
            while ( $shapes_infos=$shapes->fetchArray(SQLITE3_ASSOC) ) {
                if ( isset($shapes_infos['shape_pt_lat']) && isset($shapes_infos['shape_pt_lon']) && isset($shapes_infos['shape_pt_sequence']) ) {
                    $node_string  = "\r\n{ ";
                    $node_string .= '"type" : "node", ';
                    $node_string .= '"id" : ' . json_encode($shape_id.'-'.$shapes_infos['shape_pt_sequence']) . ', ';
                    $node_string .= '"lat" : ' . json_encode($shapes_infos['shape_pt_lat']) . ', ';
                    $node_string .= '"lon" : ' . json_encode($shapes_infos['shape_pt_lon']);
                    $node_string .= ' }';
                    array_push( $element_array, $node_string );
                    array_push( $shape_node_array, json_encode($shape_id.'-'.$shapes_infos['shape_pt_sequence']) );
                }
            }
            if ( count($shape_node_array) > 0 ) {
                array_push( $member_array, '    { "ref" : ' . json_encode($shape_id) . ', "role" : "", "type" : "way" }' );
                $way_string  = "\r\n{ ";
                $way_string .= '"type" : "way", ';
                $way_string .= '"id" : ' . json_encode($shape_id) . ', ';
                $way_string .= '"nodes" : [ ' . implode( ', ', $shape_node_array );
                $way_string .= " ] }";
                array_push( $element_array, $way_string );
            }
        }
        $return_string  = implode( ', ', $element_array );
        $return_string .= ",\r\n{ ";
        $return_string .= '"type" : "relation", ';
        $return_string .= '"id" : ' . json_encode($trip_id) . ', ';
        $return_string .= '"members" : [ ';
        $return_string .= implode( ', ', $member_array );
        $return_string .= ' ], ';
        $return_string .= '"tags" : { ';

        $return_string .= implode( ', ', $tags_array );

        if ( isset($table_array['ptna_trips_comments']) ) {
            $sql = sprintf( "SELECT   *
                            FROM     ptna_trips_comments
                            WHERE    trip_id='%s';",
                            SQLite3::escapeString($rep_trip_id)
                        );
            $trips = $db->query( $sql );

            $ptna_array = array();
            while ( $trips_infos=$trips->fetchArray(SQLITE3_ASSOC) ) {
                foreach ( array_keys($trips_infos) as $trips_info ) {
                    if ( $trips_info != "trip_id" ) {
                        if ( $trips_infos[$trips_info] ) {
                            array_push( $ptna_array, json_encode($trips_info) . ' : ' . json_encode($trips_infos[$trips_info]) );
                        }
                    }
                }
            }
            if ( count($ptna_array) > 0 ) {
                $return_string .= '}, "ptna" : { ';
                $return_string .= implode( ', ', $ptna_array );
            }
        }

        $return_string .= '} }';
    }

    return $return_string;
}

?>
