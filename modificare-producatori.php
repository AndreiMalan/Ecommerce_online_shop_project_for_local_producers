<?php
include("conectare.php");
$error = '';
if (!empty($_POST['id_producator'])) {
    if (isset($_POST['submit'])) { 
        if (is_numeric($_POST['id_producator'])) { 
            $id = $_POST['id_producator'];
            $nume = htmlentities($_POST['nume_producator'], ENT_QUOTES);
            $prenume = htmlentities($_POST['prenume_producator'], ENT_QUOTES);
            $username = htmlentities($_POST['username'], ENT_QUOTES);
            $email = htmlentities($_POST['email'], ENT_QUOTES);
            $localitate = htmlentities($_POST['localitate'], ENT_QUOTES);
            $judet = htmlentities($_POST['judet'], ENT_QUOTES);
            if ($nume == '' || $prenume == '' || $username == '' || $email == '' || $localitate == '' || $judet == '') { 
                echo "<div> ERROR: Completati campurile obligatorii!</div>";
            } else {
                if ($stmt = $mysqli->prepare("UPDATE producatori SET nume_producator=?, prenume_producator=?, username=?, email=?, localitate=?, judet=? WHERE id_producator='" . $id . "'")) {
                    $stmt->bind_param(
                        "ssssss",
                        $nume,
                        $prenume,
                        $username,
                        $email,
                        $localitate,
                        $judet
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
            echo "id_producator incorect!";
        }
    }
} ?>
<html>

<head>
    <title>
        <?php if ($_GET['id_producator'] != '') {
            echo "Modificare inregistrare";
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
        <?php echo "Modificare producator"; ?>
    </h1>
    <?php if ($error != '') {
        echo "<div style='padding:6px; border:3px solid red; color:red'>" . $error . "</div>";
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
                <a class="login">Modifica Producator</a>
                <?php if ($_GET['id_producator'] != '') { ?>
                    <input type="hidden" name="id_producator" value="<?php echo $_GET['id_producator']; ?>" />
                    <?php
                    if ($result = $mysqli->query("SELECT * FROM producatori where id_producator='" . $_GET['id_producator'] . "'")) {
                        if ($result->num_rows > 0) {
                            $row = $result->fetch_object(); ?>
                            </p>
                            <div class="inputBox">
                                <input type="text" name="nume_producator" value="<?php echo $row->nume_producator; ?>" required="required">
                                <span>Nume</span>
                            </div>
                            <div class="inputBox">
                                <input type="text" name="prenume_producator" value="<?php echo $row->prenume_producator; ?>" required="required">
                                <span>Prenume</span>
                            </div>
                            <div class="inputBox">
                                <input type="text" name="username" value="<?php echo $row->username; ?>"
                                    required="required">
                                <span>Username</span>
                            </div>
                            <div class="inputBox">
                                <input type="text" name="email" value="<?php echo $row->email; ?>" required="required">
                                <span>Email</span>
                            </div>
                            <div class="inputBox">
                                <input type="text" name="localitate" value="<?php echo $row->localitate; ?>" required="required">
                                <span>Localitate</span>
                            </div>
                            <div class="inputBox">
                                <input type="text" name="judet" value="<?php echo $row->judet; ?>" required="required">
                                <span>Judet</span>
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