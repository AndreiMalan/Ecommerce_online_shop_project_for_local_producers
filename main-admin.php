<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <title>Main Page for Admin</title>
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
  if (!isset($_SESSION['id_admin'])) {
    header("Location: index-admin.html");
    exit;
  }

  $admin_id = $_SESSION['id_admin'];
  $admin = $mysqli->query("SELECT adminname FROM admin WHERE id_admin = $admin_id")->fetch_object()->adminname;
  $welcome_message = "Bine ai venit, " . $admin . "!";
  ?>
  <h1 class="center">Pagina de gestiune destinata administratorului</h1>
  <div class="center">
    <?php echo $welcome_message; ?>
  </div>
  <br>
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
  <div class="container">
    <img id="background" src="imagini/background.png" alt="Background">
</body>

</html>