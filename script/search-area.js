//
//
//
//const OSM_API_URL_PREFIX = 'https://api.openstreetmap.org/api/0.6/relation/';
//const OSM_API_URL_SUFFIX = '/full.json';

const OSM_API_URL_PREFIX = 'https://overpass-api.de/api/interpreter?data=[out:json];relation';
const OSM_API_URL_SUFFIX = ';(._;>;);out;';

const defaultlat    = 48.0649;
const defaultlon    = 11.6612;
const defaultzoom   = 10;

const osmlicence    = 'Map data &copy; <a href="https://openstreetmap.org" target="_blank">OpenStreetMap</a> contributors, <a href="https://www.openstreetmap.org/copyright" target="_blank">ODbL</a> &mdash; ';
const attribution   = '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors';

var map;
var layeroverpass;
var layerextract;
var layergetid;
var colours = { overpass: 'blue',    extract: 'black',    getid: 'green' };


var OSM_Nodes       = [];
var OSM_Ways        = [];
var OSM_Relations   = [];
var overpass_data   = '';
var downloadstartms = 0;
var bool_fitBounds_Overpass = true;

var dBar;


function create_map( overpass, extract, getid ) {

    if ( !document.getElementById || !document.createElement || !document.appendChild ) return false;

    //  empty tiles
	var nomap  = L.tileLayer('');

    //  OpenStreetMap's Standard tile layer
	var osmorg = L.tileLayer(  'https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
		                        maxZoom: 19,
		                        attribution: attribution
	                        } );

    //  OpenStreetMap's DE Style
    var osmde = L.tileLayer(    'https://tile.openstreetmap.de/tiles/osmde/{z}/{x}/{y}.png', {
                                maxZoom: 19,
                                attribution: osmlicence + 'Imagery &copy; <a href="https://www.openstreetmap.de/germanstyle.html" target="_blank">openstreetmap.de</a>'
                            } );

    // 	OSM France
    // 	https://{s}.tile.openstreetmap.fr/osmfr/{z}/{x}/{y}.png
	var osmfr = L.tileLayer(    'https://{s}.tile.openstreetmap.fr/osmfr/{z}/{x}/{y}.png', {
		                        maxZoom: 19,
		                        attribution: attribution
	                        } );

    // Variables for the data
    layeroverpass  = L.layerGroup();
    layerextract   = L.layerGroup();
    layergetid     = L.layerGroup();

    map = L.map( 'searchareamap', { center : [defaultlat, defaultlon], zoom: defaultzoom, layers: [osmorg, layeroverpass] } );

    var baseMaps = {
                    "OpenStreetMap's Standard"  : osmorg,
                    "OSM Deutscher Style"       : osmde,
                    "OSM France"                : osmfr,
                    "none"                      : nomap
                   };

    var overlayMaps = { "<span style='color: blue'>Overpass-API</span>"      : layeroverpass,
                        "<span style='color: black'>osmium extract</span>"   : layerextract,
                        "<span style='color: green'>osmium getid</span>"     : layergetid
                      };

    var layers      = L.control.layers(baseMaps, overlayMaps).addTo(map);

    if ( extract ) {
        map.addLayer(layerextract);
    }
    if ( getid ) {
        map.addLayer(layergetid);
    }

    return;
}


function show_osmium_getid_area( data, name ) {

    if ( data && name ) {
        var decoded_data = decodeURIComponent(data.replace(/\+/g,' '))
        var decoded_name = decodeURIComponent(name.replace(/\+/g,' '))

        if ( decoded_data.match('^[A-Za-z0-9]') ) {
            // osmium polygon data
            var latlngs = create_latlngs_from_osmium_poly_data( decoded_data );

            if ( latlngs.length ) {
                var polygon = L.polygon( latlngs, {color: colours['getid']} ); // .bindPopup(decoded_name.replace(/^(xx|yy|zz)-/,''));
                    polygon.setStyle( { color: colours['getid'], fillOpacity: 0.1 } );
                    polygon.addTo(layergetid);
            }
        } else {
            // geoJSON
            var polygon = L.geoJSON( JSON.parse(decoded_data) ); // .bindPopup(decoded_name.replace(/^(xx|yy|zz)-/,''));
                polygon.setStyle( { color: colours['getid'], fillOpacity: 0.1 } );
                polygon.addTo(layergetid);
        }
    }
    return;
}


