<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    
    
    // Assurez-vous que les champs de date de début et de fin sont présents dans l'URL
    if (isset($_GET['start_date']) && isset($_GET['end_date'])) {
        
        if (preg_match('/\/AffichageChambre\.php/', $_SERVER['REQUEST_URI'], $matches)) {
            // Récupérez les dates fournies dans l'URL
            $dateDebut = $_GET['start_date'];
            $dateFin = $_GET['end_date'];
            
            // Connexion à la base de données
            $serveur = "localhost"; // adresse du serveur MySQL
            $utilisateur = "root"; 
            $motDePasse = ""; 
            $baseDeDonnees = "palmhaven"; // nom de la base de données MySQL
            
            
            $connexion = new mysqli($serveur, $utilisateur, $motDePasse, $baseDeDonnees);
            
            // Vérifier la connexion
            if ($connexion->connect_error) {
                die("Connexion échouée: " . $connexion->connect_error);
            }
            
            // Construire la requête SQL pour sélectionner les chambres disponibles entre les dates fournies
            $requete ="SELECT img, type_chambre, numero  
            FROM chambre 
            WHERE numero NOT IN (
                SELECT DISTINCT chambre.numero
                FROM chambre 
                INNER JOIN reservation ON chambre.numero = reservation.numero_chambre 
                WHERE 
                (
                    ('$dateDebut' BETWEEN reservation.date_debut AND reservation.date_fin) 
                    OR ('$dateFin' BETWEEN reservation.date_debut AND reservation.date_fin)
                    ) 
                    OR 
                    (
                        (reservation.date_debut BETWEEN '$dateDebut' AND '$dateFin') 
                        OR (reservation.date_fin BETWEEN '$dateDebut' AND '$dateFin')
                        )
                        )";
                        
                        $resultat = $connexion->query($requete);
                        
                        $chambres = []; // Initialiser le tableau des chambres ici
                        
                        // Parcourir les résultats de la requête
                        while ($messageCourant = $resultat->fetch_assoc()) {
                            $chambres[]=$messageCourant;
                        }
                        

                        $_SESSION['date_debut']=$dateDebut;
                        $_SESSION['date_fin']=$dateFin;
                        
                        // Afficher le tableau encodé en JSON
                        echo json_encode($chambres);

        }else{
            
        }
        
                    
    } else {
        // Les champs de date de début et de fin ne sont pas présents dans l'URL
        http_response_code(400); // Bad Request
        echo json_encode(['erreur' => 'Les champs de date de début et de fin sont obligatoires.', 'code' => 400]);
    }   
                
} else {
    // Méthode non autorisée
    http_response_code(405); // Method Not Allowed
    echo json_encode(['erreur' => 'Méthode non autorisée.', 'code' => 405]);
}

            
            
        