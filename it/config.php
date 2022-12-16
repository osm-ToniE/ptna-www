<!DOCTYPE html>
<html lang="it">

<?php $title="Configurazione"; include('html-head.inc'); ?>

<?php include('../script/config.php'); ?>

    <body>

<?php if ( isset($_GET['network']) ) { $found = ReadDetails( $_GET['network'] ); } else { $found = ''; } ?>

      <div id="wrapper">

<?php include "header.inc" ?>

        <nav id="navigation">
            <h2 id="it">Dettagli di configurazione <?php if ( $found ) { printf( "per %s", $_GET['network'] ); } ?></h2>
            <ul>
                <li><a href="#overpass-api">Query API overpass</a></li>
                <li><a href="#options">Opzioni di analisi</a></li>
                <li><a href="#discussion">Discussione</a>
                    <ul>
                        <li><a href="#discussion-ptna">Discussione generale per PTNA</a></li>
                        <li><a href="#discussion-network">Discussion for this analysis</a></li>
                    </ul>
                </li>
             </ul>
        </nav>

        <hr />

        <main id="main" class="results">

            <h2 id="overpass-api">Query API overpass</h2>
            <div class="indent">

                <p>
                    La <a href="https://wiki.openstreetmap.org/wiki/Overpass_API">API Overpass</a> viene utilizzata per scaricare i dati OSM.
                    <a href="/en/index.php#overpass">La query utilizzata</a> restituisce tutti i modi e nodi dei percorsi (i loro membri con i loro dettagli) da un <a href="/en/index.php#searcharea">area di ricerca</a>.
                    I dati così ottenuti consentono un'analisi delle linee di trasporto pubblico secondo cui ad es. il percorso può anche essere verificato per completezza.
                    Nodi, modi e relazioni (fermate e piattaforme) e i loro tag possono essere verificati rispetto al loro "ruolo" nella relazione.
                </p>

                <?php if ( $found ) {
                          $query = htmlentities( GetOverpassQuery() );
                          $fsize = GetOsmXmlFileSizeByte();
                          $rlink = GetRegionLink();
                          $rname = htmlentities( GetRegionName() );
                          if ( $query ) { printf( "<p><code>%s</code></p>\n", $query ); }
                          if ( $fsize ) { printf( "<p>Questa query attualmente recapita approssimativamente %.3f MB.\n</p>", $fsize / 1024 / 1024 ); }
                          if ( $rlink ) {
                              printf( "<p>Mostra <a href=\"/en/index.php#searcharea\">l'area di ricerca</a> " );
                              if ( $rname ) { printf( "\"<strong>%s</strong>\" ", $rname ); }
                              printf( "sulla <a href=\"%s\">mappa OSM</a>.</p>\n", $rlink );
                          }
                      }
                ?>
            </div>

            <hr />

            <h2 id="options">Opzioni di analisi</h2>
            <div class="indent">

                <p>
                    Gli <a href="/en/index.php#messages">errori e commenti</a> riportati da PTNA possono essere controllati da una varietà di <a href="/en/index.php#options">opzioni di analisi</a>.<br />
                    Ecco un elenco di opzioni di analisi e i loro valori.<br />
                </p>

                <table id="message-table">
                    <thead>
                        <tr class="message-tableheaderrow">
                            <th class="message-text">Opzione</th>
                            <th class="message-option">Valore</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ( $found ) { PrintOptionDetails( "en" ); } ?>
                    </tbody>
                </table>
            </div>

            <hr />

            <h2 id="discussion">Discussione</h2>
            <div class="indent">

                <p>
                </p>

                <h3 id="discussion-ptna">Discussione generale per PTNA</h3>
                <div class="indent">

                    <p>
                        <?php $link = GetDiscussionPagePtna();
                              if ( $link ) {
                                  printf( "<a href=\"%s\">Discussione generale per PTNA</a> in the OSM Wiki.", $link );
                              } else {
                                  echo "???";
                              }
                        ?>
                    </p>
                </div>

                <h3 id="discussion-network">Discussione per questa analisi</h3>
                <div class="indent">

                    <p>
                        <?php $link = GetDiscussionPageNetwork();
                              if ( $link ) {
                                  printf( "<a href=\"%s\">Discussione per questa analisi</a>, questa 'network' nel Wiki di OSM.", $link );
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
