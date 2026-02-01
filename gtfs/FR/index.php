<!DOCTYPE html>
<?php   include( '../../script/globals.php'     );
        include( '../../script/parse_query.php' );
        include( '../../script/gtfs.php'        );
?>
<html lang="<?php echo $html_lang ?>">

<?php $title="GTFS Analysis"; $lang_dir="../../$ptna_lang/"; include $lang_dir.'html-head.inc'; ?>

    <body>
      <div id="wrapper">
<?php include $lang_dir.'header.inc' ?>
<?php $duration = 0; ?>
        <main id="main" class="results">

            <h2 id="FR"><a href="index.php"><img src="/img/France32.png"  class="flagimg" alt="drapeau français" /></a> Analyse GTFS pour la France</h2>
            <div class="indent">
<?php include $lang_dir.'gtfs-head.inc' ?>
                <table id="gtfsFR">
                    <thead>
<?php include $lang_dir.'gtfs-trth.inc' ?>
                    </thead>
                    <tbody>
<?php
    $duration += CreateGtfsEntry( "FR-974-Alterneo" );
    $duration += CreateGtfsEntry( "FR-974-Car_Jaune" );
    $duration += CreateGtfsEntry( "FR-974-CarSud" );
    $duration += CreateGtfsEntry( "FR-974-Citalis" );
    $duration += CreateGtfsEntry( "FR-974-Estival" );
    $duration += CreateGtfsEntry( "FR-974-KarOuest" );
    $duration += CreateGtfsEntry( "FR-ARA-CarsRegion_26" );
    $duration += CreateGtfsEntry( "FR-ARA-Citea" );
    $duration += CreateGtfsEntry( "FR-ARA-Montelibus" );
    $duration += CreateGtfsEntry( "FR-ARA-SMTCAC" );
    $duration += CreateGtfsEntry( "FR-BRE-ARBUS" );
    $duration += CreateGtfsEntry( "FR-BRE-Bibus" );
    $duration += CreateGtfsEntry( "FR-BRE-BREIZHGO_CAR_22" );
    $duration += CreateGtfsEntry( "FR-BRE-BREIZHGO_CAR_29" );
    $duration += CreateGtfsEntry( "FR-BRE-BREIZHGO_CAR_35" );
    $duration += CreateGtfsEntry( "FR-BRE-BREIZHGO_CAR_56" );
    $duration += CreateGtfsEntry( "FR-BRE-BREIZHGO_CAR_NS" );
    $duration += CreateGtfsEntry( "FR-BRE-BREIZHGO_CAR_RLP" );
    $duration += CreateGtfsEntry( "FR-BRE-Coralie" );
    $duration += CreateGtfsEntry( "FR-BRE-Dinamo" );
    $duration += CreateGtfsEntry( "FR-BRE-Distribus" );
    $duration += CreateGtfsEntry( "FR-BRE-Glazgo" );
    $duration += CreateGtfsEntry( "FR-BRE-IZILO" );
    $duration += CreateGtfsEntry( "FR-BRE-KICEO" );
    $duration += CreateGtfsEntry( "FR-BRE-KorriGo" );
    $duration += CreateGtfsEntry( "FR-BRE-Lineotim" );
    $duration += CreateGtfsEntry( "FR-BRE-MAT" );
    $duration += CreateGtfsEntry( "FR-BRE-QUB" );
    $duration += CreateGtfsEntry( "FR-BRE-Star" );
    $duration += CreateGtfsEntry( "FR-BRE-SURF" );
    $duration += CreateGtfsEntry( "FR-BRE-TILT" );
    $duration += CreateGtfsEntry( "FR-BRE-TUB" );
    $duration += CreateGtfsEntry( "FR-BRE-TUDBUS" );
    $duration += CreateGtfsEntry( "FR-CVL-TAO" );
    $duration += CreateGtfsEntry( "FR-GES-CTS" );
    $duration += CreateGtfsEntry( "FR-GES-STAN" );
    $duration += CreateGtfsEntry( "FR-NAQ-TBM" );
    $duration += CreateGtfsEntry( "FR-NOR-Atoumod" );
    $duration += CreateGtfsEntry( "FR-NOR-Hobus" );
    $duration += CreateGtfsEntry( "FR-OCC-liO" );
    $duration += CreateGtfsEntry( "FR-OCC-Tisseo" );
    $duration += CreateGtfsEntry( "FR-PAC-Altigo" );
    $duration += CreateGtfsEntry( "FR-PAC-Bandol-et-Sanary-sur-mer" );
    $duration += CreateGtfsEntry( "FR-PAC-Cmonbus" );
    $duration += CreateGtfsEntry( "FR-PAC-L-Agglo-en-bus" );
    $duration += CreateGtfsEntry( "FR-PAC-Lignes-d-Azur" );
    $duration += CreateGtfsEntry( "FR-PAC-Mistral" );
    $duration += CreateGtfsEntry( "FR-PAC-Mouvenbus" );
    $duration += CreateGtfsEntry( "FR-PAC-Orizo" );
    $duration += CreateGtfsEntry( "FR-PAC-Palmbus" );
    $duration += CreateGtfsEntry( "FR-PAC-RTM" );
    $duration += CreateGtfsEntry( "FR-PAC-Sillages-Scolaire" );
    $duration += CreateGtfsEntry( "FR-PAC-Sillages-Urbain" );
    $duration += CreateGtfsEntry( "FR-PAC-TEDbus" );
    $duration += CreateGtfsEntry( "FR-PAC-Trans-Agglo" );
    $duration += CreateGtfsEntry( "FR-PAC-TransCoVe" );
    $duration += CreateGtfsEntry( "FR-PAC-Zest" );
    $duration += CreateGtfsEntry( "FR-PAC-Zou-Express" );
    $duration += CreateGtfsEntry( "FR-PAC-Zou-Proximite" );
    $duration += CreateGtfsEntry( "FR-PAC-Zou-Scolaire" );
    $duration += CreateGtfsEntry( "FR-PDL-Aleop" );
    $duration += CreateGtfsEntry( "FR-PDL-Aleop_44" );
    $duration += CreateGtfsEntry( "FR-SNCF" );
?>
                    </tbody>
                </table>

                <?php printf( "<p>Les requêtes SQL ont pris %f secondes pour se terminer</p>\n", $duration ); ?>
            </div>
        </main> <!-- main -->

        <hr />

<?php include $lang_dir.'gtfs-footer.inc' ?>

      </div> <!-- wrapper -->
    </body>
</html>
