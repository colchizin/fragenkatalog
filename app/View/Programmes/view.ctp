<div class="related">
	<h3>Semester</h3>
	<?php
		foreach ($semesters as $semester=>$subjects):
	?>
		<h4><?php echo __('%sth semester', $semester);?></h4>
		<ul data-role='listview'>
			<?php
				foreach($subjects as $subject):
			?>
					<li>
						<span class='ui-li-count'><?php echo $subject['Subject']['exam_count'];?></span>
						<?php echo $this->Html->link($subject['Subject']['name'], array(
							'controller'=>'subjects',
							'action'=>'view',
							$subject['Subject']['id']));
						?>
					</li>
			<?php
				endforeach;
			?>
		</ul>
	<?php
		endforeach;
	?>
</div>

<div class="programmes view">
	<dl>
		<dt><?php echo __('Name'); ?></dt>
		<dd>
			<?php echo h($programme['Programme']['name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Description'); ?></dt>
		<dd>
			<?php echo h($programme['Programme']['description']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('University'); ?></dt>
		<dd>
			<?php echo $this->Html->link(
				$programme['University']['name'],
				array(
					'controller' => 'universities',
					'action' => 'view',
					$programme['University']['id']
				),
				array(
					'data-role'=>'button'
				)
			); ?>
			&nbsp;
		</dd>
	</dl>
</div>


<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul data-role='listview' data-inset='true' data-theme='b'>
		<li><?php echo $this->Html->link(__('Edit Programme'), array('action' => 'edit', $programme['Programme']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Universities'), array('controller' => 'universities', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Subject'), array('controller' => 'subjects', 'action' => 'add')); ?> </li>
	</ul>
</div>
<?php if (isset($ask_programme) && $ask_programme == true): ?>
	<script language='javascript'>
		$(document).ready(function() {
			var res = confirm(
					'<?php echo __('Set Programme %s as your default?', $programme['Programme']['name']);?>'
			);
			if (res) {
				location.href = '<?php echo $this->Html->url(
					array(
						'controller'=>'users',
						'action'=>'setProgramme',
						$programme['Programme']['id']
					)
				);?>';
			}
		});
	</script>
<?php endif;?>
