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
                <a target="_blank" href="https://www.fossgis.de/datenschutzerklaerung">Datenschutzerklärung</a> |
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
                        <th class="results-discussion">Diskussion</th>
                        <th class="results-route">Linien</th>
                    </tr>
                </thead>
                <tbody>

                    <?php CreateFullEntry( "DE-Bahnverkehr" ); ?>

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
                        <th class="results-discussion">Diskussion</th>
                        <th class="results-route">Linien</th>
                    </tr>
                </thead>
                <tbody>

                    <?php CreateFullEntry( "DE-BE-VBB" ); ?>

                    <?php CreateFullEntry( "DE-BW-DING" ); ?>

                    <?php CreateFullEntry( "DE-BW-DING-SWU" ); ?>

                    <?php CreateFullEntry( "DE-BW-KV.SHA" ); ?>

                    <?php CreateFullEntry( "DE-BW-RVF" ); ?>

                    <?php CreateFullEntry( "DE-BW-VVS" ); ?>

                    <?php CreateFullEntry( "DE-BY-AVV" ); ?>

                    <?php CreateFullEntry( "DE-BY-CBB" ); ?>

                    <?php CreateFullEntry( "DE-BY-DGF" ); ?>

                    <?php CreateFullEntry( "DE-BY-FRG" ); ?>

                    <?php CreateFullEntry( "DE-BY-INVG" ); ?>

                    <?php CreateFullEntry( "DE-BY-LAVV" ); ?>

                    <?php CreateFullEntry( "DE-BY-MVV" ); ?>

                    <?php CreateFullEntry( "DE-BY-PAF" ); ?>

                    <?php CreateFullEntry( "DE-BY-RBA" ); ?>

                    <?php CreateFullEntry( "DE-BY-RBO" ); ?>

                    <?php CreateFullEntry( "DE-BY-REG" ); ?>

                    <?php CreateFullEntry( "DE-BY-RVO" ); ?>

                    <?php CreateFullEntry( "DE-BY-RVV" ); ?>

                    <?php CreateFullEntry( "DE-BY-VAB" ); ?>

                    <?php CreateFullEntry( "DE-BY-VBP-VLP" ); ?>

                    <?php CreateFullEntry( "DE-BY-VGA" ); ?>

                    <?php CreateFullEntry( "DE-BY-VGN" ); ?>

                    <?php CreateFullEntry( "DE-BY-VGND" ); ?>

                    <?php CreateFullEntry( "DE-BY-VGRI" ); ?>

                    <?php CreateFullEntry( "DE-BY-VLC" ); ?>

                    <?php CreateFullEntry( "DE-BY-VLD" ); ?>

                    <?php CreateFullEntry( "DE-BY-VLK" ); ?>

                    <?php CreateFullEntry( "DE-BY-VLMÜ" ); ?>

                    <?php CreateFullEntry( "DE-BY-VSL" ); ?>

                    <?php CreateFullEntry( "DE-BY-VVM-Mainfranken" ); ?>

                    <?php CreateFullEntry( "DE-BY-VVM-Mittelschwaben" ); ?>

                    <?php CreateFullEntry( "DE-HB-VBN" ); ?>

                    <?php CreateFullEntry( "DE-HE-NVV" ); ?>

                    <?php CreateFullEntry( "DE-HE-RMV" ); ?>

                    <?php CreateFullEntry( "DE-HH-HVV" ); ?>

                    <?php CreateFullEntry( "DE-MV-MVVG" ); ?>

                    <?php CreateFullEntry( "DE-NI-BVE" ); ?>

                    <?php CreateFullEntry( "DE-NI-VEJ" ); ?>

                    <?php CreateFullEntry( "DE-NI-VGC" ); ?>

                    <?php CreateFullEntry( "DE-NI-VGE" ); ?>

                    <?php CreateFullEntry( "DE-NI-VOS" ); ?>

                    <?php CreateFullEntry( "DE-NI-VRB" ); ?>

                    <?php CreateFullEntry( "DE-NW-AVV" ); ?>

                    <?php CreateFullEntry( "DE-NW-VRR" ); ?>

                    <?php CreateFullEntry( "DE-NW-VRS" ); ?>

                    <?php CreateFullEntry( "DE-NW-WT" ); ?>

                    <?php CreateFullEntry( "DE-RP-VRM" ); ?>

                    <?php CreateFullEntry( "DE-RP-VRN" ); ?>

                    <?php CreateFullEntry( "DE-RP-VRT" ); ?>

                    <?php CreateFullEntry( "DE-SH-NAH.SH" ); ?>

                    <?php CreateFullEntry( "DE-SL-saarVV" ); ?>

                    <?php CreateFullEntry( "DE-SN-MDV" ); ?>

                    <?php CreateFullEntry( "DE-SN-VMS" ); ?>

                    <?php CreateFullEntry( "DE-ST-VTO" ); ?>

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

