<!DOCTYPE html>
<html lang="ca">

<?php $title="Configuració"; include('html-head.inc'); ?>

<?php include('../script/config.php'); ?>

    <body>

<?php if ( isset($network) ) { $found = ReadDetails( $network ); } else { $found = ''; } ?>

      <div id="wrapper">

<?php include "header.inc" ?>

        <nav id="navigation">
            <h2 id="es">Detalls de configuració <?php if ( $found ) { printf( "para %s", $network ); } ?></h2>
            <ul>
                <li><a href="#overpass-api">Consulta API d'Overpass</a></li>
                <li><a href="#options">Opcions d'anàlisi</a></li>
                <li><a href="#discussion">Discussió</a>
                    <ul>
                        <li><a href="#discussion-ptna">Discussió general sobre la PTNA</a></li>
                        <li><a href="#discussion-network">Discussió per a aquest anàlisis</a></li>
                    </ul>
                </li>
             </ul>
        </nav>

        <hr />

        <main id="main" class="results">

            <h2 id="overpass-api">Consulta API d'Overpass</h2>
            <div class="indent">

                <p>
                    La <a href="https://wiki.openstreetmap.org/wiki/ES:API_de_Overpass">API d'Overpass</a> s'utilitza per a descarregar les dades d'OSM.
                    <a href="/en/index.php#overpass">La consulta utilitzada</a> retorna totes les formes i nodes de les rutes (els seus membres amb els seus detalls) desde una <a href="/en/index.php#searcharea"> àrea de cerca</a>.
                    Les dades obtingudes així permeten un anàlisi de les línies de transport públic en el sentit que, p. la ruta també es pot verificar per a completar.
                    Els nodes, formes y relacions (parades i plataformes) i les seves etiquetes poden verificar-se respecte al seu 'rol' a la relación.
                </p>

                <?php if ( $found ) {
                          $query = htmlentities( GetOverpassQuery() );
                          $fsize = GetOsmXmlFileSizeByte();
                          $rlink = GetRegionLink();
                          $rname = htmlentities( GetRegionName() );
                          if ( $query ) { printf( "<p><code>%s</code></p>\n", $query ); }
                          if ( $fsize ) { printf( "<p>Aquesta consulta actualment ofereix aproximadament %.3f MB.\n</p>", $fsize / 1024 / 1024 ); }
                          if ( $rlink ) {
                              printf( "<p>Mostrar l'<a href=\"/en/index.php#searcharea\">àrea de cerca</a> " );
                              if ( $rname ) { printf( "\"<strong>%s</strong>\" ", $rname ); }
                              printf( "al <a href=\"%s\">OSM map</a>.</p>\n", $rlink );
                          }
                      }
                ?>
            </div>

            <hr />

            <h2 id="options">Opcions d'anàlisi</h2>
            <div class="indent">

                <p>
                    Los <a href="/en/index.php#messages">errors i comentaris</a> informats per PTNA poden controlar-se mitjançant una verietat d'<a href="/en/index.php#options">opcions d'anàlisi</a>. <br />
                    Aquí hi ha una llista d'opcions d'anàlisi i els seus valors.<br />
                </p>

                <table id="message-table">
                    <thead>
                        <tr class="message-tableheaderrow">
                            <th class="message-text">Opció</th>
                            <th class="message-option">Valor</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ( $found ) { PrintOptionDetails( "en" ); } ?>
                    </tbody>
                </table>
            </div>

            <hr />

            <h2 id="discussion">Discussió</h2>
            <div class="indent">

                <p>
                </p>

                <h3 id="discussion-ptna">Discussió general sobre la PTNA</h3>
                <div class="indent">

                    <p>
                        <?php $link = GetDiscussionPagePtna();
                              if ( $link ) {
                                  printf( "<a href=\"%s\">Discussió general sobre la PTNA</a> a la Wiki d'OSM.", $link );
                              } else {
                                  echo "???";
                              }
                        ?>
                    </p>
                </div>

                <h3 id="discussion-network">Discussió per a aquest anàlisi</h3>
                <div class="indent">

                    <p>
                        <?php $link = GetDiscussionPageNetwork();
                              if ( $link ) {
                                  printf( "<a href=\"%s\">Discussió per a aquest anàlisi</a>, aquesta 'network' a la Wiki d'OSM.", $link );
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
