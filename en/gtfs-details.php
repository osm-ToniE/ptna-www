<!DOCTYPE html>
<html lang="en">

<?php $title="GTFS Details"; include('html-head.inc'); ?>

<?php include('../script/globals.php'); ?>
<?php include('../script/gtfs.php'); ?>

    <body>

      <div id="wrapper">
      
<?php include "header.inc" ?>

        <main id="main" class="results">

<?php $network  = $_GET['network']; ?>

            <h2 id="details"><img src="/img/GreatBritain16.png" alt="Union Jack" /> GTFS Details<?php if ( $network ) { echo ' for "' . htmlspecialchars($network) . '"'; } ?></h2>
                <div class="indent">
                    <p>
                    </p>
                    
                    <h3>GTFS specific data</h3>
                        <div class="indent">
                            <table id="gtfs-ptna-table">
                                <thead>
                                    <tr class="statistics-tableheaderrow">
                                        <th class="statistics-name">Name</th>
                                        <th class="statistics-text">Detail</th>
                                    </tr>
                                </thead>
                                <tbody>
<?php CreatePtnaDetails( $network ); ?>
                                </tbody>
                            </table>
                        </div>

                    <h3>GTFS Aggregation Details</h3>
                        <div class="indent">
                            <table id="gtfs-ptna-aggregation-table">
                                <thead>
                                    <tr class="statistics-tableheaderrow">
                                        <th class="statistics-name">Name</th>
                                        <th class="statistics-number">Value</th>
                                        <th class="statistics-number">Unit</th>
                                    </tr>
                                </thead>
                                <tbody>
<?php CreatePtnaAggregationStatistics( $network ); ?>
                                </tbody>
                            </table>
                        </div>

                    <h3>GTFS Analysis Details</h3>
                        <div class="indent">
                            <table id="gtfs-ptna-analysis-table">
                                <thead>
                                    <tr class="statistics-tableheaderrow">
                                        <th class="statistics-name">Name</th>
                                        <th class="statistics-number">Value</th>
                                        <th class="statistics-number">Unit</th>
                                    </tr>
                                </thead>
                                <tbody>
<?php CreatePtnaAnalysisStatistics( $network ); ?>
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

