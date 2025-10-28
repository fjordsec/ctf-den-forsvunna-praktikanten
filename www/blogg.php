<?php
session_start();


if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {

    header('Location: index.php');
    exit;
}

$access_granted = false;
$error_message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $password = $_POST['password'] ?? '';
    if ($password === 'framtidenärhemligheten') {
        $access_granted = true;
    } else {
        $error_message = '<p class="error">Fel lösenord. Åtkomst nekad.</p>';
    }
}
?>
<!DOCTYPE html>
<html lang="sv">
<head>
    <meta charset="UTF-8">
    <title>Alexs dolda blogg</title>
    <link rel="stylesheet" href="style.css"> 
</head>
<body>
    <div class="container">
        <h1>Alexs dolda blogg</h1>

        <?php if ($access_granted): ?>
            <div class="blog-post">
                <h2>En stunds paus...</h2>
                <p><em>Publicerat: 2025-10-28</em></p>
                <p>Hittade ett lugnt ställe att tänka på. Allt är så komplicerat just nu. Jag hoppas att de förstår ledtrådarna jag lämnade efter mig. Det är viktigt att sanningen kommer fram.</p>
                <img src="bilder/cafe.jpg" alt="En kopp kaffe på ett cafébord" style="max-width: 100%; border-radius: 4px;">
                <p><strong>Ledtråd:</strong> Allt finns i detaljerna.</p>
            </div>
            <hr>
            <a href="flagga.php">Gå till flaggsidan</a>

        <?php else: ?>
            <p>Denna blogg är skyddad. Vänligen ange lösenordet du har hittat för att fortsätta.</p>
            <form action="blogg.php" method="post">
                <label for="password">Lösenord:</label>
                <input type="password" id="password" name="password" required>
                <button type="submit">Lås upp</button>
            </form>
            <?php echo $error_message; ?>
        <?php endif; ?>

    </div>
</body>
</html>