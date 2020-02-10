<!DOCTYPE html>
<html lang="en">

<?php $title="Results"; $inc_lang='../../en/'; include $inc_lang.'html-head.inc'; ?>

<?php include('../../script/entries.php'); ?>

    <body>
      <div id="wrapper">
      
<?php include $inc_lang.'header.inc' ?>

        <nav id="navigation">
            <h2 id="CH"><img src="/img/Switzerland32.png" alt="Schweizerfahne" /> Schweiz / Suisse / Svizzera</h2>
            <ul>
                <li><a href="#CH-de">Ergebnisse für die deutsch-sprachige Schweiz</a></li>
                <li><a href="#CH-fr">Résultats pour la Suisse romande</a></li>
                <li><a href="#CH-it">Risultati per la Svizzera italiana</a></li>
             </ul>
        </nav>

        <hr />

        <main id="main" class="results">

            <h2 id="CH-de"><img src="/img/Germany16.png" alt="deutsche Flagge" /> Ergebnisse für die deutsch-sprachige Schweiz</h2>

<?php $inc_lang='../../de/'; include $inc_lang.'results-head.inc' ?>

            <table id="networksCH-de">
                <thead>
<?php $inc_lang='../../de/'; include $inc_lang.'results-trth.inc' ?>
                </thead>
                <tbody>

                    <?php CreateNewFullEntry( "CH-KtUR", "de", "Konfiguration" ); ?>

                    <?php CreateNewFullEntry( "CH-OTV", "de", "Konfiguration" ); ?>

                    <?php CreateNewFullEntry( "CH-TNW", "de", "Konfiguration" ); ?>

                    <?php CreateNewFullEntry( "CH-TV_BE+SO", "de", "Konfiguration" ); ?>
                    
                    <?php CreateNewFullEntry( "CH-TVAG", "de", "Konfiguration" ); ?>

                    <?php CreateNewFullEntry( "CH-TVLU", "de", "Konfiguration" ); ?>

                    <?php CreateNewFullEntry( "CH-TVOEng", "de", "Konfiguration" ); ?>

                    <?php CreateNewFullEntry( "CH-TVSZ", "de", "Konfiguration" ); ?>

                    <?php CreateNewFullEntry( "CH-TVZG", "de", "Konfiguration" ); ?>

                    <?php CreateNewFullEntry( "CH-ZVV", "de", "Konfiguration" ); ?>
                    
                </tbody>
            </table>

            <hr />
            
            <h2 id="CH-fr"><img src="/img/France16.png" alt="La France" /> Résultats pour la Suisse romande</h2>

<?php $inc_lang='../../fr/'; include $inc_lang.'results-head.inc' ?>

            <table id="networksCH-fr">
                <thead>
<?php $inc_lang='../../fr/'; include $inc_lang.'results-trth.inc' ?>
                </thead>
                <tbody>

                    <?php CreateNewFullEntry( "CH-CTGE", "fr", "Configuration" ); ?>

                    <?php CreateNewFullEntry( "CH-CTIFR", "fr", "Configuration" ); ?>

                    <?php CreateNewFullEntry( "CH-CTNE", "fr", "Configuration" ); ?>

                    <?php CreateNewFullEntry( "CH-CTV", "fr", "Configuration" ); ?>

                    <?php CreateNewFullEntry( "CH-CtVS", "fr", "Configuration" ); ?>

                </tbody>
            </table>

            <hr />

            <h2 id="CH-it"><img src="/img/Italy16.png" alt="Italia" /> Risultati per la Svizzera italiana</h2>

<?php $inc_lang='../../it/'; include $inc_lang.'results-head.inc' ?>

            <table id="networksCH-it">
                <thead>
<?php $inc_lang='../../it/'; include $inc_lang.'results-trth.inc' ?>
                </thead>
                <tbody>

                    <?php CreateNewFullEntry( "CH-CTM", "it", "Configurazione" ); ?>
                    
                </tbody>
            </table>

        </main> <!-- main -->

        <hr />

<?php $inc_lang='../../de/'; include $inc_lang.'footer.inc' ?>

        <hr />

<?php $inc_lang='../../fr/'; include $inc_lang.'footer.inc' ?>

        <hr />

<?php $inc_lang='../../it/'; include $inc_lang.'footer.inc' ?>

      </div> <!-- wrapper -->
    </body>
</html>

