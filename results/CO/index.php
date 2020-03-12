<!DOCTYPE html>
<html lang="es">

<?php $title="Resultados"; $inc_lang='../../es/'; include $inc_lang.'html-head.inc'; ?>

<?php include('../../script/entries.php'); ?>

    <body>
      <div id="wrapper">
      
<?php include $inc_lang.'header.inc' ?>

        <main id="main" class="results">

            <h2 id="CO"><img src="/img/Colombia32.png" alt="bandera Colombia" /> Resultados para Colombia</h2>
      
<?php include $inc_lang.'results-head.inc' ?>

            <table id="networksCO">
                <thead>
<?php include $inc_lang.'results-trth.inc' ?>
                </thead>
                <tbody>

                    <?php CreateNewFullEntry( "CO-BOY-Duitama", "es", "Configuración" ); ?>

                </tbody>
            </table>

        </main> <!-- main -->

        <hr />

<?php include $inc_lang.'footer.inc' ?>

      </div> <!-- wrapper -->
    </body>
</html>

