<!DOCTYPE html>
<html lang="pt-BR">

<?php $title="Configuração"; include('html-head.inc'); ?>

<?php include('../script/config.php'); ?>

    <body>

<?php if ( isset($_GET['network']) ) { $found = ReadDetails( $_GET['network'] ); } else { $found = ''; } ?>

      <div id="wrapper">

<?php include "header.inc" ?>

        <nav id="navigation">
            <h2 id="de">Detalhes das configurações <?php if ( $found ) { printf( "para %s", $_GET['network'] ); } ?></h2>
            <ul>
                <li><a href="#overpass-api">Consulta do Overpass</a></li>
                <li><a href="#options">Configurações de análise</a></li>
                <li><a href="#discussion">Discussão</a>
                    <ul>
                        <li><a href="#discussion-ptna">Discussão geral sobre o PTNA</a></li>
                        <li><a href="#discussion-network">Discussão sobre esta análise</a></li>
                    </ul>
                </li>
             </ul>
        </nav>

        <hr />

        <main id="main" class="results">

            <h2 id="overpass-api">Consulta do Overpass</h2>
            <div class="indent">

                <p>
                    A <a href="https://wiki.openstreetmap.org/wiki/Overpass_API">API do Overpass</a> é usada para baixar os dados do OSM.
                    <a href="/pt/index.php#sobrepass">A consulta utilizada</a> retorna todos os caminhos e nós das rotas (retorna os seus membros e seus detalhes) a partir de uma <a href="/pt/index.php#searcharea">área definida</a>.
                    Os dados obtidos permitem uma análise das linhas de transporte público mapeadas. Por exemplo, é possível verificar se uma rota está totalmente mapeada.
                    Os nós, caminhos e relações (paradas e plataformas) e suas etiquetas podem ser comparados ao seu "papel" na relação.
                </p>

                <?php if ( $found ) {
                          $query = htmlentities( GetOverpassQuery() );
                          $fsize = GetOsmXmlFileSizeByte();
                          $rlink = GetRegionLink();
                          $rname = htmlentities( GetRegionName() );
                          if ( $query ) { printf( "<p><code>%s</code></p>\n", $query ); }
                          if ( $fsize ) { printf( "<p>Esta consulta atualmente fornece aproximadamente %.3f MB de dados.\n</p>", $fsize / 1024 / 1024 ); }
                          if ( $rlink ) {
                              printf( "<p>Mostrar a <a href=\"/en/index.php#searcharea\">área de pesquisa</a> " );
                              if ( $rname ) { printf( "\"<strong>%s</strong>\" ", $rname ); }
                              printf( "no mapa <a href=\"%s\">OSM</a>.</p>\n", $rlink );
                          }
                      }
                ?>
            </div>

            <hr />

            <h2 id="options">Configurações de análise</h2>
            <div class="indent">

                <p>
                    Os <a href="/en/index.php#messages">erros e observações</a> resultantes da análise do PTNA podem ser controlados por uma variedade de <a href="/en/index.php#options">configurações</a>.<br />
                    Aqui embaixo está uma lista de configurações e seus respectivos valores.<br />
                </p>

                <table id="message-table">
                    <thead>
                        <tr class="message-tableheaderrow">
                            <th class="message-text">Configuração</th>
                            <th class="message-option">Valor</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ( $found ) { PrintOptionDetails( "en" ); } ?>
                    </tbody>
                </table>
            </div>

            <hr />

            <h2 id="discussion">Discussão</h2>
            <div class="indent">

                <p>
                </p>

                <h3 id="discussion-ptna">Discussão geral sobre o PTNA</h3>
                <div class="indent">

                    <p>
                        <?php $link = GetDiscussionPagePtna();
                              if ( $link ) {
                                  printf( "<a href=\"%s\">Discussão geral sobre o PTNA</a> na wiki do OSM.", $link );
                              } else {
                                  echo "???";
                              }
                        ?>
                    </p>
                </div>

                <h3 id="discussion-network">Discussão sobre esta análise</h3>
                <div class="indent">

                    <p>
                        <?php $link = GetDiscussionPageNetwork();
                              if ( $link ) {
                                  printf( "<a href=\"%s\">Discussão sobre esta análise</a> e empresa na wiki do OSM.", $link );
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
