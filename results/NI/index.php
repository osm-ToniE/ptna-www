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
         <?php include('../../script/entries.php'); ?>
    </head>
    <body>
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

        <main id="main" class="results">

            <h2 id="EU"><img src="/img/Nicaragua32.png" alt="bandera Nicaragua" /> Resultados para Nicaragua</h2>
            <p>
                La primera columna contiene un enlace a los resultados del análisis.
            </p>
            <p>
                La columna "Cambios recientes" enlaza con la página HTML que muestra las diferencias con los últimos resultados del análisis.
                Estos son de color, puede usar los botones de navegación <img class="diff-navigate" src="/img/diff-navigate.png" alt="Navigation"> en la parte inferior derecha o los caracteres 'j' (hacia adelante) y 'k' (hacia atrás) para saltar de una diferencia a otra.
                Esta columna incluye la fecha del último análisis donde han surgido cambios relevantes.
                Las fechas más antiguas significan que no hubo cambios en los resultados.
                Sin embargo, los datos han sido analizados como se indica en la columna "Fecha de análisis".
            </p>

            <table id="networksEU">
                <thead>
                    <tr class="results-tableheaderrow">
                        <th class="results-name">Nombre</th>
                        <th class="results-region">Ciudad / Región</th>
                        <th class="results-network">Asociación de transporte</th>
                        <th class="results-datadate">Fecha de análisis</th>
                        <th class="results-analyzed">Cambios recientes</th>
                        <th class="results-discussion">Discusiones</th>
                        <th class="results-route">Líneas</th>
                    </tr>
                </thead>
                <tbody>

                    <?php CreateFullEntry( "NI-MN-IRTRAMMA" ); ?>

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

