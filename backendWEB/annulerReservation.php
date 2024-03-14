<?php
session_start();

if (!isset($_SESSION['email'])) {
    header('Location: connexion.php');
    exit;
}

// Vérifier si l'id_reservation est passé en paramètre
if(isset($_GET['id_reservation'])) {
    require('connexion.php'); 

    $id_reservation = $_GET['id_reservation'];

    // sql pour supprimer la reservation
    $sql_delete = "DELETE FROM reservations WHERE id_reservation = ?";
    $stmt_delete = $conn->prepare($sql_delete);
    $stmt_delete->bind_param("i", $id_reservation);

   
    if ($stmt_delete->execute()) {
        echo "La réservation a été supprimée avec succès.";
    } else {
        echo "Une erreur est survenue lors de la suppression de la réservation.";
    }

    $stmt_delete->close();
    // ramener vers la page de reservation si jamais
    header('Location: reservations.php');
    exit;
} else {
    echo "L'id de la réservation n'a pas été spécifié.";
}
?>



?>