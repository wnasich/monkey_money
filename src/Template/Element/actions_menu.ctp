<?php foreach ($actions as $action) { ?>
	<?php if (empty($action['divider'])) { ?>
		<?php if (empty($action['disabled'])) { ?>
			<?php echo $this->element('action_item', $action);?>
		<?php } else { ?>
			<?php $action['url'] = 'javascript:void(0);'; ?>
				<?php echo $this->element('action_item', $action);?>
		<?php } ?>
	<?php } else { ?>
		<br />
	<?php } ?>
<?php } ?>
