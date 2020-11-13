<!DOCTYPE html>
<?php   include( '../script/globals.php'     );
        include( '../script/gtfs.php'        );
        include( '../script/parse_query.php' );
?>
<html lang="en">

<?php $title="GTFS Analysis Details"; include('html-head.inc'); ?>

    <body>

      <div id="wrapper">

<?php include "header.inc" ?>

        <main id="main" class="results">

<?php $topic    = $_GET['topic'];
      $duration = 0;
?>

            <h2 id="details"><img src="/img/GreatBritain16.png" alt="Union Jack" /> GTFS Analysis Details<?php if ( $feed ) { echo ' for "' . htmlspecialchars($feed) . '"'; } ?></h2>
                <div class="indent">
                    <p>
                    </p>

                    <h3>Analysis Details for Trips</h3>
                        <div class="indent">
                            <table id="gtfs-ptna-table">
                                <thead>
                                    <tr class="statistics-tableheaderrow">
                                        <th class="statistics-name">Route</th>
                                        <th class="statistics-text">Trip</th>
                                        <th class="statistics-text">Comment</th>
                                    </tr>
                                </thead>
                                <tbody>
<?php $duration += CreateAnalysisDetailsForTrips( $feed, $release_date, $topic ); ?>
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
