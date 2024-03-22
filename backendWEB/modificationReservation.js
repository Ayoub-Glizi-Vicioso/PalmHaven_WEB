$(document).ready(function () {
    document.getElementById("form_modifier").addEventListener("submit", function(event) {
        console.log('formulaire soumis!');
        event.preventDefault(); // Empêche le formulaire de se soumettre normalement

        let nouveau_debut = document.getElementById("Ddebut").value;
        let nouveau_fin = document.getElementById("Dfin").value
        let id_reservation = document.getElementById("id_reservation").value;
        console.log(id_reservation);
        let email = document.getElementById("email").value;
        console.log(email);

        let url = '../backendWEB/moficationReservation.php';
        let params = 'nouv_debut=' + nouveau_debut + 'nouv_fin=' + nouveau_fin + 'id_reservation=' + id_reservation + '&email=' + email;

        let xhr = new XMLHttpRequest();
        xhr.open('POST', url + '?' + params);
        
        xhr.onreadystatechange = function () {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    // Redirection vers la page de profil après l'annulation de la réservation
                    window.location.href = '../interfaceWEB/Profilmesreservtion.php?annulation_success=true';
                } else {
                    // Gérer les erreurs
                    console.error('Erreur de requête :', xhr.status);
                }
            }
        };

        xhr.send();
    });
});
