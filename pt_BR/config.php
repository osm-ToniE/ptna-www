<!DOCTYPE html>
<html lang="pt_BR">
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
                <h2>Análise estática para OpenStreetMap</h2>
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
            <h2 id="de">Detalhes de configuração <?php if ( $found ) { printf( "para %s", $_GET['network'] ); } ?></h2>
            <ul>
                <li><a href="#overpass-api">Consulta de API Overpass</a></li>
                <li><a href="#options">Opções de análise</a></li>
             </ul>
        </nav>

        <hr />

        <main id="main" class="results">

            <h2 id="overpass-api">Consulta de API Overpass</h2>
            <p>
                A <a href="https://wiki.openstreetmap.org/wiki/Pt:API_de_Overpass">API Overpass</a> é usada para baixar os dados do OSM.
                <a href="/en/index.php#overpass">A consulta usada</a> retorna todas as formas e nós das rotas (seus membros com seus detalhes) de um <a href="/en/index.php#searcharea">área de pesquisa</a>.
                Os dados assim obtidos permitem uma análise das linhas de transporte público para o efeito que, por exemplo, a rota também pode ser verificada quanto à integridade.
                Nós, formas e relações (paradas e plataformas) e suas tags podem ser verificados em relação ao seu 'papel' na relação.
            </p>
            
            <?php if ( $found ) {
                      $query = htmlentities( GetOverpassQuery() );
                      $fsize = GetOsmXmlFileSize();
                      $rlink = GetRegionLink();
                      $rname = htmlentities( GetRegionName() );
                      if ( $query ) { printf( "<p><code>%s</code></p>\n", $query ); }
                      if ( $fsize ) { printf( "<p>Atualmente, essa consulta fornece aproximadamente %.1f MB.\n</p>", $fsize ); }
                      if ( $rlink ) { 
                          printf( "<p>Mostrar a <a href=\"/de/index.php#searcharea\">área de pesquisa</a> " );
                          if ( $rname ) { printf( "\"%s\" ", $rname ); }
                          printf( "no <a href=\"%s\">mapa OSM</a>.</p>\n", $rlink );
                      }
                  }
            ?>

            <hr />

            <h2 id="options">Opções de análise</h2>

            <p>
                Os <a href="/en/index.php#messages">erros e comentários</a> relatados pelo PTNA podem ser controlados por uma variedade de <a href="/en/index.php#options">opções de análise</a>.<br />
                Aqui está uma lista de opções de análise e seus valores.<br />
            </p>

            <table id="message-table">
                <thead>
                    <tr class="message-tableheaderrow">
                        <th class="message-text">Opção</th>
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
                Todos os dados geográficos <a href="https://www.openstreetmap.org/copyright"> © colaboradores do OpenStreetMap </a>
            </p>
            <p>
                Este programa é um software gratuito: você pode redistribuí-lo e / ou modificá-lo sob os termos da <a href="https://www.gnu.org/licenses/gpl.html"> LICENÇA PÚBLICA GERAL GNU, Versão 3, 29 de junho de 2007 </a> conforme publicado pela Free Software Foundation, versão 3 da licença ou (a seu critério) qualquer versão posterior. Obtenha o código fonte no <a href="https://github.com/osm-ToniE"> GitHub </a>.
            </p>
            <p>
                Esta página foi traduzida para o português com a ajuda do Google translate. Comentários para melhorar a tradução são bem-vindos, especialmente para tradução correta para o português brasileiro.
            </p>
        </footer>

      </div> <!-- wrapper -->
    </body>
</html>

