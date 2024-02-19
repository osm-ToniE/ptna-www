//
//
//

const OVERPASS_API_URL_PREFIX = 'https://overpass-api.de/api/interpreter?data=[out:json];relation(';
const OVERPASS_API_URL_SUFFIX = ');(._;>>;);out;';

const PTNA_API_URL = '/api/gtfs.php';

const defaultlat    = 48.0649;
const defaultlon    = 11.6612;
const defaultzoom   = 10;

const members_per_timeout = 10000;

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
var trip_id;
var feed2;
var release_date2;
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
var label_of_object     = {}
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

    IterateOverMembers( 'left', trip_id.toString() );
    if ( relation_id !== '' ) {
        IterateOverMembers( 'right', relation_id.toString() );
    } else {
        IterateOverMembers( 'right', trip_id2.toString() );
    }

    // console.log(CMP_List);

    if ( relation_id !== '' ) {
        CreateTripsCompareTable( CMP_List, left = 'GTFS', right = 'OSM' );
    } else {
        CreateTripsCompareTable( CMP_List, left = 'GTFS', right = 'GTFS' );
    }

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
                if ( trip_id !== '' ) {
                    var url     = PTNA_API_URL     +
                                  '?feed='         + encodeURIComponent(feed)         +
                                  '&release_date=' + encodeURIComponent(release_date) +
                                  '&trip_id='      + encodeURIComponent(trip_id)      +
                                  '&full';
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
                    alert( "Parameter 'trip_id' is not set" );
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
                if ( trip_id2 !== '' ) {
                    var url = PTNA_API_URL     +
                        '?feed='         + encodeURIComponent(feed2)         +
                        '&release_date=' + encodeURIComponent(release_date2) +
                        '&trip_id='      + encodeURIComponent(trip_id2)      +
                        '&full';
                    const d = new Date();
                    downloadstartms = d.getTime();

                    const response = await fetch(url);

                    if ( response.ok ) {
                        const JsonResp = await response.json();
                        const d = new Date();
                        var usedms = d.getTime() - downloadstartms;
                        dBarLeft.value = usedms;
                        document.getElementById('download_right_text').innerText = usedms.toString();
                        return JSON.stringify(JsonResp);
                    } else {
                        alert( "HTTP-Error: " + response.status );
                    }
                } else {
                    alert( "Parameter 'trip_id2' is not set" );
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


function IterateOverMembers( lor, rel_id ) {
    var object = DATA_Relations[lor][rel_id];

    number_of_match         = { platform:1, stop:1, route:1, shape:1, other:1 };
    latlonroute[lor]['platform'] = [];
    latlonroute[lor]['stop']     = [];
    latlonroute[lor]['route']    = [];
    latlonroute[lor]['shape']    = [];
    latlonroute[lor]['other']    = [];

    if ( object && object['type'] === 'relation' && object['tags'] && (object['tags']['type'] === 'route' || object['tags']['type'] === 'trip') ) {

        const d = new Date();
        analysisstartms = d.getTime();

        handleMembers( lor, rel_id );

    }
}


function handleMembers( lor, relation_id ) {

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

            label_of_object[id] = number_of_match[match].toString();
            number_of_match[match]++;

            name = member['tags'] && member['tags']['name'] || member['tags'] && member['tags']['ref'] || member['tags'] && member['tags']['description'] || member['ptna'] && member['ptna']['stop_name'] || member['tags'] && member['tags']['stop_name'] || '';

            [lat,lon] = drawObject( lor, id, type, match, label_of_object[id], htmlEscape(name) )

            latlonroute[lor][match].push( [lat,lon] );

            if ( match === 'platform' || match === 'stop' ) {
                CMP_List[lor].push( { 'id':id, 'type':type, 'lat':lat, 'lon':lon, 'tags':member['tags'], 'ptna':member['ptna'] } );
            }

            if ( (match === "shape" || match === 'route') && number_of_match[match] == 1 ) {
                map.fitBounds( getRelationBounds() );
            }

        }
    }

    // reached the end of the list

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

    finalizeAnalysisProgress();

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


function drawObject( lor, id, type, match, label_number, name ) {

    if ( type == "node" ) {
        return drawNode( lor, id, match, label_number, name, true, true );
    } else if ( type == "way" ) {
        return drawWay( lor, id, match, label_number, name, true );
    } else if ( type == "relation" ) {
        return drawRelation( lor, id, match, label_number, name, true )
    }
    return [0,0];
}


function drawNode( lor, id, match, label, name, set_marker, set_circle ) {
    match = match || 'other';
    label = label || 0;
    name  = name  || '';

    var lat = DATA_Nodes[lor][id]['lat'];
    var lon = DATA_Nodes[lor][id]['lon'];
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
    if ( lat < minlat ) minlat = lat;
    if ( lat > maxlat ) maxlat = lat;
    if ( lon < minlon ) minlon = lon;
    if ( lon > maxlon ) maxlon = lon;

    return [lat,lon];
}


function drawWay( lor, id, match, label, name, set_marker ) {
    match = match || 'other';
    label = label || 0;
    name  = name  || '';

    var lat = 0;
    var lon = 0;

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

    if ( match == 'platform' ) {
        mlat = DATA_Nodes[lor][nodes[0]]['lat'];
        mlon = DATA_Nodes[lor][nodes[0]]['lon'];
        if ( set_marker ) L.marker([mlat,mlon],{color:colours[lor],icon:icons[lor]}).bindTooltip(label.toString(),{permanent:true,direction:'center'}).bindPopup(PopupContent(id, "way", match, label, name)).addTo(layerplatform[lor]);

        L.polyline(polyline_array,{color:colours[lor],weight:4,fill:false}).bindPopup(PopupContent(id, "way", match, label, name)).addTo(layerplatform[lor]);
    } else if ( match == 'stop' ) {
        mlat = DATA_Nodes[lor][nodes[0]]['lat'];
        mlon = DATA_Nodes[lor][nodes[0]]['lon'];
        if ( set_marker ) L.marker([mlat,mlon],{color:colours[lor],icon:icons[lor]}).bindTooltip(label.toString(),{permanent:true,direction:'center'}).bindPopup(PopupContent(id, "way", match, label, name)).addTo(layerplatform[lor]);

        L.polyline(polyline_array,{color:colours[lor],weight:4,fill:false}).bindPopup(PopupContent(id, "way", match, label, name)).addTo(layerplatform[lor]);
    } else if ( match == "route" || match == "shape" ) {
        L.polyline(polyline_array,{color:colours[lor],weight:4,fill:false}).bindPopup(PopupContent(id, "way", match, label, name)).addTo(layershape[lor]);
    }

    return [DATA_Nodes[lor][nodes[0]]['lat'],DATA_Nodes[lor][nodes[0]]['lon']];
}


function drawRelation( lor, id, match, label, name, set_marker ) {
    match = match || 'other';
    label = label || 0;
    name  = name  || '';

    var lat = 0;
    var lon = 0;

    var member_type;
    var member_role;
    var member_id;
    var have_set_marker = 0;

    var members = DATA_Relations[lor][id]["members"];

    for ( var j = 0; j < members.length; j++ ) {
        member_type = members[j]['type'];
        member_role = members[j]['role'];
        member_id   = members[j]['ref'];

        if ( member_type == "node" ) {
            if ( !DATA_Nodes[lor][member_id] ) {
                downloadRelationSync( id );
            }
            if ( DATA_Nodes[lor][member_id] ) {
                if ( have_set_marker ) {
                    drawNode( lor, member_id, match, label, name, false, false );
                } else {
                    [lat,lon] = drawNode( lor, member_id, match, label, name, true, true );
                    have_set_marker = 1;
                }
            } else {
                console.log( "Failed to download Relation " + id + " for Node: " + member_id );
            }
        } else if ( member_type == "way" ) {
            if ( !DATA_Ways[lor][member_id] ) {
                downloadRelationSync( id );
            }
            if ( DATA_Ways[member_id] ) {
                if ( have_set_marker ) {
                    drawWay( lor, member_id, match, label, name, false );
                } else {
                    [lat,lon] = drawWay( lor, member_id, match, label, name, true );
                    have_set_marker = 1;
                }
            } else {
                console.log( "Failed to download Relation " + id + " for  Way: " + member_id );
            }
        } else if ( member_type == "relation" ) {
            //
            // deep dive into member relations only for type=route relations
            //
            if ( DATA_Relations[lor][id]["tags"] && DATA_Relations[id]["tags"]["type"] && DATA_Relations[id]["tags"]["type"] == "route" ) {
                if ( !DATA_Relations[lor][member_id] ) {
                    downloadRelationSync( id );
                }
                if ( DATA_Relations[lor][member_id] ) {
                    console.log( "No further recursive download of Relation " + id + " for  Relation: " + member_id );
                    document.getElementById("beta").style.display = "block";
                } else {
                    console.log( "Failed to download Relation " + id + " for  Relation: " + member_id );
                }
            } else {
                if ( DATA_Relations[lor][id]["tags"] && DATA_Relations[id]["tags"]["type"] ) {
                    console.log( "No deep dive into relations of type = " + DATA_Relations[lor][id]["tags"]["type"]  );
                } else {
                    console.log( "No deep dive into relations other than type = route" );
                }
            }
        }

    }

    return [ lat, lon ];
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


function downloadRelationSync( relation_id  ) {

    var url     = `${OVERPASS_API_URL_PREFIX}${relation_id}${OVERPASS_API_URL_SUFFIX}`;
    var request = new XMLHttpRequest();
    request.open( "GET", url, false );
    request.onreadystatechange = function() {
        if ( request.readyState === 4 ) {
            if ( request.status === 200 ) {
                var type = request.getResponseHeader( "Content-Type" );
                if ( type.match(/application\/json/) ) {
                    parseHttpResponse( request.responseText );
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
            alert( "GTFS for data for trip_id =  " + trip_id + " not found");
        } else {
            if ( relation_id !== '' ) {
                alert( "OSM relation = " + relation_id + " not found");
            } else {
                alert( "GTFS for data for trip_id2 =  " + trip_id2 + " not found");
            }
        }
        throw new Error("ERROR");
    }
    fillNodesWaysRelations( lor );

}


function CreateTripsCompareTable( cmp_list, left, right ) {

    var body_row_template = {};
    var fields            = [];

    const div   = document.getElementById('trips-table-div');
    const table = document.getElementById('trips-table');
    const thead = document.getElementById('trips-table-thead');
    const tbody = document.getElementById('trips-table-tbody');
    const tfoot = document.getElementById('trips-table-tfoot');
    var   tr;
    var   th;
    var   td;

    // left &#x2BC7;
    // right &#x2BC8;
    // up &#x2BC5;
    // down &#x2BC6;
    if ( right === 'OSM' ) {
        fields            = ['stop_number','stop_id','stop_lat','stop_lon','stop_name','arrow_left','distance','arrow_right','name','ref_name','lat','lon','gtfs:stop_id','ref:IFOPT','platform_number'];
    } else {
        fields            = ['stop_number','stop_id','stop_lat','stop_lon','stop_name','arrow_left','distance','arrow_right','stop_name2','stop_lat2','stop_lon2','stop_id2','stop_number2'];
    }
    body_row_template = { 'stop_number' : '',         'stop_id' : '',  'stop_lat' : '',            'stop_lon' : '',  'stop_name' : '',
                          'arrow_left'  : '&#x2BC7;', 'distance' : '', 'arrow_right' : '&#x2BC8;',
                          'name': '',                 'ref_name': '',  'lat' : '',                 'lon' : '',       'gtfs:stop_id' : '', 'ref:IFOPT' : '', 'platform_number' : '',
                          'stop_name2'  : '',         'stop_id2': '',  'stop_lat2' : '',           'stop_lon2' : '', 'stop_number2' : ''
                        };
    body_row_style    = { 'stop_name' : ['text-align:right'], 'name' : ['text-align:left'], 'ref_name' : ['text-align:left'], 'stop_name2' : ['text-align:left'] };

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
        // magic calculation of visible height of table, before scrolling is enabled
        div.style["height"] = (max_len * 2) + "em";

        for ( var i = 0; i < max_len; i++ ) {
            body_row = {...body_row_template};
            row_style = JSON.parse(JSON.stringify(body_row_style));
            if ( i < left_len ) {
                if ( cmp_list['left'][i]['tags'] ) {
                    body_row['stop_number'] = i+1;
                    body_row['stop_id']     = cmp_list['left'][i]['tags']['stop_id'] || '';
                    body_row['stop_lat']    = parseFloat(cmp_list['left'][i]['lat'].toString().replace(',','.')).toFixed(5)  || '';
                    body_row['stop_lon']    = parseFloat(cmp_list['left'][i]['lon'].toString().replace(',','.')).toFixed(5)  || '';
                    body_row['stop_name']   = (cmp_list['left'][i]['ptna'] && cmp_list['left'][i]['ptna']['stop_name']) || cmp_list['left'][i]['tags']['stop_name']  || '';
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
                    } else {
                        body_row['stop_number2'] = i+1;
                        body_row['stop_id2']     = cmp_list['right'][i]['tags']['stop_id'] || '';
                        body_row['stop_lat2']    = parseFloat(cmp_list['right'][i]['lat'].toString().replace(',','.')).toFixed(5)  || '';
                        body_row['stop_lon2']    = parseFloat(cmp_list['right'][i]['lon'].toString().replace(',','.')).toFixed(5)  || '';
                        body_row['stop_name2']   = (cmp_list['right'][i]['ptna'] && cmp_list['right'][i]['ptna']['stop_name']) || cmp_list['right'][i]['tags']['stop_name'] || '';
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
                    if ( body_row['ref:IFOPT'] !== '' && body_row['stop_id'].toString().match(/:/g).length >= 2 ) {
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
                    if ( body_row['name'] !== '' ) {
                        if ( !body_row['stop_name'].toString().match(body_row['name'].toString()) &&
                             !body_row['name'].toString().match(body_row['stop_name'].toString())    ) {
                            if ( body_row['stop_name'].toString().match(',') &&
                                body_row['name'].toString().match(',')         ) {
                                left_name_parts  = body_row['stop_name'].replace(/,\s+/g,',').split(',');
                                right_name_parts = body_row['name'].replace(/,\s+/g,',').split(',');
                                if ( left_name_parts.length  == 2 && left_name_parts[0]  && left_name_parts[1]  &&
                                    right_name_parts.length == 2 && right_name_parts[0] && right_name_parts[1]    ) {
                                    if ( !left_name_parts[0].match(right_name_parts[1]) ||
                                        !left_name_parts[1].match(right_name_parts[0])    ) {
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
                        if ( !body_row['stop_name'].toString().match(body_row['ref_name'].toString()) ) {
                            if ( body_row['stop_name'].toString().match(',') &&
                                body_row['ref_name'].toString().match(',')     ) {
                                left_name_parts  = body_row['stop_name'].replace(/,\s+/g,',').split(',');
                                right_name_parts = body_row['ref_name'].replace(/,\s+/g,',').split(',');
                                if ( left_name_parts.length  == 2 &&
                                    right_name_parts.length == 2    ) {
                                    if ( !left_name_parts[0].match(right_name_parts[1]) ||
                                        !left_name_parts[1].match(right_name_parts[0])    ) {
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

        // console.log( body_rows );
        // console.log( row_styles );

        CalculateScores( scores );

        console.log( scores );

        FillTripsTable( fields, body_rows, row_styles, scores );

        FillTripsScoresTable( scores );
    }
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


function compareNumbers(a, b) {
    return a - b;
}


function compareNumbersReverse(a, b) {
    return b -a;
}


function FillTripsTable( fields, body_rows, row_styles, scores ) {
    var thead = document.getElementById('trips-table-thead');
    var tbody = document.getElementById('trips-table-tbody');
    var tr;
    var td;

    tr           = document.createElement('tr');
    th           = document.createElement('th');
    th.innerHTML = 'Stop<br/>Number';
    th.setAttribute( 'class', "compare-trips-left" );
    th.setAttribute( 'rowspan', 2 );
    tr.appendChild(th);
    th           = document.createElement('th');
    th.innerHTML = 'Stop data of GTFS trip (' + trip_id + ')';
    th.setAttribute( 'class', "compare-trips-left" );
    th.setAttribute( 'colspan', 4 );
    tr.appendChild(th);
    th           = document.createElement('th');
    th.innerHTML = 'Distance<br/>[m]';
    th.setAttribute( 'rowspan', 2 );
    th.setAttribute( 'colspan', 3 );
    tr.appendChild(th);

    if ( relation_id !== '' ) {
        var colspan = 3;
        if ( scores['totals']['ref_name']     > 0 ) { colspan++; }
        if ( scores['totals']['gtfs:stop_id'] > 0 ) { colspan++; }
        if ( scores['totals']['ref:IFOPT']    > 0 ) { colspan++; }
        th           = document.createElement('th');
        th.innerHTML = 'Platform data of OSM route (r' + relation_id + ')';
        th.setAttribute( 'class', "compare-trips-right" );
        th.setAttribute( 'colspan', colspan );
        tr.appendChild(th);
        th            = document.createElement('th');
        th.innerHTML  = 'Platform<br/>Number';
        th.setAttribute( 'class', "compare-trips-right" );
        th.setAttribute( 'rowspan', 2 );
        tr.appendChild(th);
    } else {
        th           = document.createElement('th');
        th.innerHTML = 'Stop data of GTFS trip (' + trip_id2 + ')';
        th.setAttribute( 'class', "compare-trips-right" );
        th.setAttribute( 'colspan', 4 );
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
    tr.appendChild(th);

    if ( relation_id !== '' ) {
        th           = document.createElement('th');
        th.innerHTML = 'name';
        th.setAttribute( 'class', "compare-trips-right" );
        tr.appendChild(th);
        if ( scores['totals']['ref_name']     > 0 ) {
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
                td.innerHTML = (body_rows[i][field] === '') ? '&nbsp;' : body_rows[i][field];
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
                elem.innerHTML = scores['mismatch_percent'][field][i];
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
                elem.innerHTML = scores['mismatch_percent'][field];
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
    elem.innerHTML = scores['over_all_score'];
}


function updateAnalysisProgress( increment ) {
    const d = new Date();
    var usedms = d.getTime() - analysisstartms;
    aBar.value = usedms;
    document.getElementById('analysis_text').innerText = usedms.toString();
}


function finalizeAnalysisProgress() {
    const d = new Date();
    var usedms = d.getTime() - analysisstartms;
    aBar.value = usedms;
    document.getElementById('analysis_text').innerText = usedms.toString();
}
