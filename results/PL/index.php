<!DOCTYPE html>
<html lang="pl-PL">

<?php $title="Results"; $inc_lang='../../pl_PL/'; include $inc_lang.'html-head.inc'; ?>

<?php include('../../script/entries.php'); ?>

    <body>
      <div id="wrapper">

<?php include $inc_lang.'header.inc' ?>

        <main id="main" class="results">

            <h2 id="PL"><img src="/img/Poland32.png"  class="flagimg" alt="Flaga Polski" /> Wyniki dla Polski</h2>

<?php include $inc_lang.'results-head.inc' ?>

            <table id="networksPL">
                <thead>
<?php include $inc_lang.'results-trth.inc' ?>
                </thead>
                <tbody>

                <?php CreateNewFullEntry( "PL-14-ZTM-Warszawa", "pl_PL", "Configuration" ); ?>
                <?php CreateNewFullEntry( "PL-24-ZTM-Katowice", "pl_PL", "Configuration" ); ?>

                </tbody>
            </table>

        </main> <!-- main -->

        <hr />

<?php include $inc_lang.'footer.inc' ?>

      </div> <!-- wrapper -->
    </body>
</html>
