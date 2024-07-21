<?php
    include('../script/config.php');

    $download_total_secs = 0;
    $analysis_total_secs = 0;
    $size_total_files    = [];
    $count_has_changes   = 0;

    function PrintNetworkStatistics( $network ) {
        global $details_hash;
        global $download_total_secs;
        global $analysis_total_secs;
        global $size_total_files;
        global $count_has_changes;

        if ( ReadDetails($network) ) {

            $osm_xml_file_name = GetOsmXmlFileName();
            $start_download    = GetStartDownloadDate();
            $end_download      = GetEndDownloadDate();
            $duration_download = 0;
            $size_download     = GetOsmXmlFileSizeByte();
            $start_filter      = GetStartFilterDate();
            $end_filter        = GetEndFilterDate();
            $duration_filter = 0;
            $size_extract      = GetOsmPbfFileSizeByte();
            $routes_link       = GetRoutesLink();
            $osm_base          = GetOsmBase();
            $routes_size       = GetRoutesSize();
            $routes_date       = GetRoutesDate();
            $analysis_webpath  = GetHtmlFileWebPath();
            $analysis_filepath = GetHtmlFilePath();
            $start_analysis    = GetStartAnalysisDate();
            $end_analysis      = GetEndAnalysisDate();
            $duration_analysis = 0;
            $has_changes       = HasChanges();
            $html_diff         = GetHtmlDiff();
            $diff_webpath      = GetDiffFileWebPath();
            $tzname            = GetDetailsTZNAME();
            $tzshort           = GetDetailsTZSHORT();
            $utc               = GetDetailsUTC();
            printf( "<tr class=\"statistics-tablerow\">\n" );
            printf( "    <td class=\"statistics-network\">%s</td>\n", $network );
            printf( "    <td class=\"statistics-name\">%s</td>\n",    $utc     );
            printf( "    <td class=\"statistics-name\">%s</td>\n",    $tzshort );
            printf( "    <td class=\"statistics-name\">%s</td>\n",    $tzname  );
            if ( $osm_base ) {
                if ( $start_download ) {
                    $osmbaseabs     = strtotime( $osm_base );
                    $startabs       = strtotime( $start_download );
                    $age_osm_base   = $startabs - $osmbaseabs;
                    if ( $age_osm_base > 3600 ) {
                        printf( "    <td class=\"statistics-date-marked\"><a href=\"/en/showlogs.php?network=%s\" title=\"OSM Data is older than 1 hour at time of download\">%s</a></td>\n", $network, $osm_base );
                    } else {
                        printf( "    <td class=\"statistics-date\">%s</td>\n", $osm_base );
                    }
                } else {
                    printf( "    <td class=\"statistics-date\">%s</td>\n", $osm_base );
                }
            } else {
                printf( "    <td class=\"statistics-date\"></td>\n");
            }
            if ( $start_download && $end_download ) {
                $sabs                 = strtotime( $start_download );
                $eabs                 = strtotime( $end_download );
                $duration_download    = $eabs - $sabs;
                $download_total_secs += $duration_download;
                printf( "    <td class=\"statistics-date\">%s</td>\n",          $start_download    );
                printf( "    <td class=\"statistics-duration\">%d:%02d</td>\n", $duration_download/60, $duration_download%60 );
            } else {
                printf( "    <td class=\"statistics-date\"></td>\n");
                printf( "    <td class=\"statistics-duration\"></td>\n" );
            }
            if ( $osm_xml_file_name && $size_download ) {
                if ( $start_download && $end_download ) {
                    printf( "    <td class=\"statistics-size\">%.3f</td>\n", $size_download / 1024 / 1024 );
                    $size_total_files[$osm_xml_file_name.$start_download] = $size_download;
                } else {
                    if ( $size_extract ) {
                        printf( "    <td class=\"statistics-size\"></td>\n" );
                    } else {
                        printf( "    <td class=\"statistics-size\">reused</td>\n" );
                    }
                }
            } else {
                if ( $osm_xml_file_name && $size_download == 0 ) {
                    printf( "    <td class=\"statistics-size-marked\">Download via Overpass-API failed</td>\n", $network );
                } else {
                    printf( "    <td class=\"statistics-size\"></td>\n" );
                }
            }
            if ( $start_filter && $end_filter ) {
                $sabs                 = strtotime( $start_filter );
                $eabs                 = strtotime( $end_filter );
                $duration_filter      = $eabs - $sabs;
                $filter_total_secs   += $filter_download;
                printf( "    <td class=\"statistics-date\">%s</td>\n",          $start_filter    );
                printf( "    <td class=\"statistics-duration\">%d:%02d</td>\n", $duration_filter/60, $duration_filter%60 );
                printf( "    <td class=\"statistics-size\">%.3f</td>\n",        $size_download / 1024 / 1024 );
            } else {
                printf( "    <td class=\"statistics-date\"></td>\n");
                printf( "    <td class=\"statistics-duration\"></td>\n" );
                printf( "    <td class=\"statistics-size\"></td>\n" );
            }
            if ( $routes_size != '-1') {
                if ( $routes_date ) {
                    if ( $routes_link ) {
                        printf( "    <td class=\"statistics-date\"><a href=\"%s\">%s</a></td>\n", $routes_link, $routes_date );
                    } else {
                        printf( "    <td class=\"statistics-date\">%s</td>\n", $routes_date );
                    }
                } else {
                    printf( "    <td class=\"statistics-date\">Not configured</td>\n");
                }
            } else {
                printf( "    <td class=\"statistics-date-marked\">Download from OSM-Wiki failed</td>\n", $network );
            }
            if ( $start_analysis && $end_analysis ) {
                $sabs                 = strtotime( $start_analysis );
                $eabs                 = strtotime( $end_analysis );
                $duration_analysis    = $eabs - $sabs;
                if ( $duration_analysis == 0 ) {
                    $duration_analysis = 1;
                }
                $analysis_total_secs += $duration_analysis;
                if ( $analysis_webpath && file_exists($analysis_filepath) && filesize($analysis_filepath) > 0 ) {
                    printf( "    <td class=\"statistics-date\"><a href=\"%s\">%s</a></td>\n", $analysis_webpath, $start_analysis );
                } else {
                    if ( file_exists($analysis_filepath) && filesize($analysis_filepath) == 0 ) {
                        printf( "    <td class=\"statistics-date attention\">%s</td>\n", $start_analysis );
                    } else {
                        printf( "    <td class=\"statistics-date\">%s</td>\n", $start_analysis );
                    }
                }
                printf( "    <td class=\"statistics-duration\">%d:%02d</td>\n", $duration_analysis/60, $duration_analysis%60 );
            } else {
                printf( "    <td class=\"statistics-date\"></td>\n");
                printf( "    <td class=\"statistics-duration\"></td>\n" );
            }
            if ( $has_changes && $diff_webpath ) {
                if ( $html_diff > 0 ) {
                    $html_diff_str = $html_diff;
                } else {
                    $html_diff_str = '';
                }
                printf( "    <td class=\"statistics-date\"><a href=\"%s\">%s</a></td>\n", $diff_webpath, $html_diff_str );
                $count_has_changes++;
            } else {
                printf( "    <td class=\"statistics-date\"></td>\n");
            }
            printf( "    <td class=\"statistics-size-name\"><a href=\"/en/showlogs.php?network=%s\" title=\"Log file\">Log</a></td>\n", $network );
            printf( "</tr>\n" );
         }
    }

    function PrintNetworkStatisticsTotals( $count ) {
        global $download_total_secs;
        global $analysis_total_secs;
        global $size_total_files;
        global $count_has_changes;

        $size_total = 0;
        $file_total = 0;

        foreach ( $size_total_files as $file => $size ) {
            $size_total += $size;
            $file_total++;
        }
        printf( "<tr class=\"statistics-tableheaderrow\">\n" );
        printf( "    <th class=\"statistics-network\">%d</th>\n", $count );
        printf( "    <th class=\"statistics-date\"></th>\n" );
        printf( "    <th class=\"statistics-date\"></th>\n" );
        printf( "    <th class=\"statistics-date\"></th>\n" );
        printf( "    <th class=\"statistics-date\"></th>\n" );
        printf( "    <th class=\"statistics-date\">%d</th>\n", $file_total );
        printf( "    <th class=\"statistics-duration\">%d:%02d:%02d</th>\n", $download_total_secs/3600, ($download_total_secs%3600)/60, $download_total_secs%60 );
        printf( "    <th class=\"statistics-size\">%.1f</th>\n", $size_total / 1024 / 1024 );
        printf( "    <th class=\"statistics-date\"></th>\n" );
        printf( "    <th class=\"statistics-duration\"></th>\n" );
        printf( "    <th class=\"statistics-size\"></th>\n" );
        printf( "    <th class=\"statistics-date\"></th>\n" );
        printf( "    <th class=\"statistics-date\"></th>\n" );
        printf( "    <th class=\"statistics-duration\">%d:%02d:%02d</th>\n", $analysis_total_secs/3600, ($analysis_total_secs%3600)/60, $analysis_total_secs%60 );
        printf( "    <th class=\"statistics-date\">%d</th>\n", $count_has_changes );
        printf( "    <th class=\"statistics-name\"></th>\n" );
        printf( "</tr>\n" );
    }

    function PrintNetworkAnalysisLogs( $network ) {
        global $path_to_work;

        $logfilename = $path_to_work . 'log/' . $network . '.log';
        if ( file_exists($logfilename) ) {
            $lines = file( $logfilename, FILE_IGNORE_NEW_LINES  );
            foreach ( $lines as $line ) {
                $line = preg_replace( '/\/osm\/ptna\/work/',   '$WORK_LOC',  $line );
                $line = preg_replace( '/\/osm\/ptna\/www/',    '$WWW_LOC',   $line );
                $line = preg_replace( '/\/osm\/ptna/',         '$PTNA_LOC',  $line );
                $line = preg_replace( '/\/home\/toni\/ptna/',  '$PTNA_PATH', $line );
                $line = preg_replace( '/toni osm/',            'user group', $line );
                $line = preg_replace( '/ uid="[^"]*" /',       ' ',          $line );
                $line = preg_replace( '/ user="[^"]*" /',      ' ',          $line );
                $line = preg_replace( '/ changeset="[^"]*" /', ' ',          $line );
                printf( "%s\n", htmlspecialchars($line) );
            }
        }
    }

    function PrintTimezoneAnalysisLogs( $timezone ) {
        global $path_to_work;

        if ( $timezone ) {
            $logfilename = $path_to_work . 'ptna-cronjob-' . $timezone . '.log';
            if ( file_exists($logfilename) ) {
                $lines = file( $logfilename, FILE_IGNORE_NEW_LINES  );
                foreach ( $lines as $line ) {
                    $line = preg_replace( '/\/osm\/ptna\/work/',   '$WORK_LOC',  $line );
                    $line = preg_replace( '/\/osm\/ptna\/www/',    '$WWW_LOC',   $line );
                    $line = preg_replace( '/\/osm\/ptna/',         '$PTNA_LOC',  $line );
                    $line = preg_replace( '/\/home\/toni\/ptna/',  '$PTNA_PATH', $line );
                    $line = preg_replace( '/toni osm/',            'user group', $line );
                    $line = preg_replace( '/ uid="[^"]*" /',       ' ',          $line );
                    $line = preg_replace( '/ user="[^"]*" /',      ' ',          $line );
                    $line = preg_replace( '/ changeset="[^"]*" /', ' ',          $line );
                    printf( "%s\n", htmlspecialchars($line) );
                }
            }
            $logfilename = $path_to_work . 'log/ptna-all-networks-' . $timezone . '.log';
            if ( file_exists($logfilename) ) {
                $lines = file( $logfilename, FILE_IGNORE_NEW_LINES  );
                foreach ( $lines as $line ) {
                    $line = preg_replace( '/\/osm\/ptna\/work/',   '$WORK_LOC',  $line );
                    $line = preg_replace( '/\/osm\/ptna\/www/',    '$WWW_LOC',   $line );
                    $line = preg_replace( '/\/osm\/ptna/',         '$PTNA_LOC',  $line );
                    $line = preg_replace( '/\/home\/toni\/ptna/',  '$PTNA_PATH', $line );
                    $line = preg_replace( '/toni osm/',            'user group', $line );
                    $line = preg_replace( '/ uid="[^"]*" /',       ' ',          $line );
                    $line = preg_replace( '/ user="[^"]*" /',      ' ',          $line );
                    $line = preg_replace( '/ changeset="[^"]*" /', ' ',          $line );
                    printf( "%s\n", htmlspecialchars($line) );
                }
            }
        }
    }

    function StatisticsPrintServerLoad() {
        $output_array = explode( "\n", shell_exec( "top -bn1" ) );
        foreach ( $output_array as $line ) {
            if ( preg_match("/CPU.s.:/i",$line) ) {
                printf( "%s", $line );
            }
        }
    }

?>
