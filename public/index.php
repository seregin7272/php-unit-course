<?php
declare(strict_types=1);

require_once '../vendor/autoload.php';

$BMI = new BMICalculator();

$BMI->mass = (float) $_REQUEST['mass'];
$BMI->height = (float) $_REQUEST['height'];

$BMI->BMI = $BMI->calculate();

echo 'Индекс:' . $BMI->BMI, '  ' , $BMI->getTextResult();