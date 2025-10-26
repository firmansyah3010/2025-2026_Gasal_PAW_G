<?php
require 'validate.inc';
$errors = [];
$isValid = true;

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // --- Validasi setiap field ---
    $isValid &= validateName($_POST, 'surname', $errors);
    $isValid &= validateUsername($_POST, $errors);
    $isValid &= validateEmail($_POST, $errors);
    $isValid &= validatePassword($_POST, $errors);
    $isValid &= validateAddress($_POST, $errors);
    $isValid &= validateSemester($_POST, $errors);
    $isValid &= validateGender($_POST, $errors);
    $isValid &= validateHobi($_POST, $errors);
    $isValid &= validateBirthdate($_POST, $errors);

    if ($isValid) {
        echo "<h3>Form submitted successfully!</h3>";
        echo "<p>Data yang Anda masukkan:</p><ul>";
        foreach ($_POST as $key => $val) {
            if (is_array($val)) $val = implode(", ", $val);
            echo "<li>".htmlspecialchars($key).": ".htmlspecialchars($val)."</li>";
        }
        echo "</ul>";
    } else {
        // Jika ada error, tampilkan form lagi dengan pesan error
        $errors_html = $errors;
        include 'from.inc';
    }
} else {
    include 'from.inc';
}
?>
