<?php
$class = 'message';
if (!empty($params['class'])) {
    $class .= ' ' . $params['class'];
}
?>
<?= $this->Html->alert(h($message), 'default', ['class' => $class]) ?>