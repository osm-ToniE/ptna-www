<!DOCTYPE html>
<html lang="en">

<?php $title="Statistics"; include('html-head.inc'); ?>

<?php
    include('../script/parse_query.php');
    include('../script/statistics.php');
    ?>

    <body>
      <script src="/script/sort-table.js"></script>
      <div id="wrapper">

<?php include "header.inc" ?>

        <main id="main" class="results">

            <h2 id="statistics"><img src="/img/GreatBritain16.png" alt="Union Jack" /> Statistics</h2>
            <p>
            </p>

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
