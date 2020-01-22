<!DOCTYPE html>
<html lang="de">
    <head>
        <meta charset="utf-8" />
        <title>PTNA - Results</title>
        <meta name="generator" content="PTNA" />
        <meta name="keywords" content="OSM Public Transport PTv2" />
        <meta name="description" content="PTNA - Results of the Analysis of various Networks" />
        <meta name="robots" content="noindex,nofollow" />
        <link rel="stylesheet" href="/css/main.css" />
        <link rel="shortcut icon" href="/favicon.ico" />
        <link rel="icon" type="image/png" href="/favicon.png" sizes="32x32" />
        <link rel="icon" type="image/png" href="/favicon.png" sizes="96x96" />
        <link rel="icon" type="image/svg+xml" href="/favicon.svg" sizes="any" />
        <?php include('../../script/entries.php'); ?>
    </head>
    <body>
      <div id="wrapper">
        <header id="headerblock">
            <div id="headerimg" class="logo">
                <a href="/"><img src="/img/logo.png" alt="logo" /></a>
            </div>
            <div id="headertext">
                <h1><a href="/">PTNA - Public Transport Network Analysis</a></h1>
                <h2>Statische Auswertungen für OpenStreetMap</h2>
            </div>
            <div id="headernav">
                <a href="/">Home</a> |
                <a href="/contact.html">Kontakt</a> |
                <a target="_blank" href="https://www.openstreetmap.de/impressum.html">Impressum</a> |
                <a target="_blank" href="https://www.fossgis.de/datenschutzerklärung">Datenschutzerklärung</a> |
                <a href="/en/index.html" title="english"><img src="/img/GreatBritain16.png" alt="Union Jack" /></a>
                <a href="/de/index.html" title="deutsch"><img src="/img/Germany16.png" alt="deutsche Flagge" /></a>
                <!-- <a href="/fr/index.html" title="français"><img src="/img/France16.png" alt="Tricolore Française" /></a> -->
            </div>
        </header>

        <nav id="navigation">
            <h2 id="DE"><img src="/img/Switzerland32.png" alt="Schweizerfahne" /> Auswertungen für die Schweiz</h2>
            <ul>
                <!-- <li><a href="#bahnverkehr">Bahnverkehr in der Schweiz</a></li> -->
                <li><a href="#uebergreifend">Kanton-übergreifende Verkehrsverbünde in der Schweiz</a></li>
                <li><a href="#verkehrsverbuende">Verkehrsverbünde in der Schweiz</a></li>
             </ul>
        </nav>

        <hr />

        <main id="main" class="results">

            <p>
                Die erste Spalte der Tabelle enthält jeweils einen Link auf das Ergebnis der Analyse.
            </p>
            <p>
                In der Spalte "Letzte Änderung" stehen Links auf HTML-Seiten, in der die Änderungen zur vorangegangenen Auswertung farblich markiert sind -
                siehe dort die Navigationsbuttons <img class="diff-navigate" src="/img/diff-navigate.png" alt="Navigation"> unten rechts bzw. die Zeichen 'j' (vorwärts) und 'k' (rückwärts), mit denen man sich von Differenz zu Differenz "vorhangeln" kann.
                Diese Spalte enthält das Datum der letzten Auswertung bei der relevante Änderungen an den Daten vorlagen.
                Ältere Datumsangaben bedeuten, dass sich am Ergebnis der Auswertung seit diesem Datum nichts geändert hat, die Daten selber stammen jedoch vom Tag der Auswertung.
            </p>

            <hr />

<!--            <h3 id="bahnverkehr">Bahnverkehr in der Schweiz</h3>
            <table id="networksCHBahn">
                <thead>
                    <tr class="results-tableheaderrow">
                        <th class="results-name">Name</th>
                        <th class="results-region">Stadt/Kanton</th>
                        <th class="results-network">Verkehrsverbund</th>
                        <th class="results-datadate">Datum der Auswertung</th>
                        <th class="results-analyzed">Letzte Änderung</th>
                        <th class="results-discussion">Diskussion</th>
                        <th class="results-route">Linien</th>
                    </tr>
                </thead>
                <tbody>

                    <?php CreateFullEntry( "CH-Bahnverkehr" ); ?>

                </tbody>
            </table>

            <hr />
-->

            <h3 id="uebergreifend">Kanton-übergreifende Verkehrsverbünde in der Schweiz</h3>
            <table id="networksCHuebergreifend">
                <thead>
                    <tr class="results-tableheaderrow">
                        <th class="results-name">Name</th>
                        <th class="results-region">Stadt/Kanton</th>
                        <th class="results-network">Verkehrsverbund</th>
                        <th class="results-datadate">Datum der Auswertung</th>
                        <th class="results-analyzed">Letzte Änderung</th>
                        <th class="results-discussion">Diskussion</th>
                        <th class="results-route">Linien</th>
                    </tr>
                </thead>
                <tbody>

                    <?php CreateFullEntry( "CH-Ostwind" ); ?>

                </tbody>
            </table>

            <hr />

            <h3 id="verkehrsverbuende">Verkehrsverbünde in der Schweiz</h3>
            <table id="networksCHVerbund">
                <thead>
                    <tr class="results-tableheaderrow">
                        <th class="results-name">Name</th>
                        <th class="results-region">Stadt/Kanton</th>
                        <th class="results-network">Verkehrsverbund</th>
                        <th class="results-datadate">Datum der Auswertung</th>
                        <th class="results-analyzed">Letzte Änderung</th>
                        <th class="results-discussion">Diskussion</th>
                        <th class="results-route">Linien</th>
                    </tr>
                </thead>
                <tbody>

                    <!-- <?php CreateFullEntry( "CH-ZH-VZZ" ); ?> -->

                </tbody>
            </table>

        </main> <!-- main -->

        <hr />

        <footer id="footer">
            <p>
                All geographic data <a href="https://www.openstreetmap.org/copyright">© OpenStreetMap contributors</a>.
            </p>
            <p>
                This program is free software: you can redistribute it and/or modify it under the terms of the <a href="https://www.gnu.org/licenses/gpl.html">GNU GENERAL PUBLIC LICENSE, Version 3, 29 June 2007</a> as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version. Get the source code via <a href="https://github.com/osm-ToniE">GitHub</a>.
            </p>
        </footer>

      </div> <!-- wrapper -->
    </body>
</html>

