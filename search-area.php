<!DOCTYPE html>
<?php
    include( 'script/globals.php'     );
    if ( isset($_GET['lang'])                              &&
         preg_match("/^[a-zA-Z0-9_-]+$/", $_GET['lang'])   &&
         is_dir($path_to_www.$_GET['lang'])                &&
         is_file($path_to_www.$_GET['lang'].'/header.inc')    ) {
        $lang = $_GET['lang'];
    } else {
        $lang = 'en';
    }
    $inc_lang = './' . $lang . '/';
?>
<html lang="<?php echo $lang; ?>">

<?php   $lang_title="Search Area";
        $lang_download="Download search area details from Overpass-API";
        $lang_overpass_api="Search area for Overpass-API query";
        $lang_osmium_extract="Planet extract area for 'osmium extract'";
        $lang_osmium_getid="Larger extract area for 'osmium getid'";

        if ( $lang == 'de' ) {
            $lang_title="Suchgebiet";
            $lang_download="Download Suchgebietdetails von Overpass-API";
            $lang_overpass_api="Suchgebiet für Overpass-API Anfragen";
            $lang_osmium_extract="Planet Teilgebiet für 'osmium extract'";
            $lang_osmium_getid="Größeres Teilgebiet für 'osmium getid'";
        }

        $title=$lang_title;
        include $inc_lang.'html-head.inc';
?>

    <body>
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
        <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

        <script src="/script/search-area.js"></script>

<?php
        echo "        <script> const overpass_api_query  = '[boundary=administrative][admin_level=8][wikidata=%27Q262669%27]'; </script>\n";
        echo "        <script> const osmium_extract_data = 'polygon 1   12.74        48.145   12.77        48.16   12.775       48.175   12.795       48.185   12.79        48.195   12.805       48.215   12.84        48.225   12.875       48.2   12.875       48.175   12.865       48.155   12.84        48.135   12.815       48.13   12.8         48.105   12.745       48.11   12.74        48.125   12.74        48.145 END END'; </script>\n";
        echo '        <script> const osmium_getid_data   = "polygon%5Cn1%5Cn  12.74        48.145%5CnEND%5CnEND%5Cn"; </script>' . "\n";
?>

        <div id="wrapper">

<?php include $inc_lang.'header.inc' ?>

        <main id="main" class="map">

            <div id="searchareamap"></div>
            <div class="searchareas">
                <h3 id="searchareas">PTNA <?php echo $lang_title; ?></h3>
                <div class="indent">

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
                create_map( overpass_api_query, osmium_extract_data, osmium_getid_data );
                show_osmium_getid_area(   osmium_getid_data   );
                show_osmium_extract_area( osmium_extract_data );
                show_overpass_api_area(   overpass_api_query  );
            </script>

        </main> <!-- main -->

        <hr class="clearing" />

<?php include $inc_lang.'footer.inc' ?>

        </div> <!-- wrapper -->

    </body>
</html>
