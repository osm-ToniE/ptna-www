<!DOCTYPE html>
<html lang="ru">

<?php $title="GTFS Statistics"; include('html-head.inc'); ?>

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

            <h2 id="gtfs-statistics"><img src="/img/Russia16.png"  class="flagimg" alt="Флаг России" /> GTFS Statistics</h2>
            <p>
                Server Load: <code><?php StatisticsPrintServerLoad();?></code><br />
                Disk Load:   <code><?php StatisticsPrintDiskLoad();?></code>
            </p>

            <hr />

            <table id="message-table" class="js-sort-table">
                <thead>
                    <tr class="statistics-tableheaderrow">
                        <th class="statistics-name js-sort-string">&#x21C5;GTFS Feed Details</th>
                        <th class="statistics-date js-sort-string">&#x21C5;GTFS Data Update</th>
                        <th class="statistics-date js-sort-none"  >Update Logs</th>
                    </tr>
                </thead>
                <tbody>
<?php PrintGtfsUpdateStatistics();  ?>
                </tbody>
                <tfoot>
                </tfoot>
            </table>

        </main> <!-- main -->

        <hr />

<?php include "footer.inc" ?>

      </div> <!-- wrapper -->
    </body>
</html>
