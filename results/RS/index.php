<!DOCTYPE html>
<html lang="sr">

<?php $title="Results"; $inc_lang='../../sr/'; include $inc_lang.'html-head.inc'; ?>

<?php include('../../script/entries.php'); ?>

    <body>
      <div id="wrapper">

<?php include $inc_lang.'header.inc' ?>

        <main id="main" class="results">

            <h2 id="RS"><img src="/img/Serbia32.png"  class="flagimg" alt="застава Србије" /> Резултати за Србију</h2>

<?php include $inc_lang.'results-head.inc' ?>

            <table id="networksRS">
                <thead>
<?php include $inc_lang.'results-trth.inc' ?>
                </thead>
                <tbody>

                <?php CreateNewFullEntry( "RS-00-Beograd", "sr", "Конфигурација" ); ?>

                <?php CreateNewFullEntry( "RS-01-SUTRANS", "sr", "Конфигурација" ); ?>

                <?php CreateNewFullEntry( "RS-12-KGBUS", "sr", "Конфигурација" ); ?>

                <?php CreateNewFullEntry( "RS-16-GP-UZICE", "sr", "Конфигурација" ); ?>

                <?php CreateNewFullEntry( "RS-20-JGP-NIS", "sr", "Конфигурација" ); ?>

</tbody>
            </table>

        </main> <!-- main -->

        <hr />

<?php include $inc_lang.'footer.inc' ?>

      </div> <!-- wrapper -->
    </body>
</html>
