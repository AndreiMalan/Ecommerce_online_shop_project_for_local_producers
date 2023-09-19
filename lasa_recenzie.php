<?php
include("conectare.php");
session_start();

if (!isset($_SESSION['id_user'])) {
    header("Location: index-user.html");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['id_user'];
    $text_recenzie = $_POST['text_recenzie'];
    $date_recenzie = date('Y-m-d H:i:s');
    if ($stmt = $mysqli->prepare('INSERT INTO recenzii (id_recenzie, text_recenzie, data_recenzie, user_id) VALUES (?, ?, ?, ?)')) {
        $id = null;
        $stmt->bind_param('issi', $id, $text_recenzie, $date_recenzie, $user_id);
        $stmt->execute();
        echo "S-a inserat cu succes recenzia!";
        header('Location: magazin.php');
    } else {
        echo 'Nu se poate face prepare statement!';
    }
}
?>
<html>

<head>
    <link rel="stylesheet" href="style2.css">
    <link rel="stylesheet" href="recenzie.css">
    <script>
        function showMessage() {
            alert("Recenzia a fost postata cu succes!")
        }
    </script>
</head>

<body>
<nav>
        <ul>
            <li><a href="home.html"><img src="imagini/background.png" width='180px' height="85px"></a></li>
            <li><a href="home.html">Home</a></li>
            <li><a href="cont_personal.php">Contul meu</a></li>
            <li><a href="categorii.php">Categorii</a></li>
            <li><a href="producatori.php">Producatori</a></li>
            <li><a href="magazin.php">Magazin</a></li>
            <li><a href="cos.php">Cos</a></li>
            <li><a href="lasa_recenzie.php">Lasa recenzie</a></li>
            <li><a href="vezi_recenzie.php">Vezi recenzii</a></li>
            <li><a href="logout-user.php">LogOut</a></li>
        </ul>
    </nav>
    <div>
        <span>
            <div class="title-font">Pagina pentru lasarea de recenzii</div>
        </span>
    </div>
    <form method="post">
        <div class="content">
            <div class="container">
                <div class="card_recenzie">
                    <a class="login">Adauga Recenzie</a>
                    <div class="inputBox">
                        <textarea name="text_recenzie" id="text_recenzie" value=""></textarea>
                        <input type="hidden" name="date" value="<?php echo date('Y-m-d H:i:s'); ?>">
                        <span>Recenzie</span>
                    </div>
                    <input type="submit" class="enter" name="submit" value="Submit" />
                </div>
            </div>
        </div>

    </form>
</body>

</html>