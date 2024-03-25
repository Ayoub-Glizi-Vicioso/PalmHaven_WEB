$(document).ready(function () {
    document.getElementById("form_annuler").addEventListener("submit", function(event) {
        console.log('formulaire soumis!');
        event.preventDefault(); // Empêche le formulaire de se soumettre normalement

        let id_reservation = document.getElementById("id_reservation").value;

        let email = document.getElementById("email").value;


        let url = '../backendWEB/annulerReservation.php';
        let params = 'id_reservation=' + id_reservation + '&email=' + email;

        let xhr = new XMLHttpRequest();
        xhr.open('DELETE', url + '?' + params);
        
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
