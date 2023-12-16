<!DOCTYPE html>
<html lang="cs">

<?php $title="Analýzy"; $inc_lang='../../cs/'; include $inc_lang.'html-head.inc'; ?>

<?php include('../../script/entries.php'); ?>

    <body>
      <div id="wrapper">

<?php include $inc_lang.'header.inc' ?>

        <main id="main" class="results">

        <h2 id="CZ"><img src="/img/CzechRepublic32.png" alt="Vlajka Česka" /> Výsledky pro Českou republiku</h2>

            <?php include $inc_lang.'results-head.inc' ?>

            <table id="networksCZ">
                <thead>
<?php include $inc_lang.'results-trth.inc' ?>
                </thead>
                <tbody>

                    <?php CreateNewFullEntry( "CZ-10-PID", "cs", "Konfigurace" ); ?>

                </tbody>
            </table>

        </main> <!-- main -->

        <hr />

<?php include $inc_lang.'footer.inc' ?>

      </div> <!-- wrapper -->
    </body>
</html>
