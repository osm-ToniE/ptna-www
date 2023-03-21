<!DOCTYPE html>
<html lang="it">

<?php $title="Risultati"; $inc_lang='../../it/'; include $inc_lang.'html-head.inc'; ?>

<?php include('../../script/entries.php'); ?>

    <body>
      <div id="wrapper">

<?php include $inc_lang.'header.inc' ?>

        <main id="main" class="results">

            <h2 id="IT"><img src="/img/Italy16.png" alt="Italia" /> Risultati per l'Italia</h2>

<?php include $inc_lang.'results-head.inc' ?>

            <table id="networksIT">
                <thead>
<?php include $inc_lang.'results-trth.inc' ?>
                </thead>
                <tbody>

                    <?php CreateNewFullEntry( "IT-PI-Servizio-Urbano-Pisa", "it", "Configurazione" ); ?>

                </tbody>
            </table>

        </main> <!-- main -->

        <hr />

<?php include $inc_lang.'footer.inc' ?>

      </div> <!-- wrapper -->
    </body>
</html>
