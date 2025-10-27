<?php
    session_start()
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Récapitulatif des produits</title>
</head>
<body>
        <nav>
            <a href="index.php">Ajouter un protduit</a>
            <a href="recap.php">Voir le récapitulatif</a>
            <?php
                if(!isset($_SESSION['products']) || empty ($_SESSION['products'])){  
                    // s'il n'y a pas de tableau products en session OU que le tableau products est vide alors
                    echo "Articles dans la session : 0";
                } else {
                    echo "Articles dans la session : " . count($_SESSION['products']);
                }
            ?>

        <nav>
    <?php 
        if(!isset($_SESSION['products']) || empty ($_SESSION['products'])){  
            // s'il n'y a pas de tableau products en session OU que le tableau products est vide alors
            echo "<p> Aucun produit en session.....</p>";
        }
        else{
            echo "<table>",
            //tableau  
                    "<thead>",
                    //<thead> l'en-tête des colonnes d'un tableau.
                        "<tr>",
                        // <tr> définit une ligne de cellules dans un tableau
                            "<th>#</th>",
                            "<th>Nom</th>",
                            "<th>Prix</th>",
                            "<th>Quantité</th>",
                            "<th>Total</th>",
                            "<th>Actions</th>",
                        "</tr>",
                    "</thead>",
                    "<tbody>";
            $totalGeneral = 0;
            
        foreach($_SESSION['products'] as $index => $product ){
            // pour chaque produit présent dans le tableau 'products' de la session,
            // on récupère à la fois la clé (index) et le contenu du produit (product)
            echo "<tr>",
                        "<td>" .$index. "</td>",
                        "<td>" .$product['name']. "</td>",
                        "<td>" .number_format($product['price'], 2, ",", "&nbsp;"). "&nbsp;€</td>",
                        // on affiche le prix du produit formaté avec 2 chiffres après la virgule,
                        // une virgule comme séparateur décimal et une espace insécable pour les milliers,
                        // puis on ajoute le symbole "€"
                        "<td>" .$product['qtt']. "</td>",
                        "<td>" .number_format($product['total'], 2, ",", "&nbsp;"). "&nbsp;€</td>",
                        "<td><a href=" . 'traitement.php?action=delete&id=' . $index . ">Delete</a>
                        <a href=" . 'traitement.php?action=up-qtt&id=' . $index . "&qtt=" . $product['qtt'] .">Up qtt</a>
                        <a href=" . 'traitement.php?action=down-qtt&id=' . $index . "&qtt=" . $product['qtt'] .">Down qtt</a>
                        </td>",
                    "</tr>";
                $totalGeneral += $product['total'];

        }
            echo "<tr>",
                        "<td colspan=4>Total général : </td>",
                // on crée une cellule de tableau (<td>) qui s’étend sur 4 colonnes,
                // et on y affiche le texte "Total général :"
                        "<td><strong>" .number_format($totalGeneral, 2, ",", "&nbsp;")."&nbsp;€</strong></td>",
                // on affiche le total général en gras, formaté avec 2 chiffres après la virgule,
                // une virgule comme séparateur décimal, une espace insécable pour les milliers,
                // puis on ajoute le symbole "€"
                    "</tr>",  
                "</tbody>",
                "</table>";
        }

        // var_dump($_SESSION['products'])
    ?>

    <a href="traitement.php?action=clear">Clear session</a>
</body>
</html>