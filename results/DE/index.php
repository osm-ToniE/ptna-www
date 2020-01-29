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
            <h2 id="DE"><img src="/img/Germany32.png" alt="deutsche Flagge" /> Auswertungen für Deutschland</h2>
            <ul>
                <li><a href="#bahnverkehr">Bahnverkehr in Deutschland</a></li>
                <li><a href="#verkehrsverbuende">Verkehrsverbünde in Deutschland</a></li>
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

            <h3 id="bahnverkehr">Bahnverkehr in Deutschland</h3>
            <table id="networksDEBahn">
                <thead>
                    <tr class="results-tableheaderrow">
                        <th class="results-name">Name</th>
                        <th class="results-region">Stadt/Region</th>
                        <th class="results-network">Verkehrsverbund</th>
                        <th class="results-datadate">Datum der Auswertung</th>
                        <th class="results-analyzed">Letzte Änderung</th>
                        <th class="results-discussion">Konfiguration</th>
                        <th class="results-route">Linien</th>
                    </tr>
                </thead>
                <tbody>

                    <?php CreateNewFullEntry( "DE-Bahnverkehr", "de", "Konfiguration" ); ?>

                </tbody>
            </table>

            <hr />

            <h3 id="verkehrsverbuende">Verkehrsverbünde in Deutschland</h3>
            <table id="networksDEVerbund">
                <thead>
                    <tr class="results-tableheaderrow">
                        <th class="results-name">Name</th>
                        <th class="results-region">Stadt/Region</th>
                        <th class="results-network">Verkehrsverbund</th>
                        <th class="results-datadate">Datum der Auswertung</th>
                        <th class="results-analyzed">Letzte Änderung</th>
                        <th class="results-discussion">Konfiguration</th>
                        <th class="results-route">Linien</th>
                    </tr>
                </thead>
                <tbody>

                    <?php CreateNewFullEntry( "DE-BE-VBB", "de", "Konfiguration" ); ?>

                    <?php CreateNewFullEntry( "DE-BW-bodo", "de", "Konfiguration" ); ?>
                    
                    <?php CreateNewFullEntry( "DE-BW-DING", "de", "Konfiguration" ); ?>
                    
                    <?php CreateNewFullEntry( "DE-BW-DING-SWU", "de", "Konfiguration" ); ?>

                    <?php CreateNewFullEntry( "DE-BW-KV.SHA", "de", "Konfiguration" ); ?>

                    <?php CreateNewFullEntry( "DE-BW-RVF", "de", "Konfiguration" ); ?>

                    <?php CreateNewFullEntry( "DE-BW-VHB", "de", "Konfiguration" ); ?>

                    <?php CreateNewFullEntry( "DE-BW-VVS", "de", "Konfiguration" ); ?>

                    <?php CreateNewFullEntry( "DE-BY-AVV", "de", "Konfiguration" ); ?>

                    <?php CreateNewFullEntry( "DE-BY-CBB", "de", "Konfiguration" ); ?>

                    <?php CreateNewFullEntry( "DE-BY-DGF", "de", "Konfiguration" ); ?>

                    <?php CreateNewFullEntry( "DE-BY-FRG", "de", "Konfiguration" ); ?>

                    <?php CreateNewFullEntry( "DE-BY-INVG", "de", "Konfiguration" ); ?>

                    <?php CreateNewFullEntry( "DE-BY-LAVV", "de", "Konfiguration" ); ?>

                    <?php CreateNewFullEntry( "DE-BY-MVV", "de", "Konfiguration" ); ?>

                    <?php CreateNewFullEntry( "DE-BY-PAF", "de", "Konfiguration" ); ?>

                    <?php CreateNewFullEntry( "DE-BY-RBA", "de", "Konfiguration" ); ?>

                    <?php CreateNewFullEntry( "DE-BY-RBO", "de", "Konfiguration" ); ?>

                    <?php CreateNewFullEntry( "DE-BY-REG", "de", "Konfiguration" ); ?>

                    <?php CreateNewFullEntry( "DE-BY-RVO", "de", "Konfiguration" ); ?>

                    <?php CreateNewFullEntry( "DE-BY-RVV", "de", "Konfiguration" ); ?>

                    <?php CreateNewFullEntry( "DE-BY-VAB", "de", "Konfiguration" ); ?>

                    <?php CreateNewFullEntry( "DE-BY-VBP-VLP", "de", "Konfiguration" ); ?>

                    <?php CreateNewFullEntry( "DE-BY-VGA", "de", "Konfiguration" ); ?>

                    <?php CreateNewFullEntry( "DE-BY-VGN", "de", "Konfiguration" ); ?>

                    <?php CreateNewFullEntry( "DE-BY-VGND", "de", "Konfiguration" ); ?>

                    <?php CreateNewFullEntry( "DE-BY-VGRI", "de", "Konfiguration" ); ?>

                    <?php CreateNewFullEntry( "DE-BY-VLC", "de", "Konfiguration" ); ?>

                    <?php CreateNewFullEntry( "DE-BY-VLD", "de", "Konfiguration" ); ?>

                    <?php CreateNewFullEntry( "DE-BY-VLK", "de", "Konfiguration" ); ?>

                    <?php CreateNewFullEntry( "DE-BY-VLMÜ", "de", "Konfiguration" ); ?>

                    <?php CreateNewFullEntry( "DE-BY-VSL", "de", "Konfiguration" ); ?>

                    <?php CreateNewFullEntry( "DE-BY-VVM-Mainfranken", "de", "Konfiguration" ); ?>

                    <?php CreateNewFullEntry( "DE-BY-VVM-Mittelschwaben", "de", "Konfiguration" ); ?>

                    <?php CreateNewFullEntry( "DE-HB-VBN", "de", "Konfiguration" ); ?>

                    <?php CreateNewFullEntry( "DE-HE-NVV", "de", "Konfiguration" ); ?>

                    <?php CreateNewFullEntry( "DE-HE-RMV", "de", "Konfiguration" ); ?>

                    <?php CreateNewFullEntry( "DE-HH-HVV", "de", "Konfiguration" ); ?>

                    <?php CreateNewFullEntry( "DE-MV-MVVG", "de", "Konfiguration" ); ?>

                    <?php CreateNewFullEntry( "DE-NI-BVE", "de", "Konfiguration" ); ?>

                    <?php CreateNewFullEntry( "DE-NI-VEJ", "de", "Konfiguration" ); ?>

                    <?php CreateNewFullEntry( "DE-NI-VGC", "de", "Konfiguration" ); ?>

                    <?php CreateNewFullEntry( "DE-NI-VGE", "de", "Konfiguration" ); ?>

                    <?php CreateNewFullEntry( "DE-NI-VOS", "de", "Konfiguration" ); ?>

                    <?php CreateNewFullEntry( "DE-NI-VRB", "de", "Konfiguration" ); ?>

                    <?php CreateNewFullEntry( "DE-NW-AVV", "de", "Konfiguration" ); ?>

                    <?php CreateNewFullEntry( "DE-NW-VRR", "de", "Konfiguration" ); ?>

                    <?php CreateNewFullEntry( "DE-NW-VRS", "de", "Konfiguration" ); ?>

                    <?php CreateNewFullEntry( "DE-NW-WT", "de", "Konfiguration" ); ?>

                    <?php CreateNewFullEntry( "DE-RP-VRM", "de", "Konfiguration" ); ?>

                    <?php CreateNewFullEntry( "DE-RP-VRN", "de", "Konfiguration" ); ?>

                    <?php CreateNewFullEntry( "DE-RP-VRT", "de", "Konfiguration" ); ?>

                    <?php CreateNewFullEntry( "DE-SH-NAH.SH", "de", "Konfiguration" ); ?>

                    <?php CreateNewFullEntry( "DE-SL-saarVV", "de", "Konfiguration" ); ?>

                    <?php CreateNewFullEntry( "DE-SN-MDV", "de", "Konfiguration" ); ?>

                    <?php CreateNewFullEntry( "DE-SN-VMS", "de", "Konfiguration" ); ?>

                    <?php CreateNewFullEntry( "DE-ST-VTO", "de", "Konfiguration" ); ?>

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

