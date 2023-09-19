<?php
$DATABASE_HOST = 'localhost';
$DATABASE_USER = 'root';
$DATABASE_PASS = "";
$DATABASE_NAME = 'bachelor_degree';

$con = mysqli_connect($DATABASE_HOST, $DATABASE_USER,
    $DATABASE_PASS, $DATABASE_NAME);
if (mysqli_connect_errno()) {
    exit("Nu se poate conecta la MySQL: " . mysqli_connect_error());
}
if (!isset($_POST['username'], $_POST['password'], $_POST['email'])) {
    exit('Nu s-a completat corect formularul!');
}
if (empty($_POST['username']) || empty($_POST['password']) ||
    empty($_POST['email'])) {
    exit("Nu s-a completat corect formularul!");
}
if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
    exit('Email nu este valid!');
}
if (preg_match('/[A-Za-z0-9]+/', $_POST['username']) == 0) {
    exit('Username nu este valid!');
}
if (strlen($_POST['password']) > 20 || strlen($_POST['password']) < 5) {
    exit('Parola trebuie sa fie intre 5 si 20 de caractere!');
}
if ($stmt = $con->prepare('SELECT id_user, password FROM utilizatori WHERE username = ?')) {
    $stmt->bind_param('s', $_POST['username']);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows > 0) {
        echo 'Username exista, alegeti altul!';
    } else {
        if ($stmt = $con->prepare('INSERT INTO utilizatori (id_user, nume_user, prenume_user, username, password, email, adresa, localitate, judet) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)')) 
        {
            $password = password_hash($_POST['password'],
                PASSWORD_DEFAULT);
            $id = null;
            $stmt->bind_param('issssssss', $id, $_POST['nume_user'], $_POST['prenume_user'], $_POST['username'], $password, $_POST['email'], $_POST['adresa'], $_POST['Localitate'], $_POST['Judet']);
            $stmt->execute();
            echo "Success inregistrat!";
            header('Location: index-user.html');
        } else {
            echo 'Nu se poate face prepare statement!';
        }
    }
    $stmt->close();
} else {
    echo 'Nu se poate face prepare statement!';
}
$con->close();
?>