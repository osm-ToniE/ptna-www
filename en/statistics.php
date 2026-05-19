<!DOCTYPE html>
<html lang="en">

<?php $title="Statistics"; include('html-head.inc'); ?>

<?php
    include('../script/parse_query.php');
    include('../script/statistics.php');
    ?>

    <body>
      <script src="/script/sort-table.js"></script>
      <script> // Run sortTable.init() when the page loads - disabled in sort-table.js for race-condition reasons
                window.addEventListener
                    ? window.addEventListener('load', sortTable.init, false)
                    : window.attachEvent && window.attachEvent('onload', sortTable.init)
                    ;
      </script>

    <div id="wrapper">

<?php include "header.inc" ?>

        <main id="main" class="results">

            <h2 id="statistics"><img src="/img/GreatBritain16.png"  class="flagimg" alt="Union Jack" /> Statistics</h2>
                <p>
                    Server Load: <code><?php StatisticsPrintServerLoad();?></code><br />
                    Disk Load:   <code><?php StatisticsPrintDiskLoad();?></code>
                </p>

            <hr />

            <h3 id="GTFS-Update">Cron jobs for periodic GTFS update:</h3>
                <a href="showlogs.php?gtfs=cron" title="Show logs for GTFS update handling">Logs of GTFS update cron job</a><br />
                <a href="gtfs-statistics.php" title="Show individual GTFS logs for feed update handling">Logs of GTFS feed updates</a>

            <hr />

            <h3 id="on-demand-analysis">Cron jobs for on-demand analysis:</h3>
                <a href="/results/queue.php" title="Show analysis queue">Analysis Queue</a><br />
                <a href="showlogs.php?queue=analysis-queue" title="Show logs for analysis queue handling">Logs of analysis queue</a>

            <hr />

            <h3 id="priodic-analysis">Cron jobs for periodic analysis:</h3>
                <table id="analysis-table" class="js-sort-table">
                    <thead>
                        <tr class="statistics-tableheaderrow">
                            <th class="statistics-name js-sort-none">Started at Munich, DE time</th>
                            <th class="statistics-name js-sort-none">Timezones (Standard Time)</th>
                            <th class="statistics-name js-sort-none"><a href="https://download.openstreetmap.fr/extracts/" title="Extracts from french server">Extract Regions</a></th>
                            <th class="statistics-name js-sort-none">Countries</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- 20:15 -->
                        <tr class="statistics-tablerow">
                            <td class="statistics-name" rowspan="4"><a href="showlogs.php?job=australia-eastern-and-southeastern-asia" title="Show logs for planet handling: Australia, East and Southeast Asia">20:15</a></td>
                            <td class="statistics-name"><a href="showlogs.php?timezone=UTC%2B10"    title="Show logs for timezone UTC+10 (AU)">UTC+10</a></td>
                            <td class="statistics-name" rowspan="2"><a href="showlogs.php?continent=oceania"    title="Show logs for continent handling: Oceania">Oceania</a></td>
                            <td class="statistics-name">Australia</td>
                        </tr>
                        <tr class="statistics-tablerow">
                            <td class="statistics-name"><a href="showlogs.php?timezone=UTC%2B09.30" title="Show logs for timezone UTC+09.30 (AU)">UTC+09.30</a></td>
                            <td class="statistics-name">Australia</td>
                        </tr>
                        <tr class="statistics-tablerow">
                            <td class="statistics-name"><a href="showlogs.php?timezone=UTC%2B08"    title="Show logs for timezone UTC+08 (CN, PH)">UTC+08</a></td>
                            <td class="statistics-name" rowspan="2"><a href="showlogs.php?continent=asia"       title="Show logs for continent handling: Asia">Asia</a></td>
                            <td class="statistics-name">China, Pilippines</td>
                        </tr>
                        <tr class="statistics-tablerow">
                            <td class="statistics-name"><a href="showlogs.php?timezone=UTC%2B07"    title="Show logs for timezone UTC+07 (ID)">UTC+07</a></td>
                            <td class="statistics-name">Indonesia</td>
                        </tr>

                        <!-- 00:15 -->
                        <tr class="statistics-tablerow">
                            <td class="statistics-name" rowspan=3><a href="showlogs.php?job=india-iran-la-reunion" title="Show logs for planet handling: Show logs for planet handling: India, Iran, La Reunion">00:15</a></td>
                            <td class="statistics-name"><a href="showlogs.php?timezone=UTC%2B05.30" title="Show logs for timezone UTC+05.30 (IN)">UTC+05.30</a></td>
                            <td class="statistics-name"><a href="showlogs.php?continent=asia"       title="Show logs for continent handling: Asia">Asia</a></td>
                            <td class="statistics-name">India</td>
                        </tr>
                        <tr class="statistics-tablerow">
                            <td class="statistics-name"><a href="showlogs.php?timezone=UTC%2B04" title="Show logs for timezone UTC+04 (FR-974)">UTC+04</a></td>
                            <td class="statistics-name"><a href="showlogs.php?continent=africa"  title="Show logs for continent handling: Africa">Africa</a></td>
                            <td class="statistics-name">France (La Reunion)</td>
                        </tr>
                        <tr class="statistics-tablerow">
                            <td class="statistics-name"><a href="showlogs.php?timezone=UTC%2B03.30" title="Show logs for timezone UTC+03.30 (IR)">UTC+03.30</a></td>
                            <td class="statistics-name"><a href="showlogs.php?continent=asia"   title="Show logs for continent handling: Asia">Asia</a></td>
                            <td class="statistics-name">Iran</td>
                        </tr>

                        <!-- 02:15 -->
                        <tr class="statistics-tablerow">
                            <td class="statistics-name" rowspan="8"><a href="showlogs.php?job=africa-europe-israel" title="Show logs for planet handling: Africa, Europe, Israel">02:15</a></td>
                            <td class="statistics-name" rowspan="2"><a href="showlogs.php?timezone=UTC%2B03"    title="Show logs for timezone UTC+03 (RU)">UTC+03</a></td>
                            <td class="statistics-name"><a href="showlogs.php?continent=africa"    title="Show logs for continent handling: Africa">Africa</a></td>
                            <td class="statistics-name">Ethiopia, Madagascar</td>
                        </tr>
                        <tr class="statistics-tablerow">
                            <td class="statistics-name"><a href="showlogs.php?continent=europe"    title="Show logs for continent handling: Europe">Europe</a></td>
                            <td class="statistics-name">Russia</td>
                        </tr>
                        <tr class="statistics-tablerow">
                            <td class="statistics-name" rowspan="2"><a href="showlogs.php?timezone=UTC%2B02"    title="Show logs for timezone UTC+01 (IL, BG, EE, FI, RO)">UTC+02</a></td>
                            <td class="statistics-name"><a href="showlogs.php?continent=asia"       title="Show logs for continent handling: Asia">Asia</a></td>
                            <td class="statistics-name">Israel</td>
                        </tr>
                        <tr class="statistics-tablerow">
                            <td class="statistics-name"><a href="showlogs.php?continent=europe"       title="Show logs for continent handling: Europe">Europe</a></td>
                            <td class="statistics-name">Bulgaria, Estonia, Finland, Romania</td>
                        </tr>
                        <tr class="statistics-tablerow">
                            <td class="statistics-name" rowspan="2"><a href="showlogs.php?timezone=UTC%2B01"    title="Show logs for timezone UTC+01 (AT, CH, CZ, DE, DK, ES, FR, HR, IT, LI, LU, MA, NL, NO, PL, RS, SI)">UTC+01</a></td>
                            <td class="statistics-name"><a href="showlogs.php?continent=africa"       title="Show logs for continent handling: Africa">Africa</a></td>
                            <td class="statistics-name">Morocco</td>
                        </tr>
                        <tr class="statistics-tablerow">
                            <td class="statistics-name"><a href="showlogs.php?continent=europe"       title="Show logs for continent handling: Europe">Europe</a></td>
                            <td class="statistics-name">Austria, Croatia, Czechia, Denmark, France, Germany, Italy, Liechtenstein, Luxemburg, Netherlands, Norway, Poland, Serbia, Slovenia, Spain, Switzerland</td>
                        </tr>
                        <tr class="statistics-tablerow">
                            <td class="statistics-name" rowspan="2"><a href="showlogs.php?timezone=UTC%2B00"    title="Show logs for timezone UTC+00 (GH, MR, ES, GB, JE)">UTC+00</a></td>
                            <td class="statistics-name"><a href="showlogs.php?continent=africa"       title="Show logs for continent handling: Africa">Africa</a></td>
                            <td class="statistics-name">Ghana, Mauretania</td>
                        </tr>
                        <tr class="statistics-tablerow">
                            <td class="statistics-name"><a href="showlogs.php?continent=europe"       title="Show logs for continent handling: Europe">Europe</a></td>
                            <td class="statistics-name">Great Britain, Jersey, Spain (Canaries)</td>
                        </tr>

                        <!-- 08:15 -->
                        <tr class="statistics-tablerow">
                            <td class="statistics-name" rowspan="8"><a href="showlogs.php?job=eastern-america" title="Show logs for planet handling: America">08:15</a></td>
                            <td class="statistics-name"><a href="showlogs.php?timezone=UTC-03"                 title="Show logs for timezone UTC-03 (AR, BR)">UTC-03</a></td>
                            <td class="statistics-name"><a href="showlogs.php?continent=south-america"         title="Show logs for continent handling: South America">South America</a></td>
                            <td class="statistics-name">Argentina, Brasil</td>
                        </tr>
                        <tr class="statistics-tablerow">
                            <td class="statistics-name" rowspan="2"><a href="showlogs.php?timezone=UTC-04"     title="Show logs for timezone UTC-04 (BO, CA, CL)">UTC-04</a></td>
                            <td class="statistics-name"><a href="showlogs.php?continent=north-america"         title="Show logs for continent handling: North America">North America</a></td>
                            <td class="statistics-name">Canada</td>
                        </tr>
                        <tr class="statistics-tablerow">
                            <td class="statistics-name"><a href="showlogs.php?continent=south-america"         title="Show logs for continent handling: South America">South America</a></td>
                            <td class="statistics-name">Bolivia, Chile</td>
                        </tr>
                        <tr class="statistics-tablerow">
                            <td class="statistics-name" rowspan="3"><a href="showlogs.php?timezone=UTC-05"     title="Show logs for timezone UTC-05 (CA, CO, PA, USA)">UTC-05</a></td>
                            <td class="statistics-name"><a href="showlogs.php?continent=central-america"       title="Show logs for continent handling: Central America">Central America</a></td>
                            <td class="statistics-name">Panama</td>
                        </tr>
                        <tr class="statistics-tablerow">
                            <td class="statistics-name"><a href="showlogs.php?continent=north-america"         title="Show logs for continent handling: North America">North America</a></td>
                            <td class="statistics-name">Canada, USA</td>
                        </tr>
                        <tr class="statistics-tablerow">
                            <td class="statistics-name"><a href="showlogs.php?continent=south-america"         title="Show logs for continent handling: South America">South America</a></td>
                            <td class="statistics-name">Columbia</td>
                        </tr>
                        <tr class="statistics-tablerow">
                            <td class="statistics-name" rowspan="2"><a href="showlogs.php?timezone=UTC-06"     title="Show logs for timezone UTC+00 (CA, NI, US)">UTC-06</a></td>
                            <td class="statistics-name"><a href="showlogs.php?continent=central-america"       title="Show logs for continent handling: Central America">Central America</a></td>
                            <td class="statistics-name">Nicaragua</td>
                        </tr>
                        <tr class="statistics-tablerow">
                            <td class="statistics-name"><a href="showlogs.php?continent=north-america"         title="Show logs for continent handling: North America">North America</a></td>
                            <td class="statistics-name">Canada, USA</td>
                        </tr>

                        <!-- 12:15 -->
                        <tr class="statistics-tablerow">
                            <td class="statistics-name" rowspan="3"><a href="showlogs.php?job=western-america" title="Show logs for planet handling: America">12:15</a></td>
                            <td class="statistics-name"><a href="showlogs.php?timezone=UTC-07"                 title="Show logs for timezone UTC-07 (CA, US)">UTC-07</a></td>
                            <td class="statistics-name"><a href="showlogs.php?continent=north-america"         title="Show logs for continent handling: North America">North America</a></td>
                            <td class="statistics-name">Canada, USA</td>
                        </tr>
                        <tr class="statistics-tablerow">
                            <td class="statistics-name"><a href="showlogs.php?timezone=UTC-08"                 title="Show logs for timezone UTC-08 (US)">UTC-08</a></td>
                            <td class="statistics-name"><a href="showlogs.php?continent=north-america"         title="Show logs for continent handling: North America">North America</a></td>
                            <td class="statistics-name">USA</td>
                        </tr>
                        <tr class="statistics-tablerow">
                            <td class="statistics-name"><a href="showlogs.php?timezone=UTC-09"                 title="Show logs for timezone UTC-09 (US)">UTC-09</a></td>
                            <td class="statistics-name"><a href="showlogs.php?continent=north-america"         title="Show logs for continent handling: North America">North America</a></td>
                            <td class="statistics-name">USA</td>
                        </tr>
                    </tbody>
                    <tfoot>
                    </tfoot>
                </table>
