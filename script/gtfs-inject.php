<?php
    include('../script/config.php');

    if ( isset($_SERVER['SERVER_NAME']) && $_SERVER['SERVER_NAME'] != 'localhost' ) {
        $path_to_bin      = '/home/toni/ptna/bin';
    } else {
        $path_to_bin      = '/home/toni/Develop/OSM/ptna/bin';
    }

    $temp_routes_csv_txt        = '';
    $temp_routes_csv_injected   = '';
    $temp_routes_read           = '';
    $temp_routes_inject         = '';
    $wiki_routes_page           = '';
    $catalog_file               = '';
    $error_string               = '';

    function PerformInjection( $network ) {
        global $path_to_bin;
        global $path_to_tmp;
        global $details_hash;
        global $filename_hash;
        global $temp_routes_csv_txt;
        global $temp_routes_csv_injected;
        global $temp_routes_read;
        global $temp_routes_inject;
        global $wiki_routes_page;
        global $error_string;
        $ret = true;

        if ( ReadDetails($network) ) {
            $wiki_routes_page          = preg_replace( '/^.*\/wiki\//', '', GetRoutesLink() );
            $temp_routes_csv_txt       = $path_to_tmp . $network . '-Routes-temp.txt';
            $temp_routes_csv_injected  = $path_to_tmp . $network . '-Routes-injected.txt';
            $temp_routes_read          = $path_to_tmp . $network . '-Routes-read.log';
            $temp_routes_inject        = $path_to_tmp . $network . '-Routes-inject.log';
            $catalog_file              = $filename_hash['CATALOG'];

            if ( file_exists($catalog_file) )
            {
                $shell_command  = "$path_to_bin/ptna-wiki-page.pl --pull --page=$wiki_routes_page --file=$temp_routes_csv_txt > $temp_routes_read 2>&1";
                $shell_response = shell_exec( $shell_command );

                if ( $temp_routes_csv_txt && file_exists($temp_routes_csv_txt) ) {
                    $shell_command  = "$path_to_bin/ptnaFillCsvData.py --show-hidden-variables --routes $catalog_file --template $temp_routes_csv_txt --outfile $temp_routes_csv_injected > $temp_routes_inject 2>&1";
                    $shell_response = shell_exec( $shell_command );
                } else {
                    $error_string = "Error: excecuting 'read from Wiki' command for page '" . $wiki_routes_page . "' : " . $shell_response;
                    $ret = false;
                }
            } else {
                $error_string = "Nothing to inject, catalog file '$network-catalog.json' does not extis";
                $ret = false;
            }
        }

        return $ret;
    }

    function PrintInjectionResult() {
        global $temp_routes_csv_injected;

        if ( $temp_routes_csv_injected && file_exists($temp_routes_csv_injected) ) {
            $lines = file( $temp_routes_csv_injected, FILE_IGNORE_NEW_LINES  );
            printf( "<pre>\n" );
            foreach ( $lines as $line ) {
                if ( preg_match('/^\s*@/',$line) ) {
                    printf( "<strong class=\"attention\">%s</strong>\n", htmlspecialchars($line) );
                } else {
                    printf( "%s\n", htmlspecialchars($line) );
                }
            }
            printf( "</pre>\n" );
        }
    }

    function PrintInjectionLogs( $type ) {
        global $temp_routes_csv_txt;
        global $temp_routes_csv_injected;
        global $temp_routes_read;
        global $temp_routes_inject;
        global $error_string;
        $filename = '';

        if ( $type ) {
            if ( $type == 'errors' ) {
                printf( "%s\n", htmlspecialchars($error_string) );
            } elseif ( $type == 'read' ) {
                $filename = $temp_routes_read;
            } elseif ( $type == 'inject' ) {
                $filename = $temp_routes_inject;
            }
            if ( $filename && file_exists($filename) ) {
                $lines = file( $filename, FILE_IGNORE_NEW_LINES  );
                printf( "<pre>\n");
                foreach ( $lines as $line ) {
                    $line = preg_replace( '/\/osm\/ptna\/work/',   '$WORK_LOC',  $line );
                    $line = preg_replace( '/\/osm\/ptna\/www/',    '$WWW_LOC',   $line );
                    $line = preg_replace( '/\/osm\/ptna/',         '$PTNA_LOC',  $line );
                    $line = preg_replace( '/\/home\/.*?ptna/',     '$PTNA_PATH', $line );
                    $line = preg_replace( '/\/home\/.*?gtfs/',     '$GTFS_PATH', $line );
                    $line = preg_replace( '/\/home\/.*?bin/',      '~/bin',      $line );
                    $line = preg_replace( '/toni osm/',            'user group', $line );
                    $line = preg_replace( '/ uid="[^"]*" /',       ' ',          $line );
                    $line = preg_replace( '/ user="[^"]*" /',      ' ',          $line );
                    $line = preg_replace( '/ changeset="[^"]*" /', ' ',          $line );
                    $line = preg_replace( '/ toni /',              ' user ',     $line );
                    printf( "%s\n", htmlspecialchars($line) );
                }
                printf( "</pre>\n");
            }
        }
    }

    function DeleteTempFiles() {
        global $temp_routes_csv_txt;
        global $temp_routes_csv_injected;
        global $temp_routes_read;
        global $temp_routes_inject;

        if ( $temp_routes_csv_txt && file_exists($temp_routes_csv_txt) ) {
            unlink( $temp_routes_csv_txt );
        }
        if ( $temp_routes_csv_injected && file_exists($temp_routes_csv_injected) ) {
            unlink( $temp_routes_csv_injected );
        }
        #if ( $temp_routes_read && file_exists($temp_routes_read) ) {
        #    unlink( $temp_routes_read );
        #}
        if ( $temp_routes_inject && file_exists($temp_routes_inject) ) {
            unlink( $temp_routes_inject );
        }
    }

?>
