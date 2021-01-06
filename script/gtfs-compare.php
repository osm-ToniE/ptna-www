<?php

    if ( $_GET['feed2'] ) {
        $feed2          = $_GET['feed2'];
    } else {
        $feed2          = $_GET['feed'];
    }
    if ( $_GET['release_date2'] ) {
        $release_date2  = $_GET['release_date2'];
    } else {
        $release_date2  = $_GET['release_date'];
    }
    if ( $_GET['route_id2'] ) {
        $route_id2      = $_GET['route_id2'];
    } else {
        $route_id2      = $_GET['route_id'];
    }
    if ( $_GET['trip_id2'] ) {
        $trip_id2       = $_GET['trip_id2'];
    } else {
        $trip_id2       = $_GET['trip_id'];
    }
    if ( $_GET['shape_id2'] ) {
        $shape_id2      = $_GET['shape_id2'];
    } else {
        $shape_id2      = $_GET['shape_id'];
    }


    function CreateCompareFeedsTableHead( $button_text, $feed, $feed2 ) {
        $indent = '                            ';
        if ( $feed == $feed2 ) {
            echo $indent . '<tr><th colspan="3" class="gtfs-name"><button class="button-create" type="submit">' . $button_text . '</button></th</tr>' . "\n";
            echo $indent . '<tr><th colspan="3" class="gtfs-name"><input type="hidden" name="feed"  value="' . $feed  . '">'  . $feed . '</th>' . "\n";
            echo $indent . '</tr>' . "\n";
        } else {
            echo $indent . '<tr><th colspan="4" class="gtfs-name"><button class="button-create" type="submit">' . $button_text . '</button></th</tr>' . "\n";
            echo $indent . '<tr><th colspan="2" class="gtfs-name"><input type="hidden" name="feed"  value="' . $feed  . '">' . $feed  . '</th>' . "\n";
            echo $indent . '    <th colspan="2" class="gtfs-name"><input type="hidden" name="feed2" value="' . $feed2 . '">' . $feed2 . '</th>' . "\n";
            echo $indent . '</tr>' . "\n";
        }
    }


    function CreateCompareFeedsTableBody( $feed, $feed2 ) {
        $indent = '                            ';

        $release_dates  = array();

        if ( $feed && preg_match("/^[a-zA-Z0-9_.-]+$/", $feed) ) {
            $release_dates =GetGtfsFeedReleaseDatesNonEmpty( $feed );
            rsort( $release_dates );
        }

        if ( $feed == $feed2 ) {
            for ( $i = 0; $i < count($release_dates) ; $i++ ) {
                $release_date = $release_dates[$i];
                echo $indent . "<tr>\n";
                if ( $i == 0 ) {
                    echo $indent . '    <td><input type="radio" name="release_date"  value="' . $release_date . '" checked="checked"></td>' . "\n";
                    if ( count($release_dates) == 1 ) {
                        echo $indent . '    <td><input type="radio" name="release_date2" value="' . $release_date . '" checked="checked"></td>' . "\n";
                    } else {
                        echo $indent . '    <td><input type="radio" name="release_date2" value="' . $release_date . '"></td>' . "\n";
                    }
                } elseif ( $i == 1 ) {
                    echo $indent . '    <td><input type="radio" name="release_date"  value="' . $release_date . '"></td>' . "\n";
                    echo $indent . '    <td><input type="radio" name="release_date2" value="' . $release_date . '" checked="checked"></td>' . "\n";
                } else {
                    echo $indent . '    <td><input type="radio" name="release_date"  value="' . $release_date . '"></td>' . "\n";
                    echo $indent . '    <td><input type="radio" name="release_date2" value="' . $release_date . '"></td>' . "\n";
                }
                echo $indent . '    <td class="gtfs-name">' . $release_date . '</td>' . "\n";
                echo $indent . "</tr>\n";
            }
        } else {
            $release_dates2  = array();

            if ( $feed2 && preg_match("/^[a-zA-Z0-9_.-]+$/", $feed2) ) {
                $release_dates2 =GetGtfsFeedReleaseDatesNonEmpty( $feed2 );
                rsort( $release_dates2 );
            }

            $count1 = count($release_dates);
            $count2 = count($release_dates2);
            $maxcount = ($count1 > $count2) ? $count1 : $count2;

            for ( $i = 0; $i < $maxcount ; $i++ ) {
                if ( $i == 0 ) {
                    $checked = ' checked="checked"';
                } else {
                    $checked = '';
                }
                echo $indent . "<tr>\n";
                $release_date1 = $release_dates[$i];
                $release_date2 = $release_dates2[$i];
                if ( $release_date1 ) {
                    echo $indent . '    <td><input type="radio" name="release_date"  value="' . $release_date1 . '"' . $checked . '></td>' . "\n";
                    echo $indent . '    <td class="gtfs-name">' . $release_date1 . '</td>' . "\n";
                } else {
                    echo $indent . "    <td>&nbsp;</td>\n";
                    echo $indent . "    <td>&nbsp;</td>\n";
                }
                if ( $release_date2 ) {
                    echo $indent . '    <td><input type="radio" name="release_date2" value="' . $release_date2 . '"' . $checked . '></td>' . "\n";
                    echo $indent . '    <td class="gtfs-name">' . $release_date2 . '</td>' . "\n";
                } else {
                    echo $indent . "    <td>&nbsp;</td>\n";
                    echo $indent . "    <td>&nbsp;</td>\n";
                }
                echo $indent . "</tr>\n";
            }
        }
    }
?>
