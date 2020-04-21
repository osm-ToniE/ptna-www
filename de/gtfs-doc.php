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
                <li><a href="#download">Aktualisierung der Daten</a></li>
                <li><a href="#prepare">Vorbereitung der GTFS Daten</a></li>
                <li><a href="#aggregate">Aggregierung der GTFS Daten</a>
                <li><a href="#analyze">Analyse der GTFS Daten</a>
                <li><a href="#normalize">Normalisierung der GTFS Daten</a>
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
            
            <h2 id="download">Aktualisierung der Daten</h2>
            <div class="indent">
                <p>
                    Die Aktualisierung der Daten auf dieser Seite erfolgt aus mehreren Gründen nur in unregelmäßigen Abständen:
                </p>
                <ul>
                    <li>Einige Verbünde stellen quasi täglich neue Versionen zur Verfügung ohne ein Datum anzugeben.</li>
                    <li>Einige Verbünde stellen Daten in sehr unregelmäßigen Abständen zur Verfügung.</li>
                    <li>Einige Daten lassen sich direkt und immer über den selben Link runter laden.</li>
                    <li>Einige Daten lassen sich nur indirekt über, pro Version, immer wieder andere Links runter laden - um das automatisierte Laden zu verhindern?</li>
                    <li>Zumindest das Runterladen kann nicht einfach automatisiert werden kann.</li>
                    <li>Die automatisierte Vorbereitung (hauptsächlich die <a href="#aggregate">Aggregierung</a>) der GTFS-Daten für diese Website dauert, je nach Größe des Verbundes, zwischen ein paar Sekunden (<a href="/en/gtfs-details.php?network=DE-BW-Filsland">DE-BW-Filsland</a>) und 16 Stunden (<a href="/en/gtfs-details.php?network=DE-BE-VBB">DE-BE-VBB</a>).</li>
                </ul>
            </div>

            <hr />

            <h2 id="prepare">Vorbereitung der GTFS Daten</h2>
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

            <h2 id="aggregate">Aggregierung der GTFS Daten</h2>
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

            <h2 id="analyze">Analyse der GTFS Daten</h2>
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

            <h2 id="normalize">Normalisierung der GTFS Daten</h2>
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

