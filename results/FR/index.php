<!DOCTYPE html>
<html lang="fr">

<?php $title="Résultats"; $inc_lang='../../fr/'; include $inc_lang.'html-head.inc'; ?>

<?php include('../../script/entries.php'); ?>

    <body>
      <div id="wrapper">

<?php include $inc_lang.'header.inc' ?>

        <main id="main" class="results">

            <h2 id="FR"><img src="/img/France32.png"  class="flagimg" alt="Drapeau français" /> Résultats pour la France</h2>

<?php include $inc_lang.'results-head.inc' ?>

            <h2 id="trains">Transports ferroviaires en France</h2>
            <table id="networksFRtrain">
                <thead>
<?php include $inc_lang.'results-trth.inc' ?>
                </thead>
                <tbody>

                    <?php CreateNewFullEntry( "FR-SNCF", "fr", "Configuration" ); ?>

                </tbody>
            </table>

            <hr />

            <h2 id="others">Transports publics par région</h2>
            <table id="networksFR">
                <thead>
<?php include $inc_lang.'results-trth.inc' ?>
                </thead>
                <tbody>
                    <?php CreateNewFullEntry("FR-974-Alterneo", "fr", "Configuration" ); ?>

                    <?php CreateNewFullEntry("FR-974-Car_Jaune", "fr", "Configuration" ); ?>

                    <?php CreateNewFullEntry("FR-974-CarSud", "fr", "Configuration" ); ?>

                    <?php CreateNewFullEntry("FR-974-Citalis", "fr", "Configuration" ); ?>

                    <?php CreateNewFullEntry("FR-974-Estival", "fr", "Configuration" ); ?>

                    <?php CreateNewFullEntry("FR-974-KarOuest", "fr", "Configuration" ); ?>

                    <?php CreateNewFullEntry("FR-ARA-Drome", "fr", "Configuration" ); ?>

                    <?php CreateNewFullEntry("FR-ARA-SMTCAC", "fr", "Configuration" ); ?>

                    <?php CreateNewFullEntry("FR-BRE-ARBUS", "fr", "Configuration" ); ?>

                    <?php CreateNewFullEntry("FR-BRE-AXEOBUS", "fr", "Configuration" ); ?>

                    <?php CreateNewFullEntry("FR-BRE-Bibus", "fr", "Configuration" ); ?>

                    <?php CreateNewFullEntry("FR-BRE-CORALIE", "fr", "Configuration" ); ?>

                    <?php CreateNewFullEntry("FR-BRE-Distribus", "fr", "Configuration" ); ?>

                    <?php CreateNewFullEntry("FR-BRE-ILLENOO2", "fr", "Configuration" ); ?>

                    <?php CreateNewFullEntry("FR-BRE-IZILO", "fr", "Configuration" ); ?>

                    <?php CreateNewFullEntry("FR-BRE-LRRNS", "fr", "Configuration" ); ?>

                    <?php CreateNewFullEntry("FR-BRE-LRRON", "fr", "Configuration" ); ?>

                    <?php CreateNewFullEntry("FR-BRE-MAT", "fr", "Configuration" ); ?>

                    <?php CreateNewFullEntry("FR-BRE-PENNARBED", "fr", "Configuration" ); ?>

                    <?php CreateNewFullEntry("FR-BRE-PONDIBUS", "fr", "Configuration" ); ?>

                    <?php CreateNewFullEntry("FR-BRE-QUB", "fr", "Configuration" ); ?>

                    <?php CreateNewFullEntry("FR-BRE-Star", "fr", "Configuration" ); ?>

                    <?php CreateNewFullEntry("FR-BRE-SURF", "fr", "Configuration" ); ?>

                    <?php CreateNewFullEntry("FR-BRE-TIBUS", "fr", "Configuration" ); ?>

                    <?php CreateNewFullEntry("FR-BRE-TILT", "fr", "Configuration" ); ?>

                    <?php CreateNewFullEntry("FR-BRE-TIM", "fr", "Configuration" ); ?>

                    <?php CreateNewFullEntry("FR-BRE-TUDBUS", "fr", "Configuration" ); ?>

                    <?php CreateNewFullEntry("FR-CVL-TAO", "fr", "Configuration" ); ?>

                    <?php CreateNewFullEntry("FR-GES-Colibri", "fr", "Configuration" ); ?>

                    <?php CreateNewFullEntry("FR-GES-CTS", "fr", "Configuration" ); ?>

                    <?php CreateNewFullEntry("FR-GES-STAN", "fr", "Configuration" ); ?>

                    <?php CreateNewFullEntry("FR-IDF-aerial", "fr", "Configuration" ); ?>

                    <?php CreateNewFullEntry("FR-IDF-albatrans", "fr", "Configuration" ); ?>

                    <?php CreateNewFullEntry("FR-IDF-apolo-7", "fr", "Configuration" ); ?>

                    <?php CreateNewFullEntry("FR-IDF-arlequin", "fr", "Configuration" ); ?>

                    <?php CreateNewFullEntry("FR-IDF-bus-en-seine", "fr", "Configuration" ); ?>

                    <?php CreateNewFullEntry("FR-IDF-busval-d-oise", "fr", "Configuration" ); ?>

                    <?php CreateNewFullEntry("FR-IDF-cars-moreau", "fr", "Configuration" ); ?>

                    <?php CreateNewFullEntry("FR-IDF-ceat", "fr", "Configuration" ); ?>

                    <?php CreateNewFullEntry("FR-IDF-cif", "fr", "Configuration" ); ?>

                    <?php CreateNewFullEntry("FR-IDF-com-bus", "fr", "Configuration" ); ?>

                    <?php CreateNewFullEntry("FR-IDF-comete", "fr", "Configuration" ); ?>

                    <?php CreateNewFullEntry("FR-IDF-cso", "fr", "Configuration" ); ?>

                    <?php CreateNewFullEntry("FR-IDF-entre-seine-et-foret", "fr", "Configuration" ); ?>

                    <?php CreateNewFullEntry("FR-IDF-fileo", "fr", "Configuration" ); ?>

                    <?php CreateNewFullEntry("FR-IDF-goelys", "fr", "Configuration" ); ?>

                    <?php CreateNewFullEntry("FR-IDF-houdanais", "fr", "Configuration" ); ?>

                    <?php CreateNewFullEntry("FR-IDF-hourtoule", "fr", "Configuration" ); ?>

                    <?php CreateNewFullEntry("FR-IDF-lacroix", "fr", "Configuration" ); ?>

                    <?php CreateNewFullEntry("FR-IDF-les-cars-bleus", "fr", "Configuration" ); ?>

                    <?php CreateNewFullEntry("FR-IDF-melibus", "fr", "Configuration" ); ?>

                    <?php CreateNewFullEntry("FR-IDF-mobicaps", "fr", "Configuration" ); ?>

                    <?php CreateNewFullEntry("FR-IDF-noctilien", "fr", "Configuration" ); ?>

                    <?php CreateNewFullEntry("FR-IDF-ormont-transport", "fr", "Configuration" ); ?>

                    <?php CreateNewFullEntry("FR-IDF-Peps", "fr", "Configuration" ); ?>

                    <?php CreateNewFullEntry("FR-IDF-paladin", "fr", "Configuration" ); ?>

                    <?php CreateNewFullEntry("FR-IDF-parisis", "fr", "Configuration" ); ?>

                    <?php CreateNewFullEntry("FR-IDF-pays-crecois", "fr", "Configuration" ); ?>

                    <?php CreateNewFullEntry("FR-IDF-pays-de-l-ourcq", "fr", "Configuration" ); ?>

                    <?php CreateNewFullEntry("FR-IDF-pays-de-meaux", "fr", "Configuration" ); ?>

                    <?php CreateNewFullEntry("FR-IDF-pays-fertois", "fr", "Configuration" ); ?>

                    <?php CreateNewFullEntry("FR-IDF-phebus", "fr", "Configuration" ); ?>

                    <?php CreateNewFullEntry("FR-IDF-poissy-aval-deux-rives-de-seine", "fr", "Configuration" ); ?>

                    <?php CreateNewFullEntry("FR-IDF-procars", "fr", "Configuration" ); ?>

                    <?php CreateNewFullEntry("FR-IDF-r-bus", "fr", "Configuration" ); ?>

                    <?php CreateNewFullEntry("FR-IDF-rambouillet-interurbain", "fr", "Configuration" ); ?>

                    <?php CreateNewFullEntry("FR-IDF-reseau-du-canton-de-perthes", "fr", "Configuration" ); ?>

                    <?php CreateNewFullEntry("FR-IDF-savac", "fr", "Configuration" ); ?>

                    <?php CreateNewFullEntry("FR-IDF-seine-et-marne-express", "fr", "Configuration" ); ?>

                    <?php CreateNewFullEntry("FR-IDF-seine-saint-denis", "fr", "Configuration" ); ?>

                    <?php CreateNewFullEntry("FR-IDF-seine-senart-bus", "fr", "Configuration" ); ?>

                    <?php CreateNewFullEntry("FR-IDF-senart-bus", "fr", "Configuration" ); ?>

                    <?php CreateNewFullEntry("FR-IDF-situs", "fr", "Configuration" ); ?>

                    <?php CreateNewFullEntry("FR-IDF-siyonne", "fr", "Configuration" ); ?>

                    <?php CreateNewFullEntry("FR-IDF-sol-r", "fr", "Configuration" ); ?>

                    <?php CreateNewFullEntry("FR-IDF-sqybus", "fr", "Configuration" ); ?>

                    <?php CreateNewFullEntry("FR-IDF-still", "fr", "Configuration" ); ?>

                    <?php CreateNewFullEntry("FR-IDF-stivo", "fr", "Configuration" ); ?>

                    <?php CreateNewFullEntry("FR-IDF-tam", "fr", "Configuration" ); ?>

                    <?php CreateNewFullEntry("FR-IDF-tice", "fr", "Configuration" ); ?>

                    <?php CreateNewFullEntry("FR-IDF-tramy", "fr", "Configuration" ); ?>

                    <?php CreateNewFullEntry("FR-IDF-trans-essonne", "fr", "Configuration" ); ?>

                    <?php CreateNewFullEntry("FR-IDF-transdev-ile-de-france-conflans", "fr", "Configuration" ); ?>

                    <?php CreateNewFullEntry("FR-IDF-transports-daniel-meyer", "fr", "Configuration" ); ?>

                    <?php CreateNewFullEntry("FR-IDF-val-de-seine", "fr", "Configuration" ); ?>

                    <?php CreateNewFullEntry("FR-IDF-vybus", "fr", "Configuration" ); ?>

                    <?php CreateNewFullEntry("FR-IDF-yerres", "fr", "Configuration" ); ?>

                    <?php CreateNewFullEntry("FR-NAQ-TBM", "fr", "Configuration" ); ?>

                    <?php CreateNewFullEntry("FR-NOR-Nomad_Car", "fr", "Configuration" ); ?>

                    <?php CreateNewFullEntry("FR-NOR-Twisto", "fr", "Configuration" ); ?>

                    <?php CreateNewFullEntry("FR-OCC-liO", "fr", "Configuration" ); ?>

                    <?php CreateNewFullEntry("FR-OCC-Tisseo", "fr", "Configuration" ); ?>

                    <?php CreateNewFullEntry("FR-PAC-Alpes-de-Haute-Provence", "fr", "Configuration" ); ?>

                    <?php CreateNewFullEntry("FR-PAC-Alpes-Maritimes", "fr", "Configuration" ); ?>

                    <?php CreateNewFullEntry("FR-PAC-Bouches-du-Rhone", "fr", "Configuration" ); ?>

                    <?php CreateNewFullEntry("FR-PAC-Hautes-Alpes", "fr", "Configuration" ); ?>

                    <?php CreateNewFullEntry("FR-PAC-Lignes-d-Azur", "fr", "Configuration" ); ?>

                    <?php CreateNewFullEntry("FR-PAC-Mistral", "fr", "Configuration" ); ?>

                    <?php CreateNewFullEntry("FR-PAC-Orizo", "fr", "Configuration" ); ?>

                    <?php CreateNewFullEntry("FR-PAC-RTM", "fr", "Configuration" ); ?>

                    <?php CreateNewFullEntry("FR-PAC-Var", "fr", "Configuration" ); ?>

                    <?php CreateNewFullEntry("FR-PAC-Vaucluse", "fr", "Configuration" ); ?>

                    <?php CreateNewFullEntry("FR-PAC-Zou", "fr", "Configuration" ); ?>

                </tbody>
            </table>

        </main> <!-- main -->

        <hr />

<?php include $inc_lang.'footer.inc' ?>

      </div> <!-- wrapper -->
    </body>
</html>
