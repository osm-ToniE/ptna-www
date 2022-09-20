<!DOCTYPE html>
<html lang="fr">

<?php $title="Documentation"; include('html-head.inc'); ?>

    <body>
      <div id="wrapper">

<?php include "header.inc" ?>

        <nav id="navigation">
            <h2>Documentation</h2>
            <ul>
                <li><a href="#motivation">Motivation</a></li>
                <li><a href="#overview">Aperçu</a></li>
                <li><a href="#web">Le site web</a>
                    <ul>
                        <li><a href="#analysislist">Résultats</a></li>
                        <li><a href="#statistics">Statistiques</a></li>
                    </ul>
                </li>
                <li><a href="#networkroutes">Itinéraires appartenant au réseau 'network'</a></li>
                <li><a href="#analysis">L'analyse</a>
                    <ul>
                        <li><a href="#routesdescription">Description des lignes attendues</a></li>
                        <li><a href="#overpass">Téléchargement de données de OSM</a></li>
                        <li><a href="#analysissettings">Definition des options d'analyse</a></li>
                        <li><a href="#dataanalysis">Analyse des données</a>
                            <ul>
                                <li><a href="#analysisdate">Date of Data</a></li>
                                <li><a href="#analysisroutes">Aperçu over the PT lines</a></li>
                                <li><a href="#analysisnotassigned">Unassigned lines</a></li>
                                <li><a href="#analysisother">Other PT lines</a></li>
                                <li><a href="#analysisnoref">PT lines w/o 'ref'</a></li>
                                <li><a href="#analysisrelations">More Relationen</a></li>
                                <li><a href="#analysisnetwork">Details for 'network'-Values</a>
                                    <ul>
                                       <li><a href="#analysisnetworkconsidered">Considered 'network' values</a></li>
                                       <li><a href="#analysisnetworknotconsidered">Not considered 'network' values</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                        <li><a href="#checks">Checks</a>
                            <ul>
                                <li><a href="#scheme">Used Schema</a>
                                   <ul>
                                      <li><a href="#deviations">Deviations</a></li>
                                      <li><a href="#specials">Specials</a></li>
                                    </ul>
                                </li>
                                <li><a href="#approach">Approach</a></li>
                                <li><a href="#options">Analysis Options</a></li>
                                <li><a href="#messages">Messages</a></li>
                                <li><a href="#taginfo">PTNA on 'taginfo'</a></li>
                            </ul>
                        </li>
                    </ul>
                </li>
                <li><a href="#code">Le Code</a>
                    <ul>
                        <li><a href="#ptna">ptna</a></li>
                        <li><a href="#ptnanetworks">ptna-networks</a></li>
                        <li><a href="#ptnawww">ptna-www</a></li>
                        <li><a href="#gtfs">gtfs</a></li>
                        <li><a href="#gtfsfeeds">gtfs-feeds</a></li>
                    </ul>
                </li>
            </ul>
        </nav>

        <hr />

        <main id="main">

            <h2 id="motivation">Motivation</h2>
            <div class="indent">
                <p>
                    First <a href="https://wiki.openstreetmap.org/wiki/Talk:M%C3%BCnchen/Transportation#Qualit.C3.A4tssicherung_-_M.C3.BCnchen.2FTransportation">discussions</a> (german) started at a Munich OSM pub meeting in February 2017.
                </p>
                <p>
                    The whole discussion was triggered by unintentional deletion of bus relations in the Munich area (but new relations were created).
                    As a result, many links on the <a href="https://wiki.openstreetmap.org/wiki/München/Transportation#Verkehrsmittel">München/Transportation</a> (german) page were out of date.
                    However, one must also say that the site was not well maintained in the past, in part, was not known at all.
                    The quality and timeliness of the site seems to be a general problem.
                </p>
                <p>
                    <strong>Problem:</strong> the quality of the page <a class="a" href="https://wiki.openstreetmap.org/wiki/München/Transportation#Verkehrsmittel">München/Transportation</a> (german) leaves room for improvement:
                </p>
                <ul>
                    <li><strong>Completeness:</strong>
                        <ul>
                            <li>we do not know if we have listed all existing bus lines of the MVV on the page</li>
                            <li>we do not know if we have mapped artifacts, e.g. bus lines that have already been reset or renumbered</li>
                            <li>suburban trains, subways and trams are manageable in number, there is a chance that we are complete</li>
                        </ul>
                    </li>
                    <li><strong>PTv2:</strong>
                        <ul>
                            <li>we do not know which of the lines have already been changed to "Public-Transport Version 2".</li>
                            <li><a href="https://wiki.openstreetmap.org/wiki/Public_Transport">Public_transport</a>. The original text of the proposal can be found under
                                <a href="https://wiki.openstreetmap.org/w/index.php?title=Proposed_features/Public_Transport&amp;oldid=625726">Approved Feature Public Transport (approved Version 625726)</a>
                            </li>
                        </ul>
                    </li>
                    <li><strong>Correctness:</strong>
                        <ul>
                            <li>we do not know if the lines switched to PTv2 are consistent and sorted</li>
                            <li>i.e. whether the ways are captured correctly, in the correct order, without gaps, without extensions and at roundabouts</li>
                            <li>whether the "stop" and "platform" members are captured completely and in the correct order</li>
                        </ul>
                    </li>
                    <li><strong>Uniformity:</strong>
                        <ul>
                            <li>we do not know if all relations with their tags are complete and correct</li>
                            <li>i.e. with existing, correct and possibly uniform "network", "operator",
                                public_transport: version, name, ref, from, to (and via), ...
                            </li>
                        </ul>
                    </li>
                    <li><strong>Clarity:</strong>
                        <ul>
                            <li>we do not have a page that shows us all that, <strong>but most of all the problems with it </strong>
                            </li>
                        </ul>
                    </li>
                    <li><strong>Automation:</strong>
                        <ul>
                            <li>we have no possibility to automatically create such a summary page (weekly, ...)
                            </li>
                        </ul>
                    </li>
                </ul>
                <p>
                    <strong>Causes </strong> there are many:
                </p>
                <ul>
                    <li><strong>Completeness:</strong>
                        <ul>
                            <li>where should we get the information from? We may receive a list from the MVV (CSV, ...)</li>
                        </ul>
                    </li>
                    <li><strong>PTv2:</strong>
                        <ul>
                            <li>some lines have neither "version" 1 nor 2 as tag: forgotten, ignorance of existence ...</li>
                         </ul>
                    </li>
                    <li><strong>Correctness:</strong>
                        <ul>
                            <li>This is a tedious work that has to be started again and again, because relations are quickly (unintentionally) "filled" with gaps, ...</li>
                        </ul>
                    </li>
                    <li><strong>Uniformity:</strong>
                        <ul>
                            <li>what is the standard? network = MVV or network = "Münchner Verkehrs- und Tarif-Verbund" and so on? <a href="https://wiki.openstreetmap.org/wiki/München/Transportation#Vorschlag_für_vereinheitliches_Tagging">München/Transportation Proposal for unified tagging</a> (german)</li>
                        </ul>
                    </li>
                    <li><strong>Clarity:</strong>
                        <ul>
                            <li>Parts of the page are already clearer, how could a clearer page look like (layout?)</li>
                        </ul>
                    </li>
                    <li><strong>Automation:</strong>
                        <ul>
                            <li>there is nothing</li>
                        </ul>
                    </li>
                </ul>
                <p>
                    A non-representative view of Berlin, Hamburg and Aachen shows that other cities have the same problem.
                </p>
            </div> <!-- "motivation" -->

            <hr />

            <h2 id="overview">Aperçu</h2>
            <div class="indent">
                <p>
                    Lorem ipsum dolor sit amet, consectetur adipisici elit, …
                </p>
            </div> <!-- "overview" -->

            <hr />

            <h2 id="web">Le site web</h2>
            <div class="indent">
                <p>
                    Lorem ipsum dolor sit amet, consectetur adipisici elit, …
                </p>
                <h3 id="analysislist">L'analyse</h3>
                <div class="indent">
                    <p>
                        Lorem ipsum dolor sit amet, consectetur adipisici elit, …
                    </p>
                    <ul>
                        <li>Name</li>
                        <li>City/Region</li>
                        <li>Network</li>
                        <li>Results</li>
                        <li>Last Changes</li>
                        <li>Discussion</li>
                        <li>Lines</li>
                    </ul>
                </div> <!-- "analysislist" -->
                <h3 id="statistics">Statistics</h3>
                <div class="indent">
                    <p>
                        <a href="/en/statistics.php">Statistics</a> ... Lorem ipsum dolor sit amet, consectetur adipisici elit, …
                    </p>
                </div> <!-- "statistics" -->
            </div> <!-- "web" -->

            <hr />

            <h2 id="networkroutes">Itinéraires appartenant au réseau 'network'</h2>
            <div class="indent">
                <p>
                    Lorem ipsum dolor sit amet, consectetur adipisici elit, …
                </p>
                <p>
                    <strong>Important: Consider the Copyright &copy; and origin of the data!</strong><br />
                </p>
                <p>
                    <strong>Note: The list will be published under the <a href="https://www.gnu.org/licenses/gpl.html">GPL 3</a> license.</strong>
                </p>
            </div> <!-- "networkroutes" -->

            <hr />

            <h2 id="analysis">L'analyse</h2>
            <div class="indent">
                <p>
                    Lorem ipsum dolor sit amet, consectetur adipisici elit, …
                </p>

                <h3 id="routesdescription">Description des lignes attendues</h3>
                <div class="indent">
                    <p>
                        Lorem ipsum dolor sit amet, consectetur adipisici elit, …
                    </p>
                    <p>
                        <strong>Important: Consider the Copyright &copy; and origin of the data!</strong><br />
                    </p>
                    <p>
                        <strong>Note: The list will be published under the <a href="https://www.gnu.org/licenses/gpl.html">GPL 3</a> license.</strong>
                    </p>
                    <p>
                        Example: Lines of the <a href="https://wiki.openstreetmap.org/wiki/M%C3%BCnchen/Transportation/MVV-Linien-gesamt">Münchner Verkehrs- und Tarifverbund</a> in OSM Wiki
                    </p>
                </div> <!-- "routesdescription" -->

                <h3 id="overpass">Téléchargement de données de OSM</h3>
                <div class="indent">
                    <p>
                        Lorem ipsum dolor sit amet, consectetur adipisici elit, …
                    </p>
	                <h4 id="searcharea">Definition of the search area</h4>
                    <div class="indent">
                        <p>
                            Lorem ipsum dolor sit amet, consectetur adipisici elit, …
                        </p>
		            </div> <!-- searcharea -->

		            <h4 id="searchdata">Seletion of relevant routes, ways and nodes</h4>
                    <div class="indent">
                        <p>
                            Lorem ipsum dolor sit amet, consectetur adipisici elit, …
                        </p>
		            </div> <!-- searchdata -->

		            <h4 id="searchoutput">Output of data</h4>
                    <div class="indent">
                        <p>
                            Lorem ipsum dolor sit amet, consectetur adipisici elit, …
                        </p>
		            </div> <!-- searchoutput -->
                    <p>
                        Lorem ipsum dolor sit amet, consectetur adipisici elit, …
                    </p>
                </div> <!-- "overpass" -->

                <h3 id="analysissettings">Definition des options d'analyse</h3>
                <div class="indent">
                    <p>
                        Lorem ipsum dolor sit amet, consectetur adipisici elit, …
                    </p>
                </div> <!-- "#analysissettings" -->

                <h3 id="dataanalysis">Analyse des données</h3>
                <div class="indent">
                    <p>
                        Lorem ipsum dolor sit amet, consectetur adipisici elit, …
                    </p>

                    <h4 id="analysisdate">Date of Data</h4>
                    <div class="indent">
                        <p>
                            Lorem ipsum dolor sit amet, consectetur adipisici elit, …
                        </p>
                        <p>
                            Example: <a href="/results/DE/BY/DE-BY-MVV-Analysis.html#A1">Münchner Verkehrs- und Tarifverbund</a>
                        </p>
                    </div> <!-- "analysisdate" -->

                    <h4 id="analysisroutes">Aperçu overPT Lines ... </h4>
                    <div class="indent">
                        <p>
                            Lorem ipsum dolor sit amet, consectetur adipisici elit, …
                        </p>
                        <p>
                            Example: <a href="/results/DE/BY/DE-BY-MVV-Analysis.html#A2">Münchner Verkehrs- und Tarifverbund</a>
                        </p>
                    </div> <!-- "analysisroutes" -->

                    <h4 id="analysisnotassigned">Not assigned lines</h4>
                    <div class="indent">
                        <p>
                            Lorem ipsum dolor sit amet, consectetur adipisici elit, …
                        </p>
                        <p>
                            Example: <a href="/results/DE/SN/DE-SN-VMS-Analysis.html#A3">Verkehrsverbund Mittelsachsen</a>
                        </p>
                    </div> <!-- "analysisnotassigned" -->

                    <h4 id="analysisother">Other PT Lines</h4>
                    <div class="indent">
                        <p>
                            Lorem ipsum dolor sit amet, consectetur adipisici elit, …
                        </p>
                        <p>
                            Example: <a href="/results/DE/BY/DE-BY-RVO-Analysis.html#A3">Regionalverkehr Oberbayern</a>
                        </p>
                    </div> <!-- "analysisother" -->

                    <h4 id="analysisnoref">PT Lines w/o 'ref'</h4>
                    <div class="indent">
                        <p>
                            Lorem ipsum dolor sit amet, consectetur adipisici elit, …
                        </p>
                        <p>
                            Example: <a href="/results/DE/NI/DE-NI-VEJ-Analysis.html#A4">Verkehrsverbund Ems-Jade</a>
                        </p>
                    </div> <!-- "analysisnoref" -->

                    <h4 id="analysisrelations">More Relations</h4>
                    <div class="indent">
                        <p>
                            Lorem ipsum dolor sit amet, consectetur adipisici elit, …
                        </p>
                        <p>
                            Example: <a href="/results/DE/NW/DE-NW-VRS-Analysis.html#A5">Verkehrsverbund Rhein-Sieg (VRS)</a>
                        </p>
                    </div> <!-- "analysisrelations" -->

                    <h4 id="analysisnetwork">Details for 'network'-Values</h4>
                    <div class="indent">
                        <p>
                            Lorem ipsum dolor sit amet, consectetur adipisici elit, …
                        </p>

                        <h5 id="analysisnetworkconsidered">Considered 'network' values</h5>
                        <div class="indent">
                            <p>
                                Lorem ipsum dolor sit amet, consectetur adipisici elit, …
                            </p>
                            <p>
                                Example: <a href="/results/DE/SN/DE-SN-VMS-Analysis.html#A7.1">Verkehrsverbund Mittelsachsen (VMS)</a>
                            </p>
                        </div> <!-- "analysisnetworkconsidered" -->

                        <h5 id="analysisnetworknotconsidered">Not considered 'network' values</h5>
                        <div class="indent">
                            <p>
                                Lorem ipsum dolor sit amet, consectetur adipisici elit, …
                            </p>
                            <p>
                                Example: <a href="/results/DE/SN/DE-SN-VMS-Analysis.html#A7.2">Verkehrsverbund Mittelsachsen (VMS)</a>
                            </p>
                        </div> <!-- "analysisnetworknotconsidered" -->
                    </div> <!-- "analysisnetwork" -->
                </div> <!-- "dataanalysis" -->

                <h3 id="checks">Checks</h3>
                <div class="indent">
                    <p>
                        Lorem ipsum dolor sit amet, consectetur adipisici elit, …
                    </p>

                    <h4 id="scheme">Used Schema</h4>
                    <div class="indent">
                        <p>
                            Lorem ipsum dolor sit amet, consectetur adipisici elit, …
                        </p>
                        <p>
                            See: <a href="https://wiki.openstreetmap.org/wiki/User:ToniE/analyze-routes#Verwendetes_Schema">OSM Wiki</a>
                        </p>

                        <h5 id="deviations">Deviations</h5>
                        <div class="indent">
                            <p>
                                Lorem ipsum dolor sit amet, consectetur adipisici elit, …
                            </p>
                            <p>
                                See: <a href="https://wiki.openstreetmap.org/wiki/User:ToniE/analyze-routes#Abweichungen">OSM Wiki</a>
                            </p>
                        </div> <!-- "deviations" -->

                        <h5 id="specials">Specials</h5>
                        <div class="indent">
                            <p>
                                Lorem ipsum dolor sit amet, consectetur adipisici elit, …
                            </p>
                            <p>
                                See: <a href="https://wiki.openstreetmap.org/wiki/User:ToniE/analyze-routes#Besonderheiten">OSM Wiki</a>
                            </p>
                        </div> <!-- "specials" -->
                    </div> <!-- "scheme" -->

                    <h4 id="approach">Approach</h4>
                    <div class="indent">
                        <p>
                            Lorem ipsum dolor sit amet, consectetur adipisici elit, …
                        </p>
                        <p>
                            See: <a href="https://wiki.openstreetmap.org/wiki/User:ToniE/analyze-routes#Vorgehensweise">OSM Wiki</a>
                        </p>
                    </div> <!-- "approach" -->

                    <h4 id="options">Analysis options</h4>
                    <div class="indent">
                        <p>
                             Lorem ipsum dolor sit amet, consectetur adipisici elit, …
                        </p>

                        <?php include "option-table.inc" ?>

                    </div> <!-- "options" -->

                    <h4 id="messages">Messages</h4>
                    <div class="indent">
                        <p>
                             Lorem ipsum dolor sit amet, consectetur adipisici elit, …
                        </p>

                        <?php include "message-table.inc" ?>

                    </div> <!-- "messages" -->

                    <h4 id="taginfo">PTNA on 'taginfo'</h4>
                    <div class="indent">
                        <p>
                            PTNA and the
                            '<a href="https://wiki.openstreetmap.org/wiki/FR:Attributs"     title="What are'tags', OSM Wiki"    >tags</a>' analysed by PTNA are listed at
                            '<a href="https://wiki.openstreetmap.org/wiki/Taginfo/Projects" title="Taginfo Projects im OSM Wiki">taginfo-projects</a>' as a
                             <a href="https://taginfo.openstreetmap.org/projects/ptna"      title="PTNA als Projekt bei taginfo-projects">project</a>.
                            <ul>
                                <li><a href="https://taginfo.openstreetmap.org/projects/ptna#tags" title="'tags' analysed by PTNA">Analysis</a></li>
                                <li><a href="https://github.com/taginfo/taginfo-projects"          title="Taginfo Projects on GitHub">taginfo-projects on GitHub</a></li>
                            </ul>
                        </p>
                    </div> <!-- "taginfo" -->

                </div> <!-- "checks" -->
            </div> <!-- "analysis" -->

            <hr />

            <h2 id="code">Le Code</h2>
            <div class="indent">
                <p>
                    Lorem ipsum dolor sit amet, consectetur adipisici elit, …
                </p>

                <h3 id="ptna">ptna</h3>
                <div class="indent">
                    <p>
                        Lorem ipsum dolor sit amet, consectetur adipisici elit, …
                    </p>
                    <p>
                        See: <a href="https://github.com/osm-ToniE/ptna">ptna on GitHub</a>
                    </p>
                </div> <!-- "ptna" -->

                <h3 id="ptnanetworks">ptna-networks</h3>
                <div class="indent">
                    <p>
                        Lorem ipsum dolor sit amet, consectetur adipisici elit, …
                    </p>
                    <p>
                        See: <a href="https://github.com/osm-ToniE/ptna-networks">ptna-networks on GitHub</a>
                    </p>
                </div> <!-- "ptnanetworks" -->

                <h3 id="ptnawww">ptna-www</h3>
                <div class="indent">
                    <p>
                        Lorem ipsum dolor sit amet, consectetur adipisici elit, …
                    </p>
                    <p>
                        See: <a href="https://github.com/osm-ToniE/ptna-www">ptna-www on GitHub</a>
                    </p>
                </div> <!-- "ptnawww" -->

                <h3 id="gtfs">gtfs</h3>
                <div class="indent">
                    <p>
                        Lorem ipsum dolor sit amet, consectetur adipisici elit, …
                    </p>
                    <p>
                        Siehe: <a href="https://github.com/osm-ToniE/gtfs">gtfs on GitHub</a>
                    </p>
                </div> <!-- "gtfs" -->

                <h3 id="gtfsfeeds">gtfs-feeds</h3>
                <div class="indent">
                    <p>
                        Lorem ipsum dolor sit amet, consectetur adipisici elit, …
                    </p>
                    <p>
                        Siehe: <a href="https://github.com/osm-ToniE/gtfs-feeds">gtfs-feeds on GitHub</a>
                    </p>
                </div> <!-- "gtfsfeeds" -->
            </div> <!-- "code" -->
        </main>

        <hr />

<?php include "footer.inc" ?>

      </div> <!-- wrapper -->
    </body>
</html>
