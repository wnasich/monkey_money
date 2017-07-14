<?php
use App\Model\Entity\Closing;

$actions = [
	[
		'class' => 'glyphicon glyphicon-info-sign',
		'label' =>  __('View'),
		'url' => ['action' => 'view', $closing->id],
	],
	[
		'class' => 'glyphicon glyphicon-trash',
		'label' =>  __('Remove'),
		'url' => ['action' => 'changeStatus', $closing->id, Closing::STATUS_REMOVED],
	],
	[
		'class' => 'glyphicon glyphicon-ok',
		'label' =>  __('Verified'),
		'url' => ['action' => 'changeStatus', $closing->id, Closing::STATUS_VERIFIED],
	],
];

echo $this->element('actions_menu', ['actions' => $actions]);
