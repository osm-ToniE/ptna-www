<!DOCTYPE html>
<?php
    $lang     = ( $_GET['lang'] && is_dir('./'.$_GET['lang']) ) ? $_GET['lang'] : 'en';
    $inc_lang = './' . $lang . '/';
?>
<html lang="<?php echo $lang; ?>">

<?php $title="OSM Relation"; include $inc_lang.'html-head.inc'; ?>

    <body>
      <link rel="stylesheet" href="https://unpkg.com/leaflet@1.6.0/dist/leaflet.css" integrity="sha512-xwE/Az9zrjBIphAcBb3F6JVqxf46+CDLwfLMHloNu6KEQCAWi6HcDUbeOfBIptF7tcCzusKFjFw2yuvEpDL9wQ==" crossorigin=""/>
      <script src="https://unpkg.com/leaflet@1.6.0/dist/leaflet.js" integrity="sha512-gZwIG9x3wUXg2hdXF6+rVkLF/0Vi9U8D2Ntg4Ga5I5BZpVkVxlJWbSQtXPSiUTtC0TjtGOmxa1AJPuV0CPthew==" crossorigin=""></script>

      <script src="/script/relation.js"></script>

      <div id="wrapper">

<?php include $inc_lang.'header.inc' ?>

        <main id="main" class="results">

            <div id="relationmap"></div>
            <div>
                <h3 id ="osm-relation">OSM Relation</h3>

                <table id="relationtable">
                    <thead class="results-tableheaderrow">
                        <tr>
                            <th class="results-name">Key</th>
                            <th class="results-name">Value</th>
                        </tr>
                    </thead>
                    <tbody id="relation-values" class="results-tablerow">
                    </tbody>
                </table>
            </div>
            <script>
                showrelation();
            </script>

        </main> <!-- main -->

        <hr class="clearing" />

<?php include $inc_lang.'footer.inc' ?>

      </div> <!-- wrapper -->

    </body>
</html>
