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
                    if ( isset($network) ) {
                        PrintNetworkAnalysisLogs( $network );
                    } else if ( isset($_GET['timezone']) && $_GET['timezone']) {
                        PrintTimezoneAnalysisLogs( $_GET['timezone'] );
                    }
?>
            </pre>

        </main> <!-- main -->

        <hr />

<?php include "footer.inc" ?>

      </div> <!-- wrapper -->
    </body>
</html>
