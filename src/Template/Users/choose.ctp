<br/>
<br/>
<br/>

<div class="row">
    <div class="col col-sm-6 col-sm-offset-3 text-center">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><?= __('Login') ?></h3>
            </div>
            <div class="panel-body">

                <?php
                $count = 0;
                $rowOfButtons = [];
                $currentRow = '';
                foreach ($users as $user) {
                    if ($count % 4 == 0 && $currentRow) {
                        $rowOfButtons[] = $currentRow;
                        $currentRow = '';
                    }
                    $currentRow .= $this->Html->link($user->name, [
                        'controller' => 'Users',
                        'action' => 'loginOperator',
                        $user->username,
                    ], [
                        'class' => 'btn btn-default',
                        'role' => 'button',
                    ]) . ' ';
                    $count++;
                }
                $rowOfButtons[] = $currentRow;
                ?>
                <p>
                    <?=  join('</p> <p>', $rowOfButtons) ?>
                </p>
            </div>
        </div>

        <br/>
        <br/>
        <br/>
        <br/>
        <br/>
        <br/>
        <br/>
        <br/>
        <br/>
        <br/>
        <br/>
        <br/>
        <br/>
        <br/>

        <div class="well well-sm text-center"><?php echo $this->Html->link(__('Login'),
            ['controller' => 'users', 'action' => 'login']
        ); ?></div>

    </div>
</div>