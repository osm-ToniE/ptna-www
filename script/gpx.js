

function gpxdownload() {
    
  var table = document.getElementById("gtfs-single-trip");
  var listnode = table.getElementsByTagName("tbody")[0];
  var liste = listnode.getElementsByTagName("tr");

  var network = document.getElementById("network").firstChild.data;
  var route_short_name = document.getElementById("route_short_name").firstChild.data;
  var trip_id = document.getElementById("trip_id").firstChild.data;
  
  
//   Metadaten befüllen
  var metadata = "";
  metadata += "  <name>" + network + ", Linie " + route_short_name + "</name>\r\n" 
  metadata += "  <cmt>Trip-Id = " + trip_id + "</cmt>\r\n"
  metadata += "  <desc>GTFS Analysen für " + network + "</desc>\r\n"
  metadata += "  <src>https://ptna.openstreetmap.de/gtfs/DE/index.php</src>\r\n"
  metadata += "  <link>https://ptna.openstreetmap.de/</link>\r\n"
 
  var filename = network + "_Linie_" + route_short_name + ".gpx";
     
  //    <time> xsd:dateTime </time> 
  var dateobj = new Date(); 
  var date = dateobj.toISOString(); 
  metadata += "  <time>" + date + "</time>\r\n"
      
  
  
  var wpt = "";
  var rte = "";
  
//    Alle Zeilen abarbeiten
   for (var i = 0; i < liste.length; i++)
   {
    var punkt = liste[i];
    var unterpunkt = punkt.getElementsByTagName("td");

    var gpx_name = "-unbekannt-";
    var gpx_lat = "-1";
    var gpx_lon = "-1";
    
//    Alle Spalten abarbeiten
    for (var j = 0; j < unterpunkt.length; j++)
    {
      var keyvalue = unterpunkt[j];
      
      
      if (keyvalue.firstChild) {
          var value = keyvalue.firstChild.data;
      }
      else {
          var value = "-1";
      }
      
      
      var key = keyvalue.getAttribute("class");
      
      
      if ( key == "gtfs-name") 
      {
          gpx_name = value;
      }
      else if ( key == "gtfs-lat") 
      {
          gpx_lat = value;
      }
      else if ( key == "gtfs-lon") 
      {
          gpx_lon = value;
      }
    }
    
    
    wpt += " <wpt lat=\"" + gpx_lat + "\" lon=\"" + gpx_lon + "\"><name>" + gpx_name + "</name></wpt>\r\n";
    rte += "  <rtept lat=\"" + gpx_lat + "\" lon=\"" + gpx_lon + "\"></rtept>\r\n";
    
    
   } 
   
   
//    GPX zusammenstellen
     var gpx_gesamt='<?xml version="1.0" encoding="UTF-8" standalone="no" ?>\r\n<gpx xmlns="http://www.topografix.com/GPX/1/1" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" version="1.1">\r\n <metadata>\r\n' + metadata + ' </metadata>\r\n' + wpt + ' <rte>\r\n' + rte + ' </rte>\r\n</gpx>';
    
   
   
// Datei erstellen:
     
  var element = document.createElement('a');
  element.setAttribute('href', 'data:text/plain;charset=utf-8,' + encodeURIComponent(gpx_gesamt));
  element.setAttribute('download', filename);
  
  element.style.display = 'none';
  document.body.appendChild(element);

  element.click();
  
  document.body.removeChild(element);
    
}
