<?php
$errors = array();
if (isset($_POST['surname']))
{
    require 'tugas-2.4.php'; // validate.inc
    validateName($errors, $_POST, 'surname');
    if ($errors)
    {
        echo '<h1>Invalid, correct the following errors:</h1>';
        foreach ($errors as $field => $error)
            echo "$field $error</br>";

        // tampilkan kembali form
        include 'tugas-3.7.php'; // form.inc
    }
    else
    {
        echo 'Form submitted successfully with no errors';
    }
}
else
{
    // tampilkan kembali form
    include 'tugas-3.7.php'; // form.inc
}
?>
