<!DOCTYPE html>
<?php   include( '../script/globals.php'     );
        include( '../script/parse_query.php' );
        include( '../script/queue.php' );
        $lang_dir="../$ptna_lang/";
?>
<html lang="<?php echo $html_lang ?>">

<?php   $title='Analysis Queue'; include $lang_dir.'html-head.inc'; ?>

    <body>

      <div id="wrapper">

<?php   include $lang_dir.'header.inc'; ?>

        <main id="main" class="results">

<?php       $show_contents = 1;
            #echo "<!-- \$_SERVER = \n";
            #print_r( $_SERVER );
            #echo " -->\n";
            if ( isset($_SERVER['HTTP_REFERER']) ) {
                preg_match( '/\/results\/.*\/([0-9A-Za-z_.-]+)-Analysis\.[dif.]*.*html$/', $_SERVER['HTTP_REFERER'], $matches );
                if ( isset($matches[1]) ) {
                    $network = $matches[1];
                    $ret_val = InsertIntoAnalysisQueue( $network );
                    http_response_code( $ret_val['HTTP'] );
                    echo "<!-- \$ret_val = \n";
                    print_r( $ret_val );
                    echo " -->\n";
                    if ( $ret_val['HTTP'] >= 200 && $ret_val['HTTP'] < 300 ) {
                        echo '            <h2 id="request">Your analysis reqeuest for ' . $network . " has been accepted</h2>\n";
                    } else {
                        echo '            <h2 id="request">Your analysis reqeuest for ' . $network . " failed</h2>\n";
                        echo '            <div class="indent">' . "\n";
                        echo '              <p>' . $ret_val['status'] . "</p>\n";
                        echo "            </div>\n";
                        echo "            <hr />\n";
                    }
                } else {
                    preg_match( '/\/(statistics.php)$/',     $_SERVER['HTTP_REFERER'], $matches1 );
                    preg_match( '/\/(results\/queue.php)$/', $_SERVER['HTTP_REFERER'], $matches2 );
                    preg_match( '/(openstreetmap\.org)/',    $_SERVER['HTTP_REFERER'], $matches3 );
                    if ( isset($matches1[1]) || isset($matches2[1]) || isset($matches3[1]) ) {
                        ;
                    } else {
                        $show_contents = 0;
                        http_response_code( 404 );
                        echo '            <h3 id="request">Invalid analysis reqeuest: unknown ' . "'network'" . "</h3>\n";
                        echo "            <hr />\n";
                    }
                }
             }
?>

<?php if ( $show_contents ): ?>
            <h2 id="queue">Contents of analysis queue</h2>
            <div class="indent">
            <a href="/results/queue.php" title="Reload"><button class="button-create" type="button"> Reload </button></a><br />
            <table id="queue-table">
                <thead>
                    <tr class="statistics-tableheaderrow">
                        <th class="statistics-name">Network</th>
                        <th class="statistics-name">State</th>
                        <th class="statistics-date">Queued At</th>
                        <th class="statistics-date">Started At</th>
                        <th class="statistics-date">Finished At</th>
                        <th class="statistics-size">Changes</th>
                        <th class="statistics-date">Logs</th>
                    </tr>
                </thead>
                <tbody>
<?php PrintAnalysisQueue(); ?>
                </tbody>
            </table>

            </div>
<?php endif; ?>

</main> <!-- main -->

        <hr />

<?php include $lang_dir.'footer.inc' ?>

      </div> <!-- wrapper -->
    </body>
</html>
