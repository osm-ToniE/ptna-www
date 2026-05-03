<!DOCTYPE html>
<html lang="en">

<?php $title="Results"; $inc_lang='../../en/'; include $inc_lang.'html-head.inc'; ?>

<?php include('../../script/entries.php'); ?>

    <body>
      <div id="wrapper">

<?php include $inc_lang.'header.inc' ?>

        <main id="main" class="results">

            <h2 id="ID"><img src="/img/Indonesia32.png"  class="flagimg" alt="Flag of Indonesia" /> Results for Indonesiya</h2>

<?php include $inc_lang.'results-head.inc' ?>

            <h2 id="other-networks">Transport Associations in Indonesiya</h2>
            <table id="networksID">
                <thead>
<?php include $inc_lang.'results-trth.inc' ?>
                </thead>
                <tbody>

                    <?php CreateNewFullEntry( "ID-JK-Transjakarta", "en", "Configuration" ); ?>

                </tbody>
            </table>

        </main> <!-- main -->

        <hr />

<?php include $inc_lang.'footer.inc' ?>

      </div> <!-- wrapper -->
    </body>
</html>
