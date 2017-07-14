<?php
$viewClosingUrl = [
	'_full' => true,
	'controller' => 'Closings',
	'action' => 'view',
	$closingCurrent->id,
];
if ($emailBaseUrl) {
	$viewClosingUrl['_host'] = $emailBaseUrl;
}
?>

<hr />
<table>
<thead>
	<tr>
		<th>&nbsp;</th>
		<th><?= __('Previous closing') ?></th>
		<th>&nbsp;</th>
		<th><?= __('Current closing') ?></th>
	</tr>
</thead>
<tbody>

<?php
echo $this->Html->formatTemplate('tagstart', ['tag' => 'tr']);
echo $this->Html->tag('td', __('Number'));
echo $this->Html->tag('td', $closingPrevious->number, ['style' => 'text-align: right;']);
echo $this->Html->tag('td', '');
echo $this->Html->tag('td', $closingCurrent->number, ['style' => 'text-align: right;']);
echo $this->Html->formatTemplate('tagend', ['tag' => 'tr']);

echo $this->Html->formatTemplate('tagstart', ['tag' => 'tr']);
echo $this->Html->tag('td', __('Operator'));
echo $this->Html->tag('td', $operatorPrevious->name);
echo $this->Html->tag('td', '');
echo $this->Html->tag('td', $operatorCurrent->name);
echo $this->Html->formatTemplate('tagend', ['tag' => 'tr']);

echo $this->Html->formatTemplate('tagstart', ['tag' => 'tr']);
echo $this->Html->tag('td', __('Created'));
echo $this->Html->tag('td', $this->Time->format($closingPrevious->created));
echo $this->Html->tag('td', '');
echo $this->Html->tag('td', $this->Time->format($closingCurrent->created));
echo $this->Html->formatTemplate('tagend', ['tag' => 'tr']);

echo $this->Html->formatTemplate('tagstart', ['tag' => 'tr']);
echo $this->Html->tag('td', __('Total'));
echo $this->Html->tag('td', $this->Number->currency($closingPrevious->change_amount), ['style' => 'text-align: right;']);
echo $this->Html->tag('td', '');
echo $this->Html->tag('td', $this->Number->currency($closingCurrent->change_amount), ['style' => 'text-align: right;']);
echo $this->Html->formatTemplate('tagend', ['tag' => 'tr']);

echo $this->Html->formatTemplate('tagstart', ['tag' => 'tr']);
echo $this->Html->tag('td', null, ['colspan' => 4]);
echo $this->Html->formatTemplate('tagend', ['tag' => 'tr']);
echo "\n";
?>

<?php
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
		$colorStyle = '';
		if ($closingCurrent->billCodeIsPackage($billCode) && $changeBillPrevious <> $changeBillCurrent) {
			$changedMark = ' &rarr; ';
			if ($changeBillPrevious > $changeBillCurrent) {
				$colorStyle = 'font-weight: bold; color: red; ';
			} else {
				$colorStyle = 'font-weight: bold; color: blue; ';
			}
		}

		echo $this->Html->formatTemplate('tagstart', ['tag' => 'tr']);
		echo $this->Html->tag('td', $bills[$billCode]['name']);
		echo $this->Html->tag('td', $changeBillPrevious, ['style' => 'text-align: right; ' . $colorStyle]);
		echo $this->Html->tag('td', $changedMark);
		echo $this->Html->tag('td', $changeBillCurrent, ['style' => 'text-align: left; ' . $colorStyle]);
		echo $this->Html->formatTemplate('tagend', ['tag' => 'tr']);
		echo "\n";
	}
	echo $this->Html->formatTemplate('tagstart', ['tag' => 'tr']);
	echo $this->Html->tag('td', null, ['colspan' => 4]);
	echo $this->Html->formatTemplate('tagend', ['tag' => 'tr']);
}
?>
</tbody>
</table>
<hr />
<?= $this->Html->link(__('View closing'), $viewClosingUrl); ?>
