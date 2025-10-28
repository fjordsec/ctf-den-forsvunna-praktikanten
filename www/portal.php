<?php
session_start();
$_SESSION['logged_in'] = true; // Sätter sessionen så bloggen vet att vi är inne
?>
<!DOCTYPE html>
<html lang="sv">
<head>
    <meta charset="UTF-8">
    <title>Välkommen till portalen</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Välkommen, Admin!</h1>
        <p><strong>Flagga:</strong> <i>CTF{välkommen_till_systemet}</i></p>
        <p>Du är inloggad. Här är materialet från Alexs dator:</p>
        <ul>
            <li><a href="/filer/meddelande.html">Alexs sista meddelande (meddelande.html)</a></li>
            <li><a href="/bilder/team.png">En teambild (team.png)</a></li>
            <li><a href="/filer/alex_usb.img">Avbild av Alexs USB-minne (alex_usb.img)</a></li>
        </ul>
        <p>Det verkar som att Alex även hade en låst blogg. Kanske kan du hitta lösenordet i materialet?</p>
        <a href="blogg.php">Gå till Alexs blogg</a>
        <hr>
        <a href="flagga.php">Gå till flaggsidan för att registrera dina framsteg!</a>
    </div>
</body>
</html> 