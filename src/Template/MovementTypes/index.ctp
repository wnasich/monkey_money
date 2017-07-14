<div class="page-header">
    <div class="actions pull-right">
        <?= $this->Html->link(
            __('New movement type'),
            ['action' => 'add'],
            ['class' => 'btn btn-sm btn-primary']
        ) ?>
    </div>
    <h2><?= __('Movement types') ?></h2>
</div>

<table class="table table-hover table-striped">
    <thead>
        <tr>
            <th><?php echo $this->Paginator->sort('name', __('Name')); ?></th>
            <th><?php echo $this->Paginator->sort('output', __('Output')); ?></th>
            <th><?php echo $this->Paginator->sort('view_public', __('View public')); ?></th>
            <th style="width:260px;"></th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($movementTypes as $movementType): ?>
        <tr>
            <td><?= h($movementType->name) ?>&nbsp;</td>
            <td><?= $movementType->outputName(); ?>&nbsp;</td>
            <td><?= $movementType->viewPublicName(); ?>&nbsp;</td>
            <td class="text-right"><?php echo $this->element('MovementTypes/action_option', ['movementType' => $movementType]); ?></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
