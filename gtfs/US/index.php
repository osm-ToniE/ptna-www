<!DOCTYPE html>
<?php   include( '../../script/globals.php'     );
        include( '../../script/parse_query.php' );
        include( '../../script/gtfs.php'        );
?>
<html lang="<?php echo $html_lang ?>">

<?php $title="GTFS Analysis"; $lang_dir="../../$ptna_lang/"; include $lang_dir.'html-head.inc'; ?>

    <body>
      <div id="wrapper">
<?php include $lang_dir.'header.inc' ?>
<?php $duration = 0; ?>
        <main id="main" class="results">

            <h2 id="US"><a href="index.php"><img src="/img/USA32.png"  class="flagimg" alt="Flag of the United States of Amerika" /></a> GTFS Analysis for the United States of Amerika</h2>
            <div class="indent">
<?php include $lang_dir.'gtfs-head.inc' ?>
                <h3 id="USStates">States of the US</h3>
                <table id="gtfsUS">
                    <thead>
<?php include $lang_dir.'gtfs-trth.inc' ?>
                    </thead>
                    <tbody>
<?php
    $duration += CreateGtfsEntry( "US-MA-GATRA" );
    $duration += CreateGtfsEntry( "US-MA-LRTA" );
    $duration += CreateGtfsEntry( "US-MA-MBTA" );
    $duration += CreateGtfsEntry( "US-MA-MWRTA" );
    $duration += CreateGtfsEntry( "US-MA-PVTA" );
    $duration += CreateGtfsEntry( "US-NY-MTA-Bronx-Bus" );
    $duration += CreateGtfsEntry( "US-NY-MTA-Brooklyn-Bus" );
    $duration += CreateGtfsEntry( "US-NY-MTA-Bus-Company" );
    $duration += CreateGtfsEntry( "US-NY-MTA-Manhattan-Bus" );
    $duration += CreateGtfsEntry( "US-NY-MTA-Queens-Bus" );
    $duration += CreateGtfsEntry( "US-NY-MTA-Staten-Island-Bus" );
    $duration += CreateGtfsEntry( "US-NY-MTA-Subway" );
    $duration += CreateGtfsEntry( "US-RI-RIPTA" );
?>
                    </tbody>
                </table>

                <h3 id="USNPS">National Park Service</h3>
                <table id="gtfsUSNPS">
                    <thead>
<?php include $lang_dir.'gtfs-trth.inc' ?>
                    </thead>
                    <tbody>
<?php
    $duration += CreateGtfsEntry( "US-NPS-BCS" );   # Bryce Canyon Shuttle
    $duration += CreateGtfsEntry( "US-NPS-ZCS" );   # Zion Canyon Shuttle
?>
                    </tbody>
                </table>

                <?php printf( "<p>SQL-Queries took %f seconds to complete</p>\n", $duration ); ?>
            </div>
        </main> <!-- main -->

        <hr />

<?php include $lang_dir.'gtfs-footer.inc' ?>

      </div> <!-- wrapper -->
    </body>
</html>
