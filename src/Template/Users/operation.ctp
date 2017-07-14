<?php
$billsDef = getBillsDefinitions();
$bills = $billsDef['bills'] + $billsDef['packages'];

$billRatios = [];
foreach ($bills as $code => $bill) {
    $billRatios[$code] = $bill['ratio'];
}

$this->Html->scriptBlock('
    var billRatios = ' . json_encode($billRatios) . ';
', ['block' => true]);

$this->Html->script([
    'view/users/operation.js',
    'view/calc.js',
], ['block' => true]);
?>
<div class="row">

    <div class="col col-sm-5">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><?= __('Current movements') ?></h3>
            </div>
            <div class="panel-body">
                <?= $this->Html->tag('div', '', [
                    'id' => 'current-movements-container',
                    'class' => 'js-content-by-ajax',
                    'data-content-url' => $this->Url->build(['controller' => 'Movements', 'action' => 'indexOperator']),
                ]) ?>
            </div>
        </div>

        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><?= __('Change left on last closing') ?></h3>
            </div>
            <div class="panel-body" id="closing-change-details">
                <?= $this->element('Closings/change_details', ['closing' => $lastClosing]) ?>
            </div>
        </div>

    </div>

    <div class="col col-sm-4">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><?= __('New movement') ?></h3>
            </div>
            <div class="panel-body" id="new-movement-panel-body">

                <div class="panel-group" id="new-movement-accordion" role="tablist" aria-multiselectable="true">

                    <div class="panel panel-default">
                        <div class="panel-heading" role="tab" id="header-new-output-movement">
                            <h4 class="panel-title">
                                <a role="button" data-toggle="collapse" data-parent="#new-movement-accordion" href="#collapse-new-output-movement" aria-expanded="true" aria-controls="collapse-new-output-movement">
                                    <span class="glyphicon glyphicon-log-out" aria-hidden="true"></span> <?= __('Output') ?>
                                </a>
                            </h4>
                        </div>
                        <div id="collapse-new-output-movement" class="panel-collapse collapse" role="tabpanel" aria-labelledby="header-new-output-movement">
                            <div class="panel-body">
                                <?= $this->Html->tag('div', '', [
                                    'id' => 'new-output-movement-container',
                                    'class' => 'js-content-by-ajax',
                                    'data-content-url' => $this->Url->build(['controller' => 'Movements', 'action' => 'add', '1']),
                                ]) ?>
                            </div>
                        </div>
                    </div>

                    <div class="panel panel-default">
                        <div class="panel-heading" role="tab" id="header-new-input-movement">
                            <h4 class="panel-title">
                                <a role="button" data-toggle="collapse" data-parent="#new-movement-accordion" href="#collapse-new-input-movement" aria-expanded="true" aria-controls="collapse-new-input-movement">
                                    <span class="glyphicon glyphicon-log-in" aria-hidden="true"></span> <?= __('Input') ?>
                                </a>
                            </h4>
                        </div>
                        <div id="collapse-new-input-movement" class="panel-collapse collapse" role="tabpanel" aria-labelledby="header-new-input-movement">
                            <div class="panel-body">
                                <?= $this->Html->tag('div', '', [
                                    'id' => 'new-input-movement-container',
                                    'class' => 'js-content-by-ajax',
                                    'data-content-url' => $this->Url->build(['controller' => 'Movements', 'action' => 'add', '0']),
                                ]) ?>
                            </div>
                        </div>
                    </div>

                   <div class="panel panel-default">
                        <div class="panel-heading" role="tab" id="header-new-closing">
                            <h4 class="panel-title">
                                <a role="button" data-toggle="collapse" data-parent="#new-movement-accordion" href="#collapse-new-closing" aria-expanded="true" aria-controls="collapse-new-closing">
                                    <span class="glyphicon glyphicon-time" aria-hidden="true"></span> <?= __('Closing') ?>
                                </a>
                            </h4>
                        </div>
                        <div id="collapse-new-closing" class="panel-collapse collapse" role="tabpanel" aria-labelledby="header-new-closing">
                            <div class="panel-body">
                                <?= $this->Html->tag('div', '', [
                                    'id' => 'new-closing-container',
                                    'class' => 'js-content-by-ajax',
                                    'data-content-url' => $this->Url->build(['controller' => 'Closings', 'action' => 'add']),
                                ]) ?>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <div class="col col-sm-3">
        <?= $this->element('calc_board') ?>
    </div>

</div>
