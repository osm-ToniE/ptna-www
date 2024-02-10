//
//
//

const OVERPASS_API_URL_PREFIX = 'https://overpass-api.de/api/interpreter?data=[out:json];relation(';
const OVERPASS_API_URL_SUFFIX = ');(._;>>;);out;';

const PTNA_API_URL = '/api/get-gtfs-data.php';

const defaultlat    = 48.0649;
const defaultlon    = 11.6612;
const defaultzoom   = 10;

const members_per_timeout = 10000;

const osmlicence    = 'Map data &copy; <a href="https://openstreetmap.org" target="_blank">OpenStreetMap</a> contributors, <a href="https://www.openstreetmap.org/copyright" target="_blank">ODbL</a> &mdash; ';
const attribution   = '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors';

var map;
var layerrightways;
var layerrightstops;
var layerrightstopsroute;
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
var leftHTTPresponseText = '';
var rightHTTPresponseText = '';
var is_PTv2         = 0;
var osm_data        = [];
var osm_data_index  = 0;
var OSM_Nodes       = {};
var OSM_Ways        = {};
var OSM_Relations   = {};
var maxlat          =  -90;
var minlat          =   90;
var maxlon          = -180;
var minlon          =  180;

var CMP_DATA        = {};

var dBarLeft;
var dBarRight;
var aBar;

var number_of_match     = {};
var label_of_object     = {}
var latlonroute         = {};


function showtripcomparison() {

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
    layerrightshape          = L.layerGroup();
    layerrightstops          = L.layerGroup();
    layerrightstopsroute     = L.layerGroup();
    layerleftshape           = L.layerGroup();
    layerleftstops           = L.layerGroup();
    layerleftstopsroute      = L.layerGroup();

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
    feed2         = URLparse()["feed2"]         || '';
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
    icons      = { osm: right_icon, platform: right_icon, route: right_icon, gtfs: left_icon, stop: left_icon, shape: left_icon };
    colours    = { osm: '#6495ed',  platform: '#6495ed',  route: '#6495ed',  gtfs: '#fc0fc0', stop: '#fc0fc0', shape: '#fc0fc0' };

    // start downloading "left" data first by analyzing URI parameters 'feed', 'release_date' and 'route_id/'trip_id'
    // once done, it will start downloading "right" data afterwards: either using URI 'relation' or 'feed2', 'release_date2' and 'route_id2'/'trip_id2'
    // there is no parallel processing
    download_left_data();

}


//
// 'left' data is always GTFS data, for the time being only 'trip_id' data
//
function download_left_data() {

    if ( feed ) {
        if ( feed.match(/^[0-9A-Za-z_.-]+$/) ) {

            if ( release_date === '' || release_date.match(/^\d\d\d\d-\d\d-\d\d$/) ) {
                if ( trip_id !== '' ) {
                    var url     = PTNA_API_URL     +
                                  '?feed='         + encodeURIComponent(feed)         +
                                  '&release_date=' + encodeURIComponent(release_date) +
                                  '&trip_id='      + encodeURIComponent(trip_id)      +
                                  '&full';
                } else {
                    alert( "Parameter 'trip_id' is not set" );
                    return false;
                }
                var request = new XMLHttpRequest();
                request.open( "GET", url );
                request.onprogress = function() {
                    const d = new Date();
                    var usedms = d.getTime() - downloadstartms;
                    dBarLeft.value = usedms;
                    document.getElementById('download_left_text').innerText = usedms.toString();
                }
                request.onreadystatechange = function() {
                    const d = new Date();
                    var usedms = d.getTime() - downloadstartms;
                    dBarLeft.value = usedms;
                    document.getElementById('download_left_text').innerText = usedms.toString();
                    if ( request.readyState === 4 ) {
                        if ( request.status === 200 ) {
                            var type = request.getResponseHeader( "Content-Type" );
                            if ( type.match(/application\/json/) ) {
                                leftHTTPresponseText = request.responseText;
                                download_right_data();
                            } else {
                                alert( url + " did not return JSON data but " + type );
                            }
                        } else if ( request.status === 410 ) {
                            alert( "Relation does not exist (" + relation_id + ")" );
                        } else if ( request.status === 0 ) {
                            alert( "Response Code: " + request.status + "\n\n" + url + "\n\n" + request.getAllResponseHeaders() );
                            var type = request.getResponseHeader( "Content-Type" );
                            if ( type.match(/application\/json/) ) {
                                leftHTTPresponseText = request.responseText;
                                download_right_data();
                            } else {
                                alert( url + " did not return JSON data but " + type );
                            }
                        } else {
                            alert(  "Response Code:\n"       + request.statusText              +
                                    "\n\nRequest:\n"         + request.responseURL             +
                                    "\n\nResponseheaders:\n" + request.getAllResponseHeaders() +
                                    "\n\nResponse:\n"        + request.responseText            +
                                    "\n\nDid you disable JavaScript?"                            );
                        }
                    }
                };

                const d = new Date();
                downloadstartms = d.getTime();

                request.send();

            } else {
                alert( "Parameter 'release_date' is invalid (" + release_date + ")" );
            }
        } else {
            alert( "Parameter 'feed' is invalid (" + feed + ")" );
        }
    } else {
        alert( "Parameter 'feed' is not specified" );
    }
}

