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

        <main id="main" class="results">

            <h2 id="BR"><img src="/img/Brasil32.png" alt="bandeira do brasil" /> Resultados para o Brasil</h2>
            <p>
                A primeira coluna inclui um link para os resultados da análise.
            </p>
            <p>
                A coluna "Últimas alterações" está vinculada a uma página HTML que mostra as diferenças para os últimos resultados da análise.
                São coloridas, você pode usar os botões de navegação <img class="diff-navigate" src="/img/diff-navigate.png" alt="Navigation"> na parte inferior direita ou os caracteres 'j' (para frente) e 'k' (para trás) para pular de uma diferença para outra.
                Esta coluna inclui a data da última análise em que surgiram alterações relevantes.
                Datas anteriores significam que não houve alterações nos resultados.
                No entanto, os dados foram analisados conforme indicado na coluna "Data da análise".
            </p>

            <table id="networksEU">
                <thead>
                    <tr class="results-tableheaderrow">
                        <th class="results-name">Nome</th>
                        <th class="results-region">Cidade / Região</th>
                        <th class="results-network">Transporte Assiciacion</th>
                        <th class="results-datadate">Data da análise</th>
                        <th class="results-analyzed">Últimas alterações</th>
                        <th class="results-discussion">Discussão</th>
                        <th class="results-route">Linhas</th>
                    </tr>
                </thead>
                <tbody>

                    <?php CreateFullEntry( "BR-MG-BHTrans" ); ?>

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

