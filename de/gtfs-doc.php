<!DOCTYPE html>
<html lang="de">

<?php $title="GTFS"; include "html-head.inc" ?>

    <body>
      <div id="wrapper">
      
<?php include "header.inc" ?>

        <nav id="navigation">
            <h2>GTFS</h2>
            <ul>
                <li><a href="#gtfsdata">Was sind GTFS Daten?</a></li>
                <li><a href="#prepared">Bearbeitete GTFS Daten</a></li>
                <li><a href="#aggregated">Aggregierte GTFS Daten</a>
                <li><a href="#analyzed">Analysierte GTFS Daten</a>
                <li><a href="#normalized">Normalisierte GTFS Daten</a>
            </ul>
        </nav>

        <hr />

        <main id="main">

            <h2 id="gtfsdata">Was sind GTFS Daten?</h2>
            <div class="indent">
                <p>
                    GTFS-Daten ... Zitat von Googles Web-Site zur <a href="https://developers.google.com/transit/gtfs">GTFS-Spezifikation</a> (Übersetzt mit www.DeepL.com/Translator):
                </p>
                <p>"<i>Die General Transit Feed Specification (GTFS) [...] definiert ein gemeinsames Format für Fahrpläne des öffentlichen Verkehrs und die
                       damit verbundenen geografischen Informationen.
                       GTFS-"Feeds" ermöglichen es den Verkehrsbetrieben, ihre Verkehrsdaten zu veröffentlichen, und die Entwickler schreiben Anwendungen,
                       die diese Daten auf interoperable Weise nutzen.</i>"
                </p>
            </div>

            <hr />

            <h2 id="prepared">Bearbeitete GTFS Daten</h2>
            <div class="indent">
                <p>
                    Die GTFS-Daten des Verkehrsverbundes werden für die Verwendung in PTNA vorbereitet.
                </p>
                <ul>
                    <li>Tabelle "ptna"
                        <ul>
                            <li>Füge PTNA-spezifische Information als eigenständige Tabelle hinzu.</li>
                        </ul>
                    </li>
                    <li>Andere Tabellen
                        <ul>
                            <li>"ptna_changedate", "ptna_is_invalid", "ptna_is_wrong" und "ptna_comment" Felder werden hinzugefügt. 
                                Hiermit können <strong>später</strong> Anmerkungen eingetragen werden.
                            </li>
                        </ul>
                    </li>
               </ul>
            </div>

            <hr />

            <h2 id="aggregated">Aggregierte GTFS Daten</h2>
            <div class="indent">
                <p>
                    Die GTFS-Daten des Verkehrsverbundes werden für PTNA bearbeitet. 
                    Ziel ist, die Datenmenge zu reduzieren um schnelles Suchen in den GTFS-Daten zu ermöglichen.
                </p>
                <ul>
                    <li>Tabelle "ptna_aggregation"
                        <ul>
                            <li>Füge PTNA-spezifische Information der Aggregation als eigenständige Tabelle hinzu.</li>
                        </ul>
                    </li>
                    <li>Tabelle "routes"
                        <ul>
                            <li>Lösche alle "route_id", die zeitlich nicht mehr gültig sind (Ende der Gültigkeit vor dem Zeitpunkt der Aggregation/des Downloads).</li>
                       </ul>
                    </li>
                    <li>Tabelle "trips"
                        <ul>
                            <li>Lösche alle "trip_id", die zeitlich nicht mehr gültig sind (Ende der Gültigkeit vor dem Zeitpunkt der Aggregation/des Downloads).</li>
                        </ul>
                    </li>
                    <li>Tabelle "stop_times"
                        <ul>
                            <li>Lösche alle redundanten "trip_id", solche mit identischen Fahrwegen, die sich nur durch die Abfahrtzeiten unterscheiden.
                                Reduziere auf eine einzelne "trip_id" (die erste gefundene "trip_id").
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>

            <hr />

            <h2 id="analyzed">Analysierte GTFS Daten</h2>
            <div class="indent">
                <p>
                    Die GTFS-Daten des Verkehrsverbundes werden für PTNA bearbeitet. 
                    Ziel ist, herauszufinden, welche Route (Trip) Teilroute einer anderen Route ist.
                </p>
                <ul>
                    <li>Tabelle "ptna_analysis"
                        <ul>
                            <li>Füge PTNA-spezifische Information der Analyse als eigenständige Tabelle hinzu.</li>
                        </ul>
                    </li>
                    <li>Tabelle "trips"
                        <ul>
                            <li>...</li>
                        </ul>
                    </li>
                 </ul>
            </div>

            <hr />

            <h2 id="normalized">Normalisierte GTFS Daten</h2>
            <div class="indent">
                <p>
                    Die GTFS-Daten des Verkehrsverbundes werden für PTNA bearbeitet.
                    Ziel ist, eine einheitliche Schreibweise für Haltestellenammen zu erhalten.
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

