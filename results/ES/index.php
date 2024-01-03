<!DOCTYPE html>
<html lang="es">

<?php $title="Resultados"; $inc_lang='../../es/'; include $inc_lang.'html-head.inc'; ?>

<?php include('../../script/entries.php'); ?>

    <body>
      <div id="wrapper">

<?php include $inc_lang.'header.inc' ?>

        <main id="main" class="results">

            <h2 id="ES"><img src="/img/Spain32.png" alt="bandera España" /> Resultados para España</h2>

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

                    <?php CreateNewFullEntry( "ES-CT-ATMB", "es", "Configuración" ); ?>

                </tbody>
            </table>

        </main> <!-- main -->

        <hr />

<?php include $inc_lang.'footer.inc' ?>

      </div> <!-- wrapper -->
    </body>
</html>
