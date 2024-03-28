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
                    const data= JSON.parse(xhr.responseText);
                    alert( data['message']);
                } else {
                    // Gérer les erreurs
                    console.error('Erreur de requête :', xhr.status);
                }
            }
        };

        xhr.send();
    });
});
