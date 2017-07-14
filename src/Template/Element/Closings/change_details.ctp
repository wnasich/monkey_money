<?php
$billsDef = getBillsDefinitions();
$bills = $billsDef['bills'] + $billsDef['packages'];
?>
<?php if ($closing && $closing->change_bills) { ?>
	<table class="table table-condensed table-bordered">
	<?php foreach ($closing->change_bills as $billCode => $billCount) { ?>
	    <?php if (!$billCount) {
	        continue;
	    } ?>
	    <tr>
	        <td class="text-right"><span class="h3"><?= $billCount ?></span></td>
	        <td><span class="label label-default"><?= $bills[$billCode]['name'] ?></span></td>
	        <td><span><?= $this->Html->image('closing_bills/' . $bills[$billCode]['image'], ['class' => 'closing-bill']) ?></span></td>
	    </tr>
	<?php } ?>
	</table>
<?php } else { ?>
    <div class="well well-sm text-center"><?= __('Without changing') ?></div>
<?php } ?>