<?php
// ---- fungsi validasi (menambah ke validate.inc) ----
function validateName(&$errors, $f, $n) {
    if (!isset($f[$n]) || trim($f[$n]) === '')
        $errors[$n] = 'required';
    else if (!preg_match("/^[a-zA-Z'-]+$/", $f[$n]))
        $errors[$n] = 'invalid (hanya huruf, apostrof, atau tanda hubung)';
}
function validateEmail(&$errors, $f, $n) {
    if (!isset($f[$n]) || trim($f[$n]) === '')
        $errors[$n] = 'required';
    else if (!filter_var($f[$n], FILTER_VALIDATE_EMAIL))
        $errors[$n] = 'invalid (format email salah)';
}
function validatePassword(&$errors, $f, $n) {
    if (!isset($f[$n]) || $f[$n] === '')
        $errors[$n] = 'required';
    else if (strlen($f[$n]) < 6)
        $errors[$n] = 'invalid (minimal 6 karakter)';
}
function validateRequired(&$errors, $f, $n) {
    if (!isset($f[$n]) || trim($f[$n]) === '')
        $errors[$n] = 'required';
}
function validateState(&$errors, $f, $n) {
    if (!isset($f[$n]) || $f[$n] === '-1')
        $errors[$n] = 'required (pilih salah satu state)';
    else if (!in_array($f[$n], array('1','2','3','4','5','6','7','8')))
        $errors[$n] = 'invalid';
}
function validateGender(&$errors, $f, $n) {
    if (!isset($f[$n]))
        $errors[$n] = 'required (pilih gender)';
    else if (!in_array($f[$n], array('male','female')))
        $errors[$n] = 'invalid';
}

// ---- pemrosesan ----
$errors = array();
if (isset($_POST['surname']))
{
    validateName($errors, $_POST, 'surname');
    validateEmail($errors, $_POST, 'email');
    validatePassword($errors, $_POST, 'passwd');
    validateRequired($errors, $_POST, 'address');
    validateState($errors, $_POST, 'state');
    validateGender($errors, $_POST, 'sex');

    if ($errors)
    {
        echo '<h1>Invalid, correct the following errors:</h1>';
        foreach ($errors as $field => $error)
            echo "$field $error</br>";
        include 'tugas-3.7.php'; // form + data sebelumnya
    }
    else
    {
        echo 'Form submitted successfully with no errors';
    }
}
else
{
    include 'tugas-3.7.php';
}
?>
