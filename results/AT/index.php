<!DOCTYPE html>
<html lang="de">

<?php $title="Auswertungen"; $inc_lang='../../de/'; include $inc_lang.'html-head.inc'; ?>

<?php include('../../script/entries.php'); ?>

    <body>
      <div id="wrapper">

<?php include $inc_lang.'header.inc' ?>

<main id="main" class="results">

<h2 id="AT"><img src="/img/Austria32.png" alt="Flagge Österreich" /> Auswertungen für Österreich</h2>

<?php include $inc_lang.'results-head.inc' ?>

<table id="networksAT">
    <thead>
<?php include $inc_lang.'results-trth.inc' ?>
    </thead>
    <tbody>

    <?php CreateNewFullEntry( "AT-139-VOR", "de", "Konfiguration" ); ?>

    <?php CreateNewFullEntry( "AT-2-VKG", "de", "Konfiguration" ); ?>

    <?php CreateNewFullEntry( "AT-4-OÖVV", "de", "Konfiguration" ); ?>

    <?php CreateNewFullEntry( "AT-5-SVV", "de", "Konfiguration" ); ?>

    <?php CreateNewFullEntry( "AT-6-VVSt", "de", "Konfiguration" ); ?>

    <?php CreateNewFullEntry( "AT-7-VVT", "de", "Konfiguration" ); ?>

    <?php CreateNewFullEntry( "AT-8-VVV", "de", "Konfiguration" ); ?>

</tbody>
</table>

</main> <!-- main -->

        <hr />

<?php include $inc_lang.'footer.inc' ?>

      </div> <!-- wrapper -->
    </body>
</html>
