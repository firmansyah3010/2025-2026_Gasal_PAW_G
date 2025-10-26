<?php
// --- Regular expression & string validation ---
function validateName($fields, $field_name, &$errors) {
    $value = trim($fields[$field_name] ?? '');
    if ($value === '') {
        $errors[] = "Field '$field_name' tidak boleh kosong.";
        return false;
    }
    if (!preg_match("/^[a-zA-Z'-]+$/", $value)) {
        $errors[] = "Field '$field_name' hanya boleh berisi huruf, tanda kutip tunggal, atau tanda hubung.";
        return false;
    }
    return true;
}

function validateUsername($fields, &$errors) {
    $username = trim($fields['username'] ?? '');
    if ($username === '') {
        $errors[] = "Username tidak boleh kosong.";
        return false;
    }
    if (!preg_match("/^[a-zA-Z0-9_]{3,20}$/", $username)) {
        $errors[] = "Username harus 3-20 karakter, hanya huruf, angka, atau underscore.";
        return false;
    }
    return true;
}

function validateEmail($fields, &$errors) {
    $email = trim($fields['email'] ?? '');
    if ($email === '') {
        $errors[] = "Email tidak boleh kosong.";
        return false;
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Format email tidak valid.";
        return false;
    }
    return true;
}

function validatePassword($fields, &$errors) {
    $password = $fields['password'] ?? '';
    if (trim($password) === '') {
        $errors[] = "Password tidak boleh kosong.";
        return false;
    }
    if (strlen($password) < 6) {
        $errors[] = "Password minimal 6 karakter.";
        return false;
    }
    return true;
}

function validateAddress($fields, &$errors) {
    $address = trim($fields['address'] ?? '');
    if ($address === '') {
        $errors[] = "Alamat tidak boleh kosong.";
        return false;
    }
    return true;
}

// --- Type & value validation ---
function validateSemester($fields, &$errors) {
    $validSemesters = ['1','2','3','4'];
    if (!isset($fields['semester']) || !in_array($fields['semester'], $validSemesters)) {
        $errors[] = "Semester tidak valid.";
        return false;
    }
    return true;
}

function validateGender($fields, &$errors) {
    $validGenders = ['Laki-laki','Perempuan'];
    if (!isset($fields['gender']) || !in_array($fields['gender'], $validGenders)) {
        $errors[] = "Gender tidak valid.";
        return false;
    }
    return true;
}

function validateHobi($fields, &$errors) {
    $validHobi = ['Membaca','Olahraga','Musik','Gaming'];
    if (!isset($fields['hobi']) || !is_array($fields['hobi']) || count($fields['hobi']) === 0) {
        $errors[] = "Hobi tidak boleh kosong.";
        return false;
    }
    foreach ($fields['hobi'] as $h) {
        if (!in_array($h, $validHobi)) {
            $errors[] = "Hobi '$h' tidak valid.";
            return false;
        }
    }
    return true;
}

// --- Date validation ---
function validateBirthdate($fields, &$errors) {
    if (empty($fields['birthdate'])) {
        $errors[] = "Birthdate tidak boleh kosong.";
        return false;
    }
    $parts = explode('-', $fields['birthdate']);
    if (count($parts) !== 3 || !checkdate((int)$parts[1], (int)$parts[2], (int)$parts[0])) {
        $errors[] = "Birthdate tidak valid.";
        return false;
    }
    return true;
}
?>
