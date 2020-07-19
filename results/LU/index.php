<!DOCTYPE html>
<html lang="en">

<?php $title="Results"; $inc_lang='../../en/'; include $inc_lang.'html-head.inc'; ?>

<?php include('../../script/entries.php'); ?>

    <body>
      <div id="wrapper">

<?php include $inc_lang.'header.inc' ?>

        <main id="main" class="results">

            <h2 id="LU"><img src="/img/Luxembourg32.png" alt="Flagge Lëtzebuerg" /> Results for Lëtzebuerg / Luxemburg / Luxembourg</h2>

<?php include $inc_lang.'results-head.inc' ?>

            <table id="networksLU">
                <thead>
<?php include $inc_lang.'results-trth.inc' ?>
                </thead>
                <tbody>

                    <?php CreateNewFullEntry( "LU-AVL", "en", "Configuration" ); ?>

                    <?php CreateNewFullEntry( "LU-CFL", "en", "Configuration" ); ?>

                    <?php CreateNewFullEntry( "LU-Luxtram", "en", "Configuration" ); ?>

                    <?php CreateNewFullEntry( "LU-RGTR", "en", "Configuration" ); ?>

                    <?php CreateNewFullEntry( "LU-TICE", "en", "Configuration" ); ?>

                </tbody>
            </table>

        </main> <!-- main -->

        <hr />

<?php include $inc_lang.'footer.inc' ?>

      </div> <!-- wrapper -->
    </body>
</html>
