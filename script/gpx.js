

function gpxdownload() {

    var feed                = document.getElementById("feed").firstChild.data;
    var route_short_name    = document.getElementById("route_short_name").firstChild.data;
    var trip_id             = document.getElementById("trip_id").firstChild.data;

    //   fill Meta data
    var metadata     = "";
    metadata        += "  <name>" + feed + ", Linie " + route_short_name + "</name>\r\n"
    metadata        += "  <cmt>Trip-Id = " + trip_id + "</cmt>\r\n"
    metadata        += "  <desc>GTFS Analysis for " + feed + "</desc>\r\n"
    metadata        += "  <src>https://ptna.openstreetmap.de/gtfs/index.html</src>\r\n"
    metadata        += "  <link>https://ptna.openstreetmap.de/</link>\r\n"

    var filename = feed + "_Route_" + route_short_name + "_Trip_" + trip_id + ".gpx";
        filename = filename.replace(/[^A-Za-z0-9_.-]/g,'_');

    //    <time> xsd:dateTime </time>
    var dateobj  = new Date();
    var date     = dateobj.toISOString();
    metadata    += "  <time>" + date + "</time>\r\n"

    var wpt = "";
    var trk = "";

    var wp_table = document.getElementById( "gtfs-single-trip" );

    if ( wp_table ) {

        var wp_listnode = wp_table.getElementsByTagName( "tbody" )[0];
        var wp_list     = wp_listnode.getElementsByTagName( "tr" );

        //    evaluate all gtfs-single-trip rows
        for ( var i = 0; i < wp_list.length; i++ )
        {
            var wp_node    = wp_list[i];
            var sub_td     = wp_node.getElementsByTagName( "td" );

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

                if ( key == "gtfs-stop-name"  )
                {
                    gpx_name = (i+1) + ': ' +  value.replace(/&/g, "&amp;")
                                                    .replace(/</g, "&lt;")
                                                    .replace(/>/g, "&gt;")
                                                    .replace(/"/g, "&quot;")
                                                    .replace(/'/g, "&#039;");
                }
                else if ( key == "gtfs-stop-name normalized-name" ) {
                    value = keyvalue.firstChild.firstChild.data;
                    gpx_name = (i+1) + ': ' +  value.replace(/&/g, "&amp;")
                                                    .replace(/</g, "&lt;")
                                                    .replace(/>/g, "&gt;")
                                                    .replace(/"/g, "&quot;")
                                                    .replace(/'/g, "&#039;");
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

            wpt += " <wpt lat=\"" + gpx_lat + "\" lon=\"" + gpx_lon + "\"><name>" + gpx_name + "</name></wpt>\r\n";
            trk += "    <trkpt lat=\"" + gpx_lat + "\" lon=\"" + gpx_lon + "\"></trkpt>\r\n";

        }
    }


    var sh_table = document.getElementById( "gtfs-shape" );

    if ( sh_table ) {

        trk = "";

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

            trk += "    <trkpt lat=\"" + gpx_lat + "\" lon=\"" + gpx_lon + "\"></trkpt>\r\n";

        }
    }


    //    compile GPS output
    var gpx_gesamt=`<?xml version="1.0" encoding="UTF-8" standalone="no" ?>\r\n<gpx xmlns="https://www.topografix.com/GPX/1/1" xmlns:xsi="https://www.w3.org/2001/XMLSchema-instance" version="1.1">\r\n <metadata>\r\n${metadata} </metadata>\r\n${wpt} <trk>\r\n  <trkseg>\t\n${trk}  </trkseg>\r\n </trk>\r\n</gpx>`;



    // create file

    var element = document.createElement('a');
    element.setAttribute( 'href', 'data:text/plain;charset=utf-8,' + encodeURIComponent(gpx_gesamt) );
    element.setAttribute('download', filename);

    element.style.display = 'none';
    document.body.appendChild(element);

    element.click();

    document.body.removeChild(element);

}


function gpxdownloadforshape() {

    var feed                = document.getElementById("feed").firstChild.data;
    var shape_id            = document.getElementById("shape_id").firstChild.data;

    //   fill Meta data
    var metadata     = "";
    metadata        += "  <name>" + feed + ", Shape " + shape_id + "</name>\r\n"
    metadata        += "  <desc>GTFS Analysis for " + feed + "</desc>\r\n"
    metadata        += "  <src>https://ptna.openstreetmap.de/gtfs/index.html</src>\r\n"
    metadata        += "  <link>https://ptna.openstreetmap.de/</link>\r\n"

    var filename = feed + "_Shape_" + shape_id + ".gpx";
        filename = filename.replace(/[^A-Za-z0-9_.-]/g,'_');

    //    <time> xsd:dateTime </time>
    var dateobj  = new Date();
    var date     = dateobj.toISOString();
    metadata    += "  <time>" + date + "</time>\r\n"

    var sh_table = document.getElementById( "gtfs-shape" );

    if ( sh_table ) {

        trk = "";

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

            trk += "    <trkpt lat=\"" + gpx_lat + "\" lon=\"" + gpx_lon + "\"></trkpt>\r\n";

        }
    }


    //    compile GPS output
    var gpx_gesamt=`<?xml version="1.0" encoding="UTF-8" standalone="no" ?>\r\n<gpx xmlns="https://www.topografix.com/GPX/1/1" xmlns:xsi="https://www.w3.org/2001/XMLSchema-instance" version="1.1">\r\n <metadata>\r\n${metadata} </metadata>\r\n$<trk>\r\n  <trkseg>\r\n${trk}  </trkseg>\r\n </trk>\r\n</gpx>`;



    // create file

    var element = document.createElement('a');
    element.setAttribute( 'href', 'data:text/plain;charset=utf-8,' + encodeURIComponent(gpx_gesamt) );
    element.setAttribute('download', filename);

    element.style.display = 'none';
    document.body.appendChild(element);

    element.click();

    document.body.removeChild(element);

}
