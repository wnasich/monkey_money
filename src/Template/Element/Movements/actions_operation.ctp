<?php
$actions = [];

$actions[] = [
	'class' => 'glyphicon glyphicon-remove',
	'label' => '',
	'url' => ['controller' => 'Movements', 'action' => 'delete', $movement->id],
	'postLink' => true,
	'confirmationMessage' => __('Are you sure you want to delete movement of $ {0} ?', $movement->amount),
];

echo $this->element('actions_menu', ['actions' => $actions]);
