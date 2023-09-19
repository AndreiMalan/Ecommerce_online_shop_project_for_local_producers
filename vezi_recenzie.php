<?php
session_start();
if (!isset($_SESSION['id_user'])) {
    header("Location: index-user.html");
    exit;
}
$conn = mysqli_connect("localhost", "root", "", "bachelor_degree");
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$sql = "SELECT * FROM recenzii";

$result = mysqli_query($conn, $sql);
if (!$result) {
    die("Query failed: " . mysqli_error($conn));
}

if (mysqli_num_rows($result) > 0) {
    $reviews = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $reviews[] = $row;
    }
} else {
    $reviews = array();
}

$query = "SELECT r.text_recenzie, r.data_recenzie, u.username 
          FROM recenzii r 
          JOIN utilizatori u ON r.user_id = u.id_user 
          ORDER BY r.data_recenzie DESC";

$get_reviews = mysqli_query($conn, $query);
if (!$get_reviews) {
    die("Query failed: " . mysqli_error($conn));
}

$reviews = mysqli_fetch_all($get_reviews, MYSQLI_ASSOC);

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
            <div class="title-font">Recenziile utilizatorilor</div>
        </span>
    </div>
    <div class="content card-container">
        <?php foreach ($reviews as $review): ?>
            <div class="card1">
                <div class="card1-info">
                    <p class="title">
                        <?php echo $review['username']; ?>
                    </p>
                    <p class="subtitle">
                        <?php echo date('d-m-Y', strtotime($review['data_recenzie'])); ?>
                    </p>
                </div>
                <div class="card1-bio">
                    <p>
                        <?php echo $review['text_recenzie']; ?>
                    </p>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</body>

</html>