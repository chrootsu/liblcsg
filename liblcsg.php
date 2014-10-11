<?php namespace liblcsg;

function initNumPool()
{
	return array_map(function ($r) {
		$numbers = range($r[0], $r[1]);
		shuffle($numbers);
		return $numbers;
	}, array(
		array(1, 9), array(10, 19), array(20, 29), array(30, 39), array(40, 49),
		array(50, 59), array(60, 69), array(70, 79), array(80, 90)
	));
}

function generateColMask($colNum, $maskCount, &$colMask, &$rowState)
{
	for ($rowStateValue = 0; $rowStateValue < 3; $rowStateValue++) {
		$rowsSplit[$rowStateValue] = array_filter(range(0, 5), function ($row) use ($rowState, $rowStateValue) {
			return $rowState[$row] == $rowStateValue;
		});
		shuffle($rowsSplit[$rowStateValue]);
	}

	$rows = array_merge($rowsSplit[2], $rowsSplit[1], $rowsSplit[0]);

	for ($num = 0; $num < $maskCount; $num++) {
		$row = array_pop($rows);
		$colMask[$colNum][$row] = 1;
		$rowState[$row]++;
	}
}

function initColMask()
{
	$colMask = array_fill(0, 9, array_fill(0, 6, 0));
	$rowState = array_fill(0, 6, 0);

	generateColMask(0, 3, $colMask, $rowState);
	for ($colNum = 1; $colNum < 8; $colNum++) {
		generateColMask($colNum, 2, $colMask, $rowState);
	}
	generateColMask(8, 1, $colMask, $rowState);

	return $colMask;
}

function generateCard(&$numPool, &$colMask)
{
	$card = array_fill(0, 3, array_fill(0, 9, 0));

	$colState = array_fill(0, 9, 0);
	for ($colNum = 0; $colNum < 9; $colNum++) {
		$colState[$colNum] += array_pop($colMask[$colNum]);
	}

	for ($row = 0; $row < 3; $row++) {
		for ($colStateValue = 0; $colStateValue < 2; $colStateValue++) {
			$colsSplit[$colStateValue] = array_filter(range(0, 8), function ($col) use ($colState, $colStateValue) {
				return $colState[$col] == $colStateValue;
			});
			shuffle($colsSplit[$colStateValue]);
		}

		$cols = array_merge($colsSplit[1], $colsSplit[0]);

		for ($num = 0; $num < 5; $num++) {
			$col = array_pop($cols);
			$card[$row][$col] = array_pop($numPool[$col]);
			$colState[$col]++;
		}
	}

	return $card;
}

function createCardSet()
{
	$cards = array();
	$numPool = initNumPool();
	$colMask = initColMask();

	for ($cardNum = 0; $cardNum < 6; $cardNum++) {
		$cards[$cardNum] = generateCard($numPool, $colMask);
	}

	return $cards;
}
