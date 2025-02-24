<!DOCTYPE html>
<html lang="en">

<?php $title="Test GTFS to CSV injection"; include('html-head.inc'); ?>

<?php include('../script/config.php'); ?>

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
                        <li><a href="#logging-stdout">Logging by injection code</a></li>
                        <li><a href="#logging-stderr">Logging by Python</a></li>
                    </ul>
                </li>
             </ul>
        </nav>

        <hr />

        <main id="main" class="results">

            <h2 id="result">Result</h2>
            <div class="indent">

                <p>Lore ipsum
                </p>

                <?php if ( $found ) {
                          echo "<p>Lore ipsum</p>\n";
                      }
                ?>
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
                <p>Lore ipsum
                </p>

                <h3 id="logging-stdout">Logging by injection code</h3>
                <div class="indent">
                    <p>Lore ipsum
                    </p>
                </div>

                <h3 id="logging-stderr">Logging by Python</h3>
                <div class="indent">
                    <p>Lore ipsum
                    </p>
                </div>
            </div>

        </main> <!-- main -->

        <hr />

<?php include "footer.inc" ?>

      </div> <!-- wrapper -->
    </body>
</html>
