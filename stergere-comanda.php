<?php
include("conectare.php");
if (isset($_GET['id_cos']) && is_numeric($_GET['id_cos'])) {
    $id = $_GET['id_cos']; {
            if ($stmt = $mysqli->prepare("DELETE FROM cos WHERE id_cos = ?")) {
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
echo "<p><a href=\"vizualizare-comenzi.php\">Back to the page</a></p>";