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

            <h2 id="EU"><img src="/img/Europe32.png" alt="Europaflagge" /> Results for Europe</h2>
            <p>
                The first column includes a link to the results of the analysis.
            </p>
            <p>
                The column "Latest Changes" links to an HTML page which shows the differences to the last analysis results.
                These are coloured, you can use navigation buttons <img class="diff-navigate" src="/img/diff-navigate.png" alt="Navigation"> at the right bottom or the characters 'j' (forward) and 'k' (backward) to jump from difference to difference.
                This column includes the date of the last analysis where relevant changes have emerged.
                Older dates mean that there were no changes in the results. Nevertheless, the data has been analyzed as denoted in the column "Date of Analysis".
            </p>

            <table id="networksEU">
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
                        <td data-ref="EU-Flixbus-name" class="results-name"><a href="/results/EU/EU-Flixbus-Analysis.html" title="to results">EU-Flixbus</a></td>
                        <td data-ref="EU-Flixbus-region" class="results-region">Europe</td>
                        <td data-ref="EU-Flixbus-network" class="results-network">Flixbus;FlixTrain</td>
                        <?php CreateEntry("EU-Flixbus"); ?>
                        <td data-ref="EU-Flixbus-discussion" class="results-discussion"><a href="https://wiki.openstreetmap.org/wiki/Talk:Europa/Transportation/Analyse/Flixbus" title="in OSM-Wiki">Discussion</a></td>
                        <td data-ref="EU-Flixbus-route" class="results-route"><a href="https://wiki.openstreetmap.org/wiki/Europa/Transportation/Analyse/Flixbuslinien" title="in OSM-Wiki">Flixbus Lines</a></td>
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

