<!DOCTYPE html>
<html lang="es">

<?php $title="Resultados"; $inc_lang='../../es/'; include $inc_lang.'html-head.inc'; ?>

<?php include('../../script/entries.php'); ?>

    <body>
      <div id="wrapper">

<?php include $inc_lang.'header.inc' ?>

        <main id="main" class="results">

            <h2 id="ES"><img src="/img/Spain32.png"  class="flagimg" alt="bandera España" /> Resultados para España</h2>

<?php include $inc_lang.'results-head.inc' ?>

            <table id="networksES">
                <thead>
<?php include $inc_lang.'results-trth.inc' ?>
                </thead>
                <tbody>

                    <?php CreateNewFullEntry( "ES-AR-Z-AUZ", "es", "Configuración" ); ?>

                    <?php CreateNewFullEntry( "ES-AR-Z-Cercanias", "es", "Configuración" ); ?>

                    <?php CreateNewFullEntry( "ES-AR-Z-CTAZ", "es", "Configuración" ); ?>

                    <?php CreateNewFullEntry( "ES-AR-Z-Tranvia", "es", "Configuración" ); ?>

                    <!-- see also: https://community.openstreetmap.org/t/ptna-i-arees-de-transport-network-guid/107647 -->

                    <?php CreateNewFullEntry( "ES-CT-AB", "ca", "Configuració en progrés" ); ?> <!-- Airport Barcelona -->

                    <?php CreateNewFullEntry( "ES-CT-AG", "ca", "Configuració en progrés" ); ?> <!-- Airport Girona -->

                    <?php CreateNewFullEntry( "ES-CT-AR", "ca", "Configuració en progrés" ); ?> <!-- Airport Reus -->

                    <?php CreateNewFullEntry( "ES-CT-ATMB", "ca", "Configuració" ); ?> <!-- Barcelona -->

                    <?php CreateNewFullEntry( "ES-CT-ATMG", "ca", "Configuració en progrés" ); ?> <!-- Girona -->

                    <?php CreateNewFullEntry( "ES-CT-ATML", "ca", "Configuració en progrés" ); ?> <!-- Lleida -->

                    <?php CreateNewFullEntry( "ES-CT-ATMT", "ca", "Configuració" ); ?> <!-- Camp de Tarragona -->

                    <?php CreateNewFullEntry( "ES-CT-TB", "ca", "Configuració en progrés" ); ?> <!-- Tourism Barcelona -->

                    <?php CreateNewFullEntry( "ES-CT-TG", "ca", "Configuració en progrés" ); ?> <!-- Tourism Girona -->

                    <?php CreateNewFullEntry( "ES-CT-TT", "ca", "Configuració en progrés" ); ?> <!-- Tourism Tarragona -->

                    <?php CreateNewFullEntry( "ES-CT-VE", "ca", "Configuració en progrés" ); ?> <!-- Terres de l’Ebre -->

                    <?php CreateNewFullEntry( "ES-CT-VG", "ca", "Configuració en progrés" ); ?> <!-- Girona -->

                    <?php CreateNewFullEntry( "ES-CT-VP", "ca", "Configuració en progrés" ); ?> <!-- Alt Pirineu i Aran -->

                </tbody>
            </table>

        </main> <!-- main -->

        <hr />

<?php include $inc_lang.'footer.inc' ?>

      </div> <!-- wrapper -->
    </body>
</html>
