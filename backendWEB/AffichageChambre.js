$(document).ready(function() {
    // Écouter l'événement submit sur le formulaire
    $('.search-form').on('submit', function(event) {
        // Empêcher le comportement par défaut du formulaire (rechargement de la page)
        event.preventDefault();
        
        // Récupérer les valeurs des champs de date
        let startDate = $('#start_date').val();
        let endDate = $('#end_date').val();
        console.log("Formulaire soumis !");
        
        // Vérifier si les champs de date sont vides
        if (!startDate || !endDate) {
            // Afficher l'alerte si les champs de date sont vides
            alert("Saisissez une date de début et de fin");
            return; // Arrêter l'exécution de la fonction si les champs sont vides
        }
      
        // Fonction pour charger les chambres lorsque l'utilisateur clique sur le bouton "Rechercher"
        function chargerChambres() {
            // Création d'une nouvelle instance de XMLHttpRequest
            const requeteGet = new XMLHttpRequest();

            // Configuration de la requête HTTP GET vers une URL
            requeteGet.open('GET', '../backendWEB/AffichageChambre.php?start_date=' + startDate + '&end_date=' + endDate, true);

            // Définition de la fonction à exécuter une fois la requête terminée
            requeteGet.onreadystatechange = function () {
                // Vérification si la requête est terminée (readyState === 4)
                // et si le statut de la réponse est 200 - OK
                if (requeteGet.readyState === 4 && requeteGet.status === 200) {
                    // Traitement de la réponse reçue du serveur
                    const valeur = JSON.parse(requeteGet.responseText);

                    // Effacer le contenu précédent de la section affichage-annonce
                    $('.affichage-annonce').empty();

                    // Parcourir les données reçues et créer les éléments HTML correspondants
                    for (let i = 0; i < valeur.length; i++) {
                        // Créer un élément div pour chaque chambre
                        let nouveauDiv = $('<div class="chambre"></div>');

                        // Ajouter cet élément div à la section affichage-annonce
                        $('.affichage-annonce').append(nouveauDiv);

                        // Ajouter des styles à l'élément div
                        nouveauDiv.css({
                            'border': '1px solid #ccc',
                            'padding': '10px',
                            'margin': '10px',
                            'border-radius': '5px'
                        });

                        // Ajouter le type de chambre à l'élément div
                        nouveauDiv.append('<h5 class="type">' + valeur[i]['type_chambre'] + '</h5>');


                        // Ajouter le numéro de la chambre à l'élément div (s'il est disponible)
                        if (valeur[i]['numero']) {
                            nouveauDiv.append('<p>Numéro de chambre: ' + valeur[i]['numero'] + '</p>');
                        }

                        // Ajouter un lien vers plus d'options pour la chambre
                        let lienOptions = $('<a href="CaracChambre.php?numero_chambre=' + valeur[i]['numero'] + '">Plus d\'options</a>');
                        nouveauDiv.append(lienOptions);
                    }
                }
            };

            // Envoi de la requête
            requeteGet.send();
        }

        // Appeler la fonction chargerChambres pour charger les chambres
        chargerChambres();
    });
});
