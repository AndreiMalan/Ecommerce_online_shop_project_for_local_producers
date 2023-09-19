<?php
$hostname = 'localhost';
$username = 'root';
$password = '';
$db = 'bachelor_degree';
$mysqli = new mysqli($hostname, $username, $password, $db);
if (!mysqli_connect_errno()) {
    //Ok!
} else {
    echo 'Nu se poate conecta la baza de date!';
    exit();
}
?>