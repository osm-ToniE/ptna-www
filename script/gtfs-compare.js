//
//
//

const OVERPASS_API_URL_PREFIX = 'https://overpass-api.de/api/interpreter?data=[out:json];relation(';
const OVERPASS_API_URL_SUFFIX = ');(._;>>;);out;';

const PTNA_API_URL = '/api/gtfs.php';

const defaultlat    = 48.0649;
const defaultlon    = 11.6612;
const defaultzoom   = 10;

const osmlicence    = 'Map data &copy; <a href="https://openstreetmap.org" target="_blank">OpenStreetMap</a> contributors, <a href="https://www.openstreetmap.org/copyright" target="_blank">ODbL</a> &mdash; ';
const attribution   = '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors';

var map;
var layerplatforms       = {};
var layerplatformsroute  = {};
var layershapes          = {};
var right_icon;
var left_icon;
var icons           = {};
var colours         = {};


var feed;
var release_date;
var route_id;
var trip_id;
var feed2;
var release_date2;
var route_id2;
var trip_id2;
var relation_id;

var downloadstartms = 0;
var analysisstartms = 0;
var JSON_data       = { 'left' : {}, 'right' : {} };
var DATA_Nodes      = { 'left' : {}, 'right' : {} };
var DATA_Ways       = { 'left' : {}, 'right' : {} };
var DATA_Relations  = { 'left' : {}, 'right' : {} };
var CMP_List        = { 'left' : [], 'right' : [] };
var maxlat          =  -90;
var minlat          =   90;
var maxlon          = -180;
var minlon          =  180;

var dBarLeft;
var dBarRight;
var aBar;

var number_of_match     = {};
var label_of_object     = {};
var latlonroute         = { 'left' : {}, 'right' : {} };


async function showtripcomparison() {

    if ( !document.getElementById || !document.createElement || !document.appendChild ) return false;

    //  empty tiles
	var nomap  = L.tileLayer('');

    //  OpenStreetMap's Standard tile layer
	var osmorg = L.tileLayer(  'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
		                        maxZoom: 19,
		                        attribution: attribution
	                        } );

    //  OpenStreetMap's DE Style
    var osmde = L.tileLayer(    'https://{s}.tile.openstreetmap.de/tiles/osmde/{z}/{x}/{y}.png', {
                                maxZoom: 19,
                                attribution: osmlicence + 'Imagery &copy; <a href="https://www.openstreetmap.de/germanstyle.html" target="_blank">openstreetmap.de</a>'
                            } );

    // 	OSM France
    // 	https://{s}.tile.openstreetmap.fr/osmfr/{z}/{x}/{y}.png
	var osmfr = L.tileLayer(    'https://{s}.tile.openstreetmap.fr/osmfr/{z}/{x}/{y}.png', {
		                        maxZoom: 19,
		                        attribution: attribution
	                        } );

    // 	opentopomap
    // 	https://{s}.tile.openstreetmap.fr/osmfr/{z}/{x}/{y}.png
	var osmtopo = L.tileLayer(  'https://{s}.tile.opentopomap.org/{z}/{x}/{y}.png', {
		                        maxZoom: 17,
		                        attribution: 'Map data &copy; <a href="https://openstreetmap.org">OpenStreetMap</a> contributors, ' +
			                    'SRTM | Kartendarstellung: Â© <a href="https://opentopomap.org/">OpenTopoMap</a> '  +
			                    '<a href="https://creativecommons.org/licenses/by-sa/3.0/">CC-BY-SA</a>'
	                        } );

    // 	ÖPNV-karte
    // 	https://toolserver.org/~cmarqu/hill/{z}/{x}/{y}.png
	var oepnv = L.tileLayer(    'https://toolserver.org/~cmarqu/hill/{z}/{x}/{y}.png', {
		                        maxZoom: 19,
		                        attribution: attribution
	                        });

    //  Transport Map
    // 	https://{s}.tile2.opencyclemap.org/transport/{z}/{x}/{y}.png
    var transpmap = L.tileLayer(    'https://{s}.tile2.opencyclemap.org/transport/{z}/{x}/{y}.png', {
		                            maxZoom: 19,
		                            attribution: attribution
                                } );

    // Variables for the data
    var layerrightshape          = L.layerGroup();
    var layerrightstops          = L.layerGroup();
    var layerrightstopsroute     = L.layerGroup();
    var layerleftshape           = L.layerGroup();
    var layerleftstops           = L.layerGroup();
    var layerleftstopsroute      = L.layerGroup();

    map  = L.map( 'comparemap',  { center : [defaultlat, defaultlon], zoom: defaultzoom, layers: [osmorg, layerrightstops] } );

    var baseMaps = {
                    "OpenStreetMap's Standard"  : osmorg,
                    "OSM German Style"          : osmde,
                    "OSM France"                : osmfr,
                    // "OpenTopoMap"               : osmtopo,
                    "none"                      : nomap
                    // "ÖPNV-Karte": oepnv,
                    // "Transport Map (without API-Key!)": transpmap
                   };

    var overlayMapsGtfsGtfs = { '<span class="compare-trips-left">GTFS Shape</span>'              : layerleftshape,
                                '<span class="compare-trips-left">GTFS Stops</span>'              : layerleftstops,
                                '<span class="compare-trips-left">GTFS Stops Route</span>'        : layerleftstopsroute,
                                '<span class="compare-trips-right">GTFS Shape 2</span>'           : layerrightshape,
                                '<span class="compare-trips-right">GTFS Stops 2</span>'           : layerrightstops,
                                '<span class="compare-trips-right">GTFS Stops 2 Route</span>'     : layerrightstopsroute
                                };

    var overlayMapsGtfsOsm  = { '<span class="compare-trips-left">GTFS Shape</span>'              : layerleftshape,
                                '<span class="compare-trips-left">GTFS Stops</span>'              : layerleftstops,
                                '<span class="compare-trips-left">GTFS Stops Route</span>'        : layerleftstopsroute,
                                '<span class="compare-trips-right">OSM Shape</span>'              : layerrightshape,
                                '<span class="compare-trips-right">OSM Platforms</span>'          : layerrightstops,
                                '<span class="compare-trips-right">OSM Platform Route</span>'     : layerrightstopsroute
                              };

    var layers;

    feed          = URLparse()["feed"]          || '';
    feed2         = URLparse()["feed2"]         || feed;
    release_date  = URLparse()["release_date"]  || '';
    release_date2 = URLparse()["release_date2"] || '';
    trip_id       = URLparse()["trip_id"]       || '';
    trip_id2      = URLparse()["trip_id2"]      || '';
    relation_id   = URLparse()["relation"]      || '';

    if ( relation_id !== '' ) {
        layers    = L.control.layers(baseMaps, overlayMapsGtfsOsm).addTo(map);
    } else {
        layers    = L.control.layers(baseMaps, overlayMapsGtfsGtfs).addTo(map);
    }

    dBarLeft   = document.getElementById('download_left');
    dBarRight  = document.getElementById('download_right');
    aBar       = document.getElementById('analysis');

    map.addLayer(layerrightstopsroute);
    map.addLayer(layerleftstops);
    map.addLayer(layerleftstopsroute);

    right_icon  = L.icon( { iconUrl: '/img/marker-right.png',  iconSize: [24,24], iconAnchor: [0,24],  popupAnchor: [0,0], tooltipAnchor: [24,-32] } );
    left_icon   = L.icon( { iconUrl: '/img/marker-left.png',   iconSize: [24,24], iconAnchor: [24,24], popupAnchor: [0,0], tooltipAnchor: [-24,-32] } );
    icons       = { 'left': left_icon, 'right': right_icon };
    colours     = { 'left': '#fc0fc0', 'right': '#6495ed'  };
    layerplatform       = { 'left': layerleftstops,      'right': layerrightstops      };
    layerplatformroute  = { 'left': layerleftstopsroute, 'right': layerrightstopsroute };
    layershape          = { 'left': layerleftshape,      'right': layerrightshape      };

    await download_left_data().then( (data)  => parseHttpResponse( 'left', data ) );
    await download_right_data().then( (data) => parseHttpResponse( 'right', data ) );

    // console.log(DATA_Nodes);
    // console.log(DATA_Ways);
    // console.log(DATA_Relations);

    const d = new Date();
    analysisstartms = d.getTime();

    IterateOverMembers( 'left', trip_id.toString(), draw_also=true );
    if ( relation_id !== '' ) {
        IterateOverMembers( 'right', relation_id.toString(), draw_also=true );
    } else {
        IterateOverMembers( 'right', trip_id2.toString(), draw_also=true );
    }

    console.log("CMP_List");
    console.log(CMP_List);

    var whats_right = 'GTFS';
    if ( relation_id !== '' ) {
        whats_right = 'OSM';
    }
    var left_len  = CMP_List['left'].length;
    var right_len = CMP_List['right'].length;

    if ( left_len > 0 && right_len > 0 ) {
        var score_table = CreateTripsCompareTableAndScores( CMP_List, left = 'GTFS', right = whats_right, scores_only = false );
    } else {
        if ( left_len === 0 && right_len === 0 ) {
            if ( right === 'OSM' ) {
                alert( "There are no GTFS-stops and no OSM-platforms" );
            } else {
                alert( "There are no GTFS-stops at all" );
            }
        } else if ( left_len === 0 ) {
            alert( "There are no GTFS-stops" );
        } else {
            alert( "There are no OSM-platforms" );
        }
    }

    finalizeAnalysisProgress();
}


