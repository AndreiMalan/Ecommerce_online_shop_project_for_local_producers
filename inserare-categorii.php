<?php
include("conectare.php");
session_start();
if (!isset($_SESSION['id_admin'])) {
    header("Location: index-admin.html");
    exit;
}

$admin_id = $_SESSION['id_admin'];
$admin = $mysqli->query("SELECT adminname FROM admin WHERE id_admin = $admin_id")->fetch_object()->adminname;
$welcome_message = "Bine ai venit, " . $admin . "!" . " Aici puteti insera o categorie de produse in platforma.";
$error = '';
if (isset($_POST['submit'])) {
    $nume = htmlentities($_POST['nume_categorie'], ENT_QUOTES);
    $descriere = htmlentities($_POST['descriere_categorie'], ENT_QUOTES);
    $imagine = htmlentities($_POST['imagine_categorie'], ENT_QUOTES);
    if ($nume == '' || $descriere == '') {
        $error = 'ERROR: Campuri goale!';
    } else {
        if ($stmt = $mysqli->prepare("INSERT into categorii (id_categorie, nume_categorie, descriere_categorie, imagine_categorie) VALUES (?, ?, ?, ?)")) {
            $id = null;
            $stmt->bind_param("isss", $id, $nume, $descriere, $imagine);
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
        <?php echo "Inserare categorie"; ?>
    </title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="stylesheet" href="style3.css">
    <script>
        function showMessage() {
            alert("Inserarea s-a realizat cu succes!")
        }
    </script>
</head>

<body>
    <h1 class="center">
        <?php echo "Inserare categorie"; ?>
    </h1>
    <?php if ($error != '') {
        echo "<div style='padding:6px; border:2px solid red; color:red'>" . $error . "</div>";
    } ?>
    <div class="center"><?php echo $welcome_message; ?></div><br>
    <img src="imagini/background.png" class="logo">
    <nav>
        <ul>
            <li><a href="main-admin.php">Home</a></li>
            <li><a href="vizualizare-user.php">Utilizatori</a></li>
            <li><a href="vizualizare-producatori.php">Producatori</a></li>
            <li><a href="vizualizare-categorii.php">Categorii</a></li>
            <li><a href="inserare-categorii.php">Inserare categorie</a></li>
            <li><a href="vizualizare-comenzi.php">Comenzi</a></li>
            <li><a href="vizualizare-recenzii.php">Recenzii</a></li>
            <li><a href="statistici.php">Statistici</a></li>
            <li><a href="logout-admin.php">Log Out</a></li>
        </ul>
    </nav>
    <br><br>
    <form action="" method="post" onsubmit="showMessage()">
        <div class="container">
            <div class="card">
                <a class="login">Adauga Categorie</a>
                <div class="inputBox">
                    <input type="text" name="nume_categorie" value="" required="required">
                    <span>Nume</span>
                </div>
                <div class="inputBox">
                    <input type="text" name="descriere_categorie" value="" required="required">
                    <span>Descriere</span>
                </div>
                <div class="inputBox">
                    <input type="text" name="imagine_categorie" value="" required="required">
                    <span>Imagine</span>
                </div>
                <input type="submit" class="enter" name="submit" value="Submit" />
            </div>
        </div>
    </form>
</body>

</html>