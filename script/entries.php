<?php
    $path_to_work  = '/osm/ptna/work/';
    $details_hash  = [];
    $filename_hash = [];

    function ReadDetails( $network ) {
        global $path_to_work;
        global $details_hash;
        global $filename_hash;

        $prefixparts = explode( '-', $network );
        $countrydir  = array_shift( $prefixparts );
        if ( count($prefixparts) > 1 ) {
            $subdir = array_shift( $prefixparts );
            $details_filename  = $path_to_work . $countrydir . '/' . $subdir . '/' . $network . '-Analysis-details.txt';
            $analysis_filename = $subdir . '/' . $network . '-Analysis.html';
            $diff_filename     = $subdir . '/' . $network . '-Analysis.diff.html';
        } else {
            $details_filename  = $path_to_work . $countrydir . '/' . $network . '-Analysis-details.txt';
            $analysis_filename = $network . '-Analysis.html';
            $diff_filename     = $network . '-Analysis.diff.html';
        }

        $details_hash = [];
        $details_hash['OLD_OR_NEW'] = 'old';
        if ( file_exists($details_filename) ) {
            $lines = file( $details_filename, FILE_IGNORE_NEW_LINES|FILE_SKIP_EMPTY_LINES  );
            foreach ( $lines as $line ) {
                list($key,$value)    = explode( '=', $line, 2 );
                $key                 = rtrim(ltrim($key));
                $details_hash[$key]  = rtrim(ltrim($value));
            }
        }
        $filename_hash = [];
        $filename_hash['DETAILS']  = $details_filename;
        $filename_hash['ANALYSIS'] = $analysis_filename;
        $filename_hash['DIFF']     = $diff_filename;
    }
    function PrintAnalysis( $network, $filename ) {
        if ( $filename && file_exists($filename) ) {
            echo '<td data-ref="'.$network.'-name" class="results-name"><a href="'.$filename.'" title="analysis data">'.$network.'</a></td>';
        } else {
            echo '<td data-ref="'.$network.'-name" class="results-name">'.$network.'</td>';;
        }
    }
    function PrintRegion( $network, $link, $name ) {
        if ( $link && $name ) {
            echo '<td data-ref="'.$network.'-region" class="results-region"><a href="'.$link.'" title="show on map">'.$name.'</a></td>';
        } else if ( $name ) {
            echo '<td data-ref="'.$network.'-region" class="results-region">'.$name.'</td>';
        } else {
            echo '<td data-ref="'.$network.'-region" class="results-region">&nbsp;</td>';
        }
    }
    function PrintNetwork( $network, $link, $name ) {
        if ( $link && $name ) {
            echo '<td data-ref="'.$network.'-network" class="results-network"><a href="'.$link.'">'.$name.'</a></td>';
        } else if ( $name ) {
            echo '<td data-ref="'.$network.'-network" class="results-network">'.$name.'</td>';
        } else {
            echo '<td data-ref="'.$network.'-network" class="results-network">&nbsp;</td>';
        }
    }
    function PrintNewDate ( $network, $time_utc, $time_local ) {
        if ( $time_utc && $time_local ) {
            echo '<td data-ref="'.$network.'-datadate" class="results-datadate"><time datetime="'.$time_utc.'">'.$time_local.'</time></td>';
        } else {
            echo '<td data-ref="'.$network.'-datadate" class="results-datadate">&nbsp;</td>';
        }
    }
    function PrintOldDate ( $network, $time_utc, $time_local, $old_or_new, $filename ) {
        if ( $time_utc && $time_local && $old_or_new && $filename && file_exists($filename) ) {
            echo '<td data-ref="'.$network.'-analyzed" class="results-analyzed-'.$old_or_new.'"><a href="'.$filename.'" title="show changes"><time datetime="'.$time_utc.'">'.$time_local.'</time></a></td>';
        } else {
            echo '<td data-ref="'.$network.'-analyzed" class="results-analyzed-old">&nbsp;</time></a></td>';
        }
    }
    function PrintDiscussion( $network, $link, $name ) {
        if ( $link && $name ) {
            echo '<td data-ref="'.$network.'-discussion" class="results-discussion"><a href="'.$link.'" title="in OSM Wiki">'.$name.'</a></td>';
        } else if ( $name ) {
            echo '<td data-ref="'.$network.'-discussion" class="results-discussion">'.$name.'</td>';
        } else {
            echo '<td data-ref="'.$network.'-discussion" class="results-discussion">&nbsp;</td>';
        }
    }
    function PrintRoutes( $network, $link, $name ) {
        if ( $link && $name ) {
            echo '<td data-ref="'.$network.'-route" class="results-route"><a href="'.$link.'">'.$name.'</a></td>';
        } else if ( $name ) {
            echo '<td data-ref="'.$network.'-route" class="results-route">'.$name.'</td>';
        } else {
            echo '<td data-ref="'.$network.'-route" class="results-route">&nbsp;</td>';
        }
    }

    function CreateEntry( $network ) {
        global $details_hash;
        global $filename_hash;

        ReadDetails( $network );

        PrintNewDate( $network, $details_hash['NEW_DATE_UTC'], $details_hash['NEW_DATE_LOC'] );
        echo "\n                        ";
        PrintOldDate( $network, $details_hash['OLD_DATE_UTC'], $details_hash['OLD_DATE_LOC'], $details_hash['OLD_OR_NEW'], $filename_hash['DIFF'] );
        echo "\n";
    }

    function CreateFullEntry( $network ) {
        global $details_hash;
        global $filename_hash;

        ReadDetails( $network );

        echo '<tr class="results-tablerow">';
        echo "\n                        ";
        PrintAnalysis( $network, $filename_hash['ANALYSIS'] );
        echo "\n                        ";
        PrintRegion( $network, $details_hash['REGION_LINK'], $details_hash['REGION_NAME'] );
        echo "\n                        ";
        PrintNetwork( $network, $details_hash['NETWORK_LINK'], $details_hash['NETWORK_NAME'] );
        echo "\n                        ";
        PrintNewDate( $network, $details_hash['NEW_DATE_UTC'], $details_hash['NEW_DATE_LOC'] );
        echo "\n                        ";
        PrintOldDate( $network, $details_hash['OLD_DATE_UTC'], $details_hash['OLD_DATE_LOC'], $details_hash['OLD_OR_NEW'], $filename_hash['DIFF'] );
        echo "\n                        ";
        PrintDiscussion( $network, $details_hash['DISCUSSION_LINK'], $details_hash['DISCUSSION_NAME'] );
        echo "\n                        ";
        PrintRoutes( $network, $details_hash['ROUTES_LINK'], $details_hash['ROUTES_NAME'] );
        echo "\n";
        echo '                    </tr>' . "\n";
    }
?>

