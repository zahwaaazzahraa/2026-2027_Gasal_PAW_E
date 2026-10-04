<?php
$angka = 0;

echo '<div style="border: 3px dotted black; padding: 5px 15px; width: fit-content; font-family: Times New Roman, serif; font-size: 20px;">';

do {
    echo $angka . "<br>";
    $angka += 4;
} while ($angka <= 20);

echo '</div>';
?>