<!DOCTYPE html>
<html lang="no">

<?php $title="Results"; $inc_lang='../../no/'; include $inc_lang.'html-head.inc'; ?>

<?php include('../../script/entries.php'); ?>

    <body>
      <div id="wrapper">

<?php include $inc_lang.'header.inc' ?>

        <main id="main" class="results">

            <h2 id="NO"><img src="/img/Norway32.png" alt="norks flagg" /> Resultater for Norge</h2>

<?php include $inc_lang.'results-head.inc' ?>

            <table id="networksNO">
                <thead>
<?php include $inc_lang.'results-trth.inc' ?>
                </thead>
                <tbody>

                    <?php CreateNewFullEntry( "NO-03-Ruter", "no", "Configuration" ); ?>

                </tbody>
            </table>

        </main> <!-- main -->

        <hr />

<?php include $inc_lang.'footer.inc' ?>

      </div> <!-- wrapper -->
    </body>
</html>
