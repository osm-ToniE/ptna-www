//
//
//
const OSM_API_URL_PREFIX = 'https://api.openstreetmap.org/api/0.6/relation/';
const OSM_API_URL_SUFFIX = '/full.json';

const defaultlat    = 48.0649;
const defaultlon    = 11.6612;
const defaultzoom   = 10;

const osmlicence    = 'Map data &copy; <a href="http://openstreetmap.org" target="_blank">OpenStreetMap</a> contributors, <a href="http://www.openstreetmap.org/copyright" target="_blank">ODbL</a> &mdash; ';
const attribution   = 'Map data &copy; <a href="http://openstreetmap.org">OpenStreetMap</a> contributors, <a href="http://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>';

var map;
var layerways;
var layerplatforms;
var layerplatformsroute;
var layerstops;
var layerstopsroute;

var relation_id;
var osm_data        = {};
var nodes_by_id     = {};
var ways_by_id      = {};
var relations_by_id = {};


// addEvent( window, 'load', function() { init(); } );


function showrelation() {

    if ( !document.getElementById || !document.createElement || !document.appendChild ) return false;


    //  OpenStreetMap's Standard tile layer
	var osmorg = L.tileLayer(  'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
		                        maxZoom: 19,
		                        attribution: attribution
	                        } );

    //  OpenStreetMap's DE Style
    var osmde = L.tileLayer(    'https://{s}.tile.openstreetmap.de/tiles/osmde/{z}/{x}/{y}.png', {
                                maxZoom: 19,
                                attribution: osmlicence + 'Imagery &copy; <a href="http://www.openstreetmap.de/germanstyle.html" target="_blank">openstreetmap.de</a>'
                            } );

    // 	OSM France
    // 	http://{s}.tile.openstreetmap.fr/osmfr/{z}/{x}/{y}.png
	var osmfr = L.tileLayer(    'http://{s}.tile.openstreetmap.fr/osmfr/{z}/{x}/{y}.png', {
		                        maxZoom: 19,
		                        attribution: attribution
	                        } );

    // 	opentopomap
    // 	http://{s}.tile.openstreetmap.fr/osmfr/{z}/{x}/{y}.png
	var osmtopo = L.tileLayer(  'https://{s}.tile.opentopomap.org/{z}/{x}/{y}.png', {
		                        maxZoom: 17,
		                        attribution: 'Map data &copy; <a href="http://openstreetmap.org">OpenStreetMap</a> contributors, ' +
			                    'SRTM | Kartendarstellung: Â© <a href="http://opentopomap.org/">OpenTopoMap</a> '  +
			                    '<a href="https://creativecommons.org/licenses/by-sa/3.0/">CC-BY-SA</a>'
	                        } );

    // 	ÖPNV-karte
    // 	http://toolserver.org/~cmarqu/hill/{z}/{x}/{y}.png
	var oepnv = L.tileLayer(    'http://toolserver.org/~cmarqu/hill/{z}/{x}/{y}.png', {
		                        maxZoom: 19,
		                        attribution: attribution
	                        });

    //  Transport Map
    // 	http://{s}.tile2.opencyclemap.org/transport/{z}/{x}/{y}.png
    var transpmap = L.tileLayer(    'http://{s}.tile2.opencyclemap.org/transport/{z}/{x}/{y}.png', {
		                            maxZoom: 19,
		                            attribution: attribution
                                } );

    // Variables for the data
    layerways           = L.layerGroup();
    layerplatforms      = L.layerGroup();
    layerplatformsroute = L.layerGroup();
    layerstops          = L.layerGroup();
    layerstopsroute     = L.layerGroup();
    layerother          = L.layerGroup();

    map = L.map( 'relationmap', { center : [defaultlat, defaultlon], zoom: defaultzoom, layers: [osmorg, layerways] } );

    var baseMaps = {
                    "OpenStreetMap's Standard"  : osmorg,
                    "OSM Deutscher Style"       : osmde,
                    "OSM France"                : osmfr,
                    "OpenTopoMap"               : osmtopo
                    // "ÖPNV-Karte": oepnv,
                    // "Transport Map (without API-Key!)": transpmap
                   };

    var overlayMaps = { "<span style='color: red'>Route</span>"                 : layerways,
                        "<span style='color: blue'>Platforms</span>"            : layerplatforms,
                        "<span style='color: blue'>Platform Route</span>"       : layerplatformsroute,
                        "<span style='color: green'>Stop-Positions</span>"      : layerstops,
                        "<span style='color: green'>Stop-Position Route</span>" : layerstopsroute,
                        "<span style='color: black'>Other</span>"               : layerother
                      };

    var layers      = L.control.layers(baseMaps, overlayMaps).addTo(map);

    map.addLayer(layerplatforms);
    map.addLayer(layerplatformsroute);
    map.addLayer(layerstops);

    relation_id = URLparse()["id"];

    if ( relation_id.match(/^\d+$/) ) {

        var url     = `${OSM_API_URL_PREFIX}${relation_id}${OSM_API_URL_SUFFIX}`;
        var request = new XMLHttpRequest();
        request.open( "GET", url );
        request.onreadystatechange = function() {
            if ( request.readyState === 4 ) {
                if ( request.status === 200 ) {
                    var type = request.getResponseHeader( "Content-Type" );
                    if ( type.match(/application\/json/) ) {
                        readHttpResponse( request.responseText );
                    }
                } else if ( request.status === 410 ) {
                    alert( "Relation does not exist (" + relation_id + ")" );
                } else {
                    alert( "Response Code: " + request.status );
                }
            }
        };

        request.send();
    } else {
        alert( "Relation ID is not a number (" + relation_id + ")" );
    }
}

