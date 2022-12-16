<!DOCTYPE html>
<html lang="de">

<?php $title="Konfiguration"; include('html-head.inc'); ?>

<?php include('../script/config.php'); ?>

    <body>

<?php if ( isset($_GET['network']) ) { $found = ReadDetails( $_GET['network'] ); } else { $found = ''; } ?>

      <div id="wrapper">

<?php include "header.inc" ?>

        <nav id="navigation">
            <h2 id="de">Konfigurationsdetails <?php if ( $found ) { printf( "für %s", $_GET['network'] ); } ?></h2>
            <ul>
                <li><a href="#overpass-api">Overpass-API Abfrage</a></li>
                <li><a href="#options">Auswertungsoptionen</a></li>
                <li><a href="#discussion">Diskussion</a>
                    <ul>
                        <li><a href="#discussion-ptna">Generelle Diskussion zu PTNA</a></li>
                        <li><a href="#discussion-network">Diskussion zu dieser Auswertung</a></li>
                    </ul>
                </li>
             </ul>
        </nav>

        <hr />

        <main id="main" class="results">

            <h2 id="overpass-api">Overpass-API Abfrage</h2>
            <div class="indent">
                <p>
                    Für den Download der OSM-Daten wird das <a href="https://wiki.openstreetmap.org/wiki/DE:Overpass_API">Overpass-API</a> verwendet.
                    <a href="/de/index.php#overpass">Die verwendete Abfrage</a> liefert alle Ways und Nodes der Routen (deren Member mit ihren Details) aus einem definierten <a href="/de/index.php#searcharea">Suchgebiet</a>.
                    Die so erhaltenen Daten erlauben eine Analyse der ÖPNV-Linien dahingehend, dass z.B. auch die Wegstrecke auf Vollständigkeit geprüft werden kann.
                    Nodes, Ways und Relationen (Stops und Platforms) und deren Tags können gegen deren Rolle 'role' in der Relation geprüft werden.
                </p>

                <?php if ( $found ) {
                          $query = htmlentities( GetOverpassQuery() );
                          $fsize = GetOsmXmlFileSizeByte();
                          $rlink = GetRegionLink();
                          $rname = htmlentities( GetRegionName() );
                          if ( $query ) { printf( "<p><code>%s</code></p>\n", $query ); }
                          if ( $fsize ) { printf( "<p>Diese Abfrage liefert derzeit etwa %.3f MB.</p>\n", $fsize / 1024 / 1024 ); }
                          if ( $rlink ) {
                              printf( "<p>Das <a href=\"/de/index.php#searcharea\">Suchgebiet</a> " );
                              if ( $rname ) { printf( "\"<strong>%s</strong>\" ", $rname ); }
                              printf( "auf der <a href=\"%s\">OSM-Karte</a> anzeigen.</p>\n", $rlink );
                          }
                      }
                ?>
            </div>

            <hr />

            <h2 id="options">Auswertungsoptionen</h2>
            <div class="indent">

                <p>
                    Die Ausgabe von <a href="/de/index.php#messages">Fehlern und Anmerkungen</a> kann durch eine Vielzahl von <a href="/de/index.php#options">Auswertungsoptionen</a> beeinflusst werden.<br />
                    Hier ist eine Auflistung der Auswertungsoptionen und deren Werte.<br />
                </p>

                <table id="message-table">
                    <thead>
                        <tr class="message-tableheaderrow">
                            <th class="message-text">Option</th>
                            <th class="message-option">Wert</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ( $found ) { PrintOptionDetails( "de" ); } ?>
                    </tbody>
                </table>
            </div>

            <hr />

            <h2 id="discussion">Diskussion</h2>
            <div class="indent">

                <p>
                </p>

                <h3 id="discussion-ptna">Generelle Diskussion zu PTNA</h3>
                <div class="indent">

                    <p>
                        <?php $link = GetDiscussionPagePtna();
                              if ( $link ) {
                                  printf( "<a href=\"%s\">Generelle Diskussion zu PTNA</a> im OSM Wiki.", $link );
                              } else {
                                  echo "???";
                              }
                        ?>
                    </p>
                </div>

                <h3 id="discussion-network">Diskussion zu dieser Auswertung</h3>
                <div class="indent">

                    <p>
                        <?php $link = GetDiscussionPageNetwork();
                              if ( $link ) {
                                  printf( "<a href=\"%s\">Diskussion zu dieser Auswertung</a>, diesem 'network' im OSM Wiki.", $link );
                              } else {
                                  echo "???";
                              }
                        ?>
                    </p>
                </div>
            </div>

        </main> <!-- main -->

        <hr />

<?php include "footer.inc" ?>

      </div> <!-- wrapper -->
    </body>
</html>
