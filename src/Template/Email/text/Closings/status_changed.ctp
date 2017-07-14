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

<?= __('Modified') ?>: <?= $this->Time->format($closing->modified) ?>

<?= __('New status') ?>: <?= $closing->statusName() ?>

<?= __('Operator') ?>: <?= $operator ? $operator->name : '' ?>

<?= __('View closing') ?>: <?= $this->Url->build($viewClosingUrl, true) ?>
