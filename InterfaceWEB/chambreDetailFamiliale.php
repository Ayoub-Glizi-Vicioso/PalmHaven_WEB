<?php
session_start();


if(!isset($_GET['numero'])){

    $btn_reservation_visible = true; 

}


?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détails de la chambre d'hôtel de type familiale</title>

    <link rel="stylesheet" href="css/pourFAMILIALE/styleFAMILIALE.CSS">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>

<body>
    <div class="container-chambre">
        <a id="btn-retour" href="index.php">
            <svg id="btn-retour" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                class="bi bi-arrow-left-square-fill" viewBox="0 0 16 16">
                <path
                    d="M16 14a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2zm-4.5-6.5H5.707l2.147-2.146a.5.5 0 1 0-.708-.708l-3 3a.5.5 0 0 0 0 .708l3 3a.5.5 0 0 0 .708-.708L5.707 8.5H11.5a.5.5 0 0 0 0-1" />
            </svg>
        </a>
        <h1>Détails de la chambre d'hôtel</h1>
        <div class="room-details">
            <div class="room-image">
                <div class='container-image'>
                    <img src="./images/familiale/Club_Familiale_Suite.png" alt="Chambre d'hôtel" class="changement-image">
                </div>
                <div class="btn-images">
                    <button class="btn" onclick="avant(2)">◀︎</button>
                    <button class="btn" onclick="suivant(2)">▶︎</button>
                </div>
            </div>
            <div class="room-info">

                <h2>Suite Familiale</h2>
                <p><strong>Superficie de la chambre :</strong> 58m<sup>2</sup></p>
                        <p><strong>Équipements:</strong> Wi-Fi gratuit, TV à écran plat, minibar</p>
                        <p><strong>Prix par nuit:</strong> $350</p>
                        <p><strong>Capacité : </strong>Occupation maximale : 5 personnes (3 adultes + 2 enfants ou 2 adultes + 3 enfants ou 1 adulte + 4 enfants)</p>
                        <p><strong>Description:</strong> Ces chambres peuvent accueillir différentes configurations familiales. Ces chambres sont conçues pour offrir une expérience de vacances inoubliable aux familles, avec des installations adaptées aux enfants et aux adultes.</p>
                        
                        <?php
                            session_start(); // Démarrer la session

                            // Vérifiez si le bouton de réservation est visible
                            if ($btn_reservation_visible) {
                                // Affichez le formulaire de réservation
                                echo '
                                <form id="reservationForm" method="post">
                                    <input type="hidden" name="numero_chambre" value="' . (isset($_GET['numero_chambre']) ? $_GET['numero_chambre'] : '') . '">
                                    <button type="submit" id="reserver">Réserver maintenant</button>
                                </form>';
                            }
                            ?>


            </div>
        </div>
    </div>
    <div class="avantages">
        <div class="amenities">
            <div class="amenities-boites">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-house"
                    viewBox="0 0 16 16">
                    <path
                        d="M8.707 1.5a1 1 0 0 0-1.414 0L.646 8.146a.5.5 0 0 0 .708.708L2 8.207V13.5A1.5 1.5 0 0 0 3.5 15h9a1.5 1.5 0 0 0 1.5-1.5V8.207l.646.647a.5.5 0 0 0 .708-.708L13 5.793V2.5a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1.293zM13 7.207V13.5a.5.5 0 0 1-.5.5h-9a.5.5 0 0 1-.5-.5V7.207l5-5z" />
                </svg>
                <h6>1 lit King et 1 lit superposé triple</h6>
            </div>
            <div class="amenities-boites">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-wind" viewBox="0 0 16 16">
                    <path d="M12.5 2A2.5 2.5 0 0 0 10 4.5a.5.5 0 0 1-1 0A3.5 3.5 0 1 1 12.5 8H.5a.5.5 0 0 1 0-1h12a2.5 2.5 0 0 0 0-5m-7 1a1 1 0 0 0-1 1 .5.5 0 0 1-1 0 2 2 0 1 1 2 2h-5a.5.5 0 0 1 0-1h5a1 1 0 0 0 0-2M0 9.5A.5.5 0 0 1 .5 9h10.042a3 3 0 1 1-3 3 .5.5 0 0 1 1 0 2 2 0 1 0 2-2H.5a.5.5 0 0 1-.5-.5"/>
                  </svg>
                <h6>Climatisation</h6>
            </div>
            <div class="amenities-boites">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-wifi"
                    viewBox="0 0 16 16">
                    <path
                        d="M15.384 6.115a.485.485 0 0 0-.047-.736A12.44 12.44 0 0 0 8 3C5.259 3 2.723 3.882.663 5.379a.485.485 0 0 0-.048.736.52.52 0 0 0 .668.05A11.45 11.45 0 0 1 8 4c2.507 0 4.827.802 6.716 2.164.205.148.49.13.668-.049" />
                    <path
                        d="M13.229 8.271a.482.482 0 0 0-.063-.745A9.46 9.46 0 0 0 8 6c-1.905 0-3.68.56-5.166 1.526a.48.48 0 0 0-.063.745.525.525 0 0 0 .652.065A8.46 8.46 0 0 1 8 7a8.46 8.46 0 0 1 4.576 1.336c.206.132.48.108.653-.065m-2.183 2.183c.226-.226.185-.605-.1-.75A6.5 6.5 0 0 0 8 9c-1.06 0-2.062.254-2.946.704-.285.145-.326.524-.1.75l.015.015c.16.16.407.19.611.09A5.5 5.5 0 0 1 8 10c.868 0 1.69.201 2.42.56.203.1.45.07.61-.091zM9.06 12.44c.196-.196.198-.52-.04-.66A2 2 0 0 0 8 11.5a2 2 0 0 0-1.02.28c-.238.14-.236.464-.04.66l.706.706a.5.5 0 0 0 .707 0l.707-.707z" />
                </svg>
                <h6>Wifi inclut</h6>
            </div>
            <div class="amenities-boites">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-droplet"
                    viewBox="0 0 16 16">
                    <path fill-rule="evenodd"
                        d="M7.21.8C7.69.295 8 0 8 0q.164.544.371 1.038c.812 1.946 2.073 3.35 3.197 4.6C12.878 7.096 14 8.345 14 10a6 6 0 0 1-12 0C2 6.668 5.58 2.517 7.21.8m.413 1.021A31 31 0 0 0 5.794 3.99c-.726.95-1.436 2.008-1.96 3.07C3.304 8.133 3 9.138 3 10a5 5 0 0 0 10 0c0-1.201-.796-2.157-2.181-3.7l-.03-.032C9.75 5.11 8.5 3.72 7.623 1.82z" />
                    <path fill-rule="evenodd"
                        d="M4.553 7.776c.82-1.641 1.717-2.753 2.093-3.13l.708.708c-.29.29-1.128 1.311-1.907 2.87z" />
                </svg>
                <h6>Salle de bain complète avec douche</h6>
            </div>
        </div>
    </div>
    <div class="room-box-extras">
        <h4>Équipements</h4>
        <ul>
            <li>Fer et planche à repasser</li>
            <li>Téléphone dans la chambre</li>
            <li>Sèche-cheveux</li>
            <li>1 lit king-size et 1 lit superposé triple</li>
            <li>Baignoire</li>
            <li>Télévision de 50 pouces</li>
            <li>Climatisation</li>
            <li>Coffre-fort électronique dans la chambre</li>
            <li>Minibar (eau, boissons non alcoolisées, bière) Approvisionnement quotidien</li>
            <li>Cafetière</li>
            <li>Salle de bains avec douche</li>
            <li>Balcon / Terrasse</li>
            <li>Piscine pour enfants avec toboggans</li>
        </ul>
    </div>

    <script src="./script/scriptChangement.js"></script>
    <script src="../backendWEB/_reservation.js"></script>

</body>

</html>