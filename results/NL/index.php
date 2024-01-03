<!DOCTYPE html>
<html lang="nl">

<?php $title="Results"; $inc_lang='../../nl/'; include $inc_lang.'html-head.inc'; ?>

<?php include('../../script/entries.php'); ?>

    <body>
      <div id="wrapper">

<?php include $inc_lang.'header.inc' ?>

        <main id="main" class="results">

            <h2 id="NL"><img src="/img/Netherlands32.png" alt="Vlag van Nderland" /> Resultaten voor Nederland</h2>

<?php include $inc_lang.'results-head.inc' ?>

            <table id="networksNL">
                <thead>
<?php include $inc_lang.'results-trth.inc' ?>
                </thead>
                <tbody>

                <?php CreateNewFullEntry( "NL-HRN", "nl", "Configuratie" ); ?>

                <?php CreateNewFullEntry( "NL-NH-ASD", "nl", "Configuratie" ); ?>

                <?php CreateNewFullEntry( "NL-NH-NZKV", "nl", "Configuratie" ); ?>

</tbody>
            </table>

        </main> <!-- main -->

        <hr />

<?php include $inc_lang.'footer.inc' ?>

      </div> <!-- wrapper -->
    </body>
</html>