async function showroutecomparison() {

    if ( !document.getElementById || !document.createElement || !document.appendChild ) return false;

    //  empty tiles
	var nomap  = L.tileLayer('');

    map  = L.map( 'hiddenmap',  { center : [defaultlat, defaultlon], zoom: defaultzoom, layers: [nomap] } );

    feed          = URLparse()["feed"]           || '';
    feed2         = URLparse()["feed2"]          || feed;
    release_date  = URLparse()["release_date"]   || '';
    release_date2 = URLparse()["release_date2"]  || '';
    route_id      = URLparse()["route_id"]       || '';
    route_id2     = URLparse()["route_id2"]      || '';
    relation_id   = URLparse()["relation"]       || '';

    dBarLeft   = document.getElementById('download_left');
    dBarRight  = document.getElementById('download_right');
    aBar       = document.getElementById('analysis');

    await download_left_data().then( (data)  => parseHttpResponse( 'left', data ) );
    await download_right_data().then( (data) => parseHttpResponse( 'right', data ) );

    console.log("DATA_Nodes");
    console.log(DATA_Nodes);
    console.log("DATA_Ways");
    console.log(DATA_Ways);
    console.log("DATA_Relations");
    console.log(DATA_Relations);

    const d = new Date();
    analysisstartms = d.getTime();

    var left_len     = 0;
    var right_len    = 0;
    var score_table  = [];
    var zero_data    = false;

    var CompareTable        = [];
    var CompareTableRowInfo = { 'type' : 'GTFS', 'name' : 'GTFS route', 'members' : 'GTFS trips', 'feed' : feed, 'release_date' : release_date, 'id' : route_id, 'rows' : GetRelationMembersOfRelation('left','GTFS',route_id,sort=true) };
    var CompareTableColInfo = {};
    var whats_right         = '';
     if ( relation_id !== '' ) {
        whats_right         = 'OSM';
        if ( DATA_Relations['right'][relation_id]         && DATA_Relations['right'][relation_id]['type']         === 'relation' &&
             DATA_Relations['right'][relation_id]['tags'] && DATA_Relations['right'][relation_id]['tags']['type']                   ) {
            if ( DATA_Relations['right'][relation_id]['tags']['type'] === 'route_master' ) {
                CompareTableColInfo = { 'type' : 'OSM', 'name' : 'OSM route_master', 'members' : 'OSM routes', 'id' : relation_id, 'cols' : GetRelationMembersOfRelation('right','OSM',relation_id,sort=false) };
            } else if ( DATA_Relations['right'][relation_id]['tags']['type'] === 'route' ) {
                CompareTableColInfo = { 'type' : 'OSM', 'name' : 'OSM route', 'members' : 'OSM route', 'id' : relation_id, cols : GetRelationMembersOfRelation('right','OSM',relation_id,sort=false) };
            } else {
                alert( "OSM relation "  + relation_id + " is not a 'route_master' or a 'route' relation'") ;
                return;
            }
        } else {
            alert( "OSM relation "  + relation_id + " does not exist (not downloaded) or has invalid tags") ;
            return;
        }
    } else {
        whats_right         = 'GTFS';
        CompareTableColInfo = { 'type' : 'GTFS', 'name' : 'GTFS trip', 'members' : 'GTFS trips', 'feed' : feed2, 'release_date' : release_date2, 'id' : route_id2, 'cols' : GetRelationMembersOfRelation('right','GTFS',route_id2,sort=true) };
    }

    var NumberOfRows = CompareTableRowInfo['rows'].length;
    var NumberOfCols = CompareTableColInfo['cols'].length;

    var alerts = [];
    for ( var row = 0; row < NumberOfRows; row++ ) {
        CompareTable.push( [] );
        for ( var col = 0; col < NumberOfCols; col++ ) {
            CMP_List = { 'left' : [], 'right' : [] };
            IterateOverMembers( 'left',  CompareTableRowInfo['rows'][row]['id'].toString(), draw_also = false );
            IterateOverMembers( 'right', CompareTableColInfo['cols'][col]['id'].toString(), draw_also = false );

            console.log( "CMP_List[row=" + (row+1) + "][col=" + (col+1) + "]" );
            console.log(CMP_List);

            left_len  = CMP_List['left'].length;
            right_len = CMP_List['right'].length;

            if ( left_len > 0 && right_len > 0 ) {
                score_table = CreateTripsCompareTableAndScores( CMP_List, left = 'GTFS', right = whats_right, scores_only = true );
                CompareTable[row].push( { 'score' : score_table['over_all_score'], 'color' : score_table['over_all_color'], 'mismatch_percent' : score_table['mismatch_percent'] } );
            } else {
                CompareTable[row].push( { 'score' : -1, 'color' : 'white' } );
                if ( left_len === 0 && right_len === 0 ) {
                    if ( whats_right === 'OSM' ) {
                        console.log( "There are no GTFS-stops and no OSM-platforms" );
                        alerts['There are no GTFS-stops and no OSM-platforms'] = 1;
                    } else {
                        console.log( "There are no GTFS-stops at all" );
                        alerts['There are no GTFS-stops at all'] = 1;
                    }
                } else if ( left_len === 0 ) {
                    console.log( "There are no GTFS-stops" );
                    alerts['There are no GTFS-stops'] = 1;
                } else {
                    console.log( "There are no OSM-platforms" );
                    alerts['There are no OSM-platforms'] = 1;
                }
                zero_data = true;
                console.log( "CMP_List[row=" + row + "][col=" + col + "]" );
                console.log( CMP_List );
            }

        }
        updateAnalysisProgress();
    }

    CreateRoutesCompareTable( CompareTableRowInfo, CompareTableColInfo, CompareTable );

    if ( zero_data ) {
        var keys = [];
        for (var key in alerts) {
            if (alerts.hasOwnProperty(key)) {
                keys.push(key);
            }
        }
        alert( "Some cells may not show valid data, there was missing data.\n\n'" + keys.join("'\n'") + "'" );
    }

    finalizeAnalysisProgress();

    sortTable.init();
}


//
// 'left' data is always GTFS data, for the time being only 'trip_id' data
//
async function download_left_data() {

    if ( feed ) {
        if ( feed.match(/^[0-9A-Za-z_.-]+$/) ) {

            if ( release_date === ''                        ||
                 release_date.match(/^\d\d\d\d-\d\d-\d\d$/) ||
                 release_date === 'previous'                ||
                 release_date === 'long-term'                  ) {
                if ( route_id !== '' || trip_id !== '' ) {
                    var url = '';
                    if ( route_id ) {
                        url     = PTNA_API_URL     +
                                  '?feed='         + encodeURIComponent(feed)         +
                                  '&release_date=' + encodeURIComponent(release_date) +
                                  '&route_id='     + encodeURIComponent(route_id)      +
                                  '&ptna';
                    } else {
                        url     = PTNA_API_URL     +
                                  '?feed='         + encodeURIComponent(feed)         +
                                  '&release_date=' + encodeURIComponent(release_date) +
                                  '&trip_id='      + encodeURIComponent(trip_id)      +
                                  '&ptna';
                    }
                    const d = new Date();
                    downloadstartms = d.getTime();

                    const response = await fetch(url);

                    if ( response.ok ) {
                        const JsonResp = await response.json();
                        const d = new Date();
                        var usedms = d.getTime() - downloadstartms;
                        dBarLeft.value = usedms;
                        document.getElementById('download_left_text').innerText = usedms.toString();
                        return JSON.stringify(JsonResp);
                    } else {
                        alert( "HTTP-Error: " + response.status );
                    }
                } else {
                    alert( "Neither parameter 'route_id' nor 'trip_id' is set" );
                }
            } else {
                alert( "Parameter 'release_date' is invalid (" + release_date + ")" );
            }
        } else {
            alert( "Parameter 'feed' is invalid (" + feed + ")" );
        }
    } else {
        alert( "Parameter 'feed' is not specified" );
    }

    return '';
}

//
// 'right' data can be OSM relation or a second GTFS data set
//
async function download_right_data() {

    if ( relation_id !== '' ) {
        if ( relation_id.match(/^\d+$/) ) {
            var url  = `${OVERPASS_API_URL_PREFIX}${relation_id}${OVERPASS_API_URL_SUFFIX}`;
            const d = new Date();
            downloadstartms = d.getTime();

            const response = await fetch(url);

            if ( response.ok ) {
                const JsonResp = await response.json();
                const d = new Date();
                var usedms = d.getTime() - downloadstartms;
                dBarRight.value = usedms;
                document.getElementById('download_right_text').innerText = usedms.toString();
                return JSON.stringify(JsonResp);
            } else {
                alert( "HTTP-Error: " + response.status );
            }
        } else {
            alert( "Relation ID is not a number (" + relation_id + ")" );
        }
    } else if ( feed2 !== '' ) {
        if ( feed2.match(/^[0-9A-Za-z_.-]+$/) ) {
            if ( release_date2 === ''                        ||
                 release_date2.match(/^\d\d\d\d-\d\d-\d\d$/) ||
                 release_date2 === 'previous'                ||
                 release_date2 === 'long-term'                  ) {
                if ( route_id2 !== '' || trip_id2 !== '' ) {
                    var url = '';
                    if ( route_id ) {
                        url = PTNA_API_URL     +
                              '?feed='         + encodeURIComponent(feed2)         +
                              '&release_date=' + encodeURIComponent(release_date2) +
                              '&route_id='     + encodeURIComponent(route_id2)     +
                              '&ptna';
                    } else {
                        url = PTNA_API_URL     +
                              '?feed='         + encodeURIComponent(feed2)         +
                              '&release_date=' + encodeURIComponent(release_date2) +
                              '&trip_id='      + encodeURIComponent(trip_id2)      +
                              '&ptna';
                    }
                    const d = new Date();
                    downloadstartms = d.getTime();

                    const response = await fetch(url);

                    if ( response.ok ) {
                        const JsonResp = await response.json();
                        const d = new Date();
                        var usedms = d.getTime() - downloadstartms;
                        dBarRight.value = usedms;
                        document.getElementById('download_right_text').innerText = usedms.toString();
                        return JSON.stringify(JsonResp);
                    } else {
                        alert( "HTTP-Error: " + response.status );
                    }
                } else {
                    alert( "Neither parameter 'route_id2' nor 'trip_id2' is set" );
                }
            } else {
                alert( "Parameter 'release_date2' is invalid (" + release_date2 + ")" );
            }
        } else {
            alert( "Parameter 'feed2' is invalid (" + feed2 + ")" );
        }
    } else {
        alert( "Neither parameter 'feed2' nor parameter 'relation' is set" );
    }

    return '';

}


function URLparse() {
    var params = {};
    var query  = location.search.substring( 1 );    // w/o the '?'
    var pairs  = query.split( "&" );
    var pos;
    var name;
    var value;

    for ( var i = 0; i < pairs.length; i++ ) {
        pos = pairs[i].indexOf('=');
        if ( pos == -1 ) continue;
        name  = pairs[i].substring(0,pos);
        value = pairs[i].substring(pos+1);
        value = decodeURIComponent(value);
        params[name] = value;
    }
    return params;
}


function fillNodesWaysRelations( lor ) {

    var DATA_ID   = 0;
    var DATA_TYPE = 0;

    for ( var i = 0; i < JSON_data[lor]["elements"].length; i++ ) {
        DATA_ID   = JSON_data[lor]["elements"][i]["id"];
        DATA_TYPE = JSON_data[lor]["elements"][i]["type"];

        if ( DATA_TYPE == "node" ) {
            DATA_Nodes[lor][DATA_ID]   = JSON_data[lor]["elements"][i];
        } else if ( DATA_TYPE == "way" ) {
            DATA_Ways[lor][DATA_ID]    = JSON_data[lor]["elements"][i];
        } else if ( DATA_TYPE == "relation" ) {
            DATA_Relations[lor][DATA_ID] = JSON_data[lor]["elements"][i];
        }
    }
}


function getRelationBounds() {
    return [ [minlat, minlon], [maxlat, maxlon] ];
}


function IterateOverMembers( lor, rel_id, draw_also ) {
    var object = DATA_Relations[lor][rel_id];

    number_of_match = { 'platform':1, 'stop':1, 'route':1, 'shape':1, 'other':1 };
    label_of_object = {};

    latlonroute[lor]['platform'] = [];
    latlonroute[lor]['stop']     = [];
    latlonroute[lor]['route']    = [];
    latlonroute[lor]['shape']    = [];
    latlonroute[lor]['other']    = [];

    if ( object && object['type'] === 'relation' && object['tags'] && (object['tags']['type'] === 'route' || object['tags']['type'] === 'trip') ) {

        handleMembers( lor, rel_id, draw_also );
    }
}


