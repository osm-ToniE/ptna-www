//
//
//
const attribution   = '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors';
const osmlicence    = 'Map data &copy; <a href="http://openstreetmap.org" target="_blank">OpenStreetMap</a> contributors, <a href="http://www.openstreetmap.org/copyright" target="_blank">ODbL</a> &mdash; ';

const defaultlat    = 48.0649;
const defaultlon    = 11.6612;
const defaultzoom   = 10;

var map;
var layerplatforms;
var layerplatformsroute;
var blue_icon;
var icons           = {};
var colours         = {};


function showtriponmap() {

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
    layerplatforms      = L.layerGroup();
    layerplatformsroute = L.layerGroup();

    map = L.map( 'gtfsmap', { center : [defaultlat, defaultlon], zoom: defaultzoom, layers: [osmorg, layerplatforms] } );

    var baseMaps = {
                    "OpenStreetMap's Standard"  : osmorg,
                    "OSM Deutscher Style"       : osmde,
                    "OSM France"                : osmfr,
                    // "OpenTopoMap"               : osmtopo,
                    "none"                      : nomap
                    // "ÖPNV-Karte": oepnv,
                    // "Transport Map (without API-Key!)": transpmap
                   };

    var overlayMaps = { "<span style='color: blue'>Platforms</span>"            : layerplatforms,
                        "<span style='color: blue'>Platform Route</span>"       : layerplatformsroute
                      };

    var layers      = L.control.layers(baseMaps, overlayMaps).addTo(map);

    map.addLayer(layerplatforms);
    map.addLayer(layerplatformsroute);

    blue_icon  = L.icon( { iconUrl: '/img/blue-marker-icon.png',  iconSize: [25,41], iconAnchor: [13,41], popupAnchor: [13,-41], tooltipAnchor: [13,-35] } );
    icons      = { platform: blue_icon };
    colours    = { platform: 'blue'    };

    var polyline_array = [];

    var gpx_lat_array  = [];
    var gpx_lon_array  = [];
    var label_string   = '';

    var stop_table = document.getElementById( "gtfs-single-trip" );

    if ( stop_table ) {

        var stop_listnode = stop_table.getElementsByTagName( "tbody" )[0];
        var stop_list     = stop_listnode.getElementsByTagName( "tr" );

        //    evaluate all gtfs-single-trip rows
        for ( var i = 0; i < stop_list.length; i++ )
        {
            var stop_node  = stop_list[i];
            var sub_td     = stop_node.getElementsByTagName( "td" );

            var gpx_name = "-unknown-";
            var gpx_lat  = "-1";
            var gpx_lon  = "-1";

            //    evaluate all columns of gtfs-single-trip rows
            for ( var j = 0; j < sub_td.length; j++ )
            {
                var keyvalue = sub_td[j];


                if ( keyvalue.firstChild ) {
                    var value = keyvalue.firstChild.data;
                }
                else {
                    var value = "-1";
                }

                var key = keyvalue.getAttribute("class");

                if ( key == "gtfs-stop-name" )
                {
                    gpx_name = value;
                }
                else if ( key == "gtfs-lat" )
                {
                    gpx_lat  = value;
                }
                else if ( key == "gtfs-lon")
                {
                    gpx_lon = value;
                }
            }

            gpx_lat_array[i] = gpx_lat;
            gpx_lon_array[i] = gpx_lon;
            label_string     = '';

            for ( var k = 0; k < i; k++ ) {
                if ( gpx_lat_array[k] == gpx_lat && gpx_lon_array[k] == gpx_lon ) {
                    label_string += (k+1) + '+';
                }
            }

            label_string += (i+1);
            L.circle([gpx_lat,gpx_lon],{color:colours['platform'],radius:0.75,fill:true}).addTo(layerplatforms);
            L.marker([gpx_lat,gpx_lon],{color:colours['platform'],icon:icons['platform']}).bindTooltip(label_string.toString(),{permanent:true,direction:'center'}).bindPopup("Platform " + label_string.toString() + ': ' + gpx_name).addTo(layerplatforms);

            polyline_array.push( [gpx_lat, gpx_lon] );

        }
    }


    var sh_table = document.getElementById( "gtfs-shape" );

    if ( sh_table ) {

        polyline_array = [];

        var sh_listnode = sh_table.getElementsByTagName( "tbody" )[0];
        var sh_list     = sh_listnode.getElementsByTagName( "tr" );

        //    evaluate all gtfs-shape rows
        for ( var i = 0; i < sh_list.length; i++ )
        {
            var sh_node    = sh_list[i];
            var sub_td     = sh_node.getElementsByTagName( "td" );

            var gpx_lat  = "-1";
            var gpx_lon  = "-1";

            //    evaluate all columns of gtfs-single-trip rows
            for ( var j = 0; j < sub_td.length; j++ )
            {
                var keyvalue = sub_td[j];


                if ( keyvalue.firstChild ) {
                    var value = keyvalue.firstChild.data;
                }
                else {
                    var value = "-1";
                }

                var key = keyvalue.getAttribute("class");

                if ( key == "gtfs-lat" )
                {
                    gpx_lat  = value;
                }
                else if ( key == "gtfs-lon")
                {
                    gpx_lon = value;
                }
            }

            polyline_array.push( [gpx_lat, gpx_lon] );

        }
    }

    var route = L.polyline(polyline_array,{color:colours['platform'],weight:3,fill:false}).bindPopup("Platform Route").addTo( layerplatformsroute );

    map.fitBounds(route.getBounds());

}
