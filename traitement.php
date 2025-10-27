<?php
    session_start();

   
if(isset($_GET['action'])){
    switch($_GET['action']){
        case "add":
            if(isset($_POST['submit'])){
                $name = filter_input(INPUT_POST,"name", FILTER_SANITIZE_STRING);  //(champ "name") filter supprime une chaîne de caractères de toute présence de caractères spéciaux et de tout baliste HTML,pas injection de code HTML possible
                $price = filter_input(INPUT_POST,"price", FILTER_VALIDATE_FLOAT, FILTER_FLAG_ALLOW_FRACTION); //(champ "price")filter validera le prix que s'il est un nombre à virgule, et le drapeau pour utilisé le caractère "," ou "." pour la décimale
                $qtt = filter_input(INPUT_POST,"qtt", FILTER_VALIDATE_INT);//(champ "qtt") filter validera la quantitié que si le nombre entier différent de zéro    
        
                if($name && $price && $qtt){
        
                    $product= [
                        "name" => $name,
                        "price" => $price,
                        "qtt" => $qtt,
                        "total" => $price*$qtt,
                    ];
        
                    $_SESSION['products'][] = $product;
                    // on ajoute le produit ($product) à la fin du tableau 'products' stocké dans la session
        
                    $_SESSION ['message']= "produit ajouté  avec succès";
                } else {
                    # Stocke un message d'erreur si les champs ne sont pas valides
                    $_SESSION['message'] = "Erreur : veuillez remplir correctement le formulaire";
            }
        }
        break;
        
        case "delete":
            if(isset($_SESSION['products'])){
                unset($_SESSION['products'][$_GET['id']]);
                # Stocke un message de confirmation pour la suppression
                $_SESSION['message'] = "Produit supprimé avec succès !";    
            }
            break;
        case "clear":
            if(isset($_SESSION['products'])){
                unset($_SESSION['products']);
                # Stocke un message de confirmation pour la suppression
                $_SESSION['message'] = "Liste supprimé avec succès !";    
            }
            break;
        case "up-qtt":
            if(isset($_SESSION['products'])){
                $product = $_SESSION['products'][$_GET['id']]['qtt']++;
                ($_SESSION['products'][$_GET['id']]['total']=$_SESSION['products'][$_GET['id']]['price']*$_SESSION['products'][$_GET['id']]['qtt']);
            }
            header("Location:recap.php");
            exit();
            break;
            case "down-qtt":
                
                if(isset($_SESSION['products']) && ($_SESSION['products'][$_GET['id']]['qtt']) > 0) {
                    $product = $_SESSION['products'][$_GET['id']]['qtt']--;
                    ($_SESSION['products'][$_GET['id']]['total']=$_SESSION['products'][$_GET['id']]['price']*$_SESSION['products'][$_GET['id']]['qtt']);
                }
            header("Location:recap.php");
            exit();
            break;
    }  
}


    header("Location:index.php")
?>
<!-- definir une session = Cette fonction a deux utilités : démarrer une session sur le serveur pour l'utilisateur 
courant, ou récupérer la session de ce même utilisateur s'il en avait déjà une. Cette 
deuxième fonctionnalité est rendue possible puisqu'au démarrage d'une session, le 
serveur enregistrera un cookie PHPSESSID dans le navigateur client, contenant 
l'identifiant de la session appartenant à celui-ci. Les cookies sont transmis au serveur avec 
chaque requête HTTP effectuée par le client.

definir une super global = tout super global sont type tableau pour pouvoir facilement retrouver des clé/valeur, il y en a 9

definir la faille xss =  les types attendus par les champs ou même la ressource à atteindre : sans une 
vérification minutieuse des données transmises au serveur par le formulaire, il existe un 
risque de provoquer des erreurs, voire pire, de pirater le serveur en injectant du code. On 
appelle cela une faille par injection de code, comme XSS -->