function show_osmium_extract_area( data, name ) {

    if ( data && name ) {
        var decoded_data = decodeURIComponent(data.replace(/\+/g,' '))
        var decoded_name = decodeURIComponent(name.replace(/\+/g,' '))

        if ( decoded_data.match('^[A-Za-z0-9]') ) {
            // osmium polygon data
            var latlngs = create_latlngs_from_osmium_poly_data( decoded_data );

            if ( latlngs.length ) {
                var polygon = L.polygon( latlngs ); // .bindPopup(decoded_name.replace(/^(xx|yy|zz)-/,''));
                    polygon.setStyle( { color: colours['extract'], fillOpacity: 0.2} );
                    polygon.addTo(layerextract);

                map.fitBounds(polygon.getBounds());
                bool_fitBounds_Overpass = false;
            }
        } else {
            // geoJSON
            var polygon = L.geoJSON( JSON.parse(decoded_data) ); // .bindPopup(decoded_name.replace(/^(xx|yy|zz)-/,''));
                polygon.setStyle( { color: colours['extract'], fillOpacity: 0.2 } );
                polygon.addTo(layerextract);

            map.fitBounds(polygon.getBounds());
            bool_fitBounds_Overpass = false;
        }
    }
    return;
}

function show_overpass_api_area( query, name ) {

    var decoded_name = decodeURIComponent(name.replace(/\+/g,' '))

    dBar        = document.getElementById('download');

    if ( query && name ) {
        if ( query.match(/^area/) ) {
            var url     = `${OSM_API_URL_PREFIX}${decodeURIComponent(query.replace(/^area/,''))}${OSM_API_URL_SUFFIX}`;
            var request = new XMLHttpRequest();
            request.open( "GET", url );
            request.onprogress = function() {
                const d = new Date();
                var usedms = d.getTime() - downloadstartms;
                dBar.value = usedms;
                document.getElementById('download_text').innerText = usedms.toString();
            }
            request.onreadystatechange = function() {
                const d = new Date();
                var usedms = d.getTime() - downloadstartms;
                dBar.value = usedms;
                document.getElementById('download_text').innerText = usedms.toString();
                if ( request.readyState === 4 ) {
                    if ( request.status === 200 ) {
                        var type = request.getResponseHeader( "Content-Type" );
                        if ( type.match(/application\/json/) ) {
                            readHttpResponse( request.responseText,decoded_name );
                        } else {
                            alert( url + " did not return JSON data but " + type );
                        }
                    } else if ( request.status === 410 ) {
                        alert( "Relation does not exist (" + relation_id + ")" );
                    } else if ( request.status === 0 ) {
                        alert( "Response Code: " + request.status + "\n\n" + url + "\n\n" + request.getAllResponseHeaders() );
                        var type = request.getResponseHeader( "Content-Type" );
                        if ( type.match(/application\/json/) ) {
                            readHttpResponse( request.responseText );
                        } else {
                            alert( url + " did not return JSON data but " + type );
                        }
                    } else {
                        alert( "Response Code:\n" + request.statusText + "\n\nRequest:\n" + request.responseURL  + "\n\nResponseheaders:\n" + request.getAllResponseHeaders() + "\n\nResponse:\n" + request.responseText );
                    }
                }
            };

            const d = new Date();
            downloadstartms = d.getTime();

            request.send();
        } else if ( query.match(/^poly/) ) {
            var coordinates_string = decodeURIComponent(query.replace(/\+/g,' ')).replace(/^poly:'/,'').replace(/'$/,'');
            var latlngs = [];

            var vals = coordinates_string.split(/\s+/);
            for ( var i = 0, len = vals.length; i < len-1; i = i+2 ) {
                latlngs.push( [ vals[i], vals[i+1] ] );
            }

            if ( latlngs.length ) {
                var polygon = L.polygon( latlngs ); // .bindPopup(decoded_name.replace(/^(xx|yy|zz)-/,''));
                    polygon.setStyle( { color: colours['overpass'], fillOpacity: 0.3 } );
                    polygon.addTo(layeroverpass);

                if ( bool_fitBounds_Overpass ) {
                    map.fitBounds(polygon.getBounds());
                }
            }
        }

    }
    return;
}


