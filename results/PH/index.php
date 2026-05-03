<!DOCTYPE html>
<html lang="en">

<?php $title="Results"; $inc_lang='../../en/'; include $inc_lang.'html-head.inc'; ?>

<?php include('../../script/entries.php'); ?>

    <body>
      <div id="wrapper">

<?php include $inc_lang.'header.inc' ?>

        <main id="main" class="results">

            <h2 id="PH"><img src="/img/Philippines32.png"  class="flagimg" alt="Flag of the Philippines" /> Results for the Philippines</h2>

<?php include $inc_lang.'results-head.inc' ?>

            <h2 id="other-networks">Transport Associations in the Philippines</h2>
            <table id="networksPH">
                <thead>
<?php include $inc_lang.'results-trth.inc' ?>
                </thead>
                <tbody>

                    <?php CreateNewFullEntry( "PH-00-Metro-Manila", "en", "Configuration" ); ?>

                </tbody>
            </table>

        </main> <!-- main -->

        <hr />

<?php include $inc_lang.'footer.inc' ?>

      </div> <!-- wrapper -->
    </body>
</html>
