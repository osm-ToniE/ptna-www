<!DOCTYPE html>
<html lang="da">

<?php $title="GTFS"; include "html-head.inc" ?>

    <body>
      <div id="wrapper">

<?php include "header.inc" ?>

        <nav id="navigation">
            <h2>GTFS</h2>
            <ul>
                <li><a href="#gtfsdata">Hvad er GTFS-data?</a></li>
                <li><a href="#download">Opdater dataene</a></li>
                <li><a href="#prepare">Forberedelse af GTFS-data</a></li>
                <li><a href="#aggregate">GTFS-datasamling</a>
                <li><a href="#analyze">Analyse af GTFS-data</a>
                <li><a href="#normalize">Normalisering af GTFS-data</a>
            </ul>
        </nav>

        <hr />

        <main id="main">

            <h2 id="gtfsdata">Hvad er GTFS-data?</h2>
            <div class="indent">
                <p>
                    Citat fra MobilityDatas websted på <a href="https://gtfs.org/">GTFS</a> (Oversat med DeepL.com oversætter):
                </p>
                <p>"<i>General Transit Feed Specification (GTFS) er en åben standard, der bruges til at distribuere relevante oplysninger om transitsystemer til passagerer.
                    Den giver offentlige transportvirksomheder mulighed for at offentliggøre deres transitdata i et format, der kan bruges af en lang række softwareprogrammer.
                    I dag bruges GTFS-dataformatet af tusindvis af udbydere af offentlig transport.</i>"
                </p>
            </div>

            <hr />

            <h2 id="download">Opdater dataene</h2>
            <div class="indent">
                <p>
                    Dataene på denne side opdateres med uregelmæssige intervaller af flere grunde:
                </p>
                <ul>
                    <li>Nogle foreninger leverer nye versioner næsten hver dag uden at specificere en dato.</li>
                    <li>Nogle netværk leverer data med meget uregelmæssige intervaller.</li>
                    <li>Nogle data kan downloades direkte og altid via det samme link.</li>
                    <li>Nogle data kan kun downloades indirekte via, pr. Version, forskellige links - for at forhindre automatisk indlæsning?</li>
                    <li>I det mindste kan downloadingen ikke let automatiseres</li>
                    <li>Offentlige transportforbindelser bør have en langsigtet karakter i OSM. Er det fornuftigt at kortlægge enhver ændring af en buslinje på grund af byggepladsen i OSM for senere at fortryde den?</li>
                </ul>
            </div>

            <hr />

            <h2 id="prepare">Forberedelse af GTFS-data</h2>
            <div class="indent">
                <p>
                    GTFS-data fra transportforeningen er forberedt til anvendelse i PTNA.
                </p>
                <ul>
                    <li>Tabel "osm"
                        <ul>
                            <li>Tilføj OSM-specifikke oplysninger som en separat tabel.
                                <ul>
                                    <li>Værdien af 'network' til PT-relation (f.eks. "Münchner Verkehrs- und Tarifverbund").</li>
                                    <li>Værdien af 'network:short' til PT-relation (f.eks. "MVV").</li>
                                    <li>Værdien af 'network:guid' til PT-relation (f.eks. "DE-BY-MVV").</li>
                                    <li>Værdi af 'operator' til PT-relation: kan "agency_name" fra GTFS-tabellen "agentur.txt" bruges som 'operator'?</li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                    <li>Tabel "ptna"
                        <ul>
                            <li>Tilføj PTNA-specifikke oplysninger som en separat tabel.</li>
                        </ul>
                    </li>
                    <li>Andre tabeller
                        <ul>
                            <li>Feltet "ptna_comment" tilføjes.
                                Kommentarer kan indtastes her - se "Analyse af GTFS-data".
                            </li>
                        </ul>
                    </li>
               </ul>
            </div>

            <hr />

            <h2 id="aggregate">GTFS-datasamling</h2>
            <div class="indent">
                <p>
                    GTFS-data fra transportforeningen behandles for PTNA.
                    Målet er at reducere mængden af data for at muliggøre hurtig søgning i GTFS-data.
                </p>
                <ul>
                    <li>Tabel "ptna_aggregation"
                        <ul>
                            <li>Føj PTNA-specifikke oplysninger til aggregeringen som en separat tabel.</li>
                        </ul>
                    </li>
                    <li>Tabel "routes"
                        <ul>
                            <li>Slet alle "route_id", der ikke længere er gyldige (gyldighedens afslutning før tidspunktet for aggregering / download).</li>
                       </ul>
                    </li>
                    <li>Tabel "trips"
                        <ul>
                            <li>Slet alle "trip_id", der ikke længere er gyldige (gyldighedens afslutning før tidspunktet for aggregering / download).</li>
                        </ul>
                    </li>
                    <li>Tabel "stop_times"
                        <ul>
                            <li>Slet alle overflødige "trip_id", dem med identiske ruter, der kun adskiller sig i afgangstiderne.
                                Reducer til en enkelt "trip_id" (den første "trip_id" fundet).
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>

            <hr />

            <h2 id="analyze">Analyse af GTFS-data</h2>
            <div class="indent">
                <p>
                    GTFS-data fra transportforeningen behandles for PTNA.
                    Målet er at finde ud af, hvilken rute (tur) der er en delvis rute for en anden rute.
                </p>
                <ul>
                    <li>Tabel "ptna_analysis"
                        <ul>
                            <li>Føj PTNA-specifik information til analysen som en separat tabel.</li>
                        </ul>
                    </li>
                    <li>Tabel "trips"
                        <ul>
                            <li>...</li>
                        </ul>
                    </li>
                 </ul>
            </div>

            <hr />

            <h2 id="normalize">Normalisering af GTFS-data</h2>
            <div class="indent">
                <p>
                    GTFS-data fra transportforeningen behandles for PTNA.
                    Målet er at få en ensartet stavemåde for stopnavne.
                </p>
                <ul>
                    <li>...</li>
                </ul>
            </div>
        </main>

        <hr />

<?php include "gtfs-footer.inc" ?>

	  </div> <!-- wrapper -->
    </body>
</html>
