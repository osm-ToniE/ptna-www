<!DOCTYPE html>
<html lang="en">

<?php $title="GTFS Compare Documentation"; include "html-head.inc" ?>

    <body>
      <div id="wrapper">

<?php include "header.inc" ?>

        <nav id="navigation">
            <h2>GTFS / OSM Comparison</h2>
            <ul>
                <li><a href="#gtfsdata">What is GTFS data?</a></li>
                <li><a href="#gtfs-osm">How can GTFS data be used to improve OSM data?</a></li>
                <li><a href="#comparison-types">Which types of comparison are supported?</a></li>
                <li><a href="#where-to-add">Where can I add GTFS links for easy GTFS/OSM comparison?</a>
            </ul>
        </nav>

        <hr />

        <main id="main">

            <h2 id="gtfsdata">What is GTFS data?</h2>
            <div class="indent">
                <p>
                    Quoted from MobilityData's Web-Site <a href="https://gtfs.org/">GTFS</a>:
                </p>
                <p>"<i>The General Transit Feed Specification (GTFS) is an Open Standard used to distribute relevant information about transit systems to riders.
                    It allows public transit agencies to publish their transit data in a format that can be consumed by a wide variety of software applications.
                    Today, the GTFS data format is used by thousands of public transport providers.</i>"
                </p>
            </div>

            <hr />

            <h2 id="gtfs-osm">How can GTFS data be used to improve OSM data?</h2>
            <div class="indent">
                <p>
                    GTFS data can be used to ...
                </p>
            </div>

            <hr />

            <h2 id="comparison-types">Which types of comparison are supported?</h2>
            <div class="indent">
                <p>
                    PTNA supports the following types of comparison ...
                </p>
                <h3 id="compate-gtfs-osm">Compare GTFS with OSM</h3>
                <div class="indent">
                    <p>
                        GTFS data can be compared with OSM data.
                    </p>
                    <h4 id="compare-route-route_master">Compare GTFS route with OSM route_master</h4>
                    <div class="indent">
                        <p>
                            GTFS route data ...
                        </p>
                    </div>
                    <h4 id="compare-trip-route">Compare GTFS trip with OSM route</h4>
                    <div class="indent">
                        <p>
                            GTFS trip data can be compared with OSM route data.
                        </p>
                    </div>
                </div>
                <h3 id="compate-gtfs-gtfs">Compare GTFS with GTFS</h3>
                <div class="indent">
                    <p>
                        Two (different) sets of GTFS data (called "feed") can be compared using PTNA.
                    </p>
                    <h4 id="compare-feeds">Compare two GTFS feeds</h4>
                    <div class="indent">
                        <p>
                            Two (different) sets of GTFS data (called "feed") can be compared using PTNA.
                        </p>
                    </div>
                    <h4 id="compare-routes">Compare two GTFS routes</h4>
                    <div class="indent">
                        <p>
                            Two GTFS routes can be compared using PTNA.
                        </p>
                    </div>
                    <h4 id="compare-trips">Compare two GTFS trips</h4>
                    <div class="indent">
                        <p>
                            Two GTFS trips can be compared using PTNA.
                        </p>
                    </div>
                </div>
            </div>

            <hr />

            <h2 id="where-to-add">Where can I add GTFS links for easy GTFS/OSM comparison?</h2>
            <div class="indent">
                <p>
                    There are several places ...
                </p>
            </div>

            <hr />

<?php include "gtfs-footer.inc" ?>

	  </div> <!-- wrapper -->
    </body>
</html>
