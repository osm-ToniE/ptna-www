<?php
        $lang_title=                        "Search Area";
        $lang_name=                         "Name";
        $lang_region=                       "City / Region";
        $lang_network=                      "Network";
        $lang_download=                     "Download area details from Overpass-API";
        $lang_overpass_api=                 "Search area for Overpass-API query";
        $lang_overpass_api_description=     "In most cases, the definition of the area is based on the 'wikidata' tag of (administrative) boundary relation(s).\n" .
                                            "The other cases are being converted gradually.\n";
        $lang_osmium_extract=               "Search area for 'osmium extract'";
        $lang_osmium_extract_description=   "This slightly larger area is used for PTNA's nightly analysis only.\n" .
                                            "It defines the area handed over to 'osmium extract' and is usually created with the tool and settings mentioned below, applied to the ID of relevant (administrative) boundary relation(s).\n" .
                                            "The number of nodes in the polygon defining the extract area is reduced.\n" .
                                            "A buffer around the Overpass-API area exists also.\n" .
                                            "'osmium' extracts OSM objects from this area from the OSM Planet dump, including their associated nodes and ways (not relations) outside this area.\n" .
                                            "Subsequently, 'osmium filter' is used to reduce the size of the extract by deleting irrelevant data (buildings, landuse, bicycle routes, ...).\n";
        $lang_osmium_getid=                 "Search area for 'osmium getid'";
        $lang_osmium_getid_description=     "This even larger area is used when PTNA has reported missing object data that was not found in the “osmium extract” area.\n".
                                            "This data concerns relations outside the extract area that are members of route_master or route relations inside the area (e.g., MP platforms in stations).\n" .
                                            "The area is usually created using the tool and settings listed below, which are applied to the ID of the corresponding (administrative) boundary relation(s).\n" .
                                            "Zoom out to see the size of this area.";
?>
