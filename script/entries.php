<?php
    include('../../script/details.php');

    function PrintAnalysis( $network, $filename ) {
        if ( $filename && file_exists($filename) ) {
            echo '<td data-ref="'.$network.'-name" class="results-name"><a href="'.$filename.'" title="analysis data">'.$network.'</a></td>';
        } else {
            echo '<td data-ref="'.$network.'-name" class="results-name">'.$network.'</td>';;
        }
    }
    function PrintRegion( $network, $link, $name ) {
        if ( $link && $name ) {
            $link_array = explode( '=', $link, 2 );
            if ( count($link_array) > 1 ) {
                echo '<td data-ref="'.$network.'-region" class="results-region"><a href="'.$link_array[0].'='.urlencode(urldecode($link_array[1])).'" title="show on map">'.$name.'</a></td>';
            } else {
                echo '<td data-ref="'.$network.'-region" class="results-region"><a href="'.$link.'" title="show on map">'.$name.'</a></td>';
            }

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
            echo '<td data-ref="'.$network.'-analyzed" class="results-analyzed-old">&nbsp;</td>';
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
    function PrintConfiguration( $network, $lang, $name ) {
        if (  isset($network) ) { $network = urlencode($network); }
        if ( !isset($lang) )    { $lang    = 'en'; }
        if ( !isset($name) )    { $name    = 'Configuration'; }
        echo '<td data-ref="'.$network.'-discussion" class="results-discussion"><a href="/'.$lang.'/config.php?network='.$network.'">'.$name.'</a></td>';
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

    function CreateNewFullEntry( $network, $lang, $name ) {
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
        PrintConfiguration( $network, $lang, $name );
        echo "\n                        ";
        PrintRoutes( $network, $details_hash['ROUTES_LINK'], $details_hash['ROUTES_NAME'] );
        echo "\n";
        echo '                    </tr>' . "\n";
    }
?>

