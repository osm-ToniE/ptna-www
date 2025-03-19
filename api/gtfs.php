<?php
date_default_timezone_set('UTC');
$before = memory_get_usage();

include('../script/globals.php');

if ( isset($_SERVER['SERVER_NAME']) && $_SERVER['SERVER_NAME'] != 'localhost' ) {
    $old_limit = ini_set( "memory_limit", "-1" );
    define("PTNA_VERSION","PTNA " . substr(file_get_contents($path_to_www.'.git/ORIG_HEAD'),0,6));
    define("PTNA_DATE",date("Y-m-d\TH:i:s\Z",filemtime($path_to_www.'.git/ORIG_HEAD')));
    define("PTNA_URL","https://ptna.openstreetmap.de/api/gtfs.php");
} else {
    $old_limit = ini_set( "memory_limit", "-1" );
    define("PTNA_VERSION","PTNA on localhost");
    define("PTNA_DATE",date("Y-m-d\TH:i:s\Z"));
    define("PTNA_URL","localhost/api/gtfs.php");
}

# parse query parameters

$feed         = isset($_GET['feed'])         ? $_GET['feed']         : '';
$release_date = isset($_GET['release_date']) ? $_GET['release_date'] : '';
$route_id     = isset($_GET['route_id'])     ? $_GET['route_id']     : '';
$trip_id      = isset($_GET['trip_id'])      ? $_GET['trip_id']      : '';
$ptna         = isset($_GET['ptna'])         ? true                  : false;

$start_time = gettimeofday(true);

$gtfs_license               = "Creative Commons Attribution License (cc-by)";
$gtfs_license_url           = "https://opendefinition.org/licenses/cc-by/";

$elements                   = "";
$NODE_elements              = array();
$WAY_elements               = array();
$RELATION_elements          = array();

header( 'Content-Type: application/json', true, 200 );

$json_response = array();

$json_response['timestamp'] = date("Y-m-d\TH:i:s\Z");
AddGeneratorInfo();
$json_response['elements']  = array();

if ( $feed ) {
    $SqliteDb = FindGtfsSqliteDb( $feed, $release_date );

    if ( $SqliteDb != '' ) {

        $json_response['generator']['params']['release_date'] = preg_replace('/-ptna.*$/','',preg_replace("/^.*$feed-/",'',$SqliteDb));

        try {
            $db         = new SQLite3( $SqliteDb );

            if ( $ptna ) { AddSingleTableRow( $db, 'ptna' );   }
            if ( $ptna ) { AddSingleTableRow( $db, 'osm' );    }
            AddSingleTableRow( $db, 'feed_info' );
            AddLicenseInfo( $db );

            if ( $route_id != '' ) {
                $route_id_array = array();
                $route_id_array = explode( ';', $route_id );
                foreach ( $route_id_array as $id ) {
                    AddRoute2NodesWaysRelations( $db, $id, $ptna );
                    AddAgencyOfRouteId( $db, $id );
                }
            } elseif ( $trip_id ) {
                AddTrip2NodesWaysRelations( $db, $trip_id, $ptna );
                AddAgencyOfTripId( $db, $trip_id );
            } else {
                AddMultiTableRows( $db, 'agency' );
            }

            AddNodes();
            AddWays();
            AddRelations();

        } catch ( Exception $ex ) {
            $json_response['error'] = sprintf("%s - feed = '%s'",$ex->getMessage(),$feed);
        }
    } else {
        if ( $release_date ) {
            $json_response['error'] = sprintf("Data base for GTFS feed ('%s') not found",$feed);
        } else {
            $json_response['error'] = sprintf("Data base for GTFS feed ('%s') and version ('%s') not found",$feed,$release_date);
        }
    }
} else {
    $json_response['error'] = "Name of GTFS feed not specified: use parameter 'feed'";
}

$duration = gettimeofday(true) - $start_time;
$json_response['duration'] = sprintf("%.6F",$duration);
$after = memory_get_usage();
$json_response['size']     = $after - $before;

echo json_encode( $json_response );

######################
#
#
#
######################

