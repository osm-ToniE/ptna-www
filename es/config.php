<!DOCTYPE html>
<html lang="es">
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
         <?php include('../script/config.php'); ?>
    </head>
    <body>
      <?php if ( isset($_GET['network']) ) { $found = ReadDetails( $_GET['network'] ); } ?>
        
      <div id="wrapper">
        <header id="headerblock">
            <div id="headerimg" class="logo">
                <a href="/"><img src="/img/logo.png" alt="logo" /></a>
            </div>
            <div id="headertext">
                <h1><a href="/">PTNA - Public Transport Network Analysis</a></h1>
                <h2>Análisis estático para OpenStreetMap</h2>
            </div>
            <div id="headernav">
                <a href="/">Home</a> |
                <a href="/contact.html">Contact</a> |
                <a target="_blank" href="https://www.openstreetmap.de/impressum.html">Impressum</a> |
                <a target="_blank" href="https://www.fossgis.de/datenschutzerklärung">Datenschutzerklärung</a> |
                <a href="/en/index.html" title="english"><img src="/img/GreatBritain16.png" alt="Union Jack" /></a>
                <a href="/de/index.html" title="deutsch"><img src="/img/Germany16.png" alt="deutsche Flagge" /></a>
                <!-- <a href="/fr/index.html" title="français"><img src="/img/France16.png" alt="Tricolore Française" /></a> -->
            </div>
        </header>

        <nav id="navigation">
            <h2 id="de">Configuration details <?php if ( $found ) { printf( "for %s", $_GET['network'] ); } ?></h2>
            <ul>
                <li><a href="#overpass-api">Consulta API Overpass</a></li>
                <li><a href="#options">Opciones de análisis</a></li>
             </ul>
        </nav>

        <hr />

        <main id="main" class="results">

            <h2 id="overpass-api">Consulta API Overpass</h2>
            <p>
                La <a href="https://wiki.openstreetmap.org/wiki/Overpass_API">Overpass API</a> se usa para descargar los datos de OSM.
                <a href="/en/index.php#overpass">La consulta utilizada</a> devuelve todas las formas y nodos de las rutas (sus miembros con sus detalles) desde un <a href="/en/index.php#searcharea"> área de búsqueda</a>.
                Los datos así obtenidos permiten un análisis de las líneas de transporte público en el sentido de que, p. la ruta también se puede verificar para completar.
                Los nodos, formas y relaciones (paradas y plataformas) y sus etiquetas pueden verificarse con respecto a su 'rol' en la relación.
            </p>
            
            <?php if ( $found ) {
                      $query = htmlentities( GetOverpassQuery() );
                      $fsize = GetOsmXmlFileSize();
                      $rlink = GetRegionLink();
                      if ( $query ) { printf( "<p><code>%s</code></p>\n", $query ); }
                      if ( $fsize ) { printf( "<p>Esta consulta actualmente ofrece aproximadamente %.1f MB.\n</p>", $fsize ); }
                      if ( $rlink ) { printf( "<p>Mostrar el área de búsqueda en el <a href=\"%s\">OSM map</a>.</p>\n", $rlink ); }
                  }
            ?>

            <hr />

            <h2 id="options">Opciones de análisis</h2>

            <p>
                El contenido de <a href="/en/index.php#messages">errores y comentarios</a> puede controlarse mediante una variedad de <a href="/en/index.php#options">opciones de análisis< / a>. <br />
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

        </main> <!-- main -->

        <hr />

        <footer id="footer">
            <p>
                Todos los datos geográficos <a href="https://www.openstreetmap.org/copyright">© colaboradores de OpenStreetMap</a>.
            </p>
            <p>
                Este programa es software libre: puede redistribuirlo y / o modificarlo bajo los términos de la <a href="https://www.gnu.org/licenses/gpl.html">LICENCIA PÚBLICA GENERAL GNU, Versión 3, 29 de junio de 2007</a> según lo publicado por la Free Software Foundation, ya sea la versión 3 de la Licencia o (a su elección) cualquier versión posterior.
                Obtenga el código fuente a través de <a href="https://github.com/osm-ToniE">GitHub</a>.
            </p>
            <p>
                Esta página ha sido traducida al español con la ayuda de Google translate.
                Los comentarios para mejorar la traducción son bienvenidos.
            </p>
        </footer>

      </div> <!-- wrapper -->
    </body>
</html>

