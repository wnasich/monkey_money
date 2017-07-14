<?php
	$this->Form->templates(['error' => '{{content}}']);

	echo $this->Form->create($movement, ['novalidate' => true]);
	echo $this->Form->input('amount', [
		'label' => false,
		'id' => 'amount-' . $output,
		'type' => 'text',
		'prepend' => '$',
	]);
?>
<?php
echo $this->Html->tag('input', '', [
	'type' => 'hidden',
	'name' => 'movement_type_id',
	'value' => '',
]);
?>
<div class="form-group">
	<?php foreach ($movementTypes as $movementTypeId => $movementTypeName) { ?>
		<div class="checkbox checkbox-success">
		<?php
		$inputId = 'movement-type-id-' . $movementTypeId;
		echo $this->Html->tag('input', '', [
			'type' => 'radio',
			'id' => $inputId,
			'name' => 'movement_type_id',
			'value' => $movementTypeId,
			'autocomplete' => 'off',
		]);
		echo $this->Html->tag('label', $movementTypeName, ['for' => $inputId]);
		?>
		</div>
	<?php } ?>
	<?php
	if ($this->Form->isFieldError('movement_type_id')) {
		echo $this->Html->tag(
			'div',
			$this->Form->error('movement_type_id'),
			['class' => 'well well-sm text-danger']
		);
	}
	?>
</div>
<?= $this->Form->button(__('Save'), [
	'class' => 'btn-success js-stateful-button',
	'data-saving-text' => __('Saving ...'),
]) ?>
<?= $this->Form->end() ?>