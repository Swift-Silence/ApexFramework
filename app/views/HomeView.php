<!doctype html>

<html lang="en">
    <head>
        <!-- <link rel="stylesheet" type="text/css" href="/css/style.css" /> -->
    </head>

    <body>

        <?= $this -> _('navigation'); ?>

    </body>
</html>

<?php

$levels = [];
$cLevel = 0;
$cNextEP = 0;
$baseEP = 1000;
$maxLevel = 100;

while ($cLevel < $maxLevel)
{
    $levels[$cLevel] = $cNextEP;
    $cNextEP += floor(($cNextEP + $baseEP) * .07);
    $cLevel++;
}

echo '<pre>';
print_r($levels);