function handleMembers( lor, relation_id, draw_also ) {

    var object = DATA_Relations[lor][relation_id];
    var is_GTFS = object['tags']['type'] === 'trip';
    var is_PTv2 = object['tags']['public_transport:version'] && object['tags']['public_transport:version'] === 2;

    var listlength      = object['members'].length;

    for ( var index = 0; index < listlength; index++ ) {

        var member      = {};
        var attention   = {};
        var match       = "other";
        var role        = object['members'][index]["role"].replace(/ /g,'<blank>');
        var type        = object['members'][index]["type"];
        var id          = object['members'][index]["ref"];
        var name        = '';
        var lat         = 0;
        var lon         = 0;
        var ref_lat     = 0;
        var ref_lon     = 0;

        if ( type == "node" ) {
            member = DATA_Nodes[lor][id];
        } else if ( type == "way" ) {
            member = DATA_Ways[lor][id];
        } else if ( type == "relation" ) {
            member = DATA_Relations[lor][id];
        }

        if ( member ) {
            if ( !is_GTFS ) {
                if ( is_PTv2 ) {
                    if ( role == "platform"               ||
                            role == "platform_exit_only"  ||
                            role == "platform_entry_only" ||
                            (member['tags']                               &&
                            member['tags']['public_transport']            &&
                            member['tags']['public_transport'] == "platform")
                        ) {
                        match = "platform";
                        if ( !role.match(/platform/) ) {
                            attention['role'] = "attention";
                            attention['id']   = "attention";
                        }
                    } else {
                        if ( role == ""                             &&
                                member['tags']                         &&
                                member['tags']['highway']              &&
                                member['tags']['highway'] == "bus_stop"   ) {
                            attention['id'] = "attention";
                        } else {
                            if ( role != "stop"            &&
                                    role != "stop_exit_only"  &&
                                    role != "stop_entry_only"    ) {
                                attention['role'] = "attention";
                            }
                        }
                    }
                } else {
                    if ( role.match(/platform/) ) {
                        match = "platform";
                    }
                }
            }
            if ( match == "other" ) {
                if ( is_GTFS ) {
                    if ( role == "stop" ) {
                        match = "stop";
                    }
                }
            }

            if ( match == "other" ) {
                if ( type == "way" ) {
                    if ( is_GTFS ) {
                        match = "shape";
                    } else if ( is_PTv2 ) {
                        if ( role == "" || role== "hail_and_ride" ) {
                            match = "route";
                        } else {
                            role = role.replace(/ /, '<blank>');
                        }
                    } else {
                        if ( role == "" || role.match(/forward/) || role.match(/backward/) || role == "hail_and_ride" ) {
                            match = "route";
                        }
                    }
                }
            }

            if ( label_of_object[id] ) {
                label_of_object[id] = label_of_object[id] + "+" + number_of_match[match];
            } else {
                label_of_object[id] = number_of_match[match];
            }
            number_of_match[match]++;

            name = member['tags'] && member['tags']['name'] || member['tags'] && member['tags']['ref'] || member['tags'] && member['tags']['description'] || member['ptna'] && member['ptna']['stop_name'] || member['tags'] && member['tags']['stop_name'] || '';

            if ( is_GTFS ) {
                // GTFS is always type='node', so no need for ref_lat and ref_lon
                [lat,lon] = handleObject( lor, id, type, match, label_of_object[id], htmlEscape(name), 0, 0, draw_also );
            } else {
                // OSM is always lor='right'
                if ( CMP_List['right'].length < CMP_List['left'].length ) {
                    ref_lat = CMP_List['left'][CMP_List['right'].length]['lat'];
                    ref_lon = CMP_List['left'][CMP_List['right'].length]['lon'];
                } else {
                    ref_lat = CMP_List['left'][CMP_List['left'].length-1]['lat'];
                    ref_lon = CMP_List['left'][CMP_List['left'].length-1]['lon'];
                }
                [lat,lon] = handleObject( lor, id, type, match, label_of_object[id], htmlEscape(name), ref_lat, ref_lon, draw_also );
            }

            latlonroute[lor][match].push( [lat,lon] );

            if ( match === 'platform' || match === 'stop' ) {
                CMP_List[lor].push( { 'id':id, 'type':type, 'lat':lat, 'lon':lon, 'tags':member['tags'], 'ptna':member['ptna'] } );
            }

            if ( draw_also && (match === "shape" || match === 'route') && number_of_match[match] == 1 ) {
                map.fitBounds( getRelationBounds() );
            }

        }
    }

    // reached the end of the list

    if ( draw_also ) {
        if ( is_GTFS ) {    // GTFS has so called 'stops'
            if ( latlonroute[lor]['stop'].length > 1 ) {
                L.polyline(latlonroute[lor]['stop'],{color:colours[lor],weight:3,fill:false}).bindPopup("GTFS Stop Route").addTo( layerplatformroute[lor] );
            }
        } else {            // with OSM, we consider only 'platforms'
            if ( latlonroute[lor]['platform'].length > 1 ) {
                L.polyline(latlonroute[lor]['platform'],{color:colours[lor],weight:3,fill:false}).bindPopup("OSM Platform Route").addTo( layerplatformroute[lor] );
            }
        }

        map.fitBounds( getRelationBounds() );
    }

}


function PopupContent (id, type, match, label, name) {

    var is_GTFS = false;
    if ( match == "platform" )   { txt="OSM Platform"                 }
    else if ( match == "stop" )  { txt="GTFS Stop";   is_GTFS = true; }
    else if ( match == "route" ) { txt="OSM Way"                      }
    else if ( match == "shape" ) { txt="GTFS Shape";  is_GTFS = true; }
    else { txt="Other" }

    a = "<b>" + txt + " " + label.toString() + ': ' + name + "</b></br>";
    a += getObjectLinks( id, type, is_GTFS )

   return a;
}


function handleObject( lor, id, type, match, label_number, name, ref_lat, ref_lon, draw_also ) {

    if ( type == "node" ) {
        return handleNode( lor, id, match, label_number, name, true, true, draw_also );
    } else if ( type == "way" ) {
        return handleWay( lor, id, match, label_number, name, true, ref_lat, ref_lon, draw_also );
    } else if ( type == "relation" ) {
        return handleRelation( lor, id, match, label_number, name, true, ref_lat, ref_lon, draw_also )
    }
    return [0,0];
}


function handleNode( lor, id, match, label, name, set_marker, set_circle, draw_also ) {
    match = match || 'other';
    label = label || 0;
    name  = name  || '';

    var lat = DATA_Nodes[lor][id]['lat'];
    var lon = DATA_Nodes[lor][id]['lon'];
    if ( draw_also ) {
        if ( match == "platform" ) {
            if ( set_circle ) L.circle([lat,lon],{color:colours[lor],radius:0.75,fill:true}).addTo(layerplatform[lor]);
            if ( set_marker ) L.marker([lat,lon],{color:colours[lor],icon:icons[lor]}).bindTooltip(label.toString(),{permanent:true,direction:'center'}).bindPopup(PopupContent(id, "node", match, label, name)).addTo(layerplatform[lor]);
        } else if ( match == "stop"     ) {
            if ( set_circle ) L.circle([lat,lon],{color:colours[lor],radius:0.75,fill:true}).addTo(layerplatform[lor]);
            if ( set_marker ) L.marker([lat,lon],{color:colours[lor],icon:icons[lor]}).bindTooltip(label.toString(),{permanent:true,direction:'center'}).bindPopup(PopupContent(id, "node", match, label, name)).addTo(layerplatform[lor]);
        } else if ( match == "route" || match == "shape" ) {
            if ( set_circle ) L.circle([lat,lon],{color:colours[lor],radius:0.75,fill:true}).addTo(layershape[lor]);
            if ( set_marker ) L.marker([lat,lon],{color:colours[lor],icon:icons[lor]}).bindTooltip(label.toString(),{permanent:true,direction:'center'}).bindPopup(PopupContent(id, "node", match, label, name)).addTo(layershape[lor]);
        }
    }
    if ( lat < minlat ) minlat = lat;
    if ( lat > maxlat ) maxlat = lat;
    if ( lon < minlon ) minlon = lon;
    if ( lon > maxlon ) maxlon = lon;

    return [lat,lon];
}


function handleWay( lor, id, match, label, name, set_marker, ref_lat, ref_lon, draw_also ) {
    match = match || 'other';
    label = label || 0;
    name  = name  || '';

    var lat = 0;
    var lon = 0;
    var closest_lat = 0;
    var closest_lon = 0;

    var polyline_array = [];
    var node_id;

    var nodes = DATA_Ways[lor][id]["nodes"];

    for ( var j = 0; j < nodes.length; j++ ) {
        node_id = nodes[j];
        lat     = DATA_Nodes[lor][node_id]['lat'];
        lon     = DATA_Nodes[lor][node_id]['lon'];
        if ( lat < minlat ) minlat = lat;
        if ( lat > maxlat ) maxlat = lat;
        if ( lon < minlon ) minlon = lon;
        if ( lon > maxlon ) maxlon = lon;

        polyline_array.push( [ lat, lon ] );

    }
    closest_lat = DATA_Nodes[lor][nodes[0]]['lat'];
    closest_lon = DATA_Nodes[lor][nodes[0]]['lon'];

    if ( match == 'platform' ) {
        [ closest_lat, closest_lon ] = GetClosestLatLon( map, polyline_array, [ref_lat, ref_lon] );
        //console.log( polyline_array, [ref_lat, ref_lon] );

        if ( draw_also ) {
            if ( set_marker ) L.marker([closest_lat,closest_lon],{color:colours[lor],icon:icons[lor]}).bindTooltip(label.toString(),{permanent:true,direction:'center'}).bindPopup(PopupContent(id, "way", match, label, name)).addTo(layerplatform[lor]);

            L.polyline(polyline_array,{color:colours[lor],weight:4,fill:false}).bindPopup(PopupContent(id, "way", match, label, name)).addTo(layerplatform[lor]);
        }
    } else if ( match == 'stop' ) {
        if ( draw_also ) {
            if ( set_marker ) L.marker([closest_lat,closest_lon],{color:colours[lor],icon:icons[lor]}).bindTooltip(label.toString(),{permanent:true,direction:'center'}).bindPopup(PopupContent(id, "way", match, label, name)).addTo(layerplatform[lor]);

            L.polyline(polyline_array,{color:colours[lor],weight:4,fill:false}).bindPopup(PopupContent(id, "way", match, label, name)).addTo(layerplatform[lor]);
        }
    } else if ( match == "route" || match == "shape" ) {
        if ( draw_also ) {
            L.polyline(polyline_array,{color:colours[lor],weight:4,fill:false}).bindPopup(PopupContent(id, "way", match, label, name)).addTo(layershape[lor]);
        }
    }

    return [closest_lat, closest_lon];
}


