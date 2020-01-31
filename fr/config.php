<!DOCTYPE html>
<html lang="fr">
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
                <h2>Analyse statique pour OpenStreetMap</h2>
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
                <li><a href="#overpass-api">Requête Overpass-API</a></li>
                <li><a href="#options">Options d'analyse</a></li>
             </ul>
        </nav>

        <hr />

        <main id="main" class="results">

            <h2 id="overpass-api">Requête Overpass-API</h2>
            <p>
                <a href="https://wiki.openstreetmap.org/wiki/Overpass_API">L'API Overpass</a> est utilisée pour télécharger les données OSM.
                <a href="/en/index.php#overpass">La requête utilisée</a> renvoie tous les chemins et nœuds des itinéraires (leurs membres avec leurs détails) à partir d'un <a href = "/en/index.php#searcharea">zone de recherche</a>.
                Les données ainsi obtenues permettent une analyse des lignes de transports en commun selon laquelle par ex. l'intégralité de l'itinéraire peut également être vérifiée.
                Les nœuds, les voies et les relations (arrêts et plates-formes) et leurs balises peuvent être comparés à leur «rôle» dans la relation.
            </p>
            
            <?php if ( $found ) {
                      $query = htmlentities( GetOverpassQuery() );
                      $fsize = GetOsmXmlFileSize();
                      $rlink = GetRegionLink();
                      if ( $query ) { printf( "<p><code>%s</code></p>\n", $query ); }
                      if ( $fsize ) { printf( "<p>Cette requête fournit actuellement environ %.1f MB.\n</p>", $fsize ); }
                      if ( $rlink ) { printf( "<p>Afficher la zone de recherche sur la <a href=\"%s\">carte OSM</a>.</p>\n", $rlink ); }
                  }
            ?>

            <hr />

            <h2 id="options">Options d'analyse</h2>

            <p>
                Les <a href="/en/index.php#messages">erreurs et commentaires</a> signalés par PTNA peuvent être contrôlés par diverses <a href="/en/index.php#options">options d'analyse</a>.<br />
                Voici une liste des options d'analyse et leurs valeurs.<br />
            </p>

            <table id="message-table">
                <thead>
                    <tr class="message-tableheaderrow">
                        <th class="message-text">Option</th>
                        <th class="message-option">Valeur</th>
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
                Toutes les données géographiques <a href="https://www.openstreetmap.org/copyright"> © OpenStreetMap contributors </a>.
            </p>
            <p>
                Ce programme est un logiciel libre: vous pouvez le redistribuer et / ou le modifier selon les termes de la <a href="https://www.gnu.org/licenses/gpl.html"> LICENCE PUBLIQUE GÉNÉRALE GNU, Version 3, 29 juin 2007 </a> telle que publiée par la Free Software Foundation, version 3 de la licence ou (à votre choix) toute version ultérieure.
                Obtenez le code source via <a href="https://github.com/osm-ToniE"> GitHub </a>.
            </p>
            <p>
                Cette page a été traduite avec l'aide de Google translate. Les commentaires pour améliorer la traduction sont les bienvenus.
            </p>
        </footer>

      </div> <!-- wrapper -->
    </body>
</html>

