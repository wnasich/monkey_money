<?php
$type = $output ? __('output') : __('input');
?>
<div class="alert alert-success"><?= __('The {type} movement has been saved.', ['type' => $type]) ?></div>
<?= $this->Html->link(
	__('New movement'),
	['action' => 'add', $output],
	['class' => 'btn btn-default js-load-ajax-content']
) ?>
