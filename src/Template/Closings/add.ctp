<?php
$billsDef = getBillsDefinitions();
$bills = $billsDef['bills'];
$changePackages = $billsDef['packages'];
?>
<?= $this->Form->create($closing) ?>
    <?= $this->Form->input('closing_amount', [
        'label' => __('Closing amount'),
        'type' => 'text',
        'help' => __('Amount to move out from cashier'),
        'prepend' => '$',
    ]) ?>
    <div class="checkbox checkbox-success">
        <?php
        echo $this->Html->tag('input', '', [
            'type' => 'hidden',
            'name' => 'allow_empty_amount',
            'value' => '',
        ]);
        $inputId = 'allow-empty-amount';
        echo $this->Html->tag('input', '', [
            'type' => 'checkbox',
            'id' => $inputId,
            'name' => 'allow_empty_amount',
            'value' => '1',
            'autocomplete' => 'off',
        ]);
        echo $this->Html->tag('label', __('Closing without money output'), ['for' => $inputId]);
        ?>
    </div>
    <div class="well well-sm"><small>Tildar para habilitar cierre sin salida de dinero</small></div>
    <hr />
    <div id="change-bills-box">
    <?= $this->Form->label('change_bills', __('Change bills')) ?>
    <p class="help-block"><?= __('Input quantity of each bill/coin') ?></p>
    <?php foreach($bills as $billCode => $billDef) { ?>
        <?= $this->Form->input('change_bills.' . $billCode, [
            'label' => false,
            'type' => 'number',
            'min' => 0,
            'step' => 1,
            'prepend' => $billDef['name'],
            'data-bill-code' => $billCode,
            'append' => $this->Html->image('closing_bills/' . $billDef['image'], ['class' => 'closing-bill']),
        ]) ?>
    <?php } ?>
    <?php if($changePackages) { ?>
        <hr />
        <p class="help-block"><?= __('Input quantity of change packages') ?></p>
        <div class="well well-sm"><small>Cantidades copiadas del cierre anterior. Verificar antes de guardar el cierre.</small></div>
        <?php foreach($changePackages as $billCode => $billDef) { ?>
            <?php
            $billCount = null;
            if ($lastClosing && isset($lastClosing->change_bills[$billCode])) {
                $billCount = $lastClosing->change_bills[$billCode];
            } else if (isset($closing->change_bills[$billCode])) {
                $billCount = $closing->change_bills[$billCode];
            }
            ?>
            <?= $this->Form->input('change_bills.' . $billCode, [
                'label' => false,
                'type' => 'number',
                'min' => 0,
                'step' => 1,
                'value' => $billCount,
                'prepend' => $billDef['name'],
                'data-bill-code' => $billCode,
                'append' => $this->Html->image('closing_bills/' . $billDef['image'], ['class' => 'closing-bill']),
            ]) ?>
        <?php } ?>
        </div>
    <?php } ?>
    <hr />
    <?= $this->Form->input('change_amount', [
        'label' => __('Change amount'),
        'help' => __('Amount remain in cashier'),
        'prepend' => '$',
        'readonly' => true,
    ]) ?>
    <hr />
<?= $this->Form->button(__('Save closing'), [
    'class' => 'btn-success js-ask-confirmation js-stateful-button',
    'data-message' => __('Are you sure you want to save closing?'),
    'data-saving-text' => __('Saving ...'),
]) ?>
<?= $this->Form->end() ?>
