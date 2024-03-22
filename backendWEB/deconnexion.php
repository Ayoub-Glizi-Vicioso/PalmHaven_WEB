<<?php



    if(preg_match('/\/deconnexion\.php/', $_SERVER['REQUEST_URI'], $matches)) {
        
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            // Démarrez la session
            session_start();

            // Détruisez toutes les variables de session
            session_unset();

            // Détruisez la session
            session_destroy();

            // Redirigez l'utilisateur vers la page de connexion (ou une autre page)
            header("Location: ../interfaceWEB/index.php");
            exit();


        } else {
            echo "<script> alert('methode non autorisé');</script>";
        }


    } else {
    // Gérer le cas où la méthode de la requête n'est pas DELETE
    http_response_code(405);
    echo json_encode(array("message" => "Méthode HTTP non autorisée."));
    }


?>