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
    <title>Medici</title>
    <style>
        .specialization-group {
            margin-bottom: 25px;
        }
        .specialization-title {
            font-weight: bold;
            font-size: 1.1em;
            margin: 15px 0 8px 0;
            color: #2c3e50;
        }
        .doctor-list {
            list-style-type: none;
            padding-left: 20px;
        }
        .doctor-list li {
            margin-bottom: 5px;
            position: relative;
            padding-left: 15px;
        }
        .doctor-list li:before {
            content: "•";
            position: absolute;
            left: 0;
            color: #3498db;
        }
        .cas-badge {
            background-color: #27ae60;
            color: white;
            padding: 2px 6px;
            border-radius: 3px;
            font-size: 0.8em;
            margin-left: 8px;
        }
    </style>
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
    
    <main style="max-width: 1000px; margin: 0 auto; padding: 20px;">
        <h4>Colectivul medical</h4>
        
        <?php
        // Get doctors grouped by specialization
        $query = "SELECT specializare, nume, descriere, cas FROM medici ORDER BY specializare, nume ASC";
        $result = mysqli_query($id_conexiune, $query) or die(mysqli_error($id_conexiune));
        
        if (mysqli_num_rows($result) > 0) {
            $current_specialization = null;
            
            while ($row = mysqli_fetch_assoc($result)) {
                // Start new specialization group if changed
                if ($row['specializare'] !== $current_specialization) {
                    // Close previous group if exists
                    if ($current_specialization !== null) {
                        echo "</ul></div>";
                    }
                    
                    $current_specialization = $row['specializare'];
                    echo '<div class="specialization-group">';
                    echo '<div class="specialization-title">' . htmlspecialchars($current_specialization);

                   
                    
                    // Check if any doctor in this specialization has CAS
                    $cas_query = "SELECT 1 FROM medici WHERE specializare = '" . 
                                mysqli_real_escape_string($id_conexiune, $current_specialization) . 
                                "' AND cas = 1 LIMIT 1";
                    $cas_result = mysqli_query($id_conexiune, $cas_query);
                    if (mysqli_num_rows($cas_result) > 0) {
                        echo ' <span class="cas-badge">CAS</span>';
                    }
                    
                    echo '</div>';
                    echo '<ul class="doctor-list">';
                }
                
                // Display doctor
                echo '<li>' . htmlspecialchars($row['nume']);
                if ($row['cas']) {
                    echo ' <span class="cas-badge">CAS</span>';
                }
                
                echo '</li>';
            }
            
            // Close the last group
            if ($current_specialization !== null) {
                echo "</ul></div>";
            }
        } else {
            echo "<p>Nu există medici înregistrați.</p>";
        }
        
        mysqli_free_result($result);
        mysqli_close($id_conexiune);
        ?>
    </main>
</body>
</html>