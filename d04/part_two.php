<?php

######################
## --- PART TWO --- ##

class Board
{
    protected $id;
    protected $input;
    protected $numbers;
    protected $numbersCount;
    protected $hasWin = false;

    public function __construct($id, $input)
    {
        $this->id = $id;
        $this->input = $input;
        $this->setup();
    }

    protected function setup()
    {
        $this->numbers = preg_split("/[\s]+/", trim($this->input));
        array_walk($this->numbers, function (&$item, $key) {
            $item = new BoardNumber($item);
        });
        $this->numbersCount = count($this->numbers);
    }

    protected function checkForCompleteRow()
    {
        if ($this->hasWin) return;

        $markedCount = 0;

        for ($i = 0; $i < $this->numbersCount; $i++) { 
            if ($this->numbers[$i]->isMarked) $markedCount++;

            if ($i % 5 === 4 && $markedCount >= 5) {
                $this->hasWin = true;
                break;
            } else if ($i % 5 === 4 && $markedCount < 5) {
                $markedCount = 0;
            }
        }
    }

    protected function checkForCompleteCol()
    {
        if ($this->hasWin) return;

        $markedCount = 0;

        for ($col = 0; $col < 5; $col++) { 
            for ($row = 0; $row < 5; $row++) { 
                $id = $row * 5 + $col;
                if ($this->numbers[$id]->isMarked) $markedCount++;
            }

            if ($markedCount >= 5) {
                $this->hasWin = true;
                break;
            }

            $markedCount = 0;
        }
    }

    public function markNumber($number)
    {
        if ($this->hasWin) return;

        foreach ($this->numbers as $num)
            if ($num->value == $number) $num->isMarked = true;
        
        $this->checkForCompleteRow();
        $this->checkForCompleteCol();
    }

    public function hasWin()
    {
        return $this->hasWin;
    }

    public function getUnmarkedSum()
    {
        $sum = 0;
        foreach ($this->numbers as $number)
            if (!$number->isMarked) $sum += (int)$number->value;
        return $sum;
    }
}

class BoardNumber
{
    public $value;
    public $isMarked;

    public function __construct($number, $isMarked = false)
    {
        $this->value = $number;
        $this->isMarked = $isMarked;
    }
}

$input = new SplFileObject('input.txt');
$inputArray = preg_split("/\r\n\r\n/", $input->fread($input->getSize()));
$input = null;
$numbers = explode(',', array_shift($inputArray));
$boards = [];

foreach ($inputArray as $key => $board)
    $boards[] = new Board($key, $board);

$score = 0;

foreach ($numbers as $number) {
    foreach ($boards as $board)
        $board->markNumber($number);
    
    if (count($boards) <= 1) {
        $score = $number * $boards[array_key_last($boards)]->getUnmarkedSum();
        break;
    }

    foreach ($boards as $key => $board)
        if ($board->hasWin()) unset($boards[$key]);
}

echo "Part Two : {$score} \n";
