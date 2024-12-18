<!DOCTYPE html>
<html lang="en">

<?php $title="Analysis Logs"; include('html-head.inc'); ?>

<?php include('../script/statistics.php'); ?>

    <body>

      <div id="wrapper">

<?php include "header.inc" ?>

        <main id="main" class="results">

            <h2 id="logging"><img src="/img/GreatBritain16.png"  class="flagimg" alt="Union Jack" /> Analysis Logs</h2>
            <p>
            </p>

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
                    }
?>
            </pre>

        </main> <!-- main -->

        <hr />

<?php include "footer.inc" ?>

      </div> <!-- wrapper -->
    </body>
</html>
