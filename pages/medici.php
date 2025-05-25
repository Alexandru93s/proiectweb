<?php
require_once "../inc/config.php";
require_once "../inc/connect.php";
?>

<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8" />
    <title>Lista medici</title>
    <link rel="stylesheet" href="../pagestyles/nav.css" />
    <link rel="stylesheet" href="../pagestyles/medici.css">
</head>
<body>
<header>
        <nav>
            <h1><a href="../index.html">Clinica medicala</a></h1>
            <ul>
                <li><a href="../index.html">Home</a></li>
                <li><a href="../pages/serviciimedicale.php">Servicii Medicale</a></li>
                <li><a href="../pages/medici.php">Medici</a></li>
                <li><a href="../pages/galerie.html">Galerie</a></li>
                <li><a href="../pages/contact.html">Contact</a></li>
            </ul>
        </nav>
</header>
    <h2 style="text-align:center;">Lista medici cu specializările lor</h2>

    <table>
        <thead>
            <tr>
                <th>Nume medic</th>
                <th>Specializare</th>
                <th>Descriere</th>
            </tr>
        </thead>
        <tbody>
        <?php
        $query = "SELECT * FROM medici ORDER BY specializare, nume";
        $result = mysqli_query($id_conexiune, $query) or die(mysqli_error($id_conexiune));

        if(mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($row['nume']) . "</td>";
                echo "<td>" . htmlspecialchars($row['specializare']) . "</td>";
                echo "<td>" . htmlspecialchars($row['descriere']) . "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='2'>Nu există medici înregistrați.</td></tr>";
        }

        mysqli_free_result($result);
        mysqli_close($id_conexiune);
        ?>
        </tbody>
    </table>
</body>
</html>
