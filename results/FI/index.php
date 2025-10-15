<!DOCTYPE html>
<html lang="en">

<?php $title="Results"; $inc_lang='../../ru/'; include $inc_lang.'html-head.inc'; ?>

<?php include('../../script/entries.php'); ?>

    <body>
      <div id="wrapper">

<?php include $inc_lang.'header.inc' ?>

        <main id="main" class="results">

            <h2 id="FI"><img src="/img/Finland32.png" class="flagimg" alt="flag of Finland" /> Results for Suomi / Finland</h2>

<?php include $inc_lang.'results-head.inc' ?>

            <table id="networksFI">
                <thead>
<?php include $inc_lang.'results-trth.inc' ?>
                </thead>
                <tbody>

                    <?php CreateNewFullEntry( "FI-11-Nysee", "en", "Configuration" ); ?>

                </tbody>
            </table>

        </main> <!-- main -->

        <hr />

<?php include $inc_lang.'footer.inc' ?>

      </div> <!-- wrapper -->
    </body>
</html>
