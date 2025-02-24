<?php
    include('../../script/details.php');

    function PrintAnalysis( $network, $filename, $filepath ) {
        if ( $filename && file_exists($filepath) && filesize($filepath) > 0 ) {
            echo '<td data-ref="'.$network.'-name" class="results-name"><a href="'.$filename.'" title="analysis data">'.$network.'</a></td>';
        } else {
            if ( file_exists($filepath) && filesize($filepath) == 0 ) {
                echo '<td data-ref="'.$network.'-name" class="results-name attention">'.$network.' (see the <a href="/en/showlogs.php?network='.$network.'">log</a> file)</td>';;
            } else {
                echo '<td data-ref="'.$network.'-name" class="results-name">'.$network.'</td>';;
            }
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
            if ( preg_match('/;/',$link) && preg_match('/;/',$name) ) {
                echo '<td data-ref="'.$network.'-network" class="results-network">';
                $name_array = explode( ';', $name );
                $link_array = explode( ';', $link );
                for ( $i = 0; $i < count($name_array); $i++ ) {
                    if ( $i > 0 ) { echo '; '; }
                    if ( $name_array[$i] && $link_array[$i] ) {
                        echo '<a href="'.$link_array[$i].'">'.$name_array[$i].'</a>';
                    } else if ( $name_array[$i] ) {
                        echo $name_array[$i];
                    } else {
                        echo '<a href="'.$link_array[$i].'">'.$link_array[$i].'</a>';
                    }
                }
                echo '</td>';
            } else {
                echo '<td data-ref="'.$network.'-network" class="results-network"><a href="'.$link.'">'.$name.'</a>';
            }
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
    function PrintRoutes( $network, $link, $name, $catalog_file ) {
        echo '<td data-ref="'.$network.'-route" class="results-route">';
        if ( isset($catalog_file) && $catalog_file && file_exists($catalog_file) ) {
            echo '<a href="/en/testcsv.php?network='.$network.'"><img src="/img/Test.svg" width=19 height=19 alt="yes" title="Test GTFS to CSV injection" /></a>&nbsp;';
        }
        if ( $link && $name ) {
            echo '<a href="'.$link.'">'.$name.'</a>';
        } else if ( $name ) {
            echo $name;
        } else {
            echo '&nbsp;';
        }
        echo '</td>';
    }

    function CreateNewFullEntry( $network, $lang, $name ) {
        global $details_hash;
        global $filename_hash;

        ReadDetails( $network );

        echo '<tr class="results-tablerow">';
        echo "\n                        ";
        PrintAnalysis( $network, $filename_hash['ANALYSIS'], $filename_hash['ANALYSISFILEPATH'] );
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
        PrintRoutes( $network, $details_hash['ROUTES_LINK'], $details_hash['ROUTES_NAME'], $filename_hash['CATALOG'] );
        echo "\n";
        echo '                    </tr>' . "\n";
    }
?>
