<!DOCTYPE html>
<?php   include( '../script/globals.php'     );
        include( '../script/gtfs.php'        );
        include( '../script/parse_query.php' );
        $ptna_lang = "en";
        $html_lang = "en";
?>
<html lang=<?php echo $html_lang; ?>

<?php $title="GTFS Details"; include('html-head.inc'); ?>

    <body>

      <div id="wrapper">

<?php include "header.inc" ?>

        <main id="main" class="results">

<?php $duration = 0; ?>

            <h2 id="details"><img src="/img/GreatBritain16.png" alt="Union Jack" /> GTFS Details<?php if ( $feed ) { echo ' for "' . htmlspecialchars($feed) . '"'; } ?></h2>
                <div class="indent">

                    <h3 id="feeds">Available GTFS sources</h3>
                    <div class="indent">

<?php   $months_short = array( "Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec" );

        CreateGtfsTimeLine( $feed, $release_date, $months_short ) ;

        include 'gtfs-feed-legend.inc';
?>

                    </div>

                    <h3>PTNA Specific Data</h3>
                        <div class="indent">
                            <table id="gtfs-ptna-table">
                                <thead>
                                    <tr class="statistics-tableheaderrow">
                                        <th class="statistics-name">Name</th>
                                        <th class="statistics-text">Detail</th>
                                    </tr>
                                </thead>
                                <tbody>
<?php $duration += CreatePtnaDetails( $network ); ?>
                                </tbody>
                            </table>
                        </div>

                        <h3>OSM Specific Data</h3>
                        <div class="indent">
                            <table id="gtfs-osm-table">
                                <thead>
                                    <tr class="statistics-tableheaderrow">
                                        <th class="statistics-name">Name</th>
                                        <th class="statistics-text">Detail</th>
                                    </tr>
                                </thead>
                                <tbody>
<?php $duration += CreateOsmDetails( $network ); ?>
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
<?php $duration += CreatePtnaAggregationStatistics( $network ); ?>
                                </tbody>
                            </table>
                        </div>

                    <h3><a href="gtfs-analysis-details.php?network=<?php echo urlencode($network);  ?>">GTFS Analysis Details</a></h3>
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
<?php $duration += CreatePtnaAnalysisStatistics( $network ); ?>
                                </tbody>
                            </table>
                        </div>

                    <h3>GTFS Normalization Details</h3>
                        <div class="indent">
                            <table id="gtfs-ptna-normalization-table">
                                <thead>
                                    <tr class="statistics-tableheaderrow">
                                        <th class="statistics-name">Name</th>
                                        <th class="statistics-number">Value</th>
                                        <th class="statistics-number">Unit</th>
                                    </tr>
                                </thead>
                                <tbody>
<?php $duration += CreatePtnaNormalizationStatistics( $network ); ?>
                                </tbody>
                            </table>
                        </div>

                    <?php printf( "<p>SQL-Queries took %f seconds to complete</p>\n", $duration ); ?>
                </div>

        </main> <!-- main -->

        <hr />

<?php include "footer.inc" ?>

      </div> <!-- wrapper -->
    </body>
</html>
