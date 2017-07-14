<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title"><?= $movementType->isNew() ? __('New movement type') : __('Edit movement type') ?></h3>
    </div>
    <div class="panel-body">
	<?= $this->Form->create($movementType) ?>
    <?php
        echo $this->Form->input('name');
        echo $this->Form->input('output', ['options' => $movementTypeOutputs]);
        echo $this->Form->input('view_public', ['options' => $movementTypeViewPublics]);
    ?>
	<?= $this->Form->button(__('Submit')) ?>
	<?= $this->Form->end() ?>
	</div>
</div>
