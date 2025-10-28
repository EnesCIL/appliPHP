<?php
session_start();


?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="style.css">
        <title>Ajout produit</title>
    </head>
    <body>
        <div id = "wrapper"> 
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
        <h1>Ajouter un produit</h1>
        <form action="traitement.php?action=add" method="post"> 
            <p>
                <label>
                    Nom du produit :
                    <input type="text" name="name">
                </label>
            </p>
            <p>
                <label>
                    Prix du produit :
                    <input type="number" step="any" name="price" min=0>
                </label>
            </p>
            <p>
                <label>
                    Quantité désirée :
                    <input type="number" name="qtt" value="1" min=1>
                </label>
            </p>
            <p>
                <input type="submit" name="submit" value="Ajouter le produit">
            </p>
        </form>    
        <?php
    # Affiche un message de confirmation ou d'erreur stocké dans la session
    if(isset($_SESSION['message'])){
        echo '<p id="message">'.$_SESSION['message'].'</p>';
        unset($_SESSION['message']); // on vide le message après affichage
    }  
?>
      </div>
</body>
</html>