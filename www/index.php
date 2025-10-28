<?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $user = $_POST['username'] ?? '';
        $pass = $_POST['password'] ?? '';

        if ($user === 'admin' && $pass === 'password123') {
            header("Location: portal.php");
            exit();
        } else {
            $error = "<p class='error'>Felaktigt användarnamn eller lösenord.</p>";
        }
    }
?>
<!DOCTYPE html>
<html lang="sv">
<head>
    <meta charset="UTF-8">
    <title>Innovatech Solutions - Login</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Innovatech Internportal</h1>
        <!-- Kom ihåg att ta bort testanvändaren 'admin' med det enkla lösenordet 'password123' innan lansering. -->
        <form action="index.php" method="post">
            <input type="text" name="username" placeholder="Användarnamn" required>
            <input type="password" name="password" placeholder="Lösenord" required>
            <button type="submit">Logga in</button>
        </form>
        <?php
            if (isset($error)) {
                echo $error;
            }
        ?>
    </div>
</body>
</html>