<!DOCTYPE html>
<html lang="en">

<?php $title="Results"; $inc_lang='../../en/'; include $inc_lang.'html-head.inc'; ?>

<?php include('../../script/entries.php'); ?>

    <body>
      <div id="wrapper">

<?php include $inc_lang.'header.inc' ?>

        <main id="main" class="results">

            <h2 id="BG"><img src="/img/Bulgaria32.png" class="flagimg" alt="българско знаме" /> Results for България / Bulgaria</h2>

<?php include $inc_lang.'results-head.inc' ?>

            <table id="networksBG">
                <thead>
<?php include $inc_lang.'results-trth.inc' ?>
                </thead>
                <tbody>

                <?php CreateNewFullEntry( "BG-03-Varna", "bg", "Конфигурация" ); ?>
                <?php CreateNewFullEntry( "BG-22-Sofia", "bg", "Конфигурация" ); ?>

                </tbody>
            </table>

        </main> <!-- main -->

        <hr />

<?php include $inc_lang.'footer.inc' ?>

      </div> <!-- wrapper -->
    </body>
</html>
