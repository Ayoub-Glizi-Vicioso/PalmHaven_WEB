$(document).ready(function () {
    
    // Fonction pour envoyer un commentaire à la base de données
    function envoyerCommentaire(titre, contenu, etoiles) {
        var requestPost = new XMLHttpRequest();

        // Configuration de la requête POST vers le fichier PHP
        requestPost.open('POST', '../backendWEB/commentairesTest.php', true);
        requestPost.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

        // Préparation des données à envoyer
        var donnees = 'titre=' + encodeURIComponent(titre) + '&contenu=' + encodeURIComponent(contenu) + '&etoiles=' + encodeURIComponent(etoiles);

        // Envoi de la requête POST
        requestPost.send(donnees);
        window.location.href = "../InterfaceWEB/commentairesfront.php";
    }

    // Création d'une nouvelle requête XMLHttpRequest pour récupérer les commentaires existants
    var requestGet = new XMLHttpRequest();

    // Configuration de la requête GET vers le fichier PHP
    requestGet.open('GET', '../backendWEB/commentairesTest.php', true);

    requestGet.onreadystatechange = function () {
        if (requestGet.readyState === 4 && requestGet.status === 200) {
            
            // Traitement de la réponse reçue du serveur
            const commentaires = JSON.parse(requestGet.responseText);

            // Vérification s'il y a des commentaires à afficher
            if (commentaires.length == 0) {
                $('<h1>Aucun commentaire.</h1>').appendTo('.conteneur-boites-temoignages');
            }
            else {
                // Parcourir les données des commentaires
                for (let i = 0; i < commentaires.length; i++) {

                    // Créer une nouvelle boîte de témoignage pour chaque commentaire
                    var nouvelleBoite = document.createElement('div');
                    nouvelleBoite.classList.add('boite-temoignage');

                    // Créer la date du commentaire
                    var dateCommentaire = document.createElement('div');
                    dateCommentaire.classList.add('date');
                    dateCommentaire.textContent = commentaires[i]['Date_Systeme'];
                    nouvelleBoite.appendChild(dateCommentaire);

                    // Créer l'en-tête de la boîte de témoignage
                    var entete = document.createElement('div');
                    entete.classList.add('entete-boite-temoignage');

                    // Créer le profil de l'utilisateur
                    var profil = document.createElement('div');
                    profil.classList.add('profil');

                    // Ajouter le prénom de l'utilisateur
                    var nomUtilisateur = document.createElement('div');
                    nomUtilisateur.classList.add('nom-utilisateur');
                    nomUtilisateur.innerHTML = '<strong>' + commentaires[i]['nom_utilisateur'] + '</strong>';
                    profil.appendChild(nomUtilisateur);

                    // Ajouter le profil à l'en-tête
                    entete.appendChild(profil);

                    // Créer l'avis de l'utilisateur
                    var avis = document.createElement('div');
                    avis.classList.add('avis');

                    // Ajouter le titre
                    var titre = document.createElement('h2');
                    titre.classList.add('titre');
                    titre.textContent = commentaires[i]['Titre']; // Ajout du titre du commentaire
                    avis.appendChild(titre);

                    // Ajouter les étoiles en fonction de la note
                    var nombreEtoiles = parseInt(commentaires[i]['Etoiles']);
                    for (let j = 0; j < nombreEtoiles; j++) {
                        var etoilePleine = document.createElement('i');
                        etoilePleine.classList.add('fas', 'fa-star');
                        avis.appendChild(etoilePleine);
                    }
                    for (let j = nombreEtoiles; j < 5; j++) {
                        var etoileVide = document.createElement('i');
                        etoileVide.classList.add('far', 'fa-star');
                        avis.appendChild(etoileVide);
                    }
             
                    // Ajouter l'avis à l'en-tête
                    entete.appendChild(avis);

                    // Ajouter l'en-tête à la boîte de témoignage
                    nouvelleBoite.appendChild(entete);

                    // Ajouter le commentaire de l'utilisateur
                    var commentaireClient = document.createElement('div');
                    commentaireClient.classList.add('commentaire-client');
                    var paragraphe = document.createElement('p');
                    paragraphe.textContent = commentaires[i]['Contenu'];
                    commentaireClient.appendChild(paragraphe);

                    // Vérification si le commentaire appartient à l'utilisateur connecté
                    if (commentaires[i]['email'] == commentaires[i]['emailSession']) {
                        // Création du bouton pour effacer le commentaire
                        var boutonEffacer = document.createElement('button');
                        boutonEffacer.textContent = 'Effacer mon commentaire';
                        boutonEffacer.classList.add('effacer-commentaire');
                        boutonEffacer.setAttribute('id', commentaires[i]['id_message']);
                        commentaireClient.appendChild(boutonEffacer);
                    }

                    // Ajout de l'avis à l'en-tête
                    nouvelleBoite.appendChild(commentaireClient);

                    // Ajouter la nouvelle boîte de témoignage à la conteneur
                    document.querySelector('.conteneur-boites-temoignages').appendChild(nouvelleBoite);
                }
            }
        }
    }
    // Envoi de la requête GET
    requestGet.send();

    // Gestionnaire d'événement pour les boutons "Effacer mon commentaire"
    $(document).on('click', '.effacer-commentaire', function () {
        // Récupérer l'identifiant du commentaire à effacer
        var idCommentaire = $(this).attr('id');

        const requeteDel = new XMLHttpRequest();

        // Configuration de la requête HTTP GET vers une URL
        requeteDel.open('DELETE', '../backendWEB/commentairesTest.php', false);

        // Définition de l'en-tête de la requête pour spécifier le type de contenu
        requeteDel.setRequestHeader('Content-Type', 'application/json');
        
        // Définition des données JSON à envoyer dans la requête
        const requeteJSON = JSON.stringify({"id": idCommentaire});

        // Définition de la fonction à exécuter une fois la requête terminée
        requeteDel.onreadystatechange = function () {
            alert("Commentaire supprimé avec succès. La page va être rechargée.");
             // Recharge la page immédiatement
            window.location.reload();
        }

        // envoie de la requête
        requeteDel.send(requeteJSON);
    });
});



