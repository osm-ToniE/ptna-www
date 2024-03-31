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

                    <?php CreateNewFullEntry( "ES-CT-AB", "es", "Configuración en progreso" ); ?> <!-- Airport Barcelona -->

                    <?php CreateNewFullEntry( "ES-CT-AG", "es", "Configuración en progreso" ); ?> <!-- Airport Girona -->

                    <?php CreateNewFullEntry( "ES-CT-AR", "es", "Configuración en progreso" ); ?> <!-- Airport Reus -->

                    <?php CreateNewFullEntry( "ES-CT-ATMB", "es", "Configuración" ); ?> <!-- Barcelona -->

                    <?php CreateNewFullEntry( "ES-CT-ATMG", "es", "Configuración en progreso" ); ?> <!-- Girona -->

                    <?php CreateNewFullEntry( "ES-CT-ATML", "es", "Configuración en progreso" ); ?> <!-- Lleida -->

                    <?php CreateNewFullEntry( "ES-CT-ATMT", "es", "Configuración en progreso" ); ?> <!-- Camp de Tarragona -->

                    <?php CreateNewFullEntry( "ES-CT-TB", "es", "Configuración en progreso" ); ?> <!-- Tourism Barcelona -->

                    <?php CreateNewFullEntry( "ES-CT-TG", "es", "Configuración en progreso" ); ?> <!-- Tourism Girona -->

                    <?php CreateNewFullEntry( "ES-CT-TT", "es", "Configuración en progreso" ); ?> <!-- Tourism Tarragona -->

                    <?php CreateNewFullEntry( "ES-CT-VE", "es", "Configuración en progreso" ); ?> <!-- Terres de l’Ebre -->

                    <?php CreateNewFullEntry( "ES-CT-VG", "es", "Configuración en progreso" ); ?> <!-- Girona -->

                    <?php CreateNewFullEntry( "ES-CT-VP", "es", "Configuración en progreso" ); ?> <!-- Alt Pirineu i Aran -->

                </tbody>
            </table>

        </main> <!-- main -->

        <hr />

<?php include $inc_lang.'footer.inc' ?>

      </div> <!-- wrapper -->
    </body>
</html>