function handleRelation( lor, id, match, label, name, set_marker, ref_lat, ref_lon, draw_also ) {
    match = match || 'other';
    label = label || 0;
    name  = name  || '';

    var list_of_lat_lon = [];

    var member_type;
    var member_role;
    var member_id;
    var have_set_marker = 0;

    var members = DATA_Relations[lor][id]["members"];

    var len = members.length;
    for ( var j = 0; j < len; j++ ) {
        member_type = members[j]['type'];
        member_role = members[j]['role'];
        member_id   = members[j]['ref'];

        if ( member_type == "node" ) {
            if ( !DATA_Nodes[lor][member_id] ) {
                downloadRelationSync( id, lor );
            }
            if ( DATA_Nodes[lor][member_id] ) {
                if ( have_set_marker ) {
                    list_of_lat_lon.push(handleNode( lor, member_id, match, label, name, false, false, draw_also ));
                } else {
                    list_of_lat_lon.push(handleNode( lor, member_id, match, label, name, true, true, draw_also ));
                    have_set_marker = 1;
                }
            } else {
                console.log( "Failed to download Relation " + id + " for Node: " + member_id );
            }
        } else if ( member_type == "way" ) {
            if ( !DATA_Ways[lor][member_id] ) {
                downloadRelationSync( id, lor );
            }
            if ( DATA_Ways[lor][member_id] ) {
                if ( have_set_marker ) {
                    list_of_lat_lon.push(handleWay( lor, member_id, match, label, name, false, ref_lat, ref_lon, draw_also ));
                } else {
                    list_of_lat_lon.push(handleWay( lor, member_id, match, label, name, true, ref_lat, ref_lon, draw_also ));
                    have_set_marker = 1;
                }
            } else {
                console.log( "Failed to download Relation " + id + " for  Way: " + member_id );
            }
        } else if ( member_type == "relation" ) {
            //
            // deep dive into member relations only for type=route relations
            //
            if ( DATA_Relations[lor][id]["tags"] && DATA_Relations[lor][id]["tags"]["type"] && DATA_Relations[lor][id]["tags"]["type"] == "route" ) {
                if ( !DATA_Relations[lor][member_id] ) {
                    downloadRelationSync( id, lor );
                }
                if ( DATA_Relations[lor][member_id] ) {
                    console.log( "No further recursive download of Relation " + id + " for  Relation: " + member_id );
                    document.getElementById("beta").style.display = "block";
                } else {
                    console.log( "Failed to download Relation " + id + " for  Relation: " + member_id );
                }
            } else {
                if ( DATA_Relations[lor][id]["tags"] && DATA_Relations[lor][id]["tags"]["type"] ) {
                    console.log( "No deep dive into relations of type = " + DATA_Relations[lor][id]["tags"]["type"]  );
                } else {
                    console.log( "No deep dive into relations other than type = route" );
                }
            }
        }

    }

    var result = [];
    var lat = 0;
    var lon = 0;
    var mindist = Infinity;
    var distance = 0;
    len = list_of_lat_lon.length
    for (var i = 0; i < len; i++ ) {
        lat = list_of_lat_lon[i][0];
        lon = list_of_lat_lon[i][1];
        distance = map.distance([ref_lat, ref_lon],[lat,lon]);
        if ( distance < mindist ) {
            mindist = distance;
            result  = [lat,lon];
        }
    }
    return result;
}


function getObjectLinks( id, type, is_GTFS ) {
    var html = '';

    if ( is_GTFS ) {
        if ( type == "node" ) {
            html  = "Stop-ID: " + id;
        } else if ( type == "way" ) {
            html  = "Shape-ID: " + id;
        } else if ( type == "relation" ) {
            html  = "Trip-ID: " + id;
        }
    } else {
        if ( type ) {
            if ( type == "node" ) {
                html  = "<img src=\"/img/Node.svg\" alt=\"Node\" /> ";
                html += "<a href=\"https://osm.org/node/" + id + "\" title=\"Browse on map\">" + id + "</a> <small>(";
                html += "<a href=\"https://osm.org/edit?editor=id&amp;node=" + id + "\" title=\"Edit in iD\">iD</a>, ";
                html += "<a href=\"http://127.0.0.1:8111/load_object?new_layer=false&amp;objects=n" + id + "\" target=\"hiddenIframe\" title=\"Edit in JOSM\">JOSM</a>",
                html += ")</small>"
            } else if ( type == "way" ) {
                html  = "<img src=\"/img/Way.svg\" alt=\"Way\" /> ";
                html += "<a href=\"https://osm.org/way/" + id + "\" title=\"Browse on map\">" + id + "</a> <small>(";
                html += "<a href=\"https://osm.org/edit?editor=id&amp;way=" + id + "\" title=\"Edit in iD\">iD</a>, ";
                html += "<a href=\"http://127.0.0.1:8111/load_object?new_layer=false&amp;objects=w" + id + "\" target=\"hiddenIframe\" title=\"Edit in JOSM\">JOSM</a>",
                html += ")</small>"
            } else if ( type == "relation" ) {
                html  = "<img src=\"/img/Relation.svg\" alt=\"Relation\" /> ";
                html += "<a href=\"https://osm.org/relation/" + id + "\" title=\"Browse on map\">" + id + "</a> <small>(";
                html += "<a href=\"https://osm.org/edit?editor=id&amp;relation=" + id + "\" title=\"Edit in iD\">iD</a>, ";
                html += "<a href=\"http://127.0.0.1:8111/load_object?new_layer=false&amp;relation_members=true&amp;objects=r" + id + "\" target=\"hiddenIframe\" title=\"Edit in JOSM\">JOSM</a>, ",
                html += "<a href=\"https://relatify.monicz.dev/?relation=" + id + "&load=1\" target=\"blank\" title=\"Edit in Relatify\">Relatify</a>",
                html += ")</small>"
            }
        }
    }

    return html;
}


