<?php
session_start();
require_once "../inc/config.php";
require_once "../inc/connect.php";

// Autentificare
function isLogged() {
    return isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true;
}

function getLoggedUser() {
    return $_SESSION['username'] ?? '';
}

function doLogin($username, $password) {
    global $id_conexiune;
    $username = mysqli_real_escape_string($id_conexiune, $username);
    $query = "SELECT * FROM admin_users WHERE username = '$username'";
    $result = mysqli_query($id_conexiune, $query);

    if (mysqli_num_rows($result) == 1) {
        $user = mysqli_fetch_assoc($result);
        if (password_verify($password, $user['password'])) {
            $_SESSION['logged_in'] = true;
            $_SESSION['username'] = $user['username'];
            return true;
        }
    }
    return false;
}

function doLogout() {
    session_unset();
    session_destroy();
}

// Funcții specializări
function listSpecializari() {
    global $id_conexiune;

    echo "<h2>Specializări</h2>";
    echo "<table border='1'>";
    echo "<tr><th>ID</th><th>Nume</th><th>Acțiune</th></tr>";

    $result = mysqli_query($id_conexiune, "SELECT * FROM specializari ORDER BY nume ASC");
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>
                <td>".htmlspecialchars($row['id'])."</td>
                <td>".htmlspecialchars($row['nume'])."</td>
                <td><a href='index.php?comanda=delete_specializare&id=".$row['id']."' onclick='return confirm(\"Ești sigur?\")'>Șterge</a></td>
              </tr>";
    }
    echo "</table>";

    echo "<h3>Adaugă specializare</h3>
          <form method='post' action='index.php'>
              <input type='hidden' name='comanda' value='add_specializare'>
              <input type='text' name='nume' placeholder='Nume specializare' required>
              <button type='submit'>Adaugă</button>
          </form>";
}

function deleteSpecializare($id) {
    global $id_conexiune;
    $id = (int)$id;
    return mysqli_query($id_conexiune, "DELETE FROM specializari WHERE id = $id");
}

function addSpecializare($nume) {
    global $id_conexiune;
    $nume = mysqli_real_escape_string($id_conexiune, $nume);
    return mysqli_query($id_conexiune, "INSERT INTO specializari (nume) VALUES ('$nume')");
}

// Funcții medici
function listMedici() {
    global $id_conexiune;

    echo "<h2>Medici</h2>";
    echo "<table border='1'>";
    echo "<tr><th>ID</th><th>Specializare</th><th>Nume</th><th>Descriere</th><th>CAS</th><th>Acțiune</th></tr>";

    $result = mysqli_query($id_conexiune, "SELECT * FROM medici ORDER BY specializare ASC");
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>
                <td>".htmlspecialchars($row['id'])."</td>
                <td>".htmlspecialchars($row['specializare'])."</td>
                <td>".htmlspecialchars($row['nume'])."</td>
                <td>".htmlspecialchars($row['descriere'])."</td>
                <td>".($row['cas'] ? 'DA' : 'NU')."</td>
                <td><a href='index.php?comanda=delete_medic&id=".$row['id']."' onclick='return confirm(\"Ștergi acest medic?\")'>Șterge</a></td>
              </tr>";
    }
    echo "</table>";

    // Formular adăugare
    echo "<h3>Adaugă medic</h3>
          <form method='post' action='index.php'>
              <input type='hidden' name='comanda' value='add_medic'>
              <input type='text' name='specializare' placeholder='Specializare' required>
              <input type='text' name='nume' placeholder='Nume medic' required>
              <input type='text' name='descriere' placeholder='Descriere'>
              <label><input type='checkbox' name='cas' value='1'> Acceptă CAS</label>
              <button type='submit'>Adaugă</button>
          </form>";
}

function deleteMedic($id) {
    global $id_conexiune;
    $id = (int)$id;
    return mysqli_query($id_conexiune, "DELETE FROM medici WHERE id = $id");
}

function addMedic($specializare, $nume, $descriere, $cas) {
    global $id_conexiune;
    $specializare = mysqli_real_escape_string($id_conexiune, $specializare);
    $nume = mysqli_real_escape_string($id_conexiune, $nume);
    $descriere = mysqli_real_escape_string($id_conexiune, $descriere);
    $cas = $cas ? 1 : 0;

    return mysqli_query($id_conexiune, "INSERT INTO medici (specializare, nume, descriere, cas)
                                        VALUES ('$specializare', '$nume', '$descriere', $cas)");
}

// Procesare comenzi
$comanda = $_REQUEST['comanda'] ?? '';
if (!empty($comanda)) {
    switch ($comanda) {
        case 'login':
            $username = $_POST['username'] ?? '';
            $password = $_POST['password'] ?? '';
            if (!doLogin($username, $password)) {
                $error = "Login eșuat!";
            }
            break;
        case 'logout':
            doLogout();
            break;
        case 'add_specializare':
            if (isLogged() && !empty($_POST['nume'])) {
                addSpecializare($_POST['nume']);
            }
            break;
        case 'delete_specializare':
            if (isLogged() && isset($_GET['id'])) {
                deleteSpecializare($_GET['id']);
            }
            break;
        case 'add_medic':
            if (isLogged()) {
                addMedic($_POST['specializare'], $_POST['nume'], $_POST['descriere'], $_POST['cas'] ?? 0);
            }
            break;
        case 'delete_medic':
            if (isLogged() && isset($_GET['id'])) {
                deleteMedic($_GET['id']);
            }
            break;
    }
}
?>

<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <title>Admin Clinica</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        table { border-collapse: collapse; margin: 20px 0; }
        th, td { padding: 8px; border: 1px solid #ccc; }
        input, button { margin: 5px; }
        .error { color: red; }
    </style>
</head>
<body>
<?php if (!isLogged()): ?>
    <?php include "login-form.php"; ?>
<?php else: ?>
    <div style="float: right;">
        Bine ai venit, <strong><?= htmlspecialchars(getLoggedUser()) ?></strong> |
        <a href="index.php?comanda=logout">Logout</a>
    </div>

    <?php if (isset($error)): ?>
        <p class="error"><?= $error ?></p>
    <?php endif; ?>

    <?php
        listSpecializari();
        listMedici();
    ?>
<?php endif; ?>
</body>
</html>
