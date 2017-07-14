<?php
$actions = [
	[
		'class' => 'glyphicon glyphicon-info-sign',
		'label' =>  __('View'),
		'url' => ['action' => 'view', $user->id],
	],
	[
		'class' => 'glyphicon glyphicon-pencil',
		'label' =>  __('Edit'),
		'url' => ['action' => 'edit', $user->id],
	],
	[
		'class' => 'glyphicon glyphicon-remove',
		'label' => __('Delete'),
		'url' => ['action' => 'delete', $user->id],
		'postLink' => true,
		'confirmationMessage' => __('Are you sure you want to delete "{0}" ?', $user->name),
	]
];

echo $this->element('actions_menu', ['actions' => $actions]);
