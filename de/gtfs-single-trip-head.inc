                <p>
                    Lorem ipsum dolor sit amet, consectetur adipisici elit, …  
                </p>
    
<?php if ( $comment ) {
echo "                <p>\n";
echo "                    Diese Variante wurde mit einem Kommentar versehen:\n";
echo "                </p>\n";
echo "                <ul>\n";
echo "                    <li>Kommentar: '<strong>"  . htmlspecialchars($comment) . "</strong>'</li>\n";
echo "                </ul>\n";    
       }
?>
