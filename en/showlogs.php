<!DOCTYPE html>
<html lang="en">

<?php if ( isset($_GET['gtfs']) && $_GET['gtfs'] ) { $title="GTFS Update Logs"; } else { $title="Analysis Logs"; } include('html-head.inc'); ?>

<?php include('../script/statistics.php'); ?>

    <body>

      <div id="wrapper">

<?php include "header.inc" ?>

        <main id="main" class="results">

<?php if ( isset($_GET['gtfs']) && $_GET['gtfs'] ) { ?>
            <h2 id="logging"><img src="/img/GreatBritain16.png"  class="flagimg" alt="Union Jack" /> GTFS Update Logs</h2>
<?php } else { ?>
            <h2 id="logging"><img src="/img/GreatBritain16.png"  class="flagimg" alt="Union Jack" /> Analysis Logs</h2>
<?php } ?>
            <pre>
<?php
                    if ( isset($network) && $network ) {
                        PrintNetworkAnalysisLogs( $network );
                    } elseif ( isset($_GET['timezone']) && $_GET['timezone'] ) {
                        $timezone = preg_replace('/ /', '+', $_GET['timezone'] );
                        PrintTimezoneAnalysisLogs( $timezone );
                    } elseif ( isset($_GET['planet']) && $_GET['planet'] ) {
                        $timezone = preg_replace('/ /', '+', $_GET['planet'] );
                        PrintPlanetAnalysisLogs( $timezone );
                    } elseif ( isset($_GET['continent']) && $_GET['continent'] ) {
                        PrintContinentAnalysisLogs( $_GET['continent'] );
                    } elseif ( isset($_GET['queue']) && $_GET['queue'] ) {
                        PrintQueueLogs( $_GET['queue'] );
                    } elseif ( isset($_GET['gtfs']) && $_GET['gtfs'] ) {
                        PrintGtfsLogs( $_GET['gtfs'] );
                    }
?>
            </pre>

        </main> <!-- main -->

        <hr />

<?php include "footer.inc" ?>

      </div> <!-- wrapper -->
    </body>
</html>
