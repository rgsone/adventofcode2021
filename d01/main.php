<?php

##===========================##
#---- Advent Of Code 2021 ----#
##---        Day 01       ---##
###=========================###

$input = new SplFileObject('input.txt');

######################
## --- PART ONE --- ##

$prev = (int)$input->fgets();
$current = 0;
$total = 0;

while (!$input->eof()) {
    $current = (int)$input->fgets();
    if ($current > $prev) $total++;
    $prev = $current;
}

echo 'PART ONE : ' . $total . "\n";

######################
## --- PART TWO --- ##

$input->rewind();

$line1 = (int)$input->fgets();
$line2 = (int)$input->fgets();
$line3 = (int)$input->fgets();
$prev = $line1 + $line2 + $line3;
$current = 0;
$total = 0;

while (!$input->eof()) {
    $line1 = $line2;
    $line2 = $line3;
    $line3 = (int)$input->fgets();
    $current = $line1 + $line2 + $line3;
    if ($current > $prev) $total++;
    $prev = $current;
}

echo 'PART TWO : ' . $total . "\n";
