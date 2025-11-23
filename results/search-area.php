<!DOCTYPE html>
<?php   include( '../script/globals.php'     );
        include( '../script/parse_query.php' );
        include( '../script/config.php' );
        $lang_dir="../$ptna_lang/";
?>
<html lang="<?php echo $html_lang ?>">

<?php   $lang_title="Search Area";
        $lang_name="Name";
        $lang_region="City / Region";
        $lang_network="Network";
        $lang_download="Download area details from Overpass-API";
        $lang_overpass_api="Search area for Overpass-API query";
        $lang_osmium_extract="Search area for 'osmium extract'";
        $lang_osmium_getid="Search area for 'osmium getid'";

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
                            <tr><th><?php echo $lang_name; ?></th><td><span id="ptna-network"><?php echo $network; ?></span></td></tr>
                            <tr><th><?php echo $lang_region; ?></th><td><span id="network-region"><?php echo htmlentities(GetRegionName()); ?></span></td></tr>
                            <tr><th><?php echo $lang_network; ?></th><td><span id="network-name"><?php echo htmlentities(GetNetworkName()); ?></span></td></tr>
                        </tbody>
                    </table>

                    <h4 id="overpass-api"><?php echo $lang_overpass_api; ?></h4>
                        <div class="indent">
                            <span id="progress_section"><?php echo $lang_download; ?>: <progress id="download" value=0 max=5000></progress> <span id="download_text">0</span> ms</span>
                        </div>

                    <h4 id="osmium-extract"><?php echo $lang_osmium_extract; ?></h4>
                        <div class="indent">
                        </div>

                    <h4 id="osmium-getid"><?php echo $lang_osmium_getid; ?></h4>
                        <div class="indent">
                        </div>
                </div>
            </div>
            <script>
                create_map( network_region, osmium_extract_name, osmium_getid_name );
                show_osmium_getid_area(   osmium_getid_data   );
                show_osmium_extract_area( osmium_extract_data );
                show_overpass_api_area(   overpass_api_area  );
            </script>

        </main> <!-- main -->

        <hr class="clearing" />

<?php include $lang_dir.'footer.inc' ?>

        </div> <!-- wrapper -->

    </body>
</html>
