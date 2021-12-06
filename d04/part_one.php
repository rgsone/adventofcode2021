<?php

######################
## --- PART ONE --- ##

function buildBoards($input) {
    $i = 0;
    $boards = [];
    $board = [];

    while (!$input->eof()) {
        $line = $input->fgets();
        $lineMod = $i % 6;

        if ($lineMod < 5) {
            $lineNumbers = preg_split("/( )+/", trim($line));
            $board[] = [
                [$lineNumbers[0], 0],
                [$lineNumbers[1], 0],
                [$lineNumbers[2], 0],
                [$lineNumbers[3], 0],
                [$lineNumbers[4], 0]
            ];

            if ($lineMod == 4) {
                $boards[] = $board;
                $board = [];
            }
        }

        $i++;
    }

    return $boards;
}

$inputNumbersDrawn = new SplFileObject('input_numbers-drawn.txt');
$numbersDrawn = explode(',', $inputNumbersDrawn->fgets());
$inputNumbersDrawn = null;

$inputBoards = new SplFileObject('input_boards.txt');
$boards = buildBoards($inputBoards);
$boardsP2 = $boards;
$inputBoards = null;

function markBoards($numberDrawn, &$boards) {
    foreach ($boards as &$board) {
        foreach ($board as &$line) {
            foreach ($line as &$number) {
                if ($number[0] == $numberDrawn)
                    $number[1] = 1;
            }
        }
    }
}

function checkWinningBoard($boards) {
    $isWin = false;
    $boardId = -1;
    $boardsCount = count($boards);

    for ($i = 0; $i < $boardsCount; $i++) { 
        if (isRowCompleted($boards[$i]) || isColCompleted($boards[$i])) {
            $isWin = true;
            $boardId = $i;
            break;
        }
    }

    return [$isWin, $boardId];
}

function isRowCompleted($board) {
    $isRowComplete = false;
    $markedCount = 0;
    foreach ($board as $row) {
        foreach ($row as $number)
            $markedCount += $number[1];

        if ($markedCount >= 5) {
            $isRowComplete = true;
            break;
        }

        $markedCount = 0;
    }

    return $isRowComplete;
}

function isColCompleted($board) {
    $isColComplete = false;
    $markedCount = 0;

    for ($col = 0; $col < 5; $col++) { 
        foreach ($board as $row)
            $markedCount += $row[$col][1];
        
        if ($markedCount >= 5) {
            $isColComplete = true;
            break;
        }
        
        $markedCount = 0;
    }

    return $isColComplete;
}

function calculateScore($board, $winningNumber) {
    $sum = 0;

    foreach ($board as $row) {
        foreach ($row as $num) {
            if ($num[1] === 0) $sum += $num[0];
        }
    }

    return $winningNumber * $sum;
}

$score = 0;

foreach ($numbersDrawn as $num) {
    markBoards($num, $boards);
    [$isWinner, $winningBoardId] = checkWinningBoard($boards);
    if ($isWinner) {
        $score = calculateScore($boards[$winningBoardId], $num);
        break;
    }
}

echo "Part One : {$score} \n";
