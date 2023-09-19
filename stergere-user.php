<?php
include("conectare.php");
if (isset($_GET['id_user']) && is_numeric($_GET['id_user'])) {
    $id = $_GET['id_user']; {
            if ($stmt = $mysqli->prepare("DELETE FROM utilizatori WHERE id_user = ?")) {
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
echo "<p><a href=\"vizualizare-user.php\">Back to the page</a></p>";