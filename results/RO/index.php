<!DOCTYPE html>
<html lang="ro">

<?php $title="Results"; $inc_lang='../../ro/'; include $inc_lang.'html-head.inc'; ?>

<?php include('../../script/entries.php'); ?>

    <body>
      <div id="wrapper">

<?php include $inc_lang.'header.inc' ?>

        <main id="main" class="results">

            <h2 id="RO"><img src="/img/Romania32.png"  class="flagimg" alt="Steagul României" /> Rezultate pentru România</h2>

<?php include $inc_lang.'results-head.inc' ?>

            <table id="networksRO">
                <thead>
<?php include $inc_lang.'results-trth.inc' ?>
                </thead>
                <tbody>

                <?php CreateNewFullEntry( "RO-SB-Tursib", "ro", "Configurație" ); ?>


                </tbody>
            </table>

        </main> <!-- main -->

        <hr />

<?php include $inc_lang.'footer.inc' ?>

      </div> <!-- wrapper -->
    </body>
</html>
