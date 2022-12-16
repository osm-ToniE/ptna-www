<!DOCTYPE html>
<html lang="sr">

<?php $title="Configuration"; include('html-head.inc'); ?>

<?php include('../script/config.php'); ?>

    <body>

<?php if ( isset($_GET['network']) ) { $found = ReadDetails( $_GET['network'] ); } else { $found = ''; } ?>

      <div id="wrapper">

<?php include "header.inc" ?>

        <nav id="navigation">
            <h2 id="de">Configuration details <?php if ( $found ) { printf( "for %s", $_GET['network'] ); } ?></h2>
            <ul>
                <li><a href="#overpass-api">Overpass-API Query</a></li>
                <li><a href="#options">Analysis options</a></li>
                <li><a href="#discussion">Discussion</a>
                    <ul>
                        <li><a href="#discussion-ptna">General discussion for PTNA</a></li>
                        <li><a href="#discussion-network">Discussion for this analysis</a></li>
                    </ul>
                </li>
             </ul>
        </nav>

        <hr />

        <main id="main" class="results">

            <h2 id="overpass-api">Overpass-API Query</h2>
            <div class="indent">

                <p>
                    The <a href="https://wiki.openstreetmap.org/wiki/Overpass_API">Overpass API</a> is used to download the OSM data.
                    <a href="/en/index.php#overpass">The query used</a> returns all ways and nodes of the routes (their members with their details) from a defined <a href="/en/index.php#searcharea">search area</a>.
                    The data thus obtained allow an analysis of the public transport lines to the effect that e.g. the route can also be checked for completeness.
                    Nodes, ways and relations (stops and platforms) and their tags can be checked against their 'role' in the relation.
                </p>

                <?php if ( $found ) {
                          $query = htmlentities( GetOverpassQuery() );
                          $fsize = GetOsmXmlFileSizeByte();
                          $rlink = GetRegionLink();
                          $rname = htmlentities( GetRegionName() );
                          if ( $query ) { printf( "<p><code>%s</code></p>\n", $query ); }
                          if ( $fsize ) { printf( "<p>This query currently delivers approximately %.3f MB.\n</p>", $fsize / 1024 / 1024 ); }
                          if ( $rlink ) {
                              printf( "<p>Show the <a href=\"/en/index.php#searcharea\">search area</a> " );
                              if ( $rname ) { printf( "\"<strong>%s</strong>\" ", $rname ); }
                              printf( "on the <a href=\"%s\">OSM map</a>.</p>\n", $rlink );
                          }
                      }
                ?>
            </div>

            <hr />

            <h2 id="options">Analysis options</h2>
            <div class="indent">

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
            </div>

            <hr />

            <h2 id="discussion">Discussion</h2>
            <div class="indent">

                <p>
                </p>

                <h3 id="discussion-ptna">General discussion for PTNA</h3>
                <div class="indent">

                    <p>
                        <?php $link = GetDiscussionPagePtna();
                              if ( $link ) {
                                  printf( "<a href=\"%s\">General discussion for PTNA</a> in the OSM Wiki.", $link );
                              } else {
                                  echo "???";
                              }
                        ?>
                    </p>
                </div>

                <h3 id="discussion-network">Diskussion for this analysis</h3>
                <div class="indent">

                    <p>
                        <?php $link = GetDiscussionPageNetwork();
                              if ( $link ) {
                                  printf( "<a href=\"%s\">Diskussion for this analysis</a>, this 'network' in the OSM Wiki.", $link );
                              } else {
                                  echo "???";
                              }
                        ?>
                    </p>
                </div>
            </div>

        </main> <!-- main -->

        <hr />

<?php include "footer.inc" ?>

      </div> <!-- wrapper -->
    </body>
</html>
