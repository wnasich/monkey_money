<h3><?= __('Closing: {0}', $closing->number) ?></h3>
<table class="table table-hover table-bordered" id="closing-view-table">
    <tr>
        <th><?= __('Number') ?></th>
        <td><?= h($closing->number) ?></td>
    </tr>
    <tr>
        <th><?= __('Closing Amount') ?></th>
        <td><?= $this->Number->currency($closing->closing_amount) ?></td>
    </tr>
    <tr>
        <th><?= __('Change Amount') ?></th>
        <td><?= $this->Number->currency($closing->change_amount) ?></td>
    </tr>
    <tr>
        <th><?= __('Change bills') ?></th>
        <td>
            <?= $this->element('Closings/change_details', ['closing' => $closing]) ?>
        </td>
    </tr>
    <tr>
        <th><?= __('Created') ?></th>
        <td><?= h($closing->created) ?></td>
    </tr>
    <tr>
        <th><?= __('Modified') ?></th>
        <td><?= h($closing->modified) ?></td>
    </tr>
        <tr>
        <th><?= __('Created By User') ?></th>
        <td><?= $closing->has('created_by_user') ? $this->Html->link($closing->created_by_user->name, ['controller' => 'Users', 'action' => 'view', $closing->created_by_user->id]) : '' ?></td>
    </tr>
    <tr>
        <th><?= __('Modified By User') ?></th>
        <td><?= $closing->has('modified_by_user') ? $this->Html->link($closing->modified_by_user->name, ['controller' => 'Users', 'action' => 'view', $closing->modified_by_user->id]) : '' ?></td>
    </tr>
</table>