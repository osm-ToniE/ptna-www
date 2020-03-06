<!DOCTYPE html>
<html lang="es">

<?php $title="Configuración"; include('html-head.inc'); ?>

<?php include('../script/config.php'); ?>

    <body>

<?php if ( isset($_GET['network']) ) { $found = ReadDetails( $_GET['network'] ); } ?>

      <div id="wrapper">

<?php include "header.inc" ?>

        <nav id="navigation">
            <h2 id="es">Detalles de configuración <?php if ( $found ) { printf( "para %s", $_GET['network'] ); } ?></h2>
            <ul>
                <li><a href="#overpass-api">Consulta API de Overpass</a></li>
                <li><a href="#options">Opciones de análisis</a></li>
                <li><a href="#discussion">Discusión</a>
                    <ul>
                        <li><a href="#discussion-ptna">Discusión general sobre la PTNA</a></li>
                        <li><a href="#discussion-network">Discusión para este análisis</a></li>
                    </ul>
                </li>
             </ul>
        </nav>

        <hr />

        <main id="main" class="results">

            <h2 id="overpass-api">Consulta API de Overpass</h2>
            <div class="indent">

                <p>
                    La <a href="https://wiki.openstreetmap.org/wiki/ES:API_de_Overpass">API de Overpass</a> se usa para descargar los datos de OSM.
                    <a href="/en/index.php#overpass">La consulta utilizada</a> devuelve todas las formas y nodos de las rutas (sus miembros con sus detalles) desde un <a href="/en/index.php#searcharea"> área de búsqueda</a>.
                    Los datos así obtenidos permiten un análisis de las líneas de transporte público en el sentido de que, p. la ruta también se puede verificar para completar.
                    Los nodos, formas y relaciones (paradas y plataformas) y sus etiquetas pueden verificarse con respecto a su 'rol' en la relación.
                </p>

                <?php if ( $found ) {
                          $query = htmlentities( GetOverpassQuery() );
                          $fsize = GetOsmXmlFileSizeByte();
                          $rlink = GetRegionLink();
                          $rname = htmlentities( GetRegionName() );
                          if ( $query ) { printf( "<p><code>%s</code></p>\n", $query ); }
                          if ( $fsize ) { printf( "<p>Esta consulta actualmente ofrece aproximadamente %.1f MB.\n</p>", $fsize / 1024 / 1024 ); }
                          if ( $rlink ) {
                              printf( "<p>Mostrar el <a href=\"/en/index.php#searcharea\">área de búsqueda</a> " );
                              if ( $rname ) { printf( "\"<strong>%s</strong>\" ", $rname ); }
                              printf( "en el <a href=\"%s\">OSM map</a>.</p>\n", $rlink );
                          }
                      }
                ?>
            </div>

            <hr />

            <h2 id="options">Opciones de análisis</h2>
            <div class="indent">

                <p>
                    Los <a href="/en/index.php#messages">errores y comentarios</a> informados por PTNA puede controlarse mediante una variedad de <a href="/en/index.php#options">opciones de análisis</a>. <br />
                    Aquí hay una lista de opciones de análisis y sus valores.<br />
                </p>

                <table id="message-table">
                    <thead>
                        <tr class="message-tableheaderrow">
                            <th class="message-text">Opción</th>
                            <th class="message-option">Valor</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ( $found ) { PrintOptionDetails( "en" ); } ?>
                    </tbody>
                </table>
            </div>

            <hr />

            <h2 id="discussion">Discusión</h2>
            <div class="indent">

                <p>
                </p>

                <h3 id="discussion-ptna">Discusión general sobre la PTNA</h3>
                <div class="indent">

                    <p>
                        <?php $link = GetDiscussionPagePtna();
                              if ( $link ) {
                                  printf( "<a href=\"%s\">Discusión general sobre la PTNA</a> en el OSM Wiki.", $link );
                              } else {
                                  echo "???";
                              }
                        ?>
                    </p>
                </div>

                <h3 id="discussion-network">Discusión para este análisis</h3>
                <div class="indent">

                    <p>
                        <?php $link = GetDiscussionPageNetwork();
                              if ( $link ) {
                                  printf( "<a href=\"%s\">Discusión para este análisis</a>, esta 'network' en el OSM Wiki.", $link );
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
