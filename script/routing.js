//
//
//

function callBrouterDe( lang, unit ) {

    //
    // example: https://brouter.de/brouter-web/#map=12/48.0895/11.6440/standard&profile=car-eco&lonlats=11.661428,48.040968;11.65875,48.046366;11.655041,48.051508;11.661406,48.052462;11.66506,48.053795;11.66769,48.055772;11.665481,48.059129;11.663654,48.061597;11.661231,48.06498;11.658904,48.067905;11.656117,48.071288;11.653722,48.074293;11.651547,48.078361;11.644049,48.089463
    //

    const BrouterDe_Url = 'https://brouter.de/brouter-web/#map=';

    var stop_table = document.getElementById( "gtfs-single-trip" );

    var zoom_level = "12";
    var focus_lon  = "0.0";
    var focus_lat  = "0.0";
    var stops = "";

    if ( stop_table ) {

        var stop_listnode = stop_table.getElementsByTagName( "tbody" )[0];
        var stop_list     = stop_listnode.getElementsByTagName( "tr" );

        //    evaluate all gtfs-single-trip rows
        for ( var i = 0; i < stop_list.length; i++ )
        {
            var stop_node  = stop_list[i];
            var sub_td     = stop_node.getElementsByTagName( "td" );

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

            if ( stops == '' ) {
                zoom_level = "12";
                focus_lon  = gpx_lon;
                focus_lat  = gpx_lat;
                stops += "&lonlats=" + gpx_lon + ","+ gpx_lat;
            } else {
                stops += ";" + gpx_lon + ","+ gpx_lat;
            }

        }

        var url = `${BrouterDe_Url + zoom_level}/${focus_lat}/${focus_lon}/standard&profile=car-eco${stops}`;

        // console.log( 'Url: ' + url );

        var BrouterDe_window = window.open( url, '_blank' );

    }
}


function callGraphHopperCom( lang, unit ) {

    //
    // example: https://graphhopper.com/maps/?point=48.0409683110054%2C11.6614280160552&point=48.0463655186021%2C11.6587504785824&point=48.0515077526329%2C11.6550412219119&point=48.0524619811994%2C11.6614064633181&point=48.0537947184981%2C11.6650598307353&point=48.0557719221425%2C11.6676897375637&point=48.059129099637%2C11.6654814222769&point=48.0615969900852%2C11.6636542639945&point=48.0649804337512%2C11.6612305886031&point=48.067905442462%2C11.6589035446008&point=48.0712876988587%2C11.6561169596617&point=48.0742933373265%2C11.6537217015341&point=48.0783608239527%2C11.6515471512156&point=48.0894628087646%2C11.6440490755247&locale=de&vehicle=car&weighting=fastest&elevation=true&use_miles=false&layer=OpenStreetMap
    //

    const GraphHopperCom_Url = ' https://graphhopper.com/maps/?';

    var stop_table = document.getElementById( "gtfs-single-trip" );

    var stops = "";

    if ( stop_table ) {

        var stop_listnode = stop_table.getElementsByTagName( "tbody" )[0];
        var stop_list     = stop_listnode.getElementsByTagName( "tr" );

        //    evaluate all gtfs-single-trip rows
        for ( var i = 0; i < stop_list.length; i++ )
        {
            var stop_node  = stop_list[i];
            var sub_td     = stop_node.getElementsByTagName( "td" );

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

            if ( stops == '' ) {
                stops += "point=" + gpx_lat + ","+ gpx_lon;
            } else {
                stops += "&point=" + gpx_lat + ","+ gpx_lon;
            }

        }

        var url = `${GraphHopperCom_Url + stops}&locale=${lang}&vehicle=car&weighting=fastest&elevation=true&use_miles=false&layer=OpenStreetMap`;

        // console.log( 'Url: ' + url );

        var GraphHopperCom_window = window.open( url, '_blank' );

    }
}


function callOpenRouteServiceOrg( lang, unit ) {

    //
    // example: https://maps.openrouteservice.org/directions?n1=48.04871&n2=11.74078&n3=12&a=48.040968,11.661428,48.046366,11.65875,48.051508,11.655041,48.052462,11.661406,48.053795,11.66506,48.055772,11.66769,48.059129,11.665481,48.061597,11.663654,48.06498,11.661231,48.067905,11.658904,48.071288,11.656117,48.074293,11.653722,48.078361,11.651547,48.089463,11.644049&b=0&c=0&k1=de&k2=km
    //

    const OpenRouteServiceOrg_Url = 'https://maps.openrouteservice.org/directions?';

    var stop_table = document.getElementById( "gtfs-single-trip" );

    var zoom_level = "12";
    var focus_lon  = "0.0";
    var focus_lat  = "0.0";
    var stops = "";

    if ( stop_table ) {

        var stop_listnode = stop_table.getElementsByTagName( "tbody" )[0];
        var stop_list     = stop_listnode.getElementsByTagName( "tr" );

        //    evaluate all gtfs-single-trip rows
        for ( var i = 0; i < stop_list.length; i++ )
        {
            var stop_node  = stop_list[i];
            var sub_td     = stop_node.getElementsByTagName( "td" );

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

            if ( stops == '' ) {
                zoom_level = "12";
                focus_lon  = gpx_lon;
                focus_lat  = gpx_lat;
                stops += "&a=" + gpx_lat + ","+ gpx_lon;
            } else {
                stops += "," + gpx_lat + ","+ gpx_lon;
            }

        }

        var url = `${OpenRouteServiceOrg_Url}n1=${focus_lat}&n2=${focus_lon}&n3=${zoom_level}${stops}&b=0&c=0&k1=${lang}&k2=${unit}`;

        //console.log( 'Url: ' + url );

        var OpenRouteServiceOrg_window = window.open( url, '_blank' );

    }
}
