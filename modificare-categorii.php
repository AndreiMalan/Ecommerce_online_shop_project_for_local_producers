<?php
include("conectare.php");
$error = '';
if (!empty($_POST['id_categorie'])) {
    if (isset($_POST['submit'])) { 
        if (is_numeric($_POST['id_categorie'])) { 
            $id = $_POST['id_categorie'];
            $nume = htmlentities($_POST['nume_categorie'], ENT_QUOTES);
            $descriere = htmlentities($_POST['descriere_categorie'], ENT_QUOTES);
            $imagine = htmlentities($_POST['imagine_categorie'], ENT_QUOTES);
            if ($nume == '' || $descriere == '' || $imagine == '') {
                echo "<div> ERROR: Completati campurile obligatorii!</div>";
            } else {
                if ($stmt = $mysqli->prepare("UPDATE categorii SET nume_categorie=?, descriere_categorie=?, imagine_categorie=? WHERE id_categorie='" . $id . "'")) {
                    $stmt->bind_param(
                        "sss",
                        $nume,
                        $descriere,
                        $imagine,
                    );
                    $stmt->execute();
                    $stmt->close();
                }
                else {
                    echo "ERROR: nu se poate executa update.";
                }
            }
        }
        else {
            echo "id_categorie incorect!";
        }
    }
} ?>
<html>

<head>
    <title>
        <?php if ($_GET['id_categorie'] != '') {
            echo "Modificare categorie";
        } ?>
    </title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf8" />
    <link rel="stylesheet" href="style3.css">
    <script>
        function showMessage1() {
            alert("Modificarea s-a realizat cu succes!")
        }
    </script>
</head>

<body>
    <h1 class="center">
        <?php echo "Modificare categorie"; ?>
    </h1>
    <?php if ($error != '') {
        echo "<div style='padding:4px; border:1px solid red; color:red'>" . $error . "</div>";
    } ?>
    <img src="imagini/background.png" class="logo1">
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
    <form action="" method="post" onsubmit="showMessage1()">
        <div class="container">
            <div class="card">
                <a class="login">Modifica Categorie</a>
                <?php if ($_GET['id_categorie'] != '') { ?>
                    <input type="hidden" name="id_categorie" value="<?php echo $_GET['id_categorie']; ?>" />
                    <?php
                    if ($result = $mysqli->query("SELECT * FROM categorii where id_categorie='" . $_GET['id_categorie'] . "'")) {
                        if ($result->num_rows > 0) {
                            $row = $result->fetch_object(); ?>
                            </p>
                            <div class="inputBox">
                                <input type="text" name="nume_categorie" value="<?php echo $row->nume_categorie; ?>" required="required">
                                <span>Nume</span>
                            </div>
                            <div class="inputBox">
                                <input type="text" name="descriere_categorie" value="<?php echo $row->descriere_categorie; ?>" required="required">
                                <span>Descriere</span>
                            </div>
                            <div class="inputBox">
                                <input type="text" name="imagine_categorie" value="<?php echo $row->imagine_categorie; ?>" required="required">
                                <span>Imagine</span>
                            </div>
                            <?php
                        }
                    }
                } ?>
                <input type="submit" class="enter" name="submit" value="Submit" />
            </div>
    </form>
</body>

</html>