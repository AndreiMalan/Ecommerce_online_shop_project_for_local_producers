<?php
session_start();
$DATABASE_HOST = 'localhost';
$DATABASE_USER = 'root';
$DATABASE_PASS = '';
$DATABASE_NAME = 'bachelor_degree';
$con = mysqli_connect(
    $DATABASE_HOST,
    $DATABASE_USER,
    $DATABASE_PASS,
    $DATABASE_NAME
);
if (mysqli_connect_errno()) {
    exit("Esec conectare MySQL: " . mysqli_connect_error());
}
if (!isset($_POST['adminname'], $_POST['password'])) {
    exit("Completati adminname si password !");
}
if ($stmt = $con->prepare('SELECT id_admin, password FROM admin WHERE adminname = ?')) {
    $stmt->bind_param('s', $_POST['adminname']);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id, $password);
        $stmt->fetch();
        if (password_verify($_POST['password'], $password)) {
            session_regenerate_id();
            $_SESSION['loggedin'] = TRUE;
            $_SESSION['name'] = $_POST['adminname'];
            $_SESSION['id_admin'] = $id;
            echo 'Bine ati venit' . $_SESSION['name'] . '!';
            header('Location: main-admin.php');
        } else {
            echo 'Parola sau username incorect introduse!';
        }
    } else {
        echo 'Parola sau username incorect introduse!';
    }
    $stmt->close();
}
?>