<?php

    session_start();

    if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] === 'GET') {
        if(preg_match('/\/affichage.php', $_SERVER['REQUEST_URI'] , $matches )){

            $serveur = "localhost"; // adresse du serveur MySQL
            $utilisateur = "root"; 
            $motDePasse = ""; 
            $baseDeDonnees = "palmhaven"; // nom de la base de données MySQL

            // Connexion à la base de données
            $connexion = new mysqli($serveur, $utilisateur, $motDePasse, $baseDeDonnees);

            // Vérifier la connexion
            if ($connexion->connect_error) {
                die("Connexion échouée: " . $connexion->connect_error);
            } 

            $requete = "SELECT numero, étage, caratéristique , statut  FROM chambre WHERE statut = 'disponible' ";

            $resultat = $conn->query($requete);

            for ($i = 0; $i < $resultat->num_rows; $i++) {
                while ($messageCourant = $resultat->fetch_assoc()) {
                    $numero = $messageCourant['numero'];
                    $etage = $messageLive['étage'];
                    $carac = $messageLive['caractéristique'];

                    $chambre[] = array('numero' => $numero, 'étage' => $etage, 'caracteristique' => $carac);
                }
            }

            $chambre[] = $_SESSION['email'];
            
            echo json_encode($chambre);

        }else {

            echo "<script> alert('test')</script>";
            // Code HTTP 405 - Method Not Allowed
            echo json_encode(['erreur' => 'Méthode non autorisée.',
                              'code' => 405]);
     
        } 



    }
