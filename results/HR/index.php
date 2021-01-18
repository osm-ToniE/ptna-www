<!DOCTYPE html>
<html lang="hr">

<?php $title="Results"; $inc_lang='../../hr/'; include $inc_lang.'html-head.inc'; ?>

<?php include('../../script/entries.php'); ?>

    <body>
      <div id="wrapper">

<?php include $inc_lang.'header.inc' ?>

        <main id="main" class="results">

            <h2 id="HR"><img src="/img/Croatia32.png" alt="flag of the USA" /> Rezultati za Hrvatsku</h2>

<?php include $inc_lang.'results-head.inc' ?>

            <table id="networksHR">
                <thead>
<?php include $inc_lang.'results-trth.inc' ?>
                </thead>
                <tbody>

                    <?php CreateNewFullEntry( "HR-21-ZET", "hr", "Configuration" ); ?>

                </tbody>
            </table>

        </main> <!-- main -->

        <hr />

<?php include $inc_lang.'footer.inc' ?>

      </div> <!-- wrapper -->
    </body>
</html>
