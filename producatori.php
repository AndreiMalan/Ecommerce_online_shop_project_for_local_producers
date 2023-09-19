<?php
require_once "ShoppingCart.php"; 
session_start();
if (!isset($_SESSION['id_user'])) {
    header("Location: index-user.html");
    exit;
}?>

<html>

<head>
    <meta charset="utf-8">
    <title>Producatori care au plasat produse</title>
    <link rel="stylesheet" href="producer.css">
    <link rel="stylesheet" href="style2.css">
    <link rel="stylesheet" href="search.css">
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
            <div class="title-font">Producatorii nostri</div>
            <form method="GET">
                <div class="input-container">
                    <input type="text" name="search" required="" placeholder="Cautare nume">
                    <input type="submit" value="Cauta" class="invite-btn">
                </div>
            </form>
        </span>
    </div>
    <br><br>
    <?php
    $shoppingCart = new ShoppingCart();
    $query = "SELECT * FROM producatori";
    $producer_array = [];
    $search_query = '';
    if (isset($_GET['search'])) {
        $search_query = $_GET['search'];
    }
    $query = "SELECT * FROM producatori WHERE nume_producator LIKE '%$search_query%'";
    $producer_array = $shoppingCart->getAllproducers($search_query);
    if (!empty($producer_array)) {
        foreach ($producer_array as $key => $value) {
            ?>
            <div class="content">
                <div class="book">
                    <div>
                        <span>Localitate:
                            <?php echo $producer_array[$key]["localitate"] ?>

                        </span>

                    </div>
                    --------------
                    <div>
                        <span>Judet:
                            <?php echo $producer_array[$key]["judet"] ?>
                        </span>
                    </div>
                    --------------
                    <div>
                        <span>Contact:
                            <?php echo $producer_array[$key]["email"] ?>
                        </span>
                    </div>

                    <div class="cover">
                        <p>
                            <?php echo $producer_array[$key]["nume_producator"] . " " . $producer_array[$key]["prenume_producator"]; ?>
                        </p>
                    </div>
                </div>
            </div>
            <?php
        }
    }
    ?>
</body>

</html>