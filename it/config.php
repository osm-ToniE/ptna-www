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
                <h2>Analisi statica per OpenStreetMap</h2>
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
                <li><a href="#overpass-api">Query API overpass</a></li>
                <li><a href="#options">Opzioni di analisi</a></li>
             </ul>
        </nav>

        <hr />

        <main id="main" class="results">

            <h2 id="overpass-api">Query API overpass</h2>
            <p>
                La <a href="https://wiki.openstreetmap.org/wiki/Overpass_API">API Overpass</a> viene utilizzata per scaricare i dati OSM.
                <a href="/en/index.php#overpass">La query utilizzata</a> restituisce tutti i modi e nodi dei percorsi (i loro membri con i loro dettagli) da un <a href="/en/index.php#searcharea">area di ricerca</a>.
                I dati così ottenuti consentono un'analisi delle linee di trasporto pubblico secondo cui ad es. il percorso può anche essere verificato per completezza.
                Nodi, modi e relazioni (fermate e piattaforme) e i loro tag possono essere verificati rispetto al loro "ruolo" nella relazione.
            </p>
            
            <?php if ( $found ) {
                      $query = htmlentities( GetOverpassQuery() );
                      $fsize = GetOsmXmlFileSize();
                      $rlink = GetRegionLink();
                      if ( $query ) { printf( "<p><code>%s</code></p>\n", $query ); }
                      if ( $fsize ) { printf( "<p>Questa query attualmente recapita approssimativamente %.1f MB.\n</p>", $fsize ); }
                      if ( $rlink ) { printf( "<p>Mostra l'area di ricerca sulla <a href=\"%s\">mappa OSM</a>.</p>\n", $rlink ); }
                  }
            ?>

            <hr />

            <h2 id="options">Opzioni di analisi</h2>

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

        </main> <!-- main -->

        <hr />

        <footer id="footer">
            <p>
                Tutti i dati geografici <a href="https://www.openstreetmap.org/copyright">© collaboratori di OpenStreetMap</a>.
            </p>
            <p>
                Questo programma è un software gratuito: puoi ridistribuirlo e / o modificarlo secondo i termini della <a href="https://www.gnu.org/licenses/gpl.html">LICENZA PUBBLICA GENERALE GNU, Versione 3, 29 giugno 2007</a> pubblicato dalla Free Software Foundation, versione 3 della Licenza o (a propria scelta) qualsiasi versione successiva. Ottieni il codice sorgente tramite <a href="https://github.com/osm-ToniE">GitHub</a>.
            </p>
        </footer>

      </div> <!-- wrapper -->
    </body>
</html>

