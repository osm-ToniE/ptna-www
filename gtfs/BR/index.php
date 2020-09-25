<!DOCTYPE html>
<?php   include( '../../script/globals.php'     );
        include( '../../script/gtfs.php'        );
        include( '../../script/parse_query.php' );
?>
<html lang="<?php echo $html_lang ?>">

<?php $title="GTFS Análise"; $lang_dir="../../$ptna_lang/"; include $lang_dir.'html-head.inc'; ?>

    <body>
      <div id="wrapper">
<?php include $lang_dir.'header.inc' ?>
<?php $duration = 0; ?>
        <main id="main" class="results">

            <h2 id="BR"><a href="index.php"><img src="/img/Brasil32.png" alt="bandeira do brasil" /></a> GTFS Análise sobre Brasil</h2>
            <div class="indent">
<?php include $lang_dir.'gtfs-head.inc' ?>
                <table id="gtfsBR">
                    <thead>
<?php include $lang_dir.'gtfs-trth.inc' ?>
                    </thead>
                    <tbody>
<?php
    $duration += CreateGtfsEntry( "BR-MG-BHTrans-Convencional" );

    $duration += CreateGtfsEntry( "BR-MG-BHTrans-Suplementar" );
?>
                    </tbody>
                </table>

                <?php printf( "<p>As consultas SQL levaram %f segundos para serem concluídas</p>\n", $duration ); ?>
            </div>
        </main> <!-- main -->

        <hr />

<?php include $lang_dir.'gtfs-footer.inc' ?>

      </div> <!-- wrapper -->
    </body>
</html>