function AddGeneratorInfo() {
    global $json_response;
    $json_response['generator'] = array();
    $json_response['generator']['version'] = PTNA_VERSION;
    $json_response['generator']['date']    = PTNA_DATE;
    $json_response['generator']['url']     = PTNA_URL;
    $json_response['generator']['params']  = array();
    $params_array = array();
    foreach ( array_keys($_GET) as $get_key ) {
        $json_response['generator']['params'][$get_key] = $_GET[$get_key];
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

    if ( $feed_release && preg_match("/^[0-9A-Za-z_.-]+$/", $feed_release) ) {
        $feed_parts = explode( '-', $feed );
        $countrydir = array_shift( $feed_parts );

        $return_path = $path_to_work . $countrydir . '/' . $feed_release . '-ptna-gtfs-sqlite.db';

        if ( file_exists($return_path) ) {
            if ( is_link($return_path) ) {
                $return_path = $path_to_work . $countrydir . '/' . readlink( $return_path );
            }
         }
         if ( !file_exists($return_path) ) {
            $subdir = array_shift( $feed_parts );

            $return_path = $path_to_work . $countrydir . '/' . $subdir . '/' . $feed_release . '-ptna-gtfs-sqlite.db';

            if ( file_exists($return_path) ) {
                if ( is_link($return_path) ) {
                    $return_path = $path_to_work . $countrydir . '/' . $subdir . '/' . readlink( $return_path );
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


function AddSingleTableRow( $db, $table_name ) {
    global $json_response;

    $sql = sprintf( "SELECT name FROM sqlite_master WHERE type='table' AND name='%s';", SQLite3::escapeString($table_name) );

    $sql_master = $db->querySingle( $sql, true );

    if ( isset($sql_master['name']) ) {

        $json_response[$table_name] = array();

        if ( $table_name === 'feed_info' ) {
            $json_response[$table_name]['feed_publisher_name'] = '';
            $json_response[$table_name]['feed_publisher_url'] = '';
            $json_response[$table_name]['feed_lang'] = '';
        }

        $sql = sprintf( "SELECT * FROM %s LIMIT 1;", SQLite3::escapeString($table_name) );

        $result = $db->querySingle( $sql, true );

        foreach ( array_keys($result) as $table_info ) {
            $json_response[$table_name][$table_info] = $result[$table_info];
        }
    }
}

function AddMultiTableRows( $db, $table_name ) {
    global $json_response;

    $sql = sprintf( "SELECT name FROM sqlite_master WHERE type='table' AND name='%s';", SQLite3::escapeString($table_name) );

    $sql_master = $db->querySingle( $sql, true );

    if ( isset($sql_master['name']) ) {

        $json_response[$table_name] = array();
        $info                       = array();

        $sql = sprintf( "SELECT * FROM %s", SQLite3::escapeString($table_name) );

        $result = $db->query( $sql );

        while ( $table_infos=$result->fetchArray(SQLITE3_ASSOC) ) {
            foreach ( array_keys($table_infos) as $table_info ) {
                $info[$table_info] = $table_infos[$table_info];
            }
            array_push( $json_response[$table_name], $info );
        }
    }
}


function AddLicenseInfo( $db ) {
    global $json_response;

    $sql = "SELECT name FROM sqlite_master WHERE type='table' AND name='ptna';";

    $sql_master = $db->querySingle( $sql, true );

    if ( isset($sql_master['name']) ) {

        $json_response['license'] = array();

        $sql = sprintf( "SELECT * FROM ptna" );

        $result = $db->query( $sql );

        while ( $ptna_infos=$result->fetchArray(SQLITE3_ASSOC) ) {
            if ( isset($ptna_infos['original_license'] ) ) {
                $json_response['license']['type'] = $ptna_infos['original_license'];
            }
            if ( isset($ptna_infos['original_license_url'] ) ) {
                $json_response['license']['url'] = $ptna_infos['original_license_url'];
            }
            if ( isset($ptna_infos['license'] ) ) {
                $json_response['license']['use for OSM'] = $ptna_infos['license'];
            }
            if ( isset($ptna_infos['license'] ) ) {
                $json_response['license']['url for OSM'] = $ptna_infos['license_url'];
            }
        }
   }
}


function AddAgencyOfRouteId( $db, $route_id ) {
    global $json_response;
    global $RELATION_elements;

    $json_response['agency'] = array();
    if ( isset($RELATION_elements[$route_id]) ) {
        if ( isset($RELATION_elements[$route_id]['tags'])              &&
             isset($RELATION_elements[$route_id]['tags']['agency_id']) &&
             $RELATION_elements[$route_id]['tags']['agency_id']           ) {
            $sql = sprintf( "SELECT * FROM agency WHERE agency_id='%s' LIMIT 1", SQLite3::escapeString($RELATION_elements[$route_id]['tags']['agency_id']) );
            $agency_infos = $db->querySingle( $sql, true );
            foreach ( array_keys($agency_infos) as $agency_info ) {
                $json_response['agency'][$agency_info] = $agency_infos[$agency_info];
            }
        }
    }
}

function AddAgencyOfTripId( $db, $trip_id ) {
    global $json_response;
    global $RELATION_elements;

    if ( isset($RELATION_elements[$trip_id]) ) {
        if ( isset($RELATION_elements[$trip_id]['tags'])             &&
             isset($RELATION_elements[$trip_id]['tags']['route_id']) &&
             $RELATION_elements[$trip_id]['tags']['route_id']           ) {
            AddAgencyOfRouteId( $db, $RELATION_elements[$trip_id]['tags']['route_id'] );
        }
    }

}


function AddNodes() {
    global $json_response;
    global $NODE_elements;

    foreach ( array_keys($NODE_elements) as $node_info ) {
        array_push( $json_response['elements'], $NODE_elements[$node_info] );
    }
}


function AddWays() {
    global $json_response;
    global $WAY_elements;

    foreach ( array_keys($WAY_elements) as $way_info ) {
        array_push( $json_response['elements'], $WAY_elements[$way_info] );
    }
}


function AddRelations() {
    global $json_response;
    global $RELATION_elements;

    foreach ( array_keys($RELATION_elements) as $relation_info ) {
        array_push( $json_response['elements'], $RELATION_elements[$relation_info] );
    }
}


function AddRoute2NodesWaysRelations( $db, $route_id, $ptna ) {
    global $RELATION_elements;

    AddRouteOnly2Relations( $db, $route_id, $ptna );

    if ( isset($RELATION_elements[$route_id]) ) {
        if ( isset($RELATION_elements[$route_id]['tags'])                    &&
             isset($RELATION_elements[$route_id]['tags']['type'])            &&
                   $RELATION_elements[$route_id]['tags']['type'] === 'route' &&
             isset($RELATION_elements[$route_id]['members'])                    ) {
            foreach ( $RELATION_elements[$route_id]['members'] as $member) {
                if ( isset($member['ref']) && isset($member['type']) && $member['type'] === 'relation' ) {
                    AddTrip2NodesWaysRelations( $db, $member['ref'], $ptna );
                }
            }
        }
    }
}


function AddTrip2NodesWaysRelations( $db, $trip_id, $ptna ) {
    global $NODE_elements;
    global $WAY_elements;
    global $RELATION_elements;

    $return_string            = '';
    $element_array            = array();
    $table_array              = array();
    $member_array             = array();
    $list_separator           = '|';
    $rep_trip_id              = $trip_id;
    $list_trip_ids            = '';
    $list_service_ids         = '';
    $service_id               = '';
    $route_id                 = '';
    $node_string              = '';

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
    $ptna_table = $db->query( $sql );
    while ( $ptna_infos=$ptna_table->fetchArray(SQLITE3_ASSOC) ) {
        if ( isset($ptna_infos['list_separator']) ) {
            $list_separator = $ptna_infos['list_separator'];
        }
    }

    if ( $table_array['ptna_trips'] ) {
        $sql  = sprintf( "SELECT trip_id, list_trip_ids, list_service_ids FROM ptna_trips WHERE (list_trip_ids LIKE '%s%s%%' OR list_trip_ids LIKE '%%%s%s%s%%' OR list_trip_ids LIKE '%%%s%s');",
                          SQLite3::escapeString($trip_id), SQLite3::escapeString($list_separator),
                          SQLite3::escapeString($list_separator), SQLite3::escapeString($trip_id), SQLite3::escapeString($list_separator),
                          SQLite3::escapeString($list_separator), SQLite3::escapeString($trip_id)
                       );
        $trids = $db->query( $sql );
        while ( $trids_info=$trids->fetchArray(SQLITE3_ASSOC) ) {
            if ( isset($trids_info['trip_id']) ) {
                $rep_trip_id = $trids_info['trip_id'];
            }
            if ( isset($trids_info['list_trip_ids']) ) {
                $list_trip_ids = $trids_info['list_trip_ids'];
            }
            if ( isset($trids_info['list_service_ids']) ) {
                $list_service_ids = $trids_info['list_service_ids'];
            }
        }
        if ( $list_trip_ids && $list_service_ids ) {
            # find service_id which fits to this trip_id (not to rep_trip_id)
            $array_trip_ids    = explode( $list_separator, $list_trip_ids    );
            $array_service_ids = explode( $list_separator, $list_service_ids );
            $index             =  array_search( $trip_id, $array_trip_ids );
            $service_id        = $array_service_ids[$index];
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
            array_push( $member_array, [ 'ref'  => $stops_infos['stop_id'],
                                            'role' => 'stop',
                                            'type' => 'node' ]
                        );
            if ( !isset($NODE_elements[$stops_infos['stop_id']])) {
                $tmp_array = array();
                $tmp_array['type'] = 'node';
                $tmp_array['id']   = $stops_infos['stop_id'];
                $tmp_array['lat']  = $stops_infos['stop_lat'];
                $tmp_array['lon']  = $stops_infos['stop_lon'];
                $tmp_array['tags'] = array();
                foreach ( array_keys($stops_infos) as $stops_info ) {
                    $tmp_array['tags'][$stops_info] = $stops_infos[$stops_info];
                }

                if ( $ptna && $table_array['ptna_stops'] ) {
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
                                        $ptna_array['stop_name'] = $ptna_stops_infos[$ptna_stops_info];
                                    } else {
                                        $ptna_array[$ptna_stops_info] = $ptna_stops_infos[$ptna_stops_info];
                                    }
                                }
                            }
                        }
                    }
                    if ( count($ptna_array) ) {
                        $tmp_array['ptna'] = $ptna_array;
                    }
                }
                $NODE_elements[$stops_infos['stop_id']] = $tmp_array;
            }
        }
    }

    if ( count($member_array) > 0 ) {
        $sql = sprintf( "SELECT   *
                         FROM     trips
                         WHERE    trip_id='%s';",
                         SQLite3::escapeString($rep_trip_id)
                    );
        $trips = $db->query( $sql );

        $tags_array = [ 'type' => 'trip' ];
        $shape_id   = '';
        while ( $trips_infos=$trips->fetchArray(SQLITE3_ASSOC) ) {
            foreach ( array_keys($trips_infos) as $trips_info ) {
                if ( $trips_info === 'trip_id' ) {
                    $tags_array['trip_id'] = $trip_id;
                } else if ( $trips_info === 'service_id' ) {
                    if ( $service_id ) {
                        $tags_array['service_id'] = $service_id;
                    }
                } else if ( $trips_infos[$trips_info] ) {
                    $tags_array[$trips_info] = $trips_infos[$trips_info];
                }
                if ( $trips_info === 'shape_id' ) {
                    $shape_id = $trips_infos[$trips_info];
                }
                if ( $trips_info === 'route_id' ) {
                    $route_id = $trips_infos[$trips_info];
                }
            }
        }

        if ( $shape_id ) {
            $sql = sprintf( "SELECT   *
                             FROM     shapes
                             WHERE    shape_id='%s' ORDER BY CAST (shape_pt_sequence AS INTEGER) ASC;",
                             SQLite3::escapeString($shape_id)
                          );
            $shapes = $db->query( $sql );

            $shape_node_array = array();
            while ( $shapes_infos=$shapes->fetchArray(SQLITE3_ASSOC) ) {
                if ( isset($shapes_infos['shape_pt_lat']) && isset($shapes_infos['shape_pt_lon']) && isset($shapes_infos['shape_pt_sequence']) ) {
                    $id = $shape_id.'-'.$shapes_infos['shape_pt_sequence'];
                    if ( !isset($NODE_elements[$id])) {
                        $tmp_array = array();
                        $tmp_array['type']  = 'node';
                        $tmp_array['id']    = $id;
                        $tmp_array['lat']   = $shapes_infos['shape_pt_lat'];
                        $tmp_array['lon']   = $shapes_infos['shape_pt_lon'];
                        $NODE_elements[$id] = $tmp_array;
                    }
                    array_push( $shape_node_array, $shape_id.'-'.$shapes_infos['shape_pt_sequence'] );
                }
            }
            if ( count($shape_node_array) > 0 ) {
                array_push( $member_array, [ 'ref'  => $shape_id, 'role' => '', 'type' => 'way' ] );
                if ( !isset($WAY_elements[$shape_id])) {
                    $tmp_array = array();
                    $tmp_array['type']       = 'way';
                    $tmp_array['id']         = $shape_id;
                    $tmp_array['nodes']      = $shape_node_array;
                    $WAY_elements[$shape_id] = $tmp_array;
                }
            }
        }
        if ( !isset($RELATION_elements[$trip_id])) {
            $tmp_array = array();
            $tmp_array['type']           = 'relation';
            $tmp_array['id']             = $trip_id;
            $tmp_array['members']        = $member_array;
            $tmp_array['tags']           = $tags_array;
            if ( $ptna && isset($table_array['ptna_trips']) && isset($table_array['ptna_trips_comments']) ) {
                $sql = sprintf( "SELECT    ptna_trips_comments.*, ptna_trips.rides
                                 FROM      ptna_trips
                                 LEFT JOIN ptna_trips_comments ON ptna_trips.trip_id = ptna_trips_comments.trip_id
                                 WHERE     ptna_trips.trip_id='%s';",
                                 SQLite3::escapeString($rep_trip_id)
                              );
                $trips = $db->query( $sql );

                $ptna_array = array();
                while ( $trips_infos=$trips->fetchArray(SQLITE3_ASSOC) ) {
                    foreach ( array_keys($trips_infos) as $trips_info ) {
                        if ( $trips_info != "trip_id" ) {
                            if ( $trips_infos[$trips_info] ) {
                                $ptna_array[$trips_info] = $trips_infos[$trips_info];
                            }
                        }
                    }
                }
                if ( count($ptna_array) ) {
                    $tmp_array['ptna'] = $ptna_array;
                }
            }
            $RELATION_elements[$trip_id] = $tmp_array;
        }

        if ( $route_id != '' ) {
            AddRouteOnly2Relations( $db, $route_id, $ptna );
        }
    }
}


function AddRouteOnly2Relations( $db, $route_id, $ptna ) {
    global $RELATION_elements;

    if ( !isset($RELATION_elements[$route_id])) {
        $table_array              = array();
        $sql = "SELECT name FROM sqlite_master WHERE type='table';";

        $sql_master = $db->query( $sql );

        while ( $table_infos=$sql_master->fetchArray(SQLITE3_ASSOC) ) {
            if ( $table_infos['name'] == 'ptna_routes' ) {
                $table_array['ptna_routes'] = true;
            }
            if ( $table_infos['name'] == 'ptna_routes_comments' ) {
                $table_array['ptna_routes_comments'] = true;
            }
        }

        $tmp_array         = array();
        $tmp_array['type'] = 'relation';
        $tmp_array['id']   = $route_id;

        $sql = sprintf( "SELECT   trip_id
                         FROM     trips
                         WHERE    route_id='%s';",
                         SQLite3::escapeString($route_id)
                      );
        $trips = $db->query( $sql );

        $member_array = array();
        while ( $trips_infos=$trips->fetchArray(SQLITE3_ASSOC) ) {
            foreach ( array_keys($trips_infos) as $trips_info ) {
                array_push( $member_array, [ 'ref'  => $trips_infos[$trips_info], 'role' => '', 'type' => 'relation' ] );
            }
        }

        $sql = sprintf( "SELECT   *
                         FROM     routes
                         WHERE    route_id='%s';",
                         SQLite3::escapeString($route_id)
                      );
        $route = $db->query( $sql );

        while ( $route_infos=$route->fetchArray(SQLITE3_ASSOC) ) {
            foreach ( array_keys($route_infos) as $route_info ) {
                $tags_array[$route_info] = $route_infos[$route_info];
            }
        }
        if ( sizeof($member_array) && sizeof($tags_array) ) {
            $tags_array[ 'type']          = 'route';
            $tmp_array['members']         = $member_array;
            $tmp_array['tags']            = $tags_array;
            $RELATION_elements[$route_id] = $tmp_array;
        }
    }
}

?>
