//
//
//
const OSM_API_URL_PREFIX = 'https://api.openstreetmap.org/api/0.6/relation/';
const OSM_API_URL_SUFFIX = '/full.json';

const defaultlat    = 48.0649;
const defaultlon    = 11.6612;
const defaultzoom   = 10;

const members_per_timeout = 5;

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
var analysiscounter = 2;    // 1.) writeRelationTable, 2.) ... iteration over members
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

var colours         = { platform: 'blue', stop: 'green', route: 'red', other: 'black' };

var dBar;
var aBar;

var number_of_match     = {};
var label_of_object     = {}
var latlonroute         = {};


function showrelation() {

    if ( !document.getElementById || !document.createElement || !document.appendChild ) return false;

    dBar        = document.getElementById('download');
    dBar.max    = 20;
    dBar.value  = 0;
    aBar        = document.getElementById('analysis');
    aBar.max    = 100;
    aBar.value  = 0;

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
    map.addLayer(layerothers);

    relation_id = URLparse()["id"];

    if ( relation_id.match(/^\d+$/) ) {

        var url     = `${OSM_API_URL_PREFIX}${relation_id}${OSM_API_URL_SUFFIX}`;
        var request = new XMLHttpRequest();
        request.open( "GET", url );
        request.onprogress = function() {
            dBar.value++;
            document.getElementById('download_text').innerText = (dBar.value * 50).toString();
        }
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

    parseHttpResponse( responseText );

    writeRelationTable();

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


function writeRelationTable( ) {

    var object = OSM_Relations[relation_id];

    analysiscounter  = OSM_Relations[relation_id]['members'].length;
    aBar.max         = analysiscounter;

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
    updateAnalysisProgress( 1 );

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

        setTimeout( handleMember, 0, relation_id, 0 );

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
            var role        = object['members'][index]["role"];
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
                    if ( type == "way" ) {
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
                }

                if ( label_of_object[id] ) {
                    label_of_object[id] = label_of_object[id] + "+" + number_of_match[match].toString();
                } else {
                    label_of_object[id] = number_of_match[match].toString();
                }

                latlonroute[match].push( drawObject( id, type, match, label_of_object[id] ) );

                if ( match == "route" && number_of_match[match] == 1 ) {
                    map.fitBounds( getRelationBounds() );
                }

                html = "";
                name = member['tags'] && member['tags']['name'] || member['tags'] && member['tags']['ref'] || member['tags'] && member['tags']['description'] || '';
                html += "<tr>";
                html += "    <td class=\"results-number\">" + number_of_match[match]++   + "</td>";
                html += "    <td class=\"results-number\">" + (index+1)             + "</td>";
                html += "    <td class=\"results-name " + attention['role'] + "\">"   + htmlEscape(role)  + "</td>";
                html += "    <td class=\"results-text\">"   + htmlEscape(name)  + "</td>";
                html += "    <td class=\"results-name\">" + getObjectLinks( id, type ) + "</td>";
        //                if ( match == "route" ) {
        //                    html += "    <td class=\"symbol\"><img src=\"/img/" + wayimg + ".png\" width=\"32\" height=\"32\"></td>";
        //                }
                html += "</tr>\n";
                document.getElementById(match+"-members").innerHTML += html;

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
            L.polyline(latlonroute['platform'],{color:colours['platform'],weight:3,fill:false}).addTo( layerplatformsroute );
        }
        if ( latlonroute['stop'].length > 1 ) {
            L.polyline(latlonroute['stop'],{color:colours['stop'],weight:3,fill:false}).addTo( layerstopsroute );
        }

        map.fitBounds( getRelationBounds() );

        updateAnalysisProgress( members_handled+1 );

    }

}


function drawObject( id, type, match, label_number ) {

    if ( type == "node" ) {
        return drawNode( id, match, label_number, true, true );
    } else if ( type == "way" ) {
        return drawWay( id, match, label_number, true );
    } else if ( type == "relation" ) {
        return drawRelation( id, match, label_number, true )
    }
    return [0,0];
}


