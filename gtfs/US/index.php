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
    $duration += CreateGtfsEntry( "US-MA-BAT" );
    $duration += CreateGtfsEntry( "US-MA-BRTA" );
    $duration += CreateGtfsEntry( "US-MA-CATA" );
    $duration += CreateGtfsEntry( "US-MA-CCRTA" );
    $duration += CreateGtfsEntry( "US-MA-FRTA" );
    $duration += CreateGtfsEntry( "US-MA-GATRA" );
    $duration += CreateGtfsEntry( "US-MA-LRTA" );
    $duration += CreateGtfsEntry( "US-MA-MART" );
    $duration += CreateGtfsEntry( "US-MA-MBTA" );
    $duration += CreateGtfsEntry( "US-MA-MeVa" );
    $duration += CreateGtfsEntry( "US-MA-MWRTA" );
    $duration += CreateGtfsEntry( "US-MA-NRTA" );
    $duration += CreateGtfsEntry( "US-MA-PVTA" );
    $duration += CreateGtfsEntry( "US-MA-SRTA" );
    $duration += CreateGtfsEntry( "US-MA-VTA" );
    $duration += CreateGtfsEntry( "US-MA-WRTA" );
    $duration += CreateGtfsEntry( "US-NY-MTA-Bronx-Bus" );
    $duration += CreateGtfsEntry( "US-NY-MTA-Brooklyn-Bus" );
    $duration += CreateGtfsEntry( "US-NY-MTA-Bus-Company" );
    $duration += CreateGtfsEntry( "US-NY-MTA-Manhattan-Bus" );
    $duration += CreateGtfsEntry( "US-NY-MTA-Queens-Bus" );
    $duration += CreateGtfsEntry( "US-NY-MTA-Staten-Island-Bus" );
    $duration += CreateGtfsEntry( "US-NY-MTA-Subway" );
    $duration += CreateGtfsEntry( "US-RI-RIPTA" );
    $duration += CreateGtfsEntry( "US-WA-KCM" );
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
    $duration += CreateGtfsEntry( "US-NPS-BLT" );   # Boston Harbor Island National Recreation Area, Boston Light Tour
    $duration += CreateGtfsEntry( "US-NPS-BNMS" );  # Bandalier National Monument
    $duration += CreateGtfsEntry( "US-NPS-DCC" );   # National Mall and Memorial Parks, DC Circulator
    $duration += CreateGtfsEntry( "US-NPS-HST" );   # Harpers Ferry National Historical Park, HAFE Shuttle Transport
    $duration += CreateGtfsEntry( "US-NPS-IE" );    # Acadia National Park, Island Express
    $duration += CreateGtfsEntry( "US-NPS-MGSS" );  # Yosemite National Park, Mariposa Grove Shuttle Service
    $duration += CreateGtfsEntry( "US-NPS-PBCF" );  # Gulf Islands National Seashore, Pensacola Bay City Ferry
    $duration += CreateGtfsEntry( "US-NPS-SIE" );   # Gulf Islands National Seashore, 	Ship Island Excursions
    $duration += CreateGtfsEntry( "US-NPS-SRS" );   # Grand Canyon National Park, South Rim Shuttle
    $duration += CreateGtfsEntry( "US-NPS-TIF" );   # Boston Harbor Island National Recreation Area, Thompson Island Ferry
    $duration += CreateGtfsEntry( "US-NPS-YVS" );   # Yosemite National Park, Yosemite Valley Shuttle
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
