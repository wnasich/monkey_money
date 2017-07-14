<?php
$viewClosingUrl = [
	'controller' => 'Closings',
	'action' => 'view',
	$closing->id,
];
if ($emailBaseUrl) {
	$viewClosingUrl['_host'] = $emailBaseUrl;
}
?>

<?= __('Number') ?>: <?= $closing->number ?>

<?= __('Created') ?>: <?= $this->Time->format($closing->created) ?>

<?= __('Change amount') ?>: <?= $this->Number->currency($closing->change_amount) ?>


<?php
$colPads = [14, 5, 8, 5, 8, 5];

echo str_pad('', $colPads[0], ' ', STR_PAD_RIGHT);
echo str_pad(__('Low'), $colPads[1], ' ', STR_PAD_RIGHT);
echo str_pad('', $colPads[2], ' ', STR_PAD_RIGHT);
echo str_pad(__('Current'), $colPads[3], ' ', STR_PAD_RIGHT);
echo str_pad('', $colPads[4], ' ', STR_PAD_RIGHT);
echo str_pad(__('High'), $colPads[5], ' ', STR_PAD_RIGHT);
echo "\n";

$billTypes = ['bill', 'package'];
foreach (['bill', 'package'] as $billType) {
	foreach ($bills as $billCode => $billDef) {
		if (
			($billType === 'bill' && $closing->billCodeIsPackage($billCode)) ||
			($billType === 'package' && !$closing->billCodeIsPackage($billCode))
		) {
			continue;
		}

		$billCount = 0;
		if (isset($closing->change_bills[$billCode])) {
			$billCount = $closing->change_bills[$billCode];
		}
		$lowIndicator = '';
		if ($closing->isBillLow($billCode)) {
			$lowIndicator = __('Low') . '->';
		}
		$highIndicator = '';
		if ($closing->isBillHigh($billCode)) {
			$highIndicator = '<-' . __('High');
		}

		echo str_pad('  ' . $bills[$billCode]['name'], $colPads[0], ' ', STR_PAD_RIGHT);
		echo str_pad($billDef['lowLevel'], $colPads[1], ' ', STR_PAD_LEFT);
		echo str_pad($lowIndicator, $colPads[2], ' ', STR_PAD_LEFT);
		echo str_pad($billCount, $colPads[3], ' ', STR_PAD_LEFT);
		echo str_pad($highIndicator, $colPads[4], ' ', STR_PAD_BOTH);
		echo str_pad($billDef['highLevel'], $colPads[5], ' ', STR_PAD_LEFT);
		echo "\n";
	}
	echo "\n";
}
echo "\n";
echo "\n";

echo __('View closing') . ": \n" .$this->Url->build($viewClosingUrl, true);
