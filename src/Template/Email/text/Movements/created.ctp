
<?= __('Created') ?>: <?= $this->Time->format($movement->created) ?>

<?= __('Amount') ?>: <?= $this->Number->currency($movement->amount) ?>

<?= __('Movement type') ?>: <?= $movementType->name ?>

<?= __('Output?') ?>: <?= $movementType->outputName() ?>

<?= __('Operator') ?>: <?= $operator ? $operator->name : '' ?>