<!--
            Cron jobs for continents:
            <a href="showlogs.php?job=australia-eastern-and-southeastern-asia" title="Show logs for planet handling: Australia, East and Southeast Asia">Australia, East and Southeast Asia (UTC+10, UTC+09.30, UTC+08, UTC+07) @ 20:15 Munich, DE time</a> /
            <a href="showlogs.php?job=india-iran-la-reunion" title="Show logs for planet handling: India, Iran, La Reunion">India, Iran and La Reunion (UTC+05.30, UTC+04, UTC+03.30) @ 23:15 Munich, DE time</a> /
            <a href="showlogs.php?job=africa-europe-israel"  title="Show logs for planet handling: Africa, Europe, Israel">Africa, Europe, Israel (UTC+03, UTC+02, UTC+01, UTC+00) @ 02:15 Munich, DE time</a> /
            <a href="showlogs.php?job=eastern-america"       title="Show logs for planet handling: Eastern America">Eastern America (UTC-03, UTC-04, UTC-05, UTC-06) @ 07:15 Munich, DE time</a> /
            <a href="showlogs.php?job=western-america"       title="Show logs for planet handling: Western America">Western America (UTC-07, UTC-08, UTC-09) @ 11:15 Munich, DE time</a>

            <hr />

            Update and filter jobs for continents:
            <a href="showlogs.php?continent=africa"          title="Show logs for continent handling: Africa">Africa</a> /
            <a href="showlogs.php?continent=central-america" title="Show logs for continent handling: America">Central America</a> /
            <a href="showlogs.php?continent=north-america"   title="Show logs for continent handling: America">North America</a> /
            <a href="showlogs.php?continent=south-america"   title="Show logs for continent handling: America">South America</a> /
            <a href="showlogs.php?continent=asia"            title="Show logs for continent handling: Asia">Asia</a> /
            <a href="showlogs.php?continent=europe"          title="Show logs for continent handling: Europe">Europe</a> /
            <a href="showlogs.php?continent=oceania"         title="Show logs for continent handling: Oceania">Oceania</a>

            <hr />

            Individual extracts and analysis:
            <a href="showlogs.php?planet=UTC%2B03" title="Show logs for planet handling: Africa, Europe, Israel">Africa, Europe, Israel: UTC+03, UTC+02, UTC+01, UTC+00</a>

            <hr />

            Supported timezones (wintertime):
            <a href="showlogs.php?timezone=UTC%2B10"    title="Show logs for timezone UTC+10 (AU-NSW, AU-QLD, AU-TAS, AU-VIC)">UTC+10</a> /
            <a href="showlogs.php?timezone=UTC%2B09.30" title="Show logs for timezone UTC+09.30 (AU-SA)">UTC+09.30</a> /
            <a href="showlogs.php?timezone=UTC%2B08"    title="Show logs for timezone UTC+08 (CN, PH)">UTC+08</a> /
            <a href="showlogs.php?timezone=UTC%2B07"    title="Show logs for timezone UTC+07 (ID)">UTC+07</a> /
            <a href="showlogs.php?timezone=UTC%2B05.30" title="Show logs for timezone UTC+05.30 (IN)">UTC+05.30</a> /
            <a href="showlogs.php?timezone=UTC%2B04"    title="Show logs for timezone UTC+04 (FR-974)">UTC+04</a> /
            <a href="showlogs.php?timezone=UTC%2B03.30" title="Show logs for timezone UTC+03.30 (IR)">UTC+03.30</a> /
            <a href="showlogs.php?timezone=UTC%2B03"    title="Show logs for timezone UTC+03 (ET, MG, RU)">UTC+03</a> /
            <a href="showlogs.php?timezone=UTC%2B02"    title="Show logs for timezone UTC+02 (BG, EE, FI, IL, RO)">UTC+02</a> /
            <a href="showlogs.php?timezone=UTC%2B01"    title="Show logs for timezone UTC+01 (AT, CH, CZ, DE, DK, ES, EU, FR, HR, IT, LI, LU, MA, NL, NO, PL, RS, SI)">UTC+01</a> /
            <a href="showlogs.php?timezone=UTC%2B00"    title="Show logs for timezone UTC+00 (ES, GB, GH, JE, MR)">UTC+00</a> /
            <a href="showlogs.php?timezone=UTC-03"      title="Show logs for timezone UTC-03 (AR, BR)">UTC-03</a> /
            <a href="showlogs.php?timezone=UTC-04"      title="Show logs for timezone UTC-04 (CA-NB, CL, BO)">UTC-04</a> /
            <a href="showlogs.php?timezone=UTC-05"      title="Show logs for timezone UTC-05 (CA-ON, CA-QC, CO, PA, US-DC, US-IN, US-MA, US-MD, US-MI, US-NY, US-PA, US-RI, US-TN)">UTC-05</a> /
            <a href="showlogs.php?timezone=UTC-06"      title="Show logs for timezone UTC-06 (CA-MB, NI, US-IL, US-WI)">UTC-06</a> /
            <a href="showlogs.php?timezone=UTC-07"      title="Show logs for timezone UTC-07 (CA-AB, US-UT)">UTC-07</a> /
            <a href="showlogs.php?timezone=UTC-08"      title="Show logs for timezone UTC-08 (US-CA, US-NV, US-WA, US-Amtrak, US-Flixbus)">UTC-08</a> /
            <a href="showlogs.php?timezone=UTC-09"      title="Show logs for timezone UTC-09 (US-AK)">UTC-09</a>
-->
            <hr />

            <h3 id="individual-analysis">Individual Analysis</h3>
                <table id="message-table" class="js-sort-table">
                    <thead>
<?php include 'statistics-trth.inc' ?>
                    </thead>
                    <tbody>
<?php $network_array = GetAllNetworks();

        foreach ( $network_array as $network ) {
            PrintNetworkStatistics( $network );
        }
?>
                    </tbody>
                    <tfoot>
<?php PrintNetworkStatisticsTotals( count($network_array) ); ?>
                    </tfoot>
                </table>

        </main> <!-- main -->

        <hr />

<?php include "footer.inc" ?>

      </div> <!-- wrapper -->
    </body>
</html>
