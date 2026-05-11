<!DOCTYPE html>
<html lang="id">

<?php $title="Results"; $inc_lang='../../id/'; include $inc_lang.'html-head.inc'; ?>

<?php include('../../script/entries.php'); ?>

    <body>
      <div id="wrapper">

<?php include $inc_lang.'header.inc' ?>

        <main id="main" class="results">

            <h2 id="ID"><img src="/img/Indonesia32.png"  class="flagimg" alt="Flag of Indonesia" /> Hasil untuk Indonesia</h2>

<?php include $inc_lang.'results-head.inc' ?>

            <h2 id="other-networks">Jaringan transportasi di Indonesia</h2>
            <table id="networksID">
                <thead>
<?php include $inc_lang.'results-trth.inc' ?>
                </thead>
                <tbody>

                    <?php CreateNewFullEntry( "ID-JK-Transjakarta", "id", "Configuration" ); ?>

                </tbody>
            </table>

        </main> <!-- main -->

        <hr />

<?php include $inc_lang.'footer.inc' ?>

      </div> <!-- wrapper -->
    </body>
</html>
