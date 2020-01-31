<!DOCTYPE html>
<html lang="de">

<?php include "html-head.inc" ?>

    <body>
      <div id="wrapper">
      
<?php include "header.inc" ?>

        <nav id="navigation">
            <h2>Dokumentation</h2>
            <ul>
                <li><a href="#motivation">Motivation</a></li>
                <li><a href="#overview">Überblick</a></li>
                <li><a href="#web">Die Web-site</a>
                    <ul>
                        <li><a href="#analysislist">Die Auswertungen</a></li>
                    </ul>
                </li>
                <li><a href="#networkroutes">Die zum Verkehrsverbund gehörigen Linien</a></li>
                <li><a href="#analysis">Die Analyse</a>
                    <ul>
                        <li><a href="#routesdescription">Beschreibung der erwarteten Linien</a></li>
                        <li><a href="#overpass">Download der Daten aus OSM</a></li>
                        <li><a href="#analysissettings">Definition von Auswertungsoptionen</a></li>
                        <li><a href="#dataanalysis">Analyse der Daten</a>
                            <ul>
                                <li><a href="#analysisdate">Datum der Daten</a></li>
                                <li><a href="#analysisroutes">Überblick über die ÖPNV-Linien ...</a></li>
                                <li><a href="#analysisnotassigned">Nicht eindeutig zugeordnete Linien</a></li>
                                <li><a href="#analysisother">Andere ÖPNV-Linien</a></li>
                                <li><a href="#analysisnoref">ÖPNV-Linien ohne 'ref'</a></li>
                                <li><a href="#analysisrelations">Weitere Relationen</a></li>
                                <li><a href="#analysisnetwork">Details zu 'network'-Werten</a>
                                    <ul>
                                       <li><a href="#analysisnetworkconsidered">Berücksichtigte 'network' Werte</a></li>
                                       <li><a href="#analysisnetworknotconsidered">Nicht berücksichtigte 'network' Werte</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                        <li><a href="#checks">Prüfungen</a>
                            <ul>
                                <li><a href="#scheme">Verwendetes Schema</a>
                                   <ul>
                                      <li><a href="#deviations">Abweichungen</a></li>
                                      <li><a href="#specials">Besonderheiten</a></li>
                                    </ul>
                                </li>
                                <li><a href="#approach">Vorgehensweise</a></li>
                                <li><a href="#options">Auswertungsoptionen</a></li>
                                <li><a href="#messages">Meldungen</a></li>
                            </ul>
                        </li>
                    </ul>
                </li>
                <li><a href="#code">Der Code</a>
                    <ul>
                        <li><a href="#ptna">ptna</a></li>
                        <li><a href="#ptnanetworks">ptna-networks</a></li>
                        <li><a href="#ptnawww">ptna-www</a></li>
                    </ul>
                </li>
            </ul>
        </nav>

        <hr />

        <main id="main">

            <h2 id="motivation">Motivation</h2>
            <div class="indent">
                <p>
                    Erste <a href="https://wiki.openstreetmap.org/wiki/Talk:M%C3%BCnchen/Transportation#Qualit.C3.A4tssicherung_-_M.C3.BCnchen.2FTransportation">Diskussionen</a> fanden auf einem Münchner Stammtisch im Februar 2017 statt.
                </p>
                <p>
                    Ausgelöst wurde die ganze Diskussion durch unbeabsichtigtes Löschen von Bus-Relationen im Münchener Umfeld (es wurden aber neue Relationen erstellt).
                    Dadurch waren viele Links auf der Seite <a href="https://wiki.openstreetmap.org/wiki/München/Transportation#Verkehrsmittel">München/Transportation</a> nicht mehr aktuell.
                    Allerdings muss man auch sagen, dass die Seite in der Vergangenheit eh nicht gut gepflegt war, z.T. gar nicht bekannt war.
                    Die Qualität und Aktualität der Seite scheint also ein generelles Problem zu sein.
                </p>
                <p>
                    <strong>Problem:</strong> es hapert mit der Qualität der <a class="a" href="https://wiki.openstreetmap.org/wiki/München/Transportation#Verkehrsmittel">München/Transportation</a> Seite:
                </p>
                <ul>
                    <li>Vollständigkeit:
                        <ul>
                            <li>wir wissen nicht, ob wir alle existierenden Buslinien des MVV auf der Seite aufgelistet haben</li>
                            <li>wir wissen nicht, ob wir Artefakte, d.h. Buslinien gemapped haben die bereits (wieder) eingestellt oder umnummeriert worden sind</li>
                            <li>S-Bahn, U-Bahn und Tram sind in ihrer Anzahl überschaubar, da besteht die Chance, dass wir vollständig sind</li>
                        </ul>
                    </li>
                    <li>PTv2:
                        <ul>
                            <li>wir wissen nicht, welche der Linien schon auf "Public-Transport Version 2" umgestellt sind.</li>
                            <li><a href="https://wiki.openstreetmap.org/wiki/DE:Public_Transport">DE:Public_transport</a>. Den originalen Wortlaut des Proposals findet man unter
                                <a href="https://wiki.openstreetmap.org/w/index.php?title=Proposed_features/Public_Transport&amp;oldid=625726">Approved Feature Public Transport (approved Version 625726)</a>
                            </li>
                        </ul>
                    </li>
                    <li>Korrektheit:
                        <ul>
                            <li>wir wissen nicht, ob die auf PTv2 umgestellten Linien durchgängig und sortiert sind</li>
                            <li>d.h. ob die Ways komplett, in der richtigen Reihenfolge, ohne Lücken, ohne Fortsätze und bei Kreisverkehren korrekt erfasst sind</li>
                            <li>ob die "stop" und "platform" Member komplett und in der richtigen Reihenfolge erfasst sind</li>
                        </ul>
                    </li>
                    <li>Einheitlichkeit:
                        <ul>
                            <li>wir wissen nicht, ob alle Relationen mit ihren Tags komplett und korrekt sind</li>
                            <li>d.h. mit vorhanden, korrekten und gegebenenfalls einheitlichen "network", "operator",
                                "public_transport:version", "name", "ref", "from", "to" (und "via"), ...
                            </li>
                        </ul>
                    </li>
                    <li>Übersichtlichkeit:
                        <ul>
                            <li>wir haben keine Seite, auf der uns all das, <strong>vor allem aber die Probleme damit</strong>, übersichtlich angezeigt wird
                            </li>
                        </ul>
                    </li>
                    <li>Automatisierbarkeit:
                        <ul>
                            <li>wir haben keine Möglichkeit eine solche Übersichtsseite automatisiert zu erstellen (wöchentlich, ...)
                            </li>
                        </ul>
                    </li>
                </ul>
                <p>
                    <strong>Ursachen</strong> gibt es viele:
                </p>
                <ul>
                    <li>Vollständigkeit:
                        <ul>
                            <li>woher sollen wir die Informationen bekommen? Wir erhalten u.U. vom MVV eine Liste (CSV, ...)</li>
                        </ul>
                    </li>
                    <li>PTv2:
                        <ul>
                            <li>einige Linien haben weder "Version" 1 noch 2 als Tag: vergessen, Unkenntnis der Existenz ...</li>
                         </ul>
                    </li>
                    <li>Korrektheit:
                        <ul>
                            <li>das ist eine mühsame Kleinarbeit, die immer wieder und wieder angestoßen werden muss, da Relationen schnell mal (unbeabsichtigt) mit Lücken "versehen werden", ...</li>
                        </ul>
                    </li>
                    <li>Einheitlichkeit:
                        <ul>
                            <li>was ist denn der Standard? network=MVV oder network="Münchner Verkehrs- und Tarif-Verbund" und so weiter? <a href="https://wiki.openstreetmap.org/wiki/München/Transportation#Vorschlag_für_vereinheitliches_Tagging">München/Transportation Vorschlag_für_vereinheitliches_Tagging</a></li>
                        </ul>
                    </li>
                    <li>Übersichtlichkeit:
                        <ul>
                            <li>Teile der Seite sind schon übersichtlicher gestaltet, wie könnte eine übersichtlichere Seite aussehen (Layout?)</li>
                        </ul>
                    </li>
                    <li>Automatisierbarkeit:
                        <ul>
                            <li>da gibt es nichts</li>
                        </ul>
                    </li>
                </ul>
                <p>
                    Ein nicht repräsentativer Blick auf Berlin, Hamburg und Aachen zeigt, dass andere Städte u.U. das gleiche Problem haben.
                </p>
            </div> <!-- "motivation" -->

            <hr />

            <h2 id="overview">Überblick</h2>
            <div class="indent">
                <p>
                    Lorem ipsum dolor sit amet, consectetur adipisici elit, …
                </p>
            </div> <!-- "overview" -->

            <hr />

            <h2 id="web">Die Web-site</h2>
            <div class="indent">
                <p>
                    Lorem ipsum dolor sit amet, consectetur adipisici elit, …
                </p>
                <h3 id="analysislist">Die Auswertungen</h3>
                <div class="indent">
                    <p>
                        Lorem ipsum dolor sit amet, consectetur adipisici elit, …
                    </p>
                    <ul>
                        <li>Name</li>
                        <li>City/Region</li>
                        <li>Verkehrsverbund</li>
                        <li>Auswertung</li>
                        <li>Letzte Änderung</li>
                        <li>Diskussion</li>
                        <li>Linien</li>
                    </ul>
                </div> <!-- "analysislist" -->
            </div> <!-- "web" -->

            <hr />

            <h2 id="networkroutes">Die zum Verkehrsverbund gehörigen Linien</h2>
            <div class="indent">
                <p>
                    <strong>Wichtig: Beachte das Copyright &copy; des Verkehrsverbundes bzw. die Herkunft der Daten!</strong><br /><br />
                    Lorem ipsum dolor sit amet, consectetur adipisici elit, …
                </p>
                <p>
                    <strong>Beachte: Die Liste wird unter der <a href="https://www.gnu.org/licenses/gpl.html">GPL 3</a> veröffentlicht.</strong>
                </p>
            </div> <!-- "networkroutes" -->

            <hr />

            <h2 id="analysis">Die Analyse</h2>
            <div class="indent">
                <p>
                    Lorem ipsum dolor sit amet, consectetur adipisici elit, …
                </p>

                <h3 id="routesdescription">Beschreibung der erwarteten Linien</h3>
                <div class="indent">
                    <p>
                        <strong>Wichtig: Beachte das Copyright &copy; des Verkehrsverbundes bzw. die Herkunft der Daten!</strong><br /><br />
                        Lorem ipsum dolor sit amet, consectetur adipisici elit, …
                    </p>
                    <p>
                        <strong>Beachte: Die Liste wird unter der <a href="https://www.gnu.org/licenses/gpl.html">GPL 3</a> veröffentlicht.</strong>
                    </p>
                    <p>
                        Beispiel: Linien des <a href="https://wiki.openstreetmap.org/wiki/M%C3%BCnchen/Transportation/MVV-Linien-gesamt">Münchner Verkehrs- und Tarifverbund</a> im OSM Wiki
                    </p>
                </div> <!-- "routesdescription" -->

                <h3 id="overpass">Download der Daten aus OSM</h3>
                <div class="indent">
                    <p>
                        Für den Download der Daten wird das Overpass-API verwendet.
                        Die Abfrage erfolgt außerhalb des eigentlichen Analysetools durch einen <code>wget</code>-Aufruf unter Linux.<br />
                    </p>
                    Die Abfrage selber gliedert sich in 3 große Teile:

		    <h4 id="searcharea">Definition des Suchgebietes</h4>
                    <div class="indent">
                        Folgenden Möglichkeiten gibt es:
                                <ul>
                                    <li>Namen der Kreise oder/und Landkreise<br />
                                        Beispiel: boundary=administrative und admin_level=6 und name~'(Dachau|München|Ebersberg|Erding|Starnberg|Freising|Tölz|Wolfratshausen|Fürstenfeldbruck)'
                                    </li>
                                    <li>Name des Regierungsbezirks<br />
                                        Beispiel: boundary=administrative und admin_level=5 und name='Oberbayern'
                                    </li>
                                    <li>Name des Verkehrsverbundes, sofern es dazu einen Relation gibt<br />
                                        Beispiel: boundary=public_transport und name='Verkehrsverbund Rhein-Sieg'
                                    </li>
                                    <li>Oder die Liste von Geokoordinaten eines umschließenden Polygons<br />
                                        Beispiel, einfaches Rechteck: poly:'48.0770 11.6378 48.0436 11.6378 48.0436 11.7024 48.0770 11.7024'<br />
                                    </li>
                                </ul>
                                    Hinweis: Die Definition mittels poly:'...' ist der aufwändigste aber zugleich auch der sicherste Weg:
                                <ul>
                                   <li>er ist eindeutig, denn z.b. einen Landkreis: admin_level=6 mit name="Coburg" mag es weltweit mehrfach geben.</li>
                                   <li>eine Relation mit type=boundary kann Lücken enthalten, es werden dann keine Daten runter geladen.</li>
                                </ul>
                            </li>
		    </div> <!-- searcharea -->

		    <h4 id="searchdata">Auswahl und Abspeichern aller relevanten Route und deren Route-Master Relationen</h4>
                    <div class="indent">
                        <p>
                            Lorem ipsum dolor sit amet, consectetur adipisici elit, …
                        </p>
		    </div> <!-- searchdata -->
		    
		    <h4 id="searchoutput">Ausgabe der relevanten Informationen</h4>
                    <div class="indent">
                        <p>
                            Siehe: <a href="https://wiki.openstreetmap.org/wiki/User:ToniE/analyze-routes#Download_der_Daten_via_Overpass-API_Abfrage">OSM Wiki</a>
                        </p>
		    </div> <!-- searchoutput -->
                    <p>
                        Beispiel: Overpass-API query für <a href="https://wiki.openstreetmap.org/wiki/Talk:M%C3%BCnchen/Transportation/Analyse#Overpass-API_Abfrage">Münchner Verkehrs- und Tarifverbund</a>
                    </p>
                </div> <!-- "overpass" -->

                <h3 id="analysissettings">Definition von Auswertungsoptionen</h3>
                <div class="indent">
                    <p>
                        Lorem ipsum dolor sit amet, consectetur adipisici elit, …
                    </p>
                    <p>
                        Beispiel: Optionen für <a href="https://wiki.openstreetmap.org/wiki/Talk:M%C3%BCnchen/Transportation/Analyse#Auswertungsoptionen">Münchner Verkehrs- und Tarifverbund</a>
                    </p>
                </div> <!-- "#analysissettings" -->

                <h3 id="dataanalysis">Analyse der Daten</h3>
                <div class="indent">
                    <p>
                        Lorem ipsum dolor sit amet, consectetur adipisici elit, …
                    </p>

                    <h4 id="analysisdate">Datum der Daten</h4>
                    <div class="indent">
                        <p>
                            Lorem ipsum dolor sit amet, consectetur adipisici elit, …
                        </p>
                        <p>
                            Beispiel: <a href="/results/DE/BY/DE-BY-MVV-Analysis.html#A1">Münchner Verkehrs- und Tarifverbund</a>
                        </p>
                    </div> <!-- "analysisdate" -->

                    <h4 id="analysisroutes">Überblick über die ÖPNV-Linien ... </h4>
                    <div class="indent">
                        <p>
                            Lorem ipsum dolor sit amet, consectetur adipisici elit, …
                        </p>
                        <p>
                            Beispiel: <a href="/results/DE/BY/DE-BY-MVV-Analysis.html#A2">Münchner Verkehrs- und Tarifverbund</a>
                        </p>
                    </div> <!-- "analysisroutes" -->

                    <h4 id="analysisnotassigned">Nicht eindeutig zugeordnete Linien</h4>
                    <div class="indent">
                        <p>
                            Lorem ipsum dolor sit amet, consectetur adipisici elit, …
                        </p>
                        <p>
                            Beispiel: <a href="/results/DE/SN/DE-SN-VMS-Analysis.html#A3">Verkehrsverbund Mittelsachsen</a>
                        </p>
                    </div> <!-- "analysisnotassigned" -->

                    <h4 id="analysisother">Andere ÖPNV-Linien</h4>
                    <div class="indent">
                        <p>
                            Übrig bleiben die Linien, die
                        </p>
                        <ul>
                            <li>den network-Tag Kriterien entsprechen und</li>
                            <li>eben nicht in der Liste (CSV-Datei) "Beschreibung der erwarteten Linien" vorkommen.</li>
                        </ul>

                        <p>
                            Taucht in dieser Liste ("Andere ÖPNV-Linien") z.B. eine Linie 724 auf, und
                        </p>
                        <ul>
                            <li>das 'network' tag ist gesetzt und passt zum analysierten Verkehrsverbund?
                                <ul>
                                    <li>Die Linie wurde u.U. eingestellt - denn sonst würde sie bei der Liste "Überblick über die ÖPNV-Linien ... " auftauchen.</li>
                                    <li>Die Linie existiert tatsächlich und fehlt in der Liste (CSV-Datei) "Beschreibung der erwarteten Linien".</li>
                                </ul>
                            </li>
                            <li>das 'network' tag ist nicht gesetzt und müsste eigentlich zum analysierten Verkehrsverbund passen?
                                <ul>
                                    <li>Die Linie wurde u.U. eingestellt - denn sonst würde sie bei der Liste "Überblick über die ÖPNV-Linien ... " auftauchen.</li>
                                    <li>Die Linie existiert tatsächlich und fehlt in der Liste (CSV-Datei) "Beschreibung der erwarteten Linien".</li>
                                </ul>
                            </li>
                            <li>das 'network' tag ist nicht gesetzt und müsste eigentlich zu einem anderen Verkehrsverbund passen?
                                <ul>
                                    <li>Das 'network' tag mit dem korrekten Wert des anderen Verkehrsverbundes zu belegen lässt die Linie aus der Auswertung verschwinden.</li>
                                </ul>
                            </li>
                        </ul>
                        <p>
                            Beispiel: <a href="/results/DE/BY/DE-BY-RVO-Analysis.html#A3">Regionalverkehr Oberbayern</a>
                        </p>
                    </div> <!-- "analysisother" -->

                    <h4 id="analysisnoref">ÖPNV-Linien ohne 'ref'</h4>
                    <div class="indent">
                        <p>
                            Hierzu zählen alle Linien, die
                        </p>
                        <ul>
                            <li>keinen ref-Tag haben
                                <ul>
                                    <li>egal, ob sie den network-Tag Kriterien entsprechen oder nicht</li>
                                </ul>
                            </li>
                        </ul>
                        <p>
                            Beispiel: <a href="/results/DE/NI/DE-NI-VEJ-Analysis.html#A4">Verkehrsverbund Ems-Jade</a>
                        </p>
                    </div> <!-- "analysisnoref" -->

                    <h4 id="analysisrelations">Weitere Relationen</h4>
                    <div class="indent">
                        <p>
                            Lorem ipsum dolor sit amet, consectetur adipisici elit, …
                        </p>
                        <p>
                            Dieser Abschnitt enthält weitere Relationen aus dem Umfeld der Linien:
                        </p>
                        <ul>
                            <li>evtl. falsche 'route' oder 'route_master' Werte?
                                <ul>
                                    <li>z.B. 'route' = "suspended_bus" statt 'route' = "bus"</li>
                                </ul>
                            </li>
                            <li>aber auch 'type' = 'network' oder 'route' = "network", d.h. eine Sammlung aller zum 'network' gehörenden Route und Route-Master.
                                <ul>
                                    <li>solche <strong>Sammlungen sind streng genommen Fehler</strong>, da Relationen keinen Sammlungen darstellen sollen: Relationen sind keine Kategorien</li>
                                </ul>
                            </li>
                            <li>Lorem ipsum dolor sit amet, consectetur adipisici elit, …</li>
                        </ul>

                        <p>
                            Die Darstellung erfolgt in diesem Abschnitt lediglich mit der Relation-ID und markanten Tags.
                        </p>
                        <p>
                            Beispiel: <a href="/results/DE/NW/DE-NW-VRS-Analysis.html#A5">Verkehrsverbund Rhein-Sieg (VRS)</a>
                        </p>
                    </div> <!-- "analysisrelations" -->

                    <h4 id="analysisnetwork">Details zu 'network'-Werten</h4>
                    <div class="indent">
                        <p>
                            Das 'network' Tag wird nach den folgenden Werten durchsucht:
                        </p>
                        <ul>
                            <li>"langer" Name des Verkehrsverbundes</li>
                            <li>"kurzer" Name des Verkehrsverbundes</li>
                            <li>'network' ist nicht gesetzt</li>
                        </ul>

                        <h5 id="analysisnetworkconsidered">Berücksichtigte 'network' Werte</h5>
                        <div class="indent">
                            <p>
                                Dieser Abschnitt listet die 'network'-Werte auf, die berücksichtigt wurden, d.h. einen der oben genannten Werte enthält.
                            </p>
                            <p>
                                Beispiel: <a href="/results/DE/SN/DE-SN-VMS-Analysis.html#A7.1">Verkehrsverbund Mittelsachsen (VMS)</a>
                            </p>
                        </div> <!-- "analysisnetworkconsidered" -->

                        <h5 id="analysisnetworknotconsidered">Nicht berücksichtigte 'network' Werte</h5>
                        <div class="indent">
                            <p>
                                Dieser Abschnitt listet die 'network'-Werte auf, die nicht berücksichtigt wurden. Darunter können auch Tippfehler in ansonsten zu berücksichtigenden Werten sein.
                            </p>
                            <p>
                                Beispiel: <a href="/results/DE/SN/DE-SN-VMS-Analysis.html#A7.2">Verkehrsverbund Mittelsachsen (VMS)</a>
                            </p>
                        </div> <!-- "analysisnetworknotconsidered" -->
                    </div> <!-- "analysisnetwork" -->
                </div> <!-- "dataanalysis" -->

                <h3 id="checks">Prüfungen</h3>
                <div class="indent">
                    <p>
                        Lorem ipsum dolor sit amet, consectetur adipisici elit, …
                    </p>

                    <h4 id="scheme">Verwendetes Schema</h4>
                    <div class="indent">
                        <p>
                            Lorem ipsum dolor sit amet, consectetur adipisici elit, …
                        </p>
                        <p>
                            Siehe: <a href="https://wiki.openstreetmap.org/wiki/User:ToniE/analyze-routes#Verwendetes_Schema">OSM Wiki</a>
                        </p>

                        <h5 id="deviations">Abweichungen</h5>
                        <div class="indent">
                            <p>
                                Lorem ipsum dolor sit amet, consectetur adipisici elit, …
                            </p>
                            <p>
                                Siehe: <a href="https://wiki.openstreetmap.org/wiki/User:ToniE/analyze-routes#Abweichungen">OSM Wiki</a>
                            </p>
                        </div> <!-- "deviations" -->

                        <h5 id="specials">Besonderheiten</h5>
                        <div class="indent">
                            <p>
                                Lorem ipsum dolor sit amet, consectetur adipisici elit, …
                            </p>
                            <p>
                                Siehe: <a href="https://wiki.openstreetmap.org/wiki/User:ToniE/analyze-routes#Besonderheiten">OSM Wiki</a>
                            </p>
                        </div> <!-- "specials" -->
                    </div> <!-- "scheme" -->

                    <h4 id="approach">Vorgehensweise</h4>
                    <div class="indent">
                        <p>
                            Lorem ipsum dolor sit amet, consectetur adipisici elit, …
                        </p>
                        <p>
                            Siehe: <a href="https://wiki.openstreetmap.org/wiki/User:ToniE/analyze-routes#Vorgehensweise">OSM Wiki</a>
                        </p>
                    </div> <!-- "approach" -->

                    <h4 id="options">Auswertungsoptionen</h4>
                    <div class="indent">
                        <p>
                            Lorem ipsum dolor sit amet, consectetur adipisici elit, …
                        </p>

