$(document).ready(function(){
    var requestGet = new XMLHttpRequest();

    requestGet.open('GET', '../backendWEB/commentairesTest.php', true);

    requestGet.onreadystatechange = function (){
        if (requestGet.readyState === 4 && requestGet.status === 200){
            //a enlever apres 
            console.log(requestGet.responseText);
            // Traitement de la réponse reçue du serveur
            const commentaires = JSON.parse(requestGet.responseText);

            if(commentaires.length==0){
                $('<h1>Aucun commentaire.</h1>').appendTo('.conteneur-boites-temoignages');
            }
            else{
                // Parcourir les données des commentaires
                for (let i = 0; i < commentaires.length; i++) {

                    // Créer une nouvelle boîte de témoignage
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

                    // Ajouter le nom et pseudo de l'utilisateur
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
                    nouvelleBoite.appendChild(commentaireClient);

                    // Ajouter la nouvelle boîte de témoignage à la conteneur
                    document.querySelector('.conteneur-boites-temoignages').appendChild(nouvelleBoite);
                }
            }
        }
    }

    requestGet.send();
});
