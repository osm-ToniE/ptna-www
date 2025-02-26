<?php

    # parse query parameters for language related things

    $lang = 'en';

    if ( isset($_GET['lang'])                              &&
         preg_match("/^[a-zA-Z0-9_-]+$/", $_GET['lang'])   &&
         is_dir($path_to_www.$_GET['lang'])                &&
         is_file($path_to_www.$_GET['lang'].'/header.inc')    ) {
        $lang = $_GET['lang'];
    } else {
        $lang = 'en';

        # now guess from URL

        if ( preg_match('/\/AT\//', $_SERVER['REQUEST_URI']) ||
             preg_match('/\/CH\//', $_SERVER['REQUEST_URI']) ||
             preg_match('/\/DE\//', $_SERVER['REQUEST_URI']) ||
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
        } elseif ( preg_match('/\/NO\//', $_SERVER['REQUEST_URI']) ) {
            $lang = 'no';
        } elseif ( preg_match('/\/PL\//', $_SERVER['REQUEST_URI']) ) {
            $lang = 'pl_PL';
        } elseif ( preg_match('/\/RS\//', $_SERVER['REQUEST_URI']) ) {
            $lang = 'sr';
        } elseif ( preg_match('/\/EE\//', $_SERVER['REQUEST_URI']) ) {
            $lang = 'et';
        } elseif ( preg_match('/\/NL\//', $_SERVER['REQUEST_URI']) ) {
            $lang = 'nl';
        } elseif ( preg_match('/\/SE\//', $_SERVER['REQUEST_URI']) ) {
            $lang = 'sv';
        } elseif ( preg_match('/\/BO\//', $_SERVER['REQUEST_URI']) ||
                   preg_match('/\/CO\//', $_SERVER['REQUEST_URI']) ||
                   preg_match('/\/CL\//', $_SERVER['REQUEST_URI']) ||
                   preg_match('/\/ES\//', $_SERVER['REQUEST_URI']) ||
                   preg_match('/\/NI\//', $_SERVER['REQUEST_URI'])    ) {
            $lang = 'es';
        }
    }
    $html_lang = preg_replace( '/_/', '-', $lang );
    $ptna_lang = $lang;


    # parse query parameters for GTFS-Analysis and perform some conversion: 'network' for backward compatibility

    $feed = (isset($_GET['feed']) && preg_match('/^[0-9A-Za-z_.-]+$/',$_GET['feed'])) ? $_GET['feed'] : '';
    if ( $feed ) {
        $network      = $feed;
        $release_date = (isset($_GET['release_date']) && preg_match('/^[0-9-]+$/',$_GET['release_date'])) ? $_GET['release_date'] : '';
        if ( $release_date ) {
            $network = $feed .'-' . $release_date;
        }
    } else {
        $network = (isset($_GET['network']) && preg_match('/^[0-9A-Za-z_.-]+$/',$_GET['network'])) ? $_GET['network'] : '';
        if ( $network ) {
            $feed     = preg_replace( '/-previous.*$/',  '',          $network );
            $feed     = preg_replace( '/-long-term.*$/', '',          $feed );
            $feed     = preg_replace( '/-\d\d\d\d-\d\d-\d\d.*$/', '', $feed );
            if ( $feed != $network ) {
                $release_date = preg_replace( '/^.*-(previous|long-term|\d\d\d\d-\d\d-\d\d).*$/', '\\1', $network );
            } else {
                $release_date = '';
            }
        } else {
            $feed = '';
            $release_date = '';
        }
    }
    $route_id = isset($_GET['route_id']) ? $_GET['route_id'] : '';
    $trip_id  = isset($_GET['trip_id'])  ? $_GET['trip_id']  : '';
    $shape_id = isset($_GET['shape_id']) ? $_GET['shape_id'] : '';
?>
