<div class="row">
    <div class="col col-md-offset-3 col-md-6">
        <div class="panel panel-primary">
        <div class="panel-heading">
            <h3 class="panel-title"><?php echo __('Login'); ?></h3>
        </div>
        <div class="panel-body">
            <?php
            echo $this->Form->create('User', [
                'id' => 'LoginForm',
                'horizontal' => true,
                'columns' => [
                    'label' => 3,
                    'input' => 9,
                    'error' => 0,
                ]
            ]);
            ?>
            <?php echo $this->Form->input('username', [
                'label' => __('Username'),
                'beforeInput' => '<div class="input-group"><span class="input-group-addon">@</span>',
                'afterInput' => '</div>'
            ]); ?>
            <?php echo $this->Form->input('password', [
                'label' => __('Password'),
                'beforeInput' => '<div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>',
                'afterInput' => '</div>'
            ]); ?>

            <?php echo $this->Form->submit(__('Login'), [
                'class' => 'btn btn-success',
            ]); ?>

            <?php echo $this->Form->end(); ?>
        </div>
        </div>
    </div>
</div>
