<?php
    echo "                <p>\n";
    echo "                    A segunda coluna da tabela contém um link para a análise dos dados GTFS para cada trajeto (arquivo trips.txt do GTFS) da linha.\n";
    echo "                </p>\n";

    if ( $comment ) {
        echo "                <p>\n";
        echo "                    Uma observação foi adicionada a esta linha:\n";
        echo "                </p>\n";
        echo "                <ul>\n";
        echo "                    <li><strong>"  . preg_replace("/\n/","</strong></li>\n                    <li><strong>", HandlePtnaComment($comment)) . "</strong></li>\n";
        echo "                </ul>\n";
    }
?>
