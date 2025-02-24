<!DOCTYPE html>
<html lang="en">

<?php $title="Test GTFS to CSV injection"; include('html-head.inc'); ?>

<?php     include('../script/gtfs-inject.php');
?>

    <body>

<?php if ( isset($network) ) { $found = ReadDetails( $network ); } else { $found = ''; } ?>

      <div id="wrapper">

<?php include "header.inc" ?>

        <nav id="navigation">
            <h2 id="en">Test GTFS to CSV injection <?php if ( $found ) { printf( "for %s", $network ); } ?></h2>
            <ul>
                <li><a href="#result">Result</a></li>
                <li><a href="#details">Details</a></li>
                <li><a href="#logging">Logging</a>
                    <ul>
                        <li><a href="#logging-read">Logging "read Wiki page"</a></li>
                        <li><a href="#logging-inject">Logging "inject into Wiki page"</a></li>
                    </ul>
                </li>
             </ul>
        </nav>

        <hr />

        <main id="main" class="results">

            <?php PerformInjection( $network ); ?>

            <h2 id="result">Result</h2>
            <div class="indent">
                <p>This is currently the original file from the OSM wiki. Injection does not take place at the moment.
                </p>
                <?php PrintInjectionLogs( 'injected' ); ?>
            </div>

            <hr />

            <h2 id="details">Details</h2>
            <div class="indent">
                <p>Lore ipsum
                </p>
            </div>

            <hr />

            <h2 id="logging">Logging</h2>
            <div class="indent">
                <h3 id="logging-read">Logging "read Wiki page"</h3>
                <div class="indent">
                    <?php PrintInjectionLogs( 'read' ); ?>
                </div>

                <hr />

                <h3 id="logging-inject">Logging "inject into Wiki page"</h3>
                <div class="indent">
                    <?php PrintInjectionLogs( 'injection' ); ?>
                </div>

            </div>

            <?php DeleteTempFiles(); ?>

        </main> <!-- main -->

        <hr />

<?php include "footer.inc" ?>

      </div> <!-- wrapper -->
    </body>
</html>
