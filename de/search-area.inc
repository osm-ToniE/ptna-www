<?php
        $lang_title=                        "Suchgebiet";
        $lang_name=                         "Name";
        $lang_region=                       "Stadt / Region";
        $lang_network=                      "Verkehrsverbund";
        $lang_download=                     "Details des Gebietes von Overpass-API laden";
        $lang_overpass_api=                 "Suchgebiet für Overpass-API-Anfragen";
        $lang_overpass_api_description=     "Für die meisten Fällen basiert die Definition des Gebiets auf dem 'wikidata'-Tag der (administrativen) Grenzrelation(en).\n" .
                                            "Die anderen Fälle werden nach und nach umgestellt.\n";
        $lang_osmium_extract=               "Suchgebiet für 'osmium extract'";
        $lang_osmium_extract_description=   "Dieser etwas größere Bereich wird ausschließlich für die nächtliche Analyse von PTNA verwendet.\n" .
                                            "Es definiert den Bereich, der an 'osmium extract' übergeben wird, und wird in der Regel mit dem unten genannten Tool und den dort angegebenen Einstellungen erstellt, die auf die ID der entsprechenden (administrativen) Grenzrelation(en) angewendet werden.\n" .
                                            "Die Anzahl der Knoten im Polygon, das den Extraktionsbereich definiert, wird reduziert.\n" .
                                            "Es gibt auch einen Puffer um den Overpass-API-Bereich herum.\n" .
                                            "'osmium' extrahiert OSM-Objekte aus diesem Bereich aus dem OSM Planet Dump, einschließlich der zugehörigen Nodes und Ways (keine Relationen) außerhalb dieses Bereichs.\n" .
                                            "Anschließend wird 'osmium filter' verwendet, um die Größe des Extrakts zu reduzieren, indem irrelevante Daten (buildings, landuse, bicycle routes usw.) gelöscht werden.\n";
        $lang_osmium_getid=                 "Suchgebiet für  'osmium getid'";
        $lang_osmium_getid_description=     "Dieser noch größere Bereich wird verwendet, wenn PTNA fehlende Objektdaten gemeldet hat, die im 'osmium extrakt' Gebiet nicht gefunden wurden.\n".
                                            "Diese Daten betreffen Relationen außerhalb des Extraktbereichs, die Mitglieder von route_master oder route Relationen innerhalb des Bereichs sind (z. B. MP-Plattformen in Bahnhöfen).\n" .
                                            "Der Bereich wird in der Regel mit dem unten aufgeführten Werkzeug und den dort angegebenen Einstellungen erstellt, die auf die ID der entsprechenden (administrativen) Grenzrelation(en) angewendet werden.\n" .
                                            "Vergrößere die Ansicht, um die Größe dieses Gebietes zu sehen.";
?>
