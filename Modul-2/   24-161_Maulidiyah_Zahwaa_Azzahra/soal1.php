<?php
$matkul = ["PTI", "ALPRO", "DPW", "STRUKDAT", "JARKOM", "PAW", "PSBF", "RPL"];
$praktikum = ["JARKOM", "PAW"];

echo '<div style="border: 3px dotted black; padding: 5px; width: fit-content; font-family: Times New Roman, serif; font-size: 20px;">';

for ($i = 0; $i < count($matkul); $i++) {
    if (in_array($matkul[$i], $praktikum)) {
        // matkul sama dengan data di $praktikum
        echo "Saya sedang mengambil matkul " . $matkul[$i] . " termasuk praktikum nya<br>";
    } elseif ($i == 6 || $i == 7) {
        // indeks 6 atau 7
        echo "Saya belum mengambil matkul " . $matkul[$i] . "<br>";
    } else {
        // selain kondisi di atas
        echo "Saya sudah mengambil matkul " . $matkul[$i] . " semester lalu<br>";
    }
}

echo '</div>';
?>