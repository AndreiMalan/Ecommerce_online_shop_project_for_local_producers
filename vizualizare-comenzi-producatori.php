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
    if (!isset($_SESSION['id_producator'])) {
        header("Location: index-producatori.html");
        exit;
    }
    if (isset($_GET["accept"])) {
        $cart_id = $_GET["accept"];
        $stmt = $mysqli->prepare("UPDATE cos SET raspuns='Acceptat' WHERE id_cos=?");
        $stmt->bind_param("i", $cart_id);
        $stmt->execute();
        $stmt->close();
    }
    if (isset($_GET["refuz"])) {
        $cart_id = $_GET["refuz"];
        $stmt = $mysqli->prepare("UPDATE cos SET raspuns='Refuzat' WHERE id_cos=?");
        $stmt->bind_param("i", $cart_id);
        $stmt->execute();
        $stmt->close();
    }
    $producer_id = $_SESSION['id_producator'];
    $producer = $mysqli->query("SELECT username FROM producatori WHERE id_producator = $producer_id")->fetch_object()->username;
    $welcome_message = "Bine ai venit, " . $producer . "!" . " Aici puteti vizualiza si gestiona toate comenzile plasate in platforma";
    ?>
    <h1 class="center">Vizualizare comenzi</h1>
    <div class="center">
        <?php echo $welcome_message; ?>
    </div><br>
    <img src="imagini/background.png" class="logo">
    <nav>
        <ul>
            <li><a href="main-producatori.php">Home</a></li>
            <li><a href="vizualizare.php">Vizualizare produse</a></li>
            <li><a href="inserare.php">Inserare Produs nou</a></li>
            <li><a href="vizualizare-categorii-producatori.php">Vizualizare Categorii</a></li>
            <li><a href="vizualizare-comenzi-producatori.php">Vizualizare Comenzi</a></li>
            <li><a href="logout-producatori.php">Log Out</a></li>
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
    if (
        $result = $mysqli->query("SELECT c.id_cos, p.nume_produs, p.pret, c.cantitate, u.username, u.adresa, u.localitate, u.judet, c.raspuns
                                FROM cos c
                                JOIN produse p ON p.id_produs = c.product_id
                                JOIN utilizatori u ON u.id_user = c.user_id 
                                WHERE (p.nume_produs LIKE '%$search%' OR u.username LIKE '%$search%') AND c.status='Comandat' AND p.producer_id = $producer_id
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
                echo "<td><a class='btn2' href='?accept=" . $row->id_cos . "'>Acceptare</a></td>";
                echo "<td><a class='btn1' href='?refuz=" . $row->id_cos . "'>Refuzare</a></td>";

                if ($row->raspuns == "Acceptat")
                    echo "<td><img src='imagini\acceptat.png' width='30' height='30' alt='Comanda acceptata'></td>";
                else
                    if ($row->raspuns == "Refuzat")
                        echo "<td><img src='imagini\cancel.png' width='30' height='30' alt='Comanda refuzata'></td>";
                    else
                        echo "<td></td>";
                    echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "Nu sunt inregistrari in tabela!";
        }
    } else {
        echo "Error: " . $mysqli->error;
    }
    $mysqli->close();
    ?>
</body>

</html>