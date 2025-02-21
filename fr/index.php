<!DOCTYPE html>
<html lang="fr">

<?php $title="Documentation"; include('html-head.inc'); ?>

    <body>
      <div id="wrapper">

<?php include "header.inc" ?>

        <nav id="navigation">
            <h2>Documentation</h2>
            <ul>
                <li><a href="#motivation">Motivation</a></li>
                <li><a href="#overview">Aperçu</a></li>
                <li><a href="#web">Le site web</a>
                    <ul>
                        <li><a href="#analysislist">Résultats</a></li>
                        <li><a href="#statistics">Statistiques</a></li>
                    </ul>
                </li>
                <li><a href="#networkroutes">Itinéraires appartenant au réseau 'network'</a></li>
                <li><a href="#analysis">L'analyse</a>
                    <ul>
                        <li><a href="#routesdescription">Description des lignes attendues</a></li>
                        <li><a href="#overpass">Téléchargement de données de OSM</a></li>
                        <li><a href="#analysissettings">Definition des options d'analyse</a></li>
                        <li><a href="#dataanalysis">Analyse des données</a>
                            <ul>
                                <li><a href="#analysisdate">Date des données</a></li>
                                <li><a href="#analysisroutes">Aperçu des lignes de transport en commun</a></li>
                                <li><a href="#analysisnotassigned">Lignes non assignées</a></li>
                                <li><a href="#analysisother">Autres lignes de transport en commun</a></li>
                                <li><a href="#analysisnoref">Lignes de transport en commun sans 'ref'</a></li>
                                <li><a href="#analysisrelations">Autres relations</a></li>
                                <li><a href="#analysisnetwork">Détails des valeurs pour l’attribut 'network</a>
                                    <ul>
                                       <li><a href="#analysisnetworkconsidered">Valeurs de l'attribut 'network' prises en compte</a></li>
                                       <li><a href="#analysisnetworknotconsidered">Valeurs de l'attribut 'network' non prises en compte</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                        <li><a href="#checks">Contrôles</a>
                            <ul>
                                <li><a href="#scheme">Schéma utilisé</a>
                                   <ul>
                                      <li><a href="#deviations">Divergences</a></li>
                                      <li><a href="#specials">Particularités</a></li>
                                    </ul>
                                </li>
                                <li><a href="#approach">Marche à suivre</a></li>
                                <li><a href="#options">Options d'analyse</a></li>
                                <li><a href="#messages">Messages</a></li>
                                <li><a href="#taginfo">PTNA sur 'taginfo'</a></li>
                            </ul>
                        </li>
                    </ul>
                </li>
                <li><a href="#code">Le Code</a>
                    <ul>
                        <li><a href="#ptna">ptna</a></li>
                        <li><a href="#ptnanetworks">ptna-networks</a></li>
                        <li><a href="#ptnawww">ptna-www</a></li>
                        <li><a href="#gtfs">gtfs</a></li>
                        <li><a href="#gtfsfeeds">gtfs-feeds</a></li>
                    </ul>
                </li>
            </ul>
        </nav>

        <hr />

        <main id="main">

            <h2 id="motivation">Motivation</h2>
            <div class="indent">
                <p>
                    Les premières <a href="https://wiki.openstreetmap.org/wiki/Talk:M%C3%BCnchen/Transportation#Qualit.C3.A4tssicherung_-_M.C3.BCnchen.2FTransportation">discussions</a> (en allemand) ont commencé lors d'une réunion d'OSM à Munich en février 2017.
                </p>
                <p>
                    Toute cette discussion a été déclenchée par la suppression involontaire de relations de bus dans la région de Munich (mais de nouvelles relations ont été créées).
                    En conséquence, de nombreux liens sur la page <a href="https://wiki.openstreetmap.org/wiki/München/Transportation#Verkehrsmittel">München/Transportation</a> (en allemand) étaient obsolètes.
                    Cependant, il faut aussi dire que le site n'était pas bien entretenu dans le passé, et qu'il n'était en partie pas connu du tout.
                    La qualité et l'exactitude du site semblent être un problème général.
                </p>
                <p>
                    <strong>Problème :</strong> la qualité de la page <a class="a" href="https://wiki.openstreetmap.org/wiki/München/Transportation#Verkehrsmittel">München/Transportation</a> (en allemand) laisse à désirer :
                </p>
                <ul>
                    <li><strong>Complétude :</strong>
                        <ul>
                            <li>nous ne savons pas si nous avons listé toutes les lignes de bus existantes de MVV sur la page</li>
                            <li>nous ne savons pas si nous avons cartographié des artefacts, par exemple des lignes de bus qui ont déjà été réinitialisées ou renumérotées</li>
                            <li>les trains de banlieue, les métros et les tramways sont en nombre raisonnable, il y a des chances que nous soyons complets</li>
                        </ul>
                    </li>
                    <li><strong>PTv2:</strong>
                        <ul>
                            <li>nous ne savons pas quelles lignes ont déjà été modifiées vers "Transports publics Version 2".</li>
                            <li><a href="https://wiki.openstreetmap.org/wiki/FR:Transports_publics">Transports publics</a>. Le texte original de la proposition se trouve sous la rubrique"
                                <a href="https://wiki.openstreetmap.org/w/index.php?title=Proposed_features/Public_Transport&amp;oldid=625726">Caractéristiques approuvées - Transports publics » (version 625726 approuvée en anglais)</a>
                            </li>
                        </ul>
                    </li>
                    <li><strong>Exactitude :</strong>
                        <ul>
                            <li>nous ne savons pas si les lignes passées en PTv2 sont cohérentes et triées</li>
                            <li>c'est-à-dire si les chemins sont saisies correctement, dans le bon ordre, sans discontinuité, sans ajouts et aux giratoires</li>
                            <li>si les membres "stop" et "platform" sont saisis intégralement et dans le bon ordre</li>
                        </ul>
                    </li>
                    <li><strong>Uniformité :</strong>
                        <ul>
                            <li>nous ne savons pas si toutes les relations avec leurs attributs sont complètes et correctes</li>
                            <li>c'est-à-dire avec des "network", "operator",
                                public_transport: version, name, ref, from, to (et via), ...
                            </li>
                        </ul>
                    </li>
                    <li><strong>Clarté :</strong>
                        <ul>
                            <li>nous n'avons pas de page qui nous montre tout cela, <strong>mais surtout les problèmes que cela pose </strong>
                            </li>
                        </ul>
                    </li>
                    <li><strong>Automatisation :</strong>
                        <ul>
                            <li>nous n'avons pas la possibilité de créer automatiquement une telle page récapitulative (hebdomadaire, ...)
                            </li>
                        </ul>
                    </li>
                </ul>
                <p>
                    <strong>Les causes </strong> sont nombreuses :
                </p>
                <ul>
                    <li><strong>Exhaustivité :</strong>
                        <ul>
                            <li>d'où proviennent les informations ? Nous pouvons recevoir une liste du MVV (CSV, ...)</li>
                        </ul>
                    </li>
                    <li><strong>PTv2:</strong>
                        <ul>
                            <li>certaines lignes n'ont ni la "version" 1 ni la 2 comme attribut : oubli, ignorance de l'existence ...</li>
                         </ul>
                    </li>
                    <li><strong>Correction :</strong>
                        <ul>
                            <li>Il s'agit d'un travail fastidieux qui doit être recommencé à plusieurs reprises, car les relations sont rapidement (involontairement) "remplies" de trous, ...</li>
                        </ul>
                    </li>
                    <li><strong>Uniformité :</strong>
                        <ul>
                            <li>Quelle est la norme ? network = MVV ou network = "Münchner Verkehrs- und Tarif-Verbund" et ainsi de suite ? <a href="https://wiki.openstreetmap.org/wiki/München/Transportation#Vorschlag_für_vereinheitliches_Tagging">Proposition d’attributs unifiés pour les Transports de Munich</a> (exte en allemand)</li>
                        </ul>
                    </li>
                    <li><strong>Clarté :</strong>
                        <ul>
                            <li>Certaines parties de la page sont déjà plus claires, à quoi pourrait ressembler une page plus claire (mise en page ?)</li>
                        </ul>
                    </li>
                    <li><strong>Automatisation :</strong>
                        <ul>
                            <li>il n'y a rien</li>
                        </ul>
                    </li>
                </ul>
                <p>
                    Une vue non représentative de Berlin, Hambourg et Aix-la-Chapelle montre que d'autres villes ont le même problème.
                </p>
            </div> <!-- "motivation" -->

            <hr />

            <h2 id="overview">Aperçu</h2>
            <div class="indent">
                <p>
                    Lorem ipsum dolor sit amet, consectetur adipisici elit, …
                </p>
            </div> <!-- "overview" -->

            <hr />

            <h2 id="web">Le site web</h2>
            <div class="indent">
                <p>
                    Lorem ipsum dolor sit amet, consectetur adipisici elit, …
                </p>
                <h3 id="analysislist">L'analyse</h3>
                <div class="indent">
                    <p>
                        Lorem ipsum dolor sit amet, consectetur adipisici elit, …
                    </p>
                    <ul>
                        <li>Nom</li>
                        <li>Ville / Région</li>
                        <li>Network</li>
                        <li>Résultats</li>
                        <li>Derniers changements</li>
                        <li>Discussion</li>
                        <li>Lignes</li>
                    </ul>
                </div> <!-- "analysislist" -->
                <h3 id="statistics">Statistiques</h3>
                <div class="indent">
                    <p>
                        <a href="/en/statistics.php">Statistics</a> ... Lorem ipsum dolor sit amet, consectetur adipisici elit, …
                    </p>
                </div> <!-- "statistics" -->
            </div> <!-- "web" -->

            <hr />

            <h2 id="networkroutes">Les itinéraires appartenant au réseau 'network'</h2>
            <div class="indent">
                <p>
                    Lorem ipsum dolor sit amet, consectetur adipisici elit, …
                </p>
                <p>
                    <strong>Important : Tenez compte du Copyright &copy ; et de l'origine des données !</strong><br />
                </p>
                <p>
                    <strong>Note : La liste sera publiée sous licence <a href="https://www.gnu.org/licenses/gpl.html">GPL 3</a>.</strong>
                </p>
            </div> <!-- "networkroutes" -->

            <hr />

            <h2 id="analysis">L'analyse</h2>
            <div class="indent">
                <p>
                    Lorem ipsum dolor sit amet, consectetur adipisici elit, …
                </p>

                <h3 id="routesdescription">Description des lignes attendues</h3>
                <div class="indent">
                    <p>
                        Lorem ipsum dolor sit amet, consectetur adipisici elit, …
                    </p>
                    <p>
                        <strong>Important : Tenez compte du Copyright &copy ; et de l'origine des données !</strong><br />
                    </p>
                    <p>
                        <strong>Note : La liste sera publiée sous licence <a href="https://www.gnu.org/licenses/gpl.html">GPL 3</a>.</strong>
                    </p>
                    <p>
                        Exemple : Lignes de <a href="https://wiki.openstreetmap.org/wiki/M%C3%BCnchen/Transportation/MVV-Linien-gesamt">Münchner Verkehrs- und Tarifverbund</a> (en allemand) dans le Wiki OSM
                    </p>
                </div> <!-- "routesdescription" -->

                <h3 id="overpass">Téléchargement de données de OSM</h3>
                <div class="indent">
                    <p>
                        Lorem ipsum dolor sit amet, consectetur adipisici elit, …
                    </p>
	                <h4 id="searcharea">Définition de la zone de recherche</h4>
                    <div class="indent">
                        <p>
                            Lorem ipsum dolor sit amet, consectetur adipisici elit, …
                        </p>
		            </div> <!-- searcharea -->

		            <h4 id="searchdata">Sélection des itinéraires, des routes et des nœuds pertinents</h4>
                    <div class="indent">
                        <p>
                            Lorem ipsum dolor sit amet, consectetur adipisici elit, …
                        </p>
		            </div> <!-- searchdata -->

		            <h4 id="searchoutput">Production de données</h4>
                    <div class="indent">
                        <p>
                            Lorem ipsum dolor sit amet, consectetur adipisici elit, …
                        </p>
		            </div> <!-- searchoutput -->
                    <p>
                        Lorem ipsum dolor sit amet, consectetur adipisici elit, …
                    </p>
                </div> <!-- "overpass" -->

                <h3 id="analysissettings">Définition des options d'analyse</h3>
                <div class="indent">
                    <p>
                        Lorem ipsum dolor sit amet, consectetur adipisici elit, …
                    </p>
                </div> <!-- "#analysissettings" -->

                <h3 id="dataanalysis">Analyse des données</h3>
                <div class="indent">
                    <p>
                        Lorem ipsum dolor sit amet, consectetur adipisici elit, …
                    </p>

                    <h4 id="analysisdate">Date des données</h4>
                    <div class="indent">
                        <p>
                            Lorem ipsum dolor sit amet, consectetur adipisici elit, …
                        </p>
                        <p>
                            Exemple : <a href="/results/DE/BY/DE-BY-MVV-Analysis.html#A1">Münchner Verkehrs- und Tarifverbund</a>
                        </p>
                    </div> <!-- "analysisdate" -->

                    <h4 id="analysisroutes">Aperçu des Lignes du Réseau de transports en commun de ... </h4>
                    <div class="indent">
                        <p>
                            Lorem ipsum dolor sit amet, consectetur adipisici elit, …
                        </p>
                        <p>
                            Exemple : <a href="/results/DE/BY/DE-BY-MVV-Analysis.html#A2">Münchner Verkehrs- und Tarifverbund</a>
                        </p>
                    </div> <!-- "analysisroutes" -->

                    <h4 id="analysisnotassigned">Lignes non attribuées</h4>
                    <div class="indent">
                        <p>
                            Lorem ipsum dolor sit amet, consectetur adipisici elit, …
                        </p>
                        <p>
                            Exemple : <a href="/results/DE/SN/DE-SN-VMS-Analysis.html#A3">Verkehrsverbund Mittelsachsen</a>
                        </p>
                    </div> <!-- "analysisnotassigned" -->

                    <h4 id="analysisother">Autres lignes de transport en commun</h4>
                    <div class="indent">
                        <p>
                            Lorem ipsum dolor sit amet, consectetur adipisici elit, …
                        </p>
                        <p>
                            Exemple : <a href="/results/DE/BY/DE-BY-RVO-Analysis.html#A3">Regionalverkehr Oberbayern</a>
                        </p>
                    </div> <!-- "analysisother" -->

                    <h4 id="analysisnoref">Lignes de transport en commun sans 'ref'</h4>
                    <div class="indent">
                        <p>
                            Lorem ipsum dolor sit amet, consectetur adipisici elit, …
                        </p>
                        <p>
                            Exemple : <a href="/results/DE/NI/DE-NI-VEJ-Analysis.html#A4">Verkehrsverbund Ems-Jade</a>
                        </p>
                    </div> <!-- "analysisnoref" -->

                    <h4 id="analysisrelations">Autres Relations</h4>
                    <div class="indent">
                        <p>
                            Lorem ipsum dolor sit amet, consectetur adipisici elit, …
                        </p>
                        <p>
                            Exemple : <a href="/results/DE/NW/DE-NW-VRS-Analysis.html#A5">Verkehrsverbund Rhein-Sieg (VRS)</a>
                        </p>
                    </div> <!-- "analysisrelations" -->

                    <h4 id="analysisnetwork">Détails des valeurs pour l’attribut 'network'</h4>
                    <div class="indent">
                        <p>
                            Lorem ipsum dolor sit amet, consectetur adipisici elit, …
                        </p>

                        <h5 id="analysisnetworkconsidered">Valeurs de l’attribut 'network' prises en compte</h5>
                        <div class="indent">
                            <p>
                                Lorem ipsum dolor sit amet, consectetur adipisici elit, …
                            </p>
                            <p>
                                Exemple : <a href="/results/DE/SN/DE-SN-VMS-Analysis.html#A7.1">Verkehrsverbund Mittelsachsen (VMS)</a>
                            </p>
                        </div> <!-- "analysisnetworkconsidered" -->

                        <h5 id="analysisnetworknotconsidered">Valeurs de l'attribut 'network' non prises en compte</h5>
                        <div class="indent">
                            <p>
                                Lorem ipsum dolor sit amet, consectetur adipisici elit, …
                            </p>
                            <p>
                                Exemple : <a href="/results/DE/SN/DE-SN-VMS-Analysis.html#A7.2">Verkehrsverbund Mittelsachsen (VMS)</a>
                            </p>
                        </div> <!-- "analysisnetworknotconsidered" -->
                    </div> <!-- "analysisnetwork" -->
                </div> <!-- "dataanalysis" -->

                <h3 id="checks">Contrôles</h3>
                <div class="indent">
                    <p>
                        Lorem ipsum dolor sit amet, consectetur adipisici elit, …
                    </p>

                    <h4 id="scheme">Schéma utilisé</h4>
                    <div class="indent">
                        <p>
                            Lorem ipsum dolor sit amet, consectetur adipisici elit, …
                        </p>
                        <p>
                            Voir : <a href="https://wiki.openstreetmap.org/wiki/User:ToniE/analyze-routes#Verwendetes_Schema"> Wiki OSM (en allemand)</a>
                        </p>

                        <h5 id="deviations">Divergences</h5>
                        <div class="indent">
                            <p>
                                Lorem ipsum dolor sit amet, consectetur adipisici elit, …
                            </p>
                            <p>
                                Voir : <a href="https://wiki.openstreetmap.org/wiki/User:ToniE/analyze-routes#Abweichungen"> Wiki OSM (en allemand)</a>
                            </p>
                        </div> <!-- "deviations" -->

                        <h5 id="specials">Particularités</h5>
                        <div class="indent">
                            <p>
                                Lorem ipsum dolor sit amet, consectetur adipisici elit, …
                            </p>
                            <p>
                                Voir : <a href="https://wiki.openstreetmap.org/wiki/User:ToniE/analyze-routes#Besonderheiten">Wiki OSM (en allemand)</a>
                            </p>
                        </div> <!-- "specials" -->
                    </div> <!-- "scheme" -->

                    <h4 id="approach">Méthode</h4>
                    <div class="indent">
                        <p>
                            Lorem ipsum dolor sit amet, consectetur adipisici elit, …
                        </p>
                        <p>
                            Voir : <a href="https://wiki.openstreetmap.org/wiki/User:ToniE/analyze-routes#Vorgehensweise">Wiki OSM (en allemand)</a>
                        </p>
                    </div> <!-- "approach" -->

                    <h4 id="options">Options d'analyse</h4>
                    <div class="indent">
                        <p>
                             Lorem ipsum dolor sit amet, consectetur adipisici elit, …
                        </p>

                        <?php include "option-table.inc" ?>

                    </div> <!-- "options" -->

                    <h4 id="messages">Messages</h4>
                    <div class="indent">
                        <p>
                             Lorem ipsum dolor sit amet, consectetur adipisici elit, …
                        </p>

                        <?php include "message-table.inc" ?>

                    </div> <!-- "messages" -->

                    <h4 id="taginfo">PTNA sur 'taginfo'</h4>
                    <div class="indent">
                        <p>
                            PTNA et les
                            '<a href="https://wiki.openstreetmap.org/wiki/FR:Attributs"     title="What are'tags', OSM Wiki"    >attributs</a>'  analysés par PTNA sont répertoriés dans
                            '<a href="https://wiki.openstreetmap.org/wiki/Taginfo/Projects" title="Taginfo Projects im OSM Wiki">taginfo-projects</a>' en tant que
                             <a href="https://taginfo.openstreetmap.org/projects/ptna"      title="PTNA als Projekt bei taginfo-projects">projet</a>.
                            <ul>
                                <li><a href="https://taginfo.openstreetmap.org/projects/ptna#tags" title="'tags' analysed by PTNA">Analyse</a></li>
                                <li><a href="https://github.com/taginfo/taginfo-projects"          title="Taginfo Projects on GitHub">taginfo-projects dans GitHub</a></li>
                            </ul>
                        </p>
                    </div> <!-- "taginfo" -->

                </div> <!-- "checks" -->
            </div> <!-- "analysis" -->

            <hr />

            <h2 id="code">Le Code</h2>
            <div class="indent">
                <p>
                    Lorem ipsum dolor sit amet, consectetur adipisici elit, …
                </p>

                <h3 id="ptna">ptna</h3>
                <div class="indent">
                    <p>
                        Lorem ipsum dolor sit amet, consectetur adipisici elit, …
                    </p>
                    <p>
                        Voir : <a href="https://github.com/osm-ToniE/ptna">ptna dans GitHub</a>
                    </p>
                </div> <!-- "ptna" -->

                <h3 id="ptnanetworks">ptna-networks</h3>
                <div class="indent">
                    <p>
                        Lorem ipsum dolor sit amet, consectetur adipisici elit, …
                    </p>
                    <p>
                        Voir : <a href="https://github.com/osm-ToniE/ptna-networks">ptna-networks dans GitHub</a>
                    </p>
                </div> <!-- "ptnanetworks" -->

                <h3 id="ptnawww">ptna-www</h3>
                <div class="indent">
                    <p>
                        Lorem ipsum dolor sit amet, consectetur adipisici elit, …
                    </p>
                    <p>
                        Voir : <a href="https://github.com/osm-ToniE/ptna-www">ptna-www dans GitHub</a>
                    </p>
                </div> <!-- "ptnawww" -->

                <h3 id="gtfs">gtfs</h3>
                <div class="indent">
                    <p>
                        Lorem ipsum dolor sit amet, consectetur adipisici elit, …
                    </p>
                    <p>
                        Voir : <a href="https://github.com/osm-ToniE/gtfs">gtfs dans GitHub</a>
                    </p>
                </div> <!-- "gtfs" -->

                <h3 id="gtfsfeeds">gtfs-feeds</h3>
                <div class="indent">
                    <p>
                        Lorem ipsum dolor sit amet, consectetur adipisici elit, …
                    </p>
                    <p>
                        Voir : <a href="https://github.com/osm-ToniE/gtfs-feeds">gtfs-feeds dans GitHub</a>
                    </p>
                </div> <!-- "gtfsfeeds" -->
            </div> <!-- "code" -->
        </main>

        <hr />

<?php include "footer.inc" ?>

      </div> <!-- wrapper -->
    </body>
</html>
