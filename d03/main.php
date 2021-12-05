<?php

##===========================##
#---- Advent Of Code 2021 ----#
##---        Day 03       ---##
###=========================###

$input = new SplFileObject('input.txt');

######################
## --- PART ONE --- ##

$bits = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
$bitsLength = count($bits);

while (!$input->eof()) {
    $bin = $input->fgets();
    for ($i = 0; $i < $bitsLength; $i++) {
        $bits[$i] += ($bin[$i] === '0') ? -1 : 1;
    }
}

$gamma = $epsilon = '';

foreach ($bits as $bit) {
    $gamma .= ($bit > 0) ? '1' : '0';
    $epsilon .= ($bit < 0) ? '1' : '0';
}

echo 'Part One : ' . (bindec($gamma) * bindec($epsilon)) . "\n";

######################
## --- PART TWO --- ##

$input->rewind();

######

function getRating($numbers, $index, $maxIndex, $bitCriteria) {
    $b0 = [];
    $b1 = [];
    $results = [];

    foreach ($numbers as $number) {
        if ($number[$index] === '0') $b0[] = $number;
        else $b1[] = $number;
    }

    if ($bitCriteria === 'most')
        $results = (count($b1) >= count($b0)) ? $b1 : $b0;
    else if ($bitCriteria === 'least')
        $results = (count($b0) <= count($b1)) ? $b0 : $b1;

    if (count($results) > 1) {
        $nextIndex = ($index >= $maxIndex) ? 0 : $index + 1;
        $results = getRating($results, $nextIndex, $maxIndex, $bitCriteria);
    }

    return $results;
}

$numbers = [];
while (!$input->eof())
    $numbers[] = $input->fgets();

######

$oxygen = bindec(getRating($numbers, 0, 11, 'most')[0]);
$co2 = bindec(getRating($numbers, 0, 11, 'least')[0]);

echo 'Part Two : ' . ($oxygen * $co2) . "\n";
