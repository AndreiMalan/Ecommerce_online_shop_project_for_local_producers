<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Vizualizare comenzi</title>
    <link rel="stylesheet" href="style3.css">
    <link rel="stylesheet" href="search1.css">
</head>

<body>
    <?php
    include("conectare.php");
    session_start();
    if (!isset($_SESSION['id_admin'])) {
        header("Location: index-admin.html");
        exit;
    }

    $admin_id = $_SESSION['id_admin'];
    $admin = $mysqli->query("SELECT adminname FROM admin WHERE id_admin = $admin_id")->fetch_object()->adminname;
    $welcome_message = "Bine ai venit, " . $admin . "!" . " Aici puteti vizualiza si gestiona toate comenzile plasate in platforma";
    ?>
    <h1 class="center">Vizualizare comenzi</h1>
    <div class="center">
        <?php echo $welcome_message; ?>
    </div><br>
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
    </nav><br>
    <div style="float: left">
        <form method="get">
            <div class="input-container">
                <input type="text" name="search" required="" placeholder="Cautare">
                <input type="submit" value="Cauta" class="invite-btn">
            </div>
        </form>
    </div>
    <?php
    $search = isset($_GET['search']) ? $_GET['search'] : '';
    if ($result = $mysqli->query("SELECT c.id_cos, p.nume_produs, p.pret, c.cantitate, u.username, u.adresa, u.localitate, u.judet
                                FROM cos c
                                JOIN produse p ON p.id_produs = c.product_id
                                JOIN utilizatori u ON u.id_user = c.user_id 
                                WHERE (p.nume_produs LIKE '%$search%' OR u.username LIKE '%$search%') AND c.status='Comandat'
                                ORDER BY c.id_cos")
    ) {
        if ($result->num_rows > 0) {
            echo "<table style='margin: auto; width: 50%; border='1'; cellpadding='8'>";
            echo "<tr><th>ID Comanda</th><th>Nume produs</th><th>Cantitate</th><th>Nume client</th><th>Adresa</th><th>Localitate</th><th>Judet</th></tr>";
            while ($row = $result->fetch_object()) {
                echo "<tr>";
                echo "<td class='center'>" . $row->id_cos . "</td>";
                echo "<td class='center'>" . $row->nume_produs . "</td>";
                echo "<td class='center'>" . $row->cantitate . "</td>";
                echo "<td class='center'>" . $row->username . "</td>";
                echo "<td class='center'>" . $row->adresa . "</td>";
                echo "<td class='center'>" . $row->localitate . "</td>";
                echo "<td class='center'>" . $row->judet . "</td>";
                echo "<td><a class='btn1' href='stergere-comanda.php?id_cos=" . $row->id_cos . "' onclick='return confirm(\"Sunteti sigur ca vreti sa stergeti aceasta comanda?\")'>Stergere</a></td>";
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