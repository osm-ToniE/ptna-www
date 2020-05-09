<!DOCTYPE html>
<html lang="es">

<?php $title="Resultados"; $inc_lang='../../es/'; include $inc_lang.'html-head.inc'; ?>

<?php include('../../script/entries.php'); ?>

    <body>
      <div id="wrapper">

<?php include $inc_lang.'header.inc' ?>

        <main id="main" class="results">

            <h2 id="CO"><img src="/img/Spain32.png" alt="bandera España" /> Resultados para España</h2>

<?php include $inc_lang.'results-head.inc' ?>

            <table id="networksCO">
                <thead>
<?php include $inc_lang.'results-trth.inc' ?>
                </thead>
                <tbody>

                    <?php CreateNewFullEntry( "ES-Z-AUZ", "es", "Configuración" ); ?>

                    <?php CreateNewFullEntry( "ES-Z-Cercanías", "es", "Configuración" ); ?>

                    <?php CreateNewFullEntry( "ES-Z-CTAZ", "es", "Configuración" ); ?>

                    <?php CreateNewFullEntry( "ES-Z-Tranvia", "es", "Configuración" ); ?>

                </tbody>
            </table>

        </main> <!-- main -->

        <hr />

<?php include $inc_lang.'footer.inc' ?>

      </div> <!-- wrapper -->
    </body>
</html>
