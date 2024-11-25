<!DOCTYPE html>
<html lang="en">

<?php $title="Statistics"; include('html-head.inc'); ?>

<?php
    include('../script/parse_query.php');
    include('../script/statistics.php');
    ?>

    <body>
      <script src="/script/sort-table.js"></script>
      <script> // Run sortTable.init() when the page loads - disabled in sort-table.js for race-condition reasons
                window.addEventListener
                    ? window.addEventListener('load', sortTable.init, false)
                    : window.attachEvent && window.attachEvent('onload', sortTable.init)
                    ;
      </script>

    <div id="wrapper">

<?php include "header.inc" ?>

        <main id="main" class="results">

            <h2 id="statistics"><img src="/img/GreatBritain16.png"  class="flagimg" alt="Union Jack" /> Statistics</h2>
            <p>
                Server Load: <code><?php StatisticsPrintServerLoad();?></code><br />
                Disk Load:   <code><?php StatisticsPrintDiskLoad();?></code>
            </p>

            <hr />

            Cron jobs for analysis queue:
            <a href="/results/queue.php" title="Show analysis queue">Analysis Queue</a>
            <a href="showlogs.php?queue=analysis-queue" title="Show logs for analysis queue handling">Logs of analysis queue</a>

            <hr />

            Cron jobs for Continents:
            <a href="showlogs.php?continent=africa-europe" title="Show logs for planet handling: Africa, Europe, Israel">Africa, Europe, Israel @ 02:15</a>

            <hr />

            Planet update, filter, and extracts:
            <a href="showlogs.php?planet=UTC%2B03" title="Show logs for planet handling: Africa, Europe, Israel">Africa, Europe, Israel: UTC+03, UTC+02, UTC+01, UTC+00</a>

            <hr />

            Supported timezones (wintertime):
            <a href="showlogs.php?timezone=UTC%2B10"    title="Show logs for timezone UTC+10 (AU-NSW)">UTC+10</a>
            <a href="showlogs.php?timezone=UTC%2B09.30" title="Show logs for timezone UTC+09.30 (AU-SA)">UTC+09.30</a>
            <a href="showlogs.php?timezone=UTC%2B05.30" title="Show logs for timezone UTC+05.30 (IN)">UTC+05.30</a>
            <a href="showlogs.php?timezone=UTC%2B04"    title="Show logs for timezone UTC+04 (FR-974)">UTC+04</a>
            <a href="showlogs.php?timezone=UTC%2B03.30" title="Show logs for timezone UTC+03.30 (IR)">UTC+03.30</a>
            <a href="showlogs.php?timezone=UTC%2B03"    title="Show logs for timezone UTC+03 (ET, MG)">UTC+03</a>
            <a href="showlogs.php?timezone=UTC%2B02"    title="Show logs for timezone UTC+02 (BG, EE, IL)">UTC+02</a>
            <a href="showlogs.php?timezone=UTC%2B01"    title="Show logs for timezone UTC+01 (AT, CH, CZ, DE, DK, ES, EU, FR, HR, IT, LI, LU, MA, NL, NO, PL, RS, SI)">UTC+01</a>
            <a href="showlogs.php?timezone=UTC%2B00"    title="Show logs for timezone UTC+00 (GB, GH, MR)">UTC+00</a>
            <a href="showlogs.php?timezone=UTC-03"      title="Show logs for timezone UTC-03 (AR, BR)">UTC-03</a>
            <a href="showlogs.php?timezone=UTC-04"      title="Show logs for timezone UTC-04 (BO, CA-NB, CL">UTC-04</a>
            <a href="showlogs.php?timezone=UTC-05"      title="Show logs for timezone UTC-05 (CA-ON, CA-QC, CO, PA, US-MA, US-NY, US-RI, US-TN)">UTC-05</a>
            <a href="showlogs.php?timezone=UTC-06"      title="Show logs for timezone UTC-06 (CA-MB, NI, US-IL, US-IN, US-WI)">UTC-06</a>
            <a href="showlogs.php?timezone=UTC-07"      title="Show logs for timezone UTC-07 (US-UT)">UTC-07</a>
            <a href="showlogs.php?timezone=UTC-08"      title="Show logs for timezone UTC-08 (US-CA, US-Amtrak, US-Flixbus)">UTC-08</a>
            <a href="showlogs.php?timezone=UTC-09"      title="Show logs for timezone UTC-09 (US-AK)">UTC-09</a>

            <hr />

            <table id="message-table" class="js-sort-table">
                <thead>
<?php include 'statistics-trth.inc' ?>
                </thead>
                <tbody>
<?php $network_array = GetAllNetworks();

      foreach ( $network_array as $network ) {
          PrintNetworkStatistics( $network );
      }
?>
                </tbody>
                <tfoot>
<?php PrintNetworkStatisticsTotals( count($network_array) ); ?>
                </tfoot>
            </table>

        </main> <!-- main -->

        <hr />

<?php include "footer.inc" ?>

      </div> <!-- wrapper -->
    </body>
</html>
