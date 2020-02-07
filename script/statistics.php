<?php
    include('../script/config.php');

    $download_total_secs = 0;
    $analysis_total_secs = 0;
    $size_total_files    = [];

    function PrintNetworkStatistics( $network ) {
        global $details_hash;
        global $download_total_secs;
        global $analysis_total_secs;
        global $size_total_files;

        if ( ReadDetails($network) ) {

            $osm_xml_file_name = GetOsmXmlFileName();
            $start_download    = GetStartDownloadDate();
            $end_download      = GetEndDownloadDate();
            $duration_download = 0;
            $size_download     = GetOsmXmlFileSizeByte();
            $start_analysis    = GetStartAnalysisDate();
            $end_analysis      = GetEndAnalysisDate();
            $duration_analysis = 0;
            printf( "<tr class=\"statistics-tablerow\">\n" );
            printf( "    <td class=\"statistics-network\">%s</td>\n",       $network           );
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
                if ( isset($size_total_files[$osm_xml_file_name]) ) {
                    if ( $start_download && $end_download ) {
                        printf( "    <td class=\"statistics-size\">%.1f</td>\n", $size_download / 1024 / 1024 );
                        $size_total_files[$osm_xml_file_name.$start_download] = $size_download;
                    } else {
                        printf( "    <td class=\"statistics-size\">reused</td>\n" );
                    }
                } else {
                    if ( $start_download && $end_download ) {
                        printf( "    <td class=\"statistics-size\">%.1f</td>\n", $size_download / 1024 / 1024 );
                        $size_total_files[$osm_xml_file_name] = $size_download;
                    } else {
                        printf( "    <td class=\"statistics-size\"></td>\n" );
                    }
                }
            } else {
                printf( "    <td class=\"statistics-size\"></td>\n" );
            }
            if ( $start_analysis && $end_analysis ) {
                $sabs                 = strtotime( $start_analysis );
                $eabs                 = strtotime( $end_analysis );
                $duration_analysis    = $eabs - $sabs;
                $analysis_total_secs += $duration_analysis;
                printf( "    <td class=\"statistics-date\">%s</td>\n",          $start_analysis    );
                printf( "    <td class=\"statistics-duration\">%d:%02d</td>\n", $duration_analysis/60, $duration_analysis%60 );
            } else {
                printf( "    <td class=\"statistics-date\"></td>\n");
                printf( "    <td class=\"statistics-duration\"></td>\n" );
            }
            printf( "</tr>\n" );
         }
    }

    function PrintNetworkStatisticsTotals( $count ) {
        global $download_total_secs;
        global $analysis_total_secs;
        global $size_total_files;

        $size_total = 0;
        $file_total = 0;
        
        foreach ( $size_total_files as $file => $size ) {
            $size_total += $size;
            $file_total++;
        }
        printf( "<tr class=\"statistics-tableheaderrow\">\n" );
        printf( "    <th class=\"statistics-network\">networks %d, downloads %d</th>\n", $count, $file_total );
        printf( "    <th class=\"statistics-date\"></th>\n" );
        printf( "    <th class=\"statistics-duration\">%d:%02d:%02d</th>\n", $download_total_secs/3600, ($download_total_secs%3600)/60, $download_total_secs%60 );
        printf( "    <th class=\"statistics-size\">%.1f</th>\n", $size_total / 1024 / 1024 );
        printf( "    <th class=\"statistics-date\"></th>\n" );
        printf( "    <th class=\"statistics-duration\">%d:%02d:%02d</th>\n", $analysis_total_secs/3600, ($analysis_total_secs%3600)/60, $analysis_total_secs%60 );
        printf( "</tr>\n" );
    }

?>

