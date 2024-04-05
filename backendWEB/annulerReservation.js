$(document).ready(function () {

     // Code à exécuter une fois que le document est complètement chargé
    document.getElementById("form_annuler").addEventListener("submit", function(event) {
        console.log('formulaire soumis!');
        event.preventDefault(); // Empêche le formulaire de se soumettre normalement


         // Récupérer les valeurs des champs 
        let id_reservation = document.getElementById("id_reservation").value;

        let email = document.getElementById("email").value;

        // ajouter dans le url les données de la reservation et de l'email
        let url = '../backendWEB/annulerReservation.php';
        let params = 'id_reservation=' + id_reservation + '&email=' + email;

        // création de la requte + params du l'url
        let xhr = new XMLHttpRequest();
        xhr.open('DELETE', url + '?' + params);
        
        xhr.onreadystatechange = function () {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {

                    // Récupérer le message de l'api
                    const data= JSON.parse(xhr.responseText);
                    alert( data['message']);
                } else {
                    // Dans le cas que c'est des erreurs
                    console.error('Erreur de requête :', xhr.status);
                }
            }
        };

        //envoyer la requête
        xhr.send();
    });
});
