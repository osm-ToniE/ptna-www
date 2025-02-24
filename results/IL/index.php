<!DOCTYPE html>
<html lang="en">

<?php $title="Results"; $inc_lang='../../en/'; include $inc_lang.'html-head.inc'; ?>

<?php include('../../script/entries.php'); ?>

    <body>
      <div id="wrapper">

<?php include $inc_lang.'header.inc' ?>

        <main id="main" class="results">

            <h2 id="IL"><img src="/img/Israel32.png"  class="flagimg" alt="Flag of Israel" /> Results for Israel</h2>

<?php include $inc_lang.'results-head.inc' ?>

            <table id="networksIL">
                <thead>
<?php include $inc_lang.'results-trth.inc' ?>
                </thead>
                <tbody>
                    <?php CreateNewFullEntry( "IL-D-Ashkelon",    "en", "Configuration" ); ?>
                    <?php CreateNewFullEntry( "IL-D-Beersheba",   "en", "Configuration" ); ?>
                    <?php CreateNewFullEntry( "IL-HA-Haifa",      "en", "Configuration" ); ?>
                    <?php CreateNewFullEntry( "IL-HA-Hadera",     "en", "Configuration" ); ?>
                    <?php CreateNewFullEntry( "IL-JM-Jerusalem",  "en", "Configuration" ); ?>
                    <?php CreateNewFullEntry( "IL-M-HaSharon",    "en", "Configuration" ); ?>
                    <?php CreateNewFullEntry( "IL-M-Petah_Tikva", "en", "Configuration" ); ?>
                    <?php CreateNewFullEntry( "IL-M-Ramla",       "en", "Configuration" ); ?>
                    <?php CreateNewFullEntry( "IL-M-Rehovot",     "en", "Configuration" ); ?>
                    <?php CreateNewFullEntry( "IL-TA-Tel-Aviv",   "en", "Configuration" ); ?>
                    <?php CreateNewFullEntry( "IL-Z-Acre",        "en", "Configuration" ); ?>
                    <?php CreateNewFullEntry( "IL-Z-Golan",       "en", "Configuration" ); ?>
                    <?php CreateNewFullEntry( "IL-Z-Jezreel",     "en", "Configuration" ); ?>
                    <?php CreateNewFullEntry( "IL-Z-Kinneret",    "en", "Configuration" ); ?>
                    <?php CreateNewFullEntry( "IL-Z-Safed",       "en", "Configuration" ); ?>
                </tbody>
            </table>

        </main> <!-- main -->

        <hr />

<?php include $inc_lang.'footer.inc' ?>

      </div> <!-- wrapper -->
    </body>
</html>
