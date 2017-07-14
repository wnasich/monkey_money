<?php
use App\Model\Entity\Closing;

$changeStatusUrl = [
	'controller' => 'Closings',
	'action' => 'changeStatus',
	$closing->id,
	Closing::STATUS_VERIFIED
];

if ($emailBaseUrl) {
	$changeStatusUrl['_host'] = $emailBaseUrl;
}
?>

<?= __('Operator') ?>: <?= $operator ? $operator->name : '' ?>

<?= __('Number') ?>: <?= $closing->number ?>

<?= __('Created') ?>: <?= $this->Time->format($closing->created) ?>


<?= __('Closing amount') ?>: <?= $this->Number->currency($closing->closing_amount) ?>

<?= __('Estimated sales') ?>: <?= $this->Number->currency($closing->gross_input_amount) ?>


<?= __('Change amount') ?>: <?= $this->Number->currency($closing->change_amount) ?>

<?= __('Change bills') ?>:

	<?php
	$amountPackages = 0;
	$amountNoPackages = 0;
	foreach ($closing->change_bills as $billCode => $billCount) {
		if (!$billCount) {
			continue;
		}
		$billAmount = $billCount * $bills[$billCode]['ratio'];
		if ($closing->billCodeIsPackage($billCode)) {
			$amountPackages += $billAmount;
		} else {
			$amountNoPackages += $billAmount;
		}
		?>
		<?= str_pad($billCount, 3, ' ', STR_PAD_LEFT) ?>  x  <?= $bills[$billCode]['name'] ?>

	<?php } ?>


<?= __('Available change amount') ?>: <?= $this->Number->currency($amountNoPackages) ?>

<?= __('Packaged change amount') ?>: <?= $this->Number->currency($amountPackages) ?>


<?= __('Movements') ?>:

<?php
	echo str_pad(__('Movement type'), 20, ' ', STR_PAD_RIGHT);
	echo str_pad(__('Date/Time'), 20, ' ', STR_PAD_RIGHT);
	echo str_pad(__('Output?'), 8, ' ', STR_PAD_RIGHT);
	echo str_pad(__('Amount'), 10, ' ', STR_PAD_LEFT);
	echo "\n";
	foreach ($movements as $movement) {
		echo str_pad($movement->movement_type->name, 20, ' ', STR_PAD_RIGHT);
		echo str_pad($this->Time->format($movement->created), 20, ' ', STR_PAD_RIGHT);
		echo str_pad($movement->movement_type->outputName(), 8, ' ', STR_PAD_RIGHT);
		echo str_pad($this->Number->currency($movement->amount), 10, ' ', STR_PAD_LEFT);
		echo "\n";
	}
?>


<?= __('Mark as verified') ?>: <?= $this->Url->build($changeStatusUrl, true) ?>
