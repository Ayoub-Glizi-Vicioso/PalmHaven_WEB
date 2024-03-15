// Sélectionne l'élément HTML qui contient l'image à changer
var change_image = document.querySelector('.changement-image');

// Un tableau contenant les noms des fichiers images
var imagesBungalow = ['Suite_Bungalow.png', 'bungalow2.png', 'bungalow3.png', 'bungalow4.png'];
var imagesFamiliale = ['Club_Familiale_Suite.png', 'familiale2.png'];
var imagesLune = ['Lune_de_miel_Suite.png', 'lune2.jpeg', 'lune3.jpg', 'lune4.jpg', 'lune5.jpg'];

var i = 0;  // Image courante

// Fonction pour passer à l'image précédente
function avant(x) {
    var images;
    var cheminImage;

    if (x === 1) {
        images = imagesBungalow;
        cheminImage = "images/bungalow/"+images[i];
    } else if (x === 2) {
        images = imagesFamiliale;
        cheminImage = "images/familiale/"+images[i];
    }
    else if(x==3){
        images = imagesLune;
        cheminImage = "images/lunedemiel/"+images[i];
    }

    if (i <= 0) i = images.length;
    i--;
    // Appelle la fonction pour changer l'image
    return changeImage(cheminImage);
}

// Fonction pour passer à l'image suivante
function suivant(x) {
    var images;
    var cheminImage;

    if (x === 1) {
        images = imagesBungalow;
        cheminImage = "images/bungalow/"+images[i];
    } else if (x === 2) {
        images = imagesFamiliale;
        cheminImage = "images/familiale/"+images[i];
    }
    else if(x==3){
        images = imagesLune;
        cheminImage = "images/lunedemiel/"+images[i];
    }

    if (i >= images.length - 1) i = -1;
    i++;
    return changeImage(cheminImage);
}

// Fonction pour changer l'image en fonction de l'indice actuel
function changeImage(cheminImage) {
    return change_image.setAttribute('src', cheminImage);
}
