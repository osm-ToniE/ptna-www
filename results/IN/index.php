<!DOCTYPE html>
<html lang="en">

<?php $title="Results"; $inc_lang='../../en/'; include $inc_lang.'html-head.inc'; ?>

<?php include('../../script/entries.php'); ?>

    <body>
      <div id="wrapper">

<?php include $inc_lang.'header.inc' ?>

        <main id="main" class="results">

            <h2 id="IN"><img src="/img/India32.png" alt="Flag of India" /> Results for India</h2>

<?php include $inc_lang.'results-head.inc' ?>

            <table id="networksIN">
                <thead>
<?php include $inc_lang.'results-trth.inc' ?>
                </thead>
                <tbody>

                    <?php CreateNewFullEntry( "IN-DL-Delhi", "en", "Configuration" ); ?>

                    <?php CreateNewFullEntry( "IN-GJ-Ahmedabad", "en", "Configuration" ); ?>

                    <?php CreateNewFullEntry( "IN-HR-Gurgaon", "en", "Configuration" ); ?>

                    <?php CreateNewFullEntry( "IN-KA-Bengaluru", "en", "Configuration" ); ?>

                    <?php CreateNewFullEntry( "IN-KL-Kochi", "en", "Configuration" ); ?>

                    <?php CreateNewFullEntry( "IN-MH-Mumbai", "en", "Configuration" ); ?>

                    <?php CreateNewFullEntry( "IN-MH-Pune", "en", "Configuration" ); ?>

                    <?php CreateNewFullEntry( "IN-RJ-Jaipur", "en", "Configuration" ); ?>

                    <?php CreateNewFullEntry( "IN-TN-Chennai", "en", "Configuration" ); ?>

                    <?php CreateNewFullEntry( "IN-TS-Hyderabad", "en", "Configuration" ); ?>

                    <?php CreateNewFullEntry( "IN-UP-Kanpur", "en", "Configuration" ); ?>

                    <?php CreateNewFullEntry( "IN-UP-Lucknow", "en", "Configuration" ); ?>

                    <?php CreateNewFullEntry( "IN-UP-Nagpur", "en", "Configuration" ); ?>

                    <?php CreateNewFullEntry( "IN-UP-Noida", "en", "Configuration" ); ?>

                    <?php CreateNewFullEntry( "IN-WB-Kolkata", "en", "Configuration" ); ?>

                </tbody>
            </table>

        </main> <!-- main -->

        <hr />

<?php include $inc_lang.'footer.inc' ?>

      </div> <!-- wrapper -->
    </body>
</html>
