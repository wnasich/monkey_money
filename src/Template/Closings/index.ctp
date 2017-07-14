<div class="page-header">
    <h2><?= __('Closings') ?></h2>
</div>

<table class="table table-hover table-striped">
    <thead>
        <tr>
            <th><?= $this->Paginator->sort('created', __('Created')); ?></th>
            <th class="text-right"><?= $this->Paginator->sort('number', __('Number')); ?></th>
            <th class="text-right"><?= __('Closing'); ?></th>
            <th class="text-right"><?= __('Change'); ?></th>
            <th class="text-right"><?= __('Estimated'); ?></th>
            <th><?= $this->Paginator->sort('created_by', __('Created by')); ?></th>
            <th><?= $this->Paginator->sort('modified_by', __('Modified by')); ?></th>
            <th><?php echo $this->Paginator->sort('status', __('Status')); ?></th>
            <th style="width:260px;"></th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($closings as $closing): ?>
        <tr>
            <td><?= $this->Time->format($closing->created) ?></td>
            <td class="text-right"><?= $closing->number ?></td>
            <td class="text-right"><?= $this->Number->currency($closing->closing_amount) ?></td>
            <td class="text-right"><?= $this->Number->currency($closing->change_amount) ?></td>
            <td class="text-right"><?= $this->Number->currency($closing->gross_input_amount) ?></td>
            <td><?= $closing->has('created_by_user') ? $closing->created_by_user->name : '' ?></td>
            <td><?= $closing->has('modified_by_user') ? $closing->modified_by_user->name : '' ?></td>
            <td><?= $closing->statusName() ?></td>
            <td class="text-right"><?php echo $this->element('Closings/action_option', ['closing' => $closing]); ?></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>

<?= $this->Paginator->numbers() ?>

<p><?= $this->Paginator->counter() ?></p>
