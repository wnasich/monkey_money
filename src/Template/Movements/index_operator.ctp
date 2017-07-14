<?php if ($movements->count()) { ?>
    <table class="table table-hover table-striped table-condensed">
        <thead>
            <tr>
                <th><?= __('Created') ?></th>
                <th><?= __('Movement type') ?></th>
                <th class="text-right"><?= __('Amount') ?></th>
                <th><?= __('Created By') ?></th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($movements as $movement): ?>
            <tr>
                <td><?= $this->Time->format($movement->created) ?></td>
                <td><?= $movement->has('movement_type') ? $movement->movement_type->name : '' ?></td>
                <td class="text-right"><?= $this->Number->currency($movement->amount) ?></td>
                <td><?= $movement->has('created_by_user') ? $movement->created_by_user->name : '' ?></td>
                <td class="text-right"><?php echo $this->element('Movements/actions_operation', ['movement' => $movement]); ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php } else { ?>
    <div class="well well-sm text-center"><?= __('No movements') ?></div>
<?php } ?>