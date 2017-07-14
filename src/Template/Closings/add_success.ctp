<div class="alert alert-success"><?= __('The closing has been saved.') ?></div>
<div class="alert alert-info">
	<?= __('Closing number:') ?> <span class="h3"><?= $closing->number ?></span>
</div>
<div class="well well-sm">
	<?= __('Closing amount:') ?> <?= $this->Number->currency($closing->closing_amount) ?>
</div>
<div class="well well-sm">
	<?= __('Change amount:') ?> <?= $this->Number->currency($closing->change_amount) ?>
</div>