function readHttpResponse( responseText ) {
    // console.log( '>' + responseText.toString() + "<\n" );

    osm_data = JSON.parse( responseText.toString() )

    console.log( '>' + osm_data["version"] + "<" );
    console.log( '>' + osm_data["generator"] + "<" );
    console.log( '>' + osm_data["copyright"] + "<" );
    console.log( '>' + osm_data["attribution"] + "<" );
    console.log( '>' + osm_data["license"] + "<" );

    fillNodesWaysRelations();

    writeRelationTable();

    writePlatformTable();

    writeStopTable();

    writeRouteTable();

    drawRelationWays();

    drawRelationPlatforms();

    drawRelationStops();

    map.fitBounds( getRelationBounds() );

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

    for ( var i = 0; i < osm_data["elements"].length; i++ ) {
        if ( osm_data["elements"][i]["type"] == "node" ) {
            nodes_by_id[osm_data["elements"][i]["id"]] = i;
        } else if ( osm_data["elements"][i]["type"] == "way" ) {
            ways_by_id[osm_data["elements"][i]["id"]] = i;
        } else if ( osm_data["elements"][i]["type"] == "relation" ) {
            relations_by_id[osm_data["elements"][i]["id"]] = i;
        }
    }
}


function drawRelationWays() {
    var i           = relations_by_id[relation_id];
    var waynumber   = 1;

    // i can be undefined or even 0, first element of array

    if ( i || i === 0 ) {
        if ( osm_data["elements"][i]["type"] == "relation"  &&
             osm_data["elements"][i]["id"]   == relation_id    ) {

            var members = osm_data["elements"][i]["members"];
            for ( var j = 0; j < members.length; j++ ) {
                if ( members[j]["type"] == "way" ) {
                    if ( members[j]["role"] != "stop"                &&
                         members[j]["role"] != "stop_exit_only"      &&
                         members[j]["role"] != "stop_entry_only"     &&
                         members[j]["role"] != "platform"            &&
                         members[j]["role"] != "platform_exit_only"  &&
                         members[j]["role"] != "platform_entry_only"    ) {

                        drawWay( members[j]["ref"], "way", waynumber++ );
                    }
                }
            }
        }
    }
}


function drawWay( id, role, number ) {
    var polyline_array = [];

    var i = ways_by_id[id];
    var node_id;
    var n;
    var way;

    // console.log( "id = " + id + " index = " + i );

    nodes = osm_data["elements"][i]["nodes"];

    // console.log( "Number of nodes : " + nodes.length );

    for ( var j = 0; j < nodes.length; j++ ) {
        node_id = osm_data["elements"][i]["nodes"][j];
        n       = nodes_by_id[node_id];

        polyline_array.push( [ osm_data["elements"][n]['lat'], osm_data["elements"][n]['lon'] ] );
        // console.log( "Add Node: " + osm_data["elements"][n]['lat'] + " / " + osm_data["elements"][n]['lon'] );
    }

    if ( role == 'platform' ) {
        way = L.polyline(polyline_array,{color:'blue',weight:4,fill:false}).addTo( layerplatforms );
    } else if ( role == 'stop' ) {
        way = L.polyline(polyline_array,{color:'green',weight:4,fill:false}).addTo( layerstops );
    } else {
        way = L.polyline(polyline_array,{color:'red',weight:4,fill:false}).addTo( layerways );
    }
    return way;
}


