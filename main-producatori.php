<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <title>Main Page for Producers</title>
  <link rel="stylesheet" href="style3.css">
  <link rel="stylesheet" href="main.css">
  <script>
    window.addEventListener("load", function () {
      var image = document.getElementById("background");
      image.style.marginTop = (window.innerHeight - image.height) / 2 + "px";
    });
  </script>
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
  $producer = $mysqli->query("SELECT username FROM producatori WHERE id_producator = $producer_id")->fetch_object()->username;
  $welcome_message = "Bine ai venit, " . $producer . "!";
  ?>
  <h1 class="center">Pagina de gestiune destinata producatorilor</h1>
  <div class="center">
    <?php echo $welcome_message; ?>
  </div>
  <br>
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
  <div class="container">
    <img id="background" src="imagini/background.png" alt="Background">
</body>

</html>