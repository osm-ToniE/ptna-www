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
var is_PTv2         = 0;
var osm_data        = {};
var nodes_by_id     = {};
var ways_by_id      = {};
var relations_by_id = {};
var OSM_Nodes       = {};
var OSM_Ways        = {};
var OSM_Relations   = {};


function showrelation() {

    if ( !document.getElementById || !document.createElement || !document.appendChild ) return false;


    //  wmpty tiles
	var nomap  = L.tileLayer('');

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
                    // "OpenTopoMap"               : osmtopo,
                    "none"                      : nomap
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
    console.log( '>' + responseText.toString() + "<\n" );

    osm_data = JSON.parse( responseText.toString() )

    console.log( '>' + osm_data["version"] + "<" );
    console.log( '>' + osm_data["generator"] + "<" );
    console.log( '>' + osm_data["copyright"] + "<" );
    console.log( '>' + osm_data["attribution"] + "<" );
    console.log( '>' + osm_data["license"] + "<" );

    fillNodesWaysRelations();

    writeRelationTable();

    writePlatformStopsWaysOthersTables();

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

    var OSM_ID   = 0;
    var OSM_TYPE = 0;

    for ( var i = 0; i < osm_data["elements"].length; i++ ) {
        OSM_ID   = osm_data["elements"][i]["id"];
        OSM_TYPE = osm_data["elements"][i]["type"];

        if ( OSM_TYPE == "node" ) {
            nodes_by_id[OSM_ID] = i;
            OSM_Nodes[OSM_ID]   = osm_data["elements"][i];
        } else if ( OSM_TYPE == "way" ) {
            ways_by_id[OSM_ID] = i;
            OSM_Ways[OSM_ID]    = osm_data["elements"][i];
        } else if ( OSM_TYPE == "relation" ) {
            relations_by_id[OSM_ID] = i;
            OSM_Relations[OSM_ID] = osm_data["elements"][i];
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

    var object = OSM_Relations[relation_id];

    document.getElementById("osm-relation").innerText += ' ' + relation_id;

    if ( object ) {
        if ( object["type"] == "relation"  &&
             object["id"]   == relation_id    ) {

            var html = "";
            for ( var j in object["tags"] ) {
                html += "<tr><td>" + htmlEscape(j) + "</td><td>" + htmlEscape(object["tags"][j]) + "</td></tr>\n";
                if ( j == "public_transport:version" && object["tags"][j] && object["tags"][j] == "2" ) {
                    is_PTv2 = 1;
                }
            }
            document.getElementById("relation-values").innerHTML = html;
        }
    }
}


function writePlatformStopsWaysOthersTables() {
    var object = OSM_Relations[relation_id];

    var member      = {};
    var type        = '';
    var role        = '';
    var ref         = '';
    var match       = "other"
    var html        = "";
    var img         = 'none';
    var number      = { platform:1, stop:1, route:1, other:1 };
    var name        = '';
    var wayimg      = "IsolatedWay"

    if ( object ) {
        for ( var j = 0; j < object['members'].length; j++ ) {
            member      = {};
            attention   = {};
            match       = "other";
            role        = object['members'][j]["role"];
            type        = object['members'][j]["type"];
            ref         = object['members'][j]["ref"];
            if ( type == "node" ) {
                member = OSM_Nodes[ref];
                img    = "Node";
            } else if ( type == "way" ) {
                member = OSM_Ways[ref];
                img    = "Way";
            } else if ( type == "relation" ) {
                member = OSM_Relations[ref];
                img    = "Relation";
            }

            if ( member ) {
                if ( is_PTv2 ) {
                    if ( role == "platform"            ||
                         role == "platform_exit_only"  ||
                         role == "platform_entry_only" ||
                         (member['tags']                     &&
                          member['tags']['public_transport'] &&
                          member['tags']['public_transport'] == "platform")
                       ) {
                        match = "platform";
                        if ( !role.match(/platform/) ) attention['role'] = " attention";
                    }
                } else {
                    if ( role.match(/platform/) ) {
                        match = "platform";
                    }
                }

                if ( match == "other" ) {
                    if ( is_PTv2 ) {
                        if ( role == "stop"        ||
                             role == "stop_exit_only"  ||
                             role == "stop_entry_only" ||
                            (member['tags']                     &&
                             member['tags']['public_transport'] &&
                             member['tags']['public_transport'] == "stop_position")
                           ) {
                            match = "stop";
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
                    if ( is_PTv2 ) {
                        if ( role == "" ) {
                            match = "route";
                        }
                    } else {
                        if ( role == "" || role.match(/forward/) || role.match(/backward/) ) {
                            match = "route";
                        }
                    }
                }

                html = "";
                name = member['tags'] && member['tags']['name'] || member['tags'] && member['tags']['ref'] || '';
                html += "<tr>";
                html += "    <td class=\"results-number\">" + number[match]++   + "</td>";
                html += "    <td class=\"results-number\">" + (j+1)             + "</td>";
                html += "    <td class=\"results-name " + attention['role'] + "\">"   + htmlEscape(role)  + "</td>";
                html += "    <td class=\"results-name\">"   + htmlEscape(name)  + "</td>";
                html += "    <td class=\"results-name\"><img src=\"/img/" + img + ".svg\"> " + ref + "</td>";
//                if ( match == "route" ) {
//                    html += "    <td class=\"symbol\"><img src=\"/img/" + wayimg + ".png\" width=\"32\" height=\"32\"></td>";
//                }
                html += "</tr>\n";
                document.getElementById(match+"-members").innerHTML += html;
            }
        }
    }
}


function writeRouteTable() {
    var object = OSM_Relations[relation_id];
    var number          = 1;
    var membernumber    = 15;

    if ( object ) {
        var html = "";
        html += "<tr>";
        html += "    <td class=\"results-number\">" + number++ + "</td>";
        html += "    <td class=\"results-number\">" + membernumber++ + "</td>";
        html += "    <td class=\"results-name\">" + '' + "</td>";
        html += "    <td class=\"results-name\">" + 'Starting here' + "</td>";
        html += "    <td class=\"results-name\">" + '<img src=\"/img/Way.svg\">12323' + "</td>";
        html += "    <td class=\"symbol\"><img src=\"/img/FirstWay.png\" width=\"32\" height=\"32\"></td>";
        html += "</tr>\n";
        html += "<tr>";
        html += "    <td class=\"results-number\">" + number++ + "</td>";
        html += "    <td class=\"results-number\">" + membernumber++ + "</td>";
        html += "    <td class=\"results-name\">" + '' + "</td>";
        html += "    <td class=\"results-name\">" + 'Connected at both ends' + "</td>";
        html += "    <td class=\"results-name\">" + '<img src=\"/img/Way.svg\">12323' + "</td>";
        html += "    <td class=\"symbol\"><img src=\"/img/ConnectedWay.png\" width=\"32\" height=\"32\"></td>";
        html += "</tr>\n";
        html += "<tr>";
        html += "    <td class=\"results-number\">" + number++ + "</td>";
        html += "    <td class=\"results-number\">" + membernumber++ + "</td>";
        html += "    <td class=\"results-name\">" + '' + "</td>";
        html += "    <td class=\"results-name\">" + 'Not connected to next' + "</td>";
        html += "    <td class=\"results-name\">" + '<img src=\"/img/Way.svg\">12323' + "</td>";
        html += "    <td class=\"symbol\"><img src=\"/img/NoExitWay.png\" width=\"32\" height=\"32\"></td>";
        html += "</tr>\n";
        html += "<tr>";
        html += "    <td class=\"results-number\">" + number++ + "</td>";
        html += "    <td class=\"results-number\">" + membernumber++ + "</td>";
        html += "    <td class=\"results-name\">" + '' + "</td>";
        html += "    <td class=\"results-name\">" + 'Not connected at all' + "</td>";
        html += "    <td class=\"results-name\">" + '<img src=\"/img/Way.svg\">12323' + "</td>";
        html += "    <td class=\"symbol\"><img src=\"/img/IsolatedWay.png\" width=\"32\" height=\"32\"></td>";
        html += "</tr>\n";
        html += "<tr>";
        html += "    <td class=\"results-number\">" + number++ + "</td>";
        html += "    <td class=\"results-number\">" + membernumber++ + "</td>";
        html += "    <td class=\"results-name\">" + '' + "</td>";
        html += "    <td class=\"results-name\">" + 'Roundabout start' + "</td>";
        html += "    <td class=\"results-name\">" + '<img src=\"/img/Way.svg\">12323' + "</td>";
        html += "    <td class=\"symbol\"><img src=\"/img/RoundaboutStart.png\" width=\"32\" height=\"32\"></td>";
        html += "</tr>\n";
        html += "<tr>";
        html += "    <td class=\"results-number\">" + number++ + "</td>";
        html += "    <td class=\"results-number\">" + membernumber++ + "</td>";
        html += "    <td class=\"results-name\">" + '' + "</td>";
        html += "    <td class=\"results-name\">" + 'Roundabout end' + "</td>";
        html += "    <td class=\"results-name\">" + '<img src=\"/img/Way.svg\">12323' + "</td>";
        html += "    <td class=\"symbol\"><img src=\"/img/RoundaboutEnd.png\" width=\"32\" height=\"32\"></td>";
        html += "</tr>\n";
        html += "<tr>";
        html += "    <td class=\"results-number\">" + number++ + "</td>";
        html += "    <td class=\"results-number\">" + membernumber++ + "</td>";
        html += "    <td class=\"results-name\">" + '' + "</td>";
        html += "    <td class=\"results-name\">" + 'Not connected to previous' + "</td>";
        html += "    <td class=\"results-name\">" + '<img src=\"/img/Way.svg\">12323' + "</td>";
        html += "    <td class=\"symbol\"><img src=\"/img/RestartWay.png\" width=\"32\" height=\"32\"></td>";
        html += "</tr>\n";
        html += "<tr>";
        html += "    <td class=\"results-number\">" + number++ + "</td>";
        html += "    <td class=\"results-number\">" + membernumber++ + "</td>";
        html += "    <td class=\"results-name\">" + '' + "</td>";
        html += "    <td class=\"results-name\">" + 'Connected at both ends' + "</td>";
        html += "    <td class=\"results-name\">" + '<img src=\"/img/Way.svg\">12323' + "</td>";
        html += "    <td class=\"symbol\"><img src=\"/img/ConnectedWay.png\" width=\"32\" height=\"32\"></td>";
        html += "</tr>\n";
        html += "<tr>";
        html += "    <td class=\"results-number\">" + number++ + "</td>";
        html += "    <td class=\"results-number\">" + membernumber++ + "</td>";
        html += "    <td class=\"results-name\">" + '' + "</td>";
        html += "    <td class=\"results-name\">" + 'Roundabout' + "</td>";
        html += "    <td class=\"results-name\">" + '<img src=\"/img/Way.svg\">12323' + "</td>";
        html += "    <td class=\"symbol\"><img src=\"/img/Roundabout.png\" width=\"32\" height=\"32\"></td>";
        html += "</tr>\n";
        html += "<tr>";
        html += "    <td class=\"results-number\">" + number++ + "</td>";
        html += "    <td class=\"results-number\">" + membernumber++ + "</td>";
        html += "    <td class=\"results-name\">" + '' + "</td>";
        html += "    <td class=\"results-name\">" + 'Connected at both ends' + "</td>";
        html += "    <td class=\"results-name\">" + '<img src=\"/img/Way.svg\">12323' + "</td>";
        html += "    <td class=\"symbol\"><img src=\"/img/ConnectedWay.png\" width=\"32\" height=\"32\"></td>";
        html += "</tr>\n";
        html += "<tr>";
        html += "    <td class=\"results-number\">" + number++ + "</td>";
        html += "    <td class=\"results-number\">" + membernumber++ + "</td>";
        html += "    <td class=\"results-name\">" + '' + "</td>";
        html += "    <td class=\"results-name\">" + 'This is the end' + "</td>";
        html += "    <td class=\"results-name\">" + '<img src=\"/img/Way.svg\">12323' + "</td>";
        html += "    <td class=\"symbol\"><img src=\"/img/LastWay.png\" width=\"32\" height=\"32\"></td>";
        html += "</tr>\n";
        document.getElementById("route-members").innerHTML = html;
    }
}


function writeOtherTable() {
    var object = OSM_Relations[relation_id];

    if ( object ) {
        var html = "";
        html += "<tr>";
        html += "    <td class=\"results-number\">" + 1 + "</td>";
        html += "    <td class=\"results-number\">" + 23 + "</td>";
        html += "    <td class=\"results-name\">" + '' + "</td>";
        html += "    <td class=\"results-name\">" + '... comming soon' + "</td>";
        html += "    <td class=\"results-name\">" + '<img src=\"/img/Relation.svg\">356' + "</td>";
        html += "</tr>\n";
        document.getElementById("other-members").innerHTML = html;
    }
}


function htmlEscape( str ) {
    return str
        .replace(/&/g, '&amp;')
        .replace(/"/g, '&quot;')
        .replace(/'/g, '&#39;')
        .replace(/</g, '&lt;')
        .replace(/>/g, '&gt;');
}
