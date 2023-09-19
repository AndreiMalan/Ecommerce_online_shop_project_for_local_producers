<?php
require_once "ShoppingCart.php";
include('conectare.php');
session_start();
$member_id = $_SESSION['id_user'];

if ($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['finishOrder'])) {
    $sql = "UPDATE cos SET status='Comandat' WHERE user_id=? ";
    $stmtCos = $mysqli->prepare($sql);
    $stmtCos->bind_param("i", $member_id);
    $stmtCos->execute();
}
if (!isset($_SESSION['loggedin'])) {
    header('Location: index-user.html');
    exit;
}

$shoppingCart = new ShoppingCart();
$itemCount = $shoppingCart->countCartItems($member_id);
?>
<html>

<head>
    <title>Finalizare comanda</TITLE>
    <link rel="stylesheet" href="style2.css" />
    <link rel="stylesheet" href="cos.css">
    <style>

    </style>
</head>

<body>
    <h1 style="text-align: center; color: black">Multumim pentru interesul acordat!</h1>
    <h2 style="text-align: center; color: black">Vizualizeaza produsele cumparate!</h2>
    <div id="shopping-cart">
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
        <?php
        $cartItem = $shoppingCart->getMemberCartItem($member_id);

        if (!empty($cartItem)) {
            $item_total = 0;
            ?>
            <table>
                <tbody>
                    <tr>
                        <th style="text-align: center;" class="border"><strong>Nume produs</strong></th>
                        <th style="text-align: center;" class="border"><strong>Imagine</strong></th>
                        <th style="text-align: center;" class="border"><strong>Cantitate</strong></th>
                        <th style="text-align: center;" class="border"><strong>Pret</strong></th>
                        <th style="text-align: center;" class="border"><strong>Raspuns producator</strong></th>
                    </tr>
                    <?php

                    foreach ($cartItem as $item) {
                
                        ?>
                        <tr>
                            <td><strong>
                                    <?php echo $item["nume_produs"]; ?>
                                </strong></td>
                            <td>

                                <img src="imagini/<?php echo $item["imagine"]; ?>" width="100px" height="100px"
                                    style="border-radius: 10px">
                            </td>
                            <td style="text-align: center;"><strong>
                                    <?php echo $item["cantitate"]; ?>
                            <td style="text-align: center;"><strong>
                                    <?php echo $item["pret"]; ?>
                            <td style="text-align: center;"><strong>
                                    <?php echo $item["raspuns"]; ?>
                        </tr>

                        <?php
                        $item_total += ($item["pret"] * $item["cantitate"]);
                        if ($item["raspuns"] == 'Refuzat') {
                            $item_total -= ($item["pret"] * $item["cantitate"]);
                        }

                    }
                    ?>
                    <tr>
                        <td colspan="3" align=right><strong>Total:</strong></td>
                        <td align=right class="border">
                            <?php echo $item_total . " RON"; ?>
                        </td>
                        <td></td>
                    </tr>
                </tbody>
            </table>
            <?php

        }
        ?>

    </div>
    <form method="post" action="Comanda.php" target="_blank">
        <input type="submit" name="generate_pdf" class="btn1" value="Genereaza PDF" /><br>
        <input type="button" name="go_back" class="btn" value="Inapoi la cos"
            onclick="window.location.href='cos.php';" />
    </form>

</body>

</html>