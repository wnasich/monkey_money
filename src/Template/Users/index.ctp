<div class="page-header">
    <div class="actions pull-right">
        <?php echo $this->Html->link(
            __('New user'),
            ['action' => 'add'],
            ['class' => 'btn btn-sm btn-primary']
        ); ?>
    </div>
    <h2><?php echo __('Users'); ?></h2>
</div>

<table class="table table-hover table-striped">
    <thead>
        <tr>
            <th><?php echo $this->Paginator->sort('name', __('Name')); ?></th>
            <th><?php echo $this->Paginator->sort('username', __('User Name')); ?></th>
            <th><?php echo $this->Paginator->sort('role', __('Role')); ?></th>
            <th><?php echo $this->Paginator->sort('status', __('Status')); ?></th>
            <th style="width:260px;"></th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($users as $user): ?>
        <tr>
            <td><?php echo h($user->name); ?>&nbsp;</td>
            <td><?php echo h($user->username); ?>&nbsp;</td>
            <td><?php echo $user->roleName(); ?>&nbsp;</td>
            <td><?php echo $user->statusName(); ?>&nbsp;</td>
            <td class="text-right"><?php echo $this->element('Users/action_option', ['user' => $user]); ?></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
