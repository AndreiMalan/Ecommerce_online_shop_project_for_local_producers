<?php
include('conectare.php');
require_once "ShoppingCart.php"; 
session_start();
if (!isset($_SESSION['id_user'])) {
    header("Location: index-user.html");
    exit;
}
if (!isset($_GET['page'])) {
    $page = 0;
} else {
    $page = intval($_GET['page']);
}

if(!isset($_GET['count'])) {
    $count = 8;
} else {
    $count = intval($_GET['count']);
}
if(!isset($_GET['search'])) {
    $search_query = "";
} else {
    $search_query = $_GET['search'];
}
?>

<html>

<head>
    <title>Pagina de produse</title>
    <link rel="stylesheet" href="style2.css">
    <link rel="stylesheet" href="search.css">
    <link rel="stylesheet" href="cos.css">
    
</head>

<body>
    <nav>
        <ul>
            <li><a href="home.html"><img src="imagini/background.png" width='180px' height="85px"></a></li>
            <li><a href="home.html">Home</a></li>
            <li><a href="#">Despre</a></li>
            <li><a href="categorii.php">Categorii</a></li>
            <li><a href="producatori.php">Producatori</a></li>
            <li><a href="magazin.php">Magazin</a></li>
            <li><a href="cos.php">Cos</a></li>
            <li><a href="lasa_recenzie.php">Lasa recenzie</a></li>
            <li><a href="vezi_recenzie.php">Vezi recenzii</a></li>
            <li><a href="logout-user.php">LogOut</a></li>
        </ul>
    </nav>
    <!--<?php
    $con = mysqli_connect('localhost', 'root', '', 'bachelor_degree');

    ?>-->
    <div>
        <span>
            <div class="title-font">Produsele noastre</div>
                <div class="input-container">
                    <input type="text" name="search" id="searchField" required="" placeholder="Cautare nume">
                    <input type="submit" onclick="onSearchClick()" value="Cauta" class="invite-btn">
                </div>
            
        </span>
    </div>
    <br><br><br>
    <div id="product-grid">
        <?php 
        $offset = $count * $page;

        if ($search_query == "") {
            $sql = "SELECT * FROM produse LIMIT ? OFFSET ? ";
            $retrievePagingStatement = $mysqli->prepare($sql);
            $retrievePagingStatement->bind_param("ii", $count, $offset);
        } else {
            $sql = "SELECT * FROM produse where nume_produs LIKE '%" . $search_query . "%' LIMIT ? OFFSET ? ";
            $retrievePagingStatement = $mysqli->prepare($sql);
            $retrievePagingStatement->bind_param("ii", $count, $offset);
        }

        
        $retrievePagingStatement->execute();
        $retrivePagingResult = $retrievePagingStatement->get_result();
        if ($retrivePagingResult->num_rows > 0) {
            while($row = $retrivePagingResult->fetch_assoc()) {
                $product_array[] = $row;
            }
        }
        
        $retrievePagingStatement->close();
        if (!empty($product_array)) {
            foreach ($product_array as $key => $value) {
                ?>

                <div class="column">
                    <div class="card card-rounded">
                        <form method="post"
                            action="Cos.php?action=add&id_produs=<?php echo $product_array[$key]["id_produs"]; ?>">
                            <img width="160px" height="160px" src="<?php echo 'imagini/' . $product_array[$key]["imagine"]; ?>"
                                style="width:100%">
                            <h2>
                                <?php echo $product_array[$key]["nume_produs"]; ?>
                            </h2>
                            <p>
                                <?php echo $product_array[$key]["descriere_produs"]; ?>
                            </p>
                            <p class="price">
                                <?php echo $product_array[$key]["pret"] . " lei"; ?>
                            </p>
                            <input type="number" class="cantitate" name="cantitate" size="2" min="1" max="100"
                                placeholder="Cantitate" required />
                            <input type="submit" class="adauga" value="Adauga in cos" class="btnAddAction" />
                        </form>
                    </div>
                </div>
                <?php
            }
        }
        ?>
    </div>
    <div class="pagination">
        <?php
            $sql = "SELECT COUNT(*) as total FROM produse";
            $result = mysqli_query($con, $sql);
            $row = mysqli_fetch_assoc($result);
            $numberOfElements = $row['total']; 

            $total_pages = ceil( $numberOfElements / $count );
        ?>
        <?php $nextPage = $page + 1 < $total_pages ? $page + 1 : $page ?>
        <?php $prevPage = $page - 1 < 0 ? 0 : $page - 1 ?>
        <?php $disabledPrevButton = $page == 0 ? "disabled" : "" ?>
        <?php
            $disabledNextButton = $page + 1 >= $total_pages ? "disabled" : ""
        ?>
        <button class="btn2" id="prevButton" <?php echo $disabledPrevButton ?>>Prev Page</button>
        <button class="btn2" id="nextButton" <?php echo $disabledNextButton ?>>Next Page</button>
       
        
    </div>


</body>
<script>
    var prevButton = document.getElementById('prevButton');
    prevButton.addEventListener('click', function() {
        document.location.href = 'http://localhost/Licenta_Malan_Andrei/magazin.php?page=<?php echo $prevPage?>&count=<?php echo $count?>&search=<?php echo $search_query?>';
    });

    var nextButton = document.getElementById('nextButton');
    nextButton.addEventListener('click', function() {
        document.location.href = 'http://localhost/Licenta_Malan_Andrei/magazin.php?page=<?php echo $nextPage?>&count=<?php echo $count?>&search=<?php echo $search_query?>';
    });

    function onSearchClick() {
        const searchValue = document.getElementById("searchField").value;
        document.location.href = `http://localhost/Licenta_Malan_Andrei/magazin.php?page=<?php echo $page?>&count=<?php echo $count?>&search=${searchValue}`;//string interpolation-val din var searchValue e evaluata si inlocuita inainte de concatenare la url pt a fi pusa corect
    }
</script>
</html>