function drawNode( id, match, label, set_marker, set_circle ) {

    var lat = OSM_Nodes[id]['lat'];
    var lon = OSM_Nodes[id]['lon'];
    if ( match == "platform" ) {
        if ( set_circle ) L.circle([lat,lon],{color:colours[match],radius:0.75,fill:true}).addTo(layerplatforms);
        if ( set_marker ) L.marker([lat,lon],{color:colours[match]}).bindTooltip(label.toString(),{permanent:true,direction:'center'}).addTo(layerplatforms);
    } else if ( match == "stop"     ) {
        if ( set_circle ) L.circle([lat,lon],{color:colours[match],radius:0.75,fill:true}).addTo(layerstops);
        if ( set_marker ) L.marker([lat,lon],{color:colours[match]}).bindTooltip(label.toString(),{permanent:true,direction:'center'}).addTo(layerstops);
    } else if ( match == "route"     ) {
        if ( set_circle ) L.circle([lat,lon],{color:colours[match],radius:0.75,fill:true}).addTo(layerways);
        if ( set_marker ) L.marker([lat,lon],{color:colours[match]}).bindTooltip(label.toString(),{permanent:true,direction:'center'}).addTo(layerways);
    } else {
        if ( set_circle ) L.circle([lat,lon],{color:colours[match],radius:0.75,fill:true}).addTo(layerothers);
        if ( set_marker ) L.marker([lat,lon],{color:colours[match]}).bindTooltip(label.toString(),{permanent:true,direction:'center'}).addTo(layerothers);
    }
    if ( lat < minlat ) minlat = lat;
    if ( lat > maxlat ) maxlat = lat;
    if ( lon < minlon ) minlon = lon;
    if ( lon > maxlon ) maxlon = lon;

    return [lat,lon];
}


function drawWay( id, match, label, set_marker ) {
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
        if ( set_marker ) drawNode( nodes[0], match, label, true, false )
        L.polyline(polyline_array,{color:colours[match],weight:4,fill:false}).addTo( layerplatforms );
    } else if ( match == 'stop' ) {
        if ( set_marker ) drawNode( nodes[0], match, label, true, false )
        L.polyline(polyline_array,{color:colours[match],weight:4,fill:false}).addTo( layerstops );
    } else if ( match == "route" ) {
        L.polyline(polyline_array,{color:colours[match],weight:4,fill:false}).addTo( layerways );
    } else {
        L.polyline(polyline_array,{color:colours[match],weight:4,fill:false}).addTo( layerothers );
    }

    return [OSM_Nodes[nodes[0]]['lat'],OSM_Nodes[nodes[0]]['lon']];
}


function drawRelation( id, match, label, set_marker ) {
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
                    drawNode( member_id, match, label, false, false );
                } else {
                    [lat,lon] = drawNode( member_id, match, label, true, true );
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
                    drawWay( member_id, match, label, false );
                } else {
                    [lat,lon] = drawWay( member_id, match, label, true );
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


function downloadRelationSync( relation_id  ) {

    var url     = `${OSM_API_URL_PREFIX}${relation_id}${OSM_API_URL_SUFFIX}`;
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


function parseHttpResponse( data ) {

    // console.log( '>' + data.toString() + "<\n" );

    osm_data[osm_data_index] = JSON.parse( data.toString() )

    // console.log( '>' + osm_data[osm_data_index]["version"] + "<" );
    // console.log( '>' + osm_data[osm_data_index]["generator"] + "<" );
    // console.log( '>' + osm_data[osm_data_index]["copyright"] + "<" );
    // console.log( '>' + osm_data[osm_data_index]["attribution"] + "<" );
    // console.log( '>' + osm_data[osm_data_index]["license"] + "<" );

    fillNodesWaysRelations();

}


function updateAnalysisProgress( increment ) {
    increment = increment || 1;
    aBar.value += increment;
    document.getElementById('analysis_text').innerText = Math.floor((100 / analysiscounter) * aBar.value).toString();
}
