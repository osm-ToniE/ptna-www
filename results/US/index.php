<!DOCTYPE html>
<html lang="en">

<?php $title="Results"; $inc_lang='../../en/'; include $inc_lang.'html-head.inc'; ?>

<?php include('../../script/entries.php'); ?>

    <body>
      <div id="wrapper">

<?php include $inc_lang.'header.inc' ?>

        <main id="main" class="results">

            <h2 id="USA"><img src="/img/USA32.png" alt="flag of the USA" /> Results for the USA</h2>

<?php include $inc_lang.'results-head.inc' ?>

            <table id="networksUSA">
                <thead>
<?php include $inc_lang.'results-trth.inc' ?>
                </thead>
                <tbody>

                <?php CreateNewFullEntry( "US-Amtrak", "en", "Configuration" ); ?>
                <?php CreateNewFullEntry( "US-Flixbus", "en", "Configuration" ); ?>
                <?php CreateNewFullEntry( "US-AK-Anchorage-PTD", "en", "Configuration" ); ?>
                <?php CreateNewFullEntry( "US-CA-SantaCruz", "en", "Configuration" ); ?>
                <?php CreateNewFullEntry( "US-IL-Metra", "en", "Configuration" ); ?>
                <?php CreateNewFullEntry( "US-IL-Pace", "en", "Configuration" ); ?>
                <?php CreateNewFullEntry( "US-IN-ECT", "en", "Configuration" ); ?>
                <?php CreateNewFullEntry( "US-MA-MBTA", "en", "Configuration" ); ?>
                <?php CreateNewFullEntry( "US-TN-KAT", "en", "Configuration" ); ?>
                <?php CreateNewFullEntry( "US-WI-MCTS", "en", "Configuration" ); ?>

                </tbody>
            </table>

        </main> <!-- main -->

        <hr />

<?php include $inc_lang.'footer.inc' ?>

      </div> <!-- wrapper -->
    </body>
</html>
