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
                <li><a href="#overpass-api">Consulta de Overpass-API</a></li>
                <li><a href="#options">Opções de análise</a></li>
                <li><a href="#discussion">Discussão</a>
                    <ul>
                        <li><a href="#discussion-ptna">Discussão geral para o PTNA</a></li>
                        <li><a href="#discussion-network">Discussão para esta análise</a></li>
                    </ul>
                </li>
             </ul>
        </nav>

        <hr />

        <main id="main" class="results">

            <h2 id="overpass-api">Consulta de Overpass-API</h2>
            <div class="indent">

                <p>
                    O <a href="https://wiki.openstreetmap.org/wiki/Overpass_API">Overpass API</a> é usado para baixar os dados do OSM.
                    <a href="/pt/index.php#sobrepass">A consulta utilizada</a> retorna todos os caminhos e nós das rotas (seus membros com seus detalhes) a partir de uma área definida <a href="/pt/index.php#searcharea">área de pesquisa</a>.
                    Os dados assim obtidos permitem uma análise das linhas de transporte público no sentido de que, por exemplo, a rota também pode ser verificada quanto à sua completude.
                    Os nós, caminhos e relações (paradas e plataformas) e suas tags podem ser comparados ao seu "papel" na relação.
                </p>

                <?php if ( $found ) {
                          $query = htmlentities( GetOverpassQuery() );
                          $fsize = GetOsmXmlFileSizeByte();
                          $rlink = GetRegionLink();
                          $rname = htmlentities( GetRegionName() );
                          if ( $query ) { printf( "<p><code>%s</code></p>\n", $query ); }
                          if ( $fsize ) { printf( "<p>Esta consulta atualmente fornece aproximadamente %.1f MB.\n</p>", $fsize / 1024 / 1024 ); }
                          if ( $rlink ) {
                              printf( "<p>Mostrar a <a href=\"/en/index.php#searcharea\">área de pesquisa</a> " );
                              if ( $rname ) { printf( "\"<strong>%s</strong>\" ", $rname ); }
                              printf( "no mapa <a href=\"%s\">OSM</a>.</p>\n", $rlink );
                          }
                      }
                ?>
            </div>

            <hr />

            <h2 id="options">Opções de análise</h2>
            <div class="indent">

                <p>
                    As <a href="/en/index.php#messages">erros e comentários</a> relatados pela PTNA podem ser controlados por uma variedade de <a href="/en/index.php#options">opções de análise</a>.<br />
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
            </div>

            <hr />

            <h2 id="discussion">Discussão</h2>
            <div class="indent">

                <p>
                </p>

                <h3 id="discussion-ptna">Discussão geral para o PTNA</h3>
                <div class="indent">

                    <p>
                        <?php $link = GetDiscussionPagePtna();
                              if ( $link ) {
                                  printf( "<a href=\"%s\">Discussão geral para o PTNA</a> no Wiki OSM.", $link );
                              } else {
                                  echo "???";
                              }
                        ?>
                    </p>
                </div>

                <h3 id="discussion-network">Discussão para esta análise</h3>
                <div class="indent">

                    <p>
                        <?php $link = GetDiscussionPageNetwork();
                              if ( $link ) {
                                  printf( "<a href=\"%s\">Diskussion para esta análise</a>, esta 'network' no Wiki OSM.", $link );
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
