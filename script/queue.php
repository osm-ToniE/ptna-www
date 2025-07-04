<?php

    include('../script/config.php');

    function FindAnalysisQueueSqliteDb() {
        global $path_to_work;

        $return_path = $path_to_work . 'ptna-analysis-queue-sqlite.db';

        if ( file_exists($return_path) && filesize($return_path) ) {
            return $return_path;
        } else {
            return '';
        }
    }


    function InsertIntoAnalysisQueue( $network ) {

        $return_array = array( 'HTTP' => 404, 'status' => "Not Found", 'queued' => '', 'started' => '', 'ip' => '' );

        if ( $network && preg_match("/^[0-9A-Za-z_.-]+$/",$network) ) {

            $SqliteDb = FindAnalysisQueueSqliteDb();

            if ( $SqliteDb != '' ) {

                try {

                    $db  = new SQLite3( $SqliteDb );

                    $sql    = "BEGIN TRANSACTION";
                    $result = $db->exec( $sql );

                    $sql    = "SELECT COUNT(*) AS num FROM queue WHERE status='queued';";
                    $result = $db->querySingle( $sql, true );
                    if ( $result['num'] < 10 ) {
                        $sql    = sprintf( "SELECT COUNT(*) AS num  FROM queue WHERE network='%s' AND status='queued';",  $network );
                        $result = $db->querySingle( $sql, true );
                        if ( $result['num'] == 0 ) {
                            $sql    = sprintf( "SELECT COUNT(*) AS num FROM queue WHERE network='%s' AND status='started';", $network );
                            $result = $db->querySingle( $sql, true );
                            if ( $result['num'] == 0 ) {
                                $when = time();
                                if ( isset($_SERVER['REMOTE_ADDR']) ) {
                                    $ip = $_SERVER['REMOTE_ADDR'];
                                } else {
                                    $ip = 'unknown';
                                }
                                $sql  = sprintf( "INSERT INTO queue (network,status,queued,ip) VALUES ('%s','%s',%d,'%s');", $network, 'queued', $when, $ip );
                                $db->querySingle( $sql, true );
                                $return_array['HTTP']   = 202;
                                $return_array['status'] = 'In Queue';
                                $return_array['queued'] =  $when;
                                $return_array['ip']     =  $ip;
                            } else {
                                $return_array['HTTP']    = 429;
                                $return_array['status']  = 'Is Already Running';
                            }
                        } else {
                            $return_array['HTTP']   = 429;
                            $return_array['status'] = 'Already In Queue';
                        }
                    } else {
                        $return_array['HTTP']   = 429;
                        $return_array['status'] = 'Queue Is Full';
                    }
                    $sql    = "COMMIT TRANSACTION";
                    $result = $db->exec( $sql );
                    $db->close();
                } catch ( Exception $ex ) {
                    $return_array['HTTP']   = 500;
                    $return_array['status'] = "Server Error '" . $ex . "'";
                }
            } else {
                $return_array['HTTP']   = 404;
                $return_array['status'] = 'Queue Not Found';
            }
        }

        return $return_array;
    }


    function PrintAnalysisQueue() {

        $SqliteDb = FindAnalysisQueueSqliteDb();

        if ( $SqliteDb != '' ) {

            try {

                $db  = new SQLite3( $SqliteDb );

                $sql    = "BEGIN TRANSACTION";
                $result = $db->exec( $sql );

                $sql    = "SELECT * FROM queue ORDER BY queued DESC;";
                $result = $db->query( $sql );
                if ( $result ) {
                    while ( $queue_infos=$result->fetchArray(SQLITE3_ASSOC) ) {
                        ReadDetails($queue_infos['network']);
                        printf( "<tr class=\"statistics-tablerow\">\n" );
                        $htmlwebpath=GetHtmlFileWebPath();
                        if ( $queue_infos['status'] == 'finished' && $htmlwebpath ) {
                            printf( "    <td class=\"statistics-name\"><a href=\"%s\" title=\"Report File\">%s</a></td>\n", $htmlwebpath, $queue_infos['network'] );
                        } else {
                            printf( "    <td class=\"statistics-name\">%s</td>\n", $queue_infos['network'] );
                        }
                        printf( "    <td class=\"statistics-name\">%s</td>\n", $queue_infos['status']   );
                        if ( $queue_infos['queued'] ) {
                            printf( "    <td class=\"statistics-date\">%s UTC</td>\n", date("Y-m-d H:i:s",$queue_infos['queued']) );
                        } else {
                            printf( "    <td class=\"statistics-date\">&nbsp;</td>\n" );
                        }
                        if ( $queue_infos['started'] ) {
                            printf( "    <td class=\"statistics-date\">%s UTC</td>\n", date("Y-m-d H:i:s",$queue_infos['started']) );
                        } else {
                            printf( "    <td class=\"statistics-date\">&nbsp;</td>\n" );
                        }
                        if ( $queue_infos['finished'] ) {
                            printf( "    <td class=\"statistics-date\">%s UTC</td>\n", date("Y-m-d H:i:s",$queue_infos['finished']) );
                        } else {
                            printf( "    <td class=\"statistics-date\">&nbsp;</td>\n" );
                        }
                        if ( $queue_infos['status'] == 'finished' ) {
                            $diffwebpath=GetDiffFileWebPath();
                            if ( $diffwebpath ) {
                                printf( "    <td class=\"statistics-size\"><a href=\"%s\" title=\"Diff File\">%d</a></td>\n", $diffwebpath, $queue_infos['changes'] );
                            } else {
                                printf( "    <td class=\"statistics-size\">%d</td>\n", $queue_infos['changes'] );
                            }
                        } else if ( $queue_infos['status'] == 'outdated' ) {
                            printf( "    <td class=\"statistics-size\">%d</td>\n", $queue_infos['changes'] );
                        } else {
                            printf( "    <td class=\"statistics-size\">&nbsp;</td>\n" );
                        }
                        if ( $queue_infos['status'] == 'started' || $queue_infos['status'] == 'finished' ) {
                            printf( "    <td class=\"statistics-name\"><a href=\"/en/showlogs.php?network=%s\" title=\"Log file\">logs</td>\n", $queue_infos['network'] );
                        } else if ( $queue_infos['status'] == 'locked' ) {
                            printf( "    <td class=\"statistics-name\">Another analysis for this 'network' was already running when this one was ready to be started</td>\n" );
                        } else {
                            printf( "    <td class=\"statistics-name\">&nbsp;</td>\n" );
                        }
                        printf( "</tr>\n" );
                    }
                }
                $sql    = "COMMIT TRANSACTION";
                $result = $db->exec( $sql );
                $db->close();
            } catch ( Exception $ex ) {
                printf( "<tr class=\"statistics-tablerow\">\n" );
                printf( "    <td class=\"statistics-name\" colspan=7>Server Error: %s</td>\n", $ex );
                printf( "</tr>\n" );
            }
        } else {
            printf( "<tr class=\"statistics-tablerow\">\n" );
            printf( "    <td class=\"statistics-name\" colspan=7>Queue Not Found</td>\n" );
            printf( "</tr>\n" );
        }
    }

?>
