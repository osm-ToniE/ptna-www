<!DOCTYPE html>
<html lang="pt-BR">

<?php $title="Configuração"; include('html-head.inc'); ?>

<?php include('../script/config.php'); ?>

    <body>

<?php if ( isset($_GET['network']) ) { $found = ReadDetails( $_GET['network'] ); } ?>
        
      <div id="wrapper">
      
<?php include "header.inc" ?>

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
                      $fsize = GetOsmXmlFileSizeByte();
                      $rlink = GetRegionLink();
                      $rname = htmlentities( GetRegionName() );
                      if ( $query ) { printf( "<p><code>%s</code></p>\n", $query ); }
                      if ( $fsize ) { printf( "<p>Atualmente, essa consulta fornece aproximadamente %.1f MB.\n</p>", $fsize / 1024 / 1024 ); }
                      if ( $rlink ) { 
                          printf( "<p>Mostrar a <a href=\"/en/index.php#searcharea\">área de pesquisa</a> " );
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

<?php include "footer.inc" ?>

      </div> <!-- wrapper -->
    </body>
</html>

