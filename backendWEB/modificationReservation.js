document.addEventListener("DOMContentLoaded", function() {
    // Code à exécuter une fois que le document est complètement chargé
    document.getElementById("form_modifier").addEventListener("submit", function(event) {
        event.preventDefault(); // Empêche le formulaire de se soumettre normalement
        console.log('formulaire soumis!');

        let nouveau_debut = document.getElementById("Ddebut").value;
        let nouveau_fin = document.getElementById("Dfin").value;
        let id_reservation = document.getElementById("numero_reservation").value;
        let email = document.getElementById("courriel").value;
        
        let url = '../backendWEB/modificationReservation.php';
        let requeteJson = JSON.stringify({
            nouv_debut: nouveau_debut,
            nouv_fin: nouveau_fin,
            id_reservation: id_reservation,
            email: email
        });

        let xhr = new XMLHttpRequest();
        xhr.open('POST', url);
        xhr.setRequestHeader('Content-type', 'application/json');

        xhr.onreadystatechange = function () {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    // Redirection vers la page de profil après la modification de la réservation
                    window.location.href = '../interfaceWEB/Profilmesreservtion.php?modif_success=true';
                } else {
                    // Gérer les erreurs
                    console.error('Erreur de requête :', xhr.status);
                }
            }
        };

        xhr.send(requeteJson);
    });
});