<?php include "option-table.inc" ?>

                    </div> <!-- "messages" -->

                    <h4 id="messages">Meldungen</h4>
                    <div class="indent">
                        <p>
                            Lorem ipsum dolor sit amet, consectetur adipisici elit, …
                        </p>

<?php include "message-table.inc" ?>

                    </div> <!-- "messages" -->

                </div> <!-- "checks" -->
            </div> <!-- "analysis" -->

            <hr />

            <h2 id="code">Der Code</h2>
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
                        Siehe: <a href="https://github.com/osm-ToniE/ptna">ptna auf GitHub</a>
                    </p>
                </div> <!-- "ptna" -->

                <h3 id="ptnanetworks">ptna-networks</h3>
                <div class="indent">
                    <p>
                        Lorem ipsum dolor sit amet, consectetur adipisici elit, …
                    </p>
                    <p>
                        Siehe: <a href="https://github.com/osm-ToniE/ptna-networks">ptna-networks auf GitHub</a>
                    </p>
                </div> <!-- "ptnanetworks" -->

                <h3 id="ptnawww">ptna-www</h3>
                <div class="indent">
                    <p>
                        Lorem ipsum dolor sit amet, consectetur adipisici elit, …
                    </p>
                    <p>
                        Siehe: <a href="https://github.com/osm-ToniE/ptna-www">ptna-www auf GitHub</a>
                    </p>
                </div> <!-- "ptnawww" -->
            </div> <!-- "code" -->
        </main>

        <hr />

<?php include "footer.inc" ?>

	</div> <!-- wrapper -->
    </body>
</html>

