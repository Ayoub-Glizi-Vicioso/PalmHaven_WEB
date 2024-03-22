document.addEventListener("DOMContentLoaded", function() {
    // Code à exécuter une fois que le document est complètement chargé
    document.getElementById("form_modifier").addEventListener("submit", function(event) {
        event.preventDefault(); // Empêche le formulaire de se soumettre normalement
        console.log('formulaire soumis!');

        let nouveau_debut = document.getElementById("Ddebut").value;
        console.log(nouveau_debut);
        let nouveau_fin = document.getElementById("Dfin").value;
        console.log(nouveau_fin);
        let id_reservation = document.getElementById("numero_reservation").value;
        console.log(id_reservation);
        let email = document.getElementById("courriel").value;
        console.log(email);
        let url = '../backendWEB/modificationReservation.php';
        
        let xhr = new XMLHttpRequest();
        xhr.open('POST', url);
        xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        
        let params = 'nouv_debut=' + nouveau_debut + '&nouv_fin=' + nouveau_fin + '&id_reservation=' + id_reservation + '&email=' + email;

        console.log(params);
        xhr.send(params);
    });
});
