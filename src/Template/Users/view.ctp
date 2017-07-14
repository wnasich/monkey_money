<h3><?= h($user->name) ?></h3>
<table class="table table-hover table-bordered">
    <tr>
        <th><?= __('Name') ?></th>
        <td><?= h($user->name) ?></td>
    </tr>
    <tr>
        <th><?= __('Username') ?></th>
        <td><?= h($user->username) ?></td>
    </tr>
    <tr>
        <th><?= __('Role') ?></th>
        <td><?= $user->roleName(); ?></td>
    </tr>
    <tr>
        <th><?= __('Email') ?></th>
        <td><?= $user->email; ?></td>
    </tr>
    <tr>
        <th><?= __('Alerts') ?></th>
        <td><?php foreach($user->alertsName() as $alertName) {
            echo ' ' . $this->Html->tag('span', $alertName, ['class' => 'label label-success']);
        } ?></td>
    </tr>
    <tr>
        <th><?= __('Status') ?></th>
        <td><?= $user->statusName(); ?></td>
    </tr>
    <tr>
        <th><?= __('Created') ?></th>
        <td><?= $this->Time->format($user->created) ?></td>
    </tr>
    <tr>
        <th><?= __('Updated') ?></th>
        <td><?= $this->Time->format($user->updated) ?></td>
    </tr>
</table>
