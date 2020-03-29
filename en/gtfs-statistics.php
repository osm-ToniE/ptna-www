<!DOCTYPE html>
<html lang="en">

<?php $title="GTFS Analysis Statistics"; include('html-head.inc'); ?>

<?php include('../script/globals.php'); ?>
<?php include('../script/gtfs.php'); ?>

    <body>

      <div id="wrapper">
      
<?php include "header.inc" ?>

        <main id="main" class="results">

<?php $network  = $_GET['network']; ?>

            <h2 id="statistics"><img src="/img/GreatBritain16.png" alt="Union Jack" /> GTFS Analysis Statistics<?php if ( $network ) { echo " for " . htmlspecialchars($network); }?></h2>
                <div class="indent">
                    <p>
                    </p>
                    
                    <h3>Global PTNA Data</h3>
                        <div class="indent">
                            <table id="gtfs-ptna-table">
                                <thead>
                                    <tr class="statistics-tableheaderrow">
                                        <th class="statistics-name">Name</th>
                                        <th class="statistics-number">Unit</th>
                                        <th class="statistics-number">Value</th>
                                    </tr>
                                </thead>
                                <tbody>
<?php CreatePtnaStatistics( $network ); ?>
                                </tbody>
                            </table>
                        </div>

                    <h3>PTNA Aggregation Statistics</h3>
                        <div class="indent">
                            <table id="gtfs-ptna-aggregation-table">
                                <thead>
                                    <tr class="statistics-tableheaderrow">
                                        <th class="statistics-name">Name</th>
                                        <th class="statistics-number">Unit</th>
                                        <th class="statistics-number">Value</th>
                                    </tr>
                                </thead>
                                <tbody>
<?php CreatePtnaAggregationStatistics( $network ); ?>
                                </tbody>
                            </table>
                        </div>

                    <h3>PTNA Analysis Statistics</h3>
                        <div class="indent">
                            <table id="gtfs-ptna-analysis-table">
                                <thead>
                                    <tr class="statistics-tableheaderrow">
                                        <th class="statistics-name">Name</th>
                                        <th class="statistics-name">Unit</th>
                                        <th class="statistics-number">Value</th>
                                    </tr>
                                </thead>
                                <tbody>
<?php CreatePtnaAanalysisStatistics( $network ); ?>
                                </tbody>
                            </table>
                        </div>
                </div>

        </main> <!-- main -->

        <hr />

<?php include "footer.inc" ?>

      </div> <!-- wrapper -->
    </body>
</html>

