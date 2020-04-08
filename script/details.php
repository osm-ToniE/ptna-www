<?php
    $path_to_work  = '/osm/ptna/work/';
    $path_to_www   = '/osm/ptna/www/';
    $details_hash  = [];
    $filename_hash = [];

    function ReadDetails( $network ) {
        global $path_to_work;
        global $path_to_www;
        global $details_hash;
        global $filename_hash;

        $entries_found = 0;

        $prefixparts = explode( '-', $network );
        $countrydir  = array_shift( $prefixparts );
        if ( count($prefixparts) > 1 ) {
            $subdir = array_shift( $prefixparts );
            $details_filename  = $path_to_work . $countrydir . '/' . $subdir . '/' . $network . '-Analysis-details.txt';
            $analysis_filename = $subdir . '/' . $network . '-Analysis.html';
            $diff_filename     = $subdir . '/' . $network . '-Analysis.diff.html';
            $diff_webpath      = "/results/" . $countrydir . '/' . $diff_filename;
        } else {
            $details_filename  = $path_to_work . $countrydir . '/' . $network . '-Analysis-details.txt';
            $analysis_filename = $network . '-Analysis.html';
            $diff_filename     = $network . '-Analysis.diff.html';
            $diff_webpath      = "/results/" . $countrydir . '/' . $diff_filename;
        }

        $details_hash = [];
        $details_hash['OLD_OR_NEW'] = 'old';
        if ( file_exists($details_filename) ) {
            $lines = file( $details_filename, FILE_IGNORE_NEW_LINES|FILE_SKIP_EMPTY_LINES  );
            foreach ( $lines as $line ) {
                list($key,$value)    = explode( '=', $line, 2 );
                $key                 = rtrim(ltrim($key));
                $details_hash[$key]  = rtrim(ltrim($value));
                $entries_found++;
            }
        }
        $filename_hash = [];
        $filename_hash['DETAILS']     = $details_filename;
        $filename_hash['ANALYSIS']    = $analysis_filename;
        $filename_hash['DIFF']        = $diff_filename;
        $filename_hash['DIFFWEBPATH'] = $diff_webpath;

        return $entries_found;
    }
?>

