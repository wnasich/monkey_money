<div class="page-header">
    <h2><?= __('Movement') ?></h2>
</div>
<table class="table table-hover table-striped">
    <thead>
        <tr>
            <th><?= $this->Paginator->sort('created', __('Created')); ?></th>
            <th><?= $this->Paginator->sort('movement_type_id', __('Movement type')); ?></th>
            <th class="text-right"><?= __('Amount') ?></th>
            <th><?= __('Created By') ?></th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($movements as $movement): ?>
        <tr>
            <td><?= $this->Time->nice($movement->created) ?></td>
            <td><?= $movement->has('movement_type') ? $movement->movement_type->name : '' ?></td>
            <td class="text-right"><?= $this->Number->currency($movement->amount) ?></td>
            <td><?= $movement->has('created_by_user') ? $movement->created_by_user->name : '' ?></td>
            <td class="text-right"><?php echo $this->element('Movements/action_option', ['movement' => $movement]); ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?= $this->Paginator->numbers() ?>
<p><?= $this->Paginator->counter() ?></p>
