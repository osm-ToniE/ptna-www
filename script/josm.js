
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


function route_master_osm() {

    var feed                = document.getElementById( "feed" ).firstChild.data;
    var route_short_name    = document.getElementById( "route_short_name" ).firstChild.data;
    var relation_table      = document.getElementById( "osm-route-master" );

    if ( relation_table ) {

        var relation_tablebody = relation_table.getElementsByTagName( "tbody" )[0];
        var tag_list           = relation_tablebody.getElementsByTagName( "tr" );

        var osm_xml;

        osm_xml  = "<?xml version='1.0' encoding='UTF-8'?>\r\n";
        osm_xml += "<osm version='0.6' upload='never' generator='PTNA-GTFS'>\r\n";
        osm_xml += "    <relation id='-3000' action='create'>\r\n";

        //    evaluate all osm-route-master rows

        for ( var i = 0; i < tag_list.length; i++ )
        {
            var tag_node   = tag_list[i];
            var sub_td     = tag_node.getElementsByTagName( "td" );

            // evaluate 1st and 2nd column of osm-route-master rows



            osm_xml += "        <tag k='" +  sub_td[0].innerText.replace(/&/g, "&amp;")
                                                                .replace(/</g, "&lt;")
                                                                .replace(/>/g, "&gt;")
                                                                .replace(/"/g, "&quot;")
                                                                .replace(/'/g, "&#039;")
                                + "' v='" +  sub_td[1].innerText.replace(/&/g, "&amp;")
                                                                .replace(/</g, "&lt;")
                                                                .replace(/>/g, "&gt;")
                                                                .replace(/"/g, "&quot;")
                                                                .replace(/'/g, "&#039;")
                                + "' />\r\n";
        }

        osm_xml += "    </relation>\r\n";
        osm_xml += "</osm>\r\n";

        // create file

        var filename = feed + "_Route_Master_" + route_short_name + ".osm";
        var element  = document.createElement('a');
        element.setAttribute( 'href', 'data:text/plain;charset=utf-8,' + encodeURIComponent(osm_xml) );
        element.setAttribute('download', filename);

        element.style.display = 'none';
        document.body.appendChild(element);

        element.click();

        document.body.removeChild(element);
    }

}


function copy_to_clipboard( id, success_msg, error_msg ) {

    var relation_table      = document.getElementById( id );

    if ( relation_table ) {

        var relation_tablebody = relation_table.getElementsByTagName( "tbody" )[0];
        var tag_list           = relation_tablebody.getElementsByTagName( "tr" );

        var clipboard;
        var key;
        var value;

        clipboard  = "";

        //    evaluate all rows

        for ( var i = 0; i < tag_list.length; i++ )
        {
            var tag_node   = tag_list[i];
            var sub_td     = tag_node.getElementsByTagName( "td" );

            // evaluate 1st and 2nd column of rows

            key   = sub_td[0].innerText;
            value = sub_td[1].innerText;

            if ( key === 'colour' &&
                 (value.toLowerCase() === '#ffffff'.toLowerCase() ||
                  value.toLowerCase() === '#fff'.toLowerCase()      ) )
            {
                continue;
            }
            clipboard += key + '=' + value + "\r\n";
        }

        navigator.clipboard.writeText(clipboard);

        // if ( success_msg ) {
        //     alert( success_msg + ":\r\n" + clipboard );
        // } else {
        //     alert( "Copied to Clipboard:\r\n\r\n" + clipboard );
        // }
    } else {
        if ( error_msg ) {
            alert( error_msg + ": " + id );
        } else {
            alert( "Could not find table with ID: " + id );
        }
    }

}


function route_osm() {

    var feed                = document.getElementById( "feed" ).firstChild.data;
    var route_short_name    = document.getElementById( "route_short_name" ).firstChild.data;
    var trip_id             = document.getElementById( "trip_id" ).firstChild.data;
    var stop_table          = document.getElementById( "gtfs-single-trip" );
    var relation_table      = document.getElementById( "osm-route" );

    var osm_xml     = "";
    var member_list = "";

    if ( stop_table || relation_table ) {
        osm_xml  = "<?xml version='1.0' encoding='UTF-8'?>\r\n";
        osm_xml += "<osm version='0.6' upload='never' generator='PTNA-GTFS'>\r\n";
    }

    if ( stop_table ) {

        var stop_listnode = stop_table.getElementsByTagName( "tbody" )[0];
        var stop_list     = stop_listnode.getElementsByTagName( "tr" );

        var lat                 = "";
        var lon                 = "";
        var stop_name           = "";
        var stop_id             = "";
        var node_id             = -10000;
        var node_id_of_stop_id  = {};

        //    evaluate all gtfs-single-trip rows

        for ( var i = 0; i < stop_list.length; i++ ) {
            var stop_node  = stop_list[i];
            var sub_td     = stop_node.getElementsByTagName( "td" );

            //    evaluate all columns of gtfs-single-trip rows

            for ( var j = 0; j < sub_td.length; j++ ) {
                var keyvalue = sub_td[j];

                if ( keyvalue.firstChild ) {
                    var value = keyvalue.firstChild.data;
                }
                else {
                    var value = "";
                }

                var key = keyvalue.getAttribute("class");

                if ( key == "gtfs-lat" ) {
                    lat = value;
                }
                else if ( key == "gtfs-lon") {
                    lon = value;
                }
                else if ( key == "gtfs-stop-name") {
                    stop_name =    value.replace(/&/g, "&amp;")
                                        .replace(/</g, "&lt;")
                                        .replace(/>/g, "&gt;")
                                        .replace(/"/g, "&quot;")
                                        .replace(/'/g, "&#039;");;
                }
                else if ( key == "gtfs-id") {
                    stop_id =  value.replace(/&/g, "&amp;")
                                    .replace(/</g, "&lt;")
                                    .replace(/>/g, "&gt;")
                                    .replace(/"/g, "&quot;")
                                    .replace(/'/g, "&#039;");;
                }
            }
            if ( lat && lon && stop_name && stop_id ) {
                if ( ! node_id_of_stop_id[stop_id] ) {
                    node_id_of_stop_id[stop_id] = node_id--;
                    osm_xml += "    <node id='" + node_id_of_stop_id[stop_id] + "' action='create' lat='" + lat + "' lon='" + lon + "'>\r\n";
                    osm_xml += "        <tag k='name' v='" + stop_name + "' />\r\n";
                    osm_xml += "        <tag k='gtfs:stop_id' v='" + stop_id + "' />\r\n";
                    osm_xml += "        <tag k='public_transport' v='platform' />\r\n";
                    osm_xml += "    </node>\r\n";
                }

                member_list += "        <member type='node' ref='" + node_id_of_stop_id[stop_id] + "' role='platform' />\r\n";
            }
        }
    }

    if ( relation_table ) {

        var relation_tablebody = relation_table.getElementsByTagName( "tbody" )[0];
        var tag_list           = relation_tablebody.getElementsByTagName( "tr" );

        osm_xml += "    <relation id='-4000' action='create'>\r\n";
        osm_xml += member_list;

        //    evaluate all osm-route rows

        for ( var i = 0; i < tag_list.length; i++ ) {
            var tag_node   = tag_list[i];
            var sub_td     = tag_node.getElementsByTagName( "td" );

            // evaluate 1st and 2nd column of osm-route rows

            osm_xml += "        <tag k='" +  sub_td[0].innerText.replace(/&/g, "&amp;")
                                                                .replace(/</g, "&lt;")
                                                                .replace(/>/g, "&gt;")
                                                                .replace(/"/g, "&quot;")
                                                                .replace(/'/g, "&#039;")
                                + "' v='" +  sub_td[1].innerText.replace(/&/g, "&amp;")
                                                                .replace(/</g, "&lt;")
                                                                .replace(/>/g, "&gt;")
                                                                .replace(/"/g, "&quot;")
                                                                .replace(/'/g, "&#039;")
                                 + "' />\r\n";
        }

        osm_xml += "    </relation>\r\n";

    }

    if ( stop_table || relation_table ) {

        osm_xml += "</osm>\r\n";

        // create file

        var filename = feed + "_Route_" + route_short_name + "_" + trip_id + ".osm";
        var element  = document.createElement('a');
        element.setAttribute( 'href', 'data:text/plain;charset=utf-8,' + encodeURIComponent(osm_xml) );
        element.setAttribute('download', filename);

        element.style.display = 'none';
        document.body.appendChild(element);

        element.click();

        document.body.removeChild(element);
    }
}
