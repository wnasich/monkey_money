<?php
$linkOptions = [
	'class' => 'btn btn-xs btn-primary',
];
if (!empty($class)) {
	$label = '<span class="' . $class . '" aria-hidden="true"></span> ' . $label;
}
if (!empty($disabled)) {
	$linkOptions += ['disabled' => true];
}
$linkOptions += ['role' => 'button', 'escape' => false];

if (empty($postLink)) {
	echo $this->Html->link($label, $url, $linkOptions);
} else {
	$linkOptions['confirm'] = $confirmationMessage;
	echo $this->Form->postLink($label, $url, $linkOptions);
}