function drawRelationPlatforms() {
    var i                   = relations_by_id[relation_id];
    var platformnumber      = 1;
    var platformlabel_of_id = {};
    var polyline_array      = [];

    if ( i ) {
        if ( osm_data["elements"][i]["type"] == "relation"  &&
             osm_data["elements"][i]["id"]   == relation_id    ) {

            var members = osm_data["elements"][i]["members"];
            for ( var j = 0; j < members.length; j++ ) {
                if ( members[j]["role"] == "platform"            ||
                     members[j]["role"] == "platform_exit_only"  ||
                     members[j]["role"] == "platform_entry_only"    ) {

                    if ( members[j]["type"] == "node" ) {
                        if ( platformlabel_of_id["n"+members[j]["ref"]] ) {
                            platformlabel_of_id["n"+members[j]["ref"]] += "+" + platformnumber.toString();
                        } else {
                            platformlabel_of_id["n"+members[j]["ref"]] = platformnumber.toString();
                        }
                        drawNode( members[j]["ref"], "platform", platformlabel_of_id["n"+members[j]["ref"]] );
                        var node_id    = members[j]["ref"];
                        var node_index = nodes_by_id[node_id];
                        polyline_array.push( [osm_data["elements"][node_index]['lat'], osm_data["elements"][node_index]['lon']] );
                    } else if ( members[j]["type"] == "way" ) {
                        if ( platformlabel_of_id["w"+members[j]["ref"]] ) {
                            platformlabel_of_id["w"+members[j]["ref"]] += "+" + platformnumber.toString();
                        } else {
                            platformlabel_of_id["w"+members[j]["ref"]] = platformnumber.toString();
                        }
                        var way        = drawWay( members[j]["ref"], "platform", platformlabel_of_id["w"+members[j]["ref"]] );
                        var way_id     = members[j]["ref"];
                        var way_index  = ways_by_id[way_id];
                        var node_id    = osm_data["elements"][way_index]["nodes"][0];
                        var node_index = nodes_by_id[node_id];
                        var marker     = L.marker([osm_data["elements"][node_index]['lat'], osm_data["elements"][node_index]['lon']],{color:'blue'}).bindTooltip(platformlabel_of_id["w"+members[j]["ref"]],{permanent: true,direction:'center'}).addTo(layerplatforms);
                        polyline_array.push( [osm_data["elements"][node_index]['lat'], osm_data["elements"][node_index]['lon']] );
                    }
                    platformnumber++;
                }
            }
            if ( platformnumber > 2 ) {
                var route = L.polyline(polyline_array,{color:'blue',weight:3,fill:false}).addTo(layerplatformsroute);
            }
        }
    }
}


function drawRelationStops() {
    var i               = relations_by_id[relation_id];
    var stopnumber      = 1;
    var stoplabel_of_id = {};
    var polyline_array      = [];

    if ( i ) {
        if ( osm_data["elements"][i]["type"] == "relation"  &&
             osm_data["elements"][i]["id"]   == relation_id    ) {

            var members = osm_data["elements"][i]["members"];
            for ( var j = 0; j < members.length; j++ ) {
                if ( members[j]["role"] == "stop"            ||
                     members[j]["role"] == "stop_exit_only"  ||
                     members[j]["role"] == "stop_entry_only"    ) {

                    if ( members[j]["type"] == "node" ) {
                        if ( stoplabel_of_id["n"+members[j]["ref"]] ) {
                            stoplabel_of_id["n"+members[j]["ref"]] += "+" + stopnumber.toString();
                        } else {
                            stoplabel_of_id["n"+members[j]["ref"]] = stopnumber.toString();
                        }
                        drawNode( members[j]["ref"], "stop", stoplabel_of_id["n"+members[j]["ref"]] );
                        var node_id    = members[j]["ref"];
                        var node_index = nodes_by_id[node_id];
                        polyline_array.push( [osm_data["elements"][node_index]['lat'], osm_data["elements"][node_index]['lon']] );
                    } else if ( members[j]["type"] == "way" ) {
                        if ( stoplabel_of_id["w"+members[j]["ref"]] ) {
                            stoplabel_of_id["w"+members[j]["ref"]] += "+" + stopnumber.toString();
                        } else {
                            stoplabel_of_id["w"+members[j]["ref"]] = stopnumber.toString();
                        }
                        var way        = drawWay( members[j]["ref"], "stop", stoplabel_of_id["w"+members[j]["ref"]] );
                        var way_id     = members[j]["ref"];
                        var way_index  = ways_by_id[way_id];
                        var node_id    = osm_data["elements"][way_index]["nodes"][0];
                        var node_index = nodes_by_id[node_id];
                        var marker     = L.marker([osm_data["elements"][node_index]['lat'], osm_data["elements"][node_index]['lon']],{color:'green'}).bindTooltip(stoplabel_of_id["w"+members[j]["ref"]],{permanent: true,direction:'center'}).addTo(layerstops);
                        polyline_array.push( [osm_data["elements"][node_index]['lat'], osm_data["elements"][node_index]['lon']] );
                    }
                    stopnumber++;
                }
            }
            if ( stopnumber > 2 ) {
                var route = L.polyline(polyline_array,{color:'green',weight:3,fill:false}).addTo(layerstopsroute);
            }
        }
    }
}


