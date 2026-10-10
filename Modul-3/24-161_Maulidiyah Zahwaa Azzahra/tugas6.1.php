<?php
// 1. array_push()
$a = array("A");
echo "Array awal: ";
print_r($a);
echo "<br>";

array_push($a, "B");
echo "Hasil array_push: ";
print_r($a);
echo "<br><br>";

// 2. array_merge()
$a = array("A", "B");
$b = array("C");

echo "Array awal: ";
print_r($a);
echo "<br>";

$c = array_merge($a, $b);
echo "Hasil array_merge: ";
print_r($c);
echo "<br><br>";

// 3. array_values()
$a = array("X" => 1, "Y" => 2);

echo "Array awal: ";
print_r($a);
echo "<br>";

$b = array_values($a);
echo "Hasil array_values: ";
print_r($b);
echo "<br><br>";

// 4. array_search()
$a = array("A", "B", "C");

echo 'Mencari "B" pada array: ';
print_r($a);
echo "<br>";

$b = array_search("B", $a);
echo "Hasil array_search: " . $b;
echo "<br><br>";

// 5. array_filter()
$a = array(0, 1, false, 2, "", 3, "array");

echo "Array awal: ";
print_r($a);
echo "<br>";

$b = array_filter($a);
echo "Hasil array_filter: ";
print_r($b);
echo "<br><br>";

// 6. Sorting array terindeks
$a = array(3, 1, 2);

echo "Array awal: ";
print_r($a);
echo "<br>";

sort($a);
echo "Hasil sort: ";
print_r($a);
echo "<br>";

rsort($a);
echo "Hasil rsort: ";
print_r($a);
echo "<br><br>";

// 7. Sorting array asosiatif
$a = array("Peter" => 35, "Ben" => 37, "Joe" => 43);

echo "Array awal: ";
print_r($a);
echo "<br>";

asort($a);
echo "Hasil asort: ";
print_r($a);
echo "<br>";

arsort($a);
echo "Hasil arsort: ";
print_r($a);
echo "<br>";

ksort($a);
echo "Hasil ksort: ";
print_r($a);
echo "<br>";

krsort($a);
echo "Hasil krsort: ";
print_r($a);
?>