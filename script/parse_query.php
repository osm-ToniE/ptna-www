<?php

    # parse query parameters for language related things

    $lang  = $_GET['lang'];
    if ( !$lang ) {

        $lang = 'en';

        # now guess from URL

        if ( preg_match('/\/DE\//', $_SERVER['REQUEST_URI']) ||
             preg_match('/\/CH\//', $_SERVER['REQUEST_URI']) ||
             preg_match('/\/LI\//', $_SERVER['REQUEST_URI'])       ) {
            $lang = 'de';
        } elseif ( preg_match('/\/FR\//', $_SERVER['REQUEST_URI']) ) {
            $lang = 'fr';
        } elseif ( preg_match('/\/BR\//', $_SERVER['REQUEST_URI']) ) {
            $lang = 'pt_BR';
        } elseif ( preg_match('/\/DK\//', $_SERVER['REQUEST_URI']) ) {
            $lang = 'da';
        } elseif ( preg_match('/\/RS\//', $_SERVER['REQUEST_URI']) ) {
            $lang = 'sr';
        } elseif ( preg_match('/\/HR\//', $_SERVER['REQUEST_URI']) ) {
            $lang = 'hr';
        } elseif ( preg_match('/\/BO\//', $_SERVER['REQUEST_URI']) ||
                   preg_match('/\/CO\//', $_SERVER['REQUEST_URI']) ||
                   preg_match('/\/ES\//', $_SERVER['REQUEST_URI']) ||
                   preg_match('/\/NI\//', $_SERVER['REQUEST_URI'])    ) {
            $lang = 'es';
        }
    } elseif ( !preg_match("/^[a-zA-Z0-9_-]+$/", $lang)) {
        echo "<!-- override lang from '" . htmlspecialchars($lang) . "' to 'en' -->\n";
        $lang = 'en';
    }
    $html_lang = preg_replace( '/_/', '-', $lang );
    $ptna_lang = $lang;


    # parse query parameters for GTFS-Analysis and perform some conversion: 'network' for backward compatibility

    $feed = $_GET['feed'];
    if ( $feed ) {
        $network      = $feed;
        $release_date = $_GET['release_date'];
        if ( $release_date ) {
            $network = $feed .'-' . $release_date;
        }
    } else {
        $network = $_GET['network'];
        if ( $network ) {
            $feed     = preg_replace( '/-previous.*$/',  '',          $network );
            $feed     = preg_replace( '/-long-term.*$/', '',          $feed );
            $feed     = preg_replace( '/-\d\d\d\d-\d\d-\d\d.*$/', '', $feed );
            if ( $feed != $network ) {
                $release_date = preg_replace( '/^.*-(previous|long-term|\d\d\d\d-\d\d-\d\d).*$/', '\\1', $network );
            }
        }
    }
    $route_id = $_GET['route_id'];
    $trip_id  = $_GET['trip_id'];
    $shape_id = $_GET['shape_id'];
?>
