document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('commentaire');

    form.addEventListener('submit', function(event) {
        event.preventDefault();

        const titre = form.querySelector('input[name="titre"]').value;
        const contenu = form.querySelector('input[name="contenu"]').value;
        const etoile = form.querySelector('input[name="etoile"]:checked').value;

        const nouveauMessage = document.createElement('div');
        nouveauMessage.classList.add('boite-temoignage');

        const date = new Date().toISOString(); // Obtenir la date actuelle
        const dateString = date.replace('T', ' ').substring(0, 19);

        nouveauMessage.innerHTML = `
            <div class="date">${dateString}</div>
            <div class="entete-boite-temoignage">
                <div class="profil">
                    <div class="photo-profil">
                        <img src="images/votre-image.jpg" />
                    </div>
                    <div class="nom-utilisateur">
                        <strong>Votre Nom</strong>
                    </div>
                </div>
                <div class="avis">
                    ${genererEtoiles(etoile)}
                </div>
            </div>
            <div class="commentaire-client">
                <h3>${titre}</h3>
                <p>${contenu}</p>
            </div>
        `;

        const conteneurMessages = document.querySelector('.conteneur-boites-temoignages');
        conteneurMessages.appendChild(nouveauMessage);

        // Effacer les champs du formulaire après la publication
        form.reset();
    });
});

function genererEtoiles(nombreEtoiles) {
    let etoilesHTML = '';
    for (let i = 0; i < 5; i++) {
        if (i < nombreEtoiles) {
            etoilesHTML += '<i class="fas fa-star"></i>';
        } else {
            etoilesHTML += '<i class="far fa-star"></i>';
        }
    }
    return etoilesHTML;
}
