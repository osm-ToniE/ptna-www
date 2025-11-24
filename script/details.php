<?php
    $path_to_work     = '/osm/ptna/work/';
    $path_to_www      = '/osm/ptna/www/';
    $path_to_tmp      = '/osm/ptna/work/tmp/';
    $path_to_networks = '/osm/ptna/ptna-networks/';
    $details_hash     = [];
    $filename_hash    = [];

    function ReadDetails( $network ) {
        global $path_to_work;
        global $path_to_www;
        global $details_hash;
        global $filename_hash;

        $entries_found = 0;

        if ( preg_match( '/^[0-9A-Za-z_.-]+$/',$network) ) {
            $prefixparts = explode( '-', $network );
            $countrydir  = array_shift( $prefixparts );
            if ( count($prefixparts) > 1 ) {
                $subdir = array_shift( $prefixparts );
                $catalog_filename  = $path_to_work . $countrydir . '/' . $subdir . '/' . $network . '-catalog.json';
                $wikicsv_filename  = $path_to_work . $countrydir . '/' . $subdir . '/' . $network . '-Routes.txt';
                $details_filename  = $path_to_work . $countrydir . '/' . $subdir . '/' . $network . '-Analysis-details.txt';
                $analysis_filename = $subdir . '/' . $network . '-Analysis.html';
                $diff_filename     = $subdir . '/' . $network . '-Analysis.diff.html';
                $analysis_webpath  = "/results/" . $countrydir . '/' . $analysis_filename;
                $diff_webpath      = "/results/" . $countrydir . '/' . $diff_filename;
            } else {
                $catalog_filename  = $path_to_work . $countrydir . '/' . $network . '-catalog.json';
                $wikicsv_filename  = $path_to_work . $countrydir . '/' . $network . '-Routes.txt';
                $details_filename  = $path_to_work . $countrydir . '/' . $network . '-Analysis-details.txt';
                $analysis_filename = $network . '-Analysis.html';
                $diff_filename     = $network . '-Analysis.diff.html';
                $analysis_webpath  = "/results/" . $countrydir . '/' . $analysis_filename;
                $diff_webpath      = "/results/" . $countrydir . '/' . $diff_filename;
            }
            $analysis_filepath = $path_to_www  . $analysis_webpath;

            $details_hash = [];
            $details_hash['REGION_LINK']  = '';
            $details_hash['REGION_NAME']  = '';
            $details_hash['NETWORK_LINK'] = '';
            $details_hash['NETWORK_NAME'] = '';
            $details_hash['NEW_DATE_UTC'] = '';
            $details_hash['NEW_DATE_LOC'] = '';
            $details_hash['OLD_DATE_UTC'] = '';
            $details_hash['OLD_DATE_LOC'] = '';
            $details_hash['OLD_OR_NEW']   = 'old';
            $details_hash['ROUTES_LINK']  = '';
            $details_hash['ROUTES_NAME']  = '';
            $details_hash['ROUTES_SIZE']  = 0;
            $details_hash['ROUTES_RET']   = 0;
            $details_hash['ERROR_MISSING_DATA']   = 0;
            $details_hash['ERROR_GETID_NOTFOUND'] = 0;
            $details_hash['lang'] = 'en';
            if ( file_exists($details_filename) ) {
                $lines = file( $details_filename, FILE_IGNORE_NEW_LINES|FILE_SKIP_EMPTY_LINES  );
                foreach ( $lines as $line ) {
                    if ( preg_match("/=/",$line) ) {
                        list($key,$value)    = explode( '=', $line, 2 );
                        $key                 = rtrim(ltrim($key));
                        $details_hash[$key]  = rtrim(ltrim($value));
                        $entries_found++;
                    }
                }
            }
            $filename_hash = [];
            $filename_hash['CATALOG']           = $catalog_filename;
            $filename_hash['WIKICSV']           = $wikicsv_filename;
            $filename_hash['DETAILS']           = $details_filename;
            $filename_hash['ANALYSIS']          = $analysis_filename;
            $filename_hash['ANALYSISFILEPATH']  = $analysis_filepath;
            $filename_hash['ANALYSISWEBPATH']   = $analysis_webpath;
            $filename_hash['DIFF']              = $diff_filename;
            $filename_hash['DIFFWEBPATH']       = $diff_webpath;
        }

        return $entries_found;
    }
?>
