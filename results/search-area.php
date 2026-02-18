<!DOCTYPE html>
<?php   include( '../script/globals.php'     );
        include( '../script/parse_query.php' );
        include( '../script/config.php' );
        $lang_dir="../$ptna_lang/";
        if ( !is_dir($lang_dir) ) {
            $lang_dir="../en/";
        }
?>
<html lang="<?php echo $html_lang ?>">

<?php   $lang_title=                        "Search Area";
        $lang_name=                         "Name";
        $lang_region=                       "City / Region";
        $lang_network=                      "Network";
        $lang_download=                     "Download area details from Overpass-API";
        $lang_overpass_api=                 "Search area for Overpass-API query";
        $lang_overpass_api_description=     "Lore ipsum ...\n";
        $lang_osmium_extract=               "Search area for 'osmium extract'";
        $lang_osmium_extract_description=   "Lore ipsum ...\n";
        $lang_osmium_getid_description=     "Lore ipsum ...\n";

        if ( is_file($lang_dir.'search-area.inc') ) {
            include($lang_dir.'search-area.inc');
        } elseif ( is_file('../en/search-area.inc') ) {
            include('../en/search-area.inc');
        }

        $title=$lang_title;
        include $lang_dir.'html-head.inc';
?>

    <body>
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
        <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

        <script src="/script/search-area.js"></script>

<?php
        $found = ReadDetails( $network );
?>
        <script> const ptna_network        = '<?php echo $network; ?>';
                 const network_region      = '<?php echo urlencode(GetRegionName()); ?>';
                 const network_name        = '<?php echo urlencode(GetNetworkName()); ?>';
                 const network_link        = '<?php echo urlencode(GetNetworkLink()); ?>';
                 const overpass_api_area   = '<?php echo urlencode(GetOverpassSearchArea()); ?>';
                 const osmium_extract_name = '<?php echo urlencode(GetExtractSearchName()); ?>';
                 const osmium_extract_data = '<?php echo urlencode(preg_replace('/  */',' ',GetExtractSearchData())); ?>';
                 const osmium_getid_name   = '<?php echo urlencode(GetExtractGetidName()); ?>';
                 const osmium_getid_data   = '<?php echo urlencode(preg_replace('/  */',' ',GetExtractGetidData())); ?>';
        </script>

        <div id="wrapper">

<?php include $lang_dir.'header.inc' ?>

        <main id="main" class="map">

            <div id="searchareamap"></div>
            <div class="searchareas">
                <h3 id="searchareas">PTNA <?php echo $lang_title; ?></h3>
                <div class="indent">
                    <table>
                        <tbody>
                            <tr><th class="results-network"><?php echo $lang_name; ?></th><td><span id="ptna-network"><?php echo $network; ?></span></td></tr>
                            <tr><th class="results-region"><?php echo $lang_region; ?></th><td><span id="network-region"><?php echo htmlentities(GetRegionName()); ?></span></td></tr>
                            <tr><th class="results-text"><?php echo $lang_network; ?></th><td><span id="network-name"><?php echo htmlentities(GetNetworkName()); ?></span></td></tr>
                        </tbody>
                    </table>

                    <h4 id="overpass-api"><span style="display: inline-block; width:21px; background-color: blue;">&nbsp;</span> <?php echo $lang_overpass_api; ?></h4>
                        <div class="indent">
                            <?php echo $lang_overpass_api_description; ?>
<?php if ( !preg_match('/^poly/',GetOverpassSearchArea()) ) { ?>
                            <p id="progress_section"><?php echo $lang_download; ?>: <progress id="download" value=0 max=2000></progress> <span id="download_text">0</span> ms</p>
                            <p><code><?php echo htmlentities(preg_replace('/^[a-z]*/','relation',urldecode(GetOverpassSearchArea()))); ?></code></p>
<?php } ?>
                        </div>
<?php if ( GetExtractSearchName() ) { ?>
                    <h4 id="osmium-extract"><span style="display: inline-block; width:21px; background-color: black;">&nbsp;</span> <?php echo $lang_osmium_extract; ?></h4>
                        <div class="indent">
                            <?php echo $lang_osmium_extract_description; ?>
                            <p><code>https://polygons.openstreetmap.fr/get_poly.py?id=</code>relation-ID<code>&amp;params=0.02000-0.00500-0.00500</code></p>
                        </div>
<?php } ?>

<?php if ( GetExtractGetidName() ) { ?>
                    <h4 id="osmium-getid"><span style="display: inline-block; width:21px; background-color: green;">&nbsp;</span> <?php echo $lang_osmium_getid; ?></h4>
                        <div class="indent">
                            <?php echo $lang_osmium_getid_description; ?>
                            <p><code>https://polygons.openstreetmap.fr/get_poly.py?id=</code>relation-ID<code>&amp;params=0.20000-0.00050-0.00050</code></p>
                        </div>
<?php } ?>
                </div>
            </div>
            <script>
                create_map( network_region, osmium_extract_name, osmium_getid_name );
                show_osmium_getid_area(   osmium_getid_data,   osmium_getid_name   );
                show_osmium_extract_area( osmium_extract_data, osmium_extract_name );
                show_overpass_api_area(   overpass_api_area,   network_region      );
            </script>

        </main> <!-- main -->

        <hr class="clearing" />

<?php include $lang_dir.'footer.inc' ?>

        </div> <!-- wrapper -->

    </body>
</html>
