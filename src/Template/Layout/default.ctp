<!DOCTYPE html>
<html>
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?= $cashierName ?>:
        <?= $this->fetch('title') ?>
    </title>
    <?= $this->Html->meta('icon') ?>

    <?= $this->Html->css([
        'bootstrap_flatly.min.css',
        'awesome-bootstrap-checkbox.css',
        'font-awesome.min.css',
        'global.css',
    ]) ?>
    <?= $this->Html->script([
        'jquery-2.2.4.min.js',
        'bootstrap.min.js'
    ]) ?>

    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <?= $this->fetch('script') ?>
</head>
<body>
    <div class="container-fluid clearfix">
        <?= $this->element('navbar') ?>
        <?= $this->Flash->render('auth') ?>
        <?= $this->Flash->render() ?>
        <?= $this->fetch('content') ?>
    </div>
    <footer>
    </footer>
</body>
</html>
