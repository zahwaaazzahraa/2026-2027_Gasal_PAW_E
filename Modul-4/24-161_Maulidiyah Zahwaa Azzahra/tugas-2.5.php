<?php
function validateName(&$errors, $field_list, $field_name)
{
    $pattern = "/^[a-zA-Z'-]+$/"; 
    
    if (!isset($field_list[$field_name]) || empty($field_list[$field_name])) {
        $errors[$field_name] = 'required';
    } else if (!preg_match($pattern, $field_list[$field_name])) {
        $errors[$field_name] = 'invalid';
    }
}

$errors = array();

if (isset($_POST['surname'])) {
    validateName($errors, $_POST, 'surname');
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Detail Error</title>
</head>
<body>
    <h3>Pengujian Menampilkan Detail Error </h3>

    <?php
    if (isset($_POST['surname'])) {
        if ($errors) {
            echo 'Errors: <br/>';
            foreach ($errors as $field => $error) {
                echo "$field $error</br>";
            }
        } else {
            echo 'Data OK!';
        }
    }
    ?>

    <form action="Tugas-2.5.php" method="POST">
        <label>Surname:</label>
        <input type="text" name="surname" value="<?php echo isset($_POST['surname']) ? htmlspecialchars($_POST['surname']) : ''; ?>">
        <input type="submit" value="Submit">
    </form>
</body>
</html>