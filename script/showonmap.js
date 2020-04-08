//
//
//

function showtriponmap() {

	var mymap = L.map('mapid').setView([48.0649, 11.6612], 16);
	
    L.tileLayer( 'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',
                {
                 maxZoom: 19,
                 attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
                }
               ).addTo(mymap);

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

                if ( key == "gtfs-name" )
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
            L.marker([gpx_lat, gpx_lon]).bindTooltip(label_string,{permanent: true}).bindPopup(label_string + ': ' + gpx_name).addTo(mymap);

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

    var route = L.polyline(polyline_array).addTo(mymap);

    mymap.fitBounds(route.getBounds());

}
