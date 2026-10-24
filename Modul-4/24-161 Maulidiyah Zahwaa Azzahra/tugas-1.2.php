<!DOCTYPE html>
<html>
<head><meta charset="utf-8"><title>Posted data</title></head>
<body>
<h3>Posted data: </h3>
<?php
foreach ($_POST as $key => $value)
    echo "($key) => ($value)<br/>";

//$surname = $_POST['surname'];
?>
</body>
</html>
