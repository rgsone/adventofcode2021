<?php

##===========================##
#---- Advent Of Code 2021 ----#
##---        Day 02       ---##
###=========================###

$input = new SplFileObject('input.txt');

######################
## --- PART ONE --- ##

$depth = 0;
$hPos = 0;

while (!$input->eof()) {
    [$command, $value] = explode(' ', $input->fgets());
    if ($command === 'up') $depth -= (int)$value;
    else if ($command === 'down') $depth += (int)$value;
    else if ($command === 'forward') $hPos += (int)$value;
}

echo "Part One : " . ($depth * $hPos) . "\n";

######################
## --- PART TWO --- ##

$input->rewind();

$depth = 0;
$hPos = 0;
$aim = 0;

while (!$input->eof()) {
    [$command, $value] = explode(' ', $input->fgets());
    if ($command === 'up') $aim -= (int)$value;
    else if ($command === 'down') $aim += (int)$value;
    else if ($command === 'forward') {
        $hPos += (int)$value;
        $depth += $aim * (int)$value;
    }
}

echo "Part Two : " . ($depth * $hPos) . "\n";
