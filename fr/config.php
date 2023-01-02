<!DOCTYPE html>
<html lang="fr">

<?php $title="Configuration"; include('html-head.inc'); ?>

<?php include('../script/config.php'); ?>

    <body>

<?php if ( isset($network) ) { $found = ReadDetails( $network ); } else { $found = ''; } ?>

      <div id="wrapper">

<?php include "header.inc" ?>

        <nav id="navigation">
            <h2 id="de">Détails de configuration <?php if ( $found ) { printf( "pour %s", $network ); } ?></h2>
            <ul>
                <li><a href="#overpass-api">Requête Overpass-API</a></li>
                <li><a href="#options">Options d'analyse</a></li>
                <li><a href="#discussion">Discussion</a>
                    <ul>
                        <li><a href="#discussion-ptna">Discussion générale sur le PTNA</a></li>
                        <li><a href="#discussion-network">Discussion pour cette analyse</a></li>
                    </ul>
                </li>
             </ul>
        </nav>

        <hr />

        <main id="main" class="results">

            <h2 id="overpass-api">Requête Overpass-API</h2>
            <div class="indent">

                <p>
                    <a href="https://wiki.openstreetmap.org/wiki/FR:Overpass_API">L'API Overpass</a> est utilisée pour télécharger les données OSM.
                    <a href="/fr/index.php#overpass">La requête utilisée</a> renvoie tous les chemins et nœuds des itinéraires (leurs membres avec leurs détails) à partir d'une <a href = "/fr/index.php#searcharea">zone de recherche</a>.
                    Les données ainsi obtenues permettent une analyse des itinéraires de transports en commun pour par exemple vérifier l'intégralité de l'itinéraire.
                    Les nœuds, voies et relations (arrêts et plateformes) ainsi que leurs attributs peuvent être vérifiés ainsi leur «rôle» dans la relation.
                </p>

                <?php if ( $found ) {
                          $query = htmlentities( GetOverpassQuery() );
                          $fsize = GetOsmXmlFileSizeByte();
                          $rlink = GetRegionLink();
                          $rname = htmlentities( GetRegionName() );
                          if ( $query ) { printf( "<p><code>%s</code></p>\n", $query ); }
                          if ( $fsize ) { printf( "<p>Cette requête fournit actuellement environ %.3f MB.\n</p>", $fsize / 1024 / 1024 ); }
                          if ( $rlink ) {
                              printf( "<p>Afficher la <a href=\"/fr/index.php#searcharea\">zone de recherche</a> " );
                              if ( $rname ) { printf( "\"<strong>%s</strong>\" ", $rname ); }
                              printf( "sur la <a href=\"%s\">carte OSM</a>.</p>\n", $rlink );
                          }
                      }
                ?>
            </div>

            <hr />

            <h2 id="options">Options d'analyse</h2>
            <div class="indent">

                <p>
                    Les <a href="/fr/index.php#messages">erreurs et commentaires</a> signalés par PTNA peuvent être contrôlés par diverses <a href="/fr/index.php#options">options d'analyse</a>.<br />
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
                        <?php if ( $found ) { PrintOptionDetails( "fr" ); } ?>
                    </tbody>
                </table>
            </div>

            <hr />

            <h2 id="discussion">Discussion</h2>
            <div class="indent">

                <p>
                </p>

                <h3 id="discussion-ptna">Discussion générale sur le PTNA</h3>
                <div class="indent">

                    <p>
                        <?php $link = GetDiscussionPagePtna();
                              if ( $link ) {
                                  printf( "<a href=\"%s\">Discussion générale sur le PTNA</a> dans le Wiki de l'OSM.", $link );
                              } else {
                                  echo "???";
                              }
                        ?>
                    </p>
                </div>

                <h3 id="discussion-network">Discussion pour cette analyse</h3>
                <div class="indent">

                    <p>
                        <?php $link = GetDiscussionPageNetwork();
                              if ( $link ) {
                                  printf( "<a href=\"%s\">Discussion pour cette analyse</a>, ce 'network' dans le Wiki de l'OSM.", $link );
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
