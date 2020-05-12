//
//
//
const OSM_API_URL_PREFIX = 'https://api.openstreetmap.org/api/0.6/relation/';
const OSM_API_URL_SUFFIX = '/full.json';

var relationmap;

function showrelation( relation_id ) {

    relationmap = L.map('relationmap').setView([48.0649, 11.6612], 10);

    L.tileLayer( 'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',
                {
                 maxZoom: 19,
                 attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
                }
               ).addTo(relationmap);

    if ( relation_id.toString().match(/^\d+$/) ) {

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

    var osm_data = JSON.parse( responseText.toString() )
    // relationmap.fitBounds(route.getBounds());

    console.log( '>' + osm_data["version"] + "<" );
    console.log( '>' + osm_data["generator"] + "<" );
    console.log( '>' + osm_data["copyright"] + "<" );
    console.log( '>' + osm_data["attribution"] + "<" );
    console.log( '>' + osm_data["license"] + "<" );
    console.log( '>' + osm_data["elements"][0]["type"] + "<" );

//    for ( var i = 0; i < osm_data["elements"].length; i++ ) {
//        console.log( ">[" + i + "] type = " + osm_data["elements"][i]["type"] + ", id = " + osm_data["elements"][i]["id"] + "<" );
//    }
}
