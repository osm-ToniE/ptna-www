<!DOCTYPE html>
<html lang="sl">

<?php $title="Konfiguracija"; include('html-head.inc'); ?>

<?php include('../script/config.php'); ?>

    <body>

<?php if ( isset($network) ) { $found = ReadDetails( $network ); } else { $found = ''; } ?>

      <div id="wrapper">

<?php include "header.inc" ?>

        <nav id="navigation">
            <h2 id="sl">Podrobnosti o konfiguraciji <?php if ( $found ) { printf( "za %s", $network ); } ?></h2>
            <ul>
                <li><a href="#overpass-api">Overpass-API Poizvedba</a></li>
                <li><a href="#options">Možnosti analize</a></li>
                <li><a href="#discussion">Razprava</a>
                    <ul>
                        <li><a href="#discussion-ptna">Splošna razprava za PTNA</a></li>
                        <li><a href="#discussion-network">Razprava o tej analizi</a></li>
                    </ul>
                </li>
             </ul>
        </nav>

        <hr />

        <main id="main" class="results">

            <h2 id="overpass-api">Overpass-API Poizvedba</h2>
            <div class="indent">

                <p>
                    Za prenos podatkov OSM se uporablja <a href="https://wiki.openstreetmap.org/wiki/Overpass_API">Overpass API</a>.
                    <a href="/en/index.php#overpass">Uporabljena poizvedba</a> vrne vse poti in vozlišča poti (njihove člane s podrobnostmi) iz določenega <a href="/en/index.php#searcharea">območja iskanja</a>.
                    Tako pridobljeni podatki omogočajo analizo linij javnega prevoza, tako da se lahko npr. preveri popolnost poti.
                    Vozlišča, poti in relacije (postajališča in ploščadi) ter njihove oznake je mogoče preveriti glede na njihovo "vlogo" v relaciji.
                </p>

                <?php if ( $found ) {
                          $query = htmlentities( GetOverpassQuery() );
                          $fsize = GetOsmXmlFileSizeByte();
                          $rlink = GetRegionLink();
                          $rname = htmlentities( GetRegionName() );
                          if ( $query ) { printf( "<p><code>%s</code></p>\n", $query ); }
                          if ( $fsize ) { printf( "<p>Ta poizvedba trenutno zagotavlja približno %.3f MB.\n</p>", $fsize / 1024 / 1024 ); }
                          if ( $rlink ) {
                              printf( "<p>Prikaz <a href=\"/en/index.php#searcharea\">območja za iskanje</a> " );
                              if ( $rname ) { printf( "\"<strong>%s</strong>\" ", $rname ); }
                              printf( "na zemljevidu <a href=\"%s\">OSM zemljevid</a>.</p>\n", $rlink );
                          }
                      }
                ?>
            </div>

            <hr />

            <h2 id="options">Možnosti analize</h2>
            <div class="indent">

                <p>
                    <a href="/en/index.php#messages">Hude napake in komentarji</a>, o katerih poroča PTNA, se lahko nadzorujejo z različnimi <a href="/en/index.php#options">možnosti analize</a>.<br />
                    Tukaj je seznam možnosti analize in njihovih vrednosti.<br />
                </p>

                <table id="message-table">
                    <thead>
                        <tr class="message-tableheaderrow">
                            <th class="message-text">Možnost</th>
                            <th class="message-option">Vrednost</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ( $found ) { PrintOptionDetails( "en" ); } ?>
                    </tbody>
                </table>
            </div>

            <hr />

            <h2 id="discussion">Razprava</h2>
            <div class="indent">

                <p>
                </p>

                <h3 id="discussion-ptna">Splošna razprava za PTNA</h3>
                <div class="indent">

                    <p>
                        <?php $link = GetDiscussionPagePtna();
                              if ( $link ) {
                                  printf( "<a href=\"%s\">Splošna razprava za PTNA</a> v OSM Wiki.", $link );
                              } else {
                                  echo "???";
                              }
                        ?>
                    </p>
                </div>

                <h3 id="discussion-network">Razprava o tej analizi</h3>
                <div class="indent">

                    <p>
                        <?php $link = GetDiscussionPageNetwork();
                              if ( $link ) {
                                  printf( "<a href=\"%s\">Razprava za to analizo</a>, to 'network' v OSM Wiki.", $link );
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
