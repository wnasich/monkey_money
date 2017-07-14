<ul class="nav navbar-nav navbar-right user-nav">
<?php if (!empty($currentUser)) { ?>
	<li><?php echo $this->Html->link(
		__('Logout'),
		['controller' => 'users', 'action' => 'logout'],
		['class' => 'btn btn-sm', 'role' => 'button']
	); ?></li>
<?php } ?>
</ul>
<?php if (!empty($currentUser)) { ?>
	<p class="navbar-text navbar-right h4"><span class="label label-default"><?= h($currentUser->name); ?></span></p>
<?php } ?>