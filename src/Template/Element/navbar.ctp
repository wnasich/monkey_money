<nav class="navbar navbar-default">
	<div class="container-fluid">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#main-navbar-collapse">
				<span class="sr-only"><?= __('Toggle navigation'); ?></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<?php echo $this->Html->link(
				$this->Html->image('logo_app.png') . $cashierName,
				'/',
				['class' => 'navbar-brand',	'escape' => false]
			); ?>
		</div>

		<div class="collapse navbar-collapse" id="main-navbar-collapse">
			<?php if (!empty($currentUser)) {
				echo $this->element('main_menu');
			} ?>
			<?php echo $this->element('profile_menu'); ?>
		</div>
	</div>
</nav>
