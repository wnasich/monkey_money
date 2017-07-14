<ul class="nav navbar-nav">
	<?php if ($currentUser->isAdmin()) { ?>
		<li><?php echo $this->Html->link(
			 $this->Html->tag('span', '', ['class' => 'glyphicon glyphicon-time']) .
			 ' ' . __('Closings'),
			['controller' => 'Closings', 'action' => 'index'],
			['escape' => false]
		); ?></li>
		<li><?php echo $this->Html->link(
			 $this->Html->tag('span', '', ['class' => 'glyphicon glyphicon-th-list']) .
			 ' ' . __('Movements'),
			['controller' => 'Movements', 'action' => 'index'],
			['escape' => false]
		); ?></li>
		<li><?php echo $this->Html->link(
			 $this->Html->tag('span', '', ['class' => 'glyphicon glyphicon-user']) .
			 ' ' . __('Users'),
			['controller' => 'Users', 'action' => 'index'],
			['escape' => false]
		); ?></li>
		<li><?php echo $this->Html->link(
			 $this->Html->tag('span', '', ['class' => 'glyphicon glyphicon-list-alt']) .
			 ' ' . __('Movement types'),
			['controller' => 'MovementTypes', 'action' => 'index'],
			['escape' => false]
		); ?></li>
	<?php } ?>
</ul>
