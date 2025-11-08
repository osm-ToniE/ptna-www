<!DOCTYPE html>
<html lang="en">

<?php $title="Results"; $inc_lang='../../en/'; include $inc_lang.'html-head.inc'; ?>

<?php include('../../script/entries.php'); ?>

    <body>
      <div id="wrapper">

<?php include $inc_lang.'header.inc' ?>

        <main id="main" class="results">

            <h2 id="CA"><img src="/img/Canada32.png"  class="flagimg" alt="flag of Canada" /> Results for Canada</h2>

<?php include $inc_lang.'results-head.inc' ?>

            <table id="networksCA">
                <thead>
<?php include $inc_lang.'results-trth.inc' ?>
                </thead>
                <tbody>

                <?php CreateNewFullEntry( "CA-AB-CT", "en", "Configuration" ); ?>
                <?php CreateNewFullEntry( "CA-AB-ETS", "en", "Configuration" ); ?>
                <?php CreateNewFullEntry( "CA-MB-WT", "en", "Configuration" ); ?>
                <?php CreateNewFullEntry( "CA-NB-CT", "en", "Configuration" ); ?>
                <?php CreateNewFullEntry( "CA-ON-BT", "en", "Configuration" ); ?>
                <?php CreateNewFullEntry( "CA-ON-GOT", "en", "Configuration" ); ?>
                <?php CreateNewFullEntry( "CA-ON-HSR", "en", "Configuration" ); ?>
                <?php CreateNewFullEntry( "CA-ON-MiWay", "en", "Configuration" ); ?>
                <?php CreateNewFullEntry( "CA-ON-TTC", "en", "Configuration" ); ?>
                <?php CreateNewFullEntry( "CA-ON-YRT", "en", "Configuration" ); ?>
                <?php CreateNewFullEntry( "CA-QC-EXO", "fr", "Configuration" ); ?>
                <?php CreateNewFullEntry( "CA-QC-RTC", "fr", "Configuration" ); ?>
                <?php CreateNewFullEntry( "CA-QC-STLevis", "fr", "Configuration" ); ?>

                </tbody>
            </table>

        </main> <!-- main -->

        <hr />

<?php include $inc_lang.'footer.inc' ?>

      </div> <!-- wrapper -->
    </body>
</html>
