<!DOCTYPE html>
<html lang="de">

<?php $title="GTFS"; include "html-head.inc" ?>

    <body>
      <div id="wrapper">

<?php include "header.inc" ?>

        <nav id="navigation">
            <h2>GTFS</h2>
            <ul>
                <li><a href="#gtfsdata">Was sind GTFS-Daten?</a></li>
                <li><a href="#download">Aktualisierung der Daten</a></li>
                <li><a href="#prepare">Vorbereitung der GTFS-Daten</a></li>
                <li><a href="#aggregate">Aggregierung der GTFS-Daten</a>
                <li><a href="#analyze">Analyse der GTFS-Daten</a>
                <li><a href="#normalize">Normalisierung der GTFS-Daten</a>
            </ul>
        </nav>

        <hr />

        <main id="main">

            <h2 id="gtfsdata">Was sind GTFS-Daten?</h2>
            <div class="indent">
                <p>
                    GTFS-Daten ... Zitat von Googles Web-Site zu <a href="https://developers.google.com/transit/gtfs">GTFS</a> (Übersetzt mit www.DeepL.com/Translator):
                </p>
                <p>"<i>Die General Transit Feed Specification (GTFS) [...] definiert ein gemeinsames Format für Fahrpläne des öffentlichen Verkehrs und die
                       damit verbundenen geografischen Informationen.
                       GTFS-"Feeds" ermöglichen es den Verkehrsbetrieben, ihre Verkehrsdaten zu veröffentlichen, und die Entwickler schreiben Anwendungen,
                       die diese Daten auf interoperable Weise nutzen.</i>"
                </p>
                <p>
                    Die GTFS-Daten bestehen aus einer Reihe von *.txt-Dateien, die in einem *.zip-Archiv gepackt sind.
                    Die Daten in den *.txt-Dateien sind als CSV-Daten strukturiert.
                    Die verschiendenen Dateien wiederum können als Datenbanktabellen verwendet werden.
                    PTNAs GTFS-Analyse nutzt hierzu die einfache, Datei-basierte <strong>SQLite</strong> Software.
                </p>
                <ul>
                    <li><strong>feed_info.txt</strong>
                        <div class="indent">
                            enthält im Wesentlichen Informationen über den Herausgeber (Eigentümer) der Daten sowie optionale Informationen über die Version und Gültigkeitsdauer der Daten.
                        </div>
                    </li>
                    <li><strong>agency.txt</strong>
                        <div class="indent">
                            enthält Informationen über die 'transit agency'.
                            Die darin aufgelisteten 'agencies' können im OSM-Sinne als 'network' oder als 'operator' interpretiert werden.
                            Das hängt davon ab, was der Herausgeber der Daten unter 'transit agency' versteht.
                        </div>
                    </li>
                    <li><strong>routes.txt</strong>
                        <div class="indent">
                            enthält Informationen über ...
                        </div>
                    </li>
                    <li><strong>trips.txt</strong>
                        <div class="indent">
                            enthält Informationen über ...
                        </div>
                    </li>
                    <li><strong>stops.txt</strong>
                        <div class="indent">
                            enthält Informationen über ...
                        </div>
                    </li>
                    <li><strong>stop_times.txt</strong>
                        <div class="indent">
                            enthält Informationen über ...
                        </div>
                    </li>
                    <li><strong>shapes.txt</strong>
                        <div class="indent">
                            enthält Informationen über ...
                        </div>
                    </li>
                    <li><strong>calendar.txt</strong>
                        <div class="indent">
                            enthält Informationen über ...
                        </div>
                    </li>
                    <li><strong>calendar_dates.txt</strong>
                        <div class="indent">
                            enthält Informationen über ...
                        </div>
                    </li>
                </ul>
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
                    <li>ÖPNV-Relationen sollten in OSM einen langfristigen Charakter haben. Ist es sinnvoll jede baustellen-bedingte Änderung einer Buslinie in OSM zu mappen um das später wieder rückgängig zu machen?</li>
                </ul>
            </div>

            <hr />

            <h2 id="prepare">Vorbereitung der GTFS-Daten</h2>
            <div class="indent">
                <p>
                    Die GTFS-Daten des Verkehrsverbundes werden für die Verwendung in PTNA vorbereitet.
                </p>
                <ul>
                    <li>Tabelle "osm"
                        <ul>
                            <li>Füge OSM-spezifische Information als eigenständige Tabelle hinzu.
                                <ul>
                                    <li>Wert von 'network' bei PT-Relationen (z.B. "Münchner Verkehrs- und Tarifverbund").</li>
                                    <li>Wert von 'network:short' bei PT-Relationen (z.B. "MVV").</li>
                                    <li>Wert von 'network:guid' bei PT-Relationen (z.B. "DE-BY-MVV").</li>
                                    <li>Wert von 'operator bei PT-Relationen: kann "agency_name" aus der GTFS-Tabelle "agency.txt" als 'operator' verwendet werden?</li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                    <li>Tabelle "ptna"
                        <ul>
                            <li>Füge PTNA-spezifische Information als eigenständige Tabelle hinzu.</li>
                        </ul>
                    </li>
                    <li>Andere Tabellen
                        <ul>
                            <li>Das Feld "ptna_comment" wird hinzugefügt.
                                Hiermit können Anmerkungen eingetragen werden - siehe "Analyse der GTFS-Daten.
                            </li>
                        </ul>
                    </li>
               </ul>
            </div>

            <hr />

            <h2 id="aggregate">Aggregierung der GTFS-Daten</h2>
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

            <h2 id="analyze">Analyse der GTFS-Daten</h2>
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

            <h2 id="normalize">Normalisierung der GTFS-Daten</h2>
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
