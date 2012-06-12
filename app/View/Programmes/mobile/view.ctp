<div class="related">
	<h3>Semester</h3>
	<ul data-inset='true' data-role='listview'>
	<?php
		foreach ($semesters as $semester=>$subjects):
	?>
		<li>
			<?php echo __('%sth semester', $semester);?>
			<ul>
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
		</li>
	<?php
		endforeach;
	?>
</div>

<div class="related">
	<h3><?php echo __('Subjects');?></h3>
	<?php if (!empty($programme['Subject'])):?>
	<ul data-inset='true' data-role='listview' data-filter='true'>
	<?php
		foreach ($programme['Subject'] as $subject): ?>
		<li>
			<span class='ui-li-count'><?php echo count($subject['Exam']);?></span>
			<?php echo $this->Html->link($subject['name'], array('controller' => 'subjects', 'action' => 'view', $subject['id'])); ?>
		</li>
	<?php endforeach; ?>
	</ul>
<?php endif; ?>
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
