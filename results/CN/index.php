<!DOCTYPE html>
<html lang="en">

<?php $title="Results"; $inc_lang='../../en/'; include $inc_lang.'html-head.inc'; ?>

<?php include('../../script/entries.php'); ?>

    <body>
      <div id="wrapper">

<?php include $inc_lang.'header.inc' ?>

        <main id="main" class="results">

            <h2 id="CN"><img src="/img/China32.png"  class="flagimg" alt="Flag of China" /> Results for China</h2>

<?php include $inc_lang.'results-head.inc' ?>

            <table id="networksCN">
                <thead>
<?php include $inc_lang.'results-trth.inc' ?>
                </thead>
                <tbody>

                <?php CreateNewFullEntry( "CN-SH-Shanghai", "en", "組態 / Configuration" ); ?>

                </tbody>
            </table>

        </main> <!-- main -->

        <hr />

<?php include $inc_lang.'footer.inc' ?>

      </div> <!-- wrapper -->
    </body>
</html>
