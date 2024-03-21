$(document).ready(function () {
    document.getElementById("form_modifier").addEventListener("submit", function(event) {
        event.preventDefault(); // Empêche le formulaire de se soumettre normalement


        let id_reservation = document.getElementById("id_reservation").value;
        console.log(id_reservation);
        let email = document.getElementById("email").value;
        console.log(email);

        let url = '../backendWEB/annulerReservation.php';
        let params = 'id_reservation=' + id_reservation + '&email=' + email;

        let xhr = new XMLHttpRequest();
        xhr.open('DELETE', url + '?' + params, false);

        xhr.onreadystatechange = function () {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    // Traitement de la réponse
                    var response = JSON.parse(xhr.responseText);
                    console.log(response.message); // Afficher le message de la réponse

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
