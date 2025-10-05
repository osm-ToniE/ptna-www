<!DOCTYPE html>
<html lang="en">

<?php $title="Results"; $inc_lang='../../en/'; include $inc_lang.'html-head.inc'; ?>

<?php include('../../script/entries.php'); ?>

    <body>
      <div id="wrapper">

<?php include $inc_lang.'header.inc' ?>

        <main id="main" class="results">

            <h2 id="AU"><img src="/img/Australia32.png"  class="flagimg" alt="Flag of Australia" /> Results for Australia</h2>

<?php include $inc_lang.'results-head.inc' ?>

            <table id="networksAU">
                <thead>
<?php include $inc_lang.'results-trth.inc' ?>
                </thead>
                <tbody>

                <?php CreateNewFullEntry( "AU-NSW-All", "en", "Configuration" ); ?>
                <?php CreateNewFullEntry( "AU-QLD-All", "en", "Configuration" ); ?>
                <?php CreateNewFullEntry( "AU-SA-Adelaide-Metro", "en", "Configuration" ); ?>
                <?php CreateNewFullEntry( "AU-TAS-All", "en", "Configuration" ); ?>

                </tbody>
            </table>

        </main> <!-- main -->

        <hr />

<?php include $inc_lang.'footer.inc' ?>

      </div> <!-- wrapper -->
    </body>
</html>
