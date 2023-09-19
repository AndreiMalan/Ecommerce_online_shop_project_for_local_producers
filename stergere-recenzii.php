<?php
include("conectare.php");
if (isset($_GET['id_recenzie']) && is_numeric($_GET['id_recenzie'])) {
    $id = $_GET['id_recenzie']; {
            if ($stmt = $mysqli->prepare("DELETE FROM recenzii WHERE id_recenzie = ?")) {
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
echo "<p><a href=\"vizualizare-recenzii.php\">Back to the page</a></p>";