//
// 'right' data can be OSM relation or a second GTFS data set
//
function download_right_data() {

    var url     = '';
    var request = new XMLHttpRequest();

    if ( relation_id !== '' ) {
        if ( relation_id.match(/^\d+$/) ) {
            url  = `${OVERPASS_API_URL_PREFIX}${relation_id}${OVERPASS_API_URL_SUFFIX}`;
        } else {
            alert( "Relation ID is not a number (" + relation_id + ")" );
            return false;
        }
    } else if ( feed2 !== '' ) {
        if ( feed2.match(/^[0-9A-Za-z_.-]+$/) ) {
            if ( release_date2 === '' || release_date2.match(/^\d\d\d\d-\d\d-\d\d$/) ) {
                if ( trip_id2 !== '' ) {
                    url = PTNA_API_URL     +
                        '?feed='         + encodeURIComponent(feed2)         +
                        '&release_date=' + encodeURIComponent(release_date2) +
                        '&trip_id='      + encodeURIComponent(trip_id2)      +
                        '&full';
                } else {
                    alert( "Parameter 'trip_id2' is not set" );
                    return false;
                }
            } else {
                alert( "Parameter 'release_date2' is invalid (" + release_date2 + ")" );
                return false;
            }
        } else {
            alert( "Parameter 'feed2' is invalid (" + feed2 + ")" );
            return false;
        }
    } else {
        alert( "Neither parameter 'feed2' nor parameter 'relation' is set" );
        return false;
    }

    request.open( "GET", url );
    request.onprogress = function() {
        const d = new Date();
        var usedms = d.getTime() - downloadstartms;
        dBarRight.value = usedms;
        document.getElementById('download_right_text').innerText = usedms.toString();
    };
    request.onreadystatechange = function() {
        const d = new Date();
        var usedms = d.getTime() - downloadstartms;
        dBarRight.value = usedms;
        document.getElementById('download_right_text').innerText = usedms.toString();
        if ( request.readyState === 4 ) {
            if ( request.status === 200 ) {
                var type = request.getResponseHeader( "Content-Type" );
                if ( type.match(/application\/json/) ) {
                    rightHTTPresponseText = request.responseText;
                    parseHttpResponses();
                } else {
                    alert( url + " did not return JSON data but " + type );
                }
            } else if ( request.status === 410 ) {
                alert( "Relation does not exist (" + relation_id + ")" );
            } else if ( request.status === 0 ) {
                alert( "Response Code: " + request.status + "\n\n" + url + "\n\n" + request.getAllResponseHeaders() );
                var type = request.getResponseHeader( "Content-Type" );
                if ( type.match(/application\/json/) ) {
                    rightHTTPresponseText = request.responseText;
                    parseHttpResponses();
                } else {
                    alert( url + " did not return JSON data but " + type );
                }
            } else {
                alert(  "Response Code:\n"       + request.statusText              +
                        "\n\nRequest:\n"         + request.responseURL             +
                        "\n\nResponseheaders:\n" + request.getAllResponseHeaders() +
                        "\n\nResponse:\n"        + request.responseText            +
                        "\n\nDid you disable JavaScript?"                            );
            }
        }
    };

    const d = new Date();
    downloadstartms = d.getTime();

    request.send();

}


