<?php

function validateName($field_list, $field_name)
{
    if (!isset($field_list[$field_name]))
        return false;

    $pattern = "/^[a-zA-Z'-]+$/"; 
    if (!preg_match($pattern, $field_list[$field_name]))
        return false;
        
    return true;
}

$status = "";

if (isset($_POST['surname'])) {
    if (validateName($_POST, 'surname')) {
        $status = 'Data OK!';
    } else {
        $status = 'Data invalid!';
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Pengujian Validasi</title>
</head>
<body>
    <h3>Pengujian Langkah #3: Validasi Sederhana</h3>

    <?php if ($status != ""): ?>
        <p><b>Status: <?php echo $status; ?></b></p>
    <?php endif; ?>

    <form action="Tugas-2.3.php" method="POST">
        <label>Surname:</label>
        <input type="text" name="surname" value="<?php echo isset($_POST['surname']) ? htmlspecialchars($_POST['surname']) : ''; ?>">
        <input type="submit" value="Submit">
    </form>
</body>
</html>