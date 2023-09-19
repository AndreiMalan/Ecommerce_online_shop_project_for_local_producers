<?php
require_once "ShoppingCart.php";
session_start();
if (!isset($_SESSION['id_user'])) {
    header("Location: index-user.html");
    exit;
} ?>

<html>

<head>
    <meta charset="utf-8">
    <title>Categoriile magazinului</title>
    <link rel="stylesheet" href="category.css">
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
            <div class="title-font">Categoriile noastre</div>
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
    $query = "SELECT * FROM categorii";
    $category_array = [];
    $search_query = '';
    if (isset($_GET['search'])) {
        $search_query = $_GET['search'];
    }
    $query = "SELECT * FROM categorii WHERE nume_categorie LIKE '%$search_query%'";
    $category_array = $shoppingCart->getAllcategories($search_query);
    if (!empty($category_array)) {
        foreach ($category_array as $key => $value) {
            ?>
            <div class="content">
                <div class="cards">
                    <div class="temporary_text">
                        <img width="160px" height="160px"
                            src="<?php echo 'imagini/' . $category_array[$key]["imagine_categorie"]; ?>" style="width:100%">
                    </div>
                    <div class="card_content">
                        <span class="card_title">
                            <?php echo $category_array[$key]["nume_categorie"]; ?>
                        </span>
                        <p class="card_description">
                            <?php echo $category_array[$key]["descriere_categorie"]; ?>
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