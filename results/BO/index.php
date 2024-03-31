<!DOCTYPE html>
<html lang="es">

<?php $title="Resultados"; $inc_lang='../../es/'; include $inc_lang.'html-head.inc'; ?>

<?php include('../../script/entries.php'); ?>

    <body>
      <div id="wrapper">

<?php include $inc_lang.'header.inc' ?>

        <main id="main" class="results">

            <h2 id="BO"><img src="/img/Bolivia32.png"  class="flagimg" alt="bandera Bolivia" /> Resultados para Bolivia</h2>

<?php include $inc_lang.'results-head.inc' ?>

            <table id="networksBO">
                <thead>
<?php include $inc_lang.'results-trth.inc' ?>
                </thead>
                <tbody>

                    <?php CreateNewFullEntry( "BO-C-Cochabamba", "es", "Configuración" ); ?>

                </tbody>
            </table>

        </main> <!-- main -->

        <hr />

<?php include $inc_lang.'footer.inc' ?>

      </div> <!-- wrapper -->
    </body>
</html>
