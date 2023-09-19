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
if (!isset($_POST['nume_admin'], $_POST['prenume_admin'], $_POST['adminname'], $_POST['password'], $_POST['email'])) {
    exit('Nu s-a completat corect formularul!');
}
if (empty($_POST['nume_admin']) || empty($_POST['prenume_admin']) || empty($_POST['adminname']) || empty($_POST['password']) ||
    empty($_POST['email'])) {
    exit("Sunt valori goale in formular!");
}
if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
    exit('Email nu este valid!');
}
if (preg_match('/[A-Za-z0-9]+/', $_POST['adminname']) == 0) {
    exit('Admin_name nu este valid!');
}
if (strlen($_POST['password']) > 20 || strlen($_POST['password']) < 5) {
    exit('Parola trebuie sa fie intre 5 si 20 de caractere!');
}
if ($stmt = $con->prepare('SELECT id_admin, password FROM admin WHERE adminname = ?')) {
    $stmt->bind_param('s', $_POST['adminname']);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows > 0) {
        echo 'Adminname exista, alegeti altul!';
    } else {
        if ($stmt = $con->prepare('INSERT INTO admin (id_admin, nume_admin, prenume_admin, adminname, password, email) VALUES (?, ?, ?, ?, ?, ?)')) {
            $password = password_hash($_POST['password'],
                PASSWORD_DEFAULT);
            $id = null;
            $stmt->bind_param('isssss', $id, $_POST['nume_admin'], $_POST['prenume_admin'], $_POST['adminname'], $password, $_POST['email']);
            $stmt->execute();
            echo "Success inregistrat!";
            header('Location: index-admin.html');
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