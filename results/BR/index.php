<!DOCTYPE html>
<html lang="pt-BR">

<?php $title="Resultados"; $inc_lang='../../pt_BR/'; include $inc_lang.'html-head.inc'; ?>

<?php include('../../script/entries.php'); ?>

    <body>
      <div id="wrapper">
      
<?php include $inc_lang.'header.inc' ?>

        <main id="main" class="results">

            <h2 id="BR"><img src="/img/Brasil32.png" alt="bandeira do brasil" /> Resultados para o Brasil</h2>

<?php include $inc_lang.'results-head.inc' ?>

            <table id="networksBR">
                <thead>
<?php include $inc_lang.'results-trth.inc' ?>
                </thead>
                <tbody>

                    <?php CreateNewFullEntry( "BR-MG-BHTrans", "pt_BR", "Configuração" ); ?>

                </tbody>
            </table>

        </main> <!-- main -->

        <hr />

<?php include $inc_lang.'footer.inc' ?>

      </div> <!-- wrapper -->
    </body>
</html>

