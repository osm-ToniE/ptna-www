<!DOCTYPE html>
<html lang="nl">

<?php $title="Results"; $inc_lang='../../nl/'; include $inc_lang.'html-head.inc'; ?>

<?php include('../../script/entries.php'); ?>

    <body>
      <div id="wrapper">

<?php include $inc_lang.'header.inc' ?>

        <main id="main" class="results">

            <h2 id="NL"><img src="/img/Netherlands32.png" alt="Vlag van Nederland" /> Resultaten voor Nederland</h2>

<?php include $inc_lang.'results-head.inc' ?>

            <!-- see also https://wiki.openstreetmap.org/wiki/NL-OV/PTNA -->

            <h2 id="spoorwegvervoer">Spoorwegvervoer in Nederland</h2>
            <table id="networksNLtrain">
                <thead>
<?php include $inc_lang.'results-trth.inc' ?>
                </thead>
                <tbody>
                    <?php CreateNewFullEntry( "NL-HRN", "nl", "Configuratie" ); ?>
                </tbody>
            </table>

            <hr />

            <h2 id="verdervervoer">Verder lokaal openbaar vervoer</h2>
            <table id="networksNLverder">
                <thead>
<?php include $inc_lang.'results-trth.inc' ?>
                </thead>
                <tbody>
                    <!-- NL-FL_GE_OV-IJV    IJssel-Vecht 	                                        Provincies Flevoland, Gelderland en Overijssel  -->
                    <?php CreateNewFullEntry( "NL-FL_GE_OV-IJV", "nl", "Configuratie wordt voorbereid" ); ?>

                    <!-- NL-FL-ALM 	        Busvervoer Almere 	                                    Gemeente Almere -->
                    <?php CreateNewFullEntry( "NL-FL-ALM", "nl", "Configuratie wordt voorbereid" ); ?>

                    <!-- NL-FL-ASL 	        Airport Shuttle Lelystad 	                            Provincie Flevoland -->
                    <?php CreateNewFullEntry( "NL-FL-ASL", "nl", "Configuratie wordt voorbereid" ); ?>

                    <!-- NL-FR-FR 	        Fryslân 	                                            Provincie Fryslân -->
                    <?php CreateNewFullEntry( "NL-FR-FR", "nl", "Configuratie wordt voorbereid" ); ?>

                    <!-- NL-GE-AN 	        Arnhem Nijmegen 	                                    Provincie Gelderland -->
                    <?php CreateNewFullEntry( "NL-GE-AN", "nl", "Configuratie" ); ?>

                    <!-- NL-GE-ARL 	        Achterhoek-Rivierenland                                 Provincie Gelderland -->
                    <?php CreateNewFullEntry( "NL-GE-ARL", "nl", "Configuratie" ); ?>

                    <!-- NL-GE-VL 	        Treindienst Amersfoort - Ede-Wageningen (Valleilijn) 	Provincie Gelderland -->
                    <?php CreateNewFullEntry( "NL-GE-VL", "nl", "Configuratie" ); ?>

                    <!-- NL-GE-VZ 	        Veluwe-Zuid 	                                        Provincie Gelderland -->
                    <?php CreateNewFullEntry( "NL-GE-VZ", "nl", "Configuratie" ); ?>

                    <!-- NL-GR_DR-GD  	    Publiek Vervoer Groningen-Drenthe 	                    OV-bureau Groningen-Drenthe (OVBGD) -->
                    <?php CreateNewFullEntry( "NL-GR_DR-GD", "nl", "Configuratie wordt voorbereid" ); ?>

                    <!-- NL-GR_DR-GGD 	    Groningen-Drenthe 	                                    OV-bureau Groningen-Drenthe (OVBGD) -->
                    <?php CreateNewFullEntry( "NL-GR_DR-GGD", "nl", "Configuratie wordt voorbereid" ); ?>

                    <!-- NL-GR_FR-RSFG  	Regionaal spoorvervoer Fryslân en Groningen 	        Provincies Groningen, Fryslân en LNVG Niedersachsen -->
                    <?php CreateNewFullEntry( "NL-GR_FR-RSFG", "nl", "Configuratie wordt voorbereid" ); ?>

                    <!-- NL-LI-LI  	        Limburg 	                                            Provincie Limburg -->
                    <?php CreateNewFullEntry( "NL-LI-LI", "nl", "Configuratie wordt voorbereid" ); ?>

                    <!-- NL-NB-OB 	        Oost-Brabant 	                                        Provincie Noord-Brabant -->
                    <?php CreateNewFullEntry( "NL-NB-OB", "nl", "Configuratie wordt voorbereid" ); ?>

                    <!-- NL-NB-WB 	 	    West-Brabant 	                                        Provincie Noord-Brabant -->
                    <?php CreateNewFullEntry( "NL-NB-WB", "nl", "Configuratie wordt voorbereid" ); ?>

                    <!-- NL-NB-ZOB 	        Zuidoost-Brabant 	                                    Provincie Noord-Brabant -->
                    <?php CreateNewFullEntry( "NL-NB-ZOB", "nl", "Configuratie wordt voorbereid" ); ?>

                    <!-- NL-NH-AML 	        Amstelland-Meerlanden 	                                Vervoerregio Amsterdam -->
                    <?php CreateNewFullEntry( "NL-NH-AML", "nl", "Configuratie" ); ?>

                    <!-- NL-NH-ASD 	        Stadsvervoer Amsterdam 	                                Vervoerregio Amsterdam -->
                    <?php CreateNewFullEntry( "NL-NH-ASD", "nl", "Configuratie" ); ?>

                    <!-- NL-NH-GV 	        Gooi- en Vechtstreek 	                                Provincie Noord-Holland -->
                    <?php CreateNewFullEntry( "NL-NH-GV", "nl", "Configuratie" ); ?>

                    <!-- NL-NH-HIJ 	        Haarlem-IJmond 	                                        Provincie Noord-Holland -->
                    <?php CreateNewFullEntry( "NL-NH-HIJ", "nl", "Configuratie" ); ?>

                    <!-- NL-NH-NHN 	 	    Noord-Holland Noord 	                                Provincie Noord-Holland -->
                    <?php CreateNewFullEntry( "NL-NH-NHN", "nl", "Configuratie" ); ?>

                    <!-- NL-NH-NZKV 	    IJ- en Noordzeekanaalveren 	                            Gemeente Amsterdam  -->
                    <?php CreateNewFullEntry( "NL-NH-NZKV", "nl", "Configuratie" ); ?>

                    <!-- NL-NH-SHL          Schiphol Landside/Airside 	                            Schiphol -->
                    <?php CreateNewFullEntry( "NL-NH-SHL", "nl", "Configuratie" ); ?>

                    <!-- NL-NH-ZAWA         Zaanstreek-Waterland 	                                Vervoerregio Amsterdam -->
                    <?php CreateNewFullEntry( "NL-NH-ZAWA", "nl", "Configuratie" ); ?>

                    <!-- NL-OV_DR-VDL       Vechtdallijnen 	                                        Provincies Overijssel en Drenthe -->
                    <?php CreateNewFullEntry( "NL-OV_DR-VDL", "nl", "Configuratie wordt voorbereid" ); ?>

                    <!-- NL-OV-TW 	        Twente 	                                                Provincie Overijssel -->
                    <?php CreateNewFullEntry( "NL-OV-TW", "nl", "Configuratie wordt voorbereid" ); ?>

                    <!-- NL-OV-ZKZE 	    Zwolle - Kampen en Zwolle - Enschede 	                Provincie Overijssel -->
                    <?php CreateNewFullEntry( "NL-OV-ZKZE", "nl", "Configuratie wordt voorbereid" ); ?>

                    <!-- NL-UT-PU 	        Provincie Utrecht 	                                    Provincie Utrecht -->
                    <?php CreateNewFullEntry( "NL-UT-PU", "nl", "Configuratie wordt voorbereid" ); ?>

                    <!-- NL-UT-RU 	        Regio Utrecht 	                                        Provincie Utrecht -->
                    <?php CreateNewFullEntry( "NL-UT-RU", "nl", "Configuratie wordt voorbereid" ); ?>

                    <!-- NL-ZE-FFVB 	    Fast Ferry Vlissingen-Breskens 	                        Provincie Zeeland -->
                    <?php CreateNewFullEntry( "NL-ZE-FFVB", "nl", "Configuratie wordt voorbereid" ); ?>

                    <!-- NL-ZE-ZE  	        Zeeland 	                                            Provincie Zeeland -->
                    <?php CreateNewFullEntry( "NL-ZE-ZE", "nl", "Configuratie wordt voorbereid" ); ?>

                    <!-- NL-ZH-DMG 	        Drechtsteden, Molenlanden en Gorinchem 	                Provincie Zuid-Holland -->
                    <?php CreateNewFullEntry( "NL-ZH-DMG", "nl", "Configuratie wordt voorbereid" ); ?>

                    <!-- NL-ZH-GA 	        Treindienst Gouda-Alphen aan den Rijn 	                Provincie Zuid-Holland  -->
                    <?php CreateNewFullEntry( "NL-ZH-GA", "nl", "Configuratie wordt voorbereid" ); ?>

                    <!-- NL-ZH-HLSTD 	    Gaaglanden Stad 	                                    MRDH -->
                    <?php CreateNewFullEntry( "NL-ZH-HLSTD", "nl", "Configuratie wordt voorbereid" ); ?>

                    <!-- NL-ZH-HLSTR 	    Haaglanden Streek 	                                    MRDH -->
                    <?php CreateNewFullEntry( "NL-ZH-HLSTR", "nl", "Configuratie wordt voorbereid" ); ?>

                    <!-- NL-ZH-HWGO         Hoeksche Waard - Goeree-Overflakkee 	                Provincie Zuid-Holland -->
                    <?php CreateNewFullEntry( "NL-ZH-HWGO", "nl", "Configuratie wordt voorbereid" ); ?>

                    <!-- NL-ZH-PS 	        Parkshuttle Rivium 	                                    MRDH -->
                    <?php CreateNewFullEntry( "NL-ZH-PS", "nl", "Configuratie wordt voorbereid" ); ?>

                    <!-- NL-ZH-RDH 	 	    Rail Haaglanden 	                                    MRDH -->
                    <?php CreateNewFullEntry( "NL-ZH-RDH", "nl", "Configuratie wordt voorbereid" ); ?>

                    <!-- NL-ZH-RRTD 	 	Rail Rotterdam 	                                        MRDH -->
                    <?php CreateNewFullEntry( "NL-ZH-RRTD", "nl", "Configuratie wordt voorbereid" ); ?>

                    <!-- NL-ZH-RTD_BUS 	    Bus Rotterdam 	                                        MRDH -->
                    <?php CreateNewFullEntry( "NL-ZH-RTD_BUS", "nl", "Configuratie wordt voorbereid" ); ?>

                    <!-- NL-ZH-VKL          Veer Kop van 't Land 	                                Gemeente Dordrecht -->
                    <?php CreateNewFullEntry( "NL-ZH-VKL", "nl", "Configuratie wordt voorbereid" ); ?>

                    <!-- NL-ZH-VR  	        Voorne-Putten en Rozenburg 	                            MRDH -->
                    <?php CreateNewFullEntry( "NL-ZH-VR", "nl", "Configuratie wordt voorbereid" ); ?>

                    <!-- NL-ZH-WRD  	    Personenvervoer over water Rotterdam - Drechtsteden 	Provincie Zuid-Holland -->
                    <?php CreateNewFullEntry( "NL-ZH-WRD", "nl", "Configuratie wordt voorbereid" ); ?>

                    <!-- NL-ZH-WRS  	    Personenvervoer over water in Rotterdam en Schiedam 	MRDH, Gemeente Rotterdam, Havenbedrijf Rotterdam  -->
                    <?php CreateNewFullEntry( "NL-ZH-WRS ", "nl", "Configuratie wordt voorbereid" ); ?>

                    <!-- NL-ZH-ZHN  	    Zuid-Holland Noord 	                                    Provincie Zuid-Holland -->
                    <?php CreateNewFullEntry( "NL-ZH-ZHN", "nl", "Configuratie wordt voorbereid" ); ?>

                </tbody>
            </table>

        </main> <!-- main -->

        <hr />

<?php include $inc_lang.'footer.inc' ?>

      </div> <!-- wrapper -->
    </body>
</html>
