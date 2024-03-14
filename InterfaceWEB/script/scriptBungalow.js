// Script pour le changement d'image

// Sélectionne l'élément HTML qui contient l'image à changer
var change_image = document.querySelector('.changement-image');

// Un tableau contenant les noms des fichiers images
var images = ['Suite_Bungalow.png', 'bungalow2.png', 'bungalow3.png', 'bungalow4.png'];
var i = 0;  // Image courrante

// Fonction pour passer à l'image précédente
function avant1(){
    if(i<=0)i=images.length;
    i--;
    // Appelle la fonction pour changer l'image
    return changeImage(i);
}

// Fonction pour passer à l'image suivante
function suivant1(){
    if(i>=images.length-1) i = -1;
    i++;
    return changeImage(i);
}

// Fonction pour changer l'image en fonction de l'indice actuel
function changeImage(i){
    return change_image.setAttribute('src', 'images/bungalow/'+images[i]);
}