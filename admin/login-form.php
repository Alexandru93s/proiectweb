<h2>Admin Login</h2>
<?php if (isset($error)): ?>
    <div class="error"><?= $error ?></div>
<?php endif; ?>

<form method="post" action="index.php">
    <input type="hidden" name="comanda" value="login">
    
    <div>
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required>
    </div>
    
    <div>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>
    </div>
    
    <button type="submit">Login</button>
</form>