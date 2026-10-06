<?php include( '../../script/check-request.php' ); ?>
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
                    <?php CreateNewFullEntry( "FR-SNCF",    "fr", "Configuration" ); ?>
                    <?php CreateNewFullEntry( "FR-ARA-TER", "fr", "Configuration" ); ?>
                    <?php CreateNewFullEntry( "FR-BFC-TER", "fr", "Configuration" ); ?>
                    <?php CreateNewFullEntry( "FR-BRE-TER", "fr", "Configuration" ); ?>
                    <?php CreateNewFullEntry( "FR-CVL-TER", "fr", "Configuration" ); ?>
                    <?php CreateNewFullEntry( "FR-GES-TER", "fr", "Configuration" ); ?>
                    <?php CreateNewFullEntry( "FR-HDF-TER", "fr", "Configuration" ); ?>
                    <?php CreateNewFullEntry( "FR-NAQ-TER", "fr", "Configuration" ); ?>
                    <?php CreateNewFullEntry( "FR-NOR-TER", "fr", "Configuration" ); ?>
                    <?php CreateNewFullEntry( "FR-OCC-TER", "fr", "Configuration" ); ?>
                    <?php CreateNewFullEntry( "FR-PAC-TER", "fr", "Configuration" ); ?>
                    <?php CreateNewFullEntry( "FR-PDL-TER", "fr", "Configuration" ); ?>
                    <?php CreateNewFullEntry( "FR-20R-CFC", "fr", "Configuration" ); ?>
                </tbody>
            </table>

            <hr />

            <h2 id="others">Autres transports publics par région</h2>
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
                    <?php CreateNewFullEntry("FR-BRE-BREIZHGO_CAR_22", "fr", "Configuration" ); ?>
                    <?php CreateNewFullEntry("FR-BRE-BREIZHGO_CAR_29", "fr", "Configuration" ); ?>
                    <?php CreateNewFullEntry("FR-BRE-BREIZHGO_CAR_35", "fr", "Configuration" ); ?>
                    <?php CreateNewFullEntry("FR-BRE-BREIZHGO_CAR_56", "fr", "Configuration" ); ?>
                    <?php CreateNewFullEntry("FR-BRE-BREIZHGO_CAR_NS", "fr", "Configuration" ); ?>
                    <?php CreateNewFullEntry("FR-BRE-BREIZHGO_CAR_RLP", "fr", "Configuration" ); ?>
                    <?php CreateNewFullEntry("FR-BRE-Coralie", "fr", "Configuration" ); ?>
                    <?php CreateNewFullEntry("FR-BRE-Dinamo", "fr", "Configuration" ); ?>
                    <?php CreateNewFullEntry("FR-BRE-Distribus", "fr", "Configuration" ); ?>
                    <?php CreateNewFullEntry("FR-BRE-Glazgo", "fr", "Configuration" ); ?>
                    <?php CreateNewFullEntry("FR-BRE-IZILO", "fr", "Configuration" ); ?>
                    <?php CreateNewFullEntry("FR-BRE-KICEO", "fr", "Configuration" ); ?>
                    <?php CreateNewFullEntry("FR-BRE-Lineotim", "fr", "Configuration" ); ?>
                    <?php CreateNewFullEntry("FR-BRE-MAT", "fr", "Configuration" ); ?>
                    <?php CreateNewFullEntry("FR-BRE-MOVA", "fr", "Configuration" ); ?>
                    <?php CreateNewFullEntry("FR-BRE-PONDIBUS", "fr", "Configuration" ); ?>
                    <?php CreateNewFullEntry("FR-BRE-QUB", "fr", "Configuration" ); ?>
                    <?php CreateNewFullEntry("FR-BRE-Star", "fr", "Configuration" ); ?>
                    <?php CreateNewFullEntry("FR-BRE-SURF", "fr", "Configuration" ); ?>
                    <?php CreateNewFullEntry("FR-BRE-TBK", "fr", "Configuration" ); ?>
                    <?php CreateNewFullEntry("FR-BRE-TILT", "fr", "Configuration" ); ?>
                    <?php CreateNewFullEntry("FR-BRE-TUB", "fr", "Configuration" ); ?>
                    <?php CreateNewFullEntry("FR-BRE-TUDBUS", "fr", "Configuration" ); ?>
                    <?php CreateNewFullEntry("FR-CVL-FB", "fr", "Configuration" ); ?>
                    <?php CreateNewFullEntry("FR-CVL-Remi", "fr", "Configuration" ); ?>
                    <?php CreateNewFullEntry("FR-CVL-TAO", "fr", "Configuration" ); ?>
                    <?php CreateNewFullEntry("FR-GES-Colibri", "fr", "Configuration" ); ?>
                    <?php CreateNewFullEntry("FR-GES-CTS", "fr", "Configuration" ); ?>
                    <?php CreateNewFullEntry("FR-GES-STAN", "fr", "Configuration" ); ?>
                    <?php CreateNewFullEntry("FR-IDF-argenteuil-boucles-de-seine", "fr", "Configuration" ); ?>
                    <?php CreateNewFullEntry("FR-IDF-bievre", "fr", "Configuration" ); ?>
                    <?php CreateNewFullEntry("FR-IDF-bord-de-marne", "fr", "Configuration" ); ?>
                    <?php CreateNewFullEntry("FR-IDF-boucles-nord-de-seine", "fr", "Configuration" ); ?>
                    <?php CreateNewFullEntry("FR-IDF-brie-et-2-morin", "fr", "Configuration" ); ?>
                    <?php CreateNewFullEntry("FR-IDF-centre-et-sud-yvelines", "fr", "Configuration" ); ?>
                    <?php CreateNewFullEntry("FR-IDF-cergy-pontoise-confluence", "fr", "Configuration" ); ?>
                    <?php CreateNewFullEntry("FR-IDF-coeur-d-essonne", "fr", "Configuration" ); ?>
                    <?php CreateNewFullEntry("FR-IDF-croix-du-sud", "fr", "Configuration" ); ?>
                    <?php CreateNewFullEntry("FR-IDF-essonne-sud-est", "fr", "Configuration" ); ?>
                    <?php CreateNewFullEntry("FR-IDF-essonne-sud-ouest", "fr", "Configuration" ); ?>
                    <?php CreateNewFullEntry("FR-IDF-evry-centre-essonne", "fr", "Configuration" ); ?>
                    <?php CreateNewFullEntry("FR-IDF-express-roissy", "fr", "Configuration" ); ?>
                    <?php CreateNewFullEntry("FR-IDF-fontainebleau-moret", "fr", "Configuration" ); ?>
                    <?php CreateNewFullEntry("FR-IDF-grand-melun", "fr", "Configuration" ); ?>
                    <?php CreateNewFullEntry("FR-IDF-grand-versailles", "fr", "Configuration" ); ?>
                    <?php CreateNewFullEntry("FR-IDF-haut-val-d-oise", "fr", "Configuration" ); ?>
                    <?php CreateNewFullEntry("FR-IDF-la-defense-saint-cloud", "fr", "Configuration" ); ?>
                    <?php CreateNewFullEntry("FR-IDF-lignes-ile-de-france-ouest", "fr", "Configuration" ); ?>
                    <?php CreateNewFullEntry("FR-IDF-mantois", "fr", "Configuration" ); ?>
                    <?php CreateNewFullEntry("FR-IDF-marne-et-brie", "fr", "Configuration" ); ?>
                    <?php CreateNewFullEntry("FR-IDF-marne-et-seine", "fr", "Configuration" ); ?>
                    <?php CreateNewFullEntry("FR-IDF-marne-la-vallee", "fr", "Configuration" ); ?>
                    <?php CreateNewFullEntry("FR-IDF-massy-juvisy", "fr", "Configuration" ); ?>
                    <?php CreateNewFullEntry("FR-IDF-meaux-et-ourcq", "fr", "Configuration" ); ?>
                    <?php CreateNewFullEntry("FR-IDF-ourcq", "fr", "Configuration" ); ?>
                    <?php CreateNewFullEntry("FR-IDF-paris-saclay", "fr", "Configuration" ); ?>
                    <?php CreateNewFullEntry("FR-IDF-pays-briard", "fr", "Configuration" ); ?>
                    <?php CreateNewFullEntry("FR-IDF-pays-de-montereau", "fr", "Configuration" ); ?>
                    <?php CreateNewFullEntry("FR-IDF-plaine-saint-denis", "fr", "Configuration" ); ?>
                    <?php CreateNewFullEntry("FR-IDF-poissy-les-mureaux", "fr", "Configuration" ); ?>
                    <?php CreateNewFullEntry("FR-IDF-pompadour", "fr", "Configuration" ); ?>
                    <?php CreateNewFullEntry("FR-IDF-provinois-brie-et-seine", "fr", "Configuration" ); ?>
                    <?php CreateNewFullEntry("FR-IDF-roissy-est", "fr", "Configuration" ); ?>
                    <?php CreateNewFullEntry("FR-IDF-roissy-ouest", "fr", "Configuration" ); ?>
                    <?php CreateNewFullEntry("FR-IDF-saint-germain-boucles-de-seine", "fr", "Configuration" ); ?>
                    <?php CreateNewFullEntry("FR-IDF-saint-quentin-en-yvelines", "fr", "Configuration" ); ?>
                    <?php CreateNewFullEntry("FR-IDF-seine-orly", "fr", "Configuration" ); ?>
                    <?php CreateNewFullEntry("FR-IDF-senart", "fr", "Configuration" ); ?>
                    <?php CreateNewFullEntry("FR-IDF-terres-d-envol", "fr", "Configuration" ); ?>
                    <?php CreateNewFullEntry("FR-IDF-val-d-yerres-val-de-seine", "fr", "Configuration" ); ?>
                    <?php CreateNewFullEntry("FR-IDF-val-parisis", "fr", "Configuration" ); ?>
                    <?php CreateNewFullEntry("FR-IDF-vallee-de-montmorency", "fr", "Configuration" ); ?>
                    <?php CreateNewFullEntry("FR-IDF-vallee-du-loing-nemours", "fr", "Configuration" ); ?>
                    <?php CreateNewFullEntry("FR-IDF-vallee-sud-grand-paris", "fr", "Configuration" ); ?>
                    <?php CreateNewFullEntry("FR-IDF-velizy-vallees", "fr", "Configuration" ); ?>
                    <?php CreateNewFullEntry("FR-IDF-vexin", "fr", "Configuration" ); ?>
                    <?php CreateNewFullEntry("FR-NAQ-CarsRegionaux_17", "fr", "Configuration" ); ?>
                    <?php CreateNewFullEntry("FR-NAQ-RespiRe", "fr", "Configuration" ); ?>
                    <?php CreateNewFullEntry("FR-NAQ-TBM", "fr", "Configuration" ); ?>
                    <?php CreateNewFullEntry("FR-NAQ-Yelo", "fr", "Configuration" ); ?>
                    <?php CreateNewFullEntry("FR-NOR-Altobus", "fr", "Configuration" ); ?>
                    <?php CreateNewFullEntry("FR-NOR-Astuce", "fr", "Configuration" ); ?>
                    <?php CreateNewFullEntry("FR-NOR-Atoumod", "fr", "Configuration" ); ?>
                    <?php CreateNewFullEntry("FR-NOR-Cap_Cotentin", "fr", "Configuration" ); ?>
                    <?php CreateNewFullEntry("FR-NOR-Cosibus", "fr", "Configuration" ); ?>
                    <?php CreateNewFullEntry("FR-NOR-Hobus", "fr", "Configuration" ); ?>
                    <?php CreateNewFullEntry("FR-NOR-LiA", "fr", "Configuration" ); ?>
                    <?php CreateNewFullEntry("FR-NOR-NavetteMSM", "fr", "Configuration" ); ?>
                    <?php CreateNewFullEntry("FR-NOR-Neva", "fr", "Configuration" ); ?>
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
                    <?php CreateNewFullEntry("FR-PDL-Aleop_44", "fr", "Configuration" ); ?>
                    <?php CreateNewFullEntry("FR-PDL-Irigo", "fr", "Configuration" ); ?>
                </tbody>
            </table>

        </main> <!-- main -->

        <hr />

<?php include $inc_lang.'footer.inc' ?>

      </div> <!-- wrapper -->
    </body>
</html>
