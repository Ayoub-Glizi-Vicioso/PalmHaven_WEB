$(document).ready(function() {

    // Fonction pour récupérer les messages déjà existants depuis le serveur

    const requeteGet = new XMLHttpRequest();

    // Configuration de la requête HTTP GET vers une URL
    requeteGet.open('GET', '../backendWEB/commentaire.php', true);

    // Définition de l'en-tête de la requête pour spécifier le type de contenu
    requeteGet.setRequestHeader('Content-Type', 'application/json');

    // Définition de la fonction à exécuter une fois la requête terminée
    requeteGet.onreadystatechange = function () {

        // Vérification si la requête est terminée (readyState === 4)
        // et si le statut de la réponse est 200 - OK
        if (requeteGet.readyState === 4 && requeteGet.status === 200) {

            // Traitement de la réponse reçue du serveur
            const messages = JSON.parse(requeteGet.responseText);

            if (messages !== null) {
                
                let sessionID = messages.pop(); // Dernier élément est l'ID de session
                let messageIndex = 1; // Index pour les ID des messages

                messages.forEach(function(message) {
                    let messageDiv = $("<div class='boite-temoignage' id='message-" + messageIndex + "'></div>");
                    $(".conteneur-boites-temoignages").append(messageDiv);

                    // Création des éléments HTML pour chaque message
                    let messageTitle = $("<div class='titre'>" + message.Titre + "</div>");
                    let messageContent = $("<div class='commentaire-client'>" + message.Contenu + "</div>");
                    let messageDate = $("<div class='date'>" + message.Date + "</div>");
                    let messageUser = $("<div class='profil'><div class='photo-profil'><img src='images/c-1.jpg' /></div><div class='nom-utilisateur'><strong>" + message.nom_utilisateur + "</strong></div></div>");
                    let messageStars = $("<div class='avis'></div>");
                    
                    for (let i = 0; i < message.etoiles; i++) {
                        messageStars.append("<i class='fas fa-star'></i>");
                    }
                    for (let i = message.etoiles; i < 5; i++) {
                        messageStars.append("<i class='far fa-star'></i>");
                    }

                    $("#message-" + messageIndex).append(messageTitle, messageContent, messageDate, messageUser, messageStars);

                    messageIndex++;
                });
            }
            else {
                console.error("Erreur lors de l'appel.");
            }

        }
        else if (requeteGet.readyState === 4 && requeteGet.status !== 200) {
            console.error('Erreur lors de la requête : ' + requeteGet.status);
        }
    };

    requeteGet.send();

});
