<?php
$this->Html->script([
    'view/closings/change_status.js',
], ['block' => true]);

$this->Form->templates([
    'radioWrapper' => '<div class="checkbox checkbox-success">{{label}}</div>',
    'nestingLabel' => '{{hidden}}{{input}}<label{{attrs}}>{{text}}</label>',
]);
?>
<div class="row">

    <div class="col col-md-8">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><?= __('Closing') ?></h3>
            </div>
            <div class="panel-body">
                <?= $this->Html->tag('div', '', [
                    'id' => 'current-closing-container',
                    'class' => 'js-content-by-ajax',
                    'data-content-url' => $this->Url->build(['controller' => 'Closings', 'action' => 'view', $closing->id]),
                ]) ?>
            </div>
        </div>
    </div>

    <div class="col col-md-4">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><?= __('Change status') ?></h3>
            </div>
            <div class="panel-body">
            <?= $this->Form->create($closing) ?>
            <?= $this->Form->input('status', [
                'type' => 'radio',
                'options' => $closingStatus,
            ]) ?>
            <?= $this->Form->submit(__('Save')) ?>
            <?= $this->Form->end() ?>
            </div>
        </div>
    </div>
</div>
