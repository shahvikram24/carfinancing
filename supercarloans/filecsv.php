<?php 

$csv = array();
$file = fopen('CanadaWideAutoSales.csv', 'r');

while (($result = fgetcsv($file)) !== false)
{
    $csv[] = $result;
}

fclose($file);

echo '<pre>';
print_r($csv);
echo '</pre>';

?>