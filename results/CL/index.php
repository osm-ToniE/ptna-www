<!DOCTYPE html>
<html lang="es">

<?php $title="Resultados"; $inc_lang='../../es/'; include $inc_lang.'html-head.inc'; ?>

<?php include('../../script/entries.php'); ?>

    <body>
      <div id="wrapper">

<?php include $inc_lang.'header.inc' ?>

        <main id="main" class="results">

            <h2 id="CL"><img src="/img/Chile32.png"  class="flagimg" alt="bandera Chile" /> Resultados para Chile</h2>

<?php include $inc_lang.'results-head.inc' ?>

            <table id="networksCL">
                <thead>
<?php include $inc_lang.'results-trth.inc' ?>
                </thead>
                <tbody>

                    <?php CreateNewFullEntry( "CL-RM-DTPM", "es", "Configuración" ); ?>

                </tbody>
            </table>

        </main> <!-- main -->

        <hr />

<?php include $inc_lang.'footer.inc' ?>

      </div> <!-- wrapper -->
    </body>
</html>
