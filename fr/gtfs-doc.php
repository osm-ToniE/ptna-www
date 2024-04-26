<!DOCTYPE html>
<html lang="fr">

<?php $title="GTFS"; include "html-head.inc" ?>

    <body>
      <div id="wrapper">

<?php include "header.inc" ?>

        <nav id="navigation">
            <h2>GTFS</h2>
            <ul>
                <li><a href="#gtfsdata">What is GTFS data?</a></li>
                <li><a href="#download">Updating the data</a></li>
                <li><a href="#prepare">Preparation of GTFS data</a></li>
                <li><a href="#aggregate">Aggregation of GTFS data</a>
                <li><a href="#analyze">Analysis of GTFS data</a>
                <li><a href="#normalize">Normalization of GTFS data</a>
            </ul>
        </nav>

        <hr />

        <main id="main">

            <h2 id="gtfsdata">What is GTFS data?</h2>
            <div class="indent">
                <p>
                    GTFS data ... Quoted from von Google's Web-Site <a href="https://gtfs.org/">GTFS</a>:
                </p>
                <p>"<i>The General Transit Feed Specification (GTFS), also known as GTFS static or static transit to differentiate it from the GTFS realtime extension,
                       defines a common format for public transportation schedules and associated geographic information.
                       GTFS "feeds" let public transit agencies publish their transit data and developers write applications that consume that data in an interoperable way.</i>"
                </p>
                <p>
                    The GTFS data consists of a series of *.txt files packed in a *.zip archive.
                    The data in the *.txt files is structured as CSV data.
                    The different files can be used as database tables.
                    PTNA's GTFS analysis uses the simple, file-based <strong>SQLite</strong> software.
                </p>
                <ul>
                    <li><strong>feed_info.txt</strong>
                        <div class="indent">
                        essentially contains information about the publisher (owner) of the data as well as optional information about the version and validity period of the data.
                        </div>
                    </li>
                    <li><strong>agency.txt</strong>
                        <div class="indent">
                            contains information about the transit agency.
                            The 'agencies' listed can be interpreted in the OSM sense as 'network' or 'operator'.
                            This depends on what the publisher of the data means by 'transit agency'.
                        </div>
                    </li>
                    <li><strong>routes.txt</strong>
                        <div class="indent">
                            contains information about...
                        </div>
                    </li>
                    <li><strong>trips.txt</strong>
                        <div class="indent">
                            contains information about...
                        </div>
                    </li>
                    <li><strong>stops.txt</strong>
                        <div class="indent">
                            contains information about...
                        </div>
                    </li>
                    <li><strong>stop_times.txt</strong>
                        <div class="indent">
                            contains information about...
                        </div>
                    </li>
                    <li><strong>shapes.txt</strong>
                        <div class="indent">
                            contains information about...
                        </div>
                    </li>
                    <li><strong>calendar.txt</strong>
                        <div class="indent">
                            contains information about...
                        </div>
                    </li>
                    <li><strong>calendar_dates.txt</strong>
                        <div class="indent">
                            contains information about...
                        </div>
                    </li>
                </ul>
            </div>

            <hr />

            <h2 id="download">Updating the data</h2>
            <div class="indent">
                <p>
                    The data on this page is updated only at irregular intervals for several reasons:
                </p>
                <ul>
                    <li>Some networks make new versions available almost daily without specifying a date.</li>
                    <li>Some networks provide data at very irregular intervals.</li>
                    <li>Some data can be downloaded directly and always via the same link.</li>
                    <li>Some data can only be downloaded indirectly via, per version, always different links - to prevent automated loading?</li>
                    <li>At least the download can't be automated easily.</li>
                    <li>Public transport relations should have a long-term character in OSM. Does it make sense to map every construction site related change of a bus line in OSM to undo this later on?</li>
                </ul>
            </div>

            <hr />

            <h2 id="prepare">Preparation of GTFS data</h2>
            <div class="indent">
                <p>
                The GTFS data of the transport authority are prepared for use in PTNA.
                </p>
                <ul>
                    <li>Table "osm"
                        <ul>
                            <li>Add OSM-specific information as a separate table.
                                <ul>
                                    <li>Value of 'network' for PT relations (e.g. "Münchner Verkehrs- und Tarifverbund").</li>
                                    <li>Value of 'network:short' for PT relations (e.g. "MVV").</li>
                                    <li>Value of 'network:guid' for PT relations (e.g. "DE-BY-MVV").</li>
                                    <li>Value of 'operator for PT relations: can "agency_name" from the GTFS table "agency.txt" be used as 'operator'?</li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                    <li>Table "ptna"
                        <ul>
                            <li>Add PTNA-specific information as a separate table.</li>
                        </ul>
                    </li>
                    <li>Other tables
                        <ul>
                            <li>The field 'ptna_comment' is added.
                                This can be used to enter comments - see "Analysis of GTFS data.
                            </li>
                        </ul>
                    </li>
               </ul>
            </div>

            <hr />

            <h2 id="aggregate">Aggregation of GTFS data</h2>
            <div class="indent">
                <p>
                    The GTFS data of the transport association are processed for PTNA.
                    The aim is to reduce the amount of data to enable fast searches in the GTFS data.
                </p>
                <ul>
                    <li>Table "ptna_aggregation"
                        <ul>
                            <li>Add PTNA-specific information to the aggregation as a separate table.</li>
                        </ul>
                    </li>
                    <li>Table "routes"
                        <ul>
                            <li>Delete all "route_id" that are no longer valid (end of validity before the time of aggregation/download).</li>
                       </ul>
                    </li>
                    <li>Table "trips"
                        <ul>
                            <li>Delete all "trip_id" that are no longer valid (end of validity before the time of aggregation/download)</li>
                        </ul>
                    </li>
                    <li>Table "stop_times"
                        <ul>
                            <li>Delete all redundant "trip_id", those with identical routes that differ only in departure times.
                                Reduce to a single "trip_id" (the first "trip_id" found).
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>

            <hr />

            <h2 id="analyze">Analysis of GTFS data</h2>
            <div class="indent">
                <p>
                    The GTFS data of the transport association are processed for PTNA.
                    The aim is to find out which route (trip) is a subroute of another route.
                </p>
                <ul>
                    <li>Table "ptna_analysis"
                        <ul>
                            <li>Add PTNA-specific information to the analysis as a separate table.</li>
                        </ul>
                    </li>
                    <li>Table "trips"
                        <ul>
                            <li>...</li>
                        </ul>
                    </li>
                 </ul>
            </div>

            <hr />

            <h2 id="normalize">Normalization of GTFS data</h2>
            <div class="indent">
                <p>
                The GTFS data of the transport association are processed for PTNA.
                    The aim is to achieve a uniform spelling for stop names.
                </p>
                <ul>
                    <li>"str." => "straße"</li>
                    <li>"Str." => "Straße"</li>
                    <li>"Pl."  => "Platz"</li>
                    <li>...</li>
                </ul>
            </div>
        </main>

        <hr />

<?php include "gtfs-footer.inc" ?>

	  </div> <!-- wrapper -->
    </body>
</html>
