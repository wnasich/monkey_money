<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title"><?= $movement->isNew() ? __('New movement') : __('Edit movement') ?></h3>
    </div>
    <div class="panel-body">
	<?= $this->Form->create($movement) ?>
    <?php
        echo $this->Form->input('movement_type_id', ['options' => $movementTypes]);
        echo $this->Form->input('amount');
    ?>
	<?= $this->Form->button(__('Submit')) ?>
	<?= $this->Form->end() ?>
	</div>
</div>
