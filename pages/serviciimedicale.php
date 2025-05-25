<?php
require_once "../inc/config.php";
require_once "../inc/connect.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="../pagestyles/nav.css" />
    <link rel="stylesheet" href="../pagestyles/servicii.css">
    <title>Servicii medicale</title>
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
    <h2>Servicii</h2>
    <p>
        Serviciile de specialitate sunt asigurate de un colectiv de peste 25
        medici specialisti sau primari, cadre universitare si doctori în stiinte
        medicale.<br /><br />
        <strong>Oferta noastră de servicii cuprinde:</strong>
    </p>
    <ul>
<?php
$query = "SELECT nume FROM specializari ORDER BY nume ASC";
$result = mysqli_query($id_conexiune, $query) or die(mysqli_error($id_conexiune));

if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<li>" . htmlspecialchars($row['nume']) . "</li>";
    }
    mysqli_free_result($result);
} else {
    echo "<li>Nu exista specializari inregistrate.</li>";
}

mysqli_close($id_conexiune);
?>
    </ul>
</body>
</html>