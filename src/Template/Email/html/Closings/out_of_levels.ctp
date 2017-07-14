<?php
$viewClosingUrl = [
	'_full' => true,
	'controller' => 'Closings',
	'action' => 'view',
	$closing->id,
];
if ($emailBaseUrl) {
	$viewClosingUrl['_host'] = $emailBaseUrl;
}
?>
<p><?= __('Number') ?>: <?= $closing->number ?></p>

<p><?= __('Created') ?>: <?= $this->Time->format($closing->created) ?></p>

<p><?= __('Change amount') ?>: <?= $this->Number->currency($closing->change_amount) ?></p>

<hr />
<table>
<thead>
	<tr>
		<th>&nbsp;</th>
		<th><?= __('Low') ?></th>
		<th>&nbsp;</th>
		<th><?= __('Current') ?></th>
		<th>&nbsp;</th>
		<th><?= __('High') ?></th>
	</tr>
</thead>
<tbody>
<?php
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
		$currentValueStyles = 'text-align: center; ';
		if ($closing->isBillLow($billCode)) {
			$lowIndicator = __('Low') . ' &rarr;';
			$currentValueStyles .= 'font-weight: bold; color: red; ';
		}
		$highIndicator = '';
		if ($closing->isBillHigh($billCode)) {
			$highIndicator = '&larr; ' . __('High');
			$currentValueStyles .= 'font-weight: bold; color: blue; ';
		}

		echo $this->Html->formatTemplate('tagstart', ['tag' => 'tr']);
		echo $this->Html->tag('td', $bills[$billCode]['name']);
		echo $this->Html->tag('td', $billDef['lowLevel'], ['style' => 'text-align: right;']);
		echo $this->Html->tag('td', $lowIndicator, ['style' => $currentValueStyles]);
		echo $this->Html->tag('td', $billCount, ['style' => $currentValueStyles]);
		echo $this->Html->tag('td', $highIndicator, ['style' => $currentValueStyles]);
		echo $this->Html->tag('td', $billDef['highLevel'], ['style' => 'text-align: right;']);
		echo $this->Html->formatTemplate('tagend', ['tag' => 'tr']);
		echo "\n";
	}
	echo $this->Html->formatTemplate('tagstart', ['tag' => 'tr']);
	echo $this->Html->tag('td', null, ['colspan' => 6]);
	echo $this->Html->formatTemplate('tagend', ['tag' => 'tr']);
}
?>
</tbody>
</table>
<hr />
<?= $this->Html->link(__('View closing'), $viewClosingUrl); ?>
