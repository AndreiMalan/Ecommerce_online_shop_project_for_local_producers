<?php
include("conectare.php");
if (isset($_GET['id_categorie']) && is_numeric($_GET['id_categorie'])) {
    $id = $_GET['id_categorie']; {
            if ($stmt = $mysqli->prepare("DELETE FROM categorii WHERE id_categorie = ?")) {
                $stmt->bind_param("i", $id);
                if ($stmt->execute())
                    $stmt->close();
            } else {
                echo "ERROR: Nu se poate executa delete.";
            }
            $mysqli->close();
            echo "<div>Inregistrarea a fost stearsa!</div>";
        }
    } else {
        echo "<div>Inregistrarea nu a fost stearsa.</div>";
    }
echo "<p><a href=\"vizualizare-categorii.php\">Back to the page</a></p>";