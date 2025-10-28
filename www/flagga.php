<?php session_start(); $unlocked_flags = $_SESSION['unlocked_flags'] ?? []?>
<!DOCTYPE html>
<html lang="sv">
<head>
    <meta charset="UTF-8">
    <title>Flaggvalidering</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Registrera flaggor</h1>
        <p>Mata in en flagga för att se dina framsteg.</p>
        <form action="validate.php" method="post">
            <input type="text" name="flag" placeholder="CTF{...}" required>
            <button type="submit">Validera</button>
        </form>

        <?php if (count($unlocked_flags) == 5): ?>
        <div class="completion-message">
            <h2>🎉 Grattis! Du har klarat utmaningen! 🎉</h2>
            <p>Med alla flaggor insamlade har du lyckats följa de digitala spåren och avslöja sanningen bakom Alex försvinnande. Alex är nu i säkerhet på en hemlig plats, och myndigheterna har kontaktats för att hantera industrispionaget från FutureCorp.</p>
            <p>Tack för att du hjälpte till med utredningen!</p>
        </div>
        <?php endif; ?>

        <?php if (isset($_GET['status']) && $_GET['status'] == 'correct' && count($unlocked_flags) < 5): ?>
            <p class="success">Korrekt flagga! Bra jobbat!</p>
        <?php elseif (isset($_GET['status']) && $_GET['status'] == 'incorrect'): ?>
            <p class="error">Fel flagga, försök igen.</p>
        <?php elseif (isset($_GET['status']) && $_GET['status'] == 'duplicate'): ?>
            <p class="info">Du har redan skickat in den flaggan.</p>
        <?php elseif (isset($_GET['status']) && $_GET['status'] == 'empty'): ?>
            <p class="error">Flaggan kan inte vara tom. Mata in en giltig flagga.</p>
        <?php elseif (isset($_GET['status']) && $_GET['status'] == 'invalid_format'): ?>
            <p class="error">Ogiltigt format. Flaggor måste börja med 'CTF{' och sluta med '}'.</p>
        <?php endif; ?>

        <h2>Dina framsteg:</h2>
        <ol>
            <?php
            
            if (empty($unlocked_flags)) {
                echo "<li>Inga flaggor hittade än.</li>";
            } else {
                foreach ($unlocked_flags as $index => $flag) {
                    echo "<li class='success'>" . ($index + 1) . ". $flag</li>";
                }
            }
            ?>
        </ol>

        

        <a href="portal.php">Tillbaka till portalen</a>
    </div>
</body>
</html>