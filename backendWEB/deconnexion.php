<?php
// Démarrez la session
session_start();

// Vérifiez si la méthode de la requête est POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Détruisez toutes les variables de session
    $_SESSION = array();

  
    session_destroy();

    // Redirigez l'utilisateur vers la page de connexion (ou une autre page)
    header("Location: ../interfaceWEB/index.php");
    exit();
} else {
    // Si la méthode de la requête n'est pas POST, renvoyez une erreur 405
    http_response_code(405);
    echo json_encode(array("message" => "Méthode HTTP non autorisée."));
}
?>
