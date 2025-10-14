<!DOCTYPE html>
<html lang="ru">

<?php $title="Results"; $inc_lang='../../ru/'; include $inc_lang.'html-head.inc'; ?>

<?php include('../../script/entries.php'); ?>

    <body>
      <div id="wrapper">

<?php include $inc_lang.'header.inc' ?>

        <main id="main" class="results">

            <h2 id="RU"><img src="/img/Russia32.png" class="flagimg" alt="Флаг России" /> Результаты для России</h2>

<?php include $inc_lang.'results-head.inc' ?>

            <table id="networksRU">
                <thead>
<?php include $inc_lang.'results-trth.inc' ?>
                </thead>
                <tbody>

                    <?php CreateNewFullEntry( "RU-SPB-TransportSpb", "ru", "Конфигурация" ); ?>

                </tbody>
            </table>

        </main> <!-- main -->

        <hr />

<?php include $inc_lang.'footer.inc' ?>

      </div> <!-- wrapper -->
    </body>
</html>
