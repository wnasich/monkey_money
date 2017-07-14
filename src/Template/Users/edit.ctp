<?php
use App\Model\Entity\User;
?>

<?= $this->Form->create($user) ?>
<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title"><?= $user->isNew() ? __('New user') : __('Edit user') ?></h3>
    </div>
    <div class="panel-body">
    <?php
        echo $this->Form->input('name');
        echo $this->Form->input('username');
        echo $this->Form->input('password', ['value' => '']);
        echo $this->Form->input('role', [
            'options' => $userRoles,
            'empty' => __('-- Pick a role --'),
            'default' => User::ROLE_OPERATOR,
        ]);
        echo $this->Form->input('email');
        echo $this->Html->tag(
            'div',
            $this->Html->tag(
                'div',
                $this->Form->input('alerts', [
                    'options' => $userAlerts,
                    'multiple' => true,
                ]),
                ['class' => 'panel-body']
            ),
            ['class' => 'panel panel-default']
        );
        echo $this->Form->input('status', [
            'options' => $userStatus,
            'empty' => __('-- Pick an status --'),
            'default' => User::STATUS_ENABLED,
        ]);
    ?>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
    </div>
</div>
