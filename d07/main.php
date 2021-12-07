<?php

##===========================##
#---- Advent Of Code 2021 ----#
##---       Day 07        ---##
###=========================###

$file = new SplFileObject('input.txt');
$input = $file->fread($file->getSize());
$file = null;

######################
## --- PART ONE --- ##

$positions = explode(',', $input);
sort($positions);
$median = $positions[floor(count($positions) / 2)];
$cost = array_reduce($positions, function ($cost, $pos) use ($median) {
    return $cost + abs($pos - $median);
}, 0);

echo "Part One : " . $cost . "\n";

######################
## --- PART TWO --- ##

$positions = explode(',', $input);
$average = array_sum($positions) / count($positions);
$roundedAverages = is_float($average) ? [floor($average), ceil($average)] : [$average];
$cost = array_map(function ($average) use ($positions) {
    return array_reduce($positions, function ($cost, $pos) use ($average) {
        return $cost + (abs($pos - $average) * (1 + abs($pos - $average)) / 2);
    }, 0);
}, $roundedAverages);

echo "Part Two : " . min($cost) . "\n";
