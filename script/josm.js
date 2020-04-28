
function josm_load_and_zoom_stops() {

    var stop_table = document.getElementById( "gtfs-single-trip" );

    var url = '';

    if ( stop_table ) {

        var stop_listnode = stop_table.getElementsByTagName( "tbody" )[0];
        var stop_list     = stop_listnode.getElementsByTagName( "tr" );

        //    evaluate all gtfs-single-trip rows backwards, so that we stop at the start of the route
        for ( var i = stop_list.length-1; i >= 0; i-- )
        {
            var stop_node  = stop_list[i];
            var sub_td     = stop_node.getElementsByTagName( "td" );

            var lat  = "";
            var lon  = "";

            //    evaluate all columns of gtfs-single-trip rows
            for ( var j = 0; j < sub_td.length; j++ )
            {
                var keyvalue = sub_td[j];


                if ( keyvalue.firstChild ) {
                    var value = keyvalue.firstChild.data;
                }
                else {
                    var value = "";
                }

                var key = keyvalue.getAttribute("class");

                if ( key == "gtfs-lat" )
                {
                    lat = value;
                }
                else if ( key == "gtfs-lon")
                {
                    lon = value;
                }
            }

            resp = download_here( lat, lon, 15 );

            if ( !resp.match(/OK/) ) {
                return;
            }
        }
    }
}


function download_here( lat, lon, offset ) {

    const Http     = new XMLHttpRequest();
    const JOSM_Url = 'http://127.0.0.1:8111/load_and_zoom?new_layer=false';
    const R        = 6378137;                               // radius of earth in meters


    if ( lat != "" && lon != "" && offset > 0 ) {

        //offsets in meters
        dn = 10;
        de = 10;

        //Coordinate offsets in radians
        dLat = dn/R;
        dLon = de/(R*Math.cos(Math.PI*parseFloat(lat)/180));

        //OffsetPosition, decimal degrees
        top_lat    = parseFloat(lat) + dLat * 180/Math.PI;
        right_lon  = parseFloat(lon) + dLon * 180/Math.PI;
        bottom_lat = parseFloat(lat) - dLat * 180/Math.PI;
        left_lon   = parseFloat(lon) - dLon * 180/Math.PI;

        url = `${JOSM_Url}&left=${left_lon}&right=${right_lon}&top=${top_lat}&bottom=${bottom_lat}`;
        // console.log( 'Lat: ' + lat );
        // console.log( 'Lon: ' + lon );
        // console.log( 'Left: ' + left_lon );
        // console.log( 'Right: ' + right_lon );
        // console.log( 'Top: ' + top_lat );
        // console.log( 'Bottom: ' + bottom_lat );
        // console.log( 'Send: ' + url );
        Http.open( "GET", url, false );
        Http.send();

        Http.onreadystatechange = (e) => {
            console.log( '>' + Http.responseText + '<' );
        }
    }

    return Http.responseText;
}
