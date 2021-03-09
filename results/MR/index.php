<!DOCTYPE html>
<html lang="fr">

<?php $title="Résultats"; $inc_lang='../../fr/'; include $inc_lang.'html-head.inc'; ?>

<?php include('../../script/entries.php'); ?>

    <body>
      <div id="wrapper">

<?php include $inc_lang.'header.inc' ?>

        <main id="main" class="results">

            <h2 id="MR"><img src="/img/Mauritania32.png" alt="Drapeau mauritanien" /> Résultats pour Mauritanie</h2>

<?php include $inc_lang.'results-head.inc' ?>

            <table id="networksMR">
                <thead>
<?php include $inc_lang.'results-trth.inc' ?>
                </thead>
                <tbody>

                    <?php CreateNewFullEntry("MR-NKC-Nouakchott", "fr", "Configuration" ); ?>

                </tbody>
            </table>

            <hr />

<?php include '../../es/results-head.inc' ?>

            <table id="networksMR-es">
                <thead>
<?php include '../../es/results-trth.inc' ?>
                    </thead>
                    <tbody>

                        <?php CreateNewFullEntry("MR-NKC-Nouakchott-es", "es", "Configuración" ); ?>

                    </tbody>
                </table>

</main> <!-- main -->

        <hr />

<?php include $inc_lang.'footer.inc' ?>

      </div> <!-- wrapper -->
    </body>
</html>
