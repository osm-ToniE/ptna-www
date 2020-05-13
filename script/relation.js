//
//
//
const OSM_API_URL_PREFIX = 'https://api.openstreetmap.org/api/0.6/relation/';
const OSM_API_URL_SUFFIX = '/full.json';

var relationmap;
var relation_id;
var osm_data        = {};
var nodes_by_id     = {};
var ways_by_id      = {};
var relations_by_id = {};

function showrelation() {

    relationmap = L.map('relationmap').setView([48.0649, 11.6612], 10);

    L.tileLayer( 'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',
                {
                 maxZoom: 19,
                 attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
                }
               ).addTo(relationmap);

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
    // relationmap.fitBounds(route.getBounds());

    console.log( '>' + osm_data["version"] + "<" );
    console.log( '>' + osm_data["generator"] + "<" );
    console.log( '>' + osm_data["copyright"] + "<" );
    console.log( '>' + osm_data["attribution"] + "<" );
    console.log( '>' + osm_data["license"] + "<" );

    fillNodesWaysRelations();

    writeRelationTable();

    drawRelationWays();

    drawRelationPlatforms();

    // drawRelationStops();

    relationmap.fitBounds( getRelationBounds() );

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


function writeRelationTable( ) {

    var i = relations_by_id[relation_id];

    document.getElementById("osm-relation").innerText += ' ' + relation_id;

    if ( i ) {
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


function drawRelationWays() {
    var i           = relations_by_id[relation_id];
    var waynumber   = 1;

    if ( i ) {
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

                        drawWay( members[j]["ref"], "way", waynumber++ )
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

    var color = 'red';

    if ( role == "platform" ) color = 'blue';
    if ( role == "stop"     ) color = 'yellow'

    console.log( "id = " + id + " index = " + i );

    nodes = osm_data["elements"][i]["nodes"];

    console.log( "Number of nodes : " + nodes.length );

    for ( var j = 0; j < nodes.length; j++ ) {
        node_id = osm_data["elements"][i]["nodes"][j];
        n       = nodes_by_id[node_id];

        polyline_array.push( [ osm_data["elements"][n]['lat'], osm_data["elements"][n]['lon'] ] );
        console.log( "Add Node: " + osm_data["elements"][n]['lat'] + " / " + osm_data["elements"][n]['lon'] );
    }

    var way = L.polyline(polyline_array,{color:color,weight:4,fill:false}).addTo( relationmap );

    return way;
}


function drawRelationPlatforms() {
    var i               = relations_by_id[relation_id];
    var platformnumber  = 1;

    if ( i ) {
        if ( osm_data["elements"][i]["type"] == "relation"  &&
             osm_data["elements"][i]["id"]   == relation_id    ) {

            var members = osm_data["elements"][i]["members"];
            for ( var j = 0; j < members.length; j++ ) {
                if ( members[j]["role"] == "platform"            ||
                     members[j]["role"] == "platform_exit_only"  ||
                     members[j]["role"] == "platform_entry_only"    ) {

                    if ( members[j]["type"] == "node" ) {
                        drawNode( members[j]["ref"], "platform", platformnumber );
                    } else if ( members[j]["type"] == "way" ) {
                        var way        = drawWay( members[j]["ref"], "platform", platformnumber );
                        var way_id     = members[j]["ref"];
                        var way_index  = ways_by_id[way_id];
                        var node_id    = osm_data["elements"][way_index]["nodes"][0];
                        var node_index = nodes_by_id[node_id];
                        var marker = L.marker([osm_data["elements"][node_index]['lat'], osm_data["elements"][node_index]['lon']],{color:'blue'}).bindTooltip(platformnumber.toString(),{permanent: true}).addTo(relationmap);
                    }
                    platformnumber++;
                }
            }
        }
    }
}


function drawNode( id, role, number ) {

    var i = nodes_by_id[id];

    var color = 'red';

    if ( role == "platform" ) color = 'blue';
    if ( role == "stop"     ) color = 'yellow'

    console.log( "id = " + id + " index = " + i );

    var marker = L.marker([osm_data["elements"][i]['lat'], osm_data["elements"][i]['lon']],{color:color}).bindTooltip(number.toString(),{permanent: true}).addTo(relationmap);

    return marker;
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

    console.log ( "Bounds: " + [[minlat,minlon],[maxlat,maxlon]].toString() );
    return [ [minlat, minlon], [maxlat, maxlon] ];
}
