<!DOCTYPE html>
<html lang="de">

<?php include('html-head.inc'); ?>

<?php include('../script/config.php'); ?>

    <body>

<?php if ( isset($_GET['network']) ) { $found = ReadDetails( $_GET['network'] ); } ?>
        
      <div id="wrapper">
      
<?php include "header.inc" ?>

        <nav id="navigation">
            <h2 id="de">Konfigurationsdetails <?php if ( $found ) { printf( "für %s", $_GET['network'] ); } ?></h2>
            <ul>
                <li><a href="#overpass-api">Overpass-API Abfrage</a></li>
                <li><a href="#options">Auswertungsoptionen</a></li>
             </ul>
        </nav>

        <hr />

        <main id="main" class="results">

            <h2 id="overpass-api">Overpass-API Abfrage</h2>
            <p>
                Für den Download der OSM-Daten wird das <a href="https://wiki.openstreetmap.org/wiki/DE:Overpass_API">Overpass-API</a> verwendet.
                <a href="/de/index.php#overpass">Die verwendete Abfrage</a> liefert alle Ways und Nodes der Routen (deren Member mit ihren Details) aus einem definierten <a href="/de/index.php#searcharea">Suchgebiet</a>.
                Die so erhaltenen Daten erlauben eine Analyse der ÖPNV-Linien dahingehend, dass z.B. auch die Wegstrecke auf Vollständigkeit geprüft werden kann.
                Nodes, Ways und Relationen (Stops und Platforms) und deren Tags können gegen deren Rolle 'role' in der Relation geprüft werden.
            </p>
            
            <?php if ( $found ) { 
                      $query = htmlentities( GetOverpassQuery() );
                      $fsize = GetOsmXmlFileSize();
                      $rlink = GetRegionLink();
                      $rname = htmlentities( GetRegionName() );
                      if ( $query ) { printf( "<p><code>%s</code></p>\n", $query ); }
                      if ( $fsize ) { printf( "<p>Diese Abfrage liefert derzeit etwa %.1f MB.</p>\n", $fsize ); }
                      if ( $rlink ) { 
                          printf( "<p>Das <a href=\"/de/index.php#searcharea\">Suchgebiet</a> " );
                          if ( $rname ) { printf( "\"%s\" ", $rname ); }
                          printf( "auf der <a href=\"%s\">OSM-Karte</a> anzeigen.</p>\n", $rlink );
                      }
                  }
            ?>

            <hr />

            <h2 id="options">Auswertungsoptionen</h2>

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

        </main> <!-- main -->

        <hr />

<?php include "footer.inc" ?>

      </div> <!-- wrapper -->
    </body>
</html>

