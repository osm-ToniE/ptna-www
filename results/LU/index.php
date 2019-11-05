<!DOCTYPE html>
<html lang="en">
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
        <?php
            function CreateEntry( $network ) {
                $prefixparts = explode( '-', $network );
                $countrydir  = array_shift( $prefixparts );
                if ( count($prefixparts) > 1 ) {
                    $subdir = array_shift( $prefixparts );
                    $detailsfilename  = '/osm/ptna/work/' . $countrydir . '/' . $subdir . '/' . $network . '-Analysis-details.txt';
                    $diff_filename    = $subdir . '/' . $network . '-Analysis.diff.html';
                } else {
                    $detailsfilename  = '/osm/ptna/work/' . $countrydir . '/' . $network . '-Analysis-details.txt';
                    $diff_filename    = $network . '-Analysis.diff.html';  
                }
                $data_hash = [];
                $data_hash['OLD_OR_NEW'] = 'old';
                if ( file_exists($detailsfilename) ) {
                    $lines = file( $detailsfilename, FILE_IGNORE_NEW_LINES|FILE_SKIP_EMPTY_LINES  );
    
                    foreach ( $lines as $line ) {
                        list($key,$value) = explode( '=', $line, 2 );
                        $key              = rtrim(ltrim($key));
                        $data_hash[$key]  = rtrim(ltrim($value));
                    }
                }
                if ( $data_hash['NEW_DATE_UTC'] && $data_hash['NEW_DATE_LOC'] ) {
                    echo '<td data-ref="'.$network.'-datadate" class="results-datadate"><time datetime="'.$data_hash['NEW_DATE_UTC'].'">'.$data_hash['NEW_DATE_LOC'].'</time></td>';
                } else {
                    echo '<td data-ref="'.$network.'-datadate" class="results-datadate">&nbsp;</td>';
                }
                echo "\n                        ";
                if ( $data_hash['OLD_DATE_UTC'] && $data_hash['OLD_DATE_LOC'] && $data_hash['OLD_OR_NEW'] ) {
                    echo '<td data-ref="'.$network.'-analyzed" class="results-analyzed-'.$data_hash['OLD_OR_NEW'].'"><a href="'.$diff_filename.'"><time datetime="'.$data_hash['OLD_DATE_UTC'].'">'.$data_hash['OLD_DATE_LOC'].'</time></a></td>';
                } else {
                    echo '<td data-ref="'.$network.'-analyzed" class="results-analyzed-old">&nbsp;</time></a></td>';
                }
                echo "\n";
            }
        ?>

    </head>
    <body>
      <div id="wrapper">
        <header id="headerblock">
            <div id="headerimg" class="logo">
                <a href="/"><img src="/img/logo.png" alt="logo" /></a>
            </div>
            <div id="headertext">
                <h1><a href="/">PTNA - Public Transport Network Analysis</a></h1>
                <h2>Static Analysis for OpenStreetMap</h2>
            </div>
            <div id="headernav">
                <a href="/">Home</a> |
                <a href="/contact.html">Contact</a> |
                <a target="_blank" href="https://www.openstreetmap.de/impressum.html">Impressum</a> |
                <a target="_blank" href="https://www.fossgis.de/datenschutzerklaerung">Datenschutzerklärung</a> |
                <a href="/en/index.html" title="english"><img src="/img/GreatBritain16.png" alt="Union Jack" /></a>
                <a href="/de/index.html" title="deutsch"><img src="/img/Germany16.png" alt="deutsche Flagge" /></a>
                <!-- <a href="/fr/index.html" title="français"><img src="/img/France16.png" alt="Tricolore Française" /></a> -->
            </div>
        </header>

        <main id="main" class="results">

            <h2 id="LU"><img src="/img/Luxembourg32.png" alt="Flagge Lëtzebuerg" /> Results for Lëtzebuerg / Luxemburg / Luxembourg</h2>
            <p>
                The first column includes links to the results of the analysis.
            </p>
            <p>
                The column "Latest Changes" links to an HTML page which shows the differences to the last analysis results.
                These are coloured, you can use navigation buttons <img class="diff-navigate" src="/img/diff-navigate.png" alt="Navigation"> at the right bottom or the characters 'j' (forward) and 'k' (backward) to jump from difference to difference.
                This column includes the date of the last analysis where relevant changes have emerged.
                Older dates mean that there were no changes in the results. Nevertheless, the data has been analyzed as denoted in the column "Date of Analysis".
            </p>

            <table id="networksLU">
                <thead>
                    <tr class="results-tableheaderrow">
                        <th class="results-name">Name</th>
                        <th class="results-region">City/Region</th>
                        <th class="results-network">Network</th>
                        <th class="results-datadate">Date of Analysis</th>
                        <th class="results-analyzed">Latest Changes</th>
                        <th class="results-discussion">Discussion</th>
                        <th class="results-route">Lines</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="results-tablerow">
                        <td data-ref="LU-AVL-name" class="results-name"><a href="/results/LU/LU-AVL-Analysis.html" title="to results">LU-AVL</a></td>
                        <td data-ref="LU-AVL-region" class="results-region"><a href="https://overpass-turbo.eu/map.html?Q=%5Bout%3Ajson%5D%5Btimeout%3A25%5D%3B(relation%5Bboundary%3Dadministrative%5D%5Badmin_level%3D2%5D%5Bint_name~%27Luxembourg%27%5D%3B)%3Bout%20body%3B%3E%3Bout%20skel%20qt%3B" title="show on OSM map">Lëtzebuerg</a></td>
                        <td data-ref="LU-AVL-network" class="results-network"><a href="http://autobus.lu">AVL</a></td>
                        <?php CreateEntry("LU-AVL"); ?>
                        <td data-ref="LU-AVL-discussion" class="results-discussion"><a href="https://wiki.openstreetmap.org/wiki/Talk:WikiProject_Luxembourg/Public_Transport/Analysis/AVL" title="in OSM-Wiki">Discussion</a></td>
                        <td data-ref="LU-AVL-route" class="results-route"><a href="https://wiki.openstreetmap.org/wiki/WikiProject_Luxembourg/Public_Transport/Analysis/LU-AVL-Routes" title="in OSM-Wiki">AVL Lines</a></td>
                    </tr>
                    <tr class="results-tablerow">
                        <td data-ref="LU-CFL-name" class="results-name"><a href="/results/LU/LU-CFL-Analysis.html" title="to results">LU-CFL</a></td>
                        <td data-ref="LU-CFL-region" class="results-region"><a href="https://overpass-turbo.eu/map.html?Q=%5Bout%3Ajson%5D%5Btimeout%3A25%5D%3B(relation%5Bboundary%3Dadministrative%5D%5Badmin_level%3D2%5D%5Bint_name~%27Luxembourg%27%5D%3B)%3Bout%20body%3B%3E%3Bout%20skel%20qt%3B" title="show on OSM map">Lëtzebuerg</a></td>
                        <td data-ref="LU-CFL-network" class="results-network"><a href="http://www.cfl.lu">CFL</a></td>
                        <?php CreateEntry("LU-CFL"); ?>
                        <td data-ref="LU-CFL-discussion" class="results-discussion"><a href="https://wiki.openstreetmap.org/wiki/Talk:WikiProject_Luxembourg/Public_Transport/Analysis/CFL" title="in OSM-Wiki">Discussion</a></td>
                        <td data-ref="LU-CFL-route" class="results-route"><a href="https://wiki.openstreetmap.org/wiki/WikiProject_Luxembourg/Public_Transport/Analysis/LU-CFL-Routes" title="in OSM-Wiki">CFL Lines</a></td>
                    </tr>
                    <tr class="results-tablerow">
                        <td data-ref="LU-Luxtram-name" class="results-name"><a href="/results/LU/LU-Luxtram-Analysis.html" title="to results">LU-Luxtram</a></td>
                        <td data-ref="LU-Luxtram-region" class="results-region"><a href="https://overpass-turbo.eu/map.html?Q=%5Bout%3Ajson%5D%5Btimeout%3A25%5D%3B(relation%5Bboundary%3Dadministrative%5D%5Badmin_level%3D2%5D%5Bint_name~%27Luxembourg%27%5D%3B)%3Bout%20body%3B%3E%3Bout%20skel%20qt%3B" title="show on OSM map">Lëtzebuerg</a></td>
                        <td data-ref="LU-Luxtram-network" class="results-network"><a href="http://luxtram.lu">Luxtram</a></td>
                        <?php CreateEntry("LU-Luxtram"); ?>
                        <td data-ref="LU-Luxtram-discussion" class="results-discussion"><a href="https://wiki.openstreetmap.org/wiki/Talk:WikiProject_Luxembourg/Public_Transport/Analysis/Luxtram" title="in OSM-Wiki">Discussion</a></td>
                        <td data-ref="LU-Luxtram-route" class="results-route"><a href="https://wiki.openstreetmap.org/wiki/WikiProject_Luxembourg/Public_Transport/Analysis/LU-Luxtram-Routes" title="in OSM-Wiki">Luxtram Lines</a></td>
                    </tr>
                    <tr class="results-tablerow">
                        <td data-ref="LU-RGTR-name" class="results-name"><a href="/results/LU/LU-RGTR-Analysis.html" title="to results">LU-RGTR</a></td>
                        <td data-ref="LU-RGTR-region" class="results-region"><a href="https://overpass-turbo.eu/map.html?Q=%5Bout%3Ajson%5D%5Btimeout%3A25%5D%3B(relation%5Bboundary%3Dadministrative%5D%5Badmin_level%3D2%5D%5Bint_name~%27Luxembourg%27%5D%3B)%3Bout%20body%3B%3E%3Bout%20skel%20qt%3B" title="show on OSM map">Lëtzebuerg</a></td>
                        <td data-ref="LU-RGTR-network" class="results-network"><a href="http://mobiliteit.lu">RGTR</a></td>
                        <?php CreateEntry("LU-RGTR"); ?>
                        <td data-ref="LU-RGTR-discussion" class="results-discussion"><a href="https://wiki.openstreetmap.org/wiki/Talk:WikiProject_Luxembourg/Public_Transport/Analysis/RGTR" title="in OSM-Wiki">Discussion</a></td>
                        <td data-ref="LU-RGTR-route" class="results-route"><a href="https://wiki.openstreetmap.org/wiki/WikiProject_Luxembourg/Public_Transport/Analysis/LU-RGTR-Routes" title="in OSM-Wiki">RGTR Lines</a></td>
                    </tr>
                    <tr class="results-tablerow">
                        <td data-ref="LU-TICE-name" class="results-name"><a href="/results/LU/LU-TICE-Analysis.html" title="to results">LU-TICE</a></td>
                        <td data-ref="LU-TICE-region" class="results-region"><a href="https://overpass-turbo.eu/map.html?Q=%5Bout%3Ajson%5D%5Btimeout%3A25%5D%3B(relation%5Bboundary%3Dadministrative%5D%5Badmin_level%3D2%5D%5Bint_name~%27Luxembourg%27%5D%3B)%3Bout%20body%3B%3E%3Bout%20skel%20qt%3B" title="show on OSM map">Lëtzebuerg</a></td>
                        <td data-ref="LU-TICE-network" class="results-network"><a href="http://tice.lu">TICE</a></td>
                        <?php CreateEntry("LU-TICE"); ?>
                        <td data-ref="LU-TICE-discussion" class="results-discussion"><a href="https://wiki.openstreetmap.org/wiki/Talk:WikiProject_Luxembourg/Public_Transport/Analysis/TICE" title="in OSM-Wiki">Discussion</a></td>
                        <td data-ref="LU-TICE-route" class="results-route"><a href="https://wiki.openstreetmap.org/wiki/WikiProject_Luxembourg/Public_Transport/Analysis/LU-TICE-Routes" title="in OSM-Wiki">TICE Lines</a></td>
                    </tr>
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

