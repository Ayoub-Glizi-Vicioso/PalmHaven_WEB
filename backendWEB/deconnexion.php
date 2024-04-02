<?php
// Démarrez la session
session_start();


if(preg_match('/\/deconnexion\.php/', $_SERVER['REQUEST_URI'], $matches)) {
    if($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Détruisez toutes les variables de session
        session_unset();

        // Détruisez la session
        session_destroy();

        echo json_encode(['message' => "Déconnexion réussi!"]);
        // Redirigez l'utilisateur vers la page de connexion (ou une autre page)
        
        

    } else {
        // Gérer le cas où la méthode de la requête n'est pas DELETE
        http_response_code(405);
        echo json_encode(['message' => 'Méthode HTTP non autorisée.']);
    }


}else {
    // Gérer le cas où la méthode de la requête n'est pas DELETE
    http_response_code(405);
    echo json_encode(['message' => 'Méthode HTTP non autorisée.']);
}
?>