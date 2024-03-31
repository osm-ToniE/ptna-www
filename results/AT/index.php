<!DOCTYPE html>
<html lang="de">

<?php $title="Auswertungen"; $inc_lang='../../de/'; include $inc_lang.'html-head.inc'; ?>

<?php include('../../script/entries.php'); ?>

    <body>
      <div id="wrapper">

<?php include $inc_lang.'header.inc' ?>

<main id="main" class="results">

<h2 id="AT"><img src="/img/Austria32.png"  class="flagimg" alt="Flagge Österreich" /> Auswertungen für Österreich</h2>

<?php include $inc_lang.'results-head.inc' ?>

<table id="networksAT">
    <thead>
<?php include $inc_lang.'results-trth.inc' ?>
    </thead>
    <tbody>

    <?php CreateNewFullEntry( "AT-OOeVV", "de", "Konfiguration" ); ?>

    <?php CreateNewFullEntry( "AT-SVV", "de", "Konfiguration" ); ?>

    <?php CreateNewFullEntry( "AT-VKG", "de", "Konfiguration" ); ?>

    <?php CreateNewFullEntry( "AT-VOR", "de", "Konfiguration" ); ?>

    <?php CreateNewFullEntry( "AT-VVSt", "de", "Konfiguration" ); ?>

    <?php CreateNewFullEntry( "AT-VVT", "de", "Konfiguration" ); ?>

    <?php CreateNewFullEntry( "AT-VVV", "de", "Konfiguration" ); ?>

</tbody>
</table>

</main> <!-- main -->

        <hr />

<?php include $inc_lang.'footer.inc' ?>

      </div> <!-- wrapper -->
    </body>
</html>
