<?php
include("conectare.php");
$error = '';
if (!empty($_POST['id_user'])) {
    if (isset($_POST['submit'])) { 
        if (is_numeric($_POST['id_user'])) { 
            $id = $_POST['id_user'];
            $nume = htmlentities($_POST['nume_user'], ENT_QUOTES);
            $prenume = htmlentities($_POST['prenume_user'], ENT_QUOTES);
            $username = htmlentities($_POST['username'], ENT_QUOTES);
            $email = htmlentities($_POST['email'], ENT_QUOTES);
            if ($nume == '' || $prenume == '' || $username == '' || $email == '') {
                echo "<div> ERROR: Completati campurile obligatorii!</div>";
            } else {
                if ($stmt = $mysqli->prepare("UPDATE utilizatori SET nume_user=?, prenume_user=?, username=?, email=? WHERE id_user='" . $id . "'")) {
                    $stmt->bind_param(
                        "ssss",
                        $nume,
                        $prenume,
                        $username,
                        $email
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
            echo "id_user incorect!";
        }
    }
} ?>
<html>

<head>
    <title>
        <?php if ($_GET['id_user'] != '') {
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
        <?php echo "Modificare user"; ?>
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
                <a class="login">Modifica Utilizator</a>
                <?php if ($_GET['id_user'] != '') { ?>
                    <input type="hidden" name="id_user" value="<?php echo $_GET['id_user']; ?>" />
                    <?php
                    if ($result = $mysqli->query("SELECT * FROM utilizatori where id_user='" . $_GET['id_user'] . "'")) {
                        if ($result->num_rows > 0) {
                            $row = $result->fetch_object(); ?>
                            </p>
                            <div class="inputBox">
                                <input type="text" name="nume_user" value="<?php echo $row->nume_user; ?>" required="required">
                                <span>Nume</span>
                            </div>
                            <div class="inputBox">
                                <input type="text" name="prenume_user" value="<?php echo $row->prenume_user; ?>" required="required">
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
                            <?php
                        }
                    }
                } ?>
                <input type="submit" class="enter" name="submit" value="Submit" />
            </div>
    </form>
</body>

</html>