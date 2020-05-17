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
var layerothers;

var relation_id;
var is_PTv2         = 0;
var osm_data        = {};
var nodes_by_id     = {};
var ways_by_id      = {};
var relations_by_id = {};
var OSM_Nodes       = {};
var OSM_Ways        = {};
var OSM_Relations   = {};
var maxlat          =  -90;
var minlat          =   90;
var maxlon          = -180;
var minlon          =  180;

var colours         = { platform: 'blue', stop: 'green', route: 'red', other: 'black' };



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
    layerothers         = L.layerGroup();

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
                        "<span style='color: black'>Other</span>"               : layerothers
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

    IterateOverMembers();

    // drawRelationWays();

    // drawRelationPlatforms();

    // drawRelationStops();

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


function getRelationBounds() {
    return [ [minlat, minlon], [maxlat, maxlon] ];
}


function writeRelationTable( ) {

    var object = OSM_Relations[relation_id];

    document.getElementById("osm-relation").innerHTML += ' ' + getObjectLinks( relation_id, "relation" );

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


function IterateOverMembers() {
    var object = OSM_Relations[relation_id];

    var member      = {};
    var type        = '';
    var role        = '';
    var id          = '';
    var match       = "other"
    var html        = "";
    var img         = 'none';
    var number      = { platform:1, stop:1, route:1, other:1 };
    var name        = '';
    var wayimg      = "IsolatedWay";

    var latlonroute = {};

    latlonroute['platform'] = [];
    latlonroute['stop']     = [];
    latlonroute['route']    = [];
    latlonroute['other']    = [];

    if ( object ) {
        for ( var j = 0; j < object['members'].length; j++ ) {
            member      = {};
            attention   = {};
            match       = "other";
            role        = object['members'][j]["role"];
            type        = object['members'][j]["type"];
            id          = object['members'][j]["ref"];
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

                latlonroute[match].push( drawObject( id, type, match, number[match] ) );

                html = "";
                name = member['tags'] && member['tags']['name'] || member['tags'] && member['tags']['ref'] || '';
                html += "<tr>";
                html += "    <td class=\"results-number\">" + number[match]++   + "</td>";
                html += "    <td class=\"results-number\">" + (j+1)             + "</td>";
                html += "    <td class=\"results-name " + attention['role'] + "\">"   + htmlEscape(role)  + "</td>";
                html += "    <td class=\"results-name\">"   + htmlEscape(name)  + "</td>";
                html += "    <td class=\"results-name\">" + getObjectLinks( id, type ) + "</td>";
//                if ( match == "route" ) {
//                    html += "    <td class=\"symbol\"><img src=\"/img/" + wayimg + ".png\" width=\"32\" height=\"32\"></td>";
//                }
                html += "</tr>\n";
                document.getElementById(match+"-members").innerHTML += html;

            }
        }

        if ( latlonroute['platform'].length > 1 ) {
            L.polyline(latlonroute['platform'],{color:colours['platform'],weight:3,fill:false}).addTo( layerplatformsroute );
        }
        if ( latlonroute['stop'].length > 1 ) {
            L.polyline(latlonroute['stop'],{color:colours['stop'],weight:3,fill:false}).addTo( layerstopsroute );
        }
    }
}


function drawObject( id, type, match, label_number ) {

    if ( type == "node" ) {
        return drawNode( id, match, label_number );
    } else if ( type == "way" ) {
        return drawWay( id, match, label_number );
    } else if ( type == "relation" ) {
        // return drawRelation( id, match, label_number )
    }
    return [0,0];
}


function drawNode( id, match, label ) {

    var lat = OSM_Nodes[id]['lat'];
    var lon = OSM_Nodes[id]['lon'];
    if ( match == "platform" ) {
        var circle = L.circle([lat,lon],{color:colours[match],radius:0.75,fill:true}).addTo(layerplatforms);
        var marker = L.marker([lat,lon],{color:colours[match]}).bindTooltip(label.toString(),{permanent:true,direction:'center'}).addTo(layerplatforms);
    } else if ( match == "stop"     ) {
        var circle = L.circle([lat,lon],{color:colours[match],radius:0.75,fill:true}).addTo(layerstops);
        var marker = L.marker([lat,lon],{color:colours[match]}).bindTooltip(label.toString(),{permanent:true,direction:'center'}).addTo(layerstops);
    } else if ( match == "route"     ) {
        var circle = L.circle([lat,lon],{color:colours[match],radius:0.75,fill:true}).addTo(layerways);
        var marker = L.marker([lat,lon],{color:colours[match]}).bindTooltip(label.toString(),{permanent:true,direction:'center'}).addTo(layerways);
    } else {
        var circle = L.circle([lat,lon],{color:colours[match],radius:0.75,fill:true}).addTo(layerothers);
        var marker = L.marker([lat,lon],{color:colours[match]}).bindTooltip(label.toString(),{permanent:true,direction:'center'}).addTo(layerothers);
    }
    if ( lat < minlat ) minlat = lat;
    if ( lat > maxlat ) maxlat = lat;
    if ( lon < minlon ) minlon = lon;
    if ( lon > maxlon ) maxlon = lon;

    return [lat,lon];
}


function drawWay( id, match, label ) {
    var lat;
    var lon;

    var polyline_array = [];
    var node_id;
    var n;
    var way;

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
        drawNode( nodes[0], match, label )
        way = L.polyline(polyline_array,{color:colours[match],weight:4,fill:false}).addTo( layerplatforms );
    } else if ( match == 'stop' ) {
        drawNode( nodes[0], match, label )
        way = L.polyline(polyline_array,{color:colours[match],weight:4,fill:false}).addTo( layerstops );
    } else if ( match == "route" ) {
        way = L.polyline(polyline_array,{color:colours[match],weight:4,fill:false}).addTo( layerways );
    } else {
        way = L.polyline(polyline_array,{color:colours[match],weight:4,fill:false}).addTo( layerothers );
    }

    return [OSM_Nodes[nodes[0]]['lat'],OSM_Nodes[nodes[0]]['lon']];
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
            html += "<a href=\"http://127.0.0.1:8111/load_object?new_layer=false&amp;relation_members=true&amp;objects=r" + id + "\" target=\"hiddenIframe\" title=\"Edit in JOSM\">JOSM</a>",
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
