<?php
include("conectare.php");
if (isset($_GET['id_pcos']) && !empty($_GET['id_pcos'])) {

$id_pcos = $_GET['id_pcos'];

$conn = mysqli_connect("hostname", "username", "password", "database");
if (!$conn) {
    die("Nu s-a putut conecta: " . mysqli_connect_error());
}

$sql = "DELETE FROM produse_cos WHERE id_pcos = $id_pcos";

if (mysqli_query($conn, $sql)) {
    header("Location: cos.php");
    exit;
} else {
    echo "Nu s-a putut realiza stergerea: " . mysqli_error($conn);
}
mysqli_close($conn);
}
?>