<?php
$errors = array(); 
if (isset($_POST['surname'])) 
{
    require 'validate.inc';
    validateName($errors, $_POST, 'surname');
    if ($errors) 
    {
        echo '<h1>Invalid, correct the following errors:</h1>';
        foreach ($errors as $field => $error)
            echo "$field $error<br>";

        // Tampilkan form kembali
        tampilkanForm();
    }
    else 
    {
        echo 'Form submitted successfully with no errors';
    }
} 
else 
{
    tampilkanForm();
}

function tampilkanForm() {
    ?>
    <form action="Tugas-3.4.php" method="POST">
        <label>Surname:</label>
        <input type="text" name="surname" value="<?php echo isset($_POST['surname']) ? htmlspecialchars($_POST['surname']) : ''; ?>">
        <input type="submit" value="Submit">
    </form>
    <?php
}
?>