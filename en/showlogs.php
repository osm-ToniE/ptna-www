<!DOCTYPE html>
<html lang="en">

<?php $title="Analysis Logs"; include('html-head.inc'); ?>

<?php include('../script/statistics.php'); ?>

    <body>

      <div id="wrapper">

<?php include "header.inc" ?>

        <main id="main" class="results">

            <h2 id="logging"><img src="/img/GreatBritain16.png" alt="Union Jack" /> Analysis Logs</h2>
            <p>
            </p>

            <pre>
<?php
                    if ( isset($_GET['network']) ) {
                        PrintNetworkAnalysisLogs( $_GET['network'] );
                    }
?>
            </pre>

        </main> <!-- main -->

        <hr />

<?php include "footer.inc" ?>

      </div> <!-- wrapper -->
    </body>
</html>
