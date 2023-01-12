<!DOCTYPE html>
<html lang="sl">

<?php $title="Results"; $inc_lang='../../en/'; include $inc_lang.'html-head.inc'; ?>

<?php include('../../script/entries.php'); ?>

    <body>
      <div id="wrapper">

<?php include $inc_lang.'header.inc' ?>

        <main id="main" class="results">

            <h2 id="SI"><img src="/img/Slovenia32.png" alt="zastava slovenije" /> Rezultati za Slowenia</h2>

<?php include $inc_lang.'results-head.inc' ?>

            <table id="networksSI">
                <thead>
<?php include $inc_lang.'results-trth.inc' ?>
                </thead>
                <tbody>

                <?php CreateNewFullEntry( "SI-Ljubljana-LPP", "en", "Konfiguracija" ); ?>

                </tbody>
            </table>

        </main> <!-- main -->

        <hr />

<?php include $inc_lang.'footer.inc' ?>

      </div> <!-- wrapper -->
    </body>
</html>