function htmlEscape( str ) {
    return str
        .replace(/&/g, '&amp;')
        .replace(/"/g, '&quot;')
        .replace(/'/g, '&#39;')
        .replace(/</g, '&lt;')
        .replace(/>/g, '&gt;');
}


function downloadRelationSync( relation_id, lor ) {

    var url     = `${OVERPASS_API_URL_PREFIX}${relation_id}${OVERPASS_API_URL_SUFFIX}`;
    var request = new XMLHttpRequest();
    console.log( "downloadRelationSync(" + id + "," + lor + ") -> " + url );
    request.open( "GET", url, false );
    request.onreadystatechange = function() {
        if ( request.readyState === 4 ) {
            if ( request.status === 200 ) {
                var type = request.getResponseHeader( "Content-Type" );
                if ( type.match(/application\/json/) ) {
                    parseHttpResponse( lor, request.responseText );
                }
            } else if ( request.status === 410 ) {
                alert( "Relation does not exist (" + relation_id + ")" );
            } else {
                alert( "Response Code: " + request.status );
            }
        }
    };

    request.send();

}


function parseHttpResponse( lor, data ) {

    // console.log( 'Left-or-Right = ' + lor + ' >' + data.toString() + "<\n" );

    JSON_data[lor] = JSON.parse( data.toString() )

    // console.log( '>' + JSON_data["version"] + "<" );
    // console.log( '>' + JSON_data["generator"] + "<" );
    // console.log( '>' + JSON_data["copyright"] + "<" );
    // console.log( '>' + JSON_data["attribution"] + "<" );
    // console.log( '>' + JSON_data["license"] + "<" );

    if ( JSON_data[lor]["elements"].length === 0 ) {
        if ( lor === 'left' ) {
            if ( route_id ) {
                alert( "GTFS for data for 'route_id' = '" + route_id + "' not found");
            } else if ( trip_id ) {
                alert( "GTFS for data for 'trip_id' = '" + trip_id + "' not found");
            } else {
                alert( "Neither 'route_id' nor 'trip_id' are set for GTFS data");
            }
        } else {
            if ( relation_id !== '' ) {
                alert( "OSM 'relation' = '" + relation_id + "' not found");
            } else {
                if ( route_id2 ) {
                    alert( "GTFS for data for 'route_id2' = '" + route_id2 + "' not found");
                } else if ( trip_id2 ) {
                    alert( "GTFS for data for 'trip_id2' = '" + trip_id + "' not found");
                } else {
                    alert( "Neither 'route_id2' nor 'trip_id2' are set for GTFS data, 'relation' not set for OSM data as well");
                }
            }
        }
        throw new Error("ERROR");
    }
    fillNodesWaysRelations( lor );

}


function CreateRoutesCompareTable( CompareTableRowInfo, CompareTableColInfo, CompareTable ) {

    console.log( "CompareTableRowInfo" );
    console.log( CompareTableRowInfo );
    console.log( "CompareTableColInfo" );
    console.log( CompareTableColInfo );
    console.log( "CompareTable" );
    console.log( CompareTable );

    var row_count = CompareTable.length;
    if ( row_count > 0 ) {
        var col_count = CompareTable[0].length;
        if ( col_count > 0 ) {
            var span  = document.getElementById('compare-routes-columns-name');
            var div   = document.getElementById('routes-table-div');
            var thead = document.getElementById('routes-table-thead');
            var tbody = document.getElementById('routes-table-tbody');
            var tr;
            var td;
            var th;
            var id = '';
            var type = 'GTFS';
            var col_class = '';

            // magic calculation of visible height of table, before scrolling is enabled
            if ( col_count > 10 ) {
                div.style["height"] = ((row_count * 2) + 4) * 2 + "em";  // consider string being split into two lines
            } else {
                div.style["height"] = ((row_count * 2) + 4) + "em";
            }
            div.style["min-height"] = 32 + "em";

            span.innerHTML = htmlEscape(CompareTableColInfo['name']);

            tr = document.createElement('tr');
            th = document.createElement('th');
            th.innerHTML = "Scores&nbsp;(low&nbsp;scores)";
            th.className = 'compare-routes-left js-sort-none';
            th.setAttribute( 'colspan', 3 );
            tr.appendChild(th);
            th = document.createElement('th');
            th.innerHTML = htmlEscape(CompareTableColInfo['members']);
            th.className = 'compare-routes-left js-sort-none';
            th.setAttribute( 'colspan', col_count*2 );
            tr.appendChild(th);
            thead.appendChild(tr);
            tr = document.createElement('tr');
            th = document.createElement('th');
            th.innerHTML = "&#x21C5;Num";
            th.className = 'compare-routes-right js-sort-number';
            tr.appendChild(th);
            th = document.createElement('th');
            th.innerHTML = "&#x21C5;" + htmlEscape(CompareTableRowInfo['members']);
            th.className = 'compare-routes-left js-sort-string no-border-right';
            tr.appendChild(th);
            th = document.createElement('th');
            th.innerHTML = '&nbsp;';
            th.className = 'js-sort-none no-border-left';
            tr.appendChild(th);
            for ( var col = 0; col < col_count; col++ ) {
                col_class = col % 2 ? 'compare-routes-odd' : 'compare-routes-even';
                th = document.createElement('th');
                if ( CompareTableColInfo['cols'][col]['display_name'] ) {
                    th.innerHTML = '&#x21C5; <a href="' + GetRoutesColLink(CompareTableColInfo,col) + '"' +
                                   ' target="_blank"' +
                                   ' title="Show ' + CompareTableColInfo['type'] + ' information">' +
                                   CompareTableColInfo['cols'][col]['display_name'].toString() +
                                   '</a>';
                } else {
                    th.innerHTML = 'n/a';
                }
                th.className  = col_class + ' compare-routes-link js-sort-number no-border-right';
                tr.appendChild(th);
                th   = document.createElement('th');
                id   = CompareTableColInfo['cols'][col]['id'];
                type = CompareTableColInfo['type'];
                th.innerHTML = '<img onclick="ShowMore(this)" id="'+type+'-col-'+id+'" src="/img/Magnifier32.png" height="18" width="18" alt="Show more ..." title="Show more information for id '+id+'">';
                th.className = col_class + ' js-sort-none no-border-left';
                tr.appendChild(th);
            }
            thead.appendChild(tr);

            for ( var row = 0; row < row_count; row++ ) {
                tr = document.createElement('tr');
                td = document.createElement('td');
                td.innerHTML = CompareTableRowInfo['rows'][row]['member_number'].toString();
                td.className = 'compare-routes-odd compare-routes-right';
                tr.appendChild(td);
                td = document.createElement('td');
                if ( CompareTableRowInfo['rows'][row]['display_name'] ) {
                    td.innerHTML = '<a href="' + GetRoutesRowLink(CompareTableRowInfo,row) + '"' +
                                   ' target="_blank"' +
                                   ' title="Show ' + CompareTableRowInfo['type'] + ' information">' +
                                   CompareTableRowInfo['rows'][row]['display_name'].toString() +
                                   '</a>';
                } else {
                    td.innerHTML = 'n/a';
                }
                td.className = 'compare-routes-odd compare-routes-link compare-routes-right no-border-right';
                tr.appendChild(td);
                td = document.createElement('td');
                if ( CompareTableRowInfo['rows'][row]['info'].length > 0      ||
                     CompareTableRowInfo['rows'][row]['attention'].length > 0    ) {
                    td.innerHTML = '&nbsp;';
                } else {
                    td.innerHTML = '&nbsp;';
                }
                id   = CompareTableRowInfo['rows'][row]['id'];
                type = CompareTableRowInfo['type'];
                td.innerHTML = '<img onclick="ShowMore(this)" id="'+type+'-row-'+id+'" src="/img/Magnifier32.png" height="18" width="18" alt="Show more ..." title="Show more information for id '+id+'">';
                td.className = 'compare-routes-odd compare-routes-right no-border-left';
                tr.appendChild(td);
                for ( var col = 0; col < col_count; col++ ) {
                    td = document.createElement('td');
                    if ( CompareTable[row][col]['score'] >= 0 ) {
                        td.innerHTML = '<a href="' + GetRoutesScoreLink(CompareTableRowInfo,CompareTableColInfo,row,col ) + '"' +
                                       ' target="_blank"' +
                                       ' title="Show detailed score information">' +
                                       htmlEscape(CompareTable[row][col]['score'].toString()) + '%' +
                                       '</a>';
                    } else {
                        td.innerHTML = 'n/a';
                    }
                    td.style['background-color'] = CompareTable[row][col]['color'];
                    td.className = 'compare-routes-link no-border-right';
                    tr.appendChild(td);
                    td = document.createElement('td');
                    if ( CompareTable[row][col]['score'] >= 0 ) {
                        td.innerHTML = '&nbsp;';
                    } else {
                        td.innerHTML = '&nbsp;';
                    }
                    td.style['background-color'] = CompareTable[row][col]['color'];
                    td.className = 'no-border-left';
                    tr.appendChild(td);
                }
                tbody.appendChild(tr);
            }
        }
    }

    return;
}


function GetRelationMembersOfRelation( lor, type, relation_id, sort=false ) {

    var ret_list       = [];
    var info_list      = [];
    var attention_list = [];
    var member_id      = 0;
    var name           = relation_id.toString();
    var display_name   = relation_id.toString();
    var sort_name      = relation_id.toString();
    if ( DATA_Relations[lor][relation_id]                           &&
         DATA_Relations[lor][relation_id]['type']    === 'relation'    ) {}

        if ( type === 'OSM' && DATA_Relations[lor][relation_id]['tags'] && DATA_Relations[lor][relation_id]['tags']['type'] === 'route' ) {

            name         = DATA_Relations[lor][relation_id]['tags']['name'] ? htmlEscape(DATA_Relations[lor][relation_id]['tags']['name']) : relation_id.toString();
            display_name = GetDisplayName( lor, type, relation_id );
            ret_list.push( { 'id'            : relation_id,
                             'info'          : [],                      // empty
                             'attention'     : [],                      // empty
                             'name'          : name,                    // 'name' of OSM relation if set
                             'display_name'  : GetDisplayName( lor, type, member_id ), // 'name' of OSM relation if set
                             'sort_name'     : name,                    // 'name' of OSM relation if set
                             'member_number' : 1
                           } );
        } else if ( DATA_Relations[lor][relation_id]['members'] ) {

            var members_len = DATA_Relations[lor][relation_id]['members'].length;
            for ( var i = 0; i< members_len; i++ ) {
                if ( DATA_Relations[lor][relation_id]['members'][i]['type'] === 'relation' &&
                     DATA_Relations[lor][relation_id]['members'][i]['ref']                    ) {

                    member_id    = DATA_Relations[lor][relation_id]['members'][i]['ref'];
                    name         = DATA_Relations[lor][member_id]['tags']['name'] ? htmlEscape(DATA_Relations[lor][member_id]['tags']['name']) : htmlEscape(member_id.toString());
                    display_name = GetDisplayName( lor, type, member_id );
                    sort_name    = GetSortName( lor, type, member_id);
                    ret_list.push( { 'id'            : member_id,
                                     'info'          : [],           // comments from ptna_trips
                                     'attention'     : [],           // suspicious things from ptna_trips
                                     'name'          : name,         // 'name' of OSM relation if set
                                     'display_name'  : display_name, // 'name' to be used on the routes compare table ('stop-1 ... x stops ... stop-n')
                                     'sort_name'     : sort_name,    // 'name' to be used for sorting GTFS trips ('stop-1 stop-n stop-2 stop-3' ... 'stop-n')
                                     'member_number' : i+1           // will be renumbered during 'sort'
                                   } );
                }
            }
            if ( sort ) {
                ;
            }
    }

    return ret_list;
}


function GetDisplayName( lor, type, relation_id ) {
    var display_name = DATA_Relations[lor][relation_id]['tags']['name'] ? htmlEscape(DATA_Relations[lor][relation_id]['tags']['name']) : htmlEscape(relation_id.toString());
    if ( type === 'GTFS' ) {
        if ( DATA_Relations[lor][relation_id]['members']            &&
             DATA_Relations[lor][relation_id]['members'].length > 0    ) {
                var len = DATA_Relations[lor][relation_id]['members'].length;
                var first_stop_id = 0;
                for ( i = 0; i < len; i++ ) {
                    if ( DATA_Relations[lor][relation_id]['members'][i]['role'] === 'stop' ) {
                        first_stop_id = DATA_Relations[lor][relation_id]['members'][i]['ref'];
                        break;
                    }
                }
                var last_stop_id = 0;
                for ( i = len-1; i >= 0; i-- ) {
                    if ( DATA_Relations[lor][relation_id]['members'][i]['role'] === 'stop' ) {
                        last_stop_id = DATA_Relations[lor][relation_id]['members'][i]['ref'];
                        break;
                    }
                }
                var stop_name_first = (DATA_Nodes[lor][first_stop_id]['ptna'] && DATA_Nodes[lor][first_stop_id]['ptna']['stop_name']) ? DATA_Nodes[lor][first_stop_id]['ptna']['stop_name'] : DATA_Nodes[lor][first_stop_id]['tags']['stop_name'];
                var stop_name_last  = (DATA_Nodes[lor][last_stop_id]['ptna']  && DATA_Nodes[lor][last_stop_id]['ptna']['stop_name'])  ? DATA_Nodes[lor][last_stop_id]['ptna']['stop_name']  : DATA_Nodes[lor][last_stop_id]['tags']['stop_name'];
                display_name = htmlEscape(stop_name_first) + ' ...&nbsp;' + (len-2) + '&nbsp;stops&nbsp;... ' + htmlEscape(stop_name_last);
            }
    } else if ( type === 'OSM' ) {
        ;
    }
    return display_name.replace(/:\s*/,':<br/>').replace(/\s*==*&gt;\s*/g,'<br/>=&gt;<br/>');
}


function GetSortName( lor, type, relation_id ) {
    var sort_name = DATA_Relations[lor][relation_id]['tags']['name'] ? htmlEscape(DATA_Relations[lor][relation_id]['tags']['name']) : htmlEscape(relation_id.toString());
    return sort_name;
}


function GetRoutesScoreLink( CompareTableRowInfo, CompareTableColInfo, row, col ) {
    var ret_val = '';
    if ( row >= 0 && row < CompareTableRowInfo['rows'].length &&
         col >= 0 && col < CompareTableColInfo['cols'].length    ) {
        ret_val = '/gtfs/compare-trips.php' +
                  '?feed='         + encodeURIComponent(CompareTableRowInfo['feed']) +
                  '&release_date=' + encodeURIComponent(CompareTableRowInfo['release_date']) +
                  '&trip_id='      + encodeURIComponent(CompareTableRowInfo['rows'][row]['id']);
        if ( CompareTableColInfo['type'] === 'GTFS' ) {
            ret_val += '&feed2='         + encodeURIComponent(CompareTableColInfo['feed']) +
                       '&release_date2=' + encodeURIComponent(CompareTableColInfo['release_date']) +
                       '&trip_id2='      + encodeURIComponent(CompareTableColInfo['cols'][col]['id']);
        } else if ( CompareTableColInfo['type'] === 'OSM' ) {
            ret_val += '&relation='      + encodeURIComponent(CompareTableColInfo['cols'][col]['id']);
        } else {
            ret_val = '';
        }
    }
    return ret_val;
}


function GetRoutesRowLink( CompareTableRowInfo, row ) {
    var ret_val = '';
    if ( row >= 0 && row < CompareTableRowInfo['rows'].length ) {
        var country = CompareTableRowInfo['feed'].replace(/-.*/,'');
        ret_val = '/gtfs/' + country + '/single-trip.php' +
                  '?feed='         + encodeURIComponent(CompareTableRowInfo['feed']) +
                  '&release_date=' + encodeURIComponent(CompareTableRowInfo['release_date']) +
                  '&trip_id='      + encodeURIComponent(CompareTableRowInfo['rows'][row]['id']);
    }
    return ret_val;
}


function GetRoutesColLink( CompareTableColInfo, col ) {
    var ret_val = '';
    var country = '';
    if ( col >= 0 && col < CompareTableColInfo['cols'].length ) {
        if ( CompareTableColInfo['type'] === 'GTFS' ) {
            var country = CompareTableColInfo['feed'].replace(/-.*/,'');
            ret_val = '/gtfs/' + country + '/single-trip.php' +
                      '?feed='         + encodeURIComponent(CompareTableColInfo['feed']) +
                      '&release_date=' + encodeURIComponent(CompareTableColInfo['release_date']) +
                      '&trip_id='      + encodeURIComponent(CompareTableColInfo['cols'][col]['id']);
        } else if ( CompareTableColInfo['type'] === 'OSM' ) {
            ret_val = 'https://osm.org/relation/' + encodeURIComponent(CompareTableColInfo['cols'][col]['id']);
        } else {
            ret_val = '';
        }
    }
    return ret_val;
}


function ShowMore( imgObj ) {
    var id   = imgObj.id.toString();
    var type = '';
    var lor  = '';
    if ( id.match(/^GTFS-/) ) {
        type = 'GTFS';
        id   = id.replace(/^GTFS-/,'');
    } else if ( id.match(/^OSM-/) ) {
        type = 'OSM';
        id   = id.replace(/^OSM-/,'');
    }
    if ( id.match(/^row-/) ) {
        lor = 'left';
        id  = id.replace(/^row-/,'');
    } else if ( id.match(/^col-/) ) {
        lor = 'right';
        id  = id.replace(/^col-/,'');
    }
    alert( "More information for '" + type + "' - '" + lor + "' " + id );
}


function ShowScores( imgObj ) {
    var id   = imgObj.id.toString();
    alert( "More score information for '" + id + "'" );
}


function CreateTripsCompareTableAndScores( cmp_list, left, right, scores_only ) {

    var body_row_template = {};
    var fields            = [];

    // left &#x2BC7;
    // right &#x2BC8;
    // up &#x2BC5;
    // down &#x2BC6;
    if ( right === 'OSM' ) {
        fields            = ['stop_number','stop_id','stop_lat','stop_lon','stop_name','info','arrow_left','distance','arrow_right','name','ref_name','lat','lon','gtfs:stop_id','ref:IFOPT','platform_number','Edit<br/>with'];
    } else {
        fields            = ['stop_number','stop_id','stop_lat','stop_lon','stop_name','info','arrow_left','distance','arrow_right','info2','stop_name2','stop_lat2','stop_lon2','stop_id2','stop_number2'];
    }
    body_row_template = { 'stop_number' : '',         'stop_id'    : '', 'stop_lat'    : '',         'stop_lon'  : '', 'stop_name'    : '', 'info' : '',
                          'arrow_left'  : '&#x2BC7;', 'distance'   : '', 'arrow_right' : '&#x2BC8;',
                          'name': '',                 'ref_name'   : '', 'lat'         : '',         'lon'       : '', 'gtfs:stop_id' : '', 'ref:IFOPT'     : '', 'platform_number' : '',
                          'info2'       : '',         'stop_name2' : '', 'stop_id2'    : '',         'stop_lat2' : '', 'stop_lon2'    : '', 'stop_number2' : '', 'Edit<br/>with' : ''
                        };
    body_row_style    = { 'stop_name' : ['text-align:right'], 'name' : ['text-align:left'], 'ref_name' : ['text-align:left'], 'stop_name2' : ['text-align:left'], 'Edit<br/>with' : ['text-align:left'] };

    var body_rows   = [];
    var row_styles  = [];
    var body_row    = {};
    var row_style   = {};
    var left_len    = cmp_list['left'].length;
    var right_len   = cmp_list['right'].length;
    var left_name_parts          = '';
    var right_name_parts         = '';
    var max_len                  = Math.max(left_len,right_len);
    var scores                   = { 'distances' : [ 20, 100, 1000 ],
                                     'mismatch_percent_to_color' : { // colour if actual value is greater or equal number
                                        48 : '#fe4000',
                                        24 : '#f17a00',
                                        12 : '#d7a700',
                                        2  : '#aecd00',
                                        0  : '#6aef00'
                                     },
                                     'weights'   : {
                                        'stops'        : 10,
                                        'distance'     : [1,4,12],
                                        'name'         : 2,  // GTFS 'stop_name' versus GTFS 'stop_name' or OSM 'name'
                                        'ref_name'     : 1,  // GTFS 'stop_name' versus OSM 'ref_name'
                                        'stop_id2'     : 2,  // GTFS 'stop_id' versus GTFS 'stop_id'
                                        'gtfs:stop_id' : 2,  // GTFS 'stop_id' versus OSM 'gtfs:stop_id'
                                        'ref:IFOPT'    : 2   // GTFS 'stop_id' versus OSM 'ref:IFOPT'
                                     },
                                     'totals'    : {
                                        'stops'        : max_len,
                                        'distance'     : [max_len,max_len,max_len],
                                        'name'         : 0,  // right side: OSM 'name'
                                        'ref_name'     : 0,  // right side: OSM 'ref_name'
                                        'stop_id2'     : 0,  // right side: GTFS 'stop_id'
                                        'gtfs:stop_id' : 0,  // right side: OSM 'gtfs:stop_id'
                                        'ref:IFOPT'    : 0   // right side: OSM 'ref:IFOPT'
                                     },
                                     'mismatch_count': {
                                        'stops'        : Math.abs(left_len-right_len),
                                        'distance'     : [0,0,0],
                                        'name'         : 0,  // GTFS 'stop_name' versus GTFS 'stop_name' or OSM 'name'
                                        'ref_name'     : 0,  // GTFS 'stop_name' versus OSM 'ref_name'
                                        'stop_id2'     : 0,  // GTFS 'stop_id' versus GTFS 'stop_id'
                                        'gtfs:stop_id' : 0,  // GTFS 'stop_id' versus OSM 'gtfs:stop_id'
                                        'ref:IFOPT'    : 0   // GTFS 'stop_id' versus OSM 'ref:IFOPT'
                                     },
                                     'mismatch_percent': {
                                        'stops'        : 0,
                                        'distance'     : [0,0,0],
                                        'name'         : 0,  // GTFS 'stop_name' versus GTFS 'stop_name' or OSM 'name'
                                        'ref_name'     : 0,  // GTFS 'stop_name' versus OSM 'ref_name'
                                        'stop_id2'     : 0,  // GTFS 'stop_id' versus GTFS 'stop_id'
                                        'gtfs:stop_id' : 0,  // GTFS 'stop_id' versus OSM 'gtfs:stop_id'
                                        'ref:IFOPT'    : 0   // GTFS 'stop_id' versus OSM 'ref:IFOPT'
                                     },
                                     'mismatch_color': {
                                        'stops'        : '',
                                        'distance'     : ['','',''],
                                        'name'         : '',
                                        'ref_name'     : '',
                                        'stop_id2'     : '',
                                        'gtfs:stop_id' : '',
                                        'ref:IFOPT'    : ''
                                     },
                                     'over_all_color'  : '',
                                     'over_all_score'  : ''
                                   };



    if ( left_len > 0 && right_len > 0 ) {

        for ( var i = 0; i < max_len; i++ ) {
            body_row = {...body_row_template};
            row_style = JSON.parse(JSON.stringify(body_row_style));
            if ( i < left_len ) {
                if ( cmp_list['left'][i]['tags'] ) {
                    body_row['stop_number'] = i+1;
                    body_row['stop_id']     = cmp_list['left'][i]['tags']['stop_id'] || '';
                    body_row['stop_lat']    = parseFloat(cmp_list['left'][i]['lat'].toString().replace(',','.')).toFixed(5)  || '';
                    body_row['stop_lon']    = parseFloat(cmp_list['left'][i]['lon'].toString().replace(',','.')).toFixed(5)  || '';
                    if ( cmp_list['left'][i]['ptna'] && cmp_list['left'][i]['ptna']['stop_name'] ) {
                        body_row['stop_name'] = cmp_list['left'][i]['ptna']['stop_name'];
                        if ( cmp_list['left'][i]['tags']['stop_name'] &&
                             cmp_list['left'][i]['tags']['stop_name'].toString() !== body_row['stop_name'].toString() ){
                             body_row['info'] = '<img src="/img/Information32.png" height="18" width="18" alt="Information" title="GTFS: stop_name=\'' + htmlEscape(cmp_list['left'][i]['tags']['stop_name']) + '\'"/>';
                        }
                    } else {
                        body_row['stop_name'] = cmp_list['left'][i]['tags']['stop_name'] || '';
                    }
                }
            }
            if ( i < right_len ) {
                if ( cmp_list['right'][i]['tags'] ) {
                    if ( right === 'OSM' ) {
                        body_row['platform_number'] = i+1;
                        body_row['name']         = cmp_list['right'][i]['tags']['name']         || '';
                        body_row['ref_name']     = cmp_list['right'][i]['tags']['ref_name']     || '';
                        body_row['lat']          = parseFloat(cmp_list['right'][i]['lat'].toString().replace(',','.')).toFixed(5)       || '';
                        body_row['lon']          = parseFloat(cmp_list['right'][i]['lon'].toString().replace(',','.')).toFixed(5)       || '';
                        body_row['gtfs:stop_id'] = cmp_list['right'][i]['tags']['gtfs:stop_id'] || '';
                        body_row['ref:IFOPT']    = cmp_list['right'][i]['tags']['ref:IFOPT']    || '';
                        for ( var field in scores['totals'] ) {
                            if ( field in body_row && body_row[field] !== '' ) {
                                scores['totals'][field]++;
                            }
                        }
                        if ( cmp_list['right'][i]['type'] === 'node' ) {
                            body_row['Edit<br/>with'] = '<img src="/img/Node.svg" alt="Node"> <small>' +
                                                        '<a href="https://osm.org/node/' + cmp_list['right'][i]['id'] + '" title="Link to OSM" target="_blank">' + cmp_list['right'][i]['id'] + '</a> (' +
                                                        '<a href="https://osm.org/edit?editor=id&amp;node=' + cmp_list['right'][i]['id'] + '" title="Edit in iD">iD</a>, ' +
                                                        '<a href="http://127.0.0.1:8111/load_object?new_layer=false&amp;objects=n' + cmp_list['right'][i]['id'] + '" target="hiddenIframe" title="Edit in JOSM">JOSM</a>)</small>';
                        } else if ( cmp_list['right'][i]['type'] === 'way' ) {
                            body_row['Edit<br/>with'] = '<img src="/img/Way.svg" alt="Ways"> <small>' +
                                                        '<a href="https://osm.org/way/' + cmp_list['right'][i]['id'] + '" title="Link to OSM" target="_blank">' + cmp_list['right'][i]['id'] + '</a> (' +
                                                        '<a href="https://osm.org/edit?editor=id&amp;relation=' + cmp_list['right'][i]['id'] + '" title="Edit in iD">iD</a>, ' +
                                                        '<a href="http://127.0.0.1:8111/load_object?new_layer=false&amp;objects=w' + cmp_list['right'][i]['id'] + '" target="hiddenIframe" title="Edit in JOSM">JOSM</a>)</small>';
                        } else if ( cmp_list['right'][i]['type'] === 'relation' ) {
                            body_row['Edit<br/>with'] = '<img src="/img/Relation.svg" alt="Relation"> <small>' +
                                                        '<a href="https://osm.org/relation/' + cmp_list['right'][i]['id'] + '" title="Link to OSM" target="_blank">' + cmp_list['right'][i]['id'] + '</a> (' +
                                                        '<a href="https://osm.org/edit?editor=id&amp;relation=' + cmp_list['right'][i]['id'] + '" title="Edit in iD">iD</a>, ' +
                                                        '<a href="http://127.0.0.1:8111/load_object?new_layer=false&amp;relation_members=true&amp;objects=r' + cmp_list['right'][i]['id'] + '" target="hiddenIframe" title="Edit in JOSM">JOSM</a>)</small>';
                        }
                    } else {
                        body_row['stop_number2'] = i+1;
                        body_row['stop_id2']     = cmp_list['right'][i]['tags']['stop_id'] || '';
                        body_row['stop_lat2']    = parseFloat(cmp_list['right'][i]['lat'].toString().replace(',','.')).toFixed(5)  || '';
                        body_row['stop_lon2']    = parseFloat(cmp_list['right'][i]['lon'].toString().replace(',','.')).toFixed(5)  || '';
                        body_row['stop_name2']   = (cmp_list['right'][i]['ptna'] && cmp_list['right'][i]['ptna']['stop_name']) || cmp_list['right'][i]['tags']['stop_name'] || '';
                        if ( cmp_list['right'][i]['ptna'] && cmp_list['right'][i]['ptna']['stop_name'] ) {
                            body_row['stop_name2'] = cmp_list['right'][i]['ptna']['stop_name'];
                            if ( cmp_list['right'][i]['tags']['stop_name'] &&
                                 cmp_list['right'][i]['tags']['stop_name'].toString() !== body_row['stop_name2'].toString() ){
                                 body_row['info2'] = '<img src="/img/Information32.png" height="18" width="18" alt="Information" title="GTFS: stop_name=\'' + htmlEscape(cmp_list['right'][i]['tags']['stop_name']) + '\'"/>';
                            }
                        } else {
                            body_row['stop_name2'] = cmp_list['right'][i]['tags']['stop_name'] || '';
                        }
                        for ( var field in scores['totals'] ) {
                            if ( field in body_row && body_row[field] !== '' ) {
                                scores['totals'][field]++;
                            }
                        }
                        if ( body_row['stop_name2'] !== '' ) {
                            scores['totals']['name']++;
                        }
                    }
                }
            }
            if ( i < left_len && i < right_len ) {
                body_row['distance'] = map.distance( [cmp_list['left'][i]['lat'],cmp_list['left'][i]['lon']], [cmp_list['right'][i]['lat'],cmp_list['right'][i]['lon']]).toFixed(0);
            } else if ( i < left_len ) {
                body_row['distance'] = map.distance( [cmp_list['left'][i]['lat'],cmp_list['left'][i]['lon']], [cmp_list['right'][right_len-1]['lat'],cmp_list['right'][right_len-1]['lon']]).toFixed(0);
            } else if ( i < right_len) {
                body_row['distance'] = map.distance( [cmp_list['left'][left_len-1]['lat'],cmp_list['left'][left_len-1]['lon']], [cmp_list['right'][i]['lat'],cmp_list['right'][i]['lon']]).toFixed(0);
            }

            if ( body_row['stop_id'] !== '' && (body_row['stop_id2'] || body_row['gtfs:stop_id'] || body_row['ref:IFOPT']) ) {
                if ( body_row['stop_id2'] !== '' ) {
                    if ( body_row['stop_id'].toString() !== body_row['stop_id2'].toString() ) {
                        row_style['stop_id']  = ['background-color:orange'];
                        row_style['stop_id2'] = ['background-color:orange'];
                        scores['mismatch_count']['stop_id2']++;
                    }
                } else {
                    if ( body_row['gtfs:stop_id'] !== '' ) {
                        if ( body_row['stop_id'].toString() !== body_row['gtfs:stop_id'].toString() ) {
                            row_style['stop_id']      = ['background-color:orange'];
                            row_style['gtfs:stop_id'] = ['background-color:orange'];
                            scores['mismatch_count']['gtfs:stop_id']++;
                        }
                    }
                    if ( body_row['ref:IFOPT'] !== '' && body_row['stop_id'].toString().match(/:/g) && body_row['stop_id'].toString().match(/:/g).length >= 2 ) {
                        // ref:IFOPT ~ 'a:b:c:d:e', so stop_id should have at least 2 ':'
                        if ( body_row['stop_id'].toString() !== body_row['ref:IFOPT'].toString() ) {
                            row_style['stop_id']   = ['background-color:orange'];
                            row_style['ref:IFOPT'] = ['background-color:orange'];
                            scores['mismatch_count']['ref:IFOPT']++;
                        }
                    }
                }
            }
            if ( body_row['stop_name'] !== '' && (body_row['stop_name2'] || body_row['name'] || body_row['ref_name']) ) {
                if ( body_row['stop_name2'] && body_row['stop_name2'] ) {
                    if ( body_row['stop_name'].toString() !== body_row['stop_name2'].toString() ) {
                        row_style['stop_name'].push('background-color:orange');
                        row_style['stop_name2'].push('background-color:orange');
                        scores['mismatch_count']['name']++;
                    }
                } else {
                    if ( body_row['name'] !== '' &&  body_row['name'] !== '&nbsp;' ) {
                        if ( body_row['stop_name'].toString().indexOf(body_row['name'].toString()) == -1 &&
                             body_row['name'].toString().indexOf(body_row['stop_name'].toString()) == -1 &&
                             body_row['stop_name'].toString() !== body_row['name'].toString()               ) {
                            if ( body_row['stop_name'].toString().match(',') &&
                                 body_row['name'].toString().match(',')         ) {
                                left_name_parts  = body_row['stop_name'].replace(/,\s+/g,',').split(',');
                                right_name_parts = body_row['name'].replace(/,\s+/g,',').split(',');
                                if ( left_name_parts.length  == 2 && left_name_parts[0]  && left_name_parts[1]  &&
                                     right_name_parts.length == 2 && right_name_parts[0] && right_name_parts[1]    ) {
                                    if ( left_name_parts[0].indexOf(right_name_parts[1]) == -1 ||
                                         left_name_parts[1].indexOf(right_name_parts[0]) == -1    ) {
                                            row_style['stop_name'].push('background-color:orange');
                                            row_style['name'].push('background-color:orange');
                                            scores['mismatch_count']['name']++;
                                        }
                                } else {
                                    row_style['stop_name'].push('background-color:orange');
                                    row_style['name'].push('background-color:orange');
                                    scores['mismatch_count']['name']++;
                                }
                            } else {
                                row_style['stop_name'].push('background-color:orange');
                                row_style['name'].push('background-color:orange');
                                scores['mismatch_count']['name']++;
                            }
                        }
                    }
                    if ( body_row['ref_name'] !== '' ) {
                        if ( body_row['stop_name'].toString().indexOf(body_row['ref_name'].toString()) == -1 &&
                             body_row['ref_name'].toString().indexOf(body_row['stop_name'].toString()) == -1 &&
                             body_row['stop_name'].toString() !== body_row['ref_name'].toString()               ) {
                            if ( body_row['stop_name'].toString().match(',') &&
                                 body_row['ref_name'].toString().match(',')     ) {
                                left_name_parts  = body_row['stop_name'].replace(/,\s+/g,',').split(',');
                                right_name_parts = body_row['ref_name'].replace(/,\s+/g,',').split(',');
                                if ( left_name_parts.length  == 2 &&
                                     right_name_parts.length == 2    ) {
                                    if ( left_name_parts[0].indexOf(right_name_parts[1]) == -1 ||
                                         left_name_parts[1].indexOf(right_name_parts[0]) == -1    ) {
                                        row_style['ref_name'].push('background-color:orange');
                                        scores['mismatch_count']['ref_name']++;
                                    }
                                } else {
                                    row_style['ref_name'].push('background-color:orange');
                                    scores['mismatch_count']['ref_name']++;
                                }
                            } else {
                                row_style['ref_name'].push('background-color:orange');
                                scores['mismatch_count']['ref_name']++;
                            }
                        }
                    }
                }
            }
            if ( Number(body_row['distance']) > scores['distances'][0] ) {
                var style_it = 'background-color:yellow';
                var index    = 0;
                if ( Number(body_row['distance']) > scores['distances'][1] ) {
                    style_it = 'background-color:orange';
                    index    = 1;
                }
                if ( Number(body_row['distance']) > scores['distances'][2] ) {
                    style_it = 'background-color:red';
                    index    = 2;
                }
                row_style['distance']  = [style_it];
                scores['mismatch_count']['distance'][index]++;
                if ( body_row['stop_lat'] !== '' && body_row['stop_lon'] !== '' &&
                     body_row['lat']      !== '' && body_row['lon']      !== ''    ) {
                    row_style['stop_lat']  = [style_it];
                    row_style['stop_lon']  = [style_it];
                    row_style['lat']       = [style_it];
                    row_style['lon']       = [style_it];
                }
                if ( body_row['stop_lat']  !== '' && body_row['stop_lon']  !== '' &&
                     body_row['stop_lat2'] !== '' && body_row['stop_lon2'] !== ''    ) {
                    row_style['stop_lat']  = [style_it];
                    row_style['stop_lon']  = [style_it];
                    row_style['stop_lat2'] = [style_it];
                    row_style['stop_lon2'] = [style_it];
                }
            }
            body_rows.push( {...body_row} );
            row_styles.push( {...row_style} );
        }

        console.log("body_rows");
        console.log( body_rows );
        // console.log( row_styles );

        CalculateScores( scores );

        console.log("scores");
        console.log( scores );

        if ( !scores_only ) {
            FillTripsTable( fields, body_rows, row_styles, scores );
            FillTripsScoresTable( scores );
        }

        return scores;
    }

    return array();
}


function CalculateScores( scores ) {
    var weighted_scores     = 0;
    var accumulated_weights = 0;
    for ( var field in scores['totals'] ) {
        if ( Array.isArray(scores['totals'][field]) ) {
            for ( var i = 0; i < scores['totals'][field].length; i++ ) {
                if ( scores['totals'][field][i] > 0 ) {
                    scores['mismatch_percent'][field][i] = (scores['mismatch_count'][field][i] / scores['totals'][field][i] * 100).toFixed(0);
                    scores['mismatch_color'][field][i]   = GetScoreColor( scores, scores['mismatch_percent'][field][i] );
                    weighted_scores     += (scores['mismatch_percent'][field][i] * scores['weights'][field][i]);
                    accumulated_weights += scores['weights'][field][i];
                }
            }
        } else {
            if ( scores['totals'][field] > 0 ) {
                scores['mismatch_percent'][field] = (scores['mismatch_count'][field] / scores['totals'][field] * 100).toFixed(0);
                scores['mismatch_color'][field]   = GetScoreColor( scores, scores['mismatch_percent'][field] );
                weighted_scores     += (scores['mismatch_percent'][field] * scores['weights'][field]);
                accumulated_weights += scores['weights'][field];
            }
        }
    }
    if ( accumulated_weights > 0 ) {
        scores['over_all_score'] = (weighted_scores / accumulated_weights).toFixed(2);
        scores['over_all_color'] = GetScoreColor( scores, scores['over_all_score'] );
    }
}


function GetScoreColor( scores, value ) {
    var limits = Object.keys(scores['mismatch_percent_to_color']).sort(compareNumbersReverse);
    for ( var i = 0; i < limits.length; i++ ) {
        if ( parseFloat(value) >= parseFloat(limits[i]) ) {
            return scores['mismatch_percent_to_color'][limits[i]];
        }
    }
    return '';
}


function GetClosestLatLon( map, latlonAA, latlonA ) {
    var mindist  = Infinity;
    var distance = 0;
    if ( latlonAA.length > 0 ) {
        for (i = 0, l = latlonAA.length; i < l; i++) {
            var latlon = latlonAA[i];
            distance = map.distance(latlonA, latlon);
            if ( distance < mindist ) {
                mindist = distance;
                result  = latlon;
            }
            if ( i > 0 ) {
                var P1 = latlonAA[i-1];
                var P2 = latlonAA[i];
                distance = L.LineUtil.pointToSegmentDistance(L.point(latlonA),L.point(P1),L.point(P2));
                if ( distance < mindist ) {
                    mindist = distance;
                    var P = L.LineUtil.closestPointOnSegment(L.point(latlonA),L.point(P1),L.point(P2));
                    result = [ P.x, P.y ];
                }
            }
        }
        return result;
    }
    return latlonA;
}


function GetNodesOfObject( object_id, object_type ) {
    if ( object_type === 'node') {
        return [ object_id ];
    } else if ( object_type === 'way') {

    } else if ( object_type === 'relation' ) {
    }

    return [];
}


function compareNumbers(a, b) {
    return a - b;
}


function compareNumbersReverse(a, b) {
    return b -a;
}


function FillTripsTable( fields, body_rows, row_styles, scores ) {
    var div   = document.getElementById('trips-table-div');
    var thead = document.getElementById('trips-table-thead');
    var tbody = document.getElementById('trips-table-tbody');
    var tr;
    var td;

    // magic calculation of visible height of table, before scrolling is enabled
    div.style["height"] = ((body_rows.length * 2) + 3) + "em";
    div.style["min-height"] = 24 + "em";

    tr           = document.createElement('tr');
    th           = document.createElement('th');
    th.innerHTML = 'Stop<br/>Number';
    th.setAttribute( 'class', "compare-trips-left" );
    th.setAttribute( 'rowspan', 2 );
    tr.appendChild(th);
    th           = document.createElement('th');
    th.innerHTML = 'Stop data of GTFS trip (' + htmlEscape(trip_id.toString()) + ')';
    th.setAttribute( 'class', "compare-trips-left" );
    th.setAttribute( 'colspan', 5 );
    tr.appendChild(th);
    th           = document.createElement('th');
    th.innerHTML = 'Distance<br/>[m]';
    th.setAttribute( 'rowspan', 2 );
    th.setAttribute( 'colspan', 3 );
    tr.appendChild(th);

    if ( relation_id !== '' ) {
        var colspan = 2;
        if ( scores['totals']['name']         > 0 ) { colspan++; }
        if ( scores['totals']['ref_name']     > 0 ) { colspan++; }
        if ( scores['totals']['gtfs:stop_id'] > 0 ) { colspan++; }
        if ( scores['totals']['ref:IFOPT']    > 0 ) { colspan++; }
        th           = document.createElement('th');
        th.innerHTML =  'Platform data of OSM route ' +
                        '<img src="/img/Relation.svg" alt="Relation"> <small>' +
                        '<a href="https://osm.org/relation/' + encodeURIComponent(relation_id) + '" title="Link to OSM" target="_blank">' + htmlEscape(relation_id) + '</a> (' +
                        '<a href="https://osm.org/edit?editor=id&amp;relation=' + encodeURIComponent(relation_id) + '" title="Edit in iD">iD</a>, ' +
                        '<a href="http://127.0.0.1:8111/load_object?new_layer=false&amp;relation_members=true&amp;objects=r' + encodeURIComponent(relation_id) + '" target="hiddenIframe" title="Edit in JOSM">JOSM</a>, ' +
                        '<a href="https://relatify.monicz.dev/?relation=' + encodeURIComponent(relation_id) + '&amp;load=1" target="_blank" title="Edit in Relatify">Relatify</a>)</small>';
        th.setAttribute( 'class', "compare-trips-right" );
        th.setAttribute( 'colspan', colspan );
        tr.appendChild(th);
        th            = document.createElement('th');
        th.innerHTML  = 'Platform<br/>Number';
        th.setAttribute( 'class', "compare-trips-right" );
        th.setAttribute( 'rowspan', 2 );
        tr.appendChild(th);
        th            = document.createElement('th');
        th.innerHTML  = 'Edit<br/>with';
        th.setAttribute( 'class', "compare-trips-right" );
        th.setAttribute( 'rowspan', 2 );
        tr.appendChild(th);
    } else {
        th           = document.createElement('th');
        th.innerHTML = 'Stop data of GTFS trip (' + htmlEscape(trip_id2) + ')';
        th.setAttribute( 'class', "compare-trips-right" );
        th.setAttribute( 'colspan', 5 );
        tr.appendChild(th);
        th            = document.createElement('th');
        th.innerHTML  = 'Stop<br/>Number';
        th.setAttribute( 'class', "compare-trips-right" );
        th.setAttribute( 'rowspan', 2 );
        tr.appendChild(th);
    }
    thead.appendChild(tr);

    tr           = document.createElement('tr');
    th           = document.createElement('th');
    th.innerHTML = 'stop_id';
    th.setAttribute( 'class', "compare-trips-left" );
    tr.appendChild(th);
    th           = document.createElement('th');
    th.innerHTML = 'stop_lat';
    th.setAttribute( 'class', "compare-trips-left" );
    tr.appendChild(th);
    th           = document.createElement('th');
    th.innerHTML = 'stop_lon';
    th.setAttribute( 'class', "compare-trips-left" );
    tr.appendChild(th);
    th           = document.createElement('th');
    th.innerHTML = 'stop_name';
    th.setAttribute( 'class', "compare-trips-left" );
    th.setAttribute( 'colspan', 2 );
    tr.appendChild(th);

    if ( relation_id !== '' ) {
        if ( scores['totals']['name'] > 0 ) {
            th           = document.createElement('th');
            th.innerHTML = 'name';
            th.setAttribute( 'class', "compare-trips-right" );
            tr.appendChild(th);
        }
        if ( scores['totals']['ref_name'] > 0 ) {
            th            = document.createElement('th');
            th.innerHTML  = 'ref_name';
            th.setAttribute( 'class', "compare-trips-right" );
            tr.appendChild(th);
        }
        th           = document.createElement('th');
        th.innerHTML = 'lat';
        th.setAttribute( 'class', "compare-trips-right" );
        tr.appendChild(th);
        th           = document.createElement('th');
        th.innerHTML = 'lon';
        th.setAttribute( 'class', "compare-trips-right" );
        tr.appendChild(th);
        if ( scores['totals']['gtfs:stop_id']     > 0 ) {
            th            = document.createElement('th');
            th.innerHTML  = 'gtfs:stop_id';
            th.setAttribute( 'class', "compare-trips-right" );
            tr.appendChild(th);
        }
        if ( scores['totals']['ref:IFOPT']     > 0 ) {
            th            = document.createElement('th');
            th.innerHTML  = 'ref:IFOPT';
            th.setAttribute( 'class', "compare-trips-right" );
            tr.appendChild(th);
        }
    } else {
        th           = document.createElement('th');
        th.innerHTML = 'stop_name';
        th.setAttribute( 'class', "compare-trips-right" );
        th.setAttribute( 'colspan', 2 );
        tr.appendChild(th);
        th           = document.createElement('th');
        th.innerHTML = 'stop_lat';
        th.setAttribute( 'class', "compare-trips-right" );
        tr.appendChild(th);
        th           = document.createElement('th');
        th.innerHTML = 'stop_lon';
        th.setAttribute( 'class', "compare-trips-right" );
        tr.appendChild(th);
        th           = document.createElement('th');
        th.innerHTML = 'stop_id';
        th.setAttribute( 'class', "compare-trips-right" );
        tr.appendChild(th);
    }
    tr.appendChild(th);
    thead.appendChild(tr);

    // fill the tbody
    for ( var i = 0; i < body_rows.length; i++ ) {
        tr = document.createElement('tr');
        for ( var field of fields ) {
            if ( !(field in scores['totals']) || scores['totals'][field] ) {
                td = document.createElement('td');
                if ( field === 'info'          || field === 'info2'       ||
                     field === 'arrow_left'    || field === 'arrow_right' ||
                     field === 'Edit<br/>with'                               ) {
                    td.innerHTML = (body_rows[i][field] === '') ? '&nbsp;' : body_rows[i][field];
                } else {
                    td.innerHTML = (body_rows[i][field] === '') ? '&nbsp;' : htmlEscape(body_rows[i][field].toString());
                }
                if ( row_styles[i][field] && row_styles[i][field].length > 0 ) {
                    td.style.cssText += row_styles[i][field].join(';');
                }
                tr.appendChild(td);
            }
        }
        tbody.appendChild(tr);
    }
}

function FillTripsScoresTable( scores ) {
    const score_fields_to_ids = { 'stops'        : 'score-stops',
                                  'distance'     : ['score-distance0','score-distance1','score-distance2'],
                                  'name'         : 'score-name',
                                  'ref_name'     : 'score-ref-name',
                                  'stop_id2'     : 'score-stop-id',
                                  'gtfs:stop_id' : 'score-gtfs-stop-id',
                                  'ref:IFOPT'    : 'score-ref-ifopt'
                                };
    var elem;
    var elem_weight;
    var elem_text;
    var elem_color;

    for ( var field in score_fields_to_ids ) {
        if ( Array.isArray(score_fields_to_ids[field]) ) {
            for ( var i = 0; i < score_fields_to_ids[field].length; i++ ) {
                elem        = document.getElementById(score_fields_to_ids[field][i]);
                elem_weight = document.getElementById(score_fields_to_ids[field][i]+'-weight');
                elem_text   = document.getElementById(score_fields_to_ids[field][i]+'-text');
                elem_color  = document.getElementById(score_fields_to_ids[field][i]);
                elem_weight.innerHTML = scores['weights'][field][i];
                elem.innerHTML = scores['mismatch_percent'][field][i] + '%';
                if ( field === 'distance' ) {
                    elem_text.innerHTML = elem_text.innerHTML.replace('xx',scores['distances'][i]);
                }
                if ( scores['mismatch_color'][field][i] !== '' ) {
                    elem_color.style = 'background-color: ' + scores['mismatch_color'][field][i];
                }
            }
        } else {
            elem        = document.getElementById(score_fields_to_ids[field]);
            elem_weight = document.getElementById(score_fields_to_ids[field]+'-weight');
            elem_text   = document.getElementById(score_fields_to_ids[field]+'-text');
            elem_color  = document.getElementById(score_fields_to_ids[field]);
            elem_weight.innerHTML = scores['weights'][field];
            if ( scores['totals'][field] > 0 ) {
                elem.innerHTML = scores['mismatch_percent'][field] + '%';
                if ( scores['mismatch_color'][field] !== '' ) {
                    elem_color.style = 'background-color: ' + scores['mismatch_color'][field];
                }
            } else {
                elem.innerHTML = 'n/a';
            }
        }
    }
    elem           = document.getElementById('score-total');
    elem.style     = 'background-color: ' + scores['over_all_color'];
    elem.innerHTML = scores['over_all_score'] + '%';
}


function updateAnalysisProgress( increment ) {
    const d = new Date();
    var usedms = d.getTime() - analysisstartms;
    document.getElementById('analysis_text').innerText = usedms.toString();
    if ( increment ) {
        aBar.value += increment;
    } else {
        aBar.value = usedms;
    }
}


function finalizeAnalysisProgress() {
    const d = new Date();
    var usedms = d.getTime() - analysisstartms;
    aBar.value = usedms;
    document.getElementById('analysis_text').innerText = usedms.toString();
}
