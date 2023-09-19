<?php
$conn = mysqli_connect("localhost", "root", "", "bachelor_degree");
session_start();
if (!isset($_SESSION['id_user'])) {
    header("Location: index-user.html");
    exit;
}
$user_id = $_SESSION['id_user'];
$query = "SELECT nume_user, prenume_user, username, email, adresa, localitate, judet 
          FROM utilizatori WHERE id_user = $user_id";
$get_pers_info = mysqli_query($conn, $query);
if (!$get_pers_info) {
    die("Nu s-a putut executa: " . mysqli_error($conn));
}

$accounts = mysqli_fetch_all($get_pers_info, MYSQLI_ASSOC); 

mysqli_close($conn);
?>
<html>

<head>
    <link rel="stylesheet" href="recenzie.css">
    <link rel="stylesheet" href="style2.css">
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
            <div class="title-font">Contul meu</div>
        </span>
    </div>
    <div class="content card-container">
        <?php foreach ($accounts as $account): ?>
            <div class="card2">
                <div class="card2-info">
                    <p class="title">
                        <?php echo $account['username']; ?>
                    </p>
                    <p class="subtitle">
                        <?php echo "Nume: ". $account['nume_user']; ?>
                    </p>
                    <p class="subtitle">
                        <?php echo "Prenume: ". $account['prenume_user']; ?>
                    </p>
                    <p class="subtitle">
                        <?php echo "Email: ". $account['email']; ?>
                    </p>
                    <p class="subtitle">
                        <?php echo "Adresa: ". $account['adresa']; ?>
                    </p>
                    <p class="subtitle">
                        <?php echo "Localitate: ".$account['localitate']; ?>
                    </p>
                    <p class="subtitle">
                        <?php echo "Judet: ".$account['judet']; ?>
                    </p>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</body>

</html>