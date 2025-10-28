<?php
    session_start(); //

# Vérifie si une action est demandée avec un lien qui contient l'instruction action
if(isset($_GET['action'])){
    switch($_GET['action']){
        case "add":
            # Vérifie si le formulaire d'ajout de produit a été soumis
            if(isset($_POST['submit'])){
                
                # Nettoie le champ 'name' pour empêcher l'injection de code  
                $name = filter_input(INPUT_POST,"name", FILTER_SANITIZE_STRING);  
                # "FILTER_VALIDATE_FLOAT" n'autorise que les nombres à virgule, "FILTER_FLAG_ALLOW_FRACTION" permet l'ajout d'un "," ou "."
                $price = filter_input(INPUT_POST,"price", FILTER_VALIDATE_FLOAT, FILTER_FLAG_ALLOW_FRACTION); 
                # N'autorise que les nombres entiers positifs
                $qtt = filter_input(INPUT_POST,"qtt", FILTER_VALIDATE_INT);
                # Vérifie que tous les champs sont valides avant d'ajouter le produit   
        
                if($name && $price && $qtt){
        
                    $product= [
                        "name" => $name,
                        "price" => $price,
                        "qtt" => $qtt,
                        "total" => $price*$qtt,
                    ];
                    # Ajoute le produit au tableau de session 'products'
                    $_SESSION['products'][] = $product;
                     # Stocke un message de confirmation pour l'ajout
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
                #Stocke un message de confirmation pour la suppression
                $_SESSION['message'] = "Produit supprimé avec succès !";    
            }
            break;
        case "clear":
            if(isset($_SESSION['products'])){
                unset($_SESSION['products']);
                #Stocke un message de confirmation pour la suppression
                $_SESSION['message'] = "Liste supprimé avec succès !";    
            }
            break;
        case "up-qtt":
            if(isset($_SESSION['products'])){
                # la quantité de l'id prend +1
                $product = $_SESSION['products'][$_GET['id']]['qtt']++;
                #total= prix * qtt
                ($_SESSION['products'][$_GET['id']]['total']=$_SESSION['products'][$_GET['id']]['price']*$_SESSION['products'][$_GET['id']]['qtt']);
            }
            header("Location:recap.php");
            exit();
            break;
            case "down-qtt":
                
                if(isset($_SESSION['products']) && ($_SESSION['products'][$_GET['id']]['qtt']) > 0) { #la quantitié sera toujours superieur à 0(non negatif)                  
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