<?php
$actions = [];
if ($currentUser->isAdmin()) {
	$actions[] = [
		'class' => 'glyphicon glyphicon-pencil',
		'label' =>  __('Edit'),
		'url' => ['controller' => 'Movements', 'action' => 'edit', $movement->id],
	];
}
$actions[] = [
	'class' => 'glyphicon glyphicon-remove',
	'label' => __('Delete'),
	'url' => ['controller' => 'Movements', 'action' => 'delete', $movement->id],
	'postLink' => true,
	'confirmationMessage' => __('Are you sure you want to delete movement of $ {0} ?', $movement->amount),
];

echo $this->element('actions_menu', ['actions' => $actions]);
