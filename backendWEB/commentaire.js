document.addEventListener("DOMContentLoaded", function() {
    // Appeler la fonction pour récupérer et afficher les messages lorsque le DOM est chargé
    getMessages();

    // Ajout d'un gestionnaire d'événement pour soumettre le formulaire de message
    document.getElementById('commentaire').addEventListener('submit', function(event) {
        event.preventDefault(); // Empêcher la soumission par défaut du formulaire
        addMessage(); // Appel de la fonction pour ajouter un message
    });

    // Ajout d'un gestionnaire d'événement pour la suppression de messages
    document.getElementById('deletebutton').addEventListener('click', function() {
        deleteMessage();
    });
});

/// Fonction pour récupérer et afficher les messages depuis l'API
function getMessages() {
    fetch('../backendWEB/commentaire.php', {
        method: 'GET'
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Erreur lors de la récupération des messages.');
        }
        return response.json();
    })
    .then(messages => {
        // Une fois les messages récupérés, les afficher dans la page
        const messagesDiv = document.getElementById('conteneur-boites-temoignages');
        messagesDiv.innerHTML = ''; // Effacer le contenu précédent
        messages.forEach(message => {
            const messageElement = document.createElement('div');
            messageElement.classList.add('boite-temoignage');
            messageElement.innerHTML = `
                <div class="date">${message.Date}</div>
                <div class="entete-boite-temoignage">
                    <div class="profil">
                        <div class="photo-profil">
                            <img src="images/photo-profil.jpg" />
                        </div>
                        <div class="nom-utilisateur">
                            <strong>${message.nom_utilisateur}</strong>
                        </div>
                    </div>
                    <div class="avis">
                        ${generateStars(message.etoiles)}
                    </div>
                </div>
                <div class="commentaire-client">${message.Contenu}</div>
            `;
            messagesDiv.appendChild(messageElement);
        });
    })
    .catch(error => {
        console.error('Erreur:', error);
    });
}

// Fonction pour générer les étoiles en fonction du nombre d'étoiles
function generateStars(stars) {
    let starHtml = '';
    for (let i = 0; i < parseInt(stars); i++) {
        starHtml += '<i class="fas fa-star"></i>';
    }
    return starHtml;
}
