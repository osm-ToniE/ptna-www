<!DOCTYPE html>
<html lang="en">

<?php include('html-head.inc'); ?>

<?php include('../script/config.php'); ?>

    <body>

<?php if ( isset($_GET['network']) ) { $found = ReadDetails( $_GET['network'] ); } ?>
        
    <body>
      <?php if ( isset($_GET['network']) ) { $found = ReadDetails( $_GET['network'] ); } ?>
        
      <div id="wrapper">
      
<?php include "header.inc" ?>

        <nav id="navigation">
            <h2 id="de">Configuration details <?php if ( $found ) { printf( "for %s", $_GET['network'] ); } ?></h2>
            <ul>
                <li><a href="#overpass-api">Overpass-API Query</a></li>
                <li><a href="#options">Analysis options</a></li>
             </ul>
        </nav>

        <hr />

        <main id="main" class="results">

            <h2 id="overpass-api">Overpass-API Query</h2>
            <p>
                The <a href="https://wiki.openstreetmap.org/wiki/Overpass_API">Overpass API</a> is used to download the OSM data.
                <a href="/en/index.php#overpass">The query used</a> returns all ways and nodes of the routes (their members with their details) from a defined <a href="/en/index.php#searcharea">search area</a>.
                The data thus obtained allow an analysis of the public transport lines to the effect that e.g. the route can also be checked for completeness.
                Nodes, ways and relations (stops and platforms) and their tags can be checked against their 'role' in the relation.
            </p>
            
            <?php if ( $found ) {
                      $query = htmlentities( GetOverpassQuery() );
                      $fsize = GetOsmXmlFileSize();
                      $rlink = GetRegionLink();
                      $rname = htmlentities( GetRegionName() );
                      if ( $query ) { printf( "<p><code>%s</code></p>\n", $query ); }
                      if ( $fsize ) { printf( "<p>This query currently delivers approximately %.1f MB.\n</p>", $fsize ); }
                      if ( $rlink ) { 
                          printf( "<p>Show the <a href=\"/de/index.php#searcharea\">search area</a> " );
                          if ( $rname ) { printf( "\"%s\" ", $rname ); }
                          printf( "on the <a href=\"%s\">OSM map</a>.</p>\n", $rlink );
                      }
                  }
            ?>

            <hr />

            <h2 id="options">Analysis options</h2>

            <p>
                The <a href="/en/index.php#messages">errors and comments</a> reported by PTNA can be controlled by a variety of <a href="/en/index.php#options">analysis options</a>.<br />
                Here is a list of analysis options and their values.<br />
            </p>

            <table id="message-table">
                <thead>
                    <tr class="message-tableheaderrow">
                        <th class="message-text">Option</th>
                        <th class="message-option">Value</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ( $found ) { PrintOptionDetails( "en" ); } ?>
                </tbody>
            </table>

        </main> <!-- main -->

        <hr />

<?php include "footer.inc" ?>

      </div> <!-- wrapper -->
    </body>
</html>

