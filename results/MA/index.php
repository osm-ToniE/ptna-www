<!DOCTYPE html>
<html lang="fr">

<?php $title="Résultats"; $inc_lang='../../fr/'; include $inc_lang.'html-head.inc'; ?>

<?php include('../../script/entries.php'); ?>

    <body>
      <div id="wrapper">

<?php include $inc_lang.'header.inc' ?>

        <main id="main" class="results">

            <h2 id="MA"><img src="/img/Morocco32.png"  class="flagimg" alt="Drapeau marocain" /> Résultats pour Maroc</h2>

<?php include $inc_lang.'results-head.inc' ?>

            <table id="networksMA">
                <thead>
<?php include $inc_lang.'results-trth.inc' ?>
                </thead>
                <tbody>

                    <?php CreateNewFullEntry("MA-01-Tetouan", "fr", "Configuration" ); ?>

                </tbody>
            </table>

        </main> <!-- main -->

        <hr />

<?php include $inc_lang.'footer.inc' ?>

      </div> <!-- wrapper -->
    </body>
</html>