function drawNode( id, role, label ) {

    var i = nodes_by_id[id];

    var circle;
    var marker;

    // console.log( "id = " + id + " index = " + i );

    if ( role == "platform" ) {
        var circle = L.circle([osm_data["elements"][i]['lat'], osm_data["elements"][i]['lon']],{color:'blue',radius:0.75,fill:true}).addTo(layerplatforms);
        var marker = L.marker([osm_data["elements"][i]['lat'], osm_data["elements"][i]['lon']],{color:'blue'}).bindTooltip(label,{permanent:true,direction:'center'}).addTo(layerplatforms);
    } else if ( role == "stop"     ) {
        var circle = L.circle([osm_data["elements"][i]['lat'], osm_data["elements"][i]['lon']],{color:'green',radius:0.75,fill:true}).addTo(layerstops);
        var marker = L.marker([osm_data["elements"][i]['lat'], osm_data["elements"][i]['lon']],{color:'green'}).bindTooltip(label,{permanent:true,direction:'center'}).addTo(layerstops);
    } else {
        var circle = L.circle([osm_data["elements"][i]['lat'], osm_data["elements"][i]['lon']],{color:'red',radius:0.75,fill:true}).addTo(layerways);
        var marker = L.marker([osm_data["elements"][i]['lat'], osm_data["elements"][i]['lon']],{color:'red'}).bindTooltip(label,{permanent:true,direction:'center'}).addTo(layerways);
    }

    return [marker,circle];
}


function getRelationBounds() {
    var maxlat =  -90;
    var minlat =   90;
    var maxlon = -180;
    var minlon =  180;
    var i;

    for ( var n in nodes_by_id ) {
        i = nodes_by_id[n];
        if ( osm_data["elements"][i]["lat"] < minlat ) minlat = osm_data["elements"][i]["lat"];
        if ( osm_data["elements"][i]["lat"] > maxlat ) maxlat = osm_data["elements"][i]["lat"];
        if ( osm_data["elements"][i]["lon"] < minlon ) minlon = osm_data["elements"][i]["lon"];
        if ( osm_data["elements"][i]["lon"] > maxlon ) maxlon = osm_data["elements"][i]["lon"];
    }

    // console.log ( "Bounds: " + [[minlat,minlon],[maxlat,maxlon]].toString() );
    return [ [minlat, minlon], [maxlat, maxlon] ];
}


function writeRelationTable( ) {

    var i = relations_by_id[relation_id];

    document.getElementById("osm-relation").innerText += ' ' + relation_id;

    // i can be undefined or even 0, first element of array

    if ( i || i === 0 ) {
        if ( osm_data["elements"][i]["type"] == "relation"  &&
             osm_data["elements"][i]["id"]   == relation_id    ) {

            var html = "";
            for ( var j in osm_data["elements"][i]["tags"] ) {
                html += "<tr><td>" + j + "</td><td>" + osm_data["elements"][i]["tags"][j] + "</td></tr>\n";
            }
            document.getElementById("relation-values").innerHTML = html;
        }
    }
}


function writePlatformTable() {
    var i = relations_by_id[relation_id];

    if ( i || i === 0 ) {
        var html = "";
        html += "<tr><td>" + '... coming soon' + "</td></tr>\n";
        document.getElementById("platform-values").innerHTML = html;
    }
}


function writeStopTable() {
    var i = relations_by_id[relation_id];

    if ( i || i === 0 ) {
        var html = "";
        html += "<tr><td>" + '... coming soon' + "</td></tr>\n";
        document.getElementById("stop-values").innerHTML = html;
    }
}


function writeRouteTable() {
    var i = relations_by_id[relation_id];

    if ( i || i === 0 ) {
        var html = "";
        html += "<tr><td>" + '... coming soon' + "</td></tr>\n";
        document.getElementById("route-values").innerHTML = html;
    }
}
