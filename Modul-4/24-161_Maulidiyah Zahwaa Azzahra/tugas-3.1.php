<?php
$status = "";

if (isset($_POST['surname'])) {
    if (!empty($_POST['surname'])) {
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
    <title>Validasi Self-Submission</title>
</head>
<body>
    <h3>Pengujian Validasi dengan Self-Submission</h3>

    <?php if ($status != ""): ?>
        <p><b>Status: <?php echo $status; ?></b></p>
    <?php endif; ?>

    <form action="Tugas-3.1.php" method="POST">
        <label>Surname:</label>
        <input type="text" name="surname" value="<?php echo isset($_POST['surname']) ? htmlspecialchars($_POST['surname']) : ''; ?>">
        <input type="submit" value="Submit">
    </form>
</body>
</html>