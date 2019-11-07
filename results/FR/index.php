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
                <h2>Analyse statique pour OpenStreetMap</h2>
            </div>
            <div id="headernav">
                <a href="/">Home</a> |
                <a href="/contact.html">Contact</a> |
                <a target="_blank" href="https://www.openstreetmap.de/impressum.html">Impressum</a> |
                <a target="_blank" href="https://www.fossgis.de/datenschutzerklaerung">Datenschutzerklärung</a> |
                <a href="/en/index.html" title="english"><img src="/img/GreatBritain16.png" alt="Union Jack" /></a>
                <a href="/de/index.html" title="deutsch"><img src="/img/Germany16.png" alt="deutsche Flagge" /></a>
                <!-- <a href="/fr/index.html" title="français"><img src="/img/France16.png" alt="Tricolore Française" /></a> -->
            </div>
        </header>

        <main id="main" class="results">

            <h2 id="FR"><img src="/img/France32.png" alt="Tricolore Française" /> Des Résultats pour la France</h2>
            <p>
                La première colonne comprend des liens vers les résultats de l'analyse.
            </p>
            <p>
                La colonne "Dernière modification" renvoie aux pages HTML indiquant les différences par rapport aux derniers résultats d'analyse.
                Celles-ci sont colorées, vous pouvez utiliser les boutons de navigation <img class="diff-navigate" src="/img/diff-navigate.png" alt="Navigation"> en bas à droite ou les caractères 'j' (avant) et 'k' (arrière) pour passer de différence á différence.
                Cette colonne comprend la date de la dernière analyse où des changements pertinents sont apparus.
                Les dates plus anciennes signifient qu'il n'y a pas eu de changement dans les résultats.
                Néanmoins, les données ont été analysées comme indiqué dans la colonne "Date de l'analyse".
            </p>

            <table id="networksFR">
                <thead>
                    <tr class="results-tableheaderrow">
                        <th class="results-name">Nom</th>
                        <th class="results-region">Ville / Départment / Région</th>
                        <th class="results-network">Réseau</th>
                        <th class="results-datadate">Date de l'Analyse</th>
                        <th class="results-analyzed">Dernière Modification</th>
                        <th class="results-discussion">Discussion</th>
                        <th class="results-route">Lignes</th>
                    </tr>
                </thead>
                <tbody>

                    <?php CreateFullEntry("FR-IDF-aerial"); ?>

                    <?php CreateFullEntry("FR-IDF-albatrans"); ?>

                    <?php CreateFullEntry("FR-IDF-apolo-7"); ?>

                    <?php CreateFullEntry("FR-IDF-arlequin"); ?>

                    <?php CreateFullEntry("FR-IDF-bus-en-seine"); ?>

                    <?php CreateFullEntry("FR-IDF-busval-d-oise"); ?>

                    <?php CreateFullEntry("FR-IDF-cars-moreau"); ?>

                    <?php CreateFullEntry("FR-IDF-ceat"); ?>

                    <?php CreateFullEntry("FR-IDF-cif"); ?>

                    <?php CreateFullEntry("FR-IDF-com-bus"); ?>

                    <?php CreateFullEntry("FR-IDF-comete"); ?>

                    <?php CreateFullEntry("FR-IDF-cso"); ?>

                    <?php CreateFullEntry("FR-IDF-entre-seine-et-foret"); ?>

                    <?php CreateFullEntry("FR-IDF-fileo"); ?>

                    <?php CreateFullEntry("FR-IDF-goelys"); ?>

                    <?php CreateFullEntry("FR-IDF-houdanais"); ?>

                    <?php CreateFullEntry("FR-IDF-hourtoule"); ?>

                    <?php CreateFullEntry("FR-IDF-lacroix"); ?>

                    <?php CreateFullEntry("FR-IDF-les-cars-bleus"); ?>

                    <?php CreateFullEntry("FR-IDF-melibus"); ?>

                    <?php CreateFullEntry("FR-IDF-mobicaps"); ?>

                    <?php CreateFullEntry("FR-IDF-noctilien"); ?>

                    <?php CreateFullEntry("FR-IDF-ormont-transport"); ?>

                    <?php CreateFullEntry("FR-IDF-Peps"); ?>

                    <?php CreateFullEntry("FR-IDF-paladin"); ?>

                    <?php CreateFullEntry("FR-IDF-parisis"); ?>

                    <?php CreateFullEntry("FR-IDF-pays-crecois"); ?>

                    <?php CreateFullEntry("FR-IDF-pays-de-l-ourcq"); ?>

                    <?php CreateFullEntry("FR-IDF-pays-de-meaux"); ?>

                    <?php CreateFullEntry("FR-IDF-pays-fertois"); ?>

                    <?php CreateFullEntry("FR-IDF-phebus"); ?>

                    <?php CreateFullEntry("FR-IDF-poissy-aval-deux-rives-de-seine"); ?>

                    <?php CreateFullEntry("FR-IDF-procars"); ?>

                    <?php CreateFullEntry("FR-IDF-r-bus"); ?>

                    <?php CreateFullEntry("FR-IDF-rambouillet-interurbain"); ?>

                    <?php CreateFullEntry("FR-IDF-reseau-du-canton-de-perthes"); ?>

                    <?php CreateFullEntry("FR-IDF-savac"); ?>

                    <?php CreateFullEntry("FR-IDF-seine-et-marne-express"); ?>

                    <?php CreateFullEntry("FR-IDF-seine-saint-denis"); ?>

                    <?php CreateFullEntry("FR-IDF-seine-senart-bus"); ?>

                    <?php CreateFullEntry("FR-IDF-senart-bus"); ?>

                    <?php CreateFullEntry("FR-IDF-situs"); ?>

                    <?php CreateFullEntry("FR-IDF-siyonne"); ?>

                    <?php CreateFullEntry("FR-IDF-sol-r"); ?>

                    <?php CreateFullEntry("FR-IDF-sqybus"); ?>

                    <?php CreateFullEntry("FR-IDF-still"); ?>

                    <?php CreateFullEntry("FR-IDF-stivo"); ?>

                    <?php CreateFullEntry("FR-IDF-tam"); ?>

                    <?php CreateFullEntry("FR-IDF-tice"); ?>

                    <?php CreateFullEntry("FR-IDF-tramy"); ?>

                    <?php CreateFullEntry("FR-IDF-trans-essonne"); ?>

                    <?php CreateFullEntry("FR-IDF-transdev-ile-de-france-conflans"); ?>

                    <?php CreateFullEntry("FR-IDF-transports-daniel-meyer"); ?>

                    <?php CreateFullEntry("FR-IDF-val-de-seine"); ?>

                    <?php CreateFullEntry("FR-IDF-vybus"); ?>

                    <?php CreateFullEntry("FR-IDF-yerres"); ?>

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

