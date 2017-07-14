<div class="well" data-spy="affix">
<div id="calc-board">
    <div class="row-fluid">
        <?= $this->Form->button('', ['class' => 'btn btn-default', 'type' => 'button', 'disabled' => 'disabled']) ?>
        <?= $this->Form->button(
            '<span class="glyphicon glyphicon-chevron-up"></span>',
            ['class' => 'btn btn-success', 'type' => 'button', 'data-method' => 'pageUp']
        ) ?>
        <?= $this->Form->button(
            '<span class="glyphicon glyphicon-chevron-down"></span>',
            ['class' => 'btn btn-success', 'type' => 'button', 'data-method' => 'pageDown']
        ) ?>
    </div>
    <div class="row-fluid">
        <?= $this->Form->button('7', ['class' => 'btn btn-default', 'type' => 'button']) ?>
        <?= $this->Form->button('8', ['class' => 'btn btn-default', 'type' => 'button']) ?>
        <?= $this->Form->button('9', ['class' => 'btn btn-default', 'type' => 'button']) ?>
    </div>
    <div class="row-fluid">
        <?= $this->Form->button('4', ['class' => 'btn btn-default', 'type' => 'button']) ?>
        <?= $this->Form->button('5', ['class' => 'btn btn-default', 'type' => 'button']) ?>
        <?= $this->Form->button('6', ['class' => 'btn btn-default', 'type' => 'button']) ?>
    </div>
    <div class="row-fluid">
        <?= $this->Form->button('1', ['class' => 'btn btn-default', 'type' => 'button']) ?>
        <?= $this->Form->button('2', ['class' => 'btn btn-default', 'type' => 'button']) ?>
        <?= $this->Form->button('3', ['class' => 'btn btn-default', 'type' => 'button']) ?>
    </div>
    <div class="row-fluid">
        <?= $this->Form->button('0', ['class' => 'btn btn-default', 'type' => 'button']) ?>
        <?= $this->Form->button('.', ['class' => 'btn btn-default', 'type' => 'button']) ?>
        <?= $this->Form->button('C', ['class' => 'btn btn-danger', 'type' => 'button', 'data-method' => 'reset']) ?>
    </div>
</div>
</div>