function readHttpResponse( responseText, decoded_name ) {

    parseHttpResponse( responseText );

    var latlngs = create_latlngs_from_osm_json_data();

    if ( latlngs.length ) {
        var polyline = L.polyline( latlngs ); // .bindPopup(decoded_name.replace(/^(xx|yy|zz)-/,''));
            polyline.setStyle( { color: colours['overpass'], fillOpacity: 0.3 } );
            polyline.addTo(layeroverpass);

        if ( bool_fitBounds_Overpass ) {
            map.fitBounds(polyline.getBounds());
        }
    }
    return;
}


function create_latlngs_from_osmium_poly_data( data ) {

    var latlngs = [];
    var latlngs_section = [];
    var lat = '';
    var lon = '';
    var ignore_section = false;

    var lines = data.split(/\n/);
    var lines_count = lines.length;

    for ( var index = 0; index < lines_count; index++ ) {
        if ( lines[index].match(/[!A-Za-z]/) ||
             lines[index].match(/^\d+$/)       )  {
            if ( latlngs_section.length ) {
                if ( !ignore_section ) {
                    latlngs_section.pop();
                    latlngs.push( latlngs_section );
                }
                latlngs_section = [];
            }
            if (lines[index].match(/^\s*!/) ) {
                ignore_section = true;
            } else {
                ignore_section = false;
            }
        } else if ( lines[index] ) {
            [lon,lat] = lines[index].replace(/^\s*/,'').replace(/\s*$/,'').split(/\s+/);
            latlngs_section.push( [ lat, lon ] );
        }
    }
    return latlngs;
}


function parseHttpResponse( data ) {

    // console.log( '>' + data.toString() + "<\n" );

    overpass_data = JSON.parse( data.toString() )

    console.log( '>version = ' + overpass_data["version"] + "<" );
    console.log( '>generator = ' + overpass_data["generator"] + "<" );
    console.log( '>timestamp_osm_base = ' + overpass_data["osm3s"]["timestamp_osm_base"] + "<" );
    console.log( '>copyright = ' + overpass_data["osm3s"]["copyright"] + "<" );

    if ( overpass_data["elements"].length === 0 ) {
        alert( "Data not found");
    }

    var OSM_ID   = 0;
    var OSM_TYPE = 0;

    for ( var i = 0; i < overpass_data["elements"].length; i++ ) {
        OSM_ID   = overpass_data["elements"][i]["id"];
        OSM_TYPE = overpass_data["elements"][i]["type"];

        if ( OSM_TYPE == "node" ) {
            OSM_Nodes[OSM_ID]   = overpass_data["elements"][i];
        } else if ( OSM_TYPE == "way" ) {
            OSM_Ways[OSM_ID]    = overpass_data["elements"][i];
        } else if ( OSM_TYPE == "relation" ) {
            OSM_Relations[OSM_ID] = overpass_data["elements"][i];
        }
    }
    return;
}


function create_latlngs_from_osm_json_data() {

    var latlngs = [];
    var latlngs_way = [];

    for ( var relation in OSM_Relations ) {
        // console.log( relation + ' => ' + OSM_Relations[relation]['tags']['name'] );

        var members_array = OSM_Relations[relation]['members'];
        var members_array_length = members_array.length;
        for ( var member_index = 0; member_index < members_array_length; member_index++ ) {
            // console.log( '    type = ' + members_array[member_index]['type'] + '    role = ' + members_array[member_index]['role'] + '    id = ' + members_array[member_index]['ref'] );
            if ( members_array[member_index]['type'] === 'way' ) {
                // console.log( '        id = ' + members_array[member_index]['ref'] );
                var way_id = members_array[member_index]['ref'];
                var nodes_array = OSM_Ways[way_id]['nodes'];
                var nodes_array_length = nodes_array.length;
                latlngs_way = [];
                for ( var node_index in nodes_array ) {
                    var node_id = nodes_array[node_index];
                    // console.log( '            id = ' + node_id + ' push lat = ' + OSM_Nodes[node_id]['lat'] + ' lon = ' + OSM_Nodes[node_id]['lon']);
                    latlngs_way.push( [ OSM_Nodes[node_id]['lat'], OSM_Nodes[node_id]['lon'] ] );
                }
                // console.log( latlngs_way );
                latlngs.push( latlngs_way );
            }
        }
    }
    // console.log( latlngs );
    return latlngs;
}
