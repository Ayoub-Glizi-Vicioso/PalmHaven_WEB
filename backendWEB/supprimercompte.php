<?php
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    session_start();

    if (!isset($_SESSION['email'])) {
        http_response_code(401);
        echo json_encode(array('message' => 'Vous devez être connecté pour effectuer cette action.'));
        exit;
    }

    // Vérifier si les données sont valides
    if (!isset($_POST['email'], $_POST['mot_de_passe'])) {
        http_response_code(400);
        echo json_encode(array('message' => 'Les données nécessaires ne sont pas fournies.'));
        exit;
    }

    $email_session = $_SESSION['email'];
    $email_a_supprimer = $_POST['email'];
    $mot_de_passe = $_POST['mot_de_passe']; 

    // Verifie que l'email est bien celui qu'il faut supprimer
    if ($email_session === $email_a_supprimer) {
        $serveur = "localhost";
        $utilisateur = "root";
        $mot_de_passe_bdd = ""; // pour ne pas redefinir la variable avec celle du log in 
        $baseDeDonnees = "palmhaven";

        $conn = new mysqli($serveur, $utilisateur, $mot_de_passe_bdd, $baseDeDonnees);

        if ($conn->connect_error) {
            http_response_code(500);
            echo json_encode(array('message' => 'Erreur de connexion à la base de données.'));
            exit;
        }

        // SQL pour faire la suppression
        $sql = "DELETE FROM utilisateurs WHERE email = ? AND mot_de_passe = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $email_a_supprimer, $mot_de_passe);

        if ($stmt->execute()) {
            http_response_code(200);
            echo json_encode(array('message' => 'L\'utilisateur a été supprimé avec succès.'));
        } else {
            http_response_code(500);
            echo json_encode(array('message' => 'Erreur lors de la suppression de l\'utilisateur.'));
        }

        $stmt->close();
        $conn->close();
    } else {
        http_response_code(403);
        echo json_encode(array('message' => 'Les informations d\'identification ne correspondent pas à l\'utilisateur connecté.'));
    }
} else {
    http_response_code(405);
    echo json_encode(array('message' => 'Méthode non autorisée.'));
}
?>