function parseHttpResponses() {

    parseLeftHttpResponse( leftHTTPresponseText );
    parseRightHttpResponse( rightHTTPresponseText );

    IterateOverMembers();
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


function fillNodesWaysRelations() {

    var OSM_ID   = 0;
    var OSM_TYPE = 0;

    for ( var i = 0; i < osm_data[osm_data_index]["elements"].length; i++ ) {
        OSM_ID   = osm_data[osm_data_index]["elements"][i]["id"];
        OSM_TYPE = osm_data[osm_data_index]["elements"][i]["type"];

        if ( OSM_TYPE == "node" ) {
            OSM_Nodes[OSM_ID]   = osm_data[osm_data_index]["elements"][i];
        } else if ( OSM_TYPE == "way" ) {
            OSM_Ways[OSM_ID]    = osm_data[osm_data_index]["elements"][i];
        } else if ( OSM_TYPE == "relation" ) {
            OSM_Relations[OSM_ID] = osm_data[osm_data_index]["elements"][i];
        }
    }

    osm_data_index++;

}


function getRelationBounds() {
    return [ [minlat, minlon], [maxlat, maxlon] ];
}


function IterateOverMembers() {
    var object = OSM_Relations[relation_id];

    number_of_match         = { platform:1, stop:1, route:1, other:1 };
    latlonroute['platform'] = [];
    latlonroute['stop']     = [];
    latlonroute['route']    = [];
    latlonroute['other']    = [];

    if ( object ) {

        // start analyzing the first (index = 0) member
        // function restarts itself with setTimeout() with 0 msec break, just to keep the browser responsive

        const d = new Date();
        analysisstartms = d.getTime();

        handleMember( relation_id, 0 );

    }
}


function handleMember( relation_id, index ) {

    var object = OSM_Relations[relation_id];

    var members_handled = 0;
    var listlength      = object['members'].length;

    for ( var members_handled = 0; members_handled < members_per_timeout; members_handled++ ) {

        if ( index < listlength ) {

            var member      = {};
            var attention   = {};
            var match       = "other";
            var html        = "";
            var img         = 'none';
            var role        = object['members'][index]["role"].replace(/ /g,'<blank>');
            var type        = object['members'][index]["type"];
            var id          = object['members'][index]["ref"];
            var name        = '';
            var wayimg      = "IsolatedWay";

            if ( type == "node" ) {
                member = OSM_Nodes[id];
                img    = "Node";
            } else if ( type == "way" ) {
                member = OSM_Ways[id];
                img    = "Way";
            } else if ( type == "relation" ) {
                member = OSM_Relations[id];
                img    = "Relation";
            }

            if ( member ) {
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

                if ( match == "other" ) {
                    if ( is_PTv2 ) {
                        if ( role == "stop"               ||
                                role == "stop_exit_only"  ||
                                role == "stop_entry_only" ||
                            (member['tags']                                        &&
                                member['tags']['public_transport']                 &&
                                member['tags']['public_transport'] == "stop_position")
                            ) {
                            match = "stop";
                            if ( !role.match(/stop/) ) {
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
                                attention['role'] = "attention";
                            }
                        }
                    } else {
                        if ( role.match(/stop/) ||
                            (member['tags']            &&
                                member['tags']['highway'] &&
                                member['tags']['highway'] == "bus_stop")) {
                            match = "stop";
                        }
                    }
                }

                if ( match == "other" ) {
                    if ( type == "way" ) {
                        if ( is_PTv2 ) {
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
                    label_of_object[id] = label_of_object[id] + "+" + number_of_match[match].toString();
                } else {
                    label_of_object[id] = number_of_match[match].toString();
                }

                name = member['tags'] && member['tags']['name'] || member['tags'] && member['tags']['ref'] || member['tags'] && member['tags']['description'] || '';

                latlonroute[match].push( drawObject( id, type, match, label_of_object[id], htmlEscape(name) ) );

                if ( match == "route" && number_of_match[match] == 1 ) {
                    map.fitBounds( getRelationBounds() );
                }

                array=[number_of_match[match]++, (index+1), role, name, id, type, attention['role'], attention['id']];

            }

            index++;
        }
    }

    if ( index < listlength ) {
        updateAnalysisProgress( members_per_timeout );

        // start handling the next member after 0 msec break

        setTimeout( handleMember, 0, relation_id, index );

    } else {
        // reached the end of the list

        if ( latlonroute['platform'].length > 1 ) {
            L.polyline(latlonroute['platform'],{color:colours['platform'],weight:3,fill:false}).bindPopup("Platform Route").addTo( layerrightstopsroute );
        }

        map.fitBounds( getRelationBounds() );

        finalizeAnalysisProgress();

    }

}


function PopupContent (id, type, match, label, name) {

    if ( match == "platform" ) { txt="Platform" }
    else if ( match == "stop" ) { txt="Stop" }
    else if ( match == "route" ) { txt="Way" }
    else { txt="Other" }

    a = "<b>" + txt + " " + label.toString() + ': ' + name + "</b></br>";
    a += getObjectLinks( id, type )

   return a;
}


function drawObject( id, type, match, label_number, name ) {

    if ( type == "node" ) {
        return drawNode( id, match, label_number, name, true, true );
    } else if ( type == "way" ) {
        return drawWay( id, match, label_number, name, true );
    } else if ( type == "relation" ) {
        return drawRelation( id, match, label_number, name, true )
    }
    return [0,0];
}


function drawNode( id, match, label, name, set_marker, set_circle ) {
    match = match || 'other';
    label = label || 0;
    name  = name  || '';

    var lat = OSM_Nodes[id]['lat'];
    var lon = OSM_Nodes[id]['lon'];
    if ( match == "platform" ) {
        if ( set_circle ) L.circle([lat,lon],{color:colours[match],radius:0.75,fill:true}).addTo(layerrightstops);
        if ( set_marker ) L.marker([lat,lon],{color:colours[match],icon:icons[match]}).bindTooltip(label.toString(),{permanent:true,direction:'center'}).bindPopup(PopupContent(id, "node", match, label, name)).addTo(layerrightstops);
    } else if ( match == "stop"     ) {
        if ( set_circle ) L.circle([lat,lon],{color:colours[match],radius:0.75,fill:true}).addTo(layerleftstops);
        if ( set_marker ) L.marker([lat,lon],{color:colours[match],icon:icons[match]}).bindTooltip(label.toString(),{permanent:true,direction:'center'}).bindPopup(PopupContent(id, "node", match, label, name)).addTo(layerleftstops);
    } else if ( match == "route"     ) {
        if ( set_circle ) L.circle([lat,lon],{color:colours[match],radius:0.75,fill:true}).addTo(layerrightshape);
        if ( set_marker ) L.marker([lat,lon],{color:colours[match],icon:icons[match]}).bindTooltip(label.toString(),{permanent:true,direction:'center'}).bindPopup(PopupContent(id, "node", match, label, name)).addTo(layerrightshape);
    }
    if ( lat < minlat ) minlat = lat;
    if ( lat > maxlat ) maxlat = lat;
    if ( lon < minlon ) minlon = lon;
    if ( lon > maxlon ) maxlon = lon;

    return [lat,lon];
}


function drawWay( id, match, label, name, set_marker ) {
    match = match || 'other';
    label = label || 0;
    name  = name  || '';

    var lat = 0;
    var lon = 0;

    var polyline_array = [];
    var node_id;

    var nodes = OSM_Ways[id]["nodes"];

    for ( var j = 0; j < nodes.length; j++ ) {
        node_id = nodes[j];
        lat     = OSM_Nodes[node_id]['lat'];
        lon     = OSM_Nodes[node_id]['lon'];
        if ( lat < minlat ) minlat = lat;
        if ( lat > maxlat ) maxlat = lat;
        if ( lon < minlon ) minlon = lon;
        if ( lon > maxlon ) maxlon = lon;

        polyline_array.push( [ lat, lon ] );
    }

    if ( match == 'platform' ) {
        mlat = OSM_Nodes[nodes[0]]['lat'];
        mlon = OSM_Nodes[nodes[0]]['lon'];
        if ( set_marker ) L.marker([mlat,mlon],{color:colours[match],icon:icons[match]}).bindTooltip(label.toString(),{permanent:true,direction:'center'}).bindPopup(PopupContent(id, "way", match, label, name)).addTo(layerrightstops);

        L.polyline(polyline_array,{color:colours[match],weight:4,fill:false}).bindPopup(PopupContent(id, "way", match, label, name)).addTo( layerrightstops );
    } else if ( match == 'stop' ) {
        mlat = OSM_Nodes[nodes[0]]['lat'];
        mlon = OSM_Nodes[nodes[0]]['lon'];
        if ( set_marker ) L.marker([mlat,mlon],{color:colours[match],icon:icons[match]}).bindTooltip(label.toString(),{permanent:true,direction:'center'}).bindPopup(PopupContent(id, "way", match, label, name)).addTo(layerleftstops);

        L.polyline(polyline_array,{color:colours[match],weight:4,fill:false}).bindPopup(PopupContent(id, "way", match, label, name)).addTo( layerleftstops );
    } else if ( match == "route" ) {
        L.polyline(polyline_array,{color:colours[match],weight:4,fill:false}).bindPopup(PopupContent(id, "way", match, label, name)).addTo( layerrightshape );
    }

    return [OSM_Nodes[nodes[0]]['lat'],OSM_Nodes[nodes[0]]['lon']];
}


function drawRelation( id, match, label, name, set_marker ) {
    match = match || 'other';
    label = label || 0;
    name  = name  || '';

    var lat = 0;
    var lon = 0;

    var member_type;
    var member_role;
    var member_id;
    var have_set_marker = 0;

    var members = OSM_Relations[id]["members"];

    for ( var j = 0; j < members.length; j++ ) {
        member_type = members[j]['type'];
        member_role = members[j]['role'];
        member_id   = members[j]['ref'];

        if ( member_type == "node" ) {
            if ( !OSM_Nodes[member_id] ) {
                downloadRelationSync( id );
            }
            if ( OSM_Nodes[member_id] ) {
                if ( have_set_marker ) {
                    drawNode( member_id, match, label, name, false, false );
                } else {
                    [lat,lon] = drawNode( member_id, match, label, name, true, true );
                    have_set_marker = 1;
                }
            } else {
                console.log( "Failed to download Relation " + id + " for Node: " + member_id );
            }
        } else if ( member_type == "way" ) {
            if ( !OSM_Ways[member_id] ) {
                downloadRelationSync( id );
            }
            if ( OSM_Ways[member_id] ) {
                if ( have_set_marker ) {
                    drawWay( member_id, match, label, name, false );
                } else {
                    [lat,lon] = drawWay( member_id, match, label, name, true );
                    have_set_marker = 1;
                }
            } else {
                console.log( "Failed to download Relation " + id + " for  Way: " + member_id );
            }
        } else if ( member_type == "relation" ) {
            //
            // deep dive into member relations only for type=route relations
            //
            if ( OSM_Relations[id]["tags"] && OSM_Relations[id]["tags"]["type"] && OSM_Relations[id]["tags"]["type"] == "route" ) {
                if ( !OSM_Relations[member_id] ) {
                    downloadRelationSync( id );
                }
                if ( OSM_Relations[member_id] ) {
                    console.log( "No further recursive download of Relation " + id + " for  Relation: " + member_id );
                    document.getElementById("beta").style.display = "block";
                } else {
                    console.log( "Failed to download Relation " + id + " for  Relation: " + member_id );
                }
            } else {
                if ( OSM_Relations[id]["tags"] && OSM_Relations[id]["tags"]["type"] ) {
                    console.log( "No deep dive into relations of type = " + OSM_Relations[id]["tags"]["type"]  );
                } else {
                    console.log( "No deep dive into relations other than type = route" );
                }
            }
        }

    }

    return [ lat, lon ];
}


function getObjectLinks( id, type ) {
    var html = '';

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


function parseLeftHttpResponse( data ) {

    console.log( '>' + data.toString() + "<\n" );

}

function parseRightHttpResponse( data ) {

    console.log( '>' + data.toString() + "<\n" );

    osm_data[osm_data_index] = JSON.parse( data.toString() )

    // console.log( '>' + osm_data[osm_data_index]["version"] + "<" );
    // console.log( '>' + osm_data[osm_data_index]["generator"] + "<" );
    // console.log( '>' + osm_data[osm_data_index]["copyright"] + "<" );
    // console.log( '>' + osm_data[osm_data_index]["attribution"] + "<" );
    // console.log( '>' + osm_data[osm_data_index]["license"] + "<" );

    if ( osm_data[osm_data_index]["elements"].length === 0 ) {
        alert( "Data not found");
        client.abort();
    }
    fillNodesWaysRelations();

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
