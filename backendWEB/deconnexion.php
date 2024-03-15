<?php
$method = $_SERVER['REQUEST_METHOD'];

if ($method == 'POST' && isset($_POST['action'])) {
    session_start();
    $action = $_POST['action'];

    // authentification
    if ($action == 'login' && isset($_POST['email']) && isset($_POST['password'])) {
        $serveur = "localhost"; 
        $utilisateur = "root"; 
        $motDePasse = ""; 
        $baseDeDonnees = "palmhaven"; // nom de la base de données MySQL

        $conn = new mysqli($serveur, $utilisateur, $motDePasse, $baseDeDonnees);

        if ($conn->connect_error) {
            die("Connexion échouée: " . $conn->connect_error);
        } 
        
        // verification des donnees
        $email = $conn->real_escape_string($_POST['email']);
        $password = $conn->real_escape_string($_POST['password']);
        $query = "SELECT * FROM utilisateurs WHERE email='$email' AND password='$password'";
        $result = $conn->query($query);
        if ($result->num_rows > 0) {
            $_SESSION['email'] = $email;
            http_response_code(200);
            echo json_encode(array("message" => "Authentification réussie"));
        } else {
            http_response_code(401);
            echo json_encode(array("message" => "Authentification échouée"));
        }       
        $conn->close();
    }

    // deconnexion
    if ($action == 'logout') {
        session_unset();
        session_destroy();
        http_response_code(200);
        echo json_encode(array("message" => "Déconnexion réussie"));
    }
}

//verifie la session
if ($method == 'GET' && isset($_SESSION['email'])) {
    http_response_code(200);
    echo json_encode(array("message" => "Session active", "email" => $_SESSION['email']));
} else {
    http_response_code(401);
    echo json_encode(array("message" => "Session inactive"));
}
?>
