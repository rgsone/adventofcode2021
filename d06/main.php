<?php

##===========================##
#---- Advent Of Code 2021 ----#
##---       Day 06        ---##
###=========================###

############################
## --- PART ONE + TWO --- ##

$file = new SplFileObject('input.txt');
$input = $file->fread($file->getSize());
$file = null;

function incube($fishes, $days) {
    $incubator = array_fill(0, 9, 0);

    foreach ($fishes as $fish)
        $incubator[$fish]++;

    for ($day = 0; $day < $days; $day++) {
        $current = array_shift($incubator);
        array_push($incubator, $current);
        $incubator[6] += $current;
    }
    
    return array_sum($incubator);
}

$fishes = array_map(fn($item) => (int)$item, explode(',', $input));

echo "Part One : " . incube($fishes, 80) . "\n";
echo "Part Two : " . incube($fishes, 256) . "\n";
