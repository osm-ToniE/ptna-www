<!DOCTYPE html>
<html lang="fa">

<?php $title="Results"; $inc_lang='../../fa/'; include $inc_lang.'html-head.inc'; ?>

<?php include('../../script/entries.php'); ?>

    <body>
      <div id="wrapper">

<?php include $inc_lang.'header.inc' ?>

        <main id="main" class="results">

            <h2 id="IR"><img src="/img/Iran32.png" alt="flag of Iran" /> Results for Iran</h2>

<?php include $inc_lang.'results-head.inc' ?>

            <table id="networksIR">
                <thead>
<?php include $inc_lang.'results-trth.inc' ?>
                </thead>
                <tbody>

                <?php CreateNewFullEntry( "IR-07-Shiraz", "fa", "Configuration" ); ?>

                </tbody>
            </table>

        </main> <!-- main -->

        <hr />

<?php include $inc_lang.'footer.inc' ?>

      </div> <!-- wrapper -->
    </body>
</html>
