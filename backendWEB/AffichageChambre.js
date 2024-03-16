$(document).ready(function() {

    // Écouter l'événement submit sur le formulaire
    $('.search-form').on('submit', function(event) {
        // Récupérer les valeurs des champs de date
        let startDate = $('#start_date').val();
        let endDate = $('#end_date').val();
        console.log("Formulaire soumis !");
        
        // Vérifier si les champs de date sont vides
        if (!startDate || !endDate) {
            event.preventDefault(); // Empêcher le comportement par défaut du formulaire (rechargement de la page)
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

                        // Ajouter l'image à l'élément div
                        nouveauDiv.append('<div class="image-container"><img src="' + valeur[i]['img'] + '" alt="Image de la chambre"></div>');
                        
                        // Ajouter le type de chambre à l'élément div
                        nouveauDiv.append('<div class="content"><h5 class="type">' + valeur[i]["type_chambre"] + '</h5></div>');

                        
                        // Ajouter le numéro de la chambre à l'élément div (s'il est disponible)
                        if (valeur[i]['numero']) {
                            nouveauDiv.find('.content').append('<p>Numéro de chambre: ' + valeur[i]['numero'] + '</p>');
                        }
                        
                        if(valeur[i]["type_chambre"] == 'standard'){
                            nouveauDiv.find('.content').append('<p>Chambres familiales de 53 m2 conçues pour garantir aux adultes et aux enfants des vacances vraiment spéciales. Nous disposons d\'une Suite Club Familiale équipée d\'un lit double et de trois lits simples superposés, avec tous les avantages exclusifs d\'être situées dans l\'espace privé Palm Haven. *Occupation maximale : 5 personnes (3 adultes + 2 enfants ou 2 adultes + 3 enfants ou 1 adulte + 4 enfants) *Enfants 3-12 ans (tous deux inclus)</p>');

                            let lienOptions = $('<a href="../interfaceWEB/chambresDetailsBungalow.html">Plus d\'options</a>');
                            nouveauDiv.find('.content').append(lienOptions);
                        }
                        if(valeur[i]["type_chambre"] == 'familiale'){
                            nouveauDiv.find('.content').append('<p></p>');


                            let lienOptions = $('<a href="../interfaceWEB/chambreDetailFamiliale.html" >Plus d\'options</a>');
                            nouveauDiv.find('.content').append(lienOptions);
                        }
                        if(valeur[i]["type_chambre"] == 'lune_de_miel'){
                            nouveauDiv.find('.content').append('<p></p>');

                            let lienOptions = $('<a href="">Plus d\'options</a>');
                            nouveauDiv.find('.content').append(lienOptions);
                        }

                
                        // Ajouter un lien vers plus d'options pour la chambre
                    //  let lienOptions = $('<a href="CaracChambre.php?numero_chambre=' + valeur[i]['numero'] + '">Plus d\'options</a>');
                    //   nouveauDiv.find('.content').append(lienOptions);

                        // Ajouter cet élément div à la section affichage-annonce
                        $('.affichage-annonce').append(nouveauDiv);
                    }
                }
            };

            // Envoi de la requête
            requeteGet.send();
        }

        // Appeler la fonction chargerChambres pour charger les chambres
        chargerChambres();

        // Empêcher le comportement par défaut du formulaire (rechargement de la page)
        event.preventDefault();
    });
});
