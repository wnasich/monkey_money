<?php
$viewClosingUrl = [
	'controller' => 'Closings',
	'action' => 'view',
	$closingCurrent->id,
];
if ($emailBaseUrl) {
	$viewClosingUrl['_host'] = $emailBaseUrl;
}
?>

<?php
$colPads = [12, 15, 5, 15];

echo str_pad('', $colPads[0], ' ', STR_PAD_RIGHT);
echo str_pad(__('Previous closing'), $colPads[1], ' ', STR_PAD_RIGHT);
echo str_pad('', $colPads[2], ' ', STR_PAD_RIGHT);
echo str_pad(__('Current closing'), $colPads[3], ' ', STR_PAD_RIGHT);
echo "\n";

echo str_pad(__('Number'), $colPads[0], ' ', STR_PAD_RIGHT) . ' ';
echo str_pad($closingPrevious->number, $colPads[1], ' ', STR_PAD_RIGHT);
echo str_pad('', $colPads[2], ' ', STR_PAD_RIGHT);
echo str_pad($closingCurrent->number, $colPads[3], ' ', STR_PAD_RIGHT);
echo "\n";

echo str_pad(__('Operator'), $colPads[0], ' ', STR_PAD_RIGHT);
echo str_pad($operatorPrevious->name, $colPads[1], ' ', STR_PAD_RIGHT);
echo str_pad('', $colPads[2], ' ', STR_PAD_RIGHT);
echo str_pad($operatorCurrent->name, $colPads[3], ' ', STR_PAD_RIGHT);
echo "\n";

echo str_pad(__('Created'), $colPads[0], ' ', STR_PAD_RIGHT);
echo str_pad($this->Time->format($closingPrevious->created), $colPads[1], ' ', STR_PAD_RIGHT);
echo str_pad('', $colPads[2], ' ', STR_PAD_RIGHT);
echo str_pad($this->Time->format($closingCurrent->created), $colPads[3], ' ', STR_PAD_RIGHT);
echo "\n";

echo str_pad(__('Total'), $colPads[0], ' ', STR_PAD_RIGHT);
echo str_pad($this->Number->currency($closingPrevious->change_amount), $colPads[1], ' ', STR_PAD_RIGHT);
echo str_pad('', $colPads[2], ' ', STR_PAD_RIGHT);
echo str_pad($this->Number->currency($closingCurrent->change_amount), $colPads[3], ' ', STR_PAD_RIGHT);
echo "\n";
echo "\n";

$billsMerged = $closingPrevious->change_bills + $closingCurrent->change_bills;
$billTypes = ['bill', 'package'];
foreach (['bill', 'package'] as $billType) {
	foreach ($billsMerged as $billCode => $billCount) {
		if (
			($billType === 'bill' && $closingCurrent->billCodeIsPackage($billCode)) ||
			($billType === 'package' && !$closingCurrent->billCodeIsPackage($billCode))
		) {
			continue;
		}

		$changeBillPrevious = '';
		if (isset($closingPrevious->change_bills[$billCode])) {
			$changeBillPrevious = $closingPrevious->change_bills[$billCode];
		}
		$changeBillCurrent = '';
		if (isset($closingCurrent->change_bills[$billCode])) {
			$changeBillCurrent = $closingCurrent->change_bills[$billCode];
		}
		$changedMark = '';
		if ($closingCurrent->billCodeIsPackage($billCode) && $changeBillPrevious <> $changeBillCurrent) {
			$changedMark = ' --> ';
		}
		echo str_pad('   ' . $bills[$billCode]['name'], $colPads[0], ' ', STR_PAD_RIGHT);
		echo str_pad($changeBillPrevious, $colPads[1], ' ', STR_PAD_LEFT);
		echo str_pad($changedMark, $colPads[2], ' ', STR_PAD_RIGHT);
		echo str_pad($changeBillCurrent, $colPads[3], ' ', STR_PAD_RIGHT);
		echo "\n";
	}
	echo "\n";
}
echo "\n";
echo "\n";

echo __('View closing') . ": \n" .$this->Url->build($viewClosingUrl, true);
