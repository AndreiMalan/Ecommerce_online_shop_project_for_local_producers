<?php 
include("conectare.php");
$error = '';
if (!empty($_POST['id_produs'])) {
    if (isset($_POST['submit'])) {
        if (is_numeric($_POST['id_produs'])) { 
            $id = $_POST['id_produs'];
            $nume = htmlentities($_POST['nume_produs'], ENT_QUOTES);
            $pret = htmlentities($_POST['pret'], ENT_QUOTES);
            $descriere = htmlentities($_POST['descriere_produs'], ENT_QUOTES);
            $imagine = htmlentities($_POST['imagine'], ENT_QUOTES);
            $producator = htmlentities($_POST['producer_id'], ENT_QUOTES);
            $categorie = htmlentities($_POST['category_id'], ENT_QUOTES);
            if ($nume == '' || $pret == '' || $descriere == '' || $imagine == '' || $producator == '' || $categorie == '') { // daca sunt goale afisam mesaj de eroare
                echo "<div> ERROR: Completati campurile obligatorii!</div>";
            } else { 
                if ($stmt = $mysqli->prepare("UPDATE produse SET nume_produs=?, pret=?, descriere_produs=?, imagine=?, producer_id=?, category_id=? WHERE id_produs='" . $id . "'")) {
                    $stmt->bind_param(
                        "sdssii",
                        $nume,
                        $pret,
                        $descriere,
                        $imagine,
                        $producator,
                        $categorie
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
            echo "id incorect!";
        }
    }
} ?>
<html>

<head>
    <title>
        <?php if ($_GET['id_produs'] != '') {
            echo "Modificare inregistrare";
        } ?>
    </title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf8" />
    <link rel="stylesheet" href="style3.css">
    <script>
        function showMessage1(){
            alert("Modificarea s-a realizat cu succes!")
        }
    </script>
</head>

<body>
    <!--<h1>
        <?php if ($_GET['id_produs'] != '') {
            echo "Modificare Inregistrare";
        } ?>
    </h1>-->
    <h1 class="center">
        <?php echo "Modificare produs"; ?>
    </h1>
    <?php if ($error != '') {
        echo "<div style='padding:6px; border:3px solid red; color:red'>" . $error . "</div>";
    } ?>
    <nav>
        <ul>
            <li><a href="vizualizare.php">Vizualizare produse</a></li>
            <li><a href="inserare.php">Inserare Produs nou</a></li>
            <li><a href="vizualizare-categorii-producatori.php">Vizualizare Categorii</a></li>
            <li><a href="logout-producatori.php">Log Out</a></li>
        </ul>
    </nav>
    <br><br>
    <form action="" method="post" onsubmit="showMessage1()">
        <div class="container">
            <div class="card">
                <a class="login">Modifica Produs</a>
                <?php if ($_GET['id_produs'] != '') { ?>
                    <input type="hidden" name="id_produs" value="<?php echo $_GET['id_produs']; ?>" />
                    <?php
                    if ($result = $mysqli->query("SELECT * FROM produse where id_produs='" . $_GET['id_produs'] . "'")) {
                        if ($result->num_rows > 0) {
                            $row = $result->fetch_object(); ?>
                            </p>
                            <div class="inputBox">
                                <input type="text" name="nume_produs" value="<?php echo $row->nume_produs; ?>" required="required">
                                <span>Denumire</span>
                            </div>
                            <div class="inputBox">
                                <input type="number" name="pret" value="<?php echo $row->pret; ?>" required="required">
                                <span>Pret</span>
                            </div>
                            <div class="inputBox">
                                <input type="text" name="descriere_produs" value="<?php echo $row->descriere_produs; ?>"
                                    required="required">
                                <span>Descriere</span>
                            </div>
                            <div class="inputBox">
                                <input type="text" name="imagine" value="<?php echo $row->imagine; ?>" required="required">
                                <span>Imagine</span>
                            </div>
                            <div class="inputBox">
                                <input type="number" name="producer_id" value="<?php echo $row->producer_id; ?>"
                                    required="required">
                                <span>ID Producator</span>
                            </div>
                            <div class="inputBox">
                                <input type="number" name="category_id" value="<?php echo $row->category_id; ?>"
                                    required="required">
                                <span>ID Categorie</span>
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