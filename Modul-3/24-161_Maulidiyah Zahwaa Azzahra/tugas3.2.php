<?php
$weight = array(
    "Andy" => "70",
    "Barry" => "65",
    "Charlie" => "75"
);

echo 'weight = ';
print_r($weight);
echo "<br>";

$keys = array_keys($weight);
echo "Data kedua: " . $weight[$keys[1]];
?>