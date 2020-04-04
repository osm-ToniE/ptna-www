

function ptnalistdownload( include_agency ) {
    
    var network  = document.getElementById("network").firstChild.data;
    var filename = network + "-PTNA-CSV-List.txt";
         
    var ptna_list = "";
  
    var r_table = document.getElementById( "gtfs-routes" );
    
    if ( r_table ) {

        var r_listnode = r_table.getElementsByTagName( "tbody" )[0];
        var r_list     = r_listnode.getElementsByTagName( "tr" );
    
        //    evaluate all gtfs-routes rows
        for ( var i = 0; i < r_list.length; i++ ) {

            var r_node    = r_list[i];
            var sub_span  = r_node.getElementsByTagName( "span" );
        
            var route_short_name    = "unknown";
            var route_type          = "bus";
            var route_long_name     = "unknown";
            var agency_name         = "unknown";
            
            //    evaluate all columns of gtfs-routes rows
            for ( var j = 0; j < sub_span.length; j++ )
            {
                var keyvalue = sub_span[j];
              
                if ( keyvalue.firstChild ) {
                    var value = keyvalue.firstChild.data;
                } else {
                    var value = "-1";
                }
              
                var key = keyvalue.getAttribute("class");
              
                if ( key == "route_short_name" ) {
                    if ( value.match(';') != null ) {
                        route_short_name = '"' + value + '"';
                    } else {
                        route_short_name = value;
                    }
                } else if ( key == "route_type" ) {
                    value = value.toLowerCase();
                    if ( value.match('trolleybus') != null ) {
                        value = 'trolleybus';
                    } else if ( value.match('demand and response bus') != null ) {
                        value = 'share_taxi';
                    } else if ( value.match('bus') != null ) {
                        value = 'bus';
                    } else if ( value.match('monorail') != null ) {
                        value = 'monorail';
                    } else if ( value.match('frerry') != null || value.match('water transport service') != null ) {
                        value = 'ferry';
                    } else if ( value.match('rail') != null ) {
                        value = 'train';
                    } else if ( value.match('tram') != null ) {
                        value = 'tram';
                    } else if ( value.match('funicular') != null ) {
                        value = 'funicular';
                    } else if ( value.match('metro') != null || value.match('subway') != null || value.match('underground') != null ) {
                        value = 'subway';
                    } else {
                        value = 'bus';
                    }
                    if ( value.match(';') != null ) {
                        route_type = '"' + value + '"';
                    } else {
                        route_type = value;
                    }
                } else if ( key == "route_long_name")  {
                    if ( value.match(';') != null ) {
                        route_long_name = '"' + value + '"';
                    } else {
                        route_long_name = value;
                    }
                } else if ( key == "agency_name")  {
                    if ( value.match(';') != null ) {
                        agency_name = '"' + value + '"';
                    } else {
                        agency_name = value;
                    }
                }
            }
            
            if ( include_agency ) {
                ptna_list += route_short_name + ';' + route_type + ';' + route_long_name + ';;;' + agency_name + "\r\n";
            } else {
                ptna_list += route_short_name + ';' + route_type + ';' + route_long_name + ";;;\r\n";
            }
            
        }
    }
   
   
    // create file
     
    var element = document.createElement('a');
    element.setAttribute( 'href', 'data:text/plain;charset=utf-8,' + encodeURIComponent(ptna_list) );
    element.setAttribute('download', filename);
  
    element.style.display = 'none';
    document.body.appendChild(element);

    element.click();
  
    document.body.removeChild(element);
    
}
