<!DOCTYPE html>
<html lang="et">

<?php $title="Auswertungen"; $inc_lang='../../et/'; include $inc_lang.'html-head.inc'; ?>

<?php include('../../script/entries.php'); ?>

    <body>
      <div id="wrapper">

<?php include $inc_lang.'header.inc' ?>

        <main id="main" class="results">

        <h2 id="EE"><img src="/img/Estonia32.png" alt="Eesti lipp" /> Tulemused Eesti kohta</h2>

            <?php include $inc_lang.'results-head.inc' ?>

            <table id="networksEE">
                <thead>
<?php include $inc_lang.'results-trth.inc' ?>
                </thead>
                <tbody>

                    <?php CreateNewFullEntry( "EE-Koik", "et", "Konfiguratsioon" ); ?>

                </tbody>
            </table>

        </main> <!-- main -->

        <hr />

<?php include $inc_lang.'footer.inc' ?>

      </div> <!-- wrapper -->
    </body>
</html>
