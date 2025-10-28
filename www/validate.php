<?php
session_start();

// Definiera alla korrekta flaggor
$correct_flags = [
    "CTF{välkommen_till_systemet}",
    "CTF{caesar_är_för_enkel}",
    "CTF{bilden_döljer_mer_än_du_tror}",
    "CTF{inget_försvinner_för_alltid}",
    "CTF{jag_är_på_säker_plats}"
];

// Hämta flaggan från formuläret
$submitted_flag = trim($_POST['flag'] ?? '');

// Kontrollera om flaggan är tom
if (empty($submitted_flag)) {
    header("Location: flagga.php?status=empty");
    exit();
}

// Kontrollera format (börja med CTF{ och sluta med })
if (!preg_match('/^CTF\{.*\}$/', $submitted_flag)) {
    header("Location: flagga.php?status=invalid_format");
    exit();
}

// Initiera sessionen om den inte finns
if (!isset($_SESSION['unlocked_flags'])) {
    $_SESSION['unlocked_flags'] = [];
}

// Kolla om flaggan är korrekt
if (in_array($submitted_flag, $correct_flags)) {
    // Kolla om den redan är inlämnad
    if (in_array($submitted_flag, $_SESSION['unlocked_flags'])) {
        header("Location: flagga.php?status=duplicate");
    } else {
        // Lägg till i sessionen och skicka tillbaka
        $_SESSION['unlocked_flags'][] = $submitted_flag;
        header("Location: flagga.php?status=correct");
    }
} else {
    // Skicka tillbaka med felmeddelande
    header("Location: flagga.php?status=incorrect");
}
exit();