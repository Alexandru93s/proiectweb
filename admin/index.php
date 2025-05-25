<?php
session_start();
require_once "../inc/config.php";
require_once "../inc/connect.php";

// Authentication functions
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

// Specialization functions
function listSpecializari() {
    global $id_conexiune;
    
    echo "<h2>Manage Specializations</h2>";
    echo "<table border='1'>";
    echo "<tr><th>ID</th><th>Name</th><th>Action</th></tr>";
    
    $query = "SELECT * FROM specializari ORDER BY nume ASC";
    $result = mysqli_query($id_conexiune, $query);
    
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>".htmlspecialchars($row['id'])."</td>";
        echo "<td>".htmlspecialchars($row['nume'])."</td>";
        echo "<td><a href='index.php?comanda=delete&id=".$row['id']."' onclick='return confirm(\"Are you sure?\")'>Delete</a></td>";
        echo "</tr>";
    }
    echo "</table>";
    
    // Add form
    echo "<h3>Add New Specialization</h3>";
    echo "<form method='post' action='index.php'>";
    echo "<input type='hidden' name='comanda' value='add'>";
    echo "<input type='text' name='nume' placeholder='Specialization name' required>";
    echo "<button type='submit'>Add</button>";
    echo "</form>";
}

function deleteSpecializare($id) {
    global $id_conexiune;
    $id = (int)$id;
    $query = "DELETE FROM specializari WHERE id = $id";
    return mysqli_query($id_conexiune, $query);
}

function addSpecializare($nume) {
    global $id_conexiune;
    $nume = mysqli_real_escape_string($id_conexiune, $nume);
    $query = "INSERT INTO specializari (nume) VALUES ('$nume')";
    return mysqli_query($id_conexiune, $query);
}

// Main logic
$comanda = $_REQUEST['comanda'] ?? '';

if (isset($comanda)) {
    switch ($comanda) {
        case 'login':
            $username = $_POST['username'] ?? '';
            $password = $_POST['password'] ?? '';
            if (!doLogin($username, $password)) {
                $error = "Login failed!";
            }
            break;
            
        case 'logout':
            doLogout();
            break;
            
        case 'delete':
            if (isLogged()) {
                $id = $_GET['id'] ?? 0;
                deleteSpecializare($id);
            }
            break;
            
        case 'add':
            if (isLogged()) {
                $nume = $_POST['nume'] ?? '';
                if (!empty($nume)) {
                    addSpecializare($nume);
                }
            }
            break;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Manage Specializations</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .error { color: red; }
        .success { color: green; }
        table { border-collapse: collapse; margin: 20px 0; }
        th, td { padding: 8px; border: 1px solid #ddd; }
    </style>
</head>
<body>
    <?php if (!isLogged()): ?>
        <?php include "login-form.php"; ?>
    <?php else: ?>
        <div style="float: right;">
            Welcome <b><?= htmlspecialchars(getLoggedUser()) ?></b> | 
            <a href="index.php?comanda=logout">Logout</a>
        </div>
        
        <?php if (isset($error)): ?>
            <div class="error"><?= $error ?></div>
        <?php endif; ?>
        
        <?php listSpecializari(); ?>
    <?php endif; ?>
</body>
</html>