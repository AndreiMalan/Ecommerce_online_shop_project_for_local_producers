<?php
include("conectare.php");
if (isset($_GET['id_producator']) && is_numeric($_GET['id_producator'])) {
    $id = $_GET['id_producator']; {
            if ($stmt = $mysqli->prepare("DELETE FROM producatori WHERE id_producator = ?")) {
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
echo "<p><a href=\"vizualizare-producatori.php\">Back to the page</a></p>";