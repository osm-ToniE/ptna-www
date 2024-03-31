<!DOCTYPE html>
<html lang="de">

<?php $title="Auswertungen"; $inc_lang='../../de/'; include $inc_lang.'html-head.inc'; ?>

<?php include('../../script/entries.php'); ?>

    <body>
      <div id="wrapper">

<?php include $inc_lang.'header.inc' ?>

        <main id="main" class="results">

        <h2 id="LI"><img src="/img/Liechtenstein32.png"  class="flagimg" alt="Flagge Liechtenstein" /> Auswertungen für Liechtenstein</h2>

            <?php include $inc_lang.'results-head.inc' ?>

            <table id="networksLI">
                <thead>
<?php include $inc_lang.'results-trth.inc' ?>
                </thead>
                <tbody>

                    <?php CreateNewFullEntry( "LI-Alle", "de", "Konfiguration" ); ?>

                </tbody>
            </table>

        </main> <!-- main -->

        <hr />

<?php include $inc_lang.'footer.inc' ?>

      </div> <!-- wrapper -->
    </body>
</html>
