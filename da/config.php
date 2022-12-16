<!DOCTYPE html>
<html lang="da">

<?php $title="Configuration"; include('html-head.inc'); ?>

<?php include('../script/config.php'); ?>

    <body>

<?php if ( isset($_GET['network']) ) { $found = ReadDetails( $_GET['network'] ); } else { $found = ''; } ?>

      <div id="wrapper">

<?php include "header.inc" ?>

        <nav id="navigation">
            <h2 id="de">Konfigurationsdetaljer <?php if ( $found ) { printf( "til %s", $_GET['network'] ); } ?></h2>
            <ul>
                <li><a href="#overpass-api">Overpass-API-forespørgsel</a></li>
                <li><a href="#options">Analysemuligheder</a></li>
                <li><a href="#discussion">Diskussion</a>
                    <ul>
                        <li><a href="#discussion-ptna">Generel diskussion for PTNA</a></li>
                        <li><a href="#discussion-network">Diskussion til denne analyse</a></li>
                    </ul>
                </li>
             </ul>
        </nav>

        <hr />

        <main id="main" class="results">

            <h2 id="overpass-api">Overpass-API-forespørgsel</h2>
            <div class="indent">

                <p>
                    <a href="https://wiki.openstreetmap.org/wiki/Overpass_API">Overpass API</a> bruges til at downloade OSM-data.
                    <a href="/en/index.php#overpass">Den anvendte forespørgsel</a> returnerer alle måder og noder for ruterne (deres medlemmer med deres detaljer) fra et defineret <a href="/en/index.php#searcharea">søgeområde</a>.
                    De således opnåede data tillader en analyse af de offentlige transportlinjer med den virkning, at f.eks. ruten kan også kontrolleres for fuldstændighed.
                    Nodes, Ways og Relrelations ationer (stop og platforme) og deres tags kan kontrolleres mod deres 'rolle' i relationen.
                </p>

                <?php if ( $found ) {
                          $query = htmlentities( GetOverpassQuery() );
                          $fsize = GetOsmXmlFileSizeByte();
                          $rlink = GetRegionLink();
                          $rname = htmlentities( GetRegionName() );
                          if ( $query ) { printf( "<p><code>%s</code></p>\n", $query ); }
                          if ( $fsize ) { printf( "<p>Denne forespørgsel leverer i øjeblikket ca. %.3f MB.\n</p>", $fsize / 1024 / 1024 ); }
                          if ( $rlink ) {
                              printf( "<p>Vis <a href=\"/en/index.php#searcharea\">søgeområdet</a> " );
                              if ( $rname ) { printf( "\"<strong>%s</strong>\" ", $rname ); }
                              printf( "på <a href=\"%s\">OSM-kort</a>.</p>\n", $rlink );
                          }
                      }
                ?>
            </div>

            <hr />

            <h2 id="options">Analysemuligheder</h2>
            <div class="indent">

                <p>
                    <a href="/en/index.php#messages">Fejl og kommentarer</a> rapporteret af PTNA kan kontrolleres af en række <a href="/en/index.php#options">analysemuligheder</a>.<br />
                    Her er en liste over analysemuligheder og deres værdier.<br />
                </p>

                <table id="message-table">
                    <thead>
                        <tr class="message-tableheaderrow">
                            <th class="message-text">Mulighed</th>
                            <th class="message-option">Værdi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ( $found ) { PrintOptionDetails( "en" ); } ?>
                    </tbody>
                </table>
            </div>

            <hr />

            <h2 id="discussion">Diskussion</h2>
            <div class="indent">

                <p>
                </p>

                <h3 id="discussion-ptna">Generel diskussion for PTNA</h3>
                <div class="indent">

                    <p>
                        <?php $link = GetDiscussionPagePtna();
                              if ( $link ) {
                                  printf( "<a href=\"%s\">Generel diskussion for PTNA</a> i OSM Wiki.", $link );
                              } else {
                                  echo "???";
                              }
                        ?>
                    </p>
                </div>

                <h3 id="discussion-network">Diskussion til denne analyse</h3>
                <div class="indent">

                    <p>
                        <?php $link = GetDiscussionPageNetwork();
                              if ( $link ) {
                                  printf( "<a href=\"%s\">Diskussion til denne analyse</a>, dette 'network' i OSM Wiki.", $link );
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
