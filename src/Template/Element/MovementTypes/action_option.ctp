<?php
$actions = [
	[
		'class' => 'glyphicon glyphicon-pencil',
		'label' =>  __('Edit'),
		'url' => ['action' => 'edit', $movementType->id],
	],
	[
		'class' => 'glyphicon glyphicon-remove',
		'label' => __('Delete'),
		'url' => ['action' => 'delete', $movementType->id],
		'postLink' => true,
		'confirmationMessage' => __('Are you sure you want to delete "{0}" ?', $movementType->name),
	]
];

echo $this->element('actions_menu', ['actions' => $actions]);
