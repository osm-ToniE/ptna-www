<!DOCTYPE html>
<html lang="en">

<?php $title="Results"; $inc_lang='../../en/'; include $inc_lang.'html-head.inc'; ?>

<?php include('../../script/entries.php'); ?>

    <body>
      <div id="wrapper">

<?php include $inc_lang.'header.inc' ?>

        <main id="main" class="results">

            <h2 id="EU"><img src="/img/Europe32.png"  class="flagimg" alt="Europaflagge" /> Results for Europe</h2>

<?php include $inc_lang.'results-head.inc' ?>

            <table id="networksEU">
                <thead>
<?php include $inc_lang.'results-trth.inc' ?>
                </thead>
                <tbody>

                <?php CreateNewFullEntry( "EU-Eurolines", "en", "Configuration" ); ?>

                <?php CreateNewFullEntry( "EU-Eurotrains", "en", "Configuration" ); ?>

                <?php CreateNewFullEntry( "EU-Flixbus", "en", "Configuration" ); ?>

</tbody>
            </table>

        </main> <!-- main -->

        <hr />

<?php include $inc_lang.'footer.inc' ?>

      </div> <!-- wrapper -->
    </body>
</html>
