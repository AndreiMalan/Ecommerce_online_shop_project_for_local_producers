<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>

<head>
    <title>Vizualizare Inregistrari</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="stylesheet" href="style3.css">
</head>

<body>
    <?php
    include("conectare.php");
    session_start();
    if (!isset($_SESSION['id_producator'])) {
        header("Location: index-producatori.html");
        exit;
    }

    $producer_id = $_SESSION['id_producator'];
    $id_message = "ID-ul dumneavoastra de producator, necesar pentru inserarea si modificarea produselor este: " . $producer_id;
    $producator = $mysqli->query("SELECT username FROM producatori WHERE id_producator = $producer_id")->fetch_object()->username;
    $welcome_message = "Bine ai venit, " . $producator . "!";
    ?>
    <h1 class="center">Pagina de vizualizare a categoriilor</h1>
    <div class="center">
        <?php echo $welcome_message; ?>
    </div>
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
    <?php
    if ($result = $mysqli->query("SELECT * FROM categorii ORDER BY id_categorie")) {
        if ($result->num_rows > 0) {
            echo "<table style='margin: auto; width: 50%; border='1'; cellpadding='8'>";
            echo "<tr><th>ID Categorie</th><th>Nume categorie</th><th>Descriere categorie</th></tr>";
            while ($row = $result->fetch_object()) {
                echo "<tr>";
                echo "<td>" . $row->id_categorie . "</td>";
                echo "<td class='center'>" . $row->nume_categorie . "</td>";
                echo "<td class='center'>" . $row->descriere_categorie . "</td>";
                echo "</tr>";
            }
            echo "</table>";
        } 
        else {
            echo "Nu sunt inregistrari in tabela!";
        }
    } 
    else {
        echo "Error: " . $mysqli->error;
    }
    $mysqli->close();
    ?>
</body>

</html>