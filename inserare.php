<?php
include("conectare.php");
$error = '';
if (isset($_POST['submit'])) {
    $nume = htmlentities($_POST['nume_produs'], ENT_QUOTES);
    $pret = htmlentities($_POST['pret'], ENT_QUOTES);
    $descriere = htmlentities($_POST['descriere_produs'], ENT_QUOTES);
    $imagine = htmlentities($_POST['imagine'], ENT_QUOTES);
    $producator = htmlentities($_POST['producer_id'], ENT_QUOTES);
    $categorie = htmlentities($_POST['category_id'], ENT_QUOTES);
    if ($nume == '' || $pret == '' || $descriere == '' || $imagine == '' || $producator == '' || $categorie == '') {
        $error = 'ERROR: Campuri goale!';
    } else {
        if ($stmt = $mysqli->prepare("INSERT into produse (id_produs, nume_produs, pret, descriere_produs, imagine, producer_id, category_id) VALUES (?, ?, ?, ?, ?, ?, ?)")) {
            $id = null;
            $stmt->bind_param("isdssii", $id, $nume, $pret, $descriere, $imagine, $producator, $categorie);
            $stmt->execute();
            $stmt->close();
        }
        else {
            echo "ERROR: Nu se poate executa insert.";
        }
    }
}
$mysqli->close();
?>


<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>

<head>
    <title>
        <?php echo "Inserare produs"; ?>
    </title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="stylesheet" href="style3.css">
    <script>
        function showPlaceholder(input) {
            input.placeholder = "ID regasit in 'Vizualizare Categorii'";
        }

        function hidePlaceholder(input) {
            input.placeholder = '';
        }
        function showMessage1() {
            alert("Inserarea s-a realizat cu succes!")
        }
    </script>
</head>

<body>
    <h1 class="center">
        <?php echo "Inserare produs"; ?>
    </h1>
    <?php if ($error != '') {
        echo "<div style='padding:4px; border:1px solid red; color:red'>" . $error . "</div>";
    }
    session_start();
    if (!isset($_SESSION['id_producator'])) {
        header("Location: index-producatori.html");
        exit;
    }
    $producer_id = $_SESSION['id_producator'];
    $id_message = "ID-ul dumneavoastra de producator, necesar pentru inserarea si modificarea produselor este: " . $producer_id;
    ?>
    <div>
        <?php echo $id_message; ?>
    </div>
    <nav>
        <ul>
            <li><a href="main-producatori.php">Home</a></li>
            <li><a href="vizualizare.php">Vizualizare produse</a></li>
            <li><a href="inserare.php">Inserare Produs nou</a></li>
            <li><a href="vizualizare-categorii-producatori.php">Vizualizare Categorii</a></li>
            <li><a href="vizualizare-comenzi-producatori.php">Vizualizare Comenzi</a></li>
            <li><a href="logout-producatori.php">Log Out</a></li>
        </ul>
    </nav>
    <br><br>
    <form action="" method="post" onsubmit="showMessage1()">
        <div class="container">
            <div class="card">
                <a class="login">Adauga Produs</a>
                <div class="inputBox">
                    <input type="text" name="nume_produs" value="" required="required">
                    <span>Denumire</span>
                </div>
                <div class="inputBox">
                    <input type="number" name="pret" value="" required="required">
                    <span>Pret</span>
                </div>
                <div class="inputBox">
                    <input type="text" name="descriere_produs" value="" required="required">
                    <span>Descriere</span>
                </div>
                <div class="inputBox">
                    <input type="text" name="imagine" value="" required="required">
                    <span>Imagine</span>
                </div>
                <div class="inputBox">
                    <input type="number" name="producer_id" value="" required="required">
                    <span>ID Producator</span>
                </div>
                <div class="inputBox">
                    <input type="number" name="category_id" value="" required="required" placeholder=''
                        onfocus="showPlaceholder(this)" onblur="hidePlaceholder(this)">
                    <span>ID Categorie</span>
                </div>
                <input type="submit" class="enter" name="submit" value="Submit" />
            </div>
        </div>
    </form>
</body>

</html>