<?php
    include('../script/globals.php');
    define("PTNA_VERSION",substr(file_get_contents(realpath($path_to_www.'.git/ORIG_HEAD')),0,6));

    date_default_timezone_set('UTC');

    # parse query parameters

    $feed         = isset($_GET['feed'])         ? $_GET['feed']         : '';
    $release_date = isset($_GET['release_date']) ? $_GET['release_date'] : '';
    $route_id     = isset($_GET['route_id'])     ? $_GET['route_id']     : '';
    $trip_id      = isset($_GET['trip_id'])      ? $_GET['trip_id']      : '';

    $gtfs_license               = "Creative Commons Attribution License (cc-by)";
    $gtfs_license_url           = "https://opendefinition.org/licenses/cc-by/";
    $gtfs_feed_publisher_name   = "Münchner Verkehrs- und Tarifverbund GmbH (MVV)";
    $gtfs_feed_publisher_url    = "https://www.mvv-muenchen.de/";
    $gtfs_feed_version          = "2024.0116.1640";
    $gtfs_feed_start_date       = "2023-12-10";
    $gtfs_feed_end_date         = "2024-03-31";
    $gtfs_feed_url              = "https://www.mvv-muenchen.de/fahrplanauskunft/fuer-entwickler/opendata/index.html";

    $elements                   = "";

    header( 'Content-Type: application/json', TRUE, 200 );
    echo '{ "generator" : { "version" : "PTNA API ' . PTNA_VERSION . '", "url" : "https://ptna.openstreetmap.de/api/get-gtfs-data.php", ';
    echo '"params" : { ';
    if ( $feed ) {
        echo ' "feed" : ' . json_encode($feed);
    }
    if ( $release_date ) {
        echo ', "release_date" : ' . json_encode($release_date);
    }
    if ( $route_id ) {
        echo ', "route_id" : ' . json_encode($route_id);
    } elseif ( $trip_id ) {
        echo ', "trip_id" : ' . json_encode($trip_id);
    }
    echo " } },\r\n";
    echo '"feed_info" : { ';
    echo '"feed_version" : ' . json_encode($gtfs_feed_version) . ', ';
    echo '"feed_start_date" : ' . json_encode($gtfs_feed_start_date) . ', ';
    echo '"feed_end_date" : ' . json_encode($gtfs_feed_end_date) . ',';
    echo '"feed_publisher_name" : ' . json_encode($gtfs_feed_publisher_name) . ', "feed_publisher_url" : ' . json_encode($gtfs_feed_publisher_url) . ' },';
    echo '"license" : {  "text" : ' . json_encode($gtfs_license) . ', "url" : ' . json_encode($gtfs_license_url) . "},\r\n";
    echo '"timestamp" : ' . json_encode(date("Y-m-d\TH:i:s\Z")) . ",\r\n";
    echo '"elements" : [ ' . $elements . "] }\r\n";
?>
