<?php
    echo "                <p>\n";
    echo "                    A segunda coluna da tabela contém um link para a análise dos dados GTFS para cada trajeto (arquivo trips.txt do GTFS) da linha.\n";
    echo "                </p>\n";
    echo "                <p>\n";
    echo "                    A terceira coluna da tabela contém um cálculo aproximado do número de viagens no período de validade.\n";
    echo "                    Quando aplicável, o número de viagens, incluindo os sub-percursos, é indicado entre parênteses. Apenas para dados analisados em julho de 2023 ou posteriormente.\n";
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
