<?php
$height = array(
    "Andy" => "176",
    "Barry" => "165",
    "Charlie" => "170"
);

$height["David"] = "180";
$height["Ethan"] = "172";
$height["Frank"] = "168";
$height["George"] = "175";
$height["Harry"] = "182";

echo 'height = ("Andy"=>"176", "Barry"=>"165", "Charlie"=>"170", "David"=>"180", "Ethan"=>"172", "Frank"=>"168", "George"=>"175", "Harry"=>"182")';
echo "<br>";

$kunciTerakhir = array_key_last($height);
echo "Nilai dengan indeks terakhir: " . $height[$kunciTerakhir];
echo "<br><br>";

unset($height["Barry"]);

echo 'height = ("Andy"=>"176", "Charlie"=>"170", "David"=>"180", "Ethan"=>"172", "Frank"=>"168", "George"=>"175", "Harry"=>"182")';
echo "<br>";

$kunciTerakhir = array_key_last($height);
echo "Nilai dengan indeks terakhir setelah dihapus: " . $height[$kunciTerakhir];
?>