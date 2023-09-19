<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>

<head>
    <title>Vizualizare Statistici</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="stylesheet" href="stats.css">
    <link rel="stylesheet" href="style3.css">
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
    $welcome_message = "Bine ai venit, " . $admin . "!" . " Aici puteti vizualiza statistici relevante pentru analiza platformei si a impactului sau";
    ?>
    <h1 class="center">Vizualizare statistici</h1>
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
    </nav>
    <?php
    $producatori = $mysqli->query("SELECT COUNT(*) as total_producers FROM producatori");
    if ($producatori->num_rows > 0) {
        $row = $producatori->fetch_assoc();
        $total_producers = $row["total_producers"];
    } else {
        echo "Nu sunt inregistrari in tabela!";
    }
    $utilizatori = $mysqli->query("SELECT COUNT(*) as total_users FROM utilizatori");
    if ($utilizatori->num_rows > 0) {
        $row = $utilizatori->fetch_assoc();
        $total_users = $row["total_users"];
    } else {
        echo "Nu sunt inregistrari in tabela!";
    }
    $categorii = $mysqli->query("SELECT COUNT(*) as total_categorii FROM categorii");
    if ($categorii->num_rows > 0) {
        $row = $categorii->fetch_assoc();
        $total_categorii = $row["total_categorii"];
    } else {
        echo "Nu sunt inregistrari in tabela!";
    }
    $produse = $mysqli->query("SELECT COUNT(*) as total_produse FROM produse");
    if ($produse->num_rows > 0) {
        $row = $produse->fetch_assoc();
        $total_produse = $row["total_produse"];
    } else {
        echo "Nu sunt inregistrari in tabela!";
    }
    $recenzii = $mysqli->query("SELECT COUNT(*) as total_recenzii FROM recenzii");
    if ($recenzii->num_rows > 0) {
        $row = $recenzii->fetch_assoc();
        $total_recenzii = $row["total_recenzii"];
    } else {
        echo "Nu sunt inregistrari in tabela!";
    }
    $comenzi = $mysqli->query("SELECT COUNT(*) as total_comenzi FROM cos WHERE status='Comandat'");
    if ($comenzi->num_rows > 0) {
        $row = $comenzi->fetch_assoc();
        $total_comenzi = $row["total_comenzi"];
    } else {
        echo "Nu sunt inregistrari in tabela!";
    }
    $comenzi_acceptate = $mysqli->query("SELECT COUNT(*) as total_comenzi_acceptate FROM cos WHERE raspuns='Acceptat'");
    if ($comenzi_acceptate->num_rows > 0) {
        $row = $comenzi_acceptate->fetch_assoc();
        $total_comenzi_acceptate = $row["total_comenzi_acceptate"];
    } else {
        echo "Nu sunt inregistrari in tabela!";
    }
    $comenzi_refuzate = $mysqli->query("SELECT COUNT(*) as total_comenzi_refuzate FROM cos WHERE raspuns='Refuzat'");
    if ($comenzi_refuzate->num_rows > 0) {
        $row = $comenzi_refuzate->fetch_assoc();
        $total_comenzi_refuzate = $row["total_comenzi_refuzate"];
    } else {
        echo "Nu sunt inregistrari in tabela!";
    }
    $medie_comenzi_producers = $total_comenzi/$total_producers;
    echo "<br>";
    $pret_mediu = $mysqli->query("SELECT ROUND(AVG(pret), 2) as avg_price FROM produse");
    if ($pret_mediu->num_rows > 0) {
        $row = $pret_mediu->fetch_assoc();
        $avg_price = $row["avg_price"];
    } else {
        echo "Nu sunt inregistrari in tabela!";
    }
    $mysqli->close();
    ?>
    <div style="overflow: auto;">
        <div class="flip-card">
            <div class="flip-card-inner">
                <div class="flip-card-front">
                    <p class="title">Numar total de producatori</p>
                </div>
                <div class="flip-card-back">
                    <p class="title">
                        <?php echo $total_producers; ?>
                    </p>
                </div>
            </div>
        </div>
        <div class="flip-card">
            <div class="flip-card-inner">
                <div class="flip-card-front">
                    <p class="title">Numar total de utilizatori</p>
                </div>
                <div class="flip-card-back">
                    <p class="title">
                        <?php echo $total_users; ?>
                    </p>
                </div>
            </div>
        </div>
        <div class="flip-card">
            <div class="flip-card-inner">
                <div class="flip-card-front">
                    <p class="title">Numar total de categorii de produse</p>
                </div>
                <div class="flip-card-back">
                    <p class="title">
                        <?php echo $total_categorii; ?>
                    </p>
                </div>
            </div>
        </div>
        <div class="flip-card">
            <div class="flip-card-inner">
                <div class="flip-card-front">
                    <p class="title">Numar total de produse in magazin</p>
                </div>
                <div class="flip-card-back">
                    <p class="title">
                        <?php echo $total_produse; ?>
                    </p>
                </div>
            </div>
        </div>
        <div class="flip-card">
            <div class="flip-card-inner">
                <div class="flip-card-front">
                    <p class="title">Numar total de recenzii</p>
                </div>
                <div class="flip-card-back">
                    <p class="title">
                        <?php echo $total_recenzii; ?>
                    </p>
                </div>
            </div>
        </div>
        <div class="flip-card">
            <div class="flip-card-inner">
                <div class="flip-card-front">
                    <p class="title">Numar total de comenzi plasate</p>
                </div>
                <div class="flip-card-back">
                    <p class="title">
                        <?php echo $total_comenzi; ?>
                    </p>
                </div>
            </div>
        </div>
        <div class="flip-card">
            <div class="flip-card-inner">
                <div class="flip-card-front">
                    <p class="title">Numar total de comenzi acceptate</p>
                </div>
                <div class="flip-card-back">
                    <p class="title">
                        <?php echo $total_comenzi_acceptate; ?>
                    </p>
                </div>
            </div>
        </div>
        <div class="flip-card">
            <div class="flip-card-inner">
                <div class="flip-card-front">
                    <p class="title">Numar total de comenzi refuzate</p>
                </div>
                <div class="flip-card-back">
                    <p class="title">
                        <?php echo $total_comenzi_refuzate; ?>
                    </p>
                </div>
            </div>
        </div>
        <div class="flip-card">
            <div class="flip-card-inner">
                <div class="flip-card-front">
                    <p class="title">Numar mediu de comenzi pe producator</p>
                </div>
                <div class="flip-card-back">
                    <p class="title">
                        <?php echo $medie_comenzi_producers; ?>
                    </p>
                </div>
            </div>
        </div>
        <div class="flip-card">
            <div class="flip-card-inner">
                <div class="flip-card-front">
                    <p class="title">Pret mediu pe produs</p>
                </div>
                <div class="flip-card-back">
                    <p class="title">
                        <?php echo $avg_price . " RON"; ?>
                    </p>
                </div>
            </div>
        </div>
    </div>